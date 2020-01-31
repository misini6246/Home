<?php

namespace App\Yaoyigou;


use Illuminate\Database\Eloquent\Model;


class Goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'goods_id';
    protected $perPage = 40;
    public $timestamps = false;

    public $appends = [
        'is_mhj'
    ];

    public function scopeOnSale($query)
    {
        return $query->where('is_on_sale', 1)->where('is_alone_sale', 1)->where('is_delete', 0);
    }

    public function goodsAttr()
    {
        return $this->hasMany(GoodsAttr::class, 'goods_id');
    }

    public function getIsMhjAttribute()
    {
        $value = 0;
        if (strpos($this->attributes['cat_ids'], '180') !== false) {//麻黄碱
            $value = 1;
        }
        return $value;
    }
}