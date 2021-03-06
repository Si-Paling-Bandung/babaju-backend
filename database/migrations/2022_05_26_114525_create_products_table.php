<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->unsignedBigInteger('id_store');
            $table->unsignedBigInteger('id_material');
            $table->string('title');
            $table->text('description');
            $table->string('type');
            $table->string('status')->default('publish');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_store')
                ->references('id')
                ->on('stores')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_material')
                ->references('id')
                ->on('materials')
                ->onDelete('cascade')->onUpdate('cascade');
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
}
