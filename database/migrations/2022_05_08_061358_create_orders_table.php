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
            $table->integer('branch_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->enum('order_from', ['androidapp', 'iosapp', 'web', 'pos', 'sales', 'affiliate', 'purchases'])->default('web');
            $table->string('full_name')->nullable();
            $table->longText('address')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();

            $table->longText('house')->nullable();
            $table->longText('special_mark')->nullable();
            $table->longText('notes')->nullable();

            $table->double('total_price', 12, 2)->default(0);
            $table->double('subtotal_price', 12, 2)->default(0);

            $table->double('total_price_affiliate', 12, 2)->default(0);

            $table->double('total_commission', 12, 2)->default(0);
            $table->double('total_profit', 12, 2)->default(0);


            $table->double('shipping_amount', 12, 2)->default(0);
            $table->integer('shipping_method_id')->nullable();

            $table->string('status')->default('pending');

            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();

            $table->enum('payment_status', ['pending', 'paid', 'partial', 'faild'])->default('pending');

            $table->string('payment_method')->default('cash_on_delivery');
            $table->string('transaction_id')->nullable();

            $table->double('total_tax', 12, 2)->default(0);

            $table->double('total_wht_products', 12, 2)->default(0);
            $table->double('total_wht_services', 12, 2)->default(0);


            $table->longText('description')->nullable();


            $table->boolean('is_seen')->default('0')->comment('1 for seen & 0 for unseen');
            $table->string('coupon_code')->nullable();
            $table->double('coupon_amount', 12, 2)->default(0);
            $table->double('discount_amount', 12, 2)->default(0);

            $table->string('session_id')->nullable();
            $table->bigInteger('orderId')->nullable();






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
