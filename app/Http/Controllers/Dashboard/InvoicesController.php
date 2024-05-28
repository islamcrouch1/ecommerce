<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:invoices-read')->only('index', 'show');
        $this->middleware('permission:invoices-create')->only('create', 'store');
        $this->middleware('permission:invoices-update')->only('edit', 'update');
        $this->middleware('permission:invoices-delete|invoices-trash')->only('destroy', 'trashed');
        $this->middleware('permission:invoices-restore')->only('restore');
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

        $invoices = Invoice::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->whenSearch(request()->search)
            ->whenBranch(request()->branch_id)
            ->whenOrder(request()->order_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->latest()
            ->paginate(100);

        if (request()->has('order_id')) {
            $order = Order::findOrFail(request()->order_id);
        } else {
            $order = null;
        }



        return view('dashboard.invoices.index', compact('invoices', 'countries', 'branches', 'order'));
    }


    public function create(Request $request)
    {

        $user = Auth::user();
        $warehouses = Warehouse::where('branch_id', $user->branch_id)
            ->where('vendor_id', null)
            ->get();

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'user')->orWhere('name', '=', 'vendor');
        })->get();

        $taxes = Tax::where('status', 'active')->get();

        if (request()->has('order_id')) {
            $order = Order::findOrFail(request()->order_id);
        } else {
            $order = null;
        }

        $currencies = Currency::where('status', 'on')->get();


        if (request()->has('order_id')) {
            return view('dashboard.invoices.edit', compact('warehouses', 'users', 'taxes', 'order', 'currencies'));
        } else {
            return view('dashboard.invoices.create', compact('warehouses', 'users', 'taxes', 'order', 'currencies'));
        }
    }


    public function productsSearch(Request $request)
    {

        $search = $request->search;

        $products = Product::where('vendor_id', null)->whenSearch($search)
            ->get();

        $data = [];
        $data['status'] = 1;
        $data['elements'] = $products;


        return $data;
    }

    public function getCombinations(Request $request)
    {

        $product_id = $request->product_id;

        $product = Product::findOrFail($product_id);
        $combinations = ProductCombination::where('product_id', $product_id)
            ->get();

        $data = [];



        if ($product->product_type == 'variable' || $product->product_type == 'simple') {
            $data['status'] = 1;

            checkProductUnit($product);

            foreach ($combinations as $combination) {
                $combination->name = getProductName($product, $combination);
                $combination->price = productPrice($product, $combination->id);
                $combination->can_rent = $product->can_rent != null ? $product->can_rent : 'off';
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


        $data['units_category_id'] = $product->unit->units_category_id;

        return $data;
    }

    public function getUnits(Request $request)
    {

        $units_category_id = $request->units_category_id;

        $units = Unit::where('units_category_id', $units_category_id)->get();

        $data = [];

        if ($units) {
            $data['status'] = 1;
            $data['elements'] = $units;
        }

        return $data;
    }

    public function calTotal(Request $request)
    {



        $qty = explode(',', $request->qty);
        $days = explode(',', $request->days);
        $price = explode(',', $request->price);
        $taxes = explode(',', $request->tax);
        $compinations = explode(',', $request->compinations);
        $products = explode(',', $request->products);

        $data = [];
        $subtotal = 0;
        $vat_amount = 0;
        $wht_amount = 0;
        $total = 0;
        $vat_rate = 0;
        $wht_rate = 0;

        $discount = $request->discount;
        $shipping = $request->shipping;

        $taxes_data = [];



        foreach ($qty as $index => $q) {

            if ($days[$index] <= 0) {
                $days[$index] = 1;
            }

            $subtotal = $subtotal + ($q * $price[$index] * $days[$index]);
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

        $data['status'] = 1;
        $data['total'] = round($total + $shipping, 2);
        $data['subtotal'] = round($subtotal, 2);
        $data['discount'] = round($discount * -1, 2);
        $data['shipping'] = $shipping;
        $data['taxes'] = $taxes_data;

        $currency = Currency::find($request->currency_id);
        $data['symbol'] = isset($currency->symbol) ? $currency->symbol : '';

        return $data;
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
            'order_id' => "nullable|integer",
            'status' => "required|string",
            'due_date' => "required|string",
            'shipping' => "nullable|numeric|gte:0",
            'currency_id' => "required|integer",
        ]);

        if ($request->status == 'invoice' || $request->status == 'bill') {
            $returned = false;
        } else {
            $returned = true;
        }

        if ($request->order_id != null) {
            $selected_order = Order::findOrFail($request->order_id);
            $branch_id = $selected_order->branch_id;
        } else {
            $selected_order = null;
            $branch_id = getUserBranchId(Auth::user());
        }

        if ($request->status == 'invoice' || $request->status == 'credit_note') {
            $order_from = 'sales';
        } else {
            $order_from = 'purchases';
        }


        /// check order is not canceled

        $errors = [];
        array_push($errors, checkWarehouse($request->warehouse_id));
        array_push($errors, checkAccountsErrors($order_from, $branch_id));
        array_push($errors, checkProductsQtyAndPrice($request->selected_combinations, $request->qty, $request->price));

        if ($selected_order != null) {
            array_push($errors, checkQtyForInvoice($selected_order, $request));
            array_push($errors, checkDiscountForInvoice($selected_order, $request));
            array_push($errors, checkShippingForInvoice($selected_order, $request));
        }

        $errors = array_filter($errors);


        if (count($errors) > 0) {
            alertError(null, null, $errors);
            return redirect()->back()->withInput();
        }



        if ($selected_order != null) {
            $invoice = createInvoice($request, $returned, $branch_id, $order_from, $selected_order);
            getOrderInvoiceStatus($selected_order);
        }

        if ($selected_order != null) {
            return redirect()->route('invoices.index', ['order_id' => $selected_order->id]);
        } else {
            return redirect()->route('invoices.index');
        }
    }


    public function show($invoice)
    {
        $invoice = Invoice::findOrFail($invoice);
        return view('dashboard.invoices.show')->with('invoice', $invoice);
    }
}
