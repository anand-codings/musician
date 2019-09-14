<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class TeachingStudio extends Model {

    function user() {
        return $this->hasOne(User::class, 'id', 'admin_id');
    }

    function teachers() {
        return $this->hasMany('App\TeachingStudioMember')->where('user_type', 'teachere')->where('is_approved','1');
    }

    function members() {
        return $this->hasMany('App\TeachingStudioMember')->where('user_type', 'user')->where('is_approved','1');
    }
    
    function checkMember() {
        return $this->hasOne('App\TeachingStudioMember')
                ->when(Auth::user(), function($q) {
                            $q->where(['user_id' => Auth::user()->id]);
                        });
    }

    function approvedTeachers()
    {
        return $this->hasMany('App\TeachingStudioMember')->where(['is_approved' => 1, 'user_type' => 'teacher']);
    }

    function approvedMembers()
    {
        return $this->hasMany('App\TeachingStudioMember')->where(['is_approved' => 1, 'user_type' => 'user']);
    }

    function teachingStudioImages() {
        return $this->hasMany('App\TeachingStudioImage');
    }
    
    function getSelectedCategories()
    {
        return $this->hasMany('App\SelectedTeachingStudioCategory', 'teaching_studio_id', 'id');
    }

    function bookmarked() {
        return $this->hasOne(Bookmark::class, 'teaching_studio_id')
                        ->when(Auth::user(), function($q) {
                            $q->where(['user_id' => Auth::user()->id, 'post_type' => 'teaching_studio']);
                        });
    }

    function isJoind() {
        if (Auth::user()) {
            return $this->hasOne(TeachingStudioMember::class, 'teaching_studio_id')->where(['user_id' => Auth::user()->id,'user_type'=>'user']);
        } else {
            return FALSE;
        }
    }
    
    function getUnion()
    {
        return $this->hasOne('App\Union', 'id', 'union_id');
    }
    
    function getReviews(){
        return $this->hasMany('App\Review', 'teaching_studio_id', 'id')->orderBy('updated_at', 'desc');
    }
    
    function unit() {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    function getEducations() {
        return $this->hasMany('App\TeachingStudioEducation', 'teaching_studio_id', 'id');
    }

    function getExperiences() {
        return $this->hasMany('App\TeachingStudioExperience', 'teaching_studio_id', 'id');
    }
    
    function getFiveStarReviews(){
        return $this->hasMany('App\Review', 'teaching_studio_id', 'id')->where('rating', '=', 5);
    }
    function getFourStarReviews(){
        return $this->hasMany('App\Review', 'teaching_studio_id', 'id')->where('rating', '>=', 4)->where('rating', '<', 5);
    }
    function getThreeStarReviews(){
        return $this->hasMany('App\Review', 'teaching_studio_id', 'id')->where('rating', '>=', 3)->where('rating', '<', 4);
    }
    function getTwoStarReviews(){
        return $this->hasMany('App\Review', 'teaching_studio_id', 'id')->where('rating', '>=', 2)->where('rating', '<', 3);
    }
    function getOneStarReviews(){
        return $this->hasMany('App\Review', 'teaching_studio_id', 'id')->where('rating', '>=', 1)->where('rating', '<', 2);
    }
    function getFollowers(){
        return $this->hasMany(FollowServie::class, 'studio_id', 'id');
    }
    function getDoneBookings() {
        return $this->hasMany('App\Booking', 'teaching_studio_id', 'id')->where('status', 'payment_approved');
    }
     function getProfileViews() {
        return $this->hasMany(ServiceProfileView::class, 'studio_id', 'id')->orderBy('updated_at', 'desc');
    }
}
