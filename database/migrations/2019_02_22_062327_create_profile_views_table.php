<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileViewsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('profile_views', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('viewed_by')->unsigned();
            $table->foreign('viewed_by')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('profile_viewed')->unsigned();
            $table->foreign('profile_viewed')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('profile_views');
    }

}
