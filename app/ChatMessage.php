<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model {

    function sender() {
        return $this->hasOne('\App\User', 'id', 'sender_id')->select(['id', 'first_name', 'last_name', 'photo', 'is_online', 'social_photo', 'is_online', 'is_active']);
    }

    function receiver() {
        return $this->hasOne('\App\User', 'id', 'receiver_id')->select(['id', 'first_name', 'last_name', 'is_online', 'photo', 'social_photo', 'is_online', 'is_active']);
    }

    function chatUser() {
        return $this->hasOne('\App\User', 'id', 'chat_id');
    }

    function chat() {
        return $this->hasOne('\App\Chat', 'id', 'chat_id');
    }

    function studio() {
        return $this->hasOne(TeachingStudio::class, 'id', 'studio_id');
    }

    function accompanist() {
        return $this->hasOne(Accompanist::class, 'id', 'accompanist_id');
    }

    function group() {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

}
