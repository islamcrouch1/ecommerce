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
        Schema::create('salary_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->double('penalties', 8, 2)->default(0);
            $table->double('insurance', 8, 2)->default(0);
            $table->double('loans', 8, 2)->default(0);
            $table->double('rewards', 8, 2)->default(0);
            $table->double('basic_salary', 8, 2)->default(0);
            $table->double('variable_salary', 8, 2)->default(0);
            $table->double('day_salary', 8, 2)->default(0);
            $table->double('total_absence', 8, 2)->default(0);
            $table->double('total_deduction', 8, 2)->default(0);
            $table->double('net_salary', 8, 2)->default(0);
            $table->integer('absence_days')->default(0);
            $table->string('status')->nullable();
            $table->string('date')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('salary_cards');
    }
};
