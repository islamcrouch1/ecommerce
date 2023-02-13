<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Country;
use App\Models\Entry;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\VendorOrder;
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

        $orders = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whereNot(function ($query) {
                $query->where('order_from',  'addpurchase');
            })
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->latest()
            ->paginate(100);

        return view('dashboard.orders.index')->with('orders', $orders)->with('countries', $countries);
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

        $title_ar = 'اشعار من الإدارة';
        $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . getArabicStatus($order->status);
        $title_en = 'Notification From Admin';
        $body_en  = "Your order status has been changed to " . $order->status;
        $url = route('orders.affiliate.index');

        if ($order->customer_id != null) {
            addNoty($order->customer, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
        }

        if ($status == 'canceled' || $status == 'RTO') {

            // foreach ($order->vendor_orders as $vendor_order) {
            //     changeOutStandingBalance($vendor_order->user, $vendor_order->total_price, $vendor_order->id, $status, 'sub');
            // }

            foreach ($order->products as $product) {

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {

                    Stock::create([
                        'product_combination_id' => $product->pivot->product_combination_id,
                        'product_id' => $product->id,
                        'warehouse_id' => setting('warehouse_id'),
                        'qty' => $product->pivot->qty,
                        'stock_status' => 'IN',
                        'stock_type' => 'Order',
                        'reference_id' => $order->id,
                        'reference_price' => productPrice($product, $product->pivot->product_combination_id),
                        'created_by' => Auth::check() ? Auth::id() : null,
                    ]);
                }
            }

            $vat = Tax::findOrFail(setting('vat'));
            if ($vat != null && $vat->tax_rate != null) {
                $subtotal = (100 / ($vat->tax_rate + 100)) * $order->subtotal_price;
                $vat_amount = $order->subtotal_price - $subtotal;
            } else {
                $vat_amount = 0;
            }

            if ($order->customer_id != null) {
                $customer_account = Account::where('reference_id', $order->customer_id)->where('type', 'customer')->first();
            } else {
                $customer_account = Account::findOrFail(setting('account_receivable_account'));
            }
            Entry::create([
                'account_id' => $customer_account->id,
                'type' => 'sales',
                'dr_amount' => 0,
                'cr_amount' =>  $order->subtotal_price,
                'description' => 'sales order# ' . $order->id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);

            $order->update([
                'payment_status' => 'Faild',
            ]);

            $vat_account = Account::findOrFail(setting('vat_sales_account'));

            Entry::create([
                'account_id' => $vat_account->id,
                'type' => 'sales',
                'dr_amount' => $vat_amount,
                'cr_amount' =>  0,
                'description' => 'sales order# ' . $order->id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);

            $revenue_account = Account::findOrFail(setting('revenue_account'));

            Entry::create([
                'account_id' => $revenue_account->id,
                'type' => 'sales',
                'dr_amount' => $order->subtotal_price - $vat_amount,
                'cr_amount' =>  0,
                'description' => 'sales order# ' . $order->id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);

            // changeOutStandingBalance($order->user, $order->total_commission, $order->id, $order->status, 'sub');
        }

        if ($status == 'returned') {
            // foreach ($order->vendor_orders as $vendor_order) {
            //     if ($vendor_order->status == 'Waiting for the order amount to be released') {
            //         changeOutStandingBalance($vendor_order->user, $vendor_order->total_price, $vendor_order->id, $status, 'sub');
            //     } else {
            //         changeAvailableBalance($vendor_order->user, $vendor_order->total_price, $vendor_order->id, $status, 'sub');
            //     }
            // }

            foreach ($order->products as $product) {

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {

                    Stock::create([
                        'product_combination_id' => $product->pivot->product_combination_id,
                        'product_id' => $product->id,
                        'warehouse_id' => setting('warehouse_id'),
                        'qty' => $product->pivot->qty,
                        'stock_status' => 'IN',
                        'stock_type' => 'Order',
                        'reference_id' => $order->id,
                        'reference_price' => productPrice($product, $product->pivot->product_combination_id),
                        'created_by' => Auth::check() ? Auth::id() : null,
                    ]);
                }
            }


            $vat = Tax::findOrFail(setting('vat'));
            if ($vat != null && $vat->tax_rate != null) {
                $subtotal = (100 / ($vat->tax_rate + 100)) * $order->subtotal_price;
                $vat_amount = $order->subtotal_price - $subtotal;
            } else {
                $vat_amount = 0;
            }

            if ($order->payment_method == 'cash_on_delivery') {
                $cash_account = Account::findOrFail(setting('cash_account'));
            } elseif ($order->payment_method == 'card') {
                $cash_account = Account::findOrFail(setting('card_account'));
            }

            Entry::create([
                'account_id' => $cash_account->id,
                'type' => 'sales',
                'dr_amount' => 0,
                'cr_amount' =>  $order->subtotal_price,
                'description' => 'sales order# ' . $order->id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);

            $vat_account = Account::findOrFail(setting('vat_sales_account'));

            Entry::create([
                'account_id' => $vat_account->id,
                'type' => 'sales',
                'dr_amount' => $vat_amount,
                'cr_amount' =>  0,
                'description' => 'sales order# ' . $order->id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);

            $revenue_account = Account::findOrFail(setting('revenue_account'));

            Entry::create([
                'account_id' => $revenue_account->id,
                'type' => 'sales',
                'dr_amount' => $order->subtotal_price - $vat_amount,
                'cr_amount' =>  0,
                'description' => 'sales order# ' . $order->id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);



            $order->update([
                'payment_status' => 'Faild',
            ]);

            // changeAvailableBalance($order->user, $order->total_commission, $order->id, $order->status, 'sub');
        }

        if ($status == 'delivered') {

            if ($order->customer_id != null) {
                $customer_account = Account::where('reference_id', $order->customer_id)->where('type', 'customer')->first();
            } else {
                $customer_account = Account::findOrFail(setting('account_receivable_account'));
            }
            Entry::create([
                'account_id' => $customer_account->id,
                'type' => 'sales',
                'dr_amount' => 0,
                'cr_amount' =>  $order->subtotal_price,
                'description' => 'sales order# ' . $order->id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);

            $cash_account = Account::findOrFail(setting('cash_account'));
            Entry::create([
                'account_id' => $cash_account->id,
                'type' => 'sales',
                'dr_amount' => $order->subtotal_price,
                'cr_amount' =>  0,
                'description' => 'sales order# ' . $order->id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);


            $order->update([
                'payment_status' => 'Paid',
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

        // foreach ($order->vendor_orders as $vendor_order) {

        //     $vendor_order->update([
        //         'status' => $status == 'delivered' ? 'Waiting for the order amount to be released' : $status,
        //     ]);

        //     $title_ar = 'اشعار من الإدارة';
        //     $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . getArabicStatus($vendor_order->status);
        //     $title_en = 'Notification From Admin';
        //     $body_en  = "Your order status has been changed to " . $vendor_order->status;
        //     $url = route('vendor.orders.index');
        //     addNoty($vendor_order->user, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
        // }
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

        changeOutStandingBalance($vendor_order->user, $vendor_order->total_price, $vendor_order->id, $vendor_order->status, 'sub');
        changeAvailableBalance($vendor_order->user, $vendor_order->total_price, $vendor_order->id, $vendor_order->status, 'add');
    }
}
