<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadKeywordTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thread_keyword_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_thread');
            $table->unsignedBigInteger('id_thread_keyword');
            $table->timestamps();

            $table->foreign('id_thread')
                ->references('id')
                ->on('threads')
                ->onDelete('cascade');

            $table->foreign('id_thread_keyword')
                ->references('id')
                ->on('thread_keywords')
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
        Schema::dropIfExists('thread_keyword_temps');
    }
}
