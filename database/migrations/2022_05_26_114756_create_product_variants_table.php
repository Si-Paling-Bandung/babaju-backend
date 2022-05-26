<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_product_size');
            $table->unsignedBigInteger('id_product_color');
            $table->integer('stock');
            $table->bigInteger('price');
            $table->bigInteger('discounted_price');
            $table->string('photo');
            $table->timestamps();

            $table->foreign('id_product')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('id_product_size')
                ->references('id')
                ->on('product_sizes')
                ->onDelete('cascade');

            $table->foreign('id_product_color')
                ->references('id')
                ->on('product_colors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}
