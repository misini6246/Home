<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    protected $table = "order_info";
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    /**
     * 查询作用域
     */
    public function scopeUser($query, $user_id)
    {//只查询自己的订单
        return $query->where('user_id', $user_id);
    }


    //关联order_goods
    public function order_goods()
    {
        return $this->hasMany('App\OrderGoods', 'order_id');
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

    /*
     * 消费总额
     */
    public static function pay_amount($user)
    {
        $amount = static::where('user_id', $user->user_id)->where('order_status', 1)->where(function ($query) {
            $query->where('pay_status', 1)->orwhere('pay_status', 2);
        })->where(function ($where) {
            $where->where('mobile_pay', '!=', 2)->orwhere(function ($where) {
                $where->where('mobile_pay', 2)->where('order_id', '<', 367858);
            });
        })->sum('goods_amount');
        $amount += OldOrderInfo::where('user_id', $user->user_id)->where('order_status', 1)->where(function ($query) {
            $query->where('pay_status', 1)->orwhere('pay_status', 2);
        })->sum('goods_amount');
        return $amount;
    }

    /*
     * 待付款金额
     */
    public static function wait_amount($user)
    {
        return static::where('user_id', $user->user_id)->where('order_status', 1)
            ->where('pay_status', 0)->where('shipping_status', 0)->where(function ($where) {
                $where->where('mobile_pay', '!=', 2)->orwhere(function ($where) {
                    $where->where('mobile_pay', 2)->where('order_id', '<', 367858);
                });
            })->sum('order_amount');
    }

    /*
     * 待发货数量
     */
    public static function pay_order($user)
    {
        return static::where('user_id', $user->user_id)->where('order_status', 1)->where(function ($query) {
            $query->where('pay_status', 1)->orwhere('pay_status', 2);
        })->where(function ($where) {
            $where->where('mobile_pay', '!=', 2)->orwhere(function ($where) {
                $where->where('mobile_pay', 2)->where('order_id', '<', 367858);
            });
        })->count();
    }

    /*
     * 待付款数量
     */
    public static function wait_order($user)
    {
        return static::where('user_id', $user->user_id)->where('order_status', 1)
            ->where(function ($where) {
                $where->where('mobile_pay', '!=', 2)->orwhere(function ($where) {
                    $where->where('mobile_pay', 2)->where('order_id', '<', 367858);
                });
            })
            ->where('pay_status', 0)->where('shipping_status', 0)->count();
    }

    /*
     * 最近的订单
     */
    public static function near_order($user, $num)
    {
        return static::where('user_id', $user->user_id)->where('add_time', '>', strtotime('-1 month'))
            ->where(function ($where) {
                $where->whereNotIn('mobile_pay', [2, 6, 7, 8])->orwhere(function ($where) {
                    $where->where('mobile_pay', 2)->where(function ($where) {
                        $where->where('order_id', '<', 367858)->orwhere('order_id', '>', 394321);
                    });
                });
            })->whereNotIn('order_id', [829598, 829599])
            ->orderBy('order_id', 'desc')->take($num)->get();
    }

    public function setShippingNameAttribute($value)
    {
        $value = is_null($value) ? '' : $value;
        $this->attributes['shipping_name'] = $value;
    }

    public function setWlDhAttribute($value)
    {
        $value = is_null($value) ? '' : $value;
        $this->attributes['wl_dh'] = $value;
    }
}
