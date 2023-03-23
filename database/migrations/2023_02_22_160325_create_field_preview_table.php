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
        Schema::create('field_preview', function (Blueprint $table) {
            $table->id();
            $table->integer('preview_id');
            $table->integer('stage_id');
            $table->integer('field_id');
            $table->integer('media_id')->nullable();
            $table->integer('score')->nullable();
            $table->string('type')->nullable();
            $table->longText('data')->nullable();
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
        Schema::dropIfExists('field_preview');
    }
};
