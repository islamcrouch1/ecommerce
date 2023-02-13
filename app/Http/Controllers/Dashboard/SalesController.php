<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Classes\Dijkstra;
use App\Http\Classes\PriorityQueue;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Country;
use App\Models\Entry;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\User;
use App\Models\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:sales-read')->only('index', 'show');
        $this->middleware('permission:sales-create')->only('create', 'store');
        $this->middleware('permission:sales-update')->only('edit', 'update');
        $this->middleware('permission:sales-delete|sales-trash')->only('destroy', 'trashed');
        $this->middleware('permission:sales-restore')->only('restore');
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
            ->where('order_from', 'addsale')
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);


        return view('dashboard.sales.index', compact('orders', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouses = Warehouse::all();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'user');
        })->get();
        return view('dashboard.sales.create', compact('warehouses', 'users'));
    }

    public function craeteReturn()
    {
        $warehouses = Warehouse::all();
        $suppliers = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'vendor');
        })->get();
        return view('dashboard.sales.create-return', compact('warehouses', 'suppliers'));
    }

    public function storeReturn(Request $request)
    {

        $request->validate([
            'combinations' => "required|array",
            'warehouse_id' => "required|numeric",
            'supplier_id' => "required|numeric",
            'notes' => "nullable|string",
            'tax' => "nullable|array",
            'qty' => "nullable|array",
            'price' => "nullable|array",
        ]);


        // check quantity available
        $count = 0;
        foreach ($request->combinations as $index => $combination_id) {

            $combination = ProductCombination::findOrFail($combination_id);

            if ($combination->product->product_type == 'simple') {
                $av_qty = productQuantity($combination->product->id, null, $request->warehouse_id);
                if ($request->qty[$index] > $av_qty || $request->qty[$index] <= 0) {
                    $count = $count + 1;
                }
            } elseif ($combination->product->product_type == 'variable') {
                $av_qty = productQuantity($combination->product->id, $combination->id, $request->warehouse_id);
                if ($request->qty[$index] > $av_qty || $request->qty[$index] <= 0) {
                    $count = $count + 1;
                }
            }
        }

        if ($count > 0) {
            alertError('Some products do not have enough quantity in stock to make return please review availble stock', 'بعض المنتجات ليس بها كمية كافية في المخزون لعمل المرتجع يرجى مراجعة الكميات المتاحة');
            return redirect()->route('sales.create.return');
        }

        $request->merge(['return' => true]);
        $this->store($request);

        alertSuccess('sale return created successfully', 'تم إضافة مرتجع المشتريات بنجاح');
        return redirect()->route('sales.index');
    }


    public function searchsales(Request $request)
    {

        $product_id = $request->product_id;

        $product = Product::findOrFail($product_id);
        $combinations = ProductCombination::where('product_id', $product_id)
            ->get();

        $data = [];

        if ($product->product_type == 'variable' || $product->product_type == 'simple') {
            $data['status'] = 1;

            foreach ($combinations as $combination) {
                $combination->name = getProductName($product, $combination);
                $combination->price = productPrice($product, $combination->id);
            }

            $data['elements'] = $combinations;
        } else {
            $data['status'] = 1;
            $products = [];
            array_push($products, $product);
            foreach ($products as $product_item) {
                $product_item->name = getProductName($product_item);
                $product_item->price = productPrice($product);
                $product_item->product_id = $product->id;
            }
            $data['elements'] = $products;
        }

        return $data;
    }

    public function calTotal(Request $request)
    {


        // $qty = $request->qty;
        // $price = $request->price;
        // $tax = $request->tax;
        // $compinations = $request->compinations;


        $qty = explode(',', $request->qty);
        $price = explode(',', $request->price);
        $tax = explode(',', $request->tax);
        $compinations = explode(',', $request->compinations);
        $products = explode(',', $request->products);

        $data = [];
        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $total = 0;
        $vat_rate = 0;
        $wht_rate = 0;



        foreach ($qty as $index => $q) {
            $subtotal = $subtotal + ($q * $price[$index]);
        }


        foreach ($tax as $t) {
            if ($t == 'vat-on' || $t == 'vat-from') {
                $vat = Tax::findOrFail(setting('vat'));
                if ($vat != null && $vat->tax_rate != null) {
                    $vat_rate = $vat->tax_rate;
                } else {
                    $vat_rate = 0;
                }
            }
        }


        if (in_array("vat-from", $tax)) {
            $total = $subtotal;
            $subtotal = (100 / ($vat_rate + 100)) * $total;
            $vat_amount = $total - $subtotal;
        } else {
            $vat_amount = ($subtotal * $vat_rate) / 100;
            $total = $subtotal + $vat_amount;
        }

        if (in_array("wht", $tax) && $subtotal > setting('wht_invoice_amount')) {
            foreach ($qty as $index => $q) {
                $product_price = ($q * $price[$index]);
                $product = Product::findOrFail($products[$index]);

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                    $wht = Tax::findOrFail(setting('wht_products'));
                    if ($wht != null && $wht->tax_rate != null) {
                        $wht_rate = $wht->tax_rate;
                    } else {
                        $wht_rate = 0;
                    }
                } else {
                    $wht = Tax::findOrFail(setting('wht_services'));
                    if ($wht != null && $wht->tax_rate != null) {
                        $wht_rate = $wht->tax_rate;
                    } else {
                        $wht_rate = 0;
                    }
                }


                if (in_array("vat-from", $tax)) {
                    $product_price = (100 / ($vat_rate + 100)) * $product_price;
                    $wht_amount = $wht_amount + (($product_price * $wht_rate) / 100);
                } else {
                    $wht_amount = $wht_amount + (($product_price * $wht_rate) / 100);
                }
            }
        } else {
            $wht_amount = 0;
        }





        $data['status'] = 1;
        $data['total'] = round($total, 2);
        $data['subtotal'] = round($subtotal, 2);
        $data['vat_amount'] = round($vat_amount, 2);
        $data['wht_amount'] = round($wht_amount, 2);

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $request->validate([
            'combinations' => "required|array",
            'warehouse_id' => "required|numeric",
            'user_id' => "required|numeric",
            'notes' => "nullable|string",
            'tax' => "nullable|array",
            'qty' => "nullable|array",
            'price' => "nullable|array",
        ]);


        if (isset($request->return) && $request->return == true) {
            $returned = true;
        } else {
            $returned = false;
        }

        // tax check
        if (isset($request->tax) && is_array($request->tax)) {
            foreach ($request->tax as $tax) {
                if (($tax == 'vat-on' || $tax == 'vat-from') && setting('vat') == null) {
                    alertError('please select the default added value tax for sales in settings page', 'الرجاء تحديد ضريبة القيمة المضافه الافتراضية للمبيعات في صفحة الإعدادات');
                    return redirect()->back();
                }

                if (($tax == 'vat-on' || $tax == 'vat-from') && setting('vat_sales_account') == null) {
                    alertError('please select the default added value tax account for sales in settings page', 'الرجاء تحديد حساب ضريبة القيمة المضافه الافتراضية للمبيعات في صفحة الإعدادات');
                    return redirect()->back();
                }

                if ($tax == 'wht' && (setting('wht_products') == null || setting('wht_services') == null)) {
                    alertError('please select the default withholding and collection tax for sales in settings page', 'الرجاء تحديد ضريبة الخصم والتحصيل الافتراضية للمبيعات في صفحة الإعدادات');
                    return redirect()->back();
                }

                if ($tax == 'wht' && setting('wst_account') == null) {
                    alertError('please select the default withholding and collection tax account for sales in settings page', 'الرجاء تحديد حساب ضريبة الخصم والتحصيل الافتراضية للمبيعات في صفحة الإعدادات');
                    return redirect()->back();
                }
            }
        }

        // accounts check
        if (setting('account_receivable_account') == null) {
            alertError('An error occurred while processing the request, please try again later', 'حدث خطا اثناء عمل الطلب يرجى المحاولة لاحقا');
            return redirect()->back();
        }

        if (setting('revenue_account') == null) {
            alertError('An error occurred while processing the request, please try again later', 'حدث خطا اثناء عمل الطلب يرجى المحاولة لاحقا');
            return redirect()->back();
        }


        $count = 0;
        $count_product = 0;

        // check quantity available
        foreach ($request->prods as $index => $product_id) {

            $product = Product::findOrFail($product_id);

            if ($product->product_type == 'simple') {
                $av_qty = productQuantity($product_id, null, $request->warehouse_id);
                if ($request->qty[$index] > $av_qty || $request->qty[$index] <= 0) {
                    $count = $count + 1;
                }
            } elseif ($product->product_type == 'variable') {
                $av_qty = productQuantity($product_id, $request->combinations[$index], $request->warehouse_id);
                if ($request->qty[$index] > $av_qty || $request->qty[$index] <= 0) {
                    $count = $count + 1;
                }
            } else {
                if ($request->qty[$index] <= 0) {
                    $count = $count + 1;
                }
            }

            if ($product->status != 'active') {
                $count_product = $count_product + 1;
            }
        }

        if ($count > 0) {
            alertError('Some products do not have enough quantity in stock or the ordered quantity does not match the appropriate order limit', 'بعض المنتجات ليس بها كمية كافية في المخزون او الكمية المطلوبة غير متطابقة مع الحد المناسب للطلب');
            return redirect()->back();
        }

        if ($count_product > 0) {
            alertError('Some products not available please remove it from your cart', 'بعض المنتجات غير متاحة للطلب في الوقت الحالي يرجى حذفها من سلة المشتريات');
            return redirect()->back();
        }

        // check if cart empty
        if (count($request->prods) <= 0) {
            alertError('Your cart is empty. You cannot complete your order at this time', 'سلة مشترياتك فارغة لا يمكنك من اتمام الطلب في الوقت الحالي');
            return redirect()->back();
        }



        $order = $this->attach_order($request, 'cash_on_delivery');
        alertSuccess('sale created successfully', 'تم إضافة طلب المبيعات بنجاح');
        return redirect()->route('sales.index');
    }


    private function attach_order($request, $payment_method)
    {

        $shipping_amount = 0;
        $user = User::findOrFail($request->user_id);


        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $total = 0;
        $vat_rate = 0;
        $wht_rate = 0;



        foreach ($request->qty as $index => $q) {
            $subtotal = $subtotal + ($q * $request->price[$index]);
        }
        if (isset($request->tax) && is_array($request->tax)) {


            foreach ($request->tax as $t) {
                if ($t == 'vat-on' || $t == 'vat-from') {
                    $vat = Tax::findOrFail(setting('vat'));
                    if ($vat != null && $vat->tax_rate != null) {
                        $vat_rate = $vat->tax_rate;
                    } else {
                        $vat_rate = 0;
                    }
                }
            }

            if (in_array("vat-from", $request->tax)) {
                $total = $subtotal;
                $subtotal = (100 / ($vat_rate + 100)) * $total;
                $vat_amount = $total - $subtotal;
            } else {
                $vat_amount = ($subtotal * $vat_rate) / 100;
                $total = $subtotal + $vat_amount;
            }

            if (in_array("wht", $request->tax) && $subtotal > setting('wht_invoice_amount')) {

                foreach ($request->qty as $index => $q) {

                    $product_price = ($q * $request->price[$index]);
                    $product = Product::findOrFail($request->prods[$index]);

                    if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                        $wht = Tax::findOrFail(setting('wht_products'));
                        if ($wht != null && $wht->tax_rate != null) {
                            $wht_rate = $wht->tax_rate;
                        } else {
                            $wht_rate = 0;
                        }
                    } else {
                        $wht = Tax::findOrFail(setting('wht_services'));
                        if ($wht != null && $wht->tax_rate != null) {
                            $wht_rate = $wht->tax_rate;
                        } else {
                            $wht_rate = 0;
                        }
                    }


                    if (in_array("vat-from", $request->tax)) {
                        $product_price = (100 / ($vat_rate + 100)) * $product_price;
                        $wht_amount = $wht_amount + (($product_price * $wht_rate) / 100);
                    } else {
                        $wht_amount = $wht_amount + (($product_price * $wht_rate) / 100);
                    }
                }
            } else {
                $wht_amount = 0;
            }
        }


        $order = Order::create([
            'affiliate_id' => null,
            'customer_id' => $request->user_id,
            'session_id' => null,
            'warehouse_id' => $request->warehouse_id,
            'order_from' => 'addsale',
            'full_name' => $user->name,
            'phone' => $user->phone,
            'address' => null,
            'country_id' => $user->country_id,
            'state_id' => null,
            'city_id' => null,
            'notes' => $request->notes,
            'house' => null,
            'special_mark' => null,

            'branch_id' => null,

            'total_price' => $total + $shipping_amount,
            'subtotal_price' => $subtotal,
            'shipping_amount' => $shipping_amount,
            'shipping_method_id' => null,

            'total_price_affiliate' => null,
            'total_commission' => null,
            'total_profit' => null,

            'status' => 'completed',
            'payment_method' => $payment_method,

            'transaction_id' => null,
            'total_tax' => null,
            'is_seen' => '0',

            'coupon_code' => null,
            'coupon_amount' => null,
        ]);

        if (isset($request->tax) && is_array($request->tax)) {

            foreach ($request->tax as $tax) {
                if ($tax == 'vat-on' || $tax == 'vat-from') {
                    $vat = Tax::findOrFail(setting('vat'));

                    $order->taxes()->attach(
                        $vat->id,
                        [
                            'amount' => $vat_amount,
                        ]
                    );
                }
                if ($tax == 'wht' && $subtotal > setting('wht_invoice_amount')) {

                    foreach ($request->qty as $index => $q) {

                        $product = Product::findOrFail($request->prods[$index]);

                        if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                            $wht = Tax::findOrFail(setting('wht_products'));
                            $order->taxes()->attach(
                                $wht->id,
                                [
                                    'amount' => $wht_amount,
                                ]
                            );
                        } else {
                            $wht = Tax::findOrFail(setting('wht_services'));
                            $order->taxes()->attach(
                                $wht->id,
                                [
                                    'amount' => $wht_amount,
                                ]
                            );
                        }
                    }
                }
            }
        }



        if (Account::where('reference_id', $request->user_id)->where('type', 'customer')->count() == 0) {
            $account = Account::findOrFail(setting('account_receivable_account'));
            $customer_account =  Account::create([
                'name_ar' => $user->name . '(مدينون)',
                'name_en' => $user->name . '(recievable)',
                'code' => $account->code .  $request->user_id,
                'parent_id' => $account->id,
                'account_type' => $account->account_type,
                'reference_id' => $request->user_id,
                'type' => 'customer',
                'created_by' => $request->user_id,
            ]);
        } else {
            $customer_account = Account::where('reference_id', $request->user_id)->where('type', 'customer')->first();
        }

        $order->update([
            'total_tax' => $vat_amount,
        ]);



        Entry::create([
            'account_id' => $customer_account->id,
            'type' => 'sales',
            'dr_amount' => $order->total_price - $wht_amount,
            'cr_amount' =>  0,
            'description' => 'sales order# ' . $order->id,
            'reference_id' => $order->id,
            'created_by' => Auth::id(),
        ]);


        if ($wht_amount > 0) {

            $wst_account = Account::findOrFail(setting('wst_account'));
            Entry::create([
                'account_id' => $wst_account->id,
                'type' => 'sales',
                'dr_amount' => $wht_amount,
                'cr_amount' =>  0,
                'description' => 'sales order# ' . $order->id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);
        }


        $vat_account = Account::findOrFail(setting('vat_sales_account'));
        Entry::create([
            'account_id' => $vat_account->id,
            'type' => 'sales',
            'dr_amount' => 0,
            'cr_amount' =>  $vat_amount,
            'description' => 'sales order# ' . $order->id,
            'reference_id' => $order->id,
            'created_by' => Auth::id(),
        ]);


        $revenue_account = Account::findOrFail(setting('revenue_account'));
        Entry::create([
            'account_id' => $revenue_account->id,
            'type' => 'sales',
            'dr_amount' => 0,
            'cr_amount' =>  $order->subtotal_price,
            'description' => 'sales order# ' . $order->id,
            'reference_id' => $order->id,
            'created_by' => Auth::id(),
        ]);




        foreach ($request->prods as $index => $product_id) {

            $product = Product::findOrFail($product_id);

            $order->products()->attach(
                $product->id,
                [
                    'warehouse_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->warehouse_id : null,
                    'product_combination_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->combinations[$index] : null,
                    'product_price' => $request->price[$index],
                    'product_tax' => null,
                    'product_discount' => null,
                    'qty' => $request->qty[$index],
                    'total' => $request->price[$index] * $request->qty[$index],
                    'product_type' => $product->product_type,

                    'affiliate_price' => null,
                    'total_affiliate_price' => null,
                    'commission_per_item' => null,
                    'profit_per_item' => null,
                    'total_commission' => null,
                    'total_profit' => null,

                    'extra_shipping_amount' => 0,
                    'shipping_method_id' => null,

                ]
            );

            if ($product->vendor->hasRole('vendor')) {

                $vendor_order = $product->vendor->vendor_orders()->create([
                    'total_price' => $request->price[$index] * $request->qty[$index],
                    'order_id' => $order->id,
                    'country_id' => $user->country_id,
                    'user_id' => $product->vendor->id,
                    'user_name' => $product->vendor->name,
                ]);


                $vendor_order->products()->attach(
                    $product->id,
                    [
                        'warehouse_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->warehouse_id : null,
                        'product_combination_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->combinations[$index] : null,
                        'qty' => $request->qty[$index],
                        'vendor_price' => $request->price[$index],
                        'total_vendor_price' => $request->price[$index] * $request->qty[$index],
                        'product_type' => $product->product_type,
                    ]
                );
                // changeOutStandingBalance($product->vendor, $vendor_order->total_price, $vendor_order->id, $vendor_order->status, 'add');
            }
        }

        $stocks_limit_products = [];

        foreach ($request->prods as $index => $product_id) {

            $product = Product::findOrFail($product_id);

            // add stock update
            if ($product->product_type == 'variable' || $product->product_type == 'simple') {

                Stock::create([
                    'product_combination_id' => $request->combinations[$index],
                    'product_id' => $product->id,
                    'warehouse_id' => $request->warehouse_id,
                    'qty' => $request->qty[$index],
                    'stock_status' => 'OUT',
                    'stock_type' => 'Sale',
                    'reference_id' => $order->id,
                    'reference_price' => $request->price[$index],
                    'created_by' => Auth::id(),
                ]);
            }


            // add noty for stock limit
            if ($product->product_type == 'variable') {

                $combination = ProductCombination::findOrFail($request->combinations[$index]);

                if (productQuantity($product->id, $request->combinations[$index], $request->warehouse_id) <= $combination->limit) {
                    array_push($stocks_limit_products, $product);
                }
            } elseif ($product->product_type == 'simple') {
                if (productQuantity($product->id, null, $request->warehouse_id) <= $product->limit) {
                    array_push($stocks_limit_products, $product);
                }
            }
        }



        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'superadministrator')
                ->where('name', '=', 'administrator');
        })->get();

        // send noti to admins about new order and stock limit
        foreach ($users as $admin) {
            $title_ar = 'يوجد طلب جديد';
            $body_ar = 'تم اضافة طلب جديد';
            $title_en = 'There is a new order';
            $body_en  = 'A new order has been added';
            $url = route('orders.index');

            if (Auth::check()) {
                $user = Auth::user();
            } else {
                $user = null;
            }

            // update user noty for not registered users
            addNoty($admin, $user, $url, $title_en, $title_ar, $body_en, $body_ar);
            foreach ($stocks_limit_products as $product) {
                $title_ar = 'تنبيه بنقص المخزون';
                $body_ar = 'تجاوز هذا المنتج الحد المسموح في المخزون :#' . $product->name_ar;
                $title_en = 'stock limit alert';
                $body_en  = 'this product over the stock limit :#' . $product->name_en;
                $url = route('stock.management.index', ['search' => $product->id]);
                addNoty($admin, $user, $url, $title_en, $title_ar, $body_en, $body_ar);
            }
        }

        return $order;
    }


    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => "required|string",
        ]);

        if (!checkPurchaseOrderStatus($request->status, $order->status)) {
            alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
            return redirect()->route('sales.index');
        } else {

            $this->changeStatus($order, $request->status);
        }

        alertSuccess('Order status updated successfully', 'تم تحديث حالة طلب المبيعات بنجاح');
        return redirect()->route('sales.index');
    }

    public function updateStatusBulk(Request $request)
    {
        $request->validate([
            'selected_status' => "required|string|max:255",
            'selected_items' => "required|array",
        ]);

        foreach ($request->selected_items as $order) {
            $order = Order::findOrFail($order);
            if (!checkPurchaseOrderStatus($request->selected_status, $order->status)) {
                alertError('The status of some orders cannot be changed', 'لا يمكن تغيير حالة بعض الطلبات');
            } else {
                $this->changeStatus($order, $request->selected_status);
                alertSuccess('Order status updated successfully', 'تم تحديث حالة طلب المشتريات بنجاح');
            }
        }
        return redirect()->route('sales.index');
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

        addNoty($order->customer, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);

        if ($status == 'returned') {


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


            $vat_amount = 0;
            $wht_amount = 0;

            foreach ($order->taxes as $tax) {
                if ($tax->id == setting('vat')) {
                    $vat_amount = $tax->pivot->amount;
                }
                if ($tax->id == setting('wht_products') || $tax->id == setting('wht_services')) {
                    $wht_amount = $tax->pivot->amount;
                }
            }


            $customer_account = Account::where('reference_id', $order->customer_id)->where('type', 'customer')->first();

            Entry::create([
                'account_id' => $customer_account->id,
                'type' => 'sales',
                'dr_amount' => 0,
                'cr_amount' =>  $order->total_price - $wht_amount,
                'description' => 'sales order# ' . $order->id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);


            if ($wht_amount > 0) {

                $wst_account = Account::findOrFail(setting('wst_account'));
                Entry::create([
                    'account_id' => $wst_account->id,
                    'type' => 'sales',
                    'dr_amount' => 0,
                    'cr_amount' =>  $wht_amount,
                    'description' => 'sales order# ' . $order->id,
                    'reference_id' => $order->id,
                    'created_by' => Auth::id(),
                ]);
            }


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
                'dr_amount' => $order->subtotal_price,
                'cr_amount' =>  0,
                'description' => 'sales order# ' . $order->id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($order)
    {
        $order = Order::findOrFail($order);
        return view('dashboard.sales.show')->with('order', $order);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($sale)
    {
        $sale = sale::findOrFail($sale);
        return view('dashboard.sales.edit ')->with('sale', $sale);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sale $sale)
    {
        $request->validate([
            'name' => "required|string|max:255",
            'description' => "required|string|max:255",
            'sale_rate' => "required|numeric",
        ]);

        $sale->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'sale_rate' => $request['sale_rate'],
            'updated_by' => Auth::id(),
        ]);

        alertSuccess('sale updated successfully', 'تم تعديل الضريبه بنجاح');
        return redirect()->route('sales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sale)
    {
        $sale = sale::withTrashed()->where('id', $sale)->first();
        if ($sale->trashed() && auth()->user()->hasPermission('sales-delete')) {
            $sale->forceDelete();
            alertSuccess('sale deleted successfully', 'تم حذف الضريبه بنجاح');
            return redirect()->route('sales.trashed');
        } elseif (!$sale->trashed() && auth()->user()->hasPermission('sales-trash') && checksaleForTrash($sale)) {
            $sale->delete();
            alertSuccess('sale trashed successfully', 'تم حذف الضريبه مؤقتا');
            return redirect()->route('sales.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the sale cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الضريبه لا يمكن حذفه حاليا');
            return redirect()->back();
        }
    }

    public function trashed()
    {
        $sales = sale::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.sales.index', ['sales' => $sales]);
    }

    public function restore($sale, Request $request)
    {
        $sale = sale::withTrashed()->where('id', $sale)->first()->restore();
        alertSuccess('sale restored successfully', 'تم استعادة الضريبه بنجاح');
        return redirect()->route('sales.index');
    }



    public function test(Request $request)
    {

        // dd($this->longestCommonPrefix(["a"]));


        $l1 = new ListNode();
        $l1->val = 5;
        $l1->next = new ListNode();
        $l1->next->val = 4;
        $l1->next->next = new ListNode();
        $l1->next->next->val = 3;

        $l2 = new ListNode();
        $l2->val = 5;
        $l2->next = new ListNode();
        $l2->next->val = 6;
        $l2->next->next = new ListNode();
        $l2->next->next->val = 6;


        dd($this->addTwoNumbers($l1, $l2));
    }


    private function addTwoNumbers($l1, $l2)
    {

        $check = 1;
        $hash = [];
        $level = 0;

        while ($check == 1) {

            $hash[$level] = $l1->val + $l2->val;

            if ($l1->next == null && $l2->next == null) {
                $check = 0;
                continue;
            } else {
                $level++;
            }

            if ($l1->next != null) {
                $l1 = $l1->next;
            } else {
                $l1 = new ListNode();
            }

            if ($l2->next != null) {
                $l2 = $l2->next;
            } else {
                $l2 = new ListNode();
            }
        }




        $remaining = 0;
        $output = [];


        for ($i = 0; $i < count($hash); $i++) {
            $no = $hash[$i] + $remaining;

            if ($no > 9) {
                $output[$i] = $no - 10;
                $remaining = 1;
            } else {
                $output[$i] = $no;
                $remaining = 0;
            }
        }




        if ($remaining == 1) {
            $output[count($output)] = 1;
        }


        $out = new ListNode();
        $value = array_shift($output);
        $out->val = $value;

        $node = $out;

        while (count($output) != 0) {

            $node->next = new ListNode();
            $value = array_shift($output);
            $node->next->val = $value;

            if (count($output) != 0) {
                $node = $node->next;
            }
        }


        return $out;
    }

    private function longestCommonPrefix($strs)
    {

        $trie = new Trie();

        for ($i = 0; $i < count($strs); $i++) {
            $trie->insert($strs[$i]);
        }

        $srting = $strs[0];
        $output = '';


        for ($i = 0; $i < strlen($srting); $i++) {
            $count = $trie->search(substr($srting, 0, $i + 1));




            if ($count != 0 && $count == count($strs)) {

                $output = $output . $srting[$i];
            }
        }


        return $output;
    }
}


class ListNode
{
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

class Node
{
    public $end = false;
    public $children = [];
    public $count = 1;
}


class Trie
{
    public $node = null;

    public function __construct()
    {
        $this->node = new Node();
    }

    public function insert($string)
    {
        $node = $this->node;

        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            if (is_array($node->children)  && array_key_exists($char, $node->children)) {
                $node = $node->children[$char];
                $node->count += 1;
                continue;
            }

            $node->children[$char] = new Node();
            $node = $node->children[$char];
        }

        $node->end = true;
    }


    public function search($string)
    {
        $node = $this->node;
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            if (!array_key_exists($char, $node->children)) {
                return 0;
            }
            $node = $node->children[$char];
        }

        return $node->count;
    }
}
