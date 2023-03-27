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
        Schema::create('running_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('product_combination_id')->nullable();
            $table->integer('warehouse_id');
            $table->integer('stock_id');
            $table->integer('user_id')->nullable();
            $table->enum('stock_status', ['IN', 'OUT']);
            $table->integer('requested_qty');
            $table->integer('approved_qty')->default(0);
            $table->integer('returned_qty')->default(0);
            $table->integer('reference_id')->nullable()->comment('purchase id, sale id, order id & stock transfer');
            $table->enum('stock_type', ['StockAdjustment', 'Purchase', 'Sale', 'Order', 'StockTransfer', 'SaleReturn', 'PurchaseReturn', 'ManualSale', 'Installment']);
            $table->enum('status', ['pending', 'partial', 'completed'])->default('pending');
            $table->longText('notes')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('running_orders');
    }
};
