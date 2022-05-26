<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_education_category');
            $table->string('cover_image');
            $table->string('title');
            $table->text('content');
            $table->string('lat');
            $table->string('lang');
            $table->string('location');
            $table->string('attachment');
            $table->text('form_registration');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('id_education_category')
                ->references('id')
                ->on('education_categories')
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
        Schema::dropIfExists('education');
    }
}
