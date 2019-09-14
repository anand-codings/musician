<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    function getUser()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    function gig()
    {
        return $this->belongsTo('App\PostEvent', 'gig_id', 'id');
    }
    
    function group()
    {
        return $this->belongsTo('App\Group', 'group_id', 'id');
    }
    
    function studio()
    {
        return $this->belongsTo('App\TeachingStudio', 'teaching_studio_id', 'id');
    }
    
    function accompanist()
    {
        return $this->belongsTo('App\Accompanist', 'accompanist_id', 'id');
    }
    
    function getReviewedByUser()
    {
        return $this->belongsTo('App\User', 'reviewed_by', 'id');
    }
}
