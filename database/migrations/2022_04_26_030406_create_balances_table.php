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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->double('available_balance', 8, 2);
            $table->double('outstanding_balance', 8, 2);
            $table->double('pending_withdrawal_requests', 8, 2);
            $table->double('completed_withdrawal_requests', 8, 2);
            $table->double('bonus', 12, 2)->default(0);
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
        Schema::dropIfExists('balances');
    }
};
