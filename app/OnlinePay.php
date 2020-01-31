<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlinePay extends Model
{
    protected $table = "online_pay";
    protected $primaryKey = 'id';
    public $timestamps = false;
    //关联order_info
    public function order_info(){
        return $this->belongsTo('App\OrderInfo','order_id');
    }
    //关联order_info
    public function zq_order(){
        return $this->belongsTo('App\Zq_order','order_id');
    }
    //关联goods
    public function goods(){
        return $this->belongsTo('App\Goods','goods_id');
    }
}
