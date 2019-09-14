<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccompanistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accompanists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->boolean('allow_booking')->default(0);
            $table->string('location')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('gender')->nullable();
            $table->longText('description')->nullable();
            $table->string('pic')->nullable();
            $table->string('original_pic')->nullable();
            $table->string('original_cover')->nullable();
            $table->string('cover')->nullable();
            $table->string('language')->nullable();
            $table->string('price')->nullable();
            $table->string('per_unit')->nullable();
            $table->bigInteger('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->string('rating')->nullable()->default(0);
            $table->string('rating_percentage')->nullable()->default(0);
            $table->string('number_of_reviews')->nullable()->default(0);
            $table->bigInteger('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('accompanists');
    }
}
