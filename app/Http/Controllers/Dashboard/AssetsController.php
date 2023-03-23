<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AssetsController extends Controller
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
            ->where('type', 'fixed_assets')
            ->latest()
            ->paginate(100);





        return view('dashboard.assets.index', compact('branches', 'accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.assets.create');
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
            'name_ar' => "required|string|max:255|unique:accounts",
            'name_en' => "required|string|max:255|unique:accounts",
            'code' => "required|string|max:255|unique:accounts",
            'dep_rate' => "required|numeric",
        ]);


        if ($request->dep_rate > 100 || $request->dep_rate < 0) {
            alertError('depreciation rate must be less than or equal 100%', 'نسبة الاهلاك يجب ان تكون اقل او تساوي 100%');
            return redirect()->back();
        }


        $branch_id = getUserBranchId(Auth::user());


        if (settingAccount('fixed_assets_account', $branch_id) == null) {
            alertError('please select the default non current assets account in settings page', 'الرجاء تحديد حساب الأصول الغير متداولة الافتراضية في صفحة الإعدادات');
            return redirect()->back();
        }

        if (settingAccount('dep_expenses_account', $branch_id) == null) {
            alertError('please select the default depreciation expenses account in settings page', 'الرجاء تحديد حساب مصاريف الاهلاك الافتراضية في صفحة الإعدادات');
            return redirect()->back();
        }

        $fixed_assets_account = Account::findOrFail(settingAccount('fixed_assets_account', $branch_id));
        $dep_expenses_account = Account::findOrFail(settingAccount('dep_expenses_account', $branch_id));

        $last_account = $dep_expenses_account->accounts->last();



        $parent_account = Account::create([
            'name_ar' => $request['name_ar'] . ' - ' . 'الصافي',
            'name_en' => $request['name_en'] . ' - ' . 'Net Value',
            'code' => $request['code'],
            'parent_id' => $fixed_assets_account->id,
            'account_type' => $fixed_assets_account->account_type,
            'dep_rate' => $request->dep_rate,
            'reference_id' =>  $fixed_assets_account->id,
            'type' => 'fixed_assets_net',
            'branch_id' => $branch_id,
            'created_by' => Auth::id(),
        ]);

        $account = Account::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'code' => $request['code'] . '01',
            'parent_id' => $parent_account->id,
            'account_type' => $parent_account->account_type,
            'dep_rate' => $request->dep_rate,
            'reference_id' =>  $parent_account->id,
            'type' => 'fixed_assets',
            'branch_id' => $branch_id,
            'created_by' => Auth::id(),
        ]);


        $accumulated_account = Account::create([
            'name_ar' => 'مجمع اهلاك' . ' - ' . $request['name_ar'],
            'name_en' => 'accumulated depreciation' . ' - ' . $request['name_en'],
            'code' => $request['code'] . '02',
            'parent_id' => $parent_account->id,
            'account_type' => $parent_account->account_type,
            'dep_rate' => $request->dep_rate,
            'reference_id' =>  $parent_account->id,
            'type' => 'accumulated_depreciation',
            'branch_id' => $branch_id,
            'created_by' => Auth::id(),
        ]);

        if ($last_account == null) {
            $last_code = $dep_expenses_account->code . '01';
        } else {
            $last_code = $last_account->code + 1;
        }
        $depreciation_expenses = Account::create([
            'name_ar' => 'مصاريف اهلاك' . ' - ' . $request['name_ar'],
            'name_en' => 'depreciation expenses' . ' - ' . $request['name_en'],
            'code' => $last_code,
            'parent_id' => $dep_expenses_account->id,
            'account_type' => $dep_expenses_account->account_type,
            'dep_rate' => $request->dep_rate,
            'reference_id' =>  $parent_account->id,
            'type' => 'depreciation_expenses',
            'branch_id' => $branch_id,
            'created_by' => Auth::id(),
        ]);


        alertSuccess('asset created successfully', 'تم إضافة اصل ثابت بنجاح');
        return redirect()->route('assets.index');
    }

    public function sellCreate(Account $account)
    {

        $branch_id = getUserBranchId(Auth::user());
        $assets_accounts = Account::where('account_type', 'assets')->where('parent_id', null)->where('branch_id', $branch_id)->get();

        return view('dashboard.assets.sell', compact('account', 'assets_accounts'));
    }


    public function purchaseCreate(Account $account)
    {

        $branch_id = getUserBranchId(Auth::user());
        $assets_accounts = Account::where('account_type', 'assets')->where('parent_id', null)->where('branch_id', $branch_id)->get();

        return view('dashboard.assets.purchase', compact('account', 'assets_accounts'));
    }


    public function sell(Request $request, Account $account)
    {


        $request->validate([
            'price' => "required|numeric",
            'accounts' => "required|array",
        ]);

        $branch_id = getUserBranchId(Auth::user());

        if (settingAccount('fixed_assets_account', $branch_id) == null) {
            alertError('please select the default non current assets account in settings page', 'الرجاء تحديد حساب الأصول الغير متداولة الافتراضية في صفحة الإعدادات');
            return redirect()->back();
        }

        if (settingAccount('dep_expenses_account', $branch_id) == null) {
            alertError('please select the default depreciation expenses account in settings page', 'الرجاء تحديد حساب مصاريف الاهلاك الافتراضية في صفحة الإعدادات');
            return redirect()->back();
        }


        if (settingAccount('revenue_account', $branch_id) == null) {
            alertError('please select the default revenue account in settings page', 'الرجاء تحديد حساب الايرادات الافتراضية في صفحة الإعدادات');
            return redirect()->back();
        }

        if (settingAccount('expenses_account', $branch_id) == null) {
            alertError('please select the default expenses account in settings page', 'الرجاء تحديد حساب المصروفات الافتراضية في صفحة الإعدادات');
            return redirect()->back();
        }

        $fixed_assets_account = Account::findOrFail(settingAccount('fixed_assets_account', $branch_id));
        $dep_expenses_account = Account::findOrFail(settingAccount('dep_expenses_account', $branch_id));
        $revenue_account = Account::findOrFail(settingAccount('revenue_account', $branch_id));
        $expenses_account = Account::findOrFail(settingAccount('expenses_account', $branch_id));



        $cach_account = Account::findOrFail($request['accounts'][0]);
        $price = $request['price'];



        $asset = getTrialBalance($account->id, request()->from, request()->to);

        if ($asset <= 0) {
            alertError('the asset doas not have net value to sell it now please review your data and try again later', 'لا توجد قيمة دفترية للاصل لبيعها يرجى مراجعة الادخال والمحاولة مرة اخرى');
            return redirect()->back();
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
                'name_ar' => 'ايرادات ناتجة عن بيع الاصول الغير متداولة',
                'name_en' => 'revenue generated by sell non current assets',
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
                'name_ar' => 'خسائر ناتجة عن بيع الاصول الغير متداولة',
                'name_en' => 'losses generated by sell non current assets',
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



        if ($value > 0) {

            Entry::create([
                'account_id' => $account->id,
                'type' => 'sellAsset',
                'dr_amount' => 0,
                'cr_amount' => $asset,
                'description' => 'sell non current assets' . ' - ' . 'بيع اصل غير متداول' . ' - ' . getName($account),
                'branch_id' => $branch_id,
                'created_by' => Auth::id(),
            ]);

            Entry::create([
                'account_id' => $revenue_asset->id,
                'type' => 'sellAsset',
                'dr_amount' => 0,
                'cr_amount' => $value,
                'description' => 'sell non current assets' . ' - ' . 'بيع اصل غير متداول' . ' - ' . getName($account),
                'branch_id' => $branch_id,
                'created_by' => Auth::id(),
            ]);


            if (abs($acc_balance) > 0) {

                Entry::create([
                    'account_id' => $acc_account->id,
                    'type' => 'sellAsset',
                    'dr_amount' => abs($acc_balance),
                    'cr_amount' => 0,
                    'description' => 'sell non current assets' . ' - ' . 'بيع اصل غير متداول' . ' - ' . getName($account),
                    'branch_id' => $branch_id,
                    'created_by' => Auth::id(),
                ]);
            }


            Entry::create([
                'account_id' => $cach_account->id,
                'type' => 'sellAsset',
                'dr_amount' => $asset + $value + $acc_balance,
                'cr_amount' => 0,
                'description' => 'sell non current assets' . ' - ' . 'بيع اصل غير متداول' . ' - ' . getName($account),
                'branch_id' => $branch_id,
                'created_by' => Auth::id(),
            ]);
        }

        if ($value == 0) {

            Entry::create([
                'account_id' => $account->id,
                'type' => 'sellAsset',
                'dr_amount' => 0,
                'cr_amount' => $asset,
                'description' => 'sell non current assets' . ' - ' . 'بيع اصل غير متداول' . ' - ' . getName($account),
                'branch_id' => $branch_id,
                'created_by' => Auth::id(),
            ]);

            if (abs($acc_balance) > 0) {

                Entry::create([
                    'account_id' => $acc_account->id,
                    'type' => 'sellAsset',
                    'dr_amount' => abs($acc_balance),
                    'cr_amount' => 0,
                    'description' => 'sell non current assets' . ' - ' . 'بيع اصل غير متداول' . ' - ' . getName($account),
                    'branch_id' => $branch_id,
                    'created_by' => Auth::id(),
                ]);
            }

            Entry::create([
                'account_id' => $cach_account->id,
                'type' => 'sellAsset',
                'dr_amount' => $asset + $value + $acc_balance,
                'cr_amount' => 0,
                'description' => 'sell non current assets' . ' - ' . 'بيع اصل غير متداول' . ' - ' . getName($account),
                'branch_id' => $branch_id,
                'created_by' => Auth::id(),
            ]);
        }

        if ($value < 0) {

            Entry::create([
                'account_id' => $account->id,
                'type' => 'sellAsset',
                'dr_amount' => 0,
                'cr_amount' => $asset,
                'description' => 'sell non current assets' . ' - ' . 'بيع اصل غير متداول' . ' - ' . getName($account),
                'branch_id' => $branch_id,
                'created_by' => Auth::id(),
            ]);


            Entry::create([
                'account_id' => $cach_account->id,
                'type' => 'sellAsset',
                'dr_amount' => $asset + $value + $acc_balance,
                'cr_amount' => 0,
                'description' => 'sell non current assets' . ' - ' . 'بيع اصل غير متداول' . ' - ' . getName($account),
                'branch_id' => $branch_id,
                'created_by' => Auth::id(),
            ]);

            if (abs($acc_balance) > 0) {

                Entry::create([
                    'account_id' => $acc_account->id,
                    'type' => 'sellAsset',
                    'dr_amount' => abs($acc_balance),
                    'cr_amount' => 0,
                    'description' => 'sell non current assets' . ' - ' . 'بيع اصل غير متداول' . ' - ' . getName($account),
                    'branch_id' => $branch_id,
                    'created_by' => Auth::id(),
                ]);
            }

            Entry::create([
                'account_id' => $expenses_asset->id,
                'type' => 'sellAsset',
                'dr_amount' => abs($value),
                'cr_amount' => 0,
                'description' => 'sell non current assets' . ' - ' . 'بيع اصل غير متداول' . ' - ' . getName($account),
                'branch_id' => $branch_id,
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


        alertSuccess('asset sold successfully', 'تم بيع اصل ثابت بنجاح');
        return redirect()->route('assets.index');
    }


    public function purchase(Request $request, Account $account)
    {


        $request->validate([
            'price' => "required|numeric",
            'accounts' => "required|array",
        ]);

        $branch_id = getUserBranchId(Auth::user());

        $cach_account = Account::findOrFail($request['accounts'][0]);
        $price = $request['price'];

        if ($price <= 0) {
            alertError('please enter purchase price to complete the request', 'يرجى اضافة سعر الشراء لاكمال العملية');
            return redirect()->back();
        }

        if ($cach_account->id == settingAccount('fixed_assets_account', $branch_id) || $cach_account->id == settingAccount('dep_expenses_account', $branch_id)) {
            alertError('please go to non current assets section to handle this request', 'الرجاء الذهاب الى قسم ادارة الاصول الثابتة لمعالجة هذه العملية');
            return redirect()->back();
        }



        if ($branch_id != null && $account->type == 'fixed_assets') {


            Entry::create([
                'account_id' => $account->id,
                'type' => 'purchaseAsset',
                'dr_amount' => $price,
                'cr_amount' => 0,
                'description' => 'purchase non current assets' . ' - ' . 'شراء اصل غير متداول' . ' - ' . getName($account),
                'branch_id' => $branch_id,
                'created_by' => Auth::id(),
            ]);


            Entry::create([
                'account_id' => $cach_account->id,
                'type' => 'purchaseAsset',
                'dr_amount' => 0,
                'cr_amount' => $price,
                'description' => 'purchase non current assets' . ' - ' . 'شراء اصل غير متداول' . ' - ' . getName($account),
                'branch_id' => $branch_id,
                'created_by' => Auth::id(),
            ]);

            $dep_rate = $account->dep_rate;
            $acc_dep_account = getAccu($account);
            $dep_exp_account = getDep($account);
            $mounth_rate = $dep_rate / 12;
            if ($dep_rate <= 0) {
                $months = 0;
            } else {
                $months = (100 / $dep_rate) * 12;
            }

            if ($price > 0) {

                $dep_amount_per_mounth = ($price / $months);
                $asset_value = $price;
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
                        'created_at' => $date->toDateString()
                    ]);
                }
            }
        }



        alertSuccess('asset purchased successfully', 'تم شراء اصل ثابت بنجاح');
        return redirect()->route('assets.index');
    }
}
