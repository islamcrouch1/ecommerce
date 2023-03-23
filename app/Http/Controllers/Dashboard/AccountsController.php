<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:accounts-read')->only('index', 'show');
        $this->middleware('permission:accounts-create')->only('create', 'store');
        $this->middleware('permission:accounts-update')->only('edit', 'update');
        $this->middleware('permission:accounts-delete|accounts-trash')->only('destroy', 'trashed');
        $this->middleware('permission:accounts-restore')->only('restore');
    }

    public function index()
    {


        if (!request()->has('parent_id')) {
            request()->merge(['parent_id' => null]);
        }

        $user = Auth::user();

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }


        $accounts = Account::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->whenSearch(request()->search)
            ->whenParent(request()->parent_id)
            ->whenBranch(request()->branch_id)
            ->latest()
            ->paginate(100);


        return view('dashboard.accounts.index', compact('accounts', 'branches', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::whereNull('parent_id')
            ->get();

        $user = Auth::user();

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        return view('dashboard.accounts.create', compact('accounts', 'user', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if (!request()->has('parent_id')) {
            request()->merge(['parent_id' => null]);
        }

        $request->validate([
            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'code' => [
                'required',
                'string',
                Rule::unique('accounts')->where(function ($query) use ($request) {
                    return $query->whereIn('branch_id', $request['branches']);
                }),
            ],
            // 'code' => "required|string|max:255",
            'parent_id' => "nullable|string",
            'branches' => "required|array",
            'account_type' => "required|string|max:255",
        ]);

        if ($request->parent_id != null) {
            $acc = Account::findOrFail($request->parent_id);
            $accounts = Account::where('code', $acc->code)->get();
        } else {
            $account_type = $request['account_type'];
            $parent_id = $request['parent_id'];
        }

        foreach ($request['branches'] as $branch) {

            if ($request->parent_id != null) {
                $acc = $accounts->where('branch_id', $branch)->first();
                if ($acc != null) {
                    $account_type = $acc->account_type;
                    $parent_id = $acc->id;
                } else {
                    $account_type = null;
                    $parent_id = null;
                }
            }

            if ($account_type != null) {
                $account = Account::create([
                    'name_ar' => $request['name_ar'],
                    'name_en' => $request['name_en'],
                    'code' => $request['code'],
                    'parent_id' => $parent_id,
                    'account_type' => $account_type,
                    'branch_id' => $branch,
                    'created_by' => Auth::id(),
                ]);
            }
        }



        alertSuccess('account created successfully', 'تم إضافة الحساب بنجاح');
        return redirect()->route('accounts.index', ['parent_id' => request()->parent_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($account)
    {
        $account = account::findOrFail($account);
        return view('dashboard.accounts.edit ')->with('account', $account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, account $account)
    {


        if (!request()->has('parent_id')) {
            request()->merge(['parent_id' => null]);
        }

        $request->validate([
            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'code' => [
                'required',
                'string',
                Rule::unique('accounts')->where(function ($query) use ($account) {
                    return $query->where('branch_id', $account->branch_id);
                }),
            ],
        ]);

        $account->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'code' => $request['code'],
            'updated_by' => Auth::id(),
        ]);

        alertSuccess('account updated successfully', 'تم تعديل الحساب بنجاح');
        return redirect()->route('accounts.index', ['parent_id' => request()->parent_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($account)
    {
        $account = account::withTrashed()->where('id', $account)->first();
        if ($account->trashed() && auth()->user()->hasPermission('accounts-delete')) {
            $account->forceDelete();
            alertSuccess('account deleted successfully', 'تم حذف الحساب بنجاح');
            return redirect()->route('accounts.trashed');
        } elseif (!$account->trashed() && auth()->user()->hasPermission('accounts-trash') && checkAccountForTrash($account)) {
            $account->delete();
            alertSuccess('account trashed successfully', 'تم حذف الحساب مؤقتا');
            return redirect()->route('accounts.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the account cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو الحساب لا يمكن حذفه حاليا');
            return redirect()->back();
        }
    }

    public function trashed()
    {


        $branches = Branch::all();


        $accounts = Account::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenBranch(request()->branch_id)
            ->latest()
            ->paginate(100);
        return view('dashboard.accounts.index', compact('branches', 'accounts'));
    }

    public function restore($account, Request $request)
    {
        $account = account::withTrashed()->where('id', $account)->first()->restore();
        alertSuccess('account restored successfully', 'تم استعادة الحساب بنجاح');
        return redirect()->route('accounts.index');
    }
}
