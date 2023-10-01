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
            $table->double('amount', 12, 2)->default(0);
            $table->enum('type', ['percentage', 'amount']);
            $table->string('user_type')->default('user');
            $table->timestamp('ended_at')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('user_frequency')->default(0);
            $table->integer('all_frequency')->default(0);
            $table->double('max_value', 12, 2)->default(0);
            $table->double('min_value', 12, 2)->default(0);
            $table->boolean('free_shipping')->default(false);
            $table->longText('products')->nullable();
            $table->longText('categories')->nullable();
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
