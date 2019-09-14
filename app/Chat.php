<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model {

    function sender() {
        return $this->hasOne('\App\User', 'id', 'sender_id')->select(['id', 'first_name', 'last_name', 'is_online', 'photo', 'social_photo', 'is_online', 'is_active']);
    }

    function receiver() {
        return $this->hasOne('\App\User', 'id', 'receiver_id')->select(['id', 'first_name', 'last_name', 'is_online', 'photo', 'social_photo', 'is_online', 'is_active']);
    }

    function lastMessage() {
        return $this->hasOne('\App\ChatMessage', 'id', 'last_message_id');
    }

    function messages() {
        return $this->hasMany('\App\ChatMessage', 'chat_id')->where('receiver_id', Auth::user()->id);
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
