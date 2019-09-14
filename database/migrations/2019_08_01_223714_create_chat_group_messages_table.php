<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatGroupMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_group_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('chat_group_id')->unsigned();
            $table->foreign('chat_group_id')->references('id')->on('chat_groups')->onDelete('cascade');
            $table->bigInteger('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('sender_id')->unsigned();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->longText('message')->nullable();
            $table->string('file_type')->nullable();
            $table->string('file_path')->nullable();
            $table->string('poster')->nullable();
            $table->boolean('is_read')->default(0);
            $table->boolean('sender_deleted')->default(0);
            $table->enum('message_type', ['g', 'u', 's', 'a'])->nullable()->nullable()->default('u');
            $table->bigInteger('type_id')->default(0);
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->bigInteger('studio_id')->unsigned()->nullable();
            $table->foreign('studio_id')->references('id')->on('teaching_studios')->onDelete('cascade');
            $table->bigInteger('accompanist_id')->unsigned()->nullable();
            $table->foreign('accompanist_id')->references('id')->on('accompanists')->onDelete('cascade');
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
        Schema::dropIfExists('chat_group_messages');
    }
}
