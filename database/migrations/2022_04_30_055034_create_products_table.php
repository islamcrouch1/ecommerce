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

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['active', 'pending', 'rejected', 'pause'])->default('pending');
            $table->integer('country_id');
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('sku')->nullable();
            $table->text('description_en');
            $table->text('description_ar');
            $table->double('sale_price', 8, 2)->default(0);
            $table->double('max_price', 8, 2)->default(0);
            $table->double('extra_fee', 8, 2)->default(0);
            $table->double('affiliate_price', 8, 2)->default(0);
            $table->double('total_profit', 8, 2)->default(0);
            $table->integer('unlimited')->default(0);
            $table->enum('product_type', ['simple', 'variable', 'digital', 'service']);
            $table->string('product_slug')->unique();
            $table->Text('video_url')->nullable();
            $table->double('discount_price', 8, 2)->default(0);



            $table->double('product_weight', 8, 2)->nullable();
            $table->double('product_height', 8, 2)->nullable();
            $table->double('product_width', 8, 2)->nullable();
            $table->double('product_length', 8, 2)->nullable();
            $table->double('shipping_amount', 8, 2)->default(0);
            $table->integer('shipping_method_id')->nullable();



            $table->string('digital_file')->nullable();
            $table->integer('brand_id')->nullable();
            $table->enum('is_featured', ['0', '1'])->default('0')->comment('0 for not featured & 1 for featured');
            $table->enum('on_sale', ['0', '1'])->default('0')->comment('0 for not sale & 1 for on sale');
            $table->enum('top_collection', ['0', '1'])->default('0')->comment('0 for not featured & 1 for featured');
            $table->enum('best_selling', ['0', '1'])->default('0')->comment('0 for not sale & 1 for on sale');
            $table->integer('product_min_order')->nullable();
            $table->integer('product_max_order')->nullable();
            $table->string('seo_meta_tag')->nullable();
            $table->longText('seo_desc')->nullable();
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
        Schema::dropIfExists('products');
    }
};