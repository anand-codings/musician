<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatGroupMessage extends Model
{
    function chatgroup() {
        return $this->hasOne('\App\ChatGroup', 'id', 'chat_group_id');
    }
    
    function receiver() {
        return $this->hasMany('\App\ChatGroupMember', 'chat_group_id', 'chat_group_id');
    }
    
    function sender() {
        return $this->hasOne('\App\User', 'id', 'sender_id');
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
