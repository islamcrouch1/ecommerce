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

            $table->float('product_price')->nullable();
            $table->float('product_tax')->nullable();
            $table->float('product_discount')->nullable();
            $table->float('total')->nullable();
            $table->integer('qty')->nullable();

            $table->double('affiliate_price', 8, 2)->nullable();
            $table->double('total_affiliate_price', 8, 2)->nullable();

            $table->double('commission_per_item', 8, 2)->nullable();
            $table->double('profit_per_item', 8, 2)->nullable();
            $table->double('total_commission', 8, 2)->nullable();
            $table->double('total_profit', 8, 2)->nullable();

            $table->double('extra_shipping_amount', 8, 2)->nullable();
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
