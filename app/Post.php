<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model {

    function getFile() {
        return $this->hasOne(PostFile::class);
    }

    function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function reported() {
        return $this->hasOne(PostReport::class, 'post_id')
                        ->when(Auth::user(), function($q) {
                            $q->where('user_id', Auth::user()->id);
                        });
    }
     function isMusicianFriend(){
        return $this->hasOne(CollaborativeFriend::class, 'friend_id', 'user_id')
                            ->where('user_id', Auth::user()->id)
                            ->where('is_approved', 1);
    }
    
    function isMusicianFollower(){
        return $this->hasOne(UserFollower::class, 'user_id', 'user_id')
                            ->where('followed_by', Auth::user()->id);
    }
  function comments() {
        return $this->hasMany(Comment::class, 'post_id')->orderBy('created_at', 'asc');
    }

    function getEvent() {
        return $this->hasOne(PostEvent::class, 'post_id', 'id');
    }

    function liked() {
        return $this->hasOne(PostLikes::class, 'post_id')
                        ->when(Auth::user(), function($q) {
                            $q->where('user_id', Auth::user()->id);
                        });
    }

    function likes() {
        return $this->hasmany(PostLikes::class, 'post_id');
    }

    function bookmarked() {
        return $this->hasOne(Bookmark::class, 'post_id')
                        ->when(Auth::user(), function($q) {
                            $q->where('user_id', Auth::user()->id)->where('post_type', '!=', 'group');
                        });
    }

    function gig() {
        return $this->hasOne(PostEvent::class, 'id', 'event_id');
    }

    function studio() {
        return $this->hasOne(TeachingStudio::class, 'id', 'studio_id');
    }

    function accompanist() {
        return $this->hasOne(Accompanist::class, 'id', 'accompanist_id');
    }

    function events() {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

}
