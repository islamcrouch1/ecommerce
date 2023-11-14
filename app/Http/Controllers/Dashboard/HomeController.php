<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {


        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay('365')->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $user = Auth::user();

        $users_count = User::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whereRoleNot('superadministrator')
            ->get()
            ->count();


        $sales_count = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('order_from', 'sales')
            ->where('order_type', 'SO')
            ->get()
            ->count();


        $purchases_count = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->where('order_from', 'purchases')
            ->where('order_type', 'PO')
            ->where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->get()
            ->count();


        $products_count = Product::where('vendor_id', null)
            ->whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->get()
            ->count();


        $views = View::whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to)
            ->where('full_url', 'not like', "%dashboard%")
            ->where('full_url', 'not like', "%admin%")
            ->select('full_url', DB::raw('count(*) as total'))
            ->groupBy('full_url')
            ->orderBy('total', 'DESC')
            ->latest()
            ->paginate(20);



        $user = Auth::user();
        return view('dashboard.home', compact('user', 'views', 'users_count', 'sales_count', 'purchases_count', 'products_count'));
    }
}
