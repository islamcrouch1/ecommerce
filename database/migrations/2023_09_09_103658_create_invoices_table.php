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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->integer('customer_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->longText('notes')->nullable();

            $table->double('total_price', 12, 2)->default(0);
            $table->double('subtotal_price', 12, 2)->default(0);

            $table->double('shipping_amount', 12, 2)->default(0);
            $table->integer('shipping_method_id')->nullable();

            $table->enum('status', ['invoice', 'bill', 'credit_note', 'debit_note']);
            $table->enum('payment_status', ['pending', 'paid', 'partial'])->default('pending');

            $table->double('discount_amount', 12, 2)->default(0);

            $table->integer('currency_id')->nullable();

            $table->string('serial')->nullable();

            $table->integer('order_id')->nullable();
            $table->integer('admin_id')->nullable();

            $table->timestamp('due_date')->nullable();

            $table->boolean('is_seen')->default('0')->comment('1 for seen & 0 for unseen');
            $table->enum('is_sent', ['yes', 'no'])->default('no');


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
        Schema::dropIfExists('invoices');
    }
};
