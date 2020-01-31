<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayLog extends Model
{
    protected $table = 'pay_log';
    protected $primaryKey = 'log_id';
    public $timestamps = false;
    //关联 order_info
    public function orderInfo(){
        return $this->belongsTo('App\OrderInfo','order_id');
    }
}
