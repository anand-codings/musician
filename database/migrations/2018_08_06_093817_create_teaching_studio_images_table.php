<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachingStudioImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaching_studio_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file')->nullable();
            $table->bigInteger('teaching_studio_id')->unsigned();
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
        Schema::dropIfExists('teaching_studio_images');
    }
}
