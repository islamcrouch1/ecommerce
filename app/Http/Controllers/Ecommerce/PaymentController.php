<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\PayMob;
use App\Models\Category;
use App\Models\Order;
use App\Models\Stock;
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


        $amount_cents = $request->amount_cents;
        $created_at = $request->created_at;
        $currency = $request->currency;
        $error_occured = $request->error_occured;
        $has_parent_transaction = $request->has_parent_transaction;
        $id = $request->id;
        $integration_id = $request->integration_id;
        $is_3d_secure = $request->is_3d_secure;
        $is_auth = $request->is_auth;
        $is_capture = $request->is_capture;
        $is_refunded = $request->is_refunded;
        $is_standalone_payment = $request->is_standalone_payment;
        $is_voided = $request->is_voided;
        $order = $request->order;
        $owner = $request->owner;
        $pending = $request->pending;
        $source_data_pan = $request->source_data_pan;
        $source_data_sub_type = $request->source_data_sub_type;
        $source_data_type = $request->source_data_type;
        $success = $request->success;

        $string = $amount_cents . $created_at . $currency . $error_occured . $has_parent_transaction . $id . $integration_id . $is_3d_secure . $is_auth . $is_capture . $is_refunded . $is_standalone_payment . $is_voided . $order . $owner . $pending . $source_data_pan . $source_data_sub_type . $source_data_type . $success;

        $hmac = $request->hmac;

        $hashed = hash_hmac('SHA512', $string, '6241DBBDF619E22A4F21A91ED9055302');

        if ($hmac != $hashed) {
            $this->failed($order);
        }

        $order = Order::where('orderId', $request->order)->first();

        if (Auth::check() && $order->customer_id != Auth::id()) {
            return redirect()->route('ecommerce.home');
        } elseif (!Auth::check() && $order->session_id != $request->session()->token()) {
            return redirect()->route('ecommerce.home');
        }

        $order->update([
            'transaction_id' => $id
        ]);

        if ($isSuccess == 'true' && $isVoided == 'false' && $isRefunded == 'false') {
            $this->succeeded($order);
            return redirect()->route('ecommerce.order.success', ['order' => $order->id]);
        } else {
            $this->failed($order);
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

        $order->update([
            'payment_status' => 'Paid'
        ]);
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

        $order->update([
            'payment_status' => 'Faild',
            'status' => 'canceled',
        ]);

        foreach ($order->products as $product) {

            if ($product->product_type == 'variable' || $product->product_type == 'simple') {

                Stock::create([
                    'product_combination_id' => $product->pivot->product_combination_id,
                    'product_id' => $product->id,
                    'warehouse_id' => setting('warehouse_id'),
                    'qty' => $product->pivot->qty,
                    'stock_status' => 'IN',
                    'stock_type' => 'Order',
                    'reference_id' => $order->id,
                    'reference_price' => productPrice($product, $product->pivot->product_combination_id),
                    'created_by' => Auth::check() ? Auth::id() : null,
                ]);
            }
        }
    }


    public function test()
    {
        $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
        return view('ecommerce.test', compact('categories'));
    }


    public function processedCallback(Request $request)
    {


        $orderId = $request['obj']['order']['id'];
        $order = Order::where('orderId', $orderId)->first();


        $order->update([
            'payment_status' => 'Paid'
        ]);

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


    public function invoice(Order $order)
    {

        if (Auth::check() && $order->customer_id != Auth::id()) {
            return redirect()->route('ecommerce.home');
        } else {
            $user = Auth::user();
            $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
            return view('ecommerce.invoice', compact('order', 'user', 'categories'));
        }
    }
}
