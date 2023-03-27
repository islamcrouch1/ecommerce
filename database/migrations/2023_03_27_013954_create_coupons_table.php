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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->double('amount', 8, 2)->default(0);
            $table->enum('type', ['percentage', 'amount']);
            $table->string('user_type')->default('user');
            $table->timestamp('ended_at')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('frequency')->default(0);
            $table->double('max_value', 8, 2)->default(0);
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
        Schema::dropIfExists('coupons');
    }
};
