<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectedGigCategory extends Model
{
    function getCategory()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }
}
