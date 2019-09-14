<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachingStudioMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_studio_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_rejected')->default(0);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('teaching_studio_id')->unsigned();
            $table->enum('user_type', ['user', 'teachere']);
            $table->foreign('teaching_studio_id')->references('id')->on('teaching_studios')->onDelete('cascade');
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
        Schema::dropIfExists('teaching_studio_members');
    }
}
