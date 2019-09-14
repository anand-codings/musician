<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    function notificationSentBy() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function notificationSentTo() {
        return $this->hasOne(User::class, 'id', 'on_user');
    }

    function group() {
        return $this->hasOne(Group::class, 'id', 'type_id');
    }

    function studio() {
        return $this->hasOne(TeachingStudio::class, 'id', 'type_id');
    }
    
    function accompanist() {
        return $this->hasOne(Accompanist::class, 'id', 'type_id');
    }
    
    function friend() {
        return $this->hasOne(User::class, 'id', 'type_id');
    }

    function booking() {
        return $this->hasOne(Booking::class, 'id', 'type_id');
    }

    function postLike() {
        return $this->hasOne(PostLikes::class, 'id', 'type_id');
    }

    function postComment() {
        return $this->hasOne(Comment::class, 'id', 'type_id');
    }
}
