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
        $this->middleware('permission:orders_report-read')->only('index', 'show');
        $this->middleware('permission:orders_report-create')->only('create', 'store');
        $this->middleware('permission:orders_report-update')->only('edit', 'update');
        $this->middleware('permission:orders_report-delete|orders_report-trash')->only('destroy', 'trashed');
        $this->middleware('permission:orders_report-restore')->only('restore');
    }


    public function index()
    {
        return view('dashboard.finances.index');
    }
}
