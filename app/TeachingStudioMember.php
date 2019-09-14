<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeachingStudioMember extends Model
{
    function getMemberDetail()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    function getTeachingStudio()
    {
        return $this->belongsTo('App\TeachingStudio', 'teaching_studio_id', 'id');
    }
}
