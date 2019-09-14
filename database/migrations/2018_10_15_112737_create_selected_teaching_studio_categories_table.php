<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectedTeachingStudioCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selected_teaching_studio_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('studio_category_id')->unsigned();
            $table->foreign('studio_category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('selected_teaching_studio_categories');
    }
}
