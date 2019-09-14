<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupReport extends Model
{
    function reporterUser(){
        return $this->hasOne(User::class,'id','user_id');
    }
    
    function group(){
        return $this->hasOne(Group::class,'id','group_id');
    }
}
