<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversation_replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('conversation_id');
            $table->bigInteger('user_id ');
            $table->bigInteger('project_id');
            $table->bigInteger('file_id');
            $table->text('teks');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('conversation_id')->references('id')->on('conversations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversation_replies');
    }
}
