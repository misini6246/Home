<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderGoods extends Model
{
    protected $table = "order_goods";
    protected $primaryKey = 'rec_id';
    public $timestamps = false;

    //关联order_info
    public function order_info()
    {
        return $this->belongsTo('App\OrderInfo', 'order_id');
    }

    //关联goods
    public function goods()
    {
        return $this->belongsTo('App\Goods', 'goods_id');
    }

    //关联goods_attr
    public function goodsAttr()
    {
        return $this->hasMany('App\GoodsAttr', 'goods_id', 'goods_id');
    }

    public function goods_attribute()
    {
        return $this->hasOne(GoodsAttribute::class, 'goods_id', 'goods_id');
    }

    /**
     * 获取商品限购数量
     */
    public static function xg_num($goods_id, $user_id, $time = array())
    {
        $num = DB::table('order_goods as og')
            ->leftjoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
            ->where('oi.order_status', '!=', 2)->where('oi.order_status', '!=', 3)
            ->where('og.goods_id', $goods_id)->where('oi.user_id', $user_id)
            ->whereBetween('oi.add_time', $time)
            ->sum('og.goods_number');
        return $num;
    }

}
