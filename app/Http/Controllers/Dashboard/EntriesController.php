<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Entry;
use App\Models\Order;
use App\Models\ProductCombination;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class EntriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:entries-read')->only('index', 'show');
        $this->middleware('permission:entries-create')->only('create', 'store');
        $this->middleware('permission:entries-update')->only('edit', 'update');
        $this->middleware('permission:entries-delete|entries-trash')->only('destroy', 'trashed');
        $this->middleware('permission:entries-restore')->only('restore');
        $this->middleware('permission:income_statement-read')->only('income');
    }

    public function index(Request $request)
    {


        if (!request()->has('account_id')) {
            request()->merge(['account_id' => null]);
            $accounts = [];
        } else {
            $account = Account::findOrFail(request()->account_id);
            $arrays = flatten($account->childrenRecursive()->get()->toArray());
            $accounts = [];
            foreach ($arrays as $array) {
                array_push($accounts, $array['id']);
            }
            array_push($accounts, request()->account_id);
        }

        $user = Auth::user();

        if ($user->hasPermission('branches-read')) {
            $branches = Branch::all();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $branch_id = getUserBranchId(Auth::user());


        $entries = Entry::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->when($accounts, function ($q) use ($accounts) {
                return $q->whereIn('account_id', $accounts);
            })
            ->whenBranch(request()->branch_id)
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);

        if (request()->has('account_id')) {
            $accounts = Account::whenParent(request()->account_id)
                ->get();
        }





        return view('dashboard.entries.index', compact('entries', 'accounts', 'branches'));
    }


    public function income(Request $request)
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

        if (isset(request()->branch_id)) {
            $branch_id = request()->branch_id;
        } else {
            $branch_id = getUserBranchId($user);
        }


        $revenue_account = Account::findOrFail(settingAccount('revenue_account',  $branch_id));
        $revenue = getTrialBalance($revenue_account->id, request()->from, request()->to);


        $cs_account = Account::findOrFail(settingAccount('cs_account',  $branch_id));
        $cs = getTrialBalance($cs_account->id, request()->from, request()->to);



        $expenses_accounts = Account::where('account_type', 'expenses')->where('parent_id', null)->where('branch_id', $branch_id)->get();
        $expenses_all = 0;

        foreach ($expenses_accounts as $account) {
            $expenses = getTrialBalance($account->id, request()->from, request()->to);
            $expenses_all +=  $expenses;
        }



        $orders = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whereNot(function ($query) {
                $query->where('order_from',  'addpurchase');
            })
            ->whenCountry(getDefaultCountry()->id)
            ->whenBranch($branch_id)
            ->whereNotIn('status', ['RTO', 'returned', 'canceled'])
            ->get();

        $services_cost = 0;

        foreach ($orders as $order) {

            $cost = 0;

            foreach ($order->products as $product) {
                if ($product->product_type == 'variable' || $product->product_type == 'simple') {

                    $cost += 0;
                } else {
                    $cost += $product->cost * $product->pivot->qty;
                }
            }

            $services_cost += $cost;
        }

        $gross_profit = $revenue - $expenses_all - $services_cost - $cs;



        $revenue_accounts = Account::where('account_type', 'revenue')->where('parent_id', null)->where('branch_id', $branch_id)->get();
        $revenue_all = 0;

        foreach ($revenue_accounts as $account) {
            $rev = getTrialBalance($account->id, request()->from, request()->to);
            $revenue_all +=  $rev;
        }

        $other_revenue = $revenue_all - $revenue;

        if ($gross_profit <= 0) {
            $income_tax = 0;
        } else {
            $income_tax = calcTax($gross_profit, 'income_tax');
        }


        $net_profit = $gross_profit - $income_tax;


        return view('dashboard.entries.income', compact('branches', 'revenue', 'expenses', 'services_cost', 'gross_profit',  'income_tax', 'net_profit', 'cs', 'expenses_accounts',  'expenses_all', 'other_revenue'));
    }

    public function balance(Request $request)
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

        $all_accounts = Account::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('parent_id', null)
            ->whereIn('account_type', ['assets', 'liability', 'expenses', 'revenue'])
            ->whenBranch(request()->branch_id)
            ->get();


        return view('dashboard.entries.balance', compact('all_accounts', 'branches'));
    }

    public function trial(Request $request)
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

        $all_accounts = Account::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
            ->where('parent_id', null)
            ->whereIn('account_type', ['assets', 'liability', 'expenses', 'revenue'])
            ->whenBranch(request()->branch_id)
            ->get();


        return view('dashboard.entries.trial', compact('all_accounts', 'branches'));
    }


    public function getSubAccounts(Request $request)
    {

        $account_id = $request->account_id;

        $account = Account::findOrFail($account_id);

        // if (Route::is('assets.purchase.create')) {
        //     $accounts = $account->accounts->where('type', '!=', 'accumulated_depreciation')->where('type', '!=', 'depreciation_expenses');
        // } else {
        //     $accounts = $account->accounts->where('type', '!=', 'accumulated_depreciation')->where('type', '!=', 'depreciation_expenses')->where('type', '!=', 'fixed_assets')->where('type', '!=', 'fixed_assets_net');
        // }


        $accounts = $account->accounts->where('type', '!=', 'accumulated_depreciation')->where('type', '!=', 'depreciation_expenses')->where('type', '!=', 'fixed_assets')->where('type', '!=', 'fixed_assets_net');



        $data = [];

        foreach ($accounts as $account) {
            $account->name = getName($account);
        }

        $data['status'] = 1;

        $data['elements'] = $accounts;

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $branch_id = getUserBranchId(Auth::user());
        $accounts = Account::whereNull('parent_id')->where('branch_id', $branch_id)->get();
        return view('dashboard.entries.create', compact('accounts'));
    }
    public function settleCreate()
    {

        $amount = getSettleAmount();

        if ($amount > 0) {
            $check = true;
        } else {
            $check = false;
        }

        $accounts = Account::whereNull('parent_id')
            ->where('account_type', 'assets')->get();
        return view('dashboard.entries.settle', compact('accounts', 'check', 'amount'));
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
            'accounts' => "required|array",
            'dr_amount' => "required|array",
            'cr_amount' => "required|array",
            'description' => "required|string",
        ]);

        $branch_id = getUserBranchId(Auth::user());


        $dr_amount = 0;
        $cr_amount = 0;

        foreach ($request->accounts as $index => $account) {

            if ($request->dr_amount[$index] == null || $request->cr_amount[$index] == null || $account == null) {
                alertError('some entries not valid', 'بعض المدخلات عير صحيحة');
                return redirect()->back();
            }

            $account = Account::findOrFail($account);

            if ($account->id == settingAccount('fixed_assets_account', $branch_id) || $account->id == settingAccount('dep_expenses_account', $branch_id)) {
                alertError('please go to non current assets section to handle this request', 'الرجاء الذهاب الى قسم ادارة الاصول الثابتة لمعالجة هذه العملية');
                return redirect()->back();
            }

            if ($request->dr_amount[$index] == 0 && $request->cr_amount[$index] == 0) {
                alertError('some entries not valid', 'بعض المدخلات عير صحيحة');
                return redirect()->back();
            }

            if ($request->dr_amount[$index] > 0 && $request->cr_amount[$index] > 0) {
                alertError('some entries not valid', 'بعض المدخلات عير صحيحة');
                return redirect()->back();
            }

            $dr_amount += $request->dr_amount[$index];
            $cr_amount += $request->cr_amount[$index];
        }

        if ($dr_amount - $cr_amount != 0) {
            alertError('entries not equal, this entry not correct please review it', 'القيود المدخلة غير متساوية , يرجى مراجعة قيم القيود مرة اخرى');
            return redirect()->back();
        }



        foreach ($request->accounts as $index => $account) {

            $acc = Account::findOrFail($account);

            if ($branch_id != null) {

                Entry::create([
                    'account_id' => $account,
                    'type' => 'entry',
                    'dr_amount' => $request->dr_amount[$index],
                    'cr_amount' => $request->cr_amount[$index],
                    'description' => $request->description,
                    'branch_id' => $branch_id,
                    'created_by' => Auth::id(),
                ]);
            }
        }

        alertSuccess('entry created successfully', 'تم إضافة قيد اليومية بنجاح');
        return redirect()->route('entries.index');
    }

    public function settleStore(Request $request)
    {

        $request->validate([
            'from_account' => "required|string|max:255",
            'amount' => "required|numeric",
            'description' => "required|string",
        ]);

        if ($request->amount <= 0) {
            alertError('please add the entry amount to add the entry', 'يرجى ادحال قيمة القيد لاستكمال العملية');
            return redirect()->back();
        }


        $amount = getSettleAmount();


        if ($request->amount != $amount) {
            alertError('please add suitable entry amount to add the entry', 'يرجى ادحال قيمة القيد بشكل صحيح لاستكمال العملية');
            return redirect()->back();
        }


        $from_account = Account::findOrFail($request->from_account);

        $dr_amount = 0;
        $cr_amount = 0;


        if ($from_account->account_type == 'assets' || $from_account->account_type == 'expenses') {
            $dr_amount = 0;
            $cr_amount = $request->amount;
        }

        Entry::create([
            'account_id' => $request->from_account,
            'type' => 'stockSettle',
            'dr_amount' => $dr_amount,
            'cr_amount' => $cr_amount,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);


        alertSuccess('entry created successfully', 'تم إضافة قيد اليومية بنجاح');
        return redirect()->route('entries.index');
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
    public function edit($entry)
    {
        $entry = Entry::findOrFail($entry);
        return view('dashboard.entries.edit ')->with('entry', $entry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, entry $entry)
    {
        $request->validate([
            'name' => "required|string|max:255",
            'description' => "required|string|max:255",
            'entry_rate' => "required|numeric",
        ]);

        $entry->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'entry_rate' => $request['entry_rate'],
            'updated_by' => Auth::id(),
        ]);

        alertSuccess('entry updated successfully', 'تم تعديل قيد اليومية بنجاح');
        return redirect()->route('entries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($entry)
    {
        $entry = Entry::withTrashed()->where('id', $entry)->first();
        if ($entry->trashed() && auth()->user()->hasPermission('entries-delete')) {
            $entry->forceDelete();
            alertSuccess('entry deleted successfully', 'تم حذف قيد اليومية بنجاح');
            return redirect()->route('entries.trashed');
        } elseif (!$entry->trashed() && auth()->user()->hasPermission('entries-trash') && checkentryForTrash($entry)) {
            $entry->delete();
            alertSuccess('entry trashed successfully', 'تم حذف قيد اليومية مؤقتا');
            return redirect()->route('entries.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the entry cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو قيد اليومية لا يمكن حذفه حاليا');
            return redirect()->back();
        }
    }

    public function trashed()
    {
        $entries = Entry::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.entries.index', ['entries' => $entries]);
    }

    public function restore($entry, Request $request)
    {
        $entry = Entry::withTrashed()->where('id', $entry)->first()->restore();
        alertSuccess('entry restored successfully', 'تم استعادة قيد اليومية بنجاح');
        return redirect()->route('entries.index');
    }
}
