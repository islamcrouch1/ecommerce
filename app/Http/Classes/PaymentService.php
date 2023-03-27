<?php

namespace App\Http\Classes;

use Illuminate\Support\Facades\App;

class PaymentService
{

    protected $path_url      =  'https://api.upayments.com/payment-request'; // live
    protected $success_url   =  'http://myadd.net/payment/visa/result';
    protected $error_url     =  'http://myadd.net/payment/visa/error';
    // protected $merchant_id   =  '2009';
    // protected $username      =  'khaled';
    // protected $password      =  'F!HEQb9bg2egLkF*';
    // protected $api_key       =  'IXhrAnFj0A6GhWnbpjha42CaCf8XOG9D4GqHNMTB';

    protected $merchant_id   =  '1744';
    protected $username      =  'yfb_market';
    protected $password      =  'E3G^GTJLqPu58W@M';
    protected $api_key       =  '9tp6r5gQpd9NOavDxXF4N7zqpkH0I4eu3bhW9zGd';


    protected $test_mode     =  false;

    public function __construct()
    {
        if ($this->test_mode == true) {
            $this->merchant_id  = '1201';
            $this->username     = 'test';
            $this->password     = 'test';
            $this->api_key      = 'jtest123';
            $this->path_url     = 'https://api.upayments.com/test-payment';
        }
    }

    public function pay($params)
    {
        $fields = $this->payment_create($params);
        return $this->payment_pay($fields);
    }

    protected function payment_pay($fildes)
    {
        $fields = http_build_query($fildes);
        $curl   = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->path_url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return $err;
        } else {
            return json_decode($response, true);
        }
    }


    public function setSuccessUrl($value)
    {
        $this->success_url = $value;
        return $this;
    }

    public function setErrorUrl($value)
    {
        $this->error_url = $value;
        return $this;
    }


    protected function payment_fields($fields)
    {
        return [
            'merchant_id'       =>  $this->merchant_id,
            'username'          =>  $this->username,
            'password'          =>  stripslashes($this->password),
            'api_key'           => ($this->test_mode == true) ? $this->api_key : password_hash($this->api_key, PASSWORD_BCRYPT),
            'CstFName'          =>  $fields['CstFName'],
            'CstEmail'          =>  $fields['CstEmail'],
            'CstMobile'         =>  $fields['CstMobile'],
            'order_id'          =>  $fields['order_id'],
            'total_price'       =>  $fields['total_price'],
            'success_url'       =>  $this->success_url,
            'error_url'         =>  $this->error_url,
            'test_mode'         => ($this->test_mode == true) ? 1 : 0,
            'whitelabled'       =>  false,
            'payment_gateway'   =>  $fields['payment_gateway'],
            'ProductName'       =>  json_encode($fields['products']['ProductName']),
            'ProductQty'        =>  json_encode($fields['products']['ProductQty']),
            'ProductPrice'      =>  json_encode($fields['products']['ProductPrice']),
            'reference'         =>  $fields['order_id']
        ];
    }

    protected function payment_create($fields = [])
    {
        if (empty($fields)) {
            $array['CstFName']                    = 'Eslam Saloka';
            $array['CstEmail']                    = 'eslammohsenhandousa@gmail.com';
            $array['CstMobile']                   = '12345678';
            $array['payment_gateway']             = 'cc'; // cc || knet
            $array['total_price']                 = '1000';
            $array['order_id']                    = time();
            $array['reference']                   = 'Ref00001';
            $array['products']['ProductName']     = ['cober'];
            $array['products']['ProductQty']      = [1];
            $array['products']['ProductPrice']    = [1];
        } else {
            $array = $fields;
        }
        return $this->payment_fields($array);
    }
}
