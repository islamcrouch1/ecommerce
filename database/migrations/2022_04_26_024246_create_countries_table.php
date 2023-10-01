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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('code');
            $table->string('currency');
            $table->integer('media_id')->nullable();
            $table->double('shipping_amount', 12, 2)->default(0);
            $table->enum('status', ['active', 'inactive', 'disable'])->default('active');
            $table->enum('is_default', ['0', '1'])->default('0')->comment('0 for not default & 1 for default');
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
        Schema::dropIfExists('countries');
    }
};
