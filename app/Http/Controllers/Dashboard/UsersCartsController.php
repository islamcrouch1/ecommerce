<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersCartsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:carts-read')->only('index', 'show');
        $this->middleware('permission:carts-create')->only('create', 'store');
        $this->middleware('permission:carts-update')->only('edit', 'update');
        $this->middleware('permission:carts-delete|carts-trash')->only('destroy', 'trashed');
        $this->middleware('permission:carts-restore')->only('restore');
    }

    public function index()
    {

        $countries = Country::all();

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })
            ->whereHas('cart_items', null, '>', 0)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenBranch(request()->branch_id)
            ->latest()
            ->paginate(100);

        return view('dashboard.carts.index', compact('users', 'countries'));
    }


    public function views(Request $request)
    {


        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay()->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }


        $views = View::whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to)
            ->where('full_url', 'not like', "%dashboard%")
            ->where('full_url', 'not like', "%admin%")
            ->whenSearch(request()->full_url)
            ->latest()
            ->paginate(150);



        return view('dashboard.carts.views', compact('views'));
    }
}
