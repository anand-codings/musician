<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectedAccompanistCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selected_accompanist_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('accompanist_category_id')->unsigned();
            $table->foreign('accompanist_category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->bigInteger('accompanist_id')->unsigned();
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
        Schema::dropIfExists('selected_accompanist_categories');
    }
}
