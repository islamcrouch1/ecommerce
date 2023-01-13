<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Country;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:withdrawals-read')->only('index', 'show');
        $this->middleware('permission:withdrawals-create')->only('create', 'store');
        $this->middleware('permission:withdrawals-update')->only('edit', 'update');
        $this->middleware('permission:withdrawals-delete|withdrawals-trash')->only('destroy', 'trashed');
        $this->middleware('permission:withdrawals-restore')->only('restore');
    }


    public function index(Request $request)
    {

        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $countries = Country::all();
        $withdrawals = Withdrawal::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(50);

        return view('dashboard.withdrawals.index', compact('withdrawals', 'countries'));
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'status' => "required|string",
        ]);

        $withdrawal->update([
            'status' => $request->status,
        ]);

        $user = User::findOrFail($withdrawal->user_id);

        if ($request->status == 'canceled') {
            changeAvailableBalance($user, $withdrawal->amount,  0, null, 'add');
            changePendingWithdrawalBalance($user, $withdrawal->amount, 0, null, 'sub');
        } elseif ($request->status == 'confirmed') {
            changePendingWithdrawalBalance($user, $withdrawal->amount, 0, null, 'sub');
            changeCompletedWithdrawalBalance($user, $withdrawal->amount, 0, null, 'add');
        }

        switch ($request->status) {
            case "pending":
                $status_en = "pending";
                $status_ar = "معلق";
                break;
            case "recieved":
                $status_en = "recieved";
                $status_ar = "تم الاستلام وقيد المراجعة من الادارة";
                break;
            case "confirmed":
                $status_en = "confirmed";
                $status_ar = "تم تاكيد الطلب وارسال المبلغ";
                break;
            case "canceled":
                $status_en = "canceled";
                $status_ar = "تم الغاء الطلب";
                break;
            default:
                break;
        }

        $title_ar = 'اشعار من الإدارة';
        $body_ar = "تم تغيير حالة طلب سحب الرصيد الخاص بك الى " . $status_ar;
        $title_en = 'Notification From Admin';
        $body_en  = "Your withdrawal request status has been changed to " . $status_en;
        $url = route('withdrawals.user.index');
        addNoty($user, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);

        alertSuccess('request updated successfully', 'تم تحديث حالة الطلب بنجاح');
        return redirect()->route('withdrawals.index');
    }
}
