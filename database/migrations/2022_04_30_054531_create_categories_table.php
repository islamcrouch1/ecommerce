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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id');
            $table->string('parent_id')->nullable();
            $table->string('name_en');
            $table->string('name_ar');
            $table->longText('description_en');
            $table->longText('description_ar');
            $table->double('profit', 8, 2)->default(0);
            $table->integer('media_id')->nullable();
            // $table->string('image');
            $table->string('category_slug')->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->string('subtitle_ar')->nullable();
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
        Schema::dropIfExists('categories');
    }
};
