<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
            $request->merge(['from' => Carbon::now()->subDay()->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }


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
        return view('dashboard.home', compact('user', 'views'));
    }
}
