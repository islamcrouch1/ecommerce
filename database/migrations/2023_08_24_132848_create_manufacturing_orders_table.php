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
        Schema::create('manufacturing_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('product_combination_id')->nullable();
            $table->double('qty', 12, 2)->default(0);
            $table->integer('unit_id')->nullable();
            $table->timestamp('scheduled_date')->nullable();
            $table->integer('sales_id')->nullable();
            $table->integer('manufacturer_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('bom_id')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('manufacturing_orders');
    }
};
