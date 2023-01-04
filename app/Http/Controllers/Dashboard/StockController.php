<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::whenSearch(request()->search)
            ->whereColumn('quantity', '<=', 'limit')
            ->latest()
            ->paginate(100);

        return view('Dashboard.stocks.index', compact('stocks'));
    }
}
