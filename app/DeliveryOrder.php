<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    protected $table = 'delivery_order';
    protected $primaryKey = 'delivery_id';
    public $timestamps = false;

    public function order_action(){
        return $this->hasMany('App\OrderAction','order_id','order_id')->where('action_place',1)->where('action_user','莫莉花');
    }
}
