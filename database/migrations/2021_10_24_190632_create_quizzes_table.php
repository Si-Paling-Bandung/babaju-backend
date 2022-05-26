<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_topic');
            $table->text('question');
            $table->text('answer_1');
            $table->text('answer_2');
            $table->text('answer_3');
            $table->text('answer_4');
            $table->enum('key', ['answer_1', 'answer_2', 'answer_3', 'answer_4'])->default('answer_1');
            $table->text('explanation');
            $table->enum('type', ['pre_test', 'post_test'])->default('post_test');
            $table->timestamps();
            $table->softDeletes();

            // Relation
            $table->foreign('id_topic')
                ->references('id')
                ->on('topics')
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
        Schema::dropIfExists('quizzes');
    }
}
