<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemHistory extends Model
{
    public $incrementing = false;

    public function item() {
    	return $this->belongsTo('App\Item');
    }
}
