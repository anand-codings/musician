<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void

     */
    public function up() {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('on_user')->unsigned();
            $table->foreign('on_user')->references('id')->on('users')->onDelete('cascade');
            $table->longText('activity_log')->nullable();
            $table->longText('notification_text')->nullable();
            $table->longText('unique_text')->nullable();
            $table->string('model')->nullable();
            $table->boolean('is_read')->default(0);
            $table->enum('type', ['message','accompanist', 'like', 'comment','post', 'booking', 'follow', 'review', 'payment request', 'payment approved', 'payment rejected', 'group', 'teaching_studio'])->nullable();
            $table->bigInteger('type_id')->nullable();
            $table->boolean('is_group_request_response')->default(0);
            $table->boolean('is_group_admin_responded')->default(0);
            $table->boolean('is_group_invite')->default(0);
            $table->boolean('is_group_invitee_responded')->default(0);
            $table->boolean('is_group_admin_invitation_response')->default(0);
            $table->boolean('is_accompanist_request_response')->default(0);
            $table->boolean('is_accompanist_admin_responded')->default(0);
            $table->boolean('is_accompanist_invite')->default(0);
            $table->boolean('is_accompanist_invitee_responded')->default(0);
            $table->boolean('is_accompanist_admin_invitation_response')->default(0);
            $table->boolean('is_studio_request_response')->default(0);
            $table->boolean('is_studio_admin_responded')->default(0);
            $table->boolean('is_studio_invite')->default(0);
            $table->boolean('is_studio_invitee_responded')->default(0);
            $table->boolean('is_studio_admin_invitation_response')->default(0);
            $table->boolean('is_friend_request_response')->default(0);
            $table->boolean('is_friend_responded')->default(0);
            $table->boolean('is_friend_invite')->default(0);
            $table->boolean('is_friend_invitee_responded')->default(0);
            $table->boolean('is_friend_invitation_response')->default(0);
            $table->boolean('left_notification')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('notifications');
    }

}
