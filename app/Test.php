<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'test';
    protected $primaryKey = 'order_sn';
    public $timestamps = false;


    //关联online_pay
    public function Test(){
        return $this->belongsTo('App\OrderInfo','order_sn');
    }
}
