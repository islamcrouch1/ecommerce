<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalsController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $withdrawals = Withdrawal::where('user_id', $user->id)->latest()->paginate(50);
        $requests = ModelsRequest::where('user_id', $user->id)->latest()->paginate(50);
        return view('dashboard.withdrawals.user', compact('user', 'withdrawals', 'requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => "required|numeric",
            'type' => "required|string",
            'data' => "required|string",
            'code' => "required|string",
        ]);

        $user = Auth::user();
        $limit = 0;
        $limit = $user->hasRole('affiliate') ? setting('affiliate_limit') : setting('vendor_limit');

        if ($request->code == $user->verification_code) {
            if ($request->amount <= 0) {

                alertError('You cannot make a request to withdraw the balance', 'لم يمكنك عمل طلب سحب الرصيد');
                return redirect()->route('withdrawals.user.index');
            } elseif ($request->amount < $limit) {

                alertError('It is not possible to make a request to withdraw the balance less than ' . $limit . ' EGP', 'لا يمكنك عمل طلب السحب , المبلغ المطلوب أقل من الحد المسموحح للسحب');
                return redirect()->route('withdrawals.user.index');
            } elseif ($request->amount > $user->balance->available_balance + $user->balance->bonus) {

                alertError('The amount you entered is not available in your account. You cannot complete the order', 'المبلغ الذي ادخلته غير متوفر في حسابك لا يمكنك من اتمام الطلب');
                return redirect()->route('withdrawals.user.index');
            } else {


                $withdraw = Withdrawal::create([
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                    'country_id' => $user->country->id,
                    'data' => $request->data,
                    'type' => $request->type,
                ]);


                $balance = Balance::where('user_id', $user->id)->first();

                if ($request->amount < $balance->available_balance) {
                    changeAvailableBalance($user, $request->amount,  0, null, 'sub');
                    changePendingWithdrawalBalance($user, $request->amount, 0, null, 'add');
                } else {
                    $nAmount = $request->amount - $balance->available_balance;
                    $balance->update([
                        'available_balance' => 0,
                        'bonus' => $balance->bonus - $nAmount,
                        'pending_withdrawal_requests' => $balance->pending_withdrawal_requests + $request->amount,
                    ]);
                }

                $users = User::whereHas('roles', function ($query) {
                    $query->where('name', '!=', 'vendor')
                        ->where('name', '!=', 'affiliate');
                })->get();

                foreach ($users as $admin) {

                    $title_ar = 'يوجد طلب سحب رصيد';
                    $body_ar = 'تم اضافة طلب سحب رصيد جديد  : ' . $user->name;
                    $title_en = 'There is a new balance withdrawal request';
                    $body_en  = 'A new balance withdrawal request has been added from : ' . $user->name;
                    $url = route('withdrawals.index');

                    addNoty($admin, $user, $url, $title_en, $title_ar, $body_en, $body_ar);
                }

                Auth::user()->forceFill([
                    'verification_code' => null
                ])->save();

                alertSuccess('The request has been sent successfully and it will be reviewed by the administration', 'تم ارسال الطلب بنجاح وسوف يتم مراجعته من الإدارة');
                return redirect()->route('withdrawals.user.index');
            }
        } else {
            alertError('Invalid request confirmation code', 'كود تاكيد الطلب غير صحيح');
            return redirect()->route('withdrawals.user.index');
        }
    }
}
