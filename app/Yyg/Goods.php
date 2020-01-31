<?php

namespace App\Yyg;

use App\GoodsAttr;
use App\GoodsAttribute;
use App\MemberPrice;
use App\Strategy\RealPrice\DefaultRealPrice;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'goods_id';
    public $timestamps = false;

    protected $appends = [
        'is_zy', 'is_mhj', 'is_jp', 'is_xq_red', 'product_id',
        'url', 'sccj', 'bzdw', 'ypgg', 'pzwh', 'jzl', 'zbz', 'bzxx', 'bzxx2',
        'real_price'
    ];

    public function getRealPriceAttribute()
    {
        return (new \App\Strategy\Goods(new DefaultRealPrice()))->done($this);
    }

    public function getIsPromoteAttribute($value)
    {
        $time = time();
        if ($this->promote_start_date <= $time && $this->promote_start_date > $time && $this->promote_price == 1 && $value == 1) {
            $value = 1;
        } else {
            $value = 0;
        }
        $user = auth()->user();
        if ($user && !in_array($user->user_rank, [2, 5])) {
            $value = 0;
        }
        return $value;
    }

    public function getUrlAttribute()
    {
        return route('v2.goods.show', ['id' => $this->attributes['goods_id'], 'product_id' => $this->product_id]);
    }

    public function getSccjAttribute()
    {
        return $this->is_zy == 0 ? collect($this->goods_attr->where('attr_id', 1)->first())->get('attr_value', '') : $this->goods_attribute->sccj;
    }

    public function getBzdwAttribute()
    {
        return $this->is_zy == 0 ? collect($this->goods_attr->where('attr_id', 2)->first())->get('attr_value', '') : $this->goods_attribute->bzdw;
    }

    public function getYpggAttribute()
    {
        return $this->is_zy == 0 ? collect($this->goods_attr->where('attr_id', 3)->first())->get('attr_value', '') : $this->goods_attribute->ypgg;
    }

    public function getPzwhAttribute()
    {
        return $this->is_zy == 0 ? collect($this->goods_attr->where('attr_id', 4)->first())->get('attr_value', '') : $this->goods_attribute->pzwh;
    }

    public function getJzlAttribute()
    {
        return $this->is_zy == 0 ? collect($this->goods_attr->where('attr_id', 5)->first())->get('attr_value', '') : $this->goods_attribute->jzl;
    }

    public function getZbzAttribute()
    {
        if ($this->attributes['ls_gg'] > 0) {
            $value = $this->attributes['ls_gg'];
        } else {
            $value = $this->is_zy == 0 ? collect($this->goods_attr->where('attr_id', 211)->first())->get('attr_value', '') : $this->goods_attribute->zbz;
        }
        $value = $value > $this->goods_number ? $this->goods_number : $value;
        return $value > 0 ? $value : 0;
    }

    public function getBzxxAttribute()
    {
        return collect($this->goods_attr->where('attr_id', 212)->first())->get('attr_value', '');
    }

    public function getBzxx2Attribute()
    {
        return collect($this->goods_attr->where('attr_id', 213)->first())->get('attr_value', '');
    }

    public function getLsGgAttribute()
    {
        return 0;
    }

    /**
     * @return int
     */
    public function getProductIdAttribute()
    {
        return 0;
    }

    /**
     * @return int
     */
    public function getIsZyAttribute()
    {
        if (in_array(trim($this->attributes['erp_shangplx']), ['血液制品', '冷藏药品'])) {
            $value = 2;
        } else {
            $value = str_contains($this->attributes['show_area'], '4') ? 1 : 0;
        }
        return $value;
    }

    /**
     * @return int
     */
    public function getIsMhjAttribute()
    {
        return str_contains($this->attributes['cat_ids'], '180') ? 1 : 0;
    }

    /**
     * @return mixed
     */
    public function getIsJpAttribute()
    {
        return str_contains($this->attributes['show_area'], '2') ? 1 : 0;
    }

    public function getGoodsThumbAttribute($value)
    {
        if (!empty($value)) {
            $value = get_img_path($value);
        }
        return $value;
    }

    public function getGoodsImgAttribute($value)
    {
        if (!empty($value)) {
            $value = get_img_path($value);
        }
        return $value;
    }

    public function getIsXqRedAttribute()
    {
        $xq = $this->attributes['xq'];
        $value = 0;
        if (!empty($xq)) {
            $end = strtotime('+8 month');
            if ($end > strtotime($xq)) {//效期在8个月内 标红
                $value = 1;
            }
        }
        return $value;
    }

    public function getGoodsSmsAttribute($value)
    {
        return str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $value);
    }

    public function getGoodsDescAttribute($value)
    {
        return str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $value);
    }

    public function goods_attr()
    {
        return $this->hasMany(GoodsAttr::class, 'goods_id');
    }

    public function goods_attribute()
    {
        return $this->hasOne(GoodsAttribute::class, 'goods_id');
    }

    public function member_price()
    {
        return $this->hasOne(MemberPrice::class, 'goods_id')->where('user_rank', 1);
    }
}
