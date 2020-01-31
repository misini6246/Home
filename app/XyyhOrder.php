<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XyyhOrder extends Model
{
    protected $table = "xyyh_order";
    protected $primaryKey = 'id';
    public $timestamps = false;

    //关联order_info
    public function order_info(){
        return $this->belongsTo('App\OrderInfo','order_id');
    }
}
