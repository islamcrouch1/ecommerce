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


            $table->double('product_price', 8, 2)->default(0);
            $table->double('product_tax', 8, 2)->default(0);
            $table->double('product_wht', 8, 2)->default(0);
            $table->double('product_discount', 8, 2)->default(0);
            $table->double('total', 8, 2)->default(0);

            $table->double('cost', 8, 2)->default(0);


            $table->integer('qty')->default(0);
            $table->enum('product_type', ['simple', 'variable', 'digital', 'service']);

            $table->double('affiliate_price', 8, 2)->default(0);
            $table->double('total_affiliate_price', 8, 2)->default(0);

            $table->double('commission_per_item', 8, 2)->default(0);
            $table->double('profit_per_item', 8, 2)->default(0);
            $table->double('total_commission', 8, 2)->default(0);
            $table->double('total_profit', 8, 2)->default(0);

            $table->double('extra_shipping_amount', 8, 2)->default(0);
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
