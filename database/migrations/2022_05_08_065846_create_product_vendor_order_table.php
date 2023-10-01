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
            $table->double('product_price', 12, 2)->default(0);
            $table->double('commission', 12, 2)->default(0);
            $table->double('qty', 12, 2)->default(0);
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
