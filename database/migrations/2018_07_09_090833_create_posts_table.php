<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('text')->nullable();
            $table->enum('type', ['text', 'image', 'audio', 'video', 'gig'])->nullable();
            $table->longText('edit_data')->nullable();
//            $table->enum('type', ['text', 'image', 'audio', 'video','gig'])->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('post_type', ['g', 'u', 's', 'e', 'a'])->nullable()->default('u');
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
//            $table->bigInteger('event_id')->unsigned()->nullable();
//            $table->foreign('event_id')->references('id')->on('post_events')->onDelete('cascade');
            $table->bigInteger('studio_id')->unsigned()->nullable();
            $table->foreign('studio_id')->references('id')->on('teaching_studios')->onDelete('cascade');
            $table->bigInteger('accompanist_id')->unsigned()->nullable();
            $table->foreign('accompanist_id')->references('id')->on('accompanists')->onDelete('cascade');
            $table->boolean('on_timeline')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('posts');
    }

}
