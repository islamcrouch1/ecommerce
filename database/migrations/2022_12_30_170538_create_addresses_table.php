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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->longText('name')->nullable();
            $table->longText('address')->nullable();
            $table->longText('notes')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();

            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();

            $table->longText('house')->nullable();
            $table->longText('special_mark')->nullable();

            $table->longText('block')->nullable();
            $table->longText('avenue')->nullable();

            $table->longText('floor_no')->nullable();
            $table->longText('delivery_time')->nullable();



            $table->enum('is_default_billing', ['1', '0'])->default('0');
            $table->enum('is_default_shipping', ['1', '0'])->default('0');
            $table->integer('user_id')->nullable();
            $table->string('session_id')->nullable();
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
        Schema::dropIfExists('adresses');
    }
};
