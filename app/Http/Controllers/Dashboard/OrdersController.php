<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Entry;
use App\Models\Order;
use App\Models\ProductCombination;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\VendorOrder;
use App\Models\Warehouse;
use Carbon\Carbon;
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

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }


        $orders = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->where('order_from', 'web')
            ->where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
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


            if ($order->payment_method == 'cash_on_delivery') {
                $cash_account = Account::findOrFail(settingAccount('cash_account', $branch_id));
            } elseif ($order->payment_method == 'card') {
                $cash_account = Account::findOrFail(settingAccount('card_account', $branch_id));
            }

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


            if ($order->payment_method == 'cash_on_delivery') {
                $cash_account = Account::findOrFail(settingAccount('cash_account', $branch_id));
            } elseif ($order->payment_method == 'paymob' || $order->payment_method == 'upayment') {
                $cash_account = Account::findOrFail(settingAccount('card_account', $branch_id));
            }
            createEntry($customer_account, 'sales', $order->total_price, 0, $branch_id, $order);

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
}
