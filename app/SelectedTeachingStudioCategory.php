<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectedTeachingStudioCategory extends Model
{
    function getCategory()
    {
        return $this->belongsTo('App\Category', 'studio_category_id', 'id');
    }
}
