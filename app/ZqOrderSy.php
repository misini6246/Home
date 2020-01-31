<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZqOrderSy extends Model
{
    protected $table = 'zq_order_sy';
    protected $primaryKey = 'zq_id';
    public $timestamps = false;

    //关联order_info
    public function order_info(){
        return $this->hasMany('App\OrderInfo','zq_id');
    }
}
