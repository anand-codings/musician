<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectedAccompanistCategory extends Model
{
    function getCategory()
    {
        return $this->belongsTo('App\Category', 'accompanist_category_id', 'id');
    }
}
