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
        Schema::create('installment_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('session_id')->nullable();


            $table->longText('address')->nullable();
            $table->longText('name')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();

            $table->longText('house')->nullable();
            $table->longText('special_mark')->nullable();
            $table->longText('notes')->nullable();

            $table->string('status')->default('pending');


            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();

            $table->boolean('is_seen')->default('0')->comment('1 for seen & 0 for unseen');

            $table->longText('block')->nullable();
            $table->longText('avenue')->nullable();
            $table->longText('floor_no')->nullable();

            $table->integer('product_id')->nullable();
            $table->integer('product_combination_id')->nullable();


            $table->double('product_price', 8, 2)->default(0);
            $table->integer('installment_company_id')->nullable();
            $table->double('advanced_amount', 8, 2)->default(0);
            $table->double('admin_expenses', 8, 2)->default(0);
            $table->integer('months')->nullable();

            $table->double('installment_amount', 8, 2)->default(0);



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
        Schema::dropIfExists('installment_requests');
    }
};
