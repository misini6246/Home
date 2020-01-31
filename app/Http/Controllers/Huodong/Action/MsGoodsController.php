<?php

namespace App\Http\Controllers\Huodong\Action;

use App\Goods;
use App\Http\Controllers\Huodong\MsGoods;
use Illuminate\Support\Facades\Cache;

class MsGoodsController implements MsGoods
{
    protected $goods;

    protected $real_price;

    protected $goods_number;

    protected $cart_number;

    protected $team;

    protected $area_xg;

    protected $shop_price;

    public function goods(array $goods)
    {
        $this->goods = $goods;
        $goods       = $this->get_goods_info();
        return $goods;
    }

    private function get_goods_info()
    {
        $goods = Cache::store('miaosha')->tags(['miaosha', 'goods', $this->goods['tags']])->rememberForever($this->goods['id'], function () {
            $goods = Goods::with('goods_attr', 'member_price')->where('goods_id', $this->goods['id'])->first();
            return $goods;
        });

        if ($goods) {
            foreach ($this->goods as $k => $v) {
                if ($k == 'goods_number') {
                    $goods->$k = Cache::store('miaosha')->tags(['miaosha', 'goods', $this->goods['tags'], 'kc'])->rememberForever($this->goods['id'], function () {
                        return $this->goods['goods_number'];
                    });
                } else {
                    $goods->$k = $v;
                }
            }
            $goods = $this->attr($goods);
            return $goods;
        }
    }

    private function attr($v)
    {
        if (strpos($v->cat_ids, '180') !== false) {//麻黄碱
            $v->is_mhj = 1;
        } else {
            $v->is_mhj = 0;
        }
        if ($v->goods_attr->where('attr_id', 1)->first()) {//生产厂家存在
            $v->sccj = $v->goods_attr->where('attr_id', 1)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 2)->first()) {//单位存在
            $v->dw = $v->goods_attr->where('attr_id', 2)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 3)->first()) {//规格存在
            $v->spgg = $v->goods_attr->where('attr_id', 3)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 4)->first()) {//国药准字存在
            $v->gyzz = $v->goods_attr->where('attr_id', 4)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 5)->first()) {//件装量存在
            $v->jzl = trim($v->goods_attr->where('attr_id', 5)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 211)->first()) {//中包装存在
            $v->zbz = trim($v->goods_attr->where('attr_id', 211)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 213)->first()) {//促销信息
            $v->cxxx = trim($v->goods_attr->where('attr_id', 213)->first()->attr_value);
        }
        $v->goods_img   = !empty($v->goods_img) ? $v->goods_img : 'images/no_picture.gif';
        $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
        $v->goods_img   = get_img_path($v->goods_img);
        $v->goods_thumb = get_img_path($v->goods_thumb);
        $v->is_cx       = 0;
        $v->is_zx       = 0;
        $v->zyzk        = 0;
        $v->is_jp       = 0;
        $v->is_zyyp     = 0;
        return $v;
    }
}
