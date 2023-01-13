<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bonus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BonusController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:bonus-read')->only('index', 'show');
        $this->middleware('permission:bonus-create')->only('create', 'store');
        $this->middleware('permission:bonus-update')->only('edit', 'update');
        $this->middleware('permission:bonus-delete|bonus-trash')->only('destroy', 'trashed');
        $this->middleware('permission:bonus-restore')->only('restore');
    }

    public function index()
    {
        $bonuses = Bonus::whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.bonus.index')->with('bonuses', $bonuses);
    }

    public function create()
    {
        return view('dashboard.bonus.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'type' => "required|string|max:255",
            'amount' => "required|numeric",
        ]);

        if ($request->amount == 0 || $request->amount < 0) {
            alertError('Can not make this action', 'نأسف , لا يمكن إتمام هذا الإجؤاء');
            return redirect()->route('bonus.index');
        }

        if ($request->type == 'all') {
            $users = User::whereRoleIs(['affiliate', 'vendor'])->get();

            foreach ($users as $user) {

                $user->balance->update([
                    'bonus' => $user->balance->bonus + intval($request->amount)
                ]);

                $ar = 'تم اضافة بونص الى حسابك من الادارة';
                $en = 'A bonus has been added to your account from the administration';
                addFinanceRequest($user, $request->bonus, $en, $ar);

                $title_ar = 'اشعار من الإدارة';
                $body_ar = 'تم اضافة بونص الى حسابك من الادارة';
                $title_en = 'New notification from admin';
                $body_en = 'A bonus has been added to your account from the administration';
                $url = route('withdrawals.user.index');

                addNoty($user, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
            }
        } elseif ($request->type == 'affiliate') {

            $users = User::whereRoleIs(['affiliate'])->get();

            foreach ($users as $user) {

                $user->balance->update([
                    'bonus' => $user->balance->bonus + intval($request->amount)
                ]);

                $ar = 'تم اضافة بونص الى حسابك من الادارة';
                $en = 'A bonus has been added to your account from the administration';
                addFinanceRequest($user, $request->bonus, $en, $ar);

                $title_ar = 'اشعار من الإدارة';
                $body_ar = 'تم اضافة بونص الى حسابك من الادارة';
                $title_en = 'New notification from admin';
                $body_en = 'A bonus has been added to your account from the administration';
                $url = route('withdrawals.user.index');

                addNoty($user, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
            }
        } elseif ($request->type == 'vendor') {

            $users = User::whereRoleIs(['vendor'])->get();

            foreach ($users as $user) {
                $user->balance->update([
                    'bonus' => $user->balance->bonus + intval($request->amount)
                ]);

                $ar = 'تم اضافة بونص الى حسابك من الادارة';
                $en = 'A bonus has been added to your account from the administration';
                addFinanceRequest($user, $request->bonus, $en, $ar);

                $title_ar = 'اشعار من الإدارة';
                $body_ar = 'تم اضافة بونص الى حسابك من الادارة';
                $title_en = 'New notification from admin';
                $body_en = 'A bonus has been added to your account from the administration';
                $url = route('withdrawals.user.index');

                addNoty($user, Auth::user(), $url, $title_en, $title_ar, $body_en, $body_ar);
            }
        }

        $bonus = Bonus::create([
            'user_id' => Auth::id(),
            'amount' => $request['amount'],
            'type' => $request['type'],
        ]);

        $description_ar = "اضافة رصيد بونص";
        $description_en  = "Add bonus balance";

        addLog('admin', 'bonus', $description_ar, $description_en);

        alertSuccess('bones added successfully', 'تم إضافة البونص بنجاح');
        return redirect()->route('bonus.index');
    }
}
