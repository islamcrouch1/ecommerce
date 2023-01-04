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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('product_combination_id')->nullable();
            $table->integer('warehouse_id');
            $table->integer('customer_id')->nullable();
            $table->enum('stock_status', ['IN', 'OUT']);
            $table->integer('qty');
            $table->double('reference_price', 8, 2)->default(0);
            $table->integer('reference_id')->nullable()->comment('purchase id, sale id, order id & stock transfer');
            $table->enum('stock_type', ['StockAdjustment', 'Purchase', 'Sale', 'Order', 'StockTransfer', 'SaleReturn', 'PurchaseReturn', 'ManualSale', 'Installment']);
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
        Schema::dropIfExists('stocks');
    }
};
