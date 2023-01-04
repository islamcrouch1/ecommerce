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
            $table->integer('product_type');
            $table->integer('vendor_order_id');
            $table->integer('stock_id');
            $table->double('vendor_price');
            $table->double('total_vendor_price');
            $table->integer('quantity');
            $table->string('size_ar');
            $table->string('size_en');
            $table->string('color_ar');
            $table->string('color_en');
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
