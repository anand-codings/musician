<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Accompanist extends Model {

    function user() {
        return $this->hasOne(User::class, 'id', 'admin_id');
    }

    function accompanistImages() {
        return $this->hasMany('App\AccompanistImage');
    }
    
    function members() {
        return $this->hasMany('App\AccompanistMember');
    }

    function approvedMembers() {
        return $this->hasMany('App\AccompanistMember')->where(['is_approved' => 1, 'is_rejected' => 0]);
    }
    
    function checkMember() {
        return $this->hasOne('App\AccompanistMember')
                ->when(Auth::user(), function($q) {
                            $q->where(['user_id' => Auth::user()->id]);
                        });
    }

    function getEducations() {
        return $this->hasMany('App\AccompanistEducation', 'accompanist_id', 'id');
    }

    function getExperiences() {
        return $this->hasMany('App\AccompanistExperience', 'accompanist_id', 'id');
    }

    function bookmarked() {
        return $this->hasOne(Bookmark::class, 'accompanist_id')
                        ->when(Auth::user(), function($q) {
                            $q->where(['user_id' => Auth::user()->id, 'post_type' => 'accompanist']);
                        });
    }

    function getReviews() {
        return $this->hasMany('App\Review', 'accompanist_id', 'id')->orderBy('updated_at', 'desc');
    }

    function unit() {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    function getFiveStarReviews(){
        return $this->hasMany('App\Review', 'accompanist_id', 'id')->where('rating', '=', 5);
    }
    function getFourStarReviews(){
        return $this->hasMany('App\Review', 'accompanist_id', 'id')->where('rating', '>=', 4)->where('rating', '<', 5);
    }
    function getThreeStarReviews(){
        return $this->hasMany('App\Review', 'accompanist_id', 'id')->where('rating', '>=', 3)->where('rating', '<', 4);
    }
    function getTwoStarReviews(){
        return $this->hasMany('App\Review', 'accompanist_id', 'id')->where('rating', '>=', 2)->where('rating', '<', 3);
    }
    function getOneStarReviews(){
        return $this->hasMany('App\Review', 'accompanist_id', 'id')->where('rating', '>=', 1)->where('rating', '<', 2);
    }
    function getFollowers(){
        return $this->hasMany(FollowServie::class, 'accompanist_id', 'id');
    }
    function getDoneBookings() {
        return $this->hasMany('App\Booking', 'accompanist_id', 'id')->where('status', 'payment_approved');
    }
    function getProfileViews() {
        return $this->hasMany(ServiceProfileView::class, 'accompanist_id', 'id')->orderBy('updated_at', 'desc');
    }
    function getSelectedCategories()
    {
        return $this->hasMany('App\SelectedAccompanistCategory', 'accompanist_id', 'id');
    }
}
