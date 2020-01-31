<?php

namespace App\Yaoyigou;


use App\Models\Goods;
use App\Models\GoodsAttr;
use Illuminate\Database\Eloquent\SoftDeletes;

class MiaoshaGoods extends Model
{
    use SoftDeletes;

    protected $table = 'miaosha_goods';

    public $fillable = ['goods_id', 'group_id', 'goods_price', 'goods_number', 'test_goods_number',
        'min_number', 'max_number', 'zbz', 'tsbz', 'description', 'is_changed'];

    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id')
            ->select('goods_id', 'goods_name', 'goods_sn', 'shop_price', 'xq', 'ckid', 'goods_thumb');
    }

    public function goodsAttr()
    {
        return $this->hasMany(GoodsAttr::class, 'goods_id', 'goods_id')
            ->whereIn('attr_id', [1, 2, 3, 4])->select('goods_id', 'attr_id', 'attr_value');
    }

    public function miaoshaGroup()
    {
        return $this->belongsTo(MiaoshaGroup::class, 'group_id');
    }

    public function setGoodsNumberAttribute($value)
    {
        $user = auth()->user();
        if ($this->miaoshaGroup->is_test == 1 && $user && in_array($user->user_id, cs_arr())) {
            $this->attributes['test_goods_number'] = $value;
        } else {
            $this->attributes['goods_number'] = $value;
        }
    }

    public function getGoodsNumberAttribute($value)
    {
        if ($this->miaoshaGroup->is_test == 1) {
            $user = auth()->user();
            if ($user && in_array($user->user_id, cs_arr())) {
                $value = $this->attributes['test_goods_number'];
            }
        }
        return $value;
    }
}
