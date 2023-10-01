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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->nullable();
            $table->integer('reference_id')->nullable();
            $table->string('type')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->double('dr_amount', 12, 2)->default(0);
            $table->double('cr_amount', 12, 2)->default(0);
            $table->longText('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('entries');
    }
};
