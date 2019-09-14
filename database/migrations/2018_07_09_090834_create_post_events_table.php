<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('location')->nullable();
            $table->string('lat')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('original_profile_pic')->nullable();
            $table->string('image')->nullable();
            $table->string('lng')->nullable();
            $table->string('range')->nullable();
            $table->string('cover')->nullable();
            $table->string('rating')->nullable()->default(0);
            $table->string('rating_percentage')->nullable()->default(0);
            $table->string('number_of_reviews')->nullable()->default(0);
            $table->string('price')->nullable();
            $table->string('per_unit')->nullable();
            $table->bigInteger('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->nullable();
            $table->boolean('allow_booking')->default(0);
            $table->string('event_date')->nullable();
            $table->string('event_time')->nullable();
            $table->dateTime('utc_date_time')->nullable();
            $table->string('timezone')->nullable();
            $table->string('genre')->nullable();
            $table->bigInteger('ensemble_category_id')->unsigned();
            $table->foreign('ensemble_category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->bigInteger('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('post_events');
    }
}
