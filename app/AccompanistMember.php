<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccompanistMember extends Model
{
    function getMemberDetail()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    function getAccompanistDetail()
    {
        return $this->belongsTo('App\Accompanist', 'accompanist_id', 'id');
    }
}
