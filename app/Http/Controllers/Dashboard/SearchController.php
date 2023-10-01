<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Variation;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {

        $request->validate([
            'search' => "nullable|string",
            'type' => "required|string",
            'parent' => "nullable|string",
            // 'account_type' => "nullable|string",
            // 'account_id' => "nullable|integer"
        ]);

        $search = $request->search;
        $data = [];
        $user = Auth::user();


        if ($request->type == 'variations') {

            $data['elements'] = Variation::whenAttribute($request->parent)->whenSearch($search)
                ->get();
        }

        if ($request->type == 'products') {

            $data['elements'] =  Product::where('vendor_id', null)->whenSearch($search)
                ->get();
        }

        if ($request->type == 'users') {

            $data['elements'] =  User::WhereRoleNot('superadministrator')->whenSearch($search)
                ->get();
            $data['type'] = 'untranslated';
        }

        if ($request->type == 'products_all') {

            $data['elements'] =  Product::whenSearch($search)
                ->get();
        }

        if ($request->type == 'categories') {

            $data['elements'] =  Category::whenSearch($search)
                ->get();
        }

        if ($request->type == 'accounts') {

            $data['elements'] =  Account::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
                ->whenSearch($search)
                ->get();
        }

        if ($request->type == 'admins') {

            $data['elements'] =  User::whereHas('roles', function ($query) {
                $query->where('name', 'administrator');
            })->where('name', 'like', "%$search%")
                ->get();
            $data['type'] = 'untranslated';
        }

        if ($request->type == 'accounts_edit') {

            $data['elements'] =  Account::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)
                ->where('account_type', $request->account_type)
                ->where('id', '!=', $request->account_id)
                ->whenSearch($search)
                ->get();
        }


        if ($request->type == 'acc-accounts') {

            $data['elements'] =  Account::where('branch_id', $user->hasPermission('branches-read') ? '!=' : '=', $user->hasPermission('branches-read') ? null : $user->branch_id)


                // ->where('type', '!=', 'cash_accounts')
                // ->where('type', '!=', 'bank_accounts')
                // ->where('type', '!=', 'receipt_notes')
                // ->where('type', '!=', 'payment_notes')

                ->whenSearch($search)
                ->get();
        }



        if ($request->type == 'fixed_assets') {
            $branch_id = getUserBranchId($user);
            $data['elements'] =  Account::where('branch_id', '=',  $branch_id)
                ->where('type', 'fixed_assets')
                ->whenSearch($search)
                ->get();
        }


        if ($request->type == 'supplier') {
            $data['elements'] = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'vendor');
            })->where('name', 'like', "%$search%")
                ->get();
            $data['type'] = 'untranslated';
        }

        if ($request->type == 'customer') {
            $data['elements'] = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'user');
            })->where('name', 'like', "%$search%")
                ->get();

            $data['type'] = 'untranslated';
        }



        if ($data['elements'] && !empty($data['elements'])) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }


        return $data;
    }


    public function accSearch(Request $request)
    {

        $request->validate([
            'account_type' => "nullable|string"
        ]);

        $data = [];
        $user = Auth::user();
        $user_id = $user->id;

        if ($request->account_type == 'deferred_suppliers') {
            $branch_id = getUserBranchId($user);
            $data['elements'] = Account::where('type', 'suppliers_account')->where('parent_id', settingAccount('suppliers_account', $branch_id))->get();
        } elseif ($request->account_type == 'deferred_customers') {
            $branch_id = getUserBranchId($user);
            $data['elements'] = Account::where('type', 'customers_account')->where('parent_id', settingAccount('customers_account', $branch_id))->get();
        } else {
            if ($request->account_type) {
                $branch_id = getUserBranchId($user);
                $data['elements'] = Account::whereHas('users', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                })->where('type', $request->account_type)->where('parent_id', settingAccount($request->account_type, $branch_id))->get();
            }
        }





        // $data['elements'] = $request->account_type;

        if (isset($data['elements'])) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }


        return $data;
    }


    public function ordersSearch(Request $request)
    {

        $request->validate([
            'supplier_id' => "nullable|integer",
            'type' => "nullable|string"
        ]);

        $data = [];
        $user = Auth::user();
        $user_id = $user->id;

        $branch_id = getUserBranchId($user);

        if ($request->type == 'sales') {
            $invoices = Invoice::where('branch_id', $branch_id)->where('customer_id', $request->supplier_id)->whereIn('status', ['invoice', 'credit_note'])->get();
        } else {
            $invoices = Invoice::where('branch_id', $branch_id)->where('customer_id', $request->supplier_id)->whereIn('status', ['bill', 'debit_note'])->get();
        }


        foreach ($invoices as $invoice) {
            $invoice->total_amount = getInvoiceTotalAmount($invoice);
            $invoice->paid_amount = getInvoiceTotalPayments($invoice);
            $invoice->return_amount = getInvoiceTotalReturns($invoice);
            $invoice->due_amount = $invoice->total_amount - ($invoice->paid_amount - $invoice->return_amount);
            $invoice->type = __($invoice->status);
            $invoice->symbol = $invoice->currency->symbol;
            if ($invoice->order_id != null) {
                $invoice->order_serial =  $invoice->order->serial;
            }
        }

        $data['elements'] = $invoices;

        $data['withdrawals'] = Withdrawal::where('user_id', $request->supplier_id)->whereIn('status', ['pending', 'recieved'])->get();

        if (isset($data['elements']) || isset($data['withdrawals'])) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }


        return $data;
    }
}
