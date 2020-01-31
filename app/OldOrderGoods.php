<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldOrderGoods extends Model
{
    protected $table = 'old_order_goods';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;
    //关联order_info
    public function order_info(){
        return $this->belongsTo('App\OldOrderInfo','order_id');
    }
    //关联goods
    public function goods(){
        return $this->belongsTo('App\Goods','goods_id');
    }
    //关联goods_attr
    public function goodsAttr(){
        return $this->hasMany('App\GoodsAttr','goods_id','goods_id');
    }

    public function goods_attribute()
    {
        return $this->hasOne(GoodsAttribute::class, 'goods_id', 'goods_id');
    }
}
