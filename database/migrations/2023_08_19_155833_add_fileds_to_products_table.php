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
        Schema::table('products', function (Blueprint $table) {
            $table->string('code')->nullable();
            $table->string('can_sold')->nullable();
            $table->string('can_purchased')->nullable();
            $table->string('can_manufactured')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            Schema::dropIfExists('code');
            Schema::dropIfExists('can_sold');
            Schema::dropIfExists('can_purchased');
            Schema::dropIfExists('can_manufactured');
        });
    }
};
