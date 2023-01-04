<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();


            $table->integer('affiliate_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->enum('order_from', ['androidapp', 'iosapp', 'web', 'pos', 'addsale', 'affiliate'])->default('web');
            $table->string('full_name');
            $table->string('address');
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();

            $table->string('house')->nullable();
            $table->string('special_mark')->nullable();
            $table->string('notes')->nullable();

            $table->double('total_price', 8, 2)->nullable();
            $table->double('subtotal_price', 8, 2)->nullable();

            $table->double('total_price_affiliate', 8, 2)->nullable();

            $table->double('total_commission', 8, 2)->nullable();
            $table->double('total_profit', 8, 2)->nullable();


            $table->double('shipping_amount', 8, 2)->nullable();
            $table->integer('shipping_method_id')->nullable();

            $table->string('status')->default('pending');

            $table->string('phone');
            $table->string('phone2')->nullable();

            $table->string('payment_status')->default('Pending');
            $table->enum('payment_method', [
                'cod', 'cash_on_delivery', 'e_wallet', 'paypal', 'authorize_net', 'stripe', 'banktransfer', 'mollie', 'instamojo', 'braintree', 'hyperpay', 'razorpay', 'paytm', 'paystack', 'midtrans', 'wallet', 'fygaro'
            ])->default('cash_on_delivery');
            $table->string('transaction_id')->nullable();

            $table->double('total_tax', 8, 2)->nullable();

            $table->boolean('is_seen')->default('0')->comment('1 for seen & 0 for unseen');
            $table->string('coupon_code')->nullable();
            $table->double('coupon_amount', 8, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
