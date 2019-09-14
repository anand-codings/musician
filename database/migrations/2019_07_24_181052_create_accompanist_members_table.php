<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccompanistMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accompanist_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('is_approved', ['1', '0'])->nullable()->default('0');
            $table->enum('is_rejected', ['1', '0'])->nullable()->default('0');
            $table->boolean('is_invited')->default(0);
            $table->bigInteger('user_id')->unsigned();
            $table->string('type')->nullable()->default('member');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('accompanist_members');
    }
}
