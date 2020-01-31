<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZqOrder extends Model
{
    protected $table = "zq_order";
    protected $primaryKey = 'zq_id';
    public $timestamps = false;

    //关联order_info
    public function order_info(){
        return $this->hasMany('App\OrderInfo','zq_id');
    }
}
