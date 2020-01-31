<?php

namespace App\Models\Pay;

use Illuminate\Database\Eloquent\Model;

class AlipayOrder extends Model
{
    protected $table = 'alipay_order';
    protected $primaryKey = "id";
    //public $timestamps = false;

    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'update_time';

    protected $dateFormat = 'U';

    //关联order_info
    public function order_info(){
        return $this->belongsTo('App\OrderInfo','order_id');
    }
}
