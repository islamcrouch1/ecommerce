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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();

            $table->integer('order_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->integer('product_combination_id')->nullable();


            $table->double('product_price', 12, 2)->default(0);
            $table->double('product_tax', 12, 2)->default(0);
            $table->double('product_wht', 12, 2)->default(0);
            $table->double('product_discount', 12, 2)->default(0);
            $table->double('total', 12, 2)->default(0);

            $table->double('cost', 12, 2)->default(0);


            $table->double('qty', 12, 2)->default(0);
            $table->enum('product_type', ['simple', 'variable', 'digital', 'service']);

            $table->double('affiliate_price', 12, 2)->default(0);
            $table->double('total_affiliate_price', 12, 2)->default(0);

            $table->double('commission_per_item', 12, 2)->default(0);
            $table->double('profit_per_item', 12, 2)->default(0);
            $table->double('total_commission', 12, 2)->default(0);
            $table->double('total_profit', 12, 2)->default(0);

            $table->double('extra_shipping_amount', 12, 2)->default(0);
            $table->integer('shipping_method_id')->nullable();

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
        Schema::dropIfExists('order_product');
    }
};
