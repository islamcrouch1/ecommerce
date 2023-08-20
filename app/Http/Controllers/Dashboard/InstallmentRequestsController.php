<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\InstallmentRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstallmentRequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:installment_requests-read')->only('index', 'show');
        $this->middleware('permission:installment_requests-create')->only('create', 'store');
        $this->middleware('permission:installment_requests-update')->only('edit', 'update');
        $this->middleware('permission:installment_requests-delete|installment_requests-trash')->only('destroy', 'trashed');
        $this->middleware('permission:installment_requests-restore')->only('restore');
    }

    public function index(Request $request)
    {
        $countries = Country::all();
        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }


        $user = Auth::user();

        $installment_requests = InstallmentRequest::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(50);

        return view('dashboard.installment_requests.index', compact('installment_requests', 'countries'));
    }
}
