<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class CashAccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:assets-read')->only('index', 'show');
        $this->middleware('permission:assets-create')->only('create', 'store');
        $this->middleware('permission:assets-update')->only('edit', 'update');
        $this->middleware('permission:assets-delete|accounts-trash')->only('destroy', 'trashed');
        $this->middleware('permission:assets-restore')->only('restore');
    }

    public function index(Request $request)
    {



        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $user = Auth::user();

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }


        $accounts = Account::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->whenSearch(request()->search)
            ->whenBranch(request()->branch_id)
            ->where(function ($query) {
                $query->where('type', 'cash_accounts')
                    ->orWhere('type', 'bank_accounts')
                    ->orWhere('type', 'receipt_notes')
                    ->orWhere('type', 'payment_notes');
            })
            ->latest()
            ->paginate(100);





        return view('dashboard.cash_accounts.index', compact('branches', 'accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::user();

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'superadministrator')
                ->orwhere('name', 'administrator');
        })->get();

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        return view('dashboard.cash_accounts.create', compact('users', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'branch_id' => "required|integer",
            'code' => [
                'required',
                'string',
                Rule::unique('accounts')->where(function ($query) use ($request) {
                    return $query->where('branch_id', $request['branch_id']);
                }),
            ],
            'users' => "nullable|array",
            'type' => "required|string"
        ]);

        $branch_id = $request->branch_id;



        $parent_account = Account::findOrFail(settingAccount($request->type, $branch_id));

        $account = Account::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'code' => $request['code'],
            'parent_id' => $parent_account->id,
            'account_type' => $parent_account->account_type,
            'reference_id' =>  $parent_account->id,
            'type' => $request->type,
            'branch_id' => $branch_id,
            'created_by' => Auth::id(),
        ]);

        $account->users()->attach($request->users);


        alertSuccess('cash account created successfully', 'تم إضافة حساب الخزينة بنجاح');
        return redirect()->route('cash_accounts.index');
    }

    public function edit($cash_account)
    {

        $user = Auth::user();

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'superadministrator')
                ->orwhere('name', 'administrator');
        })->get();

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }
        $account = account::findOrFail($cash_account);
        return view('dashboard.cash_accounts.edit', compact('account', 'users', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, account $cash_account)
    {

        $request->validate([
            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'branch_id' => "required|integer",
            'code' => [
                'required',
                'string',
                Rule::unique('accounts')->ignore($cash_account->id)->where(function ($query) use ($cash_account) {
                    return $query->where('branch_id', $cash_account->branch_id);
                }),
            ],
            'users' => "nullable|array",
        ]);

        $cash_account->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'code' => $request['code'],
            'updated_by' => Auth::id(),
        ]);


        $cash_account->users()->sync($request->users);


        alertSuccess('account updated successfully', 'تم تعديل الحساب بنجاح');
        return redirect()->route('cash_accounts.index');
    }
}
