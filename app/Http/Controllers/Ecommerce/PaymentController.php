<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Classes\PaymentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Classes\PayMob;
use App\Models\Account;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Order;
use App\Models\ProductCombination;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{


    public function orderFailed(Request $request)
    {
        $order = Order::findOrFail($request->OrderID);
        $this->failed($order);
        alertError('error in payment processing please try again later', 'حدث خطا اثناء عملية الدفع يرجى المحاولة لاحقا');
        return redirect()->route('ecommerce.home');
    }



    public function paymentSuccess(Request $request)
    {


        if (isset($request->order) && $request->order != null) {
            $order = Order::where('orderId', $request->order)->first();
        }

        if (isset($request->OrderID) && $request->OrderID != null) {
            $order = Order::find($request->OrderID);
        }

        if (isset($request->token) && isset($request->PayerID)) {

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request['token']);


            $order = Order::where('orderId', $response['id'])->first();
        }

        if ($order == null) {
            return redirect()->route('ecommerce.home');
        }


        if ($order->payment_method == 'paymob') {

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


        if ($order->payment_method == 'upayment') {

            if ($request->Result == 'CAPTURED') {
                $this->succeeded($order);
                return redirect()->route('ecommerce.order.success', ['order' => $order->id]);
            } else {
                $this->failed($order);
                alertError('error in payment processing pleasetry again later', 'حدث خطا اثناء عملية الدفع يرجى المحاولة لاحقا');
                return redirect()->route('ecommerce.home');
            }
        }

        if ($order->payment_method == 'paypal') {
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $this->succeeded($order);
                return redirect()->route('ecommerce.order.success', ['order' => $order->id]);
            } else {
                $this->failed($order);
                alertError('error in payment processing pleasetry again later', 'حدث خطا اثناء عملية الدفع يرجى المحاولة لاحقا');
                return redirect()->route('ecommerce.home');
            }
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


        if ($order->payment_method == 'paymob') {

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
                if ($paymobOrder->message == 'duplicate' && $order->orderId == null) {
                    # code... your order id is duplicate on PayMob database.
                    $this->failed($order);
                    alertError('error in payment processing pleasetry again later', 'حدث خطا اثناء عملية الدفع يرجى المحاولة لاحقا');
                    return redirect()->route('ecommerce.home');
                } else {
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
                $user_name = 'guast';
                $user_phone = 'guast';
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


        if ($order->payment_method == 'upayment') {

            $payment = new PaymentService();

            $array['CstFName']                    = $order->full_name;
            $array['CstEmail']                    = 'user@admin.com';
            $array['CstMobile']                   = $order->phone;
            $array['payment_gateway']             = 'knet'; // cc || knet
            $array['total_price']                 = $order->total_price;
            $array['order_id']                    = $order->id;
            $array['products']['ProductName']     = 'Payment for website products - ' .  'order number - ' . $order->id;
            $array['products']['ProductQty']      = '1';
            $array['products']['ProductPrice']    = $order->total_price;
            // $array['CurrencyCode']                = $order->country->currency;
            $array['CurrencyCode']                = 'KWD';
            $payment->setSuccessUrl(route('ecommerce.payment.success'))->setErrorUrl(route('ecommerce.order.failed'));
            $result = $payment->pay($array);
            // dd($result);
            if ($result['status'] == "success") {

                return redirect(url($result['paymentURL']));
                // $paymentURL = $result['paymentURL'];
                // return redirect()->$paymentURL ;
            } else {
                return redirect()->route('ecommerce.order.failed', ['orderID' => $order->id]);
            }
        }

        if ($order->payment_method == 'paypal') {

            $locale = app()->getlocale() == 'ar' ? 'ar-eg' : 'en_US';
            $currency = getCountry()->currency;
            $config = [
                'mode'    => 'sandbox',
                'sandbox' => [
                    'client_id'         => 'AeZbn4ahI7n7gRW4sFw0cV3Ex4oiKgLq5Syz0NzB1vZ0adFGFOSf0pVdddWiN7ASunqIZbLiiqkOxsK5',
                    'client_secret'     => 'EAbMVfc35_79N_kZlAUNmlPoE99Txgu5NfzQNvuShyxYgyxGNEonrcV22_GsUoGl227KElu-GR6zQl43',
                    'app_id'            => 'APP-80W284485P519543T',
                ],

                'payment_action' => 'Order',
                'currency'       => 'USD',
                'notify_url'     => '',
                'locale'         => $locale,
                'validate_ssl'   => true,
            ];

            $provider = new PayPalClient;
            $provider->setApiCredentials($config);
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "order_id" => $order->id,
                "application_context" => [
                    "return_url" => route('ecommerce.payment.success'),
                    "cancel_url" => route('ecommerce.order.failed', ['orderID' => $order->id]),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => 'USD',
                            "value" => $order->total_price
                        ]
                    ]
                ]
            ]);

            $order->update([
                'orderId' => $response['id'],
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
                $this->failed($order);
                alertError('error in payment processing please try again later', 'حدث خطا اثناء عملية الدفع يرجى المحاولة لاحقا');
                return redirect()->route('ecommerce.home');
            } else {
                $this->failed($order);
                alertError('error in payment processing please try again later', 'حدث خطا اثناء عملية الدفع يرجى المحاولة لاحقا');
                return redirect()->route('ecommerce.home');
            }
        }
    }


    public function createTransaction()
    {
        return view('ecommerce.paypal-transaction');
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

        $branch_id = $order->branch_id;


        if ($order->customer_id != null) {
            $customer_account = getItemAccount($order->customer_id, null, 'customers_account', $branch_id);
        } else {
            $customer_account = getItemAccount(null, null, 'customers_account', $branch_id);
        }

        createEntry($customer_account, 'sales', 0, $order->total_price, $branch_id, $order);

        $cash_account = getIntermediaryAssetAccount($order, $branch_id);
        createEntry($cash_account, 'sales', $order->total_price, 0, $branch_id, $order);

        $order->update([
            'payment_status' => 'paid',
        ]);

        $cart_items = getCartItems();
        foreach ($cart_items as $item) {
            $item->delete();
        }

        if (Auth::check()) {
            sendEmail('order', $order, 'user');
        }

        sendEmail('order', $order, 'admin');
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


        foreach ($order->vendor_orders as $vendor_order) {
            changeOutStandingBalance($vendor_order->user, ($vendor_order->total_price - $vendor_order->total_commission), $vendor_order->id, $status, 'sub');
        }

        $branch_id = $order->branch_id;

        $total_vendors_tax_ammount = 0;
        $total_order_vendors_products = 0;



        foreach ($order->products as $product) {

            if ($product->product_type == 'variable' || $product->product_type == 'simple') {


                $combination = ProductCombination::findOrFail($product->pivot->product_combination_id);

                if ($product->vendor_id == null) {

                    $warehouse_id = $product->pivot->warehouse_id;

                    $product_account = getItemAccount($combination, $combination->product->category, 'assets_account', $branch_id);
                    $cs_product_account = getItemAccount($combination, $combination->product->category, 'cs_account', $branch_id);

                    createEntry($product_account, 'sales_return', ($product->pivot->cost * $product->pivot->qty), 0, $branch_id, $order);
                    createEntry($cs_product_account, 'sales_return', 0, ($product->pivot->cost * $product->pivot->qty), $branch_id, $order);

                    // get cost and update combination cost
                    $cost = getProductCost($product, $combination, $branch_id, $order, $product->pivot->qty, true);
                }

                if ($product->vendor_id != null) {

                    $warehouse = Warehouse::where('vendor_id', $product->vendor_id)->first();
                    $warehouse_id = $warehouse->id;
                    $total_vendors_tax_ammount += $vendor_order->total_tax;
                    $total_order_vendors_products += $vendor_order->total_price;

                    // add return entry for commission tax account

                    $supplier_account = getItemAccount($product->vendor_id, null, 'suppliers_account', $branch_id);
                    createEntry($supplier_account, 'sales_return', $vendor_order->total_price - $vendor_order->total_commission, 0, $branch_id, $order);

                    if ($vendor_order->total_commission > 0) {
                        $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);
                        createEntry($revenue_account, 'sales_return', $vendor_order->total_commission - $vendor_order->total_tax, 0, $branch_id, $order);

                        $vendors_tax_account = Account::findOrFail(settingAccount('vendors_tax_account', $branch_id));
                        createEntry($vendors_tax_account, 'sales_return', $vendor_order->total_tax, 0, $branch_id, $order);
                    }
                }


                // add stock and running order
                RunningOrderCreate($combination, $warehouse_id, $product->pivot->qty, 'sales', 'IN', $order->id, $order->custumer_id != null ? $order->custumer_id : null, productPrice($product, $product->pivot->product_combination_id, 'vat'));
            }


            if ($product->vendor_id == null) {
                if ($product->product_type == 'variable' || $product->product_type == 'simple') {
                    $revenue_account = getItemAccount($combination, $combination->product->category, 'revenue_account_products', $branch_id);
                } else {
                    $revenue_account = getItemAccount($product, $product->category, 'revenue_account_services', $branch_id);
                }
                createEntry($revenue_account, 'sales_return', $product->pivot->product_price - $product->pivot->product_tax, 0, $branch_id, $order);
            }
        }


        if ($order->customer_id != null) {
            $customer_account = getItemAccount($order->customer_id, null, 'customers_account', $branch_id);
        } else {
            $customer_account = getItemAccount(null, null, 'customers_account', $branch_id);
        }
        createEntry($customer_account, 'sales_return', 0, $order->total_price, $branch_id, $order);


        $order->update([
            'payment_status' => 'faild',
        ]);


        if ($order->total_tax > 0) {
            $vat_account = Account::findOrFail(settingAccount('vat_sales_account', $branch_id));
            createEntry($vat_account, 'sales_return', $order->total_tax, 0, $branch_id, $order);
        }


        if ($order->shipping_amount > 0) {

            $revenue_account_shipping = getItemAccount(null, null, 'revenue_account_shipping', $branch_id);
            createEntry($revenue_account_shipping, 'sales_return', $order->shipping_amount, 0, $branch_id, $order);
        }

        if ($order->discount_amount > 0) {
            $allowed_discount_account = Account::findOrFail(settingAccount('allowed_discount_account', $branch_id));
            createEntry($allowed_discount_account, 'sales_return', 0, $order->discount_amount, $branch_id, $order);
        }


        if ($order->affiliate_id != null) {
            changeOutStandingBalance($order->affiliate, $order->total_commission, $order->id, $order->status, 'sub');
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

        addViewRecord();

        if (Auth::check() && $order->customer_id != Auth::id()) {
            return redirect()->route('ecommerce.home');
        } else {
            $user = Auth::user();
            $categories = Category::whereNull('parent_id')->orderBy('sort_order', 'asc')->get();
            return view('ecommerce.invoice', compact('order', 'user', 'categories'));
        }
    }
}
