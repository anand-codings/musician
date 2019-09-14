<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model {

    function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    function posts() {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }

    function teachingStudio() {
        return $this->hasOne(TeachingStudio::class, 'id', 'teaching_studio_id');
    }

    function accompanist() {
        return $this->hasOne(Accompanist::class, 'id', 'accompanist_id');
    }

    function group() {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

}
