<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Illuminate\Support\Facades\Auth;

class CollaborativeFriend extends Model
{
    function getFriendDetail()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
