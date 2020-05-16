<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $incrementing = false;

    public function category() {
    	return $this->hasOne('App\Category');
    }

    public function itemHistories() {
    	return $this->hasMany('App\ItemHistory');
    }
}
