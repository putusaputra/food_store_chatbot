<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $incrementing = false;

    public function orderItems() {
    	return $this->hasMany('App\OrderItem');
    }
}
