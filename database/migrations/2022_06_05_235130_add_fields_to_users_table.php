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
        Schema::table('users', function (Blueprint $table) {
            $table->string('store_name')->nullable();
            $table->string('store_description')->nullable();
            $table->string('store_profile')->nullable();
            $table->string('store_cover')->nullable();
            $table->integer('store_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('store_name');
            $table->dropColumn('store_profile');
            $table->dropColumn('store_cover');
            $table->dropColumn('store_status');
            $table->dropColumn('store_description');
        });
    }
};
