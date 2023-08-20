<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Stock;
use App\Models\StockTransfer;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:stock_transfers-read')->only('index', 'show');
        $this->middleware('permission:stock_transfers-create')->only('create', 'store');
        $this->middleware('permission:stock_transfers-update')->only('edit', 'update');
        $this->middleware('permission:stock_transfers-delete|stock_transfers-trash')->only('destroy', 'trashed');
        $this->middleware('permission:stock_transfers-restore')->only('restore');
    }


    public function index()
    {
        $transfers = StockTransfer::whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.stock_transfers.index', compact('transfers'));
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
        return view('dashboard.stock_transfers.create', compact('warehouses'));
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
            'warehouse_from' => "required|string",
            'warehouse_to' => "required|string",
            'ref' => "nullable|string",
            'notes' => "nullable|string",
            'product' => "required|string",
            'qty' => "required|array",

        ]);

        $product = Product::findOrFail($request->product);

        if ($product->product_type == 'variabel') {
            $request->validate([
                'combinations' => "required|array",
            ]);
        }


        if ($request->warehouse_from == $request->warehouse_to) {
            alertError('The transfer must be between different warehouses', 'يجب ان يكون التحويل بين مخازن مختلفه');
            return redirect()->back()->withInput();
        }

        foreach ($request->qty as $index => $qty) {
            if ($qty <= 0) {
                alertError('The transfer quantity must be greater than zero', 'يجب ان تكون كمية المخزون اكبر من الصفر');
                return redirect()->back()->withInput();
            }
        }

        if ($product->product_type == 'simple') {

            foreach ($product->combinations as $combination) {
                if ($request->qty[0] > productQuantity($product->id, $combination->id, $request->warehouse_from)) {
                    alertError('There are not enough quantities in the specified warehouse for stock exchange', 'لا توجد كميات كافية في المخزن المحدد لصرف المخزون');
                    return redirect()->back()->withInput();
                }
            }

            StockTransfer::create([
                'reference_no' => $request->ref,
                'notes' => $request->notes,
                'warehouse_from' => $request->warehouse_from,
                'warehouse_to' => $request->warehouse_to,
                'created_by' => Auth::id()
            ]);

            Stock::create([
                'product_combination_id' => $combination->id,
                'product_id' => $product->id,
                'warehouse_id' => $request->warehouse_from,
                'qty' => $request->qty[0],
                'stock_status' => 'OUT',
                'stock_type' => 'StockTransfer',
                'created_by' => Auth::id()
            ]);

            Stock::create([
                'product_combination_id' => $combination->id,
                'product_id' => $product->id,
                'warehouse_id' => $request->warehouse_to,
                'qty' => $request->qty[0],
                'stock_status' => 'IN',
                'stock_type' => 'StockTransfer',
                'created_by' => Auth::id()
            ]);
        }


        if ($product->product_type == 'variable') {

            foreach ($request->combinations as $combination) {
                if ($request->qty[0] > productQuantity($product->id, $combination, $request->warehouse_from)) {
                    alertError('There are not enough quantities in the specified warehouse for stock exchange', 'لا توجد كميات كافية في المخزن المحدد لصرف المخزون');
                    return redirect()->back()->withInput();
                }
            }

            StockTransfer::create([
                'reference_no' => $request->ref,
                'notes' => $request->notes,
                'warehouse_from' => $request->warehouse_from,
                'warehouse_to' => $request->warehouse_to,
                'created_by' => Auth::id()
            ]);

            foreach ($request->combinations as $index => $combination) {

                Stock::create([
                    'product_combination_id' => $combination,
                    'product_id' => $product->id,
                    'warehouse_id' => $request->warehouse_from,
                    'qty' => $request->qty[$index],
                    'stock_status' => 'OUT',
                    'stock_type' => 'StockTransfer',
                    'created_by' => Auth::id()
                ]);

                Stock::create([
                    'product_combination_id' => $combination,
                    'product_id' => $product->id,
                    'warehouse_id' => $request->warehouse_to,
                    'qty' => $request->qty[$index],
                    'stock_status' => 'IN',
                    'stock_type' => 'StockTransfer',
                    'created_by' => Auth::id()
                ]);
            }
        }


        alertSuccess('stock transfer created successfully', 'تم اضافة تحويل المخزون بنجاح');
        return redirect()->route('stock_transfers.index');
    }




    public function search(Request $request)
    {

        $product_id = $request->product_id;

        $product = Product::findOrFail($product_id);
        $combinations = ProductCombination::where('product_id', $product_id)
            ->get();

        $data = [];

        if ($product->product_type == 'variable') {
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
}
