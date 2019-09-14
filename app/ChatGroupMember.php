<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatGroupMember extends Model
{
   function getMemberDetail(){
        return $this->belongsTo('App\User', 'member_id', 'id');
    }
}
