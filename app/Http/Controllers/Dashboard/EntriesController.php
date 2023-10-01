<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountingOperation;
use App\Models\Branch;
use App\Models\Entry;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProductCombination;
use App\Models\SettlementSheet;
use App\Models\Tax;
use App\Models\User;
use App\Models\Withdrawal;
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
            $request->merge(['from' => Carbon::now()->toDateString()]);
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
            ->groupBy('description')
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
                $query->where('order_from',  'purchases');
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


        return view('dashboard.entries.income', compact('branches', 'cs_account', 'revenue_account', 'revenue', 'expenses', 'services_cost', 'gross_profit',  'income_tax', 'net_profit', 'cs', 'expenses_accounts',  'expenses_all', 'other_revenue'));
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
            ->whereIn('account_type', ['assets', 'liability'])
            // ->whereIn('account_type', ['assets', 'liability', 'expenses', 'revenue'])
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

    public function quickEntryCreate()
    {
        $branch_id = getUserBranchId(Auth::user());
        $operations = AccountingOperation::where('branch_id', $branch_id)->where('status', 1)->get();

        // $expenses_account = settingAccount('administrative_expense_account', $branch_id);

        $expenses_accounts = Account::whereNull('parent_id')->where('branch_id', $branch_id)->where('account_type', 'expenses')->get();

        // if ($expenses_account) {
        //     $expenses_accounts = Account::where('parent_id', $expenses_account)->where('branch_id', $branch_id)->get();
        // } else {
        //     $expenses_accounts = [];
        // }


        return view('dashboard.entries.quick_create', compact('operations', 'expenses_accounts'));
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
            'doc_num' => "nullable|integer",
            'image' => "nullable|image",
        ]);

        $branch_id = getUserBranchId(Auth::user());


        $dr_amount = 0;
        $cr_amount = 0;

        foreach ($request->accounts as $index => $account) {

            if ($request->dr_amount[$index] == null || $request->cr_amount[$index] == null || $account == null) {
                alertError('some entries not valid', 'بعض المدخلات غير صحيحة');
                return redirect()->back()->withInput();
            }

            $account = Account::findOrFail($account);

            if ($account->id == settingAccount('fixed_assets_account', $branch_id) || $account->id == settingAccount('dep_expenses_account', $branch_id)) {
                alertError('please go to fixed assets section to handle this request', 'الرجاء الذهاب الى قسم ادارة الاصول الثابتة لمعالجة هذه العملية');
                return redirect()->back()->withInput();
            }

            if ($request->dr_amount[$index] == 0 && $request->cr_amount[$index] == 0) {
                alertError('some entries not valid', 'بعض المدخلات غير صحيحة');
                return redirect()->back()->withInput();
            }

            if ($request->dr_amount[$index] > 0 && $request->cr_amount[$index] > 0) {
                alertError('some entries not valid', 'بعض المدخلات غير صحيحة');
                return redirect()->back()->withInput();
            }

            $dr_amount += $request->dr_amount[$index];
            $cr_amount += $request->cr_amount[$index];
        }

        if ($dr_amount - $cr_amount != 0) {
            alertError('entries not equal, this entry not correct please review it', 'القيود المدخلة غير متساوية , يرجى مراجعة قيم القيود مرة اخرى');
            return redirect()->back()->withInput();
        }


        if ($request->hasFile('image')) {
            $media_id = saveMedia('image', $request['image'], 'entries');
        } else {
            $media_id = null;
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
                    'media_id' => $media_id,
                    'doc_num' => $request->doc_num,
                    'created_by' => Auth::id(),
                ]);
            }
        }

        alertSuccess('entry created successfully', 'تم إضافة قيد اليومية بنجاح');
        return redirect()->route('entries.index');
    }

    public function quickEntrystore(Request $request)
    {



        if ($request->operation == 'salary_card_proof') {
            $request->validate([
                'operation' => "required|string",
                'operation_type' => "nullable|string",
                'description' => "nullable|string",
                'doc_num' => "nullable|integer",
                'image' => "nullable|image",
                'employees' => "nullable|array",
                'salary_cards' => "nullable|string",
            ]);
        } else {
            $request->validate([
                'operation' => "required|string",
                'type' => "required|string",
                'operation_type' => "nullable|string",
                'amount' => "nullable|numeric|gt:0",
                'account' => "required|integer",
                'description' => "nullable|string",
                'doc_num' => "nullable|integer",
                'image' => "nullable|image",
                'due_date' => "nullable|string",
                'fixed_asset' => "nullable|integer",
                'supplier' => "nullable|integer",
                'employee' => "nullable|integer",
                'order' => "nullable|integer",
                'withdrawal_id' => "nullable|integer",
            ]);
        }







        $branch_id = getUserBranchId(Auth::user());
        $amount = $request->amount;

        if ($request->operation != 'salary_card_proof') {
            $account = Account::findOrFail($request->account);
        }




        if ($request->operation != 'sell_fixed_assets' && $request->operation != 'purchase_fixed_assets' &&  $request->operation != 'payment_receipts_purchases' && $request->operation != 'receipts_sales' && $request->operation != 'pay_withdrawal_request' && $request->operation != 'employee_loan' && $request->operation != 'salary_card_proof' && $request->operation != 'salary_payment' && $request->operation != 'petty_cash'  && $request->operation != 'petty_cash_settlement') {
            $operation = AccountingOperation::findOrFail($request->operation);
            $operation_account = $operation->account;
            $description = '( ' . $operation->name_ar . ' - ' . $operation->name_en . ' )' . ' ' . $request->description;
        }

        if ($request->operation == 'sell_fixed_assets' || $request->operation == 'purchase_fixed_assets') {
            $asset_account = Account::findOrFail($request->fixed_asset);
        }

        if ($request->operation == 'employee_loan') {
            $employee = User::findOrFail($request->employee);

            if ($employee->hasRole('administrator')) {
                $operation_account = getItemAccount($employee->id, null, 'employee_loan_account', $branch_id);
                $description = getName($operation_account) . ' - ' . $request->description;
            } else {
                alertError('some entries not valid', 'بعض المدخلات غير صحيحة');
                return redirect()->back()->withInput();
            }
        }

        if ($request->operation == 'petty_cash' || $request->operation == 'petty_cash_settlement') {
            $employee = User::findOrFail($request->employee);

            if ($employee->hasRole('administrator')) {
                $operation_account = getItemAccount($employee->id, null, 'petty_cash_account', $branch_id);
                $description = getName($operation_account) . ' - ' . $request->description;
            } else {
                alertError('some entries not valid', 'بعض المدخلات غير صحيحة');
                return redirect()->back()->withInput();
            }
        }



        if ($request->operation == 'payment_receipts_purchases' || $request->operation == 'receipts_sales') {
            $invoice = Invoice::findOrFail($request->order);
        }


        $date = Carbon::now();


        if (($request->type == 'receipt_notes' || $request->type == 'payment_notes') && $request->due_date == null) {
            alertError('Please select the check due date', 'يرجى تحديد تاريخ استحقاق الشيك');
            return redirect()->back()->withInput();
        }

        if (($request->operation != 'pay_withdrawal_request' && $request->operation != 'petty_cash_settlement') && !isset($request->operation_type)) {
            alertError('Please select the operation type to complete the process', 'يرجى تحديد نوع العملية لاتمام العملية');
            return redirect()->back()->withInput();
        }

        if (($request->operation != 'pay_withdrawal_request' && $request->operation != 'salary_card_proof' && $request->operation != 'salary_payment' && $request->operation != 'petty_cash_settlement') && !isset($request->amount)) {
            alertError('Please enter the amount to complete the process', 'يرجى ادخال المبلغ لاتمام العملية');
            return redirect()->back()->withInput();
        }

        if (($request->operation == 'pay_withdrawal_request') && ($request->type == 'receipt_notes' || $request->type == 'deferred_suppliers')) {
            alertError('Please select the appropriate account type for the transaction', 'يرجى تحديد نوع الحساب المناسب للعملية');
            return redirect()->back()->withInput();
        }

        if (($request->operation == 'employee_loan' || $request->operation == 'salary_card_proof' || $request->operation == 'salary_payment'  || $request->operation == 'petty_cash') && ($request->type == 'deferred_suppliers')) {
            alertError('Please select the appropriate account type for the transaction', 'يرجى تحديد نوع الحساب المناسب للعملية');
            return redirect()->back()->withInput();
        }


        if (($request->operation == 'petty_cash_settlement') && ($request->type == 'deferred_suppliers' || $request->type == 'payment_notes')) {
            alertError('Please select the appropriate account type for the transaction', 'يرجى تحديد نوع الحساب المناسب للعملية');
            return redirect()->back()->withInput();
        }


        if (($request->operation == 'petty_cash_settlement') && (($request->expenses_accounts == null) || ($request->expenses_amounts == null) || (!is_array($request->expenses_accounts)) || (!is_array($request->expenses_amounts)))) {
            alertError('please select expenses account to settle the petty cash', 'يرجة تحديد حسابات المصاريف لتسوية العهدة');
            return redirect()->back()->withInput();
        }


        if (($request->operation == 'petty_cash_settlement')) {
            if (is_array($request->expenses_amounts)) {
                foreach ($request->expenses_amounts as $expenses_amount) {
                    if ($expenses_amount == null || $expenses_amount <= 0) {
                        alertError('Please enter the expense amount for each expense account', 'يرجى ادخال مبلغ المصروف لكل حساب مصاريف');
                        return redirect()->back()->withInput();
                    }
                }
            }
        }


        if (($request->operation_type == 'in') && ($request->type == 'payment_notes')) {
            alertError('some entries not valid', 'بعض المدخلات غير صحيحة');
            return redirect()->back()->withInput();
        }

        if (($request->operation_type == 'out') && ($request->type == 'receipt_notes')) {
            alertError('some entries not valid', 'بعض المدخلات غير صحيحة');
            return redirect()->back()->withInput();
        }

        if (isset($request->due_date) && ($request->due_date < $date)) {
            alertError('The check due date is invalid', 'تاريخ استحقاق الشيك غير مناسب');
            return redirect()->back()->withInput();
        }


        if ($request->hasFile('image')) {
            $media_id = saveMedia('image', $request['image'], 'entries');
        } else {
            $media_id = null;
        }

        if ($request->operation == 'purchase_fixed_assets' && $request->operation_type == 'in') {
            alertError('some entries not valid', 'بعض المدخلات غير صحيحة');
            return redirect()->back()->withInput();
        }

        if ($request->operation == 'sell_fixed_assets' && $request->operation_type == 'out') {
            alertError('some entries not valid', 'بعض المدخلات غير صحيحة');
            return redirect()->back()->withInput();
        }


        if ($branch_id != null) {

            if ($request->operation == 'purchase_fixed_assets' && $asset_account != null && $asset_account->type == 'fixed_assets') {

                Entry::create([
                    'account_id' => $asset_account->id,
                    'type' => 'purchaseAsset',
                    'dr_amount' => $amount,
                    'cr_amount' => 0,
                    'description' => 'purchase fixed assets' . ' - ' . 'شراء اصل ثابت' . ' - ' . getName($account),
                    'branch_id' => $branch_id,
                    'media_id' => $media_id,
                    'doc_num' => $request->doc_num,
                    'created_by' => Auth::id(),
                ]);


                Entry::create([
                    'account_id' => $account->id,
                    'type' => 'purchaseAsset',
                    'dr_amount' => 0,
                    'cr_amount' => $amount,
                    'description' => 'purchase fixed assets' . ' - ' . 'شراء اصل ثابت' . ' - ' . getName($account),
                    'branch_id' => $branch_id,
                    'media_id' => $media_id,
                    'doc_num' => $request->doc_num,
                    'created_by' => Auth::id(),
                    'due_date' => ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null,
                ]);


                $dep_rate = $asset_account->dep_rate;
                $acc_dep_account = getAccu($asset_account);
                $dep_exp_account = getDep($asset_account);




                $mounth_rate = $dep_rate / 12;


                if ($dep_rate <= 0) {
                    $months = 0;
                } else {
                    $months = (100 / $dep_rate) * 12;
                }

                if ($amount > 0) {

                    $dep_amount_per_mounth = ($amount / $months);
                    $asset_value = $amount;
                    $date = Carbon::now();
                    // $date = $date->subMonth();


                    for ($i = $months; $i > 0; $i--) {

                        $date = $date->addMonth();
                        $asset_value = $asset_value - $dep_amount_per_mounth;


                        Entry::create([
                            'account_id' => $acc_dep_account->id,
                            'type' => 'accumulatedDepreciation',
                            'dr_amount' => 0,
                            'cr_amount' => $dep_amount_per_mounth,
                            'description' => 'accumulated depreciation',
                            'branch_id' => $branch_id,
                            'created_by' => Auth::id(),
                            'media_id' => $media_id,
                            'doc_num' => $request->doc_num,
                            'created_at' => $date->toDateString()
                        ]);

                        Entry::create([
                            'account_id' => $dep_exp_account->id,
                            'type' => 'depreciationExpenses',
                            'dr_amount' => $dep_amount_per_mounth,
                            'cr_amount' => 0,
                            'description' => 'depreciation expenses',
                            'branch_id' => $branch_id,
                            'created_by' => Auth::id(),
                            'media_id' => $media_id,
                            'doc_num' => $request->doc_num,
                            'created_at' => $date->toDateString()
                        ]);
                    }
                }
            } elseif ($request->operation == 'sell_fixed_assets' && $asset_account != null && $asset_account->type == 'fixed_assets') {

                if (settingAccount('fixed_assets_account', $branch_id) == null) {
                    alertError('please select the default fixed assets account in settings page', 'الرجاء تحديد حساب الأصول الثابتة الافتراضية في صفحة الإعدادات');
                    return redirect()->back()->withInput();
                }

                if (settingAccount('dep_expenses_account', $branch_id) == null) {
                    alertError('please select the default depreciation expenses account in settings page', 'الرجاء تحديد حساب مصاريف الاهلاك الافتراضية في صفحة الإعدادات');
                    return redirect()->back()->withInput();
                }


                if (settingAccount('revenue_account', $branch_id) == null) {
                    alertError('please select the default revenue account in settings page', 'الرجاء تحديد حساب الايرادات الافتراضية في صفحة الإعدادات');
                    return redirect()->back()->withInput();
                }

                if (settingAccount('expenses_account', $branch_id) == null) {
                    alertError('please select the default expenses account in settings page', 'الرجاء تحديد حساب المصروفات الافتراضية في صفحة الإعدادات');
                    return redirect()->back()->withInput();
                }

                $fixed_assets_account = Account::findOrFail(settingAccount('fixed_assets_account', $branch_id));
                $dep_expenses_account = Account::findOrFail(settingAccount('dep_expenses_account', $branch_id));
                $revenue_account = Account::findOrFail(settingAccount('revenue_account', $branch_id));
                $expenses_account = Account::findOrFail(settingAccount('expenses_account', $branch_id));

                $price = $request->amount;
                $cash_account = $account;
                $account = $asset_account;

                $asset = getTrialBalance($account->id);

                if ($asset <= 0) {
                    alertError('the asset doas not have net value to sell it now please review your data and try again later', 'لا توجد قيمة دفترية للاصل لبيعها يرجى مراجعة الادخال والمحاولة مرة اخرى');
                    return redirect()->back()->withInput();
                }


                $acc_account = getAccu($account);
                $dep_account = getDep($account);


                $date = Carbon::now();
                $date = $date->addDay();
                $date = $date->toDateString();


                $acc_balance = getTrialBalance($acc_account->id, request()->from, request()->to);
                $net_value = $asset + $acc_balance;
                $value = $price - $net_value;


                $revenue_assets = Account::where('reference_id', $revenue_account->id)->where('type', 'revenue_assets')->first();

                if ($revenue_assets == null) {

                    $last_account = $revenue_account->accounts->last();

                    if ($last_account == null) {
                        $last_code = $revenue_account->code . '01';
                    } else {
                        $last_code = $last_account->code + 1;
                    }

                    $revenue_assets = Account::create([
                        'name_ar' => 'ايرادات ناتجة عن بيع الاصول الثابتة',
                        'name_en' => 'revenue generated by sell fixed assets',
                        'code' => $last_code,
                        'parent_id' => $revenue_account->id,
                        'account_type' => $revenue_account->account_type,
                        'reference_id' =>  $revenue_account->id,
                        'type' => 'revenue_assets',
                        'branch_id' => $branch_id,
                        'created_by' => Auth::id(),
                    ]);
                }

                $revenue_asset = Account::where('reference_id', $account->id)->where('type', 'revenue_asset')->where('parent_id', $revenue_assets->id)->first();

                if ($revenue_asset == null) {

                    $last_account = $revenue_assets->accounts->last();

                    if ($last_account == null) {
                        $last_code = $revenue_assets->code . '01';
                    } else {
                        $last_code = $last_account->code + 1;
                    }

                    $revenue_asset = Account::create([
                        'name_ar' => 'حساب ايراد' . ' - ' . getName($account),
                        'name_en' => 'revenue account', ' - ' . getName($account),
                        'code' => $last_code,
                        'parent_id' => $revenue_assets->id,
                        'account_type' => $revenue_assets->account_type,
                        'reference_id' =>  $account->id,
                        'type' => 'revenue_asset',
                        'branch_id' => $branch_id,
                        'created_by' => Auth::id(),
                    ]);
                }


                $expenses_assets = Account::where('reference_id', $expenses_account->id)->where('type', 'expenses_assets')->first();

                if ($expenses_assets == null) {

                    $last_account = $expenses_account->accounts->last();

                    if ($last_account == null) {
                        $last_code = $expenses_account->code . '01';
                    } else {
                        $last_code = $last_account->code + 1;
                    }

                    $expenses_assets = Account::create([
                        'name_ar' => 'خسائر ناتجة عن بيع الاصول الثابتة',
                        'name_en' => 'losses generated by sell fixed assets',
                        'code' => $last_code,
                        'parent_id' => $expenses_account->id,
                        'account_type' => $expenses_account->account_type,
                        'reference_id' =>  $expenses_account->id,
                        'type' => 'expenses_assets',
                        'branch_id' => $branch_id,
                        'created_by' => Auth::id(),
                    ]);
                }

                $expenses_asset = Account::where('reference_id', $account->id)->where('type', 'expenses_asset')->where('parent_id', $expenses_assets->id)->first();

                if ($expenses_asset == null) {

                    $last_account = $expenses_assets->accounts->last();

                    if ($last_account == null) {
                        $last_code = $expenses_assets->code . '01';
                    } else {
                        $last_code = $last_account->code + 1;
                    }

                    $expenses_asset = Account::create([
                        'name_ar' => 'حساب خسائر' . ' - ' . getName($account),
                        'name_en' => 'losses account', ' - ' . getName($account),
                        'code' => $last_code,
                        'parent_id' => $expenses_assets->id,
                        'account_type' => $expenses_assets->account_type,
                        'reference_id' =>  $account->id,
                        'type' => 'expenses_asset',
                        'branch_id' => $branch_id,
                        'created_by' => Auth::id(),
                    ]);
                }


                if ($request->hasFile('image')) {
                    $media_id = saveMedia('image', $request['image'], 'entries');
                } else {
                    $media_id = null;
                }

                if ($value > 0) {

                    Entry::create([
                        'account_id' => $account->id,
                        'type' => 'sellAsset',
                        'dr_amount' => 0,
                        'cr_amount' => $asset,
                        'description' => 'sell fixed assets' . ' - ' . 'بيع اصل ثابت' . ' - ' . getName($account),
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'created_by' => Auth::id(),
                    ]);

                    Entry::create([
                        'account_id' => $revenue_asset->id,
                        'type' => 'sellAsset',
                        'dr_amount' => 0,
                        'cr_amount' => $value,
                        'description' => 'sell fixed assets' . ' - ' . 'بيع اصل ثابت' . ' - ' . getName($account),
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'created_by' => Auth::id(),
                    ]);


                    if (abs($acc_balance) > 0) {

                        Entry::create([
                            'account_id' => $acc_account->id,
                            'type' => 'sellAsset',
                            'dr_amount' => abs($acc_balance),
                            'cr_amount' => 0,
                            'description' => 'sell fixed assets' . ' - ' . 'بيع اصل ثابت' . ' - ' . getName($account),
                            'branch_id' => $branch_id,
                            'media_id' => $media_id,
                            'doc_num' => $request->doc_num,
                            'created_by' => Auth::id(),
                        ]);
                    }


                    Entry::create([
                        'account_id' => $cash_account->id,
                        'type' => 'sellAsset',
                        'dr_amount' => $asset + $value + $acc_balance,
                        'cr_amount' => 0,
                        'description' => 'sell fixed assets' . ' - ' . 'بيع اصل ثابت' . ' - ' . getName($account),
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'created_by' => Auth::id(),
                        'due_date' => ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null,
                    ]);
                }

                if ($value == 0) {

                    Entry::create([
                        'account_id' => $account->id,
                        'type' => 'sellAsset',
                        'dr_amount' => 0,
                        'cr_amount' => $asset,
                        'description' => 'sell fixed assets' . ' - ' . 'بيع اصل ثابت' . ' - ' . getName($account),
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'created_by' => Auth::id(),
                    ]);

                    if (abs($acc_balance) > 0) {

                        Entry::create([
                            'account_id' => $acc_account->id,
                            'type' => 'sellAsset',
                            'dr_amount' => abs($acc_balance),
                            'cr_amount' => 0,
                            'description' => 'sell fixed assets' . ' - ' . 'بيع اصل ثابت' . ' - ' . getName($account),
                            'branch_id' => $branch_id,
                            'media_id' => $media_id,
                            'doc_num' => $request->doc_num,
                            'created_by' => Auth::id(),
                        ]);
                    }

                    Entry::create([
                        'account_id' => $cash_account->id,
                        'type' => 'sellAsset',
                        'dr_amount' => $asset + $value + $acc_balance,
                        'cr_amount' => 0,
                        'description' => 'sell fixed assets' . ' - ' . 'بيع اصل ثابت' . ' - ' . getName($account),
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'created_by' => Auth::id(),
                        'due_date' => ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null,
                    ]);
                }

                if ($value < 0) {

                    Entry::create([
                        'account_id' => $account->id,
                        'type' => 'sellAsset',
                        'dr_amount' => 0,
                        'cr_amount' => $asset,
                        'description' => 'sell fixed assets' . ' - ' . 'بيع اصل ثابت' . ' - ' . getName($account),
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'created_by' => Auth::id(),
                    ]);


                    Entry::create([
                        'account_id' => $cash_account->id,
                        'type' => 'sellAsset',
                        'dr_amount' => $asset + $value + $acc_balance,
                        'cr_amount' => 0,
                        'description' => 'sell fixed assets' . ' - ' . 'بيع اصل ثابت' . ' - ' . getName($account),
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'created_by' => Auth::id(),
                        'due_date' => ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null,
                    ]);

                    if (abs($acc_balance) > 0) {

                        Entry::create([
                            'account_id' => $acc_account->id,
                            'type' => 'sellAsset',
                            'dr_amount' => abs($acc_balance),
                            'cr_amount' => 0,
                            'description' => 'sell fixed assets' . ' - ' . 'بيع اصل ثابت' . ' - ' . getName($account),
                            'branch_id' => $branch_id,
                            'media_id' => $media_id,
                            'doc_num' => $request->doc_num,
                            'created_by' => Auth::id(),
                        ]);
                    }

                    Entry::create([
                        'account_id' => $expenses_asset->id,
                        'type' => 'sellAsset',
                        'dr_amount' => abs($value),
                        'cr_amount' => 0,
                        'description' => 'sell fixed assets' . ' - ' . 'بيع اصل ثابت' . ' - ' . getName($account),
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'created_by' => Auth::id(),
                    ]);
                }




                $entries_acc =  $acc_account->entries->where('created_at', '>', $date);
                $entries_dep =  $dep_account->entries->where('created_at', '>', $date);

                foreach ($entries_acc as $entry) {
                    $entry->forceDelete();
                }

                foreach ($entries_dep as $entry) {
                    $entry->forceDelete();
                }
            } elseif ($request->operation == 'payment_receipts_purchases' || $request->operation == 'receipts_sales') {




                $branch_id = $invoice->branch_id;
                $cach_account = $account;

                if ($request->operation_type == 'out') {
                    $amount = $amount * (-1);
                }


                if ($cach_account->branch_id != $branch_id) {
                    alertError('error happen in branches', 'حدث خطا في معالجة الفروع');
                    return redirect()->back()->withInput();
                }


                $order_from = $invoice->order->order_from;
                $user = User::findOrFail($invoice->customer_id);

                $total_amount =  getInvoiceTotalAmount($invoice);
                $return_amount = getInvoiceTotalReturns($invoice);
                $payments_amount = getInvoiceTotalPayments($invoice);
                $remain_amount = $total_amount - ($payments_amount - $return_amount);




                if ($amount == 0) {
                    alertError('please enter the amount to complete the request', 'يرجى اضافة المبلغ لاكمال العملية');
                    return redirect()->back()->withInput();
                }

                if ($cach_account->id == settingAccount('fixed_assets_account', $branch_id) || $cach_account->id == settingAccount('dep_expenses_account', $branch_id)) {
                    alertError('please go to non current assets section to handle this request', 'الرجاء الذهاب الى قسم ادارة الاصول الثابتة لمعالجة هذه العملية');
                    return redirect()->back()->withInput();
                }

                if ((($invoice->status == 'invoice' || $invoice->status == 'debit_note')  && $amount > 0) || (($invoice->status == 'bill' || $invoice->status == 'credit_note') && $amount < 0)) {
                    if ((abs($amount) >  $total_amount) || (abs($amount) > $remain_amount)) {
                        alertError('the amount is greater than the total amount due', 'المبلغ المدخل اكثر من المبلغ المطلوب للعملية يرجى مراجعة الادخالات');
                        return redirect()->back()->withInput();
                    }
                }


                if ((($invoice->status == 'invoice' || $invoice->status == 'debit_note')  && $amount < 0) || (($invoice->status == 'bill' || $invoice->status == 'credit_note') && $amount > 0)) {
                    if (abs($amount) >  $payments_amount) {
                        alertError('The refund amount is greater than the previously paid amount', 'المبلغ المسترجع اكبر من المبلغ المدفوع سابقا');
                        return redirect()->back()->withInput();
                    }
                }




                if ($order_from == 'purchases') {
                    $account = getItemAccount($invoice->customer_id, null, 'suppliers_account', $branch_id);

                    if ($amount < 0) {

                        $payment = Payment::create([
                            'order_id' => $invoice->order_id,
                            'invoice_id' => $invoice->id,
                            'user_id' => $user->id,
                            'branch_id' => $branch_id,
                            'from_account' => $cach_account->id,
                            'to_account' => $account->id,
                            'type' => 'purchases',
                            'amount' => $amount,
                            'currency_id' => $invoice->currency_id,
                            'created_by' => Auth::id(),
                        ]);


                        createEntry($account, 'pay_purchase', abs($amount), 0, $branch_id, $invoice, null, $invoice->currency->id);
                        createEntry($cach_account, 'pay_purchase', 0, abs($amount), $branch_id, $invoice, ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null, null, $invoice->currency->id);
                    }

                    if ($amount > 0) {

                        $payment = Payment::create([
                            'order_id' => $invoice->order_id,
                            'invoice_id' => $invoice->id,
                            'user_id' => $user->id,
                            'branch_id' => $branch_id,
                            'from_account' => $account->id,
                            'to_account' => $cach_account->id,
                            'type' => 'purchases',
                            'amount' => $amount,
                            'currency_id' => $invoice->currency_id,
                            'created_by' => Auth::id(),
                        ]);

                        createEntry($account, 'pay_purchase', 0, abs($amount), $branch_id, $invoice, null, $invoice->currency->id);
                        createEntry($cach_account, 'pay_purchase', abs($amount), 0, $branch_id, $invoice, ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null, null, $invoice->currency->id);
                    }
                }

                if ($order_from == 'sales') {


                    $account = getItemAccount($invoice->customer_id, null, 'customers_account', $branch_id);

                    if ($amount > 0) {

                        $payment = Payment::create([
                            'order_id' => $invoice->order_id,
                            'invoice_id' => $invoice->id,
                            'user_id' => $user->id,
                            'branch_id' => $branch_id,
                            'from_account' => $account->id,
                            'to_account' => $cach_account->id,
                            'type' => 'sales',
                            'amount' => $amount,
                            'currency_id' => $invoice->currency_id,
                            'created_by' => Auth::id(),
                        ]);

                        createEntry($account, 'pay_sales', 0, abs($amount), $branch_id, $invoice, null, $invoice->currency->id);
                        createEntry($cach_account, 'pay_sales', abs($amount), 0, $branch_id, $invoice, ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null, null, $invoice->currency->id);
                    }

                    if ($amount < 0) {

                        $payment = Payment::create([
                            'order_id' => $invoice->order_id,
                            'invoice_id' => $invoice->id,
                            'user_id' => $user->id,
                            'branch_id' => $branch_id,
                            'from_account' => $cach_account->id,
                            'to_account' => $account->id,
                            'type' => 'sales',
                            'amount' => $amount,
                            'currency_id' => $invoice->currency_id,
                            'created_by' => Auth::id(),
                        ]);

                        createEntry($account, 'pay_sales', abs($amount), 0, $branch_id, $invoice, null, $invoice->currency->id);
                        createEntry($cach_account, 'pay_sales', 0, abs($amount), $branch_id, $invoice, ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null, null, $invoice->currency->id);
                    }
                }

                getInvoicePaymentStatus($invoice);
            } elseif ($request->operation == 'pay_withdrawal_request' && $request->withdrawal_id != null) {

                $withdrawal = Withdrawal::findOrFail($request->withdrawal_id);

                $withdrawal->update([
                    'status' => 'confirmed',
                ]);

                $user = User::findOrFail($withdrawal->user_id);

                if ($user->hasRole('vendor')) {


                    $branch_id = setting('website_branch');
                    $supplier_account = getItemAccount($user->id, null, 'suppliers_account', $branch_id);

                    Entry::create([
                        'account_id' => $supplier_account->id,
                        'type' => 'withdrawal',
                        'dr_amount' => $withdrawal->amount,
                        'cr_amount' => 0,
                        'description' => 'withdrawal request# ' . $withdrawal->id,
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'reference_id' => $withdrawal->id,
                        'created_by' => Auth::check() ? Auth::id() : null,
                    ]);

                    Entry::create([
                        'account_id' => $account->id,
                        'type' => 'withdrawal',
                        'dr_amount' => 0,
                        'cr_amount' => $withdrawal->amount,
                        'description' => 'withdrawal request# ' . $withdrawal->id,
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'reference_id' => $withdrawal->id,
                        'created_by' => Auth::check() ? Auth::id() : null,
                    ]);
                }

                changePendingWithdrawalBalance($user, $withdrawal->amount, 0, null, 'sub');
                changeCompletedWithdrawalBalance($user, $withdrawal->amount, 0, null, 'add');
            } elseif ($request->operation == 'salary_card_proof') {


                $users = $request->employees;
                $date = $request->salary_cards;
                $description = $request->description;



                foreach ($users as $user) {
                    $user = User::findOrFail($user);

                    $salary_card = getSalaryCard($user, $date);

                    if (
                        $user->hasRole('administrator')
                        && $salary_card && ($salary_card->status == 'unconfirmed' || $salary_card->status == 'confirmed')
                        && (($salary_card->status == 'confirmed' && $request->operation_type == 'in') || ($salary_card->status == 'unconfirmed' && $request->operation_type == 'out'))
                    ) {

                        $salaries_account = Account::findOrFail(settingAccount('salaries_accounts', $branch_id));
                        $staff_account = getItemAccount($user->id, null, 'staff_receivables_account', $branch_id);


                        if (($salary_card->basic_salary + $salary_card->variable_salary) > 0) {

                            Entry::create([
                                'account_id' => $salaries_account->id,
                                'type' => 'entitlement_entry',
                                'dr_amount' => $request->operation_type == 'out' ? ($salary_card->basic_salary + $salary_card->variable_salary) : 0,
                                'cr_amount' => $request->operation_type == 'in' ? ($salary_card->basic_salary + $salary_card->variable_salary) : 0,
                                'description' => __('proof of entitlement to salary') . ' - ' . $date .  ' - ' . $description,
                                'branch_id' => $branch_id,
                                'media_id' => $media_id,
                                'doc_num' => $request->doc_num,
                                'created_by' => Auth::id(),
                            ]);

                            Entry::create([
                                'account_id' => $staff_account->id,
                                'type' => 'entitlement_entry',
                                'dr_amount' => $request->operation_type == 'in' ? ($salary_card->basic_salary + $salary_card->variable_salary) : 0,
                                'cr_amount' => $request->operation_type == 'out' ? ($salary_card->basic_salary + $salary_card->variable_salary) : 0,
                                'description' => __('proof of entitlement to salary') . ' - ' . $date .  ' - ' . $description,
                                'branch_id' => $branch_id,
                                'media_id' => $media_id,
                                'doc_num' => $request->doc_num,
                                'created_by' => Auth::id(),
                            ]);
                        }

                        if ($salary_card->total_deduction > 0) {


                            Entry::create([
                                'account_id' => $staff_account->id,
                                'type' => 'deduction_entry',
                                'dr_amount' => $request->operation_type == 'out' ? $salary_card->total_deduction : 0,
                                'cr_amount' => $request->operation_type == 'in' ? $salary_card->total_deduction : 0,
                                'description' => __('proof of deduction') . ' - ' . $date .  ' - '  . $description,
                                'branch_id' => $branch_id,
                                'media_id' => $media_id,
                                'doc_num' => $request->doc_num,
                                'created_by' => Auth::id(),
                            ]);


                            if ($salary_card->insurance > 0) {

                                $insurance_account = Account::findOrFail(settingAccount('social_insurance_account', $branch_id));

                                Entry::create([
                                    'account_id' => $insurance_account->id,
                                    'type' => 'deduction_entry',
                                    'dr_amount' => $request->operation_type == 'in' ? $salary_card->insurance : 0,
                                    'cr_amount' => $request->operation_type == 'out' ? $salary_card->insurance : 0,
                                    'description' => __('proof of deduction') . ' - ' . $date .  ' - ' . $description,
                                    'branch_id' => $branch_id,
                                    'media_id' => $media_id,
                                    'doc_num' => $request->doc_num,
                                    'created_by' => Auth::id(),
                                ]);
                            }


                            if ($salary_card->loans > 0) {

                                $loans_account = getItemAccount($user->id, null, 'employee_loan_account', $branch_id);

                                Entry::create([
                                    'account_id' => $loans_account->id,
                                    'type' => 'deduction_entry',
                                    'dr_amount' => $request->operation_type == 'in' ? $salary_card->loans : 0,
                                    'cr_amount' => $request->operation_type == 'out' ? $salary_card->loans : 0,
                                    'description' => __('proof of deduction') . ' - ' . $date .  ' - ' . $description,
                                    'branch_id' => $branch_id,
                                    'media_id' => $media_id,
                                    'doc_num' => $request->doc_num,
                                    'created_by' => Auth::id(),
                                ]);
                            }


                            if (($salary_card->penalties + $salary_card->total_absence) > 0) {

                                $penalties_account = Account::findOrFail(settingAccount('other_revenue_account', $branch_id));

                                Entry::create([
                                    'account_id' => $penalties_account->id,
                                    'type' => 'deduction_entry',
                                    'dr_amount' => $request->operation_type == 'in' ? ($salary_card->penalties + $salary_card->total_absence) : 0,
                                    'cr_amount' => $request->operation_type == 'out' ? ($salary_card->penalties + $salary_card->total_absence) : 0,
                                    'description' => __('proof of deduction') . ' - ' . $date .  ' - ' . $description,
                                    'branch_id' => $branch_id,
                                    'media_id' => $media_id,
                                    'doc_num' => $request->doc_num,
                                    'created_by' => Auth::id(),
                                ]);
                            }
                        }

                        if ($salary_card->rewards > 0) {


                            Entry::create([
                                'account_id' => $salaries_account->id,
                                'type' => 'entitlement_entry',
                                'dr_amount' => $request->operation_type == 'out' ? $salary_card->rewards : 0,
                                'cr_amount' => $request->operation_type == 'in' ? $salary_card->rewards : 0,
                                'description' => __('proof of rewards') . ' - ' . $date .  ' - ' . $description,
                                'branch_id' => $branch_id,
                                'media_id' => $media_id,
                                'doc_num' => $request->doc_num,
                                'created_by' => Auth::id(),
                            ]);


                            Entry::create([
                                'account_id' => $staff_account->id,
                                'type' => 'entitlement_entry',
                                'dr_amount' => $request->operation_type == 'in' ? $salary_card->rewards : 0,
                                'cr_amount' => $request->operation_type == 'out' ? $salary_card->rewards : 0,
                                'description' => __('proof of rewards') . ' - ' . $date .  ' - ' . $description,
                                'branch_id' => $branch_id,
                                'media_id' => $media_id,
                                'doc_num' => $request->doc_num,
                                'created_by' => Auth::id(),
                            ]);
                        }

                        $salary_card->update([
                            'status' => $request->operation_type == 'out' ?  'confirmed' : 'unconfirmed',
                        ]);
                    } else {
                        alertError('some entries not valid', 'بعض المدخلات غير صحيحة');
                        return redirect()->back()->withInput();
                    }
                }
            } elseif ($request->operation == 'salary_payment') {


                $users = $request->employees;
                $date = $request->salary;
                $description = $request->description;



                foreach ($users as $user) {
                    $user = User::findOrFail($user);
                    $salary_card = getSalaryCard($user, $date);


                    if (
                        $user->hasRole('administrator')
                        && $salary_card
                        && (($salary_card->status == 'paid' || $salary_card->status == 'confirmed') || ($salary_card->status == 'paid' && $request->operation_type == 'in') && ($salary_card->status == 'confirmed' && $request->operation_type == 'out'))
                    ) {

                        $staff_account = getItemAccount($user->id, null, 'staff_receivables_account', $branch_id);


                        if (($salary_card->net_salary) > 0) {

                            Entry::create([
                                'account_id' => $account->id,
                                'type' => 'entitlement_entry',
                                'dr_amount' => $request->operation_type == 'in' ? ($salary_card->net_salary) : 0,
                                'cr_amount' => $request->operation_type == 'out' ? ($salary_card->net_salary) : 0,
                                'description' => __('Payment of salary to employees') . ' - ' . $date .  ' - ' . $description,
                                'branch_id' => $branch_id,
                                'media_id' => $media_id,
                                'doc_num' => $request->doc_num,
                                'created_by' => Auth::id(),
                            ]);

                            Entry::create([
                                'account_id' => $staff_account->id,
                                'type' => 'entitlement_entry',
                                'dr_amount' => $request->operation_type == 'out' ? ($salary_card->net_salary) : 0,
                                'cr_amount' => $request->operation_type == 'in' ? ($salary_card->net_salary) : 0,
                                'description' => __('Payment of salary to employees') . ' - ' . $date .  ' - ' . $description,
                                'branch_id' => $branch_id,
                                'media_id' => $media_id,
                                'doc_num' => $request->doc_num,
                                'created_by' => Auth::id(),
                            ]);
                        }



                        $salary_card->update([
                            'status' => $request->operation_type == 'out' ?  'paid' : 'confirmed',
                        ]);
                    } else {
                        alertError('some entries not valid', 'بعض المدخلات غير صحيحة');
                        return redirect()->back()->withInput();
                    }
                }
            } elseif ($request->operation == 'petty_cash_settlement') {



                $user = $employee;


                $sheets = SettlementSheet::where('user_id', $user->id)
                    ->whereNotNull('admin_id')
                    ->where('status', 'pending')
                    ->get();

                $remaining = 0;
                $records = 0;
                $total_expenses_amount_per_account = 0;

                foreach ($sheets as $sheet) {
                    $records_amount = getSettlementAmountForSheet($sheet);
                    $remainig_amount = $sheet->amount - $records_amount;
                    $remaining += $remainig_amount;
                    $records += $records_amount;
                }

                $petty_cash_account = getItemAccount($user->id, null, 'petty_cash_account', $user->branch_id);
                $total_petty_amount = getTrialBalance($petty_cash_account->id, null, null);
                $total_sheets_amount = getSettlementAmount($user);

                $total_remaining_amount = ($total_petty_amount - $total_sheets_amount) + $remaining;

                $expenses_amount = $total_petty_amount - $total_remaining_amount;


                foreach ($request->expenses_amounts as $expenses_amount_per_account) {
                    $total_expenses_amount_per_account += $expenses_amount_per_account;
                }

                if ($expenses_amount != $total_expenses_amount_per_account) {
                    alertError('The expense amount entered does not match the amount expensed in the settlement statements', 'مبلغ المصروفات المدخل غير متطابق مع المبلغ المصروف في كشوفات التسوية');
                    return redirect()->back()->withInput();
                }

                if ($total_remaining_amount > 0) {

                    Entry::create([
                        'account_id' => $account->id,
                        'type' => $request->operation,
                        'dr_amount' => $total_remaining_amount,
                        'cr_amount' =>  0,
                        'description' => $description,
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'created_by' => Auth::id(),
                        'due_date' => ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null,
                    ]);
                }


                if ($expenses_amount > 0) {
                    foreach ($request->expenses_accounts as $index => $expenses_account) {
                        Entry::create([
                            'account_id' => $expenses_account,
                            'type' => $request->operation,
                            'dr_amount' => $request->expenses_amounts[$index],
                            'cr_amount' =>  0,
                            'description' => $description,
                            'branch_id' => $branch_id,
                            'media_id' => $media_id,
                            'doc_num' => $request->doc_num,
                            'created_by' => Auth::id(),
                            'due_date' => ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null,
                        ]);
                    }
                }

                if ($total_petty_amount > 0) {

                    Entry::create([
                        'account_id' => $operation_account->id,
                        'type' => $request->operation,
                        'dr_amount' => 0,
                        'cr_amount' =>  $total_petty_amount,
                        'description' => $description,
                        'branch_id' => $branch_id,
                        'media_id' => $media_id,
                        'doc_num' => $request->doc_num,
                        'created_by' => Auth::id(),
                        'due_date' => ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null,
                    ]);
                }

                foreach ($sheets as $sheet) {
                    $sheet->update([
                        'status' => 'confirmed',
                    ]);
                }
            } else {


                // use this for dynamic entries and for employee_loan operation

                Entry::create([
                    'account_id' => $account->id,
                    'type' => $request->operation,
                    'dr_amount' => $request->operation_type == 'in' ? $request->amount : 0,
                    'cr_amount' => $request->operation_type == 'out' ? $request->amount : 0,
                    'description' => $description,
                    'branch_id' => $branch_id,
                    'media_id' => $media_id,
                    'doc_num' => $request->doc_num,
                    'created_by' => Auth::id(),
                    'due_date' => ($request->type == 'receipt_notes' || $request->type == 'payment_notes') ? $request->due_date : null,
                ]);

                Entry::create([
                    'account_id' => $operation_account->id,
                    'type' => $request->operation,
                    'dr_amount' => $request->operation_type == 'out' ? $request->amount : 0,
                    'cr_amount' => $request->operation_type == 'in' ? $request->amount : 0,
                    'description' => $description,
                    'branch_id' => $branch_id,
                    'media_id' => $media_id,
                    'doc_num' => $request->doc_num,
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
            return redirect()->back()->withInput();
        }


        $amount = getSettleAmount();


        if ($request->amount != $amount) {
            alertError('please add suitable entry amount to add the entry', 'يرجى ادحال قيمة القيد بشكل صحيح لاستكمال العملية');
            return redirect()->back()->withInput();
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
            return redirect()->back()->withInput();
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
