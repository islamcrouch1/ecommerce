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
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('order_deadline')->nullable();
            $table->timestamp('expected_delivery')->nullable();
            $table->enum('order_type', ['RFQ', 'PO', 'Q', 'SO']);
            $table->enum('is_sent', ['yes', 'no'])->default('no');
            $table->bigInteger('serial')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            Schema::dropIfExists('order_deadline');
            Schema::dropIfExists('expected_delivery');
            Schema::dropIfExists('order_type');
            Schema::dropIfExists('is_sent');
            Schema::dropIfExists('serial');
        });
    }
};
