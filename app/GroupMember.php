<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    function getMemberDetail()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    function getGroupAdminDetail()
    {
        return $this->belongsTo('App\Group', 'group_id', 'id');
    }
}
