<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ChatGroup extends Model
{
    function sender() {
        return $this->hasOne('\App\User', 'id', 'admin_id')->select(['id', 'first_name', 'last_name', 'is_online', 'photo', 'social_photo', 'is_online', 'is_active']);
    }

    function receiver() {
        return $this->hasMany('\App\ChatGroupMember', 'chat_group_id');
    }

    function lastMessage() {
        return $this->hasOne('\App\ChatGroupMessage', 'id', 'last_message_id');
    }

    function messages() {
        return $this->hasMany('\App\ChatGroupMessage', 'chat_group_id', 'id');
    }
    function getRelatedChat() {
        return $this->hasMany('\App\ChatGroupMember', 'chat_group_id', 'id')->where('member_id',Auth::user()->id);
    }
    
    function getLoggedInStatus() {
        return $this->hasOne('\App\ChatGroupMember', 'chat_group_id', 'id')->where('member_id',Auth::user()->id);
    }
    
    function studio() {
        return $this->hasOne(TeachingStudio::class, 'id', 'type_id');
    }

    function accompanist() {
        return $this->hasOne(Accompanist::class, 'id', 'type_id');
    }

    function group() {
        return $this->hasOne(Group::class, 'id', 'type_id');
    }
    
    
}
