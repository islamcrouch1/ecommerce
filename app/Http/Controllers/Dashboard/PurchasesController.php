<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Entry;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\RunningOrder;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class PurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:purchases-read')->only('index', 'show');
        $this->middleware('permission:purchases-create')->only('create', 'store');
        $this->middleware('permission:purchases-update')->only('edit', 'update');
        $this->middleware('permission:purchases-delete|purchases-trash')->only('destroy', 'trashed');
        $this->middleware('permission:purchases-restore')->only('restore');
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
            ->where('order_from', 'purchases')
            ->where('order_type', 'PO')
            ->where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->whenInvoiceStatus(request()->invoice_status)
            ->latest()
            ->paginate(100);




        return view('dashboard.purchases.index', compact('orders', 'countries', 'branches'));
    }

    public function quitationsIndex(Request $request)
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
            ->where('order_from', 'purchases')
            ->where('order_type', 'RFQ')
            ->where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->whenInvoiceStatus(request()->invoice_status)
            ->latest()
            ->paginate(100);


        return view('dashboard.purchases.index', compact('orders', 'countries', 'branches'));
    }

    public function refundsIndex(Request $request)
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

        $orders = Order::has('refunds')
            ->whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->where('order_from', 'purchases')
            ->where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->whenInvoiceStatus(request()->invoice_status)
            ->latest()
            ->paginate(100);


        return view('dashboard.purchases.index', compact('orders', 'countries', 'branches'));
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
        $suppliers = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'vendor');
        })->get();

        $taxes = Tax::where('status', 'active')->get();
        $currencies = Currency::where('status', 'on')->get();


        return view('dashboard.purchases.create', compact('warehouses', 'suppliers', 'taxes', 'currencies'));
    }



    public function craeteReturn($order)
    {
        $user = Auth::user();
        $warehouses = Warehouse::where('branch_id', $user->branch_id)
            ->where('vendor_id', null)
            ->get();
        $suppliers = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'vendor');
        })->get();

        $taxes = Tax::where('status', 'active')->get();
        $order = Order::findOrFail($order);
        $returned = 'true';
        $currencies = Currency::where('status', 'on')->get();


        return view('dashboard.purchases.edit', compact('warehouses', 'suppliers', 'taxes', 'order', 'returned', 'currencies'));
    }


    public function edit($purchase)
    {
        $user = Auth::user();
        $warehouses = Warehouse::where('branch_id', $user->branch_id)
            ->where('vendor_id', null)
            ->get();
        $suppliers = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'vendor');
        })->get();

        $taxes = Tax::where('status', 'active')->get();
        $order = Order::findOrFail($purchase);
        $returned = 'false';
        $currencies = Currency::where('status', 'on')->get();

        return view('dashboard.purchases.edit', compact('warehouses', 'suppliers', 'order', 'taxes', 'returned', 'currencies'));
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
            return redirect()->route('purchases.create.return');
        }

        $request->merge(['return' => true]);
        $this->store($request);

        alertSuccess('purchase return created successfully', 'تم إضافة مرتجع المشتريات بنجاح');
        return redirect()->route('purchases.index');
    }

    public function searchPurchase(Request $request)
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
            }

            $data['elements'] = $combinations;
        } else {
            $data['status'] = 2;
        }


        $data['units_category_id'] = $product->unit->units_category_id;


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
        $taxes = explode(',', $request->tax);
        $compinations = explode(',', $request->compinations);

        $data = [];
        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $total = 0;
        $discount = $request->discount;
        $shipping = $request->shipping;

        if ($discount < 0) {
            $discount = 0;
        }

        if ($shipping < 0) {
            $shipping = 0;
        }



        $taxes_data = [];


        foreach ($qty as $index => $q) {
            $subtotal = $subtotal + ($q * $price[$index]);
        }

        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        $subtotal = $subtotal - $discount;
        $total = $subtotal;


        foreach ($taxes as $index => $tax) {
            $tax_data = calcTaxByID($subtotal, $tax);
            $taxes_data[$index] = $tax_data;
            $total += $tax_data['tax_amount'];
        }



        // if (isset($taxes) && in_array('vat', $taxes)) {
        //     $vat_amount = calcTax($subtotal, 'vat');
        // }

        // $total = $subtotal + $vat_amount;

        // if (isset($taxes) && in_array('wht', $taxes) && $subtotal > setting('wht_invoice_amount')) {
        //     $wht_amount = calcTax($subtotal, 'wht_products');
        // }

        $data['status'] = 1;
        $data['total'] = $total + $shipping;
        $data['subtotal'] = $subtotal;
        // $data['vat_amount'] = $vat_amount;
        // $data['wht_amount'] = $wht_amount;
        $data['discount'] = $discount * -1;
        $data['shipping'] = $shipping;
        $data['taxes'] = $taxes_data;
        $currency = Currency::find($request->currency_id);
        $data['symbol'] = isset($currency->symbol) ? $currency->symbol : '';

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
            'selected_combinations' => "required|array",
            'warehouse_id' => "required|integer",
            'user_id' => "required|integer",
            'notes' => "nullable|string",
            'taxes' => "nullable|array",
            'qty' => "nullable|array",
            'units' => "nullable|array",
            'price' => "nullable|array",
            'discount' => "nullable|numeric|gte:0",
            'returned' => "nullable|boolean",
            'order_id' => "nullable|integer",
            'order_type' => "required|string",
            'expected_delivery' => "nullable|string",
            'shipping' => "nullable|numeric|gte:0",
            'order_from' => "required|string",
            'returned' => "required|string",
            'currency_id' => "required|integer",
        ]);



        $returned = isset($request->returned) ? $request->returned : null;
        $returned = $returned == 'false' ? false : true;

        $order_from = isset($request->order_from) ? $request->order_from : null;
        $selected_order = isset($request->selected_order) ? $request->selected_order : null;


        $branch_id = getUserBranchId(Auth::user());
        $user = User::findOrFail($request->user_id);



        $errors = [];
        array_push($errors, checkWarehouse($request->warehouse_id));
        array_push($errors, checkAccountsErrors($order_from, $branch_id));
        array_push($errors, checkProductsQtyAndPrice($request->selected_combinations, $request->qty, $request->price));
        $errors = array_filter($errors);


        if (count($errors) > 0) {
            alertError(null, null, $errors);
            return redirect()->back()->withInput();
        }


        if ($selected_order) {

            $selected_order = Order::findOrFail($selected_order);

            if ($request->order_type == 'RFQ' || $request->order_type == 'PO') {
                $order = createQuotation($request, $selected_order);
            }

            if ($request->order_type == 'PO') {
                $order = createOrder($request);
            }
        } else {

            if ($request->order_type == 'RFQ') {
                $order = createQuotation($request);
            }

            if ($request->order_type == 'PO') {
                $order = createOrder($request);
            }
        }


        if ($order->order_type == 'PO') {
            return redirect()->route('purchases.index');
        } elseif ($order->order_type == 'SO') {
            return redirect()->route('sales.index');
        } elseif ($order->order_type == 'Q') {
            return redirect()->route('sales.quotations');
        } elseif ($order->order_type == 'RFQ') {
            return redirect()->route('purchases.quotations');
        }





        if ($selected_order != null && $returned == true) {

            $selected_order = Order::findOrFail($selected_order);

            if ($selected_order->order_from != $order_from) {
                alertError('reference order number is not correct', 'رقم الطلب المرجعي غير صحيح');
                return redirect()->back()->withInput();
            }

            if ($selected_order->customer_id != $request->user_id) {
                alertError('The specified customer does not match', 'العميل المحدد غير متطابق');
                return redirect()->back()->withInput();
            }

            if ($selected_order->status == 'returned' || $selected_order->status == 'RTO' || $selected_order->status == 'canceled') {
                alertError('The status of the specified order is not suitable', 'حالة الطلب المحدد غير مناسبة');
                return redirect()->back()->withInput();
            }

            if (!checkOrdersForReturn($selected_order, $request->selected_combinations, $request->qty,  $request->warehouse_id)) {
                alertError('The returned quantities do not match the quantities previously ordered in the sales order', 'كميات المرتجع غير متطابقه مع الكميات المطلوبة مسبقا في امر الشراء');
                return redirect()->back()->withInput();
            }
        }

        if ($selected_order && $returned == false) {
            $selected_order = Order::findOrFail($selected_order);
            $selected_order->update([
                'customer_id' => $user->id,
                'warehouse_id' => $request->warehouse_id,
                'order_from' => $order_from,
                'full_name' => $user->name,
                'phone' => $user->phone,
                'country_id' => $user->country_id,
                'notes' => $request->notes,
                'branch_id' => $branch_id,
                'status' => 'completed',
                'expected_delivery' => $request->expected_delivery,
                'currency_id' => $request->currency_id,
            ]);
        }

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
            'status' => $returned == true ? 'returned' : (($selected_order || $request->order_type == 'PO') ? 'completed' : 'pending'),
            'order_id' => $returned == true ? $selected_order->id : null,
            'serial' => $returned == true ? ('R' . $selected_order->serial) : getLastOrderSerial($request->order_type),
            'expected_delivery' => $request->expected_delivery,
            'currency_id' => $request->currency_id,
        ]);

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
        $stocks_limit_products = [];
        $taxes_data = [];

        foreach ($request->qty as $index => $q) {
            $sub = $sub + ($q * $request->price[$index]);
        }

        $sub = $sub - $discount;

        if ($selected_order && $returned == false) {
            $selected_order->products()->detach();
            $order->products()->detach();
        }




        foreach ($request->selected_combinations as $index => $combination_id) {

            try {

                //we will not use combination if product type is service or digital
                $combination = ProductCombination::find($request->selected_combinations[$index]);
                $product = $combination->product;

                // if ($request->order_type == 'PO' && $order_from == 'purchases') {
                //     $cost = getCost($product, $branch_id, $combination);
                // }



                $product_price = ($request->qty[$index] * $request->price[$index]) - $discountForItem;
                $subtotal += $product_price;


                if ($selected_order && $returned == false) {
                    $selected_order->products()->attach(
                        $product->id,
                        [
                            'warehouse_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->warehouse_id : null,
                            'product_combination_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->selected_combinations[$index] : null,
                            'product_price' => $request->price[$index],
                            // 'product_tax' => (isset($request->tax) && in_array('vat', $request->tax)) ? $vat_amount_product : 0,
                            // 'product_wht' => (isset($request->tax) && in_array('wht', $request->tax) && $sub > setting('wht_invoice_amount')) ? $wht_amount_product : 0,
                            'qty' => $request->qty[$index],
                            'unit_id' => $request->units[$index],
                            'total' => $request->price[$index] * $request->qty[$index],
                            'product_type' => $product->product_type,
                            // 'cost' => $cost,
                        ]
                    );
                }

                $order->products()->attach(
                    $product->id,
                    [
                        'warehouse_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->warehouse_id : null,
                        'product_combination_id' => ($product->product_type == 'simple' || $product->product_type == 'variable') ? $request->selected_combinations[$index] : null,
                        'product_price' => $request->price[$index],
                        // 'product_tax' => (isset($request->tax) && in_array('vat', $request->tax)) ? $vat_amount_product : 0,
                        // 'product_wht' => (isset($request->tax) && in_array('wht', $request->tax) && $sub > setting('wht_invoice_amount')) ? $wht_amount_product : 0,
                        'qty' => $request->qty[$index],
                        'unit_id' => $request->units[$index],
                        'total' => $request->price[$index] * $request->qty[$index],
                        'product_type' => $product->product_type,
                        // 'cost' => $cost,
                    ]
                );


                if ($selected_order && $returned == false) {
                    $selected_order->update([
                        'total_price' => $subtotal,
                        'subtotal_price' => $subtotal,
                    ]);
                }

                $order->update([
                    'total_price' => $subtotal,
                    'subtotal_price' => $subtotal,
                    // 'total_tax' => $vat_amount,
                    // 'total_wht_products' => $wht_products_amount,
                    // 'total_wht_services' => $wht_services_amount,
                ]);



                if ($request->order_type == 'PO') {
                    // add stock update and antries
                    if ($product->product_type == 'variable' || $product->product_type == 'simple') {

                        if ($order_from == 'purchases') {
                            RunningOrderCreate($combination, $request->warehouse_id, $request->qty[$index], $request->units[$index], 'purchases', $returned == true ? 'OUT' : 'IN', $order, $user->id, $request->price[$index]);
                        }
                    }
                }
            } catch (Exception $e) {
            }
        }


        if ($discount > 0) {

            if ($selected_order && $returned == false) {
                $selected_order->update([
                    'discount_amount' => $discount,
                ]);
            }

            $order->update([
                'discount_amount' => $discount,
            ]);
        }

        $total = $order->total_price;

        if ($selected_order && $returned == false) {
            $selected_order->taxes()->detach();
            $order->taxes()->detach();
        }


        if ($request->taxes) {
            foreach ($request->taxes as $index => $tax) {

                $tax_data = calcTaxByID($order->total_price, $tax);
                $taxes_data[$index] = $tax_data;
                $total += $tax_data['tax_amount'];

                if ($tax_data['tax_amount'] > 0) {
                    $vat_amount += $tax_data['tax_amount'];
                } else {
                    $wht_amount += abs($tax_data['tax_amount']);
                }


                if ($selected_order && $returned == false) {
                    $selected_order->taxes()->attach($tax, ['amount' => $tax_data['tax_amount']]);
                }

                $order->taxes()->attach($tax, ['amount' => $tax_data['tax_amount']]);
            }
        }

        if ($selected_order && $returned == false) {
            $selected_order->update([
                'total_price' => $total,
                'shipping_amount' => isset($request->shipping) ? $request->shipping : 0,
            ]);
        }


        $order->update([
            'total_price' => $total,
            'shipping_amount' => isset($request->shipping) ? $request->shipping : 0,
        ]);


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


            if ($returned == false && $order_from == 'sales') {




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

        if ($order->order_type == 'PO') {
            return redirect()->route('purchases.index');
        } elseif ($order->order_type == 'SO') {
            return redirect()->route('sales.index');
        } elseif ($order->order_type == 'Q') {
            return redirect()->route('sales.quotations');
        } elseif ($order->order_type == 'RFQ') {
            return redirect()->route('purchases.quotations');
        }
    }








    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => "required|string",
        ]);

        if ($order->order_type == 'RFQ' || ($order->status == $request->status) || $order->status == 'canceled' || $order->payment_status != 'pending') {
            alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
            return redirect()->route('sales.index');
        } else {
            $this->changeStatus($order, $request->status);
        }

        alertSuccess('Order status updated successfully', 'تم تحديث حالة طلب المشتريات بنجاح');
        return redirect()->route('purchases.index');
    }

    public function updateStatusBulk(Request $request)
    {
        $request->validate([
            'selected_status' => "required|string|max:255",
            'selected_items' => "required|array",
        ]);

        foreach ($request->selected_items as $order) {
            $order = Order::findOrFail($order);
            if ($order->order_type == 'Q' || ($order->status == $request->selected_status) || $order->status == 'canceled' || $order->payment_status != 'pending') {
                alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
                return redirect()->route('sales.index');
            } else {
                $this->changeStatus($order, $request->selected_status);
            }
        }
        return redirect()->route('purchases.index');
    }

    private function changeStatus($order, $status)
    {

        $branch_id = getUserBranchId(Auth::user());

        $order->update([
            'status' => $status,
        ]);

        createOrderHistory($order, $order->status);

        $description_ar = "تم تغيير حالة الطلب الى " . getArabicStatus($order->status) . ' طلب رقم ' . ' #' . $order->id;
        $description_en  = "order status has been changed to " . $order->status . ' order No ' . ' #' . $order->id;

        addLog('admin', 'orders', $description_ar, $description_en);


        if ($status == 'canceled') {

            $returned = true;

            foreach ($order->products as $index => $product) {

                $combination = ProductCombination::find($product->pivot->product_combination_id);

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                    RunningOrderCreate($combination, $order->warehouse_id, $product->pivot->qty, $product->pivot->unit_id, 'purchases', $returned == true ? 'OUT' : 'IN', $order, $order->customer_id, $product->pivot->product_price);
                }
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
        return view('dashboard.purchases.show')->with('order', $order);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, purchase $purchase)
    {
        $request->validate([
            'name' => "required|string|max:255",
            'description' => "required|string|max:255",
            'purchase_rate' => "required|numeric",
        ]);

        $purchase->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'purchase_rate' => $request['purchase_rate'],
            'updated_by' => Auth::id(),
        ]);

        alertSuccess('purchase updated successfully', 'تم تعديل الضريبه بنجاح');
        return redirect()->route('purchases.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($purchase)
    {
        $purchase = purchase::withTrashed()->where('id', $purchase)->first();
        if ($purchase->trashed() && auth()->user()->hasPermission('purchases-delete')) {
            $purchase->forceDelete();
            alertSuccess('purchase deleted successfully', 'تم حذف الضريبه بنجاح');
            return redirect()->route('purchases.trashed');
        } elseif (!$purchase->trashed() && auth()->user()->hasPermission('purchases-trash') && checkpurchaseForTrash($purchase)) {
            $purchase->delete();
            alertSuccess('purchase trashed successfully', 'تم حذف الضريبه مؤقتا');
            return redirect()->route('purchases.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the purchase cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الضريبه لا يمكن حذفه حاليا');
            return redirect()->back()->withInput();
        }
    }

    public function trashed()
    {
        $purchases = purchase::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.purchases.index', ['purchases' => $purchases]);
    }

    public function restore($purchase, Request $request)
    {
        $purchase = purchase::withTrashed()->where('id', $purchase)->first()->restore();
        alertSuccess('purchase restored successfully', 'تم استعادة الضريبه بنجاح');
        return redirect()->route('purchases.index');
    }
}
