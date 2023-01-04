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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('sender_id');
            $table->string('sender_name')->nullable();
            $table->string('sender_image')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('body_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('body_en')->nullable();
            $table->string('date')->nullable();
            $table->string('url')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('notifications');
    }
};
