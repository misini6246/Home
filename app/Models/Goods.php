<?php

namespace App\Models;

use App\kxpzPrice;
use App\OrderGoods;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'goods_id';
    public $timestamps = false;

    public function select1()
    {
        return ['goods_id', 'goods_name', 'goods_number', 'shop_price',
            'promote_start_date', 'promote_end_date', 'promote_price'];
    }

    public function zp_goods()
    {
        $now = time();
        return $this->belongsToMany(ZpGoods::class, 'goods_zp', 'goods_id', 'zp_id')
            ->wherePivot('start', '<=', $now)->wherePivot('end', '>', $now)->wherePivot('is_goods', 0)
            ->wherePivot('enabled', 1)->wherePivot('is_delete', 0)->withPivot('goods_number', 'zp_number', 'message', 'type', 'is_erp', 'is_goods')
            ->where('zp_goods.goods_number', '>', 0)->orderBy('goods_zp.goods_number', 'desc');
    }

    public function zp_goods1()
    {
        $now = time();
        return $this->belongsToMany(Goods::class, 'goods_zp', 'goods_id', 'zp_id')
            ->wherePivot('start', '<=', $now)->wherePivot('end', '>', $now)->wherePivot('is_goods', 1)
            ->wherePivot('enabled', 1)->wherePivot('is_delete', 0)->withPivot('goods_number', 'zp_number', 'message', 'type', 'is_erp', 'is_goods')
            ->where('goods.goods_number', '>', 0)->orderBy('goods_zp.goods_number', 'desc');
    }

    public $sycx;

    public function getIsCxAttribute($value)
    {
        $this->sycx = $value;
        return $value;
    }

    public function goods_attr()
    {
        return $this->hasMany('App\GoodsAttr', 'goods_id');
    }

    public function goods_attribute()
    {
        return $this->hasOne('App\GoodsAttribute', 'goods_id');
    }

    public function member_price()
    {
        return $this->hasMany('App\MemberPrice', 'goods_id');
    }

    public function sales_volume()
    {
        return $this->hasOne('App\SalesVolume', 'goods_id');
    }

    public function goods_xg()
    {
        return $this->hasMany(GoodsXg::class, 'goods_id', 'goods_id');
    }

    public function goods_promote()
    {
        return $this->hasMany(GoodsPromote::class, 'goods_id', 'goods_id');
    }


    public function getErpShangplxAttribute($value)
    {
        return trim($value);
    }

    public static function area_xg($goods, $user)
    {
        $country = $user->country;
        $province = $user->province;
        $city = $user->city;
        $district = $user->district;
        $user_rank = $user->user_rank;
        $user_id = $user->user_id;
        $is_can_buy = 1;
        $arr = explode('.', $goods->ls_buy_user_id);
        $arr1 = explode('.', $goods->ls_regions);//区域限制
        $arr2 = explode('.', $goods->zs_regions);//诊所限制
        $arr3 = explode('.', $goods->yy_regions);//医院限制
        $arr4 = explode('.', $goods->zs_user_ids);//诊所会员限制
        $arr5 = explode('.', $goods->yy_user_ids);//医院会员限制
        $arr6 = explode(',', $goods->ls_ranks);//等级限制
        if (!in_array($user_id, $arr)) {
            if (in_array($user_rank, $arr6)) {
                $is_can_buy = 0;
                if (in_array($user->city, [339, 336, 332, 328, 324]) && in_array($user->user_rank, [1, 2, 5]) && $goods->goods_id == 25257) {
                    $is_can_buy = 1;
                }
                if (in_array($user->city, [322, 342, 327, 331]) && in_array($user->user_rank, [2]) && in_array($goods->goods_id, [14203, 14288, 7579])) {
                    $is_can_buy = 1;
                }
                if (in_array($user->city, [322]) && in_array($user->user_rank, [2]) && in_array($goods->goods_id, [14063])) {
                    $is_can_buy = 1;
                }
            }
            if (in_array($country, $arr1) || in_array($province, $arr1) || in_array($city, $arr1) || in_array($district, $arr1)) {
                $is_can_buy = 0;
                if (in_array($user->city, [322, 342, 327, 331]) && in_array($user->user_rank, [2]) && in_array($goods->goods_id, [14203])) {
                    $is_can_buy = 1;
                }
            }
            if (!$user->is_zhongduan &&
                (in_array($country, $arr3) || in_array($province, $arr3) || in_array($city, $arr3) || in_array($district, $arr3) || in_array($user_id, $arr5))
            ) {
                $is_can_buy = 0;
            }
            if ($user->is_zhongduan &&
                (in_array($country, $arr2) || in_array($province, $arr2) || in_array($city, $arr2) || in_array($district, $arr2) || in_array($user_id, $arr4))
            ) {
                $is_can_buy = 0;
            }
        }
        $goods->is_can_buy = $is_can_buy;
        return $goods;
    }

    public function attr()
    {
        $this->goods_thumb = !empty($this->goods_thumb) ? $this->goods_thumb : 'images/no_picture.gif';
        $this->goods_thumb = get_img_path($this->goods_thumb);
        if (strpos($this->show_area, '4') !== false) {//中药饮片
            $this->goods_url = route('goods.zyyp', ['id' => $this->goods_id]);
            $this->is_zyyp = 1;
			if($this->goods_attribute&& $this->goods_attribute->sccj){
				$this->sccj = $this->goods_attribute->sccj;
			}else{
				$this->sccj = "";
			}
			if($this->goods_attribute&& $this->goods_attribute->ypgg){
				$this->ypgg = $this->goods_attribute->ypgg;
			}else{
				$this->ypgg = "";
			}
			if($this->goods_attribute&& $this->goods_attribute->jzl){
				$this->jzl = $this->goods_attribute->jzl;
			}else{
				$this->jzl = "";
			}
			if($this->goods_attribute&& $this->goods_attribute->dw){
				$this->dw = $this->goods_attribute->dw;
			}else{
				$this->dw = "";
			}
			if($this->goods_attribute&& $this->goods_attribute->cxxx){
				$this->cxxx = $this->goods_attribute->cxxx;
			}else{
				$this->cxxx = "";
			}
			if($this->goods_attribute&& $this->goods_attribute->gyzz){
				$this->gyzz = $this->goods_attribute->gyzz;
			}else{
				$this->gyzz = "";
			}
			if($this->goods_attribute&& $this->goods_attribute->zbz){
				$this->zbz = $this->goods_attribute->zbz;
			}else{
				$this->zbz = "";
			}
            
            $this->bzxx = '';
            $this->bzxx2 = '';
        } else {
            $this->goods_url = route('goods.index', ['id' => $this->goods_id]);
            $this->is_zyyp = 0;
            foreach ($this->goods_attr as $goods_attr) {
                if ($goods_attr->attr_id == 1) {
                    $this->sccj = $goods_attr->attr_value;
                } elseif ($goods_attr->attr_id == 2) {
                    $this->dw = $goods_attr->attr_value;
                } elseif ($goods_attr->attr_id == 3) {
                    $this->ypgg = $goods_attr->attr_value;
                } elseif ($goods_attr->attr_id == 4) {
                    $this->gyzz = $goods_attr->attr_value;
                } elseif ($goods_attr->attr_id == 5) {
                    $this->jzl = $goods_attr->attr_value;
                } elseif ($goods_attr->attr_id == 211) {
                    $this->zbz = $goods_attr->attr_value;
                } elseif ($goods_attr->attr_id == 212) {
                    $this->bzxx = $goods_attr->attr_value;
                } elseif ($goods_attr->attr_id == 213) {
                    $this->bzxx2 = $goods_attr->attr_value;
                }
            }
        }
        if ($this->ls_gg > 0) {//最低购买量转中包装
            $this->zbz = $this->ls_gg;
            $this->ls_gg = 0;
        }
        if ($this->goods_number < $this->zbz && $this->goods_number > 0) {
            $this->zbz = $this->goods_number;
        }
        if ($this->zbz == 0) {
            $this->zbz = 1;
        }
        if ($this->user && $this->user->province != 29) {
            $this->bzxx = '';
        }
        return $this;
    }

    public function real_price()
    {
        $this->real_price = 0;
        $this->is_kxpz();
        if ($this->is_kxpz == 1) {
            $this->real_price = $this->kxpz_price;
            $this->is_promote = 0;
        } elseif ($this->user->is_zhongduan == 0) {
            $this->real_price = collect($this->member_price->first())->get('user_price', 0);
            $this->is_promote = 0;
        } else {
            $this->real_price = $this->shop_price;
            $this->is_promote();
        }
        $this->xg_type();
        if ($this->is_promote == 1) {
            $this->real_price = $this->promote_price;
        }
        return $this;
    }

    public function is_kxpz()
    {
        $this->kxpz_price = 0;
        if ($this->is_kxpz == 1) {
            $kxpz = kxpzPrice::where('goods_id', $this->goods_id)->where(function ($query) {
                $query->where('ls_regions', 'like', '%.' . $this->user->country . '.%')//区域限制
                ->orwhere('ls_regions', 'like', '%.' . $this->user->province . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $this->user->city . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $this->user->district . '.%')
                    ->orwhere('user_id', $this->user->user_id);//会员限制
            })->select('area_price', 'company_price')
                ->orderBy('price_id', 'desc')->first();
            $this->is_kxpz = 0;
            if ($kxpz) {//有控销价
                if ($this->user->is_zhongduan == 1 && $kxpz->area_price > 0) {//终端客户
                    $this->kxpz_price = $kxpz->area_price;
                    $this->is_kxpz = 1;
                } elseif (!$this->user->is_zhongduan == 1 && $kxpz->company_price > 0) {
                    $this->kxpz_price = $kxpz->company_price;
                    $this->is_kxpz = 1;
                }
            }
        }
    }

    public function is_promote()
    {
        $time = time();
        if ($this->is_promote == 1 && $this->promote_start_date <= $time && $this->promote_end_date > $time && $this->is_xkh_tj == 0) {
            $this->is_promote = 1;
        } else {
            $this->is_promote = 0;
        }
        return $this;
    }

    public function xg_type()
    {
        if ($this->xg_type == 3) {
            $this->xg_type = 2;
            $this->xg_start_date = strtotime(date("Ymd"));
            $this->xg_end_date = strtotime(date("Ymd")) + 3600 * 24;
        } elseif ($this->xg_type == 4) {
            $this->xg_type = 2;
            $this->xg_start_date = strtotime('last monday');
            $this->xg_end_date = strtotime('next monday');
        }
        $this->xg_num = intval($this->ls_ggg);
        if ($this->xg_type == 2) {
            $num = OrderGoods::xg_num($this->goods_id, $this->user->user_id, [$this->xg_start_date, $this->xg_end_date]);//已购买的数量
            $this->xg_num -= $num;
            if ($this->xg_num <= 0) {//没有余量 限购结束 特价结束
                if ($this->is_promote == 1) {//原来在促销中
                    $this->is_promote = 0;
                    $this->xg_num = 0;
                    $this->xg_type = 0;
                }
            }
        }
        return $this;
    }


    public function ck_price()
    {
        return $this->hasOne(CkPrice::class, 'ERPID', 'ERPID')
            ->where('is_on_sale', 1)->where('goods_price', '>', 0)->where('goods_number', '>', 0);
    }
}
