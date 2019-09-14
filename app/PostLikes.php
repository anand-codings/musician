<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLikes extends Model
{
    function post() {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
    
    function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
