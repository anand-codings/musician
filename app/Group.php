<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Group extends Model {

    function user() {
        return $this->hasOne(User::class, 'id', 'admin_id');
    }

    function members() {
        return $this->hasMany('App\GroupMember');
    }

    function approvedMembers() {
        return $this->hasMany('App\GroupMember')->where(['is_approved' => 1, 'is_rejected' => 0]);
    }
    
    function checkMember() {
        return $this->hasOne('App\GroupMember')
                ->when(Auth::user(), function($q) {
                            $q->where(['user_id' => Auth::user()->id]);
                        });
    }

    function bookings() {
        return $this->hasMany('App\Booking');
    }

    function getDoneBookings() {
        return $this->hasMany('App\Booking')->where('status', 'payment_approved');
    }

    function groupImages() {
        return $this->hasMany('App\GroupImage');
    }

    function getCategory() {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    function bookmarked() {
        return $this->hasOne(Bookmark::class, 'group_id')
                        ->when(Auth::user(), function($q) {
                            $q->where(['user_id' => Auth::user()->id, 'post_type' => 'group']);
                        });
    }

    function reported() {
        return $this->hasOne(GroupReport::class, 'group_id')
                        ->when(Auth::user(), function($q) {
                            $q->where('user_id', Auth::user()->id);
                        });
    }

    function getReviews() {
        return $this->hasMany('App\Review', 'group_id', 'id')->orderBy('updated_at', 'desc');
    }

    function getFiveStarReviews() {
        return $this->hasMany('App\Review', 'group_id', 'id')->where('rating', '=', 5);
    }

    function getFourStarReviews() {
        return $this->hasMany('App\Review', 'group_id', 'id')->where('rating', '>=', 4)->where('rating', '<', 5);
    }

    function getThreeStarReviews() {
        return $this->hasMany('App\Review', 'group_id', 'id')->where('rating', '>=', 3)->where('rating', '<', 4);
    }

    function getTwoStarReviews() {
        return $this->hasMany('App\Review', 'group_id', 'id')->where('rating', '>=', 2)->where('rating', '<', 3);
    }

    function getOneStarReviews() {
        return $this->hasMany('App\Review', 'group_id', 'id')->where('rating', '>=', 1)->where('rating', '<', 2);
    }

    function getFollowers() {
        return $this->hasMany(FollowServie::class, 'group_id', 'id');
    }

    function getProfileViews() {
        return $this->hasMany(ServiceProfileView::class, 'group_id', 'id')->orderBy('updated_at', 'desc');
    }
    
    function getCollaborativeFriends() {
        return $this->hasMany('App\CollaborativeFriend', 'group_id', 'id')->where('is_approved','1')->orderBy('updated_at', 'desc');
    }
    
    function checkGroupMember() {
        return $this->hasOne('App\CollaborativeFriend', 'group_id', 'id')->where('friend_id',Auth::user()->id)->where('type','event_member');
    }

}
