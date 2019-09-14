<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    
    function post(){
        return $this->hasOne(Post::class,'id','post_id');
    }
}
