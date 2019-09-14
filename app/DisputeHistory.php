<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DisputeHistory extends Model {

    function disputeEvidence() {
        return $this->hasMany('App\DisputeEvidence', 'dispute_history_id', 'id')->orderBy('created_at', 'asc');
    }
    
    function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
