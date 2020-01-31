<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsAttr extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'goods_attr';
    protected $primaryKey = 'goods_attr_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询ad
    public function goods(){
        return $this->belongsTo('App\Goods','goods_id');
    }
    //关联查询order_goods
    public function order_goods(){
        return $this->belongsTo('App\OrderGoods','goods_id','goods_id');
    }
    //关联查询ad
    public function collectGoods(){
        return $this->belongsTo('App\CollectGoods','goods_id','goods_id');
    }
    //关联查询ad
    public function cart(){
        return $this->belongsTo('App\Cart','goods_id','goods_id');
    }
    //关联查询goods_attr attribute
    public function attribute(){
        return $this->belongsTo('App\Attribute','attr_id');
    }

    //访问器
    public function getAttrIdAttribute($value)
    {
        return intval($value);
    }
}
