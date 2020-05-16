<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $incrementing = false;

    public function order() {
    	return $this->belongsTo('App\Order');
    }
}
