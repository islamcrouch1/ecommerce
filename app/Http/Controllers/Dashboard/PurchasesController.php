<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Entry;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
            ->where('order_from', 'addpurchase')
            ->where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
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
        return view('dashboard.purchases.create', compact('warehouses', 'suppliers'));
    }

    public function craeteReturn()
    {
        $user = Auth::user();
        $warehouses = Warehouse::where('branch_id', $user->branch_id)
            ->where('vendor_id', null)
            ->get();
        $suppliers = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'vendor');
        })->get();
        return view('dashboard.purchases.create-return', compact('warehouses', 'suppliers'));
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

        $data = [];
        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $total = 0;




        foreach ($qty as $index => $q) {
            $subtotal = $subtotal + ($q * $price[$index]);
        }

        if (isset($tax) && in_array('vat', $tax)) {
            $vat_amount = calcTax($subtotal, 'vat');
        }

        $total = $subtotal + $vat_amount;

        if (isset($tax) && in_array('wht', $tax) && $subtotal > setting('wht_invoice_amount')) {
            $wht_amount = calcTax($total, 'wht_products');
        }

        $data['status'] = 1;
        $data['total'] = $total;
        $data['subtotal'] = $subtotal;
        $data['vat_amount'] = $vat_amount;
        $data['wht_amount'] = $wht_amount;

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
            'supplier_id' => "required|numeric",
            'notes' => "nullable|string",
            'tax' => "nullable|array",
            'qty' => "nullable|array",
            'price' => "nullable|array",
        ]);


        $branch_id = getUserBranchId(Auth::user());

        if (settingAccount('suppliers_account', $branch_id) == null) {
            alertError('please select the default liability account for suppliers in settings page', 'الرجاء تحديد حساب الالزامات الافتراضية للموردين في صفحة الإعدادات');
            return redirect()->back();
        }

        if (isset($request->return) && $request->return == true) {
            $returned = true;
        } else {
            $returned = false;
        }

        // tax accounts check
        if (isset($request->tax)) {
            if (in_array('vat', $request->tax) && settingAccount('vat_purchase_account', $branch_id) == null) {
                alertError('please select the default added value tax account for purchases in settings page', 'الرجاء تحديد حساب ضريبة القيمة المضافه الافتراضية للمشتريات في صفحة الإعدادات');
                return redirect()->back();
            }

            if (in_array('wht', $request->tax)  && settingAccount('wct_account', $branch_id) == null) {
                alertError('please select the default withholding and collection tax account for purchases in settings page', 'الرجاء تحديد حساب ضريبة الخصم والتحصيل الافتراضية للمشتريات في صفحة الإعدادات');
                return redirect()->back();
            }


            if (in_array('wht', $request->tax) && !in_array('vat', $request->tax)) {
                alertError('Error happen please review taxes options and try again', 'حدث حطا اثناء معالجة قيمة الضريبة يرجى مراجعة البيانات والمحاولة مرة اخرى');
                return redirect()->back();
            }
        }

        foreach ($request->combinations as $index => $combination_id) {
            if ($request->qty[$index] <= 0 || $request->price[$index] <= 0) {
                alertError('Please add quantity or purchase price to complete the order', 'يرجى ادخال الكميات واسعار الشراء لاستكمال الطلب');
                return redirect()->back();
            }
        }


        if ($returned == true) {
            $count = 0;
            // check quantity available
            foreach ($request->combinations as $index => $combination_id) {

                $combination = ProductCombination::findOrFail($combination_id);
                $av_qty = productQuantity($combination->product_id, $request->combinations[$index], $request->warehouse_id);
                if ($request->qty[$index] > $av_qty) {
                    $count = $count + 1;
                }
            }
            if ($count > 0) {
                alertError('Some products do not have enough quantity in stock or the ordered quantity does not match the appropriate order limit', 'بعض المنتجات ليس بها كمية كافية في المخزون او الكمية المطلوبة غير متطابقة مع الحد المناسب للطلب');
                return redirect()->back();
            }
        }


        // calculate order total and taxes
        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $total = 0;
        foreach ($request->qty as $index => $q) {
            $subtotal = $subtotal + ($q * $request->price[$index]);
        }

        if (isset($request->tax) && in_array('vat', $request->tax)) {
            $vat_amount = calcTax($subtotal, 'vat');
        }

        if (isset($request->tax) && in_array('wht', $request->tax) && $subtotal > setting('wht_invoice_amount')) {
            $wht_amount = calcTax($subtotal + $vat_amount, 'wht_products');
        }

        $total = $subtotal + $vat_amount;
        $order = Order::create([
            'customer_id' => $request->supplier_id,
            'warehouse_id' => $request->warehouse_id,
            'order_from' => 'addpurchase',
            'country_id' => getDefaultCountry()->id,
            'description' => $request->notes,
            'total_price' => $total,
            'subtotal_price' => $subtotal,
            'branch_id' => $branch_id,
            'status' => $returned == true ? 'returned' : 'completed',
            'total_tax' => $vat_amount,
            'is_seen' => '0',
        ]);

        if (isset($request->tax) && in_array('vat', $request->tax)) {
            $vat = Tax::findOrFail(setting('vat'));
            $order->taxes()->attach($vat->id, ['amount' => $vat_amount]);
        }

        if (isset($request->tax) && in_array('wht', $request->tax) && $subtotal > setting('wht_invoice_amount')) {
            $wht = Tax::findOrFail(setting('wht_products'));
            $order->taxes()->attach($wht->id, ['amount' => $wht_amount]);
        }



        foreach ($request->combinations as $index => $combination_id) {

            $combination = ProductCombination::findOrFail($combination_id);

            // calculate product cost in purchase
            updateCost($combination, $request->price[$index], $request->qty[$index], $returned == false ? 'add' : 'sub', $branch_id);


            if ($request->qty[$index] > 0 && $request->price[$index] > 0) {
                $order->products()->attach(
                    $combination->product_id,
                    [
                        'warehouse_id' => $request->warehouse_id,
                        'product_combination_id' => $combination_id,
                        'product_price' => $request->price[$index],
                        'qty' => $request->qty[$index],
                        'total' => ($request->price[$index] * $request->qty[$index]),
                        'product_type' => $combination->product->product_type,
                    ]
                );

                Stock::create([
                    'product_combination_id' => $combination_id,
                    'product_id' => $combination->product_id,
                    'warehouse_id' => $request->warehouse_id,
                    'qty' => $request->qty[$index],
                    'stock_status' => $returned == true ? 'OUT' : 'IN',
                    'stock_type' => 'Purchase',
                    'reference_id' => $order->id,
                    'reference_price' => $request->price[$index],
                    'created_by' =>  Auth::id(),
                ]);


                $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);

                Entry::create([
                    'account_id' => $product_account->id,
                    'type' => 'purchase',
                    'dr_amount' => $returned == true ? 0 : ($request->price[$index] * $request->qty[$index]),
                    'cr_amount' => $returned == true ? ($request->price[$index] * $request->qty[$index]) : 0,
                    'description' => 'purchases order# ' . $order->id,
                    'branch_id' => $branch_id,
                    'reference_id' => $order->id,
                    'created_by' => Auth::id(),
                ]);
            }
        }


        if ($vat_amount > 0) {

            $purchase_vat_account = Account::findOrFail(settingAccount('vat_purchase_account', $branch_id));

            Entry::create([
                'account_id' => $purchase_vat_account->id,
                'type' => 'purchase',
                'dr_amount' => $returned == true ? 0 : $vat_amount,
                'cr_amount' => $returned == true ? $vat_amount : 0,
                'description' => 'purchases order# ' . $order->id,
                'branch_id' => $branch_id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);
        }




        $supplier_account = getItemAccount($request->supplier_id, null, 'suppliers_account', $branch_id);

        Entry::create([
            'account_id' => $supplier_account->id,
            'type' => 'purchase',
            'dr_amount' => $returned == true ? ($total - $wht_amount) : 0,
            'cr_amount' => $returned == true ? 0 : ($total - $wht_amount),
            'description' => 'purchases order# ' . $order->id,
            'branch_id' => $branch_id,
            'reference_id' => $order->id,
            'created_by' => Auth::id(),
        ]);

        if ($wht_amount > 0) {
            $wht_account = Account::findOrFail(settingAccount('wct_account', $branch_id));
            Entry::create([
                'account_id' => $wht_account->id,
                'type' => 'purchase',
                'dr_amount' => $returned == true ? $wht_amount : 0,
                'cr_amount' => $returned == true ? 0 : $wht_amount,
                'description' => 'purchases order# ' . $order->id,
                'branch_id' => $branch_id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);
        }


        alertSuccess('purchase created successfully', 'تم إضافة المشتريات بنجاح');
        return redirect()->route('purchases.index');
    }


    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => "required|string",
        ]);

        if (!checkPurchaseOrderStatus($request->status, $order->status)) {
            alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
            return redirect()->route('purchases.index');
        } elseif ($request->status == 'returned' && $order->paynemt_status != 'pending') {
            alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
            return redirect()->route('purchases.index');
        } else {

            if ($request->status == 'returned') {
                if ($order->payment_status != 'pending') {
                    alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
                    return redirect()->route('purchases.index');
                }
            }

            // check quantity available
            $count = 0;

            foreach ($order->products as $product) {
                $av_qty = productQuantity($product->id, $product->pivot->product_combination_id, $order->warehouse_id);
                if ($product->pivot->qty > $av_qty) {
                    $count = $count + 1;
                }
            }

            if ($count > 0) {
                alertError('Some products do not have enough quantity in stock to make return please review availble stock', 'بعض المنتجات ليس بها كمية كافية في المخزون لعمل المرتجع يرجى مراجعة الكميات المتاحة');
                return redirect()->route('purchases.index');
            }

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
            if (!checkPurchaseOrderStatus($request->selected_status, $order->status)) {
                alertError('The status of some orders cannot be changed', 'لا يمكن تغيير حالة بعض الطلبات');
            } elseif ($request->status == 'returned' && $order->paynemt_status != 'pending') {
                alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
                return redirect()->route('purchases.index');
            } else {

                if ($request->selected_status == 'returned') {
                    if ($order->payment_status != 'pending') {
                        alertError('The status of the order cannot be changed', 'لا يمكن تغيير حالة الطلب');
                    } else {
                        // check quantity available
                        $count = 0;
                        foreach ($order->products as $product) {
                            $av_qty = productQuantity($product->id, $product->pivot->product_combination_id, $order->warehouse_id);
                            if ($product->pivot->qty > $av_qty) {
                                $count = $count + 1;
                            }
                        }

                        if ($count > 0) {
                            alertError('Some products do not have enough quantity in stock to make return please review availble stock', 'بعض المنتجات ليس بها كمية كافية في المخزون لعمل المرتجع يرجى مراجعة الكميات المتاحة');
                            return redirect()->route('purchases.index');
                        }

                        $this->changeStatus($order, $request->selected_status);
                        alertSuccess('Order status updated successfully', 'تم تحديث حالة طلب المشتريات بنجاح');
                    }
                }
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


        if ($status == 'returned') {

            // calculate order total and taxes
            $vat_amount = 0;
            $wht_amount = 0;


            foreach ($order->taxes as $tax) {
                if ($tax->id == setting('vat')) {
                    $vat_amount = ($order->subtotal_price * $tax->tax_rate) / 100;
                }
                if ($tax->id == setting('wht_products')) {
                    $wht_amount = (($order->subtotal_price + $vat_amount) * $tax->tax_rate) / 100;
                }
            }

            foreach ($order->products as $product) {

                $combination = ProductCombination::findOrFail($product->pivot->product_combination_id);

                // calculate product cost
                updateCost($combination, $product->pivot->product_price, $product->pivot->qty,  'sub', $branch_id);

                Stock::create([
                    'product_combination_id' => $combination->id,
                    'product_id' => $combination->product_id,
                    'warehouse_id' => $order->warehouse_id,
                    'qty' => $product->pivot->qty,
                    'stock_status' => 'OUT',
                    'stock_type' => 'Purchase',
                    'reference_id' => $order->id,
                    'reference_price' => $product->pivot->product_price,
                    'created_by' =>  Auth::id(),
                ]);

                $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);

                Entry::create([
                    'account_id' => $product_account->id,
                    'type' => 'purchase',
                    'dr_amount' =>  0,
                    'cr_amount' => ($product->pivot->product_price * $product->pivot->qty),
                    'description' => 'return purchases order# ' . $order->id,
                    'branch_id' => $branch_id,
                    'reference_id' => $order->id,
                    'created_by' => Auth::id(),
                ]);
            }




            if ($vat_amount > 0) {
                $purchase_vat_account = Account::findOrFail(settingAccount('vat_purchase_account', $branch_id));
                Entry::create([
                    'account_id' => $purchase_vat_account->id,
                    'type' => 'purchase',
                    'dr_amount' => 0,
                    'cr_amount' => $vat_amount,
                    'description' => 'return purchases order# ' . $order->id,
                    'branch_id' => $branch_id,
                    'reference_id' => $order->id,
                    'created_by' => Auth::id(),
                ]);
            }

            $supplier_account = getItemAccount($order->customer_id, null, 'suppliers_account', $branch_id);

            Entry::create([
                'account_id' => $supplier_account->id,
                'type' => 'purchase',
                'dr_amount' => ($order->total_price - $wht_amount),
                'cr_amount' => 0,
                'description' => 'return purchases order# ' . $order->id,
                'branch_id' => $branch_id,
                'reference_id' => $order->id,
                'created_by' => Auth::id(),
            ]);

            if ($wht_amount > 0) {
                $wht_account = Account::findOrFail(settingAccount('wct_account', $branch_id));

                Entry::create([
                    'account_id' => $wht_account->id,
                    'type' => 'purchase',
                    'dr_amount' => $wht_amount,
                    'cr_amount' =>  0,
                    'description' => 'return purchases order# ' . $order->id,
                    'branch_id' => $branch_id,
                    'reference_id' => $order->id,
                    'created_by' => Auth::id(),
                ]);
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
    public function edit($purchase)
    {
        $purchase = purchase::findOrFail($purchase);
        return view('dashboard.purchases.edit ')->with('purchase', $purchase);
    }

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
            return redirect()->back();
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
