<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliation extends Model
{
    function user() 
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    function union() 
    {
        return $this->hasOne(Union::class, 'id', 'union_id');
    }
}
