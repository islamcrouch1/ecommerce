<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:logs-read')->only('index', 'show');
        $this->middleware('permission:logs-create')->only('create', 'store');
        $this->middleware('permission:logs-update')->only('edit', 'update');
        $this->middleware('permission:logs-delete|logs-trash')->only('destroy', 'trashed');
        $this->middleware('permission:logs-restore')->only('restore');
    }

    public function index(Request $request)
    {
        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $logs = Log::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenUserType(request()->user_type)
            ->whenLogType(request()->log_type)
            ->latest()
            ->paginate(100);
        return view('Dashboard.logs.index')->with('logs', $logs);
    }
}
