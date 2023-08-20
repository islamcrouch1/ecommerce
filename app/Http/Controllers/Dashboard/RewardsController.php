<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Reward;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:attendances-read')->only('index', 'show');
        $this->middleware('permission:attendances-create')->only('create', 'store');
        $this->middleware('permission:attendances-update')->only('edit', 'update');
        $this->middleware('permission:attendances-delete|attendances-trash')->only('destroy', 'trashed');
        $this->middleware('permission:attendances-restore')->only('restore');
    }


    public function index(Request $request)
    {

        $user = Auth::user();

        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }



        // where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
        //     ->

        $rewards = Reward::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenUser(request()->user_id)
            ->latest()
            ->paginate(100);
        return view('dashboard.rewards.index', compact('branches', 'rewards'));
    }

    public function create()
    {
        return view('dashboard.rewards.create');
    }



    public function store(Request $request)
    {


        $request->validate([
            'user_id' => "required|integer",
            'amount' => "required|numeric|gt:0",
            'note' => "required|string",
            'type' => "required|string",
        ]);

        $user = User::findOrFail($request['user_id']);

        $reward = Reward::create([
            'user_id' => $request['user_id'],
            'amount' => $request['amount'],
            'note' => $request['note'],
            'type' => $request['type'],
        ]);



        $description_ar = "تم اضافة" . ' ' . __($request['type']) . ' ' . 'الى' . $user->name . ' - ' . $request['amount'];
        $description_en = __($request['type']) . ' ' . 'has been added' . ' ' . 'to' . $user->name . ' - ' . $request['amount'];
        addLog('admin', 'users', $description_ar, $description_en);


        alertSuccess('saved successfully', 'تم الحفظ بنجاح');
        return redirect()->route('rewards.index');
    }


    public function destroy(Reward $reward)
    {
        if (auth()->user()->hasPermission('rewards-delete') || auth()->user()->hasPermission('rewards-trash')) {

            $user = User::findOrFail($reward->user_id);
            $description_ar = "تم حذف" . ' ' . __($reward->type) . ' ' . 'من' . $user->name . ' - ' . $reward->amount;
            $description_en = __($reward->type) . ' ' . 'has been deleted' . ' ' . 'from' . $user->name . ' - ' . $reward->amount;
            addLog('admin', 'users', $description_ar, $description_en);

            $reward->delete();

            alertSuccess('deleted successfully', 'تم الحذف بنجاح');
            return redirect()->route('rewards.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the color cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو اللون لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }
}
