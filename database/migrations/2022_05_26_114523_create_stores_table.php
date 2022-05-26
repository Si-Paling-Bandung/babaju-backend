<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('born_date')->nullable();
            $table->string('email')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('stores');
    }
}
