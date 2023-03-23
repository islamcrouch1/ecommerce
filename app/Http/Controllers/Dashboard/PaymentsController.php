<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Entry;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:payments-read')->only('index', 'show');
        $this->middleware('permission:payments-create')->only('create', 'store');
        $this->middleware('permission:payments-update')->only('edit', 'update');
        $this->middleware('permission:payments-delete|payments-trash')->only('destroy', 'trashed');
        $this->middleware('permission:payments-restore')->only('restore');
    }



    public function create(Order $order)
    {
        $branch_id = $order->branch_id;
        $assets_accounts = Account::where('account_type', 'assets')->where('parent_id', null)->where('branch_id', $branch_id)->get();
        return view('dashboard.payments.create', compact('order', 'assets_accounts'));
    }

    public function store(Request $request, Order $order)
    {


        $request->validate([
            'amount' => "required|numeric",
            'accounts' => "required|array",
        ]);



        $branch_id = $order->branch_id;
        $cach_account = Account::findOrFail($request['accounts'][0]);

        if ($cach_account->branch_id != $branch_id) {
            alertError('error happen in branches', 'حدث خطا في معالجة الفروع');
            return redirect()->back();
        }

        $order_from = $order->order_from;
        $user = User::findOrFail($order->customer_id);


        $amount = $request['amount'];
        $total_amount = getOrderDue($order);
        $payments_amount = getTotalPayments($order);
        $remain_amount = ($total_amount - $payments_amount) - $amount;


        if ($amount == 0) {
            alertError('please enter the amount to complete the request', 'يرجى اضافة المبلغ لاكمال العملية');
            return redirect()->back();
        }

        if ($cach_account->id == settingAccount('fixed_assets_account', $branch_id) || $cach_account->id == settingAccount('dep_expenses_account', $branch_id)) {
            alertError('please go to non current assets section to handle this request', 'الرجاء الذهاب الى قسم ادارة الاصول الثابتة لمعالجة هذه العملية');
            return redirect()->back();
        }

        if (($amount >  $total_amount) || ($amount > ($total_amount - $payments_amount))) {
            alertError('the amount is greater than the total amount due', 'المبلغ المدخل اكثر من المبلغ المطلوب للعملية يرجى مراجعة الادخالات');
            return redirect()->back();
        }

        if ($amount < 0) {
            if (abs($amount) >  $payments_amount) {
                alertError('The refund amount is greater than the previously paid amount', 'المبلغ المسترجع اكبر من المبلغ المدفوع سابقا');
                return redirect()->back();
            }
        }

        if ($order_from == 'addpurchase') {
            $account = getItemAccount($order->customer_id, null, 'suppliers_account', $branch_id);

            if ($amount > 0) {

                $payment = Payment::create([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'branch_id' => $branch_id,
                    'from_account' => $cach_account->id,
                    'to_account' => $account->id,
                    'type' => 'purchases',
                    'amount' => $amount,
                    'created_by' => Auth::id(),
                ]);

                createEntry($account, 'pay_purchase', $amount, 0, $branch_id, $order);
                createEntry($cach_account, 'pay_purchase', 0, $amount, $branch_id, $order);
            }

            if ($amount < 0) {

                $payment = Payment::create([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'branch_id' => $branch_id,
                    'from_account' => $account->id,
                    'to_account' => $cach_account->id,
                    'type' => 'purchases',
                    'amount' => $amount,
                    'created_by' => Auth::id(),
                ]);

                createEntry($account, 'pay_purchase', 0, abs($amount), $branch_id, $order);
                createEntry($cach_account, 'pay_purchase', abs($amount), 0, $branch_id, $order);
            }




            if ($remain_amount > 0 && $remain_amount < $total_amount) {


                $order->update([
                    'payment_status' => 'partial',
                ]);
            }
            if ($remain_amount == 0) {

                $order->update([
                    'payment_status' => 'paid',
                ]);
            }
            if ($remain_amount == $total_amount) {

                $order->update([
                    'payment_status' => 'pending',
                ]);
            }
        }

        if ($order_from == 'addsale') {


            $account = getItemAccount($order->customer_id, null, 'customers_account', $branch_id);

            if ($amount > 0) {

                $payment = Payment::create([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'branch_id' => $branch_id,
                    'from_account' => $account->id,
                    'to_account' => $cach_account->id,
                    'type' => 'sales',
                    'amount' => $amount,
                    'created_by' => Auth::id(),
                ]);

                createEntry($account, 'pay_sales', 0, $amount, $branch_id, $order);
                createEntry($cach_account, 'pay_sales', $amount, 0, $branch_id, $order);
            }

            if ($amount < 0) {

                $payment = Payment::create([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'branch_id' => $branch_id,
                    'from_account' => $cach_account->id,
                    'to_account' => $account->id,
                    'type' => 'purchases',
                    'amount' => $amount,
                    'created_by' => Auth::id(),
                ]);

                createEntry($account, 'pay_sales', abs($amount), 0, $branch_id, $order);
                createEntry($cach_account, 'pay_sales', 0, abs($amount), $branch_id, $order);
            }




            if ($remain_amount > 0 && $remain_amount < $total_amount) {


                $order->update([
                    'payment_status' => 'partial',
                ]);
            }
            if ($remain_amount == 0) {

                $order->update([
                    'payment_status' => 'paid',
                ]);
            }
            if ($remain_amount == $total_amount) {

                $order->update([
                    'payment_status' => 'pending',
                ]);
            }
        }


        alertSuccess('The payment has been created successfully', 'تم انشاء دفعة وتم تسجبل القيود بنجاح');
        return redirect()->route('payments.create', ['order' => $order->id]);
    }
}
