<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Entry;
use App\Models\Order;
use App\Models\ProductCombination;
use App\Models\ShippingCompany;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:orders-read')->only('index', 'show');
        $this->middleware('permission:orders-create')->only('create', 'store');
        $this->middleware('permission:orders-update')->only('edit', 'update');
        $this->middleware('permission:orders-delete|orders-trash')->only('destroy', 'trashed');
        $this->middleware('permission:orders-restore')->only('restore');
    }

    public function index(Request $request)
    {
        $countries = Country::all();
        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }


        $user = Auth::user();
        $branches = getUserBranches($user);


        $orders = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->where('order_from', 'web')
            ->whereIn('branch_id', $branches->pluck('id')->toArray())
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->latest()
            ->paginate(100);

        return view('dashboard.orders.index', compact('orders', 'countries', 'branches'));
    }


    public function show(Order $order)
    {
        return view('dashboard.orders.show')->with('order', $order);
    }


    private function changeStatus($order, $status)
    {

        $order->update([
            'status' => $status,
        ]);



        createOrderHistory($order, $order->status);

        $description_ar = "تم تغيير حالة الطلب الى " . getArabicStatus($order->status) . ' طلب رقم ' . ' #' . $order->id;
        $description_en  = "order status has been changed to " . $order->status . ' order No ' . ' #' . $order->id;

        addLog('admin', 'orders', $description_ar, $description_en);

        if ($order->affiliate_id != null) {
            $title_ar = 'اشعار من الإدارة';
            $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . getArabicStatus($order->status);
            $title_en = 'Notification From Admin';
            $body_en  = "Your order status has been changed to " . $order->status;
            $url = route('orders.affiliate.index');
            addNoty($order->affiliate, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
        }

        if ($status == 'canceled' || $status == 'RTO') {

            foreach ($order->vendor_orders as $vendor_order) {
                changeOutStandingBalance($vendor_order->user, ($vendor_order->total_price - $vendor_order->total_commission), $vendor_order->id, $status, 'sub');
            }

            $branch_id = $order->branch_id;

            $vendors_tax_account = Account::findOrFail(settingAccount('vendors_tax_account', $branch_id));
            $total_vendors_tax_ammount = 0;
            $total_order_vendors_products = 0;



            foreach ($order->products as $product) {

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {


                    $combination = ProductCombination::findOrFail($product->pivot->product_combination_id);


                    if ($product->vendor_id == null) {

                        $warehouse_id = $product->pivot->warehouse_id;

                        $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);
                        $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $branch_id);

                        // get cost and update combination cost
                        $cost = getProductCost($product, $combination, $branch_id, $order, $product->pivot->qty, true);

                        createEntry($product_account, 'sales_return', ($product->pivot->cost * $product->pivot->qty), 0, $branch_id, $order);
                        createEntry($cs_product_account, 'sales_return', 0, ($product->pivot->cost * $product->pivot->qty), $branch_id, $order);
                    }

                    if ($product->vendor_id != null) {

                        $warehouse = Warehouse::where('vendor_id', $product->vendor_id)->first();
                        $warehouse_id = $warehouse->id;
                        $total_vendors_tax_ammount += $vendor_order->total_tax;
                        $total_order_vendors_products += $vendor_order->total_price;

                        // add return entry for commission tax account

                        $supplier_account = getItemAccount($product->vendor_id, null, 'suppliers_account', $branch_id);
                        createEntry($supplier_account, 'sales_return', $vendor_order->total_price - $vendor_order->total_commission, 0, $branch_id, $order);


                        if ($vendor_order->total_commission > 0) {

                            $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);
                            createEntry($revenue_account, 'sales_return', $vendor_order->total_commission - $vendor_order->total_tax, 0, $branch_id, $order);

                            $vendors_tax_account = Account::findOrFail(settingAccount('vendors_tax_account', $branch_id));
                            createEntry($vendors_tax_account, 'sales_return', $vendor_order->total_tax, 0, $branch_id, $order);
                        }
                    }

                    // add stock and running order
                    stockCreate($combination, $warehouse_id, $product->pivot->qty, 'Sale', 'IN', $order->id, $order->custumer_id != null ? $order->custumer_id : null, productPrice($product, $product->pivot->product_combination_id, 'vat'));
                }


                if ($product->vendor_id == null) {
                    if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                        $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);
                    } else {
                        $revenue_account = getItemAccount($product, $product->category, 'revenue_account_services', $branch_id);
                    }
                    createEntry($revenue_account, 'sales_return', $product->pivot->product_price - $product->pivot->product_tax, 0, $branch_id, $order);
                }
            }


            if ($order->customer_id != null) {
                $customer_account = getItemAccount($order->customer_id, null, 'customers_account', $branch_id);
            } else {
                $customer_account = getItemAccount(null, null, 'customers_account', $branch_id);
            }

            createEntry($customer_account, 'sales_return', 0, $order->total_price, $branch_id, $order);

            $order->update([
                'payment_status' => 'faild',
            ]);

            if ($order->total_tax > 0) {
                $vat_account = Account::findOrFail(settingAccount('vat_sales_account', $branch_id));
                createEntry($vat_account, 'sales_return', $order->total_tax, 0, $branch_id, $order);
            }


            if ($order->shipping_amount > 0) {

                $revenue_account_shipping = getItemAccount(null, null, 'revenue_account_shipping', $branch_id);
                createEntry($revenue_account_shipping, 'sales_return', $order->shipping_amount, 0, $branch_id, $order);
            }

            if ($order->discount_amount > 0) {
                $allowed_discount_account = Account::findOrFail(settingAccount('allowed_discount_account', $branch_id));
                createEntry($allowed_discount_account, 'sales_return', 0, $order->discount_amount, $branch_id, $order);
            }

            if ($order->affiliate_id != null) {
                changeOutStandingBalance($order->affiliate, $order->total_commission, $order->id, $order->status, 'sub');
            }
        }

        if ($status == 'returned') {


            $branch_id = $order->branch_id;
            $vendors_tax_account = Account::findOrFail(settingAccount('vendors_tax_account', $branch_id));
            $total_vendors_tax_ammount = 0;
            $total_order_vendors_products = 0;


            foreach ($order->vendor_orders as $vendor_order) {

                if ($vendor_order->status == 'Waiting for the order amount to be released') {
                    changeOutStandingBalance($vendor_order->user, ($vendor_order->total_price - $vendor_order->total_commission), $vendor_order->id, $status, 'sub');
                } else {
                    changeAvailableBalance($vendor_order->user, ($vendor_order->total_price - $vendor_order->total_commission), $vendor_order->id, $status, 'sub');
                }
            }

            foreach ($order->products as $product) {

                $combination = ProductCombination::findOrFail($product->pivot->product_combination_id);

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {


                    if ($product->vendor_id == null) {

                        $warehouse_id = $product->pivot->warehouse_id;

                        $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);
                        $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $branch_id);

                        // get cost and update combination cost
                        $cost = getProductCost($product, $combination, $branch_id, $order, $product->pivot->qty, true);

                        createEntry($product_account, 'sales_return', ($product->pivot->cost * $product->pivot->qty), 0, $branch_id, $order);
                        createEntry($cs_product_account, 'sales_return', 0, ($product->pivot->cost * $product->pivot->qty), $branch_id, $order);
                    }

                    if ($product->vendor_id != null) {

                        $warehouse = Warehouse::where('vendor_id', $product->vendor_id)->first();
                        $warehouse_id = $warehouse->id;
                        $total_vendors_tax_ammount += $vendor_order->total_tax;
                        $total_order_vendors_products += $vendor_order->total_price;

                        // add return entry for commission tax account


                        $supplier_account = getItemAccount($product->vendor_id, null, 'suppliers_account', $branch_id);
                        createEntry($supplier_account, 'sales_return', $vendor_order->total_price - $vendor_order->total_commission, 0, $branch_id, $order);


                        if ($vendor_order->total_commission > 0) {

                            $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);
                            createEntry($revenue_account, 'sales_return', $vendor_order->total_commission - $vendor_order->total_tax, 0, $branch_id, $order);

                            $vendors_tax_account = Account::findOrFail(settingAccount('vendors_tax_account', $branch_id));
                            createEntry($vendors_tax_account, 'sales_return', $vendor_order->total_tax, 0, $branch_id, $order);
                        }
                    }

                    // add stock and running order
                    stockCreate($combination, $warehouse_id, $product->pivot->qty, 'Sale', 'IN', $order->id, $order->custumer_id != null ? $order->custumer_id : null, productPrice($product, $product->pivot->product_combination_id, 'vat'));
                }



                if ($product->vendor_id == null) {
                    if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                        $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);
                    } else {
                        $revenue_account = getItemAccount($product, $product->category, 'revenue_account_services', $branch_id);
                    }

                    createEntry($revenue_account, 'sales_return', $product->pivot->product_price - $product->pivot->product_tax, 0, $branch_id, $order);
                }
            }




            $cash_account = getIntermediaryAssetAccount($order, $branch_id);
            createEntry($cash_account, 'sales_return', 0, $order->total_price, $branch_id, $order);


            if ($order->total_tax > 0) {
                $vat_account = Account::findOrFail(settingAccount('vat_sales_account', $branch_id));
                createEntry($vat_account, 'sales_return', $order->total_tax, 0, $branch_id, $order);
            }


            if ($order->shipping_amount > 0) {

                $revenue_account_shipping = getItemAccount(null, null, 'revenue_account_shipping', $branch_id);
                createEntry($revenue_account_shipping, 'sales_return', $order->shipping_amount, 0, $branch_id, $order);
            }

            if ($order->discount_amount > 0) {
                $allowed_discount_account = Account::findOrFail(settingAccount('allowed_discount_account', $branch_id));
                createEntry($allowed_discount_account, 'sales_return', 0, $order->discount_amount, $branch_id, $order);
            }



            $order->update([
                'payment_status' => 'faild',
            ]);

            // changeAvailableBalance($order->user, $order->total_commission, $order->id, $order->status, 'sub');
        }

        if ($status == 'delivered') {


            $branch_id = $order->branch_id;


            if ($order->customer_id != null) {
                $customer_account = getItemAccount($order->customer_id, null, 'customers_account', $branch_id);
            } else {
                $customer_account = getItemAccount(null, null, 'customers_account', $branch_id);
            }

            createEntry($customer_account, 'sales', 0, $order->total_price, $branch_id, $order);


            $cash_account = getIntermediaryAssetAccount($order, $branch_id);
            createEntry($cash_account, 'sales', $order->total_price, 0, $branch_id, $order);

            $order->update([
                'payment_status' => 'paid',
            ]);

            // $mystock_price = 0;

            // foreach ($order->products as $product) {
            //     if ($product->pivot->product_type != '0') {
            //         $mystock_price += ($product->min_price * $product->pivot->stock);
            //     }
            // }

            // changeOutStandingBalance($order->user, $order->total_commission, $order->id, $order->status, 'sub');
            // changeAvailableBalance($order->user, $order->total_commission, $order->id, $order->status, 'add');
        }

        foreach ($order->vendor_orders as $vendor_order) {

            $vendor_order->update([
                'status' => $status == 'delivered' ? 'Waiting for the order amount to be released' : $status,
            ]);

            $title_ar = 'اشعار من الإدارة';
            $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . getArabicStatus($vendor_order->status);
            $title_en = 'Notification From Admin';
            $body_en  = "Your order status has been changed to " . $vendor_order->status;
            $url = route('vendor.orders.index');
            addNoty($vendor_order->user, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
        }
    }


    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => "required|string",
        ]);

        if (!checkOrderStatus($request->status, $order->status)) {
            alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
            return redirect()->route('orders.index');
        } else {
            $this->changeStatus($order, $request->status);
        }

        alertSuccess('Order status updated successfully', 'تم تحديث حالة الطلب بنجاح');
        return redirect()->route('orders.index');
    }

    public function updateStatusBulk(Request $request)
    {
        $request->validate([
            'selected_status' => "required|string|max:255",
            'selected_items' => "required|array",
        ]);

        foreach ($request->selected_items as $order) {
            $order = Order::findOrFail($order);
            if (!checkOrderStatus($request->selected_status, $order->status)) {
                alertError('The status of some orders cannot be changed', 'لا يمكن تغيير حالة بعض الطلبات');
            } else {
                $this->changeStatus($order, $request->selected_status);
                alertSuccess('Orders Status updated successfully', 'تم تحديث حالة الطلب بنجاح');
            }
        }
        return redirect()->route('orders.index');
    }

    public function rejectRefund(Request $request, Order $order)
    {
        $request->validate([
            'reason' => "required|string",
        ]);
        $refund = $order->refund;
        $refund->update([
            'status' => 1,
            'refuse_reason' => $request->reason
        ]);
        $title_ar = 'اشعار من الإدارة';
        $body_ar = "تم رفض طلب المرتجع الخاص بطلبك رقم " . $order->id . ' سبب الرفض : ' . $request->reason;
        $title_en = 'Notification From Admin';
        $body_en  = "Your return request has been rejected for order ID: "  . $order->id . ' the reason of refuse : ' . $request->reason;
        $url = route('orders.affiliate.index');
        addNoty($order->user, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);

        alertSuccess('The refund request was successfully rejected', 'تم رفض طلب المرتجع بنجاح');
        return redirect()->route('orders.index');
    }

    public function refundsIndex(Request $request)
    {

        $countries = Country::all();
        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $orders = Order::has('refund')
            ->whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            // ->where('status', '!=', 'returned')
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        return view('dashboard.orders.index')->with('orders', $orders)->with('countries', $countries);
    }



    public function mandatoryIndex(Request $request)
    {
        $countries = Country::all();
        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }
        $orders = Order::where('status', 'in the mandatory period')
            ->where('updated_at', '<', now()->subMinutes(setting('mandatory_affiliate')))
            ->whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        return view('dashboard.orders.index')->with('orders', $orders)->with('countries', $countries);
    }


    public function indexVendors(Request $request)
    {
        $countries = Country::all();
        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }
        $orders = VendorOrder::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        return view('dashboard.orders.vendor-orders')->with('orders', $orders)->with('countries', $countries);
    }

    public function mandatoryIndexVendor(Request $request)
    {
        $countries = Country::all();
        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }
        $orders = VendorOrder::where('status', 'Waiting for the order amount to be released')
            ->where('updated_at', '<', now()->subMinutes(setting('mandatory_vendor')))
            ->whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);
        return view('dashboard.orders.vendor-orders')->with('orders', $orders)->with('countries', $countries);
    }



    public function updateStatusVendor(Request $request, VendorOrder $vendor_order)
    {
        $request->validate([
            'status' => "required|string|max:255",
        ]);

        if ($request->status == 'delivered' && $vendor_order->status == 'Waiting for the order amount to be released') {
            $this->changeStatusVendor($vendor_order, $request->status);
            alertSuccess('Order status updated successfully', 'تم تحديث حالة الطلب بنجاح');
        } else {
            alertSuccess('Order status cannot be updated', 'لا يمكن تحديث حالة الطلب');
        }
        return redirect()->route('orders-vendor');
    }

    public function updateStatusVendorBulk(Request $request)
    {
        $request->validate([
            'selected_status' => "required|string|max:255",
            'selected_items' => "required|array",
        ]);

        foreach ($request->selected_items as $vendor_order) {
            $vendor_order = VendorOrder::findOrFail($vendor_order);
            if ($request->selected_status == 'delivered' && $vendor_order->status == 'Waiting for the order amount to be released') {
                $this->changeStatusVendor($vendor_order, $request->selected_status);
                alertSuccess('Orders status updated successfully', 'تم تحديث حالة الطلبات بنجاح');
            } else {
                alertError('The status of some orders cannot be changed', 'لا يمكن تغيير حالة بعض الطلبات');
            }
        }
        return redirect()->route('orders-vendor');
    }

    private function changeStatusVendor($vendor_order, $status)
    {

        $vendor_order->update([
            'status' => $status,
        ]);

        $title_ar = 'اشعار من الإدارة';
        $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . getArabicStatus($vendor_order->status);
        $title_en = 'Notification From Admin';
        $body_en  = "Your order status has been changed to " . $vendor_order->status;
        $url = route('vendor.orders.index');

        addNoty($vendor_order->user, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);

        changeOutStandingBalance($vendor_order->user, ($vendor_order->total_price - $vendor_order->total_commission), $vendor_order->id, $vendor_order->status, 'sub');
        changeAvailableBalance($vendor_order->user, ($vendor_order->total_price - $vendor_order->total_commission), $vendor_order->id, $vendor_order->status, 'add');
    }



    public function ordersStore(Request $request, $order_from, $returned)
    {



        $request->validate([
            'selected_combinations' => "required|array",
            'warehouse_id' => "required|integer",
            'user_id' => "required|integer",
            'notes' => "nullable|string",
            'taxes' => "nullable|array",
            'qty' => "nullable|array",
            'price' => "nullable|array",
            'discount' => "nullable|numeric|gte:0",
            'returned' => "nullable|boolean",
            'order_id' => "nullable|integer",
            'order_type' => "required|string",
            'expected_delivery' => "required|string",
            'shipping' => "nullable|numeric|gte:0",

        ]);



        $selected_order = isset($request->selected_order) ? $request->selected_order : null;

        $branch_id = getUserBranchId(Auth::user());
        $returned = $returned == 'false' ? false : true;
        $warehouse = Warehouse::findOrFail($request->warehouse_id);
        $branch = Branch::findOrFail($branch_id);
        $user = User::findOrFail($request->user_id);


        if ($branch->warehouses->where('id', $warehouse->id)->count() != 1) {
            alertError('Error happen please review inputs options and try again', 'حدث خطا يرجى مراجعة البيانات والمحاولة مرة اخرى');
            return redirect()->back()->withInput();
        }

        if (!checkOrderAccounts($order_from, $branch_id)) {
            alertError('Please set the default accounts settings from the settings page', 'يرجى ضبط اعدادات الحسابات الافتراضية من صفحة الاعدادات');
            return redirect()->back()->withInput();
        }

        foreach ($request->selected_combinations as $index => $combination_id) {
            if ($request->qty[$index] <= 0 || $request->price[$index] <= 0) {
                alertError('Please add quantity or purchase price to complete the order', 'يرجى ادخال الكميات واسعار الشراء لاستكمال الطلب');
                return redirect()->back()->withInput();
            }
        }

        if (isset($request->tax) && (in_array('wht', $request->tax) && !in_array('vat', $request->tax))) {
            alertError('Error happen please review taxes options and try again', 'حدث حطا اثناء معالجة قيمة الضريبة يرجى مراجعة البيانات والمحاولة مرة اخرى');
            return redirect()->back()->withInput();
        }

        if (($order_from == 'addpurchase' && $returned == true) || ($order_from == 'addsale' && $returned == false)) {
            if (!checkProductsForOrder(null, $request->selected_combinations, $request->qty,  $request->warehouse_id)) {
                alertError('Some products do not have enough quantity in stock or the product not active', 'بعض المنتجات ليس بها كمية كافية في المخزون او المنتج غير مفعل');
                return redirect()->back()->withInput();
            }
        }

        if (isset($request->order_id)) {

            $ref_order = Order::findOrFail($request->order_id);

            if ($ref_order->order_from != 'addsale' && $ref_order->order_from != 'web') {
                alertError('reference order number is not correct', 'رقم الطلب المرجعي غير صحيح');
                return redirect()->back()->withInput();
            }

            if ($ref_order->customer_id != $request->user_id) {
                alertError('The specified customer does not match', 'العميل المحدد غير متطابق');
                return redirect()->back()->withInput();
            }

            if ($ref_order->status == 'returned' || $ref_order->status == 'RTO' || $ref_order->status == 'canceled') {
                alertError('The status of the specified order is not suitable', 'حالة الطلب المحدد غير مناسبة');
                return redirect()->back()->withInput();
            }
        } else {
            $ref_order = null;
        }

        // check if cart empty
        //  if (count($request->prods) <= 0) {
        //     alertError('Your cart is empty. You cannot complete your order at this time', 'سلة مشترياتك فارغة لا يمكنك من اتمام الطلب في الوقت الحالي');
        //     return redirect()->back()->withInput();
        // }



        if ($selected_order) {
            $order = Order::findOrFail($selected_order);
            $order->update([
                'customer_id' => $user->id,
                'warehouse_id' => $request->warehouse_id,
                'order_from' => $order_from,
                'full_name' => $user->name,
                'phone' => $user->phone,
                'country_id' => $user->country_id,
                'notes' => $request->notes,
                'branch_id' => $branch_id,
                'order_type' => $request->order_type,
                'status' => $returned == true ? 'returned' : 'pending',
                'serial' => getLastOrderSerial($request->order_type),
                'expected_delivery' => $request->expected_delivery,
            ]);
        } else {
            $order = Order::create([
                'customer_id' => $user->id,
                'warehouse_id' => $request->warehouse_id,
                'order_from' => $order_from,
                'full_name' => $user->name,
                'phone' => $user->phone,
                'country_id' => $user->country_id,
                'notes' => $request->notes,
                'branch_id' => $branch_id,
                'order_type' => $request->order_type,
                'status' => $returned == true ? 'returned' : 'pending',
                'serial' => getLastOrderSerial($request->order_type),
                'expected_delivery' => $request->expected_delivery,

            ]);
        }



        if (!isset($request->discount)) {
            $discount = 0;
            $discountForItem = 0;
        } elseif ($request->discount < 0) {
            $discount = 0;
            $discountForItem = 0;
        } else {
            $discount = $request->discount;
            $discountForItem = $discount / count($request->qty);
        }

        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $sub = 0;

        $wht_services_amount = 0;
        $wht_products_amount = 0;

        $stocks_limit_products = [];

        $taxes_data = [];


        foreach ($request->qty as $index => $q) {
            $sub = $sub + ($q * $request->price[$index]);
        }

        $sub = $sub - $discount;


        if ($selected_order) {
            $order->products()->detach();
        }

        foreach ($request->selected_combinations as $index => $combination_id) {

            try {

                //we will not use combination if product type is service or digital
                $combination = ProductCombination::find($request->selected_combinations[$index]);
                $product = $combination->product;



                if ($request->order_type == 'SO' || $request->order_type == 'PO') {
                    if ($order_from == 'addpurchase') {
                        // calculate product cost in purchase
                        $cost = updateCost($combination, $request->price[$index], $request->qty[$index], $returned == false ? 'add' : 'sub', $branch_id);
                    } elseif ($order_from == 'addsale') {
                        // get cost of goods sold and update it in simple and variable products
                        $cost = getProductCost($product, $combination, $branch_id, $ref_order, $request->qty[$index], $returned);
                    }
                } else {
                    $cost = 0;
                }





                $product_price = ($request->qty[$index] * $request->price[$index]) - $discountForItem;



                // $vat_amount_product = calcTaxIfExist($product_price, 'vat', $request->tax, $sub);
                // $product_price_with_vat = $product_price + $vat_amount_product;
                // $vat_amount += $vat_amount_product;


                // foreach ($request->taxes as $index => $tax) {
                //     $tax_data = calcTaxByID($product_price, $tax);
                //     $taxes_data[$index] = $tax_data;
                //     $total += $tax_data['tax_amount'];
                // }


                $subtotal += $product_price;

                // if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                //     $wht_amount_product = calcTaxIfExist($product_price, 'wht_products', $request->tax, $sub);
                //     $wht_products_amount += $wht_amount_product;
                // } else {
                //     $wht_amount_product = calcTaxIfExist($product_price, 'wht_services', $request->tax, $sub);
                //     $wht_services_amount += $wht_amount_product;
                // }




                $order->products()->attach(
                    $product->id,
                    [
                        'warehouse_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->warehouse_id : null,
                        'product_combination_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->selected_combinations[$index] : null,
                        'product_price' => $request->price[$index],
                        // 'product_tax' => (isset($request->tax) && in_array('vat', $request->tax)) ? $vat_amount_product : 0,
                        // 'product_wht' => (isset($request->tax) && in_array('wht', $request->tax) && $sub > setting('wht_invoice_amount')) ? $wht_amount_product : 0,
                        'qty' => $request->qty[$index],
                        'total' => $request->price[$index] * $request->qty[$index],
                        'product_type' => $product->product_type,
                        'cost' => $cost,
                    ]
                );




                $order->update([
                    'total_price' => $subtotal,
                    'subtotal_price' => $subtotal,
                    // 'total_tax' => $vat_amount,
                    // 'total_wht_products' => $wht_products_amount,
                    // 'total_wht_services' => $wht_services_amount,
                ]);


                if ($request->order_type == 'SO' || $request->order_type == 'PO') {

                    // add stock update and antries
                    if ($product->product_type == 'variable' || $product->product_type == 'simple') {

                        if ($order_from == 'addpurchase') {
                            // add stock and running order
                            stockCreate($combination, $request->warehouse_id, $request->qty[$index], 'Purchase', $returned == true ? 'OUT' : 'IN', $order->id, $user->id, $request->price[$index]);
                        } elseif ($order_from == 'addsale') {
                            // add stock and running order
                            stockCreate($combination, $request->warehouse_id, $request->qty[$index], 'Sale', $returned == true ? 'IN' : 'OUT', $order->id, $user->id, $request->price[$index]);
                        }


                        if ($order_from == 'addsale') {
                            // add noty for stock limit
                            if (productQuantity($product->id, $request->selected_combinations[$index], $request->warehouse_id) <= $combination->limit) {
                                array_push($stocks_limit_products, $product);
                            }
                        }

                        $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);

                        if ($order_from == 'addpurchase') {
                            createEntry($product_account, $returned == true ? 'purchase_return' : 'purchase', $returned == true ? 0 : ($request->price[$index] * $request->qty[$index]), $returned == true ? ($request->price[$index] * $request->qty[$index]) : 0, $branch_id, $order);
                        } elseif ($order_from == 'addsale') {
                            createEntry($product_account, $returned == true ? 'sales_return' : 'sales', $returned == true ? ($cost * $request->qty[$index]) :  0, $returned == true ? 0 : ($cost * $request->qty[$index]), $branch_id, $order);
                        }


                        if ($order_from == 'addsale') {
                            $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $branch_id);
                            createEntry($cs_product_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? 0 : ($cost * $request->qty[$index]), $returned == true ? ($cost * $request->qty[$index]) : 0, $branch_id, $order);
                            $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);
                        }
                    } else {

                        if ($order_from == 'addsale') {
                            $revenue_account = getItemAccount($product, $product->category, 'revenue_account_services', $branch_id);
                        }
                    }

                    if ($order_from == 'addsale') {
                        createEntry($revenue_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? ($request->price[$index] * $request->qty[$index]) : 0, $returned == true ? 0 : ($request->price[$index] * $request->qty[$index]), $branch_id, $order);
                    }
                }
            } catch (Exception $e) {
            }
        }


        if ($discount > 0) {
            $order->update([
                'discount_amount' => $discount,
            ]);
        }

        // $wht_amount = $wht_services_amount + $wht_products_amount;

        $total = $order->total_price;


        if ($selected_order) {
            $order->taxes()->detach();
        }

        foreach ($request->taxes as $index => $tax) {




            $tax_data = calcTaxByID($order->total_price, $tax);
            $taxes_data[$index] = $tax_data;
            $total += $tax_data['tax_amount'];

            if ($tax_data['tax_amount'] > 0) {
                $vat_amount += $tax_data['tax_amount'];
            } else {
                $wht_amount += abs($tax_data['tax_amount']);
            }



            $order->taxes()->attach($tax, ['amount' => $tax_data['tax_amount']]);


            // $order->update([
            //     'total_tax' => $vat_amount,
            // ]);

        }


        $order->update([
            'total_price' => $total,
            'shipping_amount' => isset($request->shipping) ? $request->shipping : 0,
        ]);


        // if (isset($request->tax) && in_array('vat', $request->tax)) {
        //     $vat = Tax::findOrFail(setting('vat'));
        //     $order->taxes()->attach($vat->id, ['amount' => $vat_amount]);
        //     $order->update([
        //         'total_tax' => $vat_amount,
        //     ]);
        // }

        // if (isset($request->tax) && in_array('wht', $request->tax) && $subtotal > setting('wht_invoice_amount')) {
        //     if ($wht_products_amount > 0) {
        //         $wht = Tax::findOrFail(setting('wht_products'));
        //         $order->taxes()->attach($wht->id, ['amount' => $wht_products_amount]);
        //         $order->update([
        //             'total_wht_products' => $wht_products_amount,
        //         ]);
        //     }
        //     if ($wht_services_amount > 0) {
        //         $wht = Tax::findOrFail(setting('wht_services'));
        //         $order->taxes()->attach($wht->id, ['amount' => $wht_services_amount]);
        //         $order->update([
        //             'total_wht_services' => $wht_services_amount,
        //         ]);
        //     }
        // }


        if ($request->order_type == 'SO' || $request->order_type == 'PO') {


            if (isset($request->shipping) && $request->shipping > 0) {
                $shipping_account = Account::findOrFail(settingAccount(getAccountNameForOrder($order_from, 'shipping'), $branch_id));
                createEntry($shipping_account, getTypeForOrder($order_from, $returned), getAmountForOrder($returned, $request->shipping, $order_from, 'shipping', 'dr'), getAmountForOrder($returned, $request->shipping, $order_from, 'shipping', 'cr'), $branch_id, $order);
            }

            if ($discount > 0) {
                $discount_account = Account::findOrFail(settingAccount(getAccountNameForOrder($order_from, 'discount'), $branch_id));
                createEntry($discount_account, getTypeForOrder($order_from, $returned), getAmountForOrder($returned, $discount, $order_from, 'discount', 'dr'), getAmountForOrder($returned, $discount, $order_from, 'discount', 'cr'), $branch_id, $order);
            }

            if ($vat_amount > 0) {
                $vat_account = Account::findOrFail(settingAccount(getAccountNameForOrder($order_from, 'vat'), $branch_id));
                createEntry($vat_account, getTypeForOrder($order_from, $returned), getAmountForOrder($returned, $vat_amount, $order_from, 'vat', 'dr'), getAmountForOrder($returned, $vat_amount, $order_from, 'vat', 'cr'), $branch_id, $order);
            }


            if ($wht_amount > 0) {
                $wht_account = Account::findOrFail(settingAccount(getAccountNameForOrder($order_from, 'wht'), $branch_id));
                createEntry($wht_account, getTypeForOrder($order_from, $returned), getAmountForOrder($returned, $wht_amount, $order_from, 'wht', 'dr'), getAmountForOrder($returned, $wht_amount, $order_from, 'wht', 'cr'), $branch_id, $order);
            }


            $user_account = getItemAccount($user->id, null, getAccountNameForOrder($order_from, 'user'), $branch_id);
            createEntry($user_account, getTypeForOrder($order_from, $returned), getAmountForOrder($returned, ($order->total_price + $order->shipping_amount), $order_from, 'user', 'dr'), getAmountForOrder($returned, ($order->total_price + $order->shipping_amount), $order_from, 'user', 'cr'), $branch_id, $order);


            if ($returned == false && $order_from == 'addsale') {




                $admins = unserialize(setting('stock_notifications'));

                $users = User::whereHas('roles', function ($query) use ($admins) {
                    $query->whereIn('name', $admins ? $admins : []);
                })->get();

                // send noti to admins about new order and stock limit
                foreach ($users as $admin) {
                    foreach ($stocks_limit_products as $product) {
                        $title_ar = 'تنبيه بنقص المخزون';
                        $body_ar = 'تجاوز هذا المنتج الحد المسموح في المخزون :#' . $product->name_ar;
                        $title_en = 'stock limit alert';
                        $body_en  = 'this product over the stock limit :#' . $product->name_en;
                        $url = route('stock.management.index', ['search' => $product->id]);
                        addNoty($admin, $user, $url, $title_en, $title_ar, $body_en, $body_ar);
                    }
                }
            }
        }


        alertSuccess('order created successfully', 'تم إضافة الطلب بنجاح');

        if ($order_from == 'addpurchase') {
            return redirect()->route('purchases.index');
        } elseif ($order_from == 'addsale') {
            return redirect()->route('sales.index');
        }
    }
}
