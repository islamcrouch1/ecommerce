<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountingOperation;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountingOperationsController extends Controller
{

    public function index(Request $request)
    {

        $user = Auth::user();
        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        $operations = AccountingOperation::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->whenSearch(request()->search)
            ->whenBranch(request()->branch_id)
            ->latest()
            ->paginate(100);

        return view('dashboard.accounting_operations.index', compact('branches', 'operations'));
    }

    public function create()
    {
        return view('dashboard.accounting_operations.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'accounts' => "required|array",
            'cash' => "nullable|string",
            'bank' => "nullable|string",
            'check' => "nullable|string",
            'status' => "nullable|string",
        ]);

        // $branch_id = getUserBranchId(Auth::user());
        foreach ($request->accounts as $account_id) {
            $account = Account::findOrFail($account_id);
            $operation = AccountingOperation::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'cash' => $request->cash == 'on' ? 1 : 0,
                'bank' => $request->bank == 'on' ? 1 : 0,
                'check' => $request->check == 'on' ? 1 : 0,
                'status' => $request->status == 'on' ? 1 : 0,
                'branch_id' => $account->branch_id,
                'account_id' => $account->id,
            ]);
        }

        alertSuccess('accounting operation created successfully', 'تم إضافة اصل ثابت بنجاح');
        return redirect()->route('accounting_operations.index');
    }

    public function edit(AccountingOperation $accounting_operation)
    {
        return view('dashboard.accounting_operations.edit')->with('operation', $accounting_operation);
    }


    public function update(Request $request, AccountingOperation $accounting_operation)
    {
        $request->validate([
            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",
            'account' => "required|integer",
            'cash' => "nullable|string",
            'bank' => "nullable|string",
            'check' => "nullable|string",
            'status' => "nullable|string",
        ]);

        $account = Account::findOrFail($request->account);
        $accounting_operation->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'cash' => $request->cash == 'on' ? 1 : 0,
            'bank' => $request->bank == 'on' ? 1 : 0,
            'check' => $request->check == 'on' ? 1 : 0,
            'status' => $request->status == 'on' ? 1 : 0,
            'branch_id' => $account->branch_id,
            'account_id' => $account->id,
        ]);

        alertSuccess('accounting operation updated successfully', 'تم تعديل العملية المحاسبية بنجاح');
        return redirect()->route('accounting_operations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($operation)
    {
        $operation = AccountingOperation::withTrashed()->where('id', $operation)->first();
        if ($operation->trashed() && auth()->user()->hasPermission('accounting_operations-delete')) {
            $operation->forceDelete();
            alertSuccess('operation deleted successfully', 'تم حذف العملية المحاسبية بنجاح');
            return redirect()->route('accounting_operations.trashed');
        } elseif (!$operation->trashed() && auth()->user()->hasPermission('accounting_operations-trash')) {
            $operation->delete();
            alertSuccess('operation trashed successfully', 'تم حذف العملية المحاسبية مؤقتا');
            return redirect()->route('accounting_operations.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the operation cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو العملية المحاسبية لا يمكن حذفه حاليا');
            return redirect()->back()->withInput();
        }
    }

    public function trashed()
    {

        $user = Auth::user();
        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }
        $operations = AccountingOperation::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.accounting_operations.index', compact('branches', 'operations'));
    }

    public function restore($operation, Request $request)
    {
        $operation = AccountingOperation::withTrashed()->where('id', $operation)->first()->restore();
        alertSuccess('attribute restored successfully', 'تم استعادة العملية المحاسبية بنجاح');
        return redirect()->route('accounting_operations.index');
    }
}
