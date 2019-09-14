<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->bigInteger('search_count')->default(0);
            $table->boolean('is_for_musician')->default(0);
            $table->boolean('is_for_studio')->default(0);
            $table->boolean('is_for_accompanist')->default(0);
            $table->boolean('is_for_group')->default(0);
            $table->boolean('is_solo')->default(0);
            $table->boolean('is_ensemble')->default(0);
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
        Schema::dropIfExists('categories');
    }
}
