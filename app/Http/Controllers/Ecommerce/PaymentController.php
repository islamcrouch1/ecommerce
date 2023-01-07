<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\PayMob;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{


    public function paymentSuccess(Request $request)
    {



        if (!isset($request->order) || $request->order == null) {
            return redirect()->route('ecommerce.home');
        }

        $isSuccess  = $request->success;
        $isVoided  = $request->is_voided;
        $isRefunded  = $request->is_refunded;


        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        $order = Order::where('orderId', $request->order)->first();


        if (Auth::check() && $order->customer_id != Auth::id()) {
            return redirect()->route('ecommerce.home');
        } elseif (!Auth::check() && $order->session_id != $request->session()->token()) {
            return redirect()->route('ecommerce.home');
        }




        if ($isSuccess == 'true' && $isVoided == 'false' && $isRefunded == 'false') {
            return view('ecommerce.order-success', compact('order', 'categories'));
        } else {
            alertError('error in payment processing pleasetry again later', 'حدث خطا اثناء عملية الدفع يرجى المحاولة لاحقا');
            return redirect()->route('ecommerce.home');
        }
    }

    public function checkingOut($orderId)
    {

        $order = Order::findOrFail($orderId);
        # code... get order user.

        if (Auth::check() && $order->customer_id != Auth::id()) {
            return redirect()->route('ecommerce.home');
        } elseif (!Auth::check() && $order->session_id != request()->session()->token()) {
            return redirect()->route('ecommerce.home');
        }

        $payment = new PayMob();

        $auth = $payment->authPaymob(); // login PayMob servers

        if (property_exists($auth, 'detail')) { // login to PayMob attempt failed.
            # code... redirect to previous page with a message.
        }

        $paymobOrder = $payment->makeOrderPaymob( // make order on PayMob
            $auth->token,
            $auth->profile->id,
            $order->total_price * 100,
            $order->id
        );
        // Duplicate order id
        // PayMob saves your order id as a unique id as well as their id as a primary key, thus your order id must not
        // duplicate in their database.
        if (isset($paymobOrder->message)) {
            if ($paymobOrder->message == 'duplicate') {
                # code... your order id is duplicate on PayMob database.
                $paymobOrder = $payment->getOrder($auth->token, $order->orderId);
            }
        } else {
            $order->update([
                'orderId' => $paymobOrder->id
            ]); // save paymob order id for later usage.
        }


        if (Auth::check()) {
            $user_name = Auth::user()->name;
            $user_phone = Auth::user()->phone;
        } else {
            $user_name = null;
            $user_phone = null;
        }

        $payment_key = $payment->getPaymentKeyPaymob( // get payment key
            $auth->token,
            $order->total_price * 100,
            $paymobOrder->id,
            // For billing data
            // $user->email, // optional
            $user_name, // optional
            // $user->lastname, // optional
            $user_phone, // optional
            // $city->name, // optional
            // $country->name // optional
        );

        $key = $payment_key->token;
        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();

        return view('ecommerce.pay', compact('key', 'categories'));
    }

    protected function payAPI($order, $payment, $key)
    {
        // $this->validate($request, [
        //     'orderId'         => 'required|integer',
        //     'card_number'     => 'required|numeric|digits:16',
        //     'card_holdername' => 'required|string|max:255',
        //     'card_expiry_mm'  => 'required|integer|max:12',
        //     'card_expiry_yy'  => 'required|integer',
        //     'card_cvn'        => 'required|integer|digits:3',
        // ]);

        if (Auth::check()) {
            $user_name = Auth::user()->name;
            $user_phone = Auth::user()->phone;
            $user_email = Auth::user()->email;
        } else {
            $user_name = null;
            $user_phone = null;
            $user_email = null;
        }

        $order   = $order;


        $payment = $payment->makePayment( // make transaction on Paymob servers.
            $key,
            '5123456789012346',
            'Test Account',
            '12',
            '25',
            '123',
            $order->orderId,
            $user_name,
            $user_name,
            $user_email,
            $user_phone
        );


        # code...
    }

    protected function succeeded($order)
    {
        # code...
    }


    protected function voided($order)
    {
        # code...
    }


    protected function refunded($order)
    {
        # code...
    }


    protected function failed($order)
    {
        # code...
    }


    public function processedCallback(Request $request)
    {




        $orderId = $request['obj']['order']['id'];
        $order   = config('paymob.order.model', 'App\Order')::wherePaymobOrderId($orderId)->first();

        // Statuses.
        $isSuccess  = $request['obj']['success'];
        $isVoided   = $request['obj']['is_voided'];
        $isRefunded = $request['obj']['is_refunded'];

        if ($isSuccess && !$isVoided && !$isRefunded) { // transcation succeeded.
            $this->succeeded($order);
        } elseif ($isSuccess && $isVoided) { // transaction voided.
            $this->voided($order);
        } elseif ($isSuccess && $isRefunded) { // transaction refunded.
            $this->refunded($order);
        } elseif (!$isSuccess) { // transaction failed.
            $this->failed($order);
        }

        return response()->json(['success' => true], 200);
    }


    public function invoice(Request $request)
    {
        # code...
    }
}
