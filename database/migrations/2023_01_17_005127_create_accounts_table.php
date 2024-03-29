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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('code')->nullable();
            $table->enum('account_type', ['assets', 'revenue', 'liability', 'expenses', 'owners_equity'])->default('assets');
            $table->tinyInteger('status')->default('1')->comment('1 for active & 0 for inactive');
            $table->integer('parent_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('reference_id')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('accounts');
    }
};
