<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PostEvent extends Model
{
    function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    function unit() {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }
    function bookings() {
        return $this->hasMany(Booking::class, 'gig_id', 'id');
    }
    function successfulBookings() {
        return $this->hasMany(Booking::class, 'gig_id', 'id')->where('status', 'payment_delivered');
    }
    function getUnfinishedBookings() {
        return $this->hasMany(Booking::class, 'gig_id', 'id')
                ->where('booked_by', Auth::id())
                ->where('status', '!=', 'admin_rejected')
                ->where('status', '!=', 'payment_delivered');
    }
    function getReviews(){
        return $this->hasMany('App\Review', 'gig_id', 'id')->orderBy('updated_at', 'desc');
    }
    
    function getSelectedCategories()
    {
        return $this->hasMany('App\SelectedGigCategory', 'gig_id', 'id');
    }
    function ensembleCategory() {
        return $this->hasOne(Category::class, 'id', 'ensemble_category_id');
    }
    function getFiveStarReviews(){
        return $this->hasMany('App\Review', 'gig_id', 'id')->where('rating', '=', 5);
    }
    function getFourStarReviews(){
        return $this->hasMany('App\Review', 'gig_id', 'id')->where('rating', '>=', 4)->where('rating', '<', 5);
    }
    function getThreeStarReviews(){
        return $this->hasMany('App\Review', 'gig_id', 'id')->where('rating', '>=', 3)->where('rating', '<', 4);
    }
    function getTwoStarReviews(){
        return $this->hasMany('App\Review', 'gig_id', 'id')->where('rating', '>=', 2)->where('rating', '<', 3);
    }
    function getOneStarReviews(){
        return $this->hasMany('App\Review', 'gig_id', 'id')->where('rating', '>=', 1)->where('rating', '<', 2);
    }
}
