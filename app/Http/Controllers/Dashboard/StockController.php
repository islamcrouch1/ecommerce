<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCombination;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $combinations = ProductCombination::whenProduct(request()->product)
            ->latest()
            ->paginate(100);

        foreach ($combinations as $index => $com) {
            if (productQuantity($com->product_id, $com->id, request()->warehouse_id) > $com->limit) {
                unset($combinations[$index]);
            }
        }


        $warehouses = Warehouse::all();

        return view('Dashboard.stocks.index', compact('combinations', 'warehouses'));
    }


    public function stockList()
    {

        $stocks = Stock::whenProduct(request()->product)
            ->whenWarehouse(request()->warehouse_id)
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(50);
        $warehouses = Warehouse::all();


        return view('Dashboard.stocks.list', compact('stocks', 'warehouses'));
    }


    public function atockAdd()
    {
        return view('Dashboard.stocks.add');
    }

    public function search(Request $request)
    {

        $search = $request->search;

        $products = Product::whenSearch($search)
            ->get();

        $data = [];
        $data['status'] = 1;
        $data['elements'] = $products;


        return $data;
    }
}
