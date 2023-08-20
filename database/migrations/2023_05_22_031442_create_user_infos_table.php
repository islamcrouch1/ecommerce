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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->nullable();
            $table->longText('store_description')->nullable();
            $table->integer('store_profile')->nullable();
            $table->integer('store_cover')->nullable();
            $table->integer('commercial_record')->nullable();
            $table->integer('tax_card')->nullable();
            $table->integer('id_card_front')->nullable();
            $table->integer('id_card_back')->nullable();
            $table->string('company_address')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_page')->nullable();
            $table->integer('store_status')->default(1);
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('user_infos');
    }
};
