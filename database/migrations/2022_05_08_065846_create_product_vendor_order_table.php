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
        Schema::create('product_vendor_order', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('product_combination_id')->nullable();
            $table->enum('product_type', ['simple', 'variable', 'digital', 'service']);
            $table->integer('vendor_order_id');
            $table->integer('warehouse_id');
            $table->double('vendor_price', 8, 2)->nullable();
            $table->double('total_vendor_price', 8, 2)->nullable();
            $table->integer('qty');
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
        Schema::dropIfExists('product_vendor_order');
    }
};
