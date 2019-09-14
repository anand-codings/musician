<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

    function user() {
        return $this->hasOne(User::class, 'id', 'booked_by');
    }

    function artist() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function gig() {
        return $this->hasOne(PostEvent::class, 'id', 'gig_id');
    }

    function group() {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    function studio() {
        return $this->hasOne(TeachingStudio::class, 'id', 'teaching_studio_id');
    }

    function accompanist() {
        return $this->hasOne(Accompanist::class, 'id', 'accompanist_id');
    }

    function availablity() {
     return $this->hasOne(BookingAvailability::class, 'booking_id');   
    }
    
    function disputeHistory() {
        return $this->hasMany('App\DisputeHistory', 'booking_id', 'id')->orderBy('created_at', 'asc');
    }
    
}
