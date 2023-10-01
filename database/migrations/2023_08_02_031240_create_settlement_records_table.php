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
        Schema::create('settlement_records', function (Blueprint $table) {
            $table->id();
            $table->integer('settlement_sheet_id')->nullable();
            $table->longText('statement')->nullable();
            $table->double('amount', 12, 2)->default(0);
            $table->integer('media_id')->nullable();
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('settlement_records');
    }
};
