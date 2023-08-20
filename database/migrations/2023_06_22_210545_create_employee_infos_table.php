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
        Schema::create('employee_infos', function (Blueprint $table) {
            $table->id();
            $table->double('basic_salary', 8, 2)->default(0);
            $table->double('variable_salary', 8, 2)->default(0);
            $table->double('work_hours', 8, 2)->default(0);
            $table->longText('address')->nullable();
            $table->longText('name')->nullable();
            $table->longText('job_title')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('national_id')->nullable();
            $table->longText('Weekend_days')->nullable();
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
        Schema::dropIfExists('employee_infos');
    }
};
