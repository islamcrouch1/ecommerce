<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Classes\Dijkstra;
use App\Http\Classes\PriorityQueue;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Entry;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\RunningOrder;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\User;
use App\Models\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

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

        $user = Auth::user();

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        $orders = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('order_from', 'addsale')
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->latest()
            ->paginate(100);


        return view('dashboard.sales.index', compact('orders', 'countries', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $warehouses = Warehouse::where('branch_id', $user->branch_id)
            ->where('vendor_id', null)
            ->get();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'user');
        })->get();
        return view('dashboard.sales.create', compact('warehouses', 'users'));
    }

    public function craeteReturn()
    {
        $user = Auth::user();
        $warehouses = Warehouse::where('branch_id', $user->branch_id)
            ->where('vendor_id', null)
            ->get();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'user');
        })->get();
        return view('dashboard.sales.create-return', compact('warehouses', 'users'));
    }

    public function storeReturn(Request $request)
    {

        $request->validate([
            'combinations' => "required|array",
            'warehouse_id' => "required|numeric",
            'user_id' => "required|numeric",
            'order_id' => "required|numeric",
            'notes' => "nullable|string",
            'tax' => "nullable|array",
            'qty' => "nullable|array",
            'price' => "nullable|array",
            'prods' => "required|array",
        ]);


        $order = Order::findOrFail($request->order_id);


        if ($order->order_from != 'addsale' && $order->order_from != 'web') {
            alertError('reference order number is not correct', 'رقم الطلب المرجعي غير صحيح');
            return redirect()->back();
        }


        // if ($order->warehouse_id != $request->warehouse_id) {
        //     alertError('The specified warehouse does not match', 'المخزن المحدد غير متطابق');
        //     return redirect()->back();
        // }

        if ($order->customer_id != $request->user_id) {
            alertError('The specified customer does not match', 'العميل المحدد غير متطابق');
            return redirect()->back();
        }

        if ($order->status == 'returned' || $order->status == 'RTO' || $order->status == 'canceled') {
            alertError('The status of the specified order is not suitable', 'حالة الطلب المحدد غير مناسبة');
            return redirect()->back();
        }

        // if ($order->payment_status != 'pending') {
        //     alertError('The payment status of the specified order is not suitable', 'حالة الدفع للطلب المحدد غير مناسبة');
        //     return redirect()->back();
        // }


        // check quantity available
        $count = 0;
        foreach ($request->prods as $index => $product_id) {

            $product = Product::findOrFail($product_id);

            if ($product->product_type == 'simple' || $product->product_type == 'variable') {
                $products = $order->products()->wherePivot('product_id', $product->id)->wherePivot('product_combination_id', $request->combinations[$index]);
                if ($products->count() == 0) {
                    $count = $count + 1;
                }
            } else {
                $products = $order->products()->wherePivot('product_id', $product->id);
                if ($products->count() == 0) {
                    $count = $count + 1;
                }
            }
        }

        foreach ($order->products as $index => $product) {

            if ($product->product_type == 'simple' || $product->product_type == 'variable') {

                if (in_array($product->pivot->product_combination_id, $request->combinations)) {
                    foreach ($request->combinations as $index => $com) {
                        if ($com = $product->pivot->product_combination_id && $request->qty[$index] > $product->pivot->qty) {
                            $count = $count + 1;
                            break;
                        }
                    }
                }
            } else {
                if (in_array($product->id, $request->prods)) {
                    foreach ($request->prods as $index => $prod) {
                        if ($prod = $product->id && $request->qty[$index] > $product->pivot->qty) {
                            $count = $count + 1;
                            break;
                        }
                    }
                }
            }
        }

        if ($count > 0) {
            alertError('Some products not in reference order or quantity requested not available for return', 'بعض المنتجات غير موجودة في الطلب المرجعي او الكميات المكلوبة غير مناسبة للمرتجع');
            return redirect()->route('sales.create.return');
        }


        $request->merge(['return' => true]);
        $request->merge(['ref_order' => $order]);
        $this->store($request);

        alertSuccess('sale return created successfully', 'تم إضافة مرتجع المبيعات بنجاح');
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


        $wht_products_amount = 0;
        $wht_services_amount = 0;



        foreach ($qty as $index => $q) {
            $subtotal = $subtotal + ($q * $price[$index]);
        }

        if (isset($tax) && in_array('vat', $tax)) {
            $vat_amount = calcTax($subtotal, 'vat');
        }

        $total = $subtotal + $vat_amount;

        if (isset($tax) && in_array('wht', $tax) && $subtotal > setting('wht_invoice_amount')) {
            foreach ($qty as $index => $q) {

                $product_price = ($q * $price[$index]);
                $product = Product::findOrFail($products[$index]);
                $product_price = $product_price + calcTax($product_price, 'vat');

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                    $wht_amount = calcTax(($product_price), 'wht_products');
                    $wht_products_amount += $wht_amount;
                } else {
                    $wht_amount = calcTax(($product_price), 'wht_services');
                    $wht_services_amount += $wht_amount;
                }
            }

            $wht_amount = $wht_services_amount + $wht_products_amount;
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

        $branch_id = getUserBranchId(Auth::user());
        if (isset($request->return) && $request->return == true) {
            $returned = true;
        } else {
            $returned = false;
        }

        // tax check
        if (isset($request->tax) && (in_array('wht', $request->tax) && !in_array('vat', $request->tax))) {
            alertError('Error happen please review taxes options and try again', 'حدث حطا اثناء معالجة قيمة الضريبة يرجى مراجعة البيانات والمحاولة مرة اخرى');
            return redirect()->back();
        }

        // accounts check
        if (!checkAccounts($branch_id, ['vat_sales_account', 'wst_account', 'customers_account', 'revenue_account'])) {
            alertError('Please set the default accounts settings from the settings page', 'يرجى ضبط اعدادات الحسابات الافتراضية من صفحة الاعدادات');
            return redirect()->back();
        }

        // prices and quantities check
        foreach ($request->combinations as $index => $combination_id) {
            if ($request->qty[$index] <= 0 || $request->price[$index] <= 0) {
                alertError('Please add quantity or sale price to complete the order', 'يرجى ادخال الكميات واسعار البيع لاستكمال الطلب');
                return redirect()->back();
            }
        }

        // check quantity available && products status
        if ($returned == false) {
            if (!checkProductsForOrder($request->prods, $request->combinations, $request->qty,  $request->warehouse_id)) {
                alertError('Some products do not have enough quantity in stock or the product not active', 'بعض المنتجات ليس بها كمية كافية في المخزون او بعض المنتجات غير نشظة ');
                return redirect()->back();
            }
        }

        // check if cart empty
        if (count($request->prods) <= 0) {
            alertError('Your cart is empty. You cannot complete your order at this time', 'سلة مشترياتك فارغة لا يمكنك من اتمام الطلب في الوقت الحالي');
            return redirect()->back();
        }

        $order = $this->attach_order($request, 'cash_on_delivery', $branch_id);
        alertSuccess('sale created successfully', 'تم إضافة طلب المبيعات بنجاح');
        return redirect()->route('sales.index');
    }


    private function attach_order($request, $payment_method, $branch_id)
    {

        if (isset($request->return) && $request->return == true) {
            $returned = true;
            $ref_order = $request->ref_order;
        } else {
            $returned = false;
            $ref_order = null;
        }


        $user = User::findOrFail($request->user_id);

        $order = Order::create([
            'customer_id' => $request->user_id,
            'warehouse_id' => $request->warehouse_id,
            'order_from' => 'addsale',
            'full_name' => $user->name,
            'phone' => $user->phone,
            'country_id' => $user->country_id,
            'notes' => $request->notes,
            'branch_id' => $branch_id,
            // 'total_price' => $total,
            // 'subtotal_price' => $subtotal,
            'status' => $returned == true ? 'returned' : 'completed',
            'payment_method' => $payment_method,
            // 'total_tax' => $vat_amount,
        ]);


        $stocks_limit_products = [];

        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $sub = 0;

        $wht_services_amount = 0;
        $wht_products_amount = 0;

        foreach ($request->qty as $index => $q) {
            $sub = $sub + ($q * $request->price[$index]);
        }

        foreach ($request->qty as $index => $q) {

            try {

                $product = Product::findOrFail($request->prods[$index]);
                //we will not use combination if product type is service or digital
                $combination = ProductCombination::find($request->combinations[$index]);

                $product_price = ($q * $request->price[$index]);
                $vat_amount_product =  calcTax($product_price, 'vat');
                $product_price_with_vat = $product_price + $vat_amount_product;
                $vat_amount += $vat_amount_product;
                $subtotal += $product_price;

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                    $wht_amount_product = calcTax(($product_price_with_vat), 'wht_products');
                    $wht_products_amount += $wht_amount_product;
                } else {
                    $wht_amount_product = calcTax(($product_price_with_vat), 'wht_services');
                    $wht_services_amount += $wht_amount_product;
                }

                // get cost of goods sold and update ot in simple and variable products
                $cost = getProductCost($product, $combination, $branch_id, $ref_order, $request->qty[$index], $returned);

                $order->products()->attach(
                    $product->id,
                    [
                        'warehouse_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->warehouse_id : null,
                        'product_combination_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->combinations[$index] : null,
                        'product_price' => $request->price[$index],
                        'product_tax' => (isset($request->tax) && in_array('vat', $request->tax)) ? $vat_amount_product : 0,
                        'product_wht' => (isset($request->tax) && in_array('wht', $request->tax) && $sub > setting('wht_invoice_amount')) ? $wht_amount_product : 0,
                        'qty' => $request->qty[$index],
                        'total' => $request->price[$index] * $request->qty[$index],
                        'product_type' => $product->product_type,
                        'cost' => $cost,
                    ]
                );

                $order->update([
                    'total_price' => $subtotal + $vat_amount,
                    'subtotal_price' => $subtotal,
                    'total_tax' => $vat_amount,
                    'total_wht_products' => $wht_products_amount,
                    'total_wht_services' => $wht_services_amount,
                ]);


                // add stock update and antries
                if ($product->product_type == 'variable' || $product->product_type == 'simple') {

                    if ($returned == true) {
                        // calculate product cost in sales return
                        updateCost($combination, $cost, $request->qty[$index], 'add', $branch_id);
                    }


                    // add stock and running order
                    stockCreate($combination, $request->warehouse_id, $request->qty[$index], 'Sale', $returned == true ? 'IN' : 'OUT', $order->id, $user->id, $request->price[$index]);


                    // add noty for stock limit
                    if (productQuantity($product->id, $request->combinations[$index], $request->warehouse_id) <= $combination->limit) {
                        array_push($stocks_limit_products, $product);
                    }

                    $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);
                    $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $branch_id);

                    createEntry($product_account, $returned == true ? 'sales_return' : 'sales', $returned == true ? ($cost * $request->qty[$index]) :  0, $returned == true ? 0 : ($cost * $request->qty[$index]), $branch_id, $order);
                    createEntry($cs_product_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? 0 : ($cost * $request->qty[$index]), $returned == true ? ($cost * $request->qty[$index]) : 0, $branch_id, $order);

                    $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);
                } else {
                    $revenue_account = getItemAccount($product, $product->category, 'revenue_account_services', $branch_id);
                }

                createEntry($revenue_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? ($request->price[$index] * $request->qty[$index]) : 0, $returned == true ? 0 : ($request->price[$index] * $request->qty[$index]), $branch_id, $order);
            } catch (Exception $e) {
            }
        }


        $wht_amount = $wht_services_amount + $wht_products_amount;


        if (isset($request->tax) && in_array('vat', $request->tax)) {
            $vat = Tax::findOrFail(setting('vat'));
            $order->taxes()->attach($vat->id, ['amount' => $vat_amount]);
            $order->update([
                'total_tax' => $vat_amount,
            ]);
        }

        if (isset($request->tax) && in_array('wht', $request->tax) && $subtotal > setting('wht_invoice_amount')) {
            if ($wht_products_amount > 0) {
                $wht = Tax::findOrFail(setting('wht_products'));
                $order->taxes()->attach($wht->id, ['amount' => $wht_products_amount]);
                $order->update([
                    'total_wht_products' => $wht_products_amount,
                ]);
            }
            if ($wht_services_amount > 0) {
                $wht = Tax::findOrFail(setting('wht_services'));
                $order->taxes()->attach($wht->id, ['amount' => $wht_services_amount]);
                $order->update([
                    'total_wht_services' => $wht_services_amount,
                ]);
            }
        }

        $customer_account = getItemAccount($request->user_id, null, 'customers_account', $branch_id);
        createEntry($customer_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? 0 : ($order->total_price - $wht_amount), $returned == true ? ($order->total_price - $wht_amount) : 0, $branch_id, $order);


        if ($wht_amount > 0) {
            $wst_account = Account::findOrFail(settingAccount('wst_account', $branch_id));
            createEntry($wst_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? 0 : $wht_amount, $returned == true ? $wht_amount : 0, $branch_id, $order);
        }

        if ($vat_amount > 0) {
            $vat_account = Account::findOrFail(settingAccount('vat_sales_account', $branch_id));
            createEntry($vat_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? $vat_amount : 0, $returned == true ? 0 : $vat_amount, $branch_id, $order);
        }


        if ($returned == false) {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'superadministrator')
                    ->orwhere('name', 'administrator');
            })->get();

            // send noti to admins about new order and stock limit
            foreach ($users as $admin) {
                $title_ar = 'يوجد طلب جديد';
                $body_ar = 'تم اضافة طلب جديد';
                $title_en = 'There is a new order';
                $body_en  = 'A new order has been added';
                $url = route('orders.index');

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
        } elseif ($request->status == 'returned' && $order->paynemt_status != 'pending') {
            alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
            return redirect()->route('sales.index');
        } else {


            if ($request->status == 'returned') {
                if ($order->payment_status != 'pending') {
                    alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
                    return redirect()->route('sales.index');
                }
            }

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

                if ($request->status == 'returned') {
                    if ($order->payment_status != 'pending') {
                        alertError('The status of some orders cannot be changed', 'لا يمكن تغيير حالة بعض الطلبات');
                    } else {
                        $this->changeStatus($order, $request->selected_status);
                        alertSuccess('Order status updated successfully', 'تم تحديث حالة طلب المشتريات بنجاح');
                    }
                }
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

        if ($status == 'returned') {

            foreach ($order->products as $product) {

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {


                    $combination = ProductCombination::findOrFail($product->pivot->product_combination_id);

                    // calculate product cost in sales return
                    updateCost($combination, $product->pivot->cost, $product->pivot->qty, 'add', $order->branch_id);

                    Stock::create([
                        'product_combination_id' => $product->pivot->product_combination_id,
                        'product_id' => $product->id,
                        'warehouse_id' => $order->warehouse_id,
                        'qty' => $product->pivot->qty,
                        'stock_status' => 'IN',
                        'stock_type' => 'Order',
                        'reference_id' => $order->id,
                        'reference_price' => productPrice($product, $product->pivot->product_combination_id),
                        'created_by' => Auth::check() ? Auth::id() : null,
                    ]);


                    $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $order->branch_id);
                    $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $order->branch_id);

                    createEntry($product_account, 'sales_return', ($product->pivot->cost * $product->pivot->qty),  0, $order->branch_id, $order);
                    createEntry($cs_product_account, 'sales_return', 0, ($product->pivot->cost * $product->pivot->qty), $order->branch_id, $order);
                }

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                    $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $order->branch_id);
                } else {
                    $revenue_account = getItemAccount($product, $product->category, 'revenue_account_services', $order->branch_id);
                }

                createEntry($revenue_account, 'sales_return', $product->pivot->total, 0, $order->branch_id, $order);
            }


            $vat_amount = 0;
            $wht_amount = 0;
            $wht_services_amount = 0;
            $wht_products_amount = 0;

            foreach ($order->taxes as $tax) {
                if ($tax->id == setting('vat')) {
                    $vat_amount = $tax->pivot->amount;
                }
                if ($tax->id == setting('wht_products')) {
                    $wht_products_amount = $tax->pivot->amount;
                }

                if ($tax->id == setting('wht_services')) {
                    $wht_services_amount = $tax->pivot->amount;
                }
            }

            $wht_amount = $wht_products_amount + $wht_services_amount;



            $customer_account = getItemAccount($order->customer_id, null, 'customers_account', $order->branch_id);

            createEntry($customer_account, 'sales_return', 0, $order->total_price - $wht_amount, $order->branch_id, $order);

            if ($wht_amount > 0) {
                $wst_account = Account::findOrFail(settingAccount('wst_account', $order->branch_id));
                createEntry($wst_account, 'sales_return', 0, $wht_amount, $order->branch_id, $order);
            }


            if ($vat_amount > 0) {
                $vat_account = Account::findOrFail(settingAccount('vat_sales_account', $order->branch_id));
                createEntry($vat_account, 'sales_return', $vat_amount, 0, $order->branch_id, $order);
            }
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
}
