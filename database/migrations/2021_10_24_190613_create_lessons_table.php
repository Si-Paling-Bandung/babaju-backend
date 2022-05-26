<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_lo');
            $table->string('name');
            $table->string('video_url')->nullable();
            $table->string('video_duration')->nullable();
            $table->text('lesson_text')->nullable();
            $table->string('lesson_attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Relation
            $table->foreign('id_lo')
                ->references('id')
                ->on('l_os')
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
        Schema::dropIfExists('lessons');
    }
}
