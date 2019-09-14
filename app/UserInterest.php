<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    function getInterest()
    {
        return $this->belongsTo('App\Interest','interest_id', 'id');
    }
}
