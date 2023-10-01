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
        Schema::create('invoice_product', function (Blueprint $table) {
            $table->id();

            $table->integer('invoice_id')->nullable();
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
            $table->integer('unit_id')->nullable();

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
        Schema::dropIfExists('invoice_product');
    }
};
