<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;


class StockController extends Controller
{


    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:add_stock-read')->only('atockAdd');
        $this->middleware('permission:stock_lists-read')->only('stockList');
        $this->middleware('permission:stock_inventory-read')->only('inventory');
        $this->middleware('permission:stock_shortages-read')->only('index');
    }


    public function index()
    {

        $user = Auth::user();


        $combinations = ProductCombination::whenProduct(request()->product)
            ->whereHas('product', function ($query) {
                $query->where('vendor_id', null);
            })
            ->latest()
            ->paginate(100);

        foreach ($combinations as $index => $com) {
            if (productQuantity($com->product_id, $com->id, request()->warehouse_id) > $com->limit) {
                unset($combinations[$index]);
            }
        }


        $warehouses = Warehouse::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('vendor_id', null)
            ->get();



        return view('dashboard.stocks.index', compact('combinations', 'warehouses'));
    }

    public function inventory()
    {
        $combinations = ProductCombination::whenProduct(request()->product)
            ->whereHas('product', function ($query) {
                $query->where('vendor_id', null);
            })
            ->latest()
            ->paginate(100);

        $user = Auth::user();

        $warehouses = Warehouse::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('vendor_id', null)
            ->get();



        return view('dashboard.stocks.inventory', compact('combinations', 'warehouses', 'user'));
    }


    public function stockList()
    {


        $user = Auth::user();


        if ($user->hasPermission('branches-read')) {
            $warehouses = Warehouse::all()->pluck('id')->toArray();
        } else {
            $warehouses = $user->branch->warehouses->pluck('id')->toArray();
        }


        $stocks = Stock::whenProduct(request()->product)
            ->whenWarehouse(request()->warehouse_id)
            ->whereHas('warehouse', function ($query) {
                $query->where('vendor_id', null);
            })->whereIn('warehouse_id', $warehouses)
            ->whenSearch(request()->search)
            ->whenWarehouse(request()->warehouse_is)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(50);



        $warehouses = Warehouse::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('vendor_id', null)
            ->get();

        return view('dashboard.stocks.list', compact('stocks', 'warehouses'));
    }


    public function atockAdd()
    {
        return view('dashboard.stocks.add');
    }



    public function searchReturn(Request $request)
    {

        $search = $request->search;

        $products = Product::where('vendor_id', null)->whenSearch($search)
            ->get();

        // $products = Product::whenSearch($search)
        //     ->get();

        $data = [];
        $data['status'] = 1;
        $data['elements'] = $products;


        return $data;
    }
}
