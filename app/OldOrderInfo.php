<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldOrderInfo extends Model
{
    protected $table = 'old_order_info';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    /**
     * 查询作用域
     */
    public function scopeUser($query,$user_id){//只查询自己的订单
        return $query->where('user_id',$user_id);
    }
    //关联order_goods
    public function order_goods(){
        return $this->hasMany('App\OldOrderGoods','order_id');
    }

    //关联pay_log
    public function payLog()
    {
        return $this->hasMany('App\PayLog', 'order_id');
    }

    //关联online_pay
    public function onlinePay()
    {
        return $this->hasOne('App\OnlinePay', 'order_id');
    }

    //关联online_pay
    public function xyyhOrder()
    {
        return $this->hasOne('App\XyyhOrder', 'order_id');
    }

    //关联online_pay
    public function weixinOrder()
    {
        return $this->hasOne('App\WeixinOrder', 'order_id');
    }

    //关联zq_order
    public function zq_order()
    {
        return $this->belongsTo('App\ZqOrder', 'zq_id');
    }

    public function order_action()
    {
        return $this->hasMany(OrderAction::class, 'order_id', 'order_id');
    }
}
