<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinancesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:finances-read')->only('index', 'show');
        $this->middleware('permission:finances-create')->only('create', 'store');
        $this->middleware('permission:finances-update')->only('edit', 'update');
        $this->middleware('permission:finances-delete|finances-trash')->only('destroy', 'trashed');
        $this->middleware('permission:finances-restore')->only('restore');
    }


    public function index()
    {
        return view('dashboard.finances.index');
    }
}
