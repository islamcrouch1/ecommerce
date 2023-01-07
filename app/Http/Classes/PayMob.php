<?php

namespace App\Http\Classes;



class PayMob
{

    public function __construct()
    {
        //
    }

    /**
     * Send POST cURL request to paymob servers.
     *
     * @param string $url
     * @param array $json
     * @return array
     */
    protected function cURL($url, $json)
    {
        // Create curl resource
        $ch = curl_init($url);

        // Request headers
        $headers = array();
        $headers[] = 'Content-Type: application/json';

        // Return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // $output contains the output string
        $output = curl_exec($ch);

        // Close curl resource to free up system resources
        curl_close($ch);
        return json_decode($output);
    }

    /**
     * Send GET cURL request to paymob servers.
     *
     * @param string $url
     * @return array
     */
    protected function GETcURL($url)
    {
        // Create curl resource
        $ch = curl_init($url);

        // Request headers
        $headers = array();
        $headers[] = 'Content-Type: application/json';

        // Return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // $output contains the output string
        $output = curl_exec($ch);

        // Close curl resource to free up system resources
        curl_close($ch);
        return json_decode($output);
    }


    public function authPaymob()
    {

        $api_key = 'ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TmpZM05qUXhMQ0p1WVcxbElqb2lhVzVwZEdsaGJDSjkuVDNWR3lVZkc4OXNFN1FxWUs0WW9PVzl0eXFjcTdOWHp0OVg3dDhaanB3NnZfOGJZV296RW9PbGdFczUxSjZlUjFRTHFuYVRtTWhZdklJWmZkMmhBcnc=';
        // Request body
        $json = [
            'api_key' => $api_key,
        ];

        // Send curl
        $auth = $this->cURL(
            'https://accept.paymob.com/api/auth/tokens',
            $json
        );

        return $auth;
    }



    public function makeOrderPaymob($token, $merchant_id, $amount_cents, $merchant_order_id)
    {
        // Request body
        $json = [
            'merchant_id'            => $merchant_id,
            'amount_cents'           => $amount_cents,
            'merchant_order_id'      => $merchant_order_id,
            'currency'               => 'EGP',
            'notify_user_with_email' => true
        ];

        // Send curl
        $order = $this->cURL(
            'https://accept.paymobsolutions.com/api/ecommerce/orders?token=' . $token,
            $json
        );

        return $order;
    }



    public function getPaymentKeyPaymob(
        $token,
        $amount_cents,
        $order_id,
        $email   = 'null',
        $fname   = 'null',
        $lname   = 'null',
        $phone   = 'null',
        $city    = 'null',
        $country = 'null'
    ) {
        // Request body
        $json = [
            'amount_cents' => $amount_cents,
            'expiration'   => 36000,
            'order_id'     => $order_id,
            "billing_data" => [
                "email"        => $email,
                "first_name"   => $fname,
                "last_name"    => $lname,
                "phone_number" => $phone,
                "city"         => $city,
                "country"      => $country,
                'street'       => 'null',
                'building'     => 'null',
                'floor'        => 'null',
                'apartment'    => 'null'
            ],
            'currency'            => 'EGP',
            'card_integration_id' => 3254976
        ];

        // Send curl
        $payment_key = $this->cURL(
            'https://accept.paymobsolutions.com/api/acceptance/payment_keys?token=' . $token,
            $json
        );

        return $payment_key;
    }


    public function makePayment(
        $token,
        $card_number,
        $card_holdername,
        $card_expiry_mm,
        $card_expiry_yy,
        $card_cvn,
        $order_id,
        $firstname,
        $lastname,
        $email,
        $phone
    ) {
        // JSON body.
        $json = [
            'source' => [
                'identifier'        => $card_number,
                'sourceholder_name' => $card_holdername,
                'subtype'           => 'CARD',
                'expiry_month'      => $card_expiry_mm,
                'expiry_year'       => $card_expiry_yy,
                'cvn'               => $card_cvn
            ],
            'billing' => [
                'first_name'   => $firstname,
                'last_name'    => $lastname,
                'email'        => $email,
                'phone_number' => $phone,
            ],
            'payment_token' => $token
        ];

        // Send curl
        $payment = $this->cURL(
            'https://accept.paymobsolutions.com/api/acceptance/payments/pay',
            $json
        );

        return $payment;
    }


    public function capture($token, $transactionId, $amount)
    {
        // JSON body.
        $json = [
            'transaction_id' => $transactionId,
            'amount_cents'   => $amount
        ];

        // Send curl.
        $res = $this->cURL(
            'https://accept.paymobsolutions.com/api/acceptance/capture?token=' . $token,
            $json
        );

        return $res;
    }

    public function getOrders($authToken, $page = 1)
    {
        $orders = $this->GETcURL(
            "https://accept.paymobsolutions.com/api/ecommerce/orders?page={$page}&token={$authToken}"
        );

        return $orders;
    }

    public function getOrder($authToken, $orderId)
    {
        $order = $this->GETcURL(
            "https://accept.paymobsolutions.com/api/ecommerce/orders/{$orderId}?token={$authToken}"
        );

        return $order;
    }


    public function getTransactions($authToken, $page = 1)
    {
        $transactions = $this->GETcURL(
            "https://accept.paymobsolutions.com/api/acceptance/transactions?page={$page}&token={$authToken}"
        );

        return $transactions;
    }


    public function getTransaction($authToken, $transactionId)
    {
        $transaction = $this->GETcURL(
            "https://accept.paymobsolutions.com/api/acceptance/transactions/{$transactionId}?token={$authToken}"
        );

        return $transaction;
    }
}
