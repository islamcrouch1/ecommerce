<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $type)
    {
        $this->order = $data;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if ($this->type == 'user') {

            $from_email = env("MAIL_USERNAME", "team@ecommerce.com");
            $from = env("APP_NAME", app()->getLocale() == 'ar' ?  "موقعنا" : 'our website');
            $subject = app()->getLocale() == 'ar' ? 'شكرا على طلبك من' . ' - ' . $from : 'thank you for your order from' . ' - ' . $from;
            $to = $this->order->customer->email;
        } else {

            $from_email = env("MAIL_USERNAME", "team@ecommerce.com");
            $from = env("APP_NAME", app()->getLocale() == 'ar' ?  "موقعنا" : 'our website');
            $subject = app()->getLocale() == 'ar' ? 'لديك طلب جديد' : 'you have a new order';
            $to = setting('orders_email');
        }


        return $this->from($from_email, $from)
            ->to($to)
            ->subject($subject)
            ->view('dashboard.orders.template')->with('order', $this->order)->with('type', $this->type);
    }
}