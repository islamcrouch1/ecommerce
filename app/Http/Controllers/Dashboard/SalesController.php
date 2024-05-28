<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Classes\Dijkstra;
use App\Http\Classes\PriorityQueue;
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
use App\Models\Unit;
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
            ->where('order_from', 'sales')
            ->where('order_type', 'SO')
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->whenInvoiceStatus(request()->invoice_status)
            ->latest()
            ->paginate(100);


        return view('dashboard.sales.index', compact('orders', 'countries', 'branches'));
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
            ->where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('order_from', 'sales')
            ->where('order_type', 'Q')
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->whenInvoiceStatus(request()->invoice_status)
            ->latest()
            ->paginate(100);


        return view('dashboard.sales.index', compact('orders', 'countries', 'branches'));
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
            ->where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('order_from', 'sales')
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->whenInvoiceStatus(request()->invoice_status)
            ->latest()
            ->paginate(100);


        return view('dashboard.sales.index', compact('orders', 'countries', 'branches'));
    }


    public function create()
    {
        $user = Auth::user();
        $warehouses = Warehouse::where('branch_id', $user->branch_id)
            ->where('vendor_id', null)
            ->get();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'user');
        })->get();

        $taxes = Tax::where('status', 'active')->get();

        $currencies = Currency::where('status', 'on')->get();

        return view('dashboard.sales.create', compact('warehouses', 'users', 'taxes', 'currencies'));
    }



    public function edit($sale)
    {
        $user = Auth::user();
        $warehouses = Warehouse::where('branch_id', $user->branch_id)
            ->where('vendor_id', null)
            ->get();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'user');
        })->get();

        $taxes = Tax::where('status', 'active')->get();
        $order = Order::findOrFail($sale);
        $returned = 'false';
        $currencies = Currency::where('status', 'on')->get();


        return view('dashboard.sales.edit', compact('warehouses', 'users', 'order', 'taxes', 'returned', 'currencies'));
    }

    public function craeteReturn($order)
    {
        $user = Auth::user();
        $warehouses = Warehouse::where('branch_id', $user->branch_id)
            ->where('vendor_id', null)
            ->get();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'user');
        })->get();

        $taxes = Tax::where('status', 'active')->get();
        $order = Order::findOrFail($order);

        $returned = 'true';
        $currencies = Currency::where('status', 'on')->get();

        return view('dashboard.sales.edit', compact('warehouses', 'users', 'taxes', 'order', 'returned', 'currencies'));
    }








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
            'expiration_date' => "nullable|string",

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

            if ($request->order_type == 'Q' || $request->order_type == 'SO') {
                $order = createQuotation($request, $selected_order);
            }

            if ($request->order_type == 'SO') {
                $order = createOrder($request);
            }
        } else {

            if ($request->order_type == 'Q') {
                $order = createQuotation($request);
            }

            if ($request->order_type == 'SO') {
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
                alertError('The returned quantities do not match the quantities previously ordered in the sales order', 'كميات المرتجع غير متطابقه مع الكميات المطلوبة مسبقا في امر البيع');
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
            'status' => $returned == true ? 'returned' : (($selected_order || $request->order_type == 'SO') ? 'completed' : 'pending'),
            'order_id' => $returned == true ? $selected_order->id : null,
            'serial' => $returned == true ? ('R' . $selected_order->serial) : getLastOrderSerial($request->order_type),
            'expected_delivery' => $request->expected_delivery,
            'currency_id' => $request->currency_id,
        ]);




        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $sub = 0;
        $stocks_limit_products = [];
        $taxes_data = [];

        foreach ($request->qty as $index => $q) {
            $sub = $sub + ($q * $request->price[$index]);
        }

        $sub = $sub - $request->discount;

        if ($selected_order && $returned == false) {
            $selected_order->products()->detach();
            $order->products()->detach();
        }

        foreach ($request->selected_combinations as $index => $combination_id) {

            try {

                //we will not use combination if product type is service or digital
                $combination = ProductCombination::find($request->selected_combinations[$index]);
                $product = $combination->product;

                // if ($request->order_type == 'SO' && $order_from == 'sales') {
                //     $cost = getCost($product, $branch_id, $combination);
                // }

                $product_price = ($request->qty[$index] * $request->price[$index]);
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


                if ($request->order_type == 'SO') {

                    // add stock update and antries
                    if ($product->product_type == 'variable' || $product->product_type == 'simple') {

                        if ($order_from == 'sales') {
                            // add stock and running order
                            RunningOrderCreate($combination, $request->warehouse_id, $request->qty[$index], $request->units[$index], 'sales', $returned == true ? 'IN' : 'OUT', $order, $user->id, $request->price[$index]);
                        }

                        if ($order_from == 'sales') {
                            // add noty for stock limit
                            if (productQuantity($product->id, $request->selected_combinations[$index], $request->warehouse_id) <= $combination->limit) {
                                array_push($stocks_limit_products, $product);
                            }
                        }

                        // $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);

                        // if ($order_from == 'purchases') {
                        //     createEntry($product_account, $returned == true ? 'purchase_return' : 'purchase', $returned == true ? 0 : ($request->price[$index] * $request->qty[$index]), $returned == true ? ($request->price[$index] * $request->qty[$index]) : 0, $branch_id, $order);
                        // } elseif ($order_from == 'sales') {
                        //     createEntry($product_account, $returned == true ? 'sales_return' : 'sales', $returned == true ? ($cost * $request->qty[$index]) :  0, $returned == true ? 0 : ($cost * $request->qty[$index]), $branch_id, $order);
                        // }


                        if ($order_from == 'sales') {
                            // $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $branch_id);
                            // createEntry($cs_product_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? 0 : ($cost * $request->qty[$index]), $returned == true ? ($cost * $request->qty[$index]) : 0, $branch_id, $order);
                            $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);
                        }
                    } else {

                        if ($order_from == 'sales') {
                            $revenue_account = getItemAccount($product, $product->category, 'revenue_account_services', $branch_id);
                        }
                    }

                    if ($order_from == 'sales') {
                        createEntry($revenue_account,  $returned == true ? 'sales_return' : 'sales', $returned == true ? ($request->price[$index] * $request->qty[$index]) : 0, $returned == true ? 0 : ($request->price[$index] * $request->qty[$index]), $branch_id, $order);
                    }
                }
            } catch (Exception $e) {
            }
        }


        if ($request->discount > 0) {

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


        if ($order->order_type == 'Q' || ($order->status == $request->status) || $order->status == 'canceled' || $order->payment_status != 'pending') {
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
            if ($order->order_type == 'Q' || ($order->status == $request->selected_status) || $order->status == 'canceled' || $order->payment_status != 'pending') {
                alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
                return redirect()->route('sales.index');
            } else {
                $this->changeStatus($order, $request->selected_status);
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

        if ($status == 'canceled') {

            $returned = true;

            foreach ($order->products as $index => $product) {

                $combination = ProductCombination::find($product->pivot->product_combination_id);

                if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                    RunningOrderCreate($combination, $order->warehouse_id, $product->pivot->qty, $product->pivot->unit_id, 'sales', $returned == true ? 'IN' : 'OUT', $order, $order->customer_id, $product->pivot->product_price);
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
        return view('dashboard.sales.show')->with('order', $order);
    }
}
