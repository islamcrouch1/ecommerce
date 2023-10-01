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
        Schema::create('manufacturing_order_components', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('product_combination_id')->nullable();
            $table->double('qty', 12, 2)->default(0);
            $table->integer('done_qty')->default(0);
            $table->integer('unit_id')->nullable();
            $table->integer('manufacturing_order_id')->nullable();
            $table->integer('warehouse_id')->nullable();
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
        Schema::dropIfExists('manufacturing_order_components');
    }
};
