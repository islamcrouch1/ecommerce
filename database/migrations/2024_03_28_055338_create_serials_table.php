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
        Schema::create('serials', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('product_combination_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->longText('serial')->nullable();
            $table->enum('status', [0, 1, 2])->default(0);
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
        Schema::dropIfExists('serials');
    }
};
