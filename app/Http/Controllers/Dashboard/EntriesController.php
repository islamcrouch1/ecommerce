<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Entry;
use App\Models\Order;
use App\Models\ProductCombination;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $entries = Entry::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->when($accounts, function ($q) use ($accounts) {
                return $q->whereIn('account_id', $accounts);
            })
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);

        if (request()->has('account_id')) {
            $accounts = Account::whenParent(request()->account_id)
                ->get();
        }


        return view('dashboard.entries.index', compact('entries', 'accounts'));
    }


    public function income(Request $request)
    {

        if (!$request->has('from') || !$request->has('to')) {
            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $revenue_account = Account::findOrFail(setting('revenue_account'));
        $revenue = 0;
        $revenue_cr = getTrialBalance($revenue_account->id, request()->from, request()->to)['cr'];
        $revenue_dr = getTrialBalance($revenue_account->id, request()->from, request()->to)['dr'];

        if ($revenue_cr > $revenue_dr) {
            $revenue = $revenue_cr;
        } else {
            $revenue = $revenue_dr;
        }


        $expenses_account = Account::findOrFail(setting('expenses_account'));

        $expenses = 0;
        $expenses_cr = getTrialBalance($expenses_account->id, request()->from, request()->to)['cr'];
        $expenses_dr = getTrialBalance($expenses_account->id, request()->from, request()->to)['dr'];

        if ($expenses_cr > $expenses_dr) {
            $expenses = $expenses_cr;
        } else {
            $expenses = $expenses_dr;
        }



        $orders = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whereNot(function ($query) {
                $query->where('order_from',  'addpurchase');
            })
            ->whenCountry(getDefaultCountry()->id)
            ->whereNotIn('status', ['RTO', 'returned', 'canceled'])
            ->get();

        $sales_cost = 0;

        foreach ($orders as $order) {
            $cost = 0;
            foreach ($order->products as $product) {
                if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                    $combination = ProductCombination::findOrFail($product->pivot->product_combination_id);
                    $cost += $combination->purchase_price * $product->pivot->qty;
                } else {
                    $cost += $product->cost * $product->pivot->qty;
                }
            }
            $sales_cost += $cost;
        }

        $gross_profit = $revenue - $expenses - $sales_cost;

        $tax = Tax::findOrFail(setting('income_tax'));

        $income_tax_rate = $tax->tax_rate;

        if ($gross_profit <= 0) {
            $income_tax = 0;
        } else {
            $income_tax = (($gross_profit * $tax->tax_rate) / 100);
        }


        $net_profit = $gross_profit - $income_tax;


        return view('dashboard.entries.income', compact('revenue', 'expenses', 'sales_cost', 'gross_profit', 'income_tax_rate', 'income_tax', 'net_profit'));
    }

    public function getSubAccounts(Request $request)
    {

        $account_id = $request->account_id;

        $account = Account::findOrFail($account_id);

        $accounts = $account->accounts;

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
        $accounts = Account::whereNull('parent_id')
            ->get();
        return view('dashboard.entries.create', compact('accounts'));
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
            'from_account' => "required|string|max:255",
            'to_account' => "required|string|max:255",
            'amount' => "required|numeric",
            'description' => "required|string",
        ]);


        $from_account = Account::findOrFail($request->from_account);
        $to_account = Account::findOrFail($request->to_account);

        $dr_amount = 0;
        $cr_amount = 0;




        if ($from_account->account_type == 'assets' || $from_account->account_type == 'expenses') {
            $dr_amount = 0;
            $cr_amount = $request->amount;
        } elseif ($from_account->account_type == 'liability' || $from_account->account_type == 'revenue') {
            $dr_amount = 0;
            $cr_amount = $request->amount;
        }

        entry::create([
            'account_id' => $request->from_account,
            'type' => 'entry',
            'dr_amount' => $dr_amount,
            'cr_amount' => $cr_amount,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        $dr_amount = 0;
        $cr_amount = 0;

        if ($to_account->account_type == 'assets' || $to_account->account_type == 'expenses') {
            $dr_amount = $request->amount;
            $cr_amount = 0;
        } elseif ($to_account->account_type == 'liability' || $to_account->account_type == 'revenue') {
            $dr_amount = $request->amount;
            $cr_amount = 0;
        }


        entry::create([
            'account_id' => $request->to_account,
            'type' => 'entry',
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
        $entry = entry::findOrFail($entry);
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
        $entry = entry::withTrashed()->where('id', $entry)->first();
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
        $entries = entry::onlyTrashed()
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(100);
        return view('dashboard.entries.index', ['entries' => $entries]);
    }

    public function restore($entry, Request $request)
    {
        $entry = entry::withTrashed()->where('id', $entry)->first()->restore();
        alertSuccess('entry restored successfully', 'تم استعادة قيد اليومية بنجاح');
        return redirect()->route('entries.index');
    }
}
