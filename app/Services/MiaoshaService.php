<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/8/22
 * Time: 15:02
 */

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class MiaoshaService
{
    protected $store;

    protected $user;

    protected $goodsService;

    protected $now;

    public function __construct(GoodsService $goodsService)
    {
        $this->store = Redis::connection('mrms');
        $this->user = auth()->user();
        $this->goodsService = $goodsService;
        $this->now = time();
    }

    /**
     * @param $key
     * @return mixed
     * 获取缓存键
     */
    public function cacheKeys($key)
    {
        $arr = [
            0 => 'type_group',
            1 => 'group',
            2 => 'goods',
            3 => 'group_goods',
            4 => 'user_goods',
            5 => 'cart_goods',
            6 => 'union',
        ];
        return $arr[$key];
    }

    /**
     * @param $group_id
     * @param $goods_id
     * @return array
     * 单个秒杀商品加入购物车
     */
    public function setCacheCart($group_id, $goods_id)
    {
        $this->user = $this->user->is_zhongduan();
        if (!$this->user->is_zhongduan) {
            return [
                'error' => 300,
                'msg' => '此活动只针对终端客户',
            ];
        }
        $goods = $this->getCacheGoods($group_id . $this->cacheKeys(6) . $goods_id);
        if (!$goods) {
            return [
                'error' => 300,
                'msg' => '活动商品不存在',
            ];
        }
        $response = $this->checkGoodsGroupTime($goods->miaoshaGroup);
        if ($response) {//验证活动时间
            return $response;
        }
        $response = $this->goodsService->checkUser();
        if ($response) {//验证会员资质
            return $response;
        }
        $response = $this->checkGoodsCustom($goods->goods);
        if ($response) {//自定义限制条件
            return $response;
        }
        $response = $this->goodsService->limitConditions($goods->goods);
        if ($response) {//验证商品限购条件
            return $response;
        }
        $response = $this->goodsService->checkJyfw($goods->goods);
        if ($response) {//验证商品经营范围
            return $response;
        }
        $userGoods = $this->getCacheUserGoods();
        if (isset($userGoods[$group_id . $this->cacheKeys(6) . $goods_id])) {
            return [
                'error' => 1,
                'msg' => '商品已加入购物车',
                'goods_number' => $goods->goods_number
            ];
        }
        if ($goods->goods_number < $goods->min_number) {
            return [
                'error' => 2,
                'msg' => '库存不足',
                'goods_number' => $goods->goods_number
            ];
        }
        $this->store->transaction(function () use ($goods, $userGoods) {
            $cartGoods = clone $goods;
            $cartGoods->is_ordered = 0;
            $cartGoods->user_id = $this->user->user_id;
            $cartGoods->goods_number = $goods->min_number;
            $goods->goods_number -= $goods->min_number;
            $this->setCacheUserGoods(array_merge($userGoods, [$cartGoods->group_id . $this->cacheKeys(6) . $cartGoods->goods_id => $cartGoods->group_id . $this->cacheKeys(6) . $cartGoods->goods_id]));
            $this->setCacheCartGoods($cartGoods);
            $this->setCacheGoods($goods);
        });
        return [
            'error' => 0,
            'msg' => '商品加入购物车成功',
            'goods_number' => $goods->goods_number
        ];
    }

    /**
     * @param $goods
     * @return array
     * 验证活动时间
     */
    public function checkGoodsGroupTime($group)
    {
        if (strtotime($group->start_time) > $this->now) {
            return [
                'error' => 300,
                'msg' => '活动未开始'
            ];
        }
        if (strtotime($group->end_time) <= $this->now) {
            return [
                'error' => 300,
                'msg' => '活动已结束'
            ];
        }
    }

    /**
     * @param array $userGoods
     * @return \Illuminate\Support\Collection
     * 获取当前会员购物车秒杀商品列表
     */
    public function getCacheCartGoodsList(array $userGoods = [])
    {
        $collect = collect();
        $this->user = $this->user->is_zhongduan();
        if (!$this->user->is_zhongduan) {
            return $collect;
        }
        $response = $this->goodsService->checkUser();
        if ($response) {//验证会员资质
            return $collect;
        }
        if (empty($userGoods)) {
            $userGoods = $this->getCacheUserGoods();
        }
        foreach ($userGoods as $id) {
            $info = $this->setGoodsAttr($this->getCacheCartGoods($this->user->user_id . $this->cacheKeys(6) . $id));
            if ($info && $info->is_ordered == 0 && strtotime($info->miaoshaGroup->invalid_time) > $this->now) {//未提交，未失效
                $response = $this->checkGoodsGroupTime($info->miaoshaGroup);
                if ($response) {//验证活动时间
                    continue;
                }
                $response = $this->checkGoodsCustom($info->goods);
                if ($response) {//自定义限制条件
                    continue;
                }
                $response = $this->goodsService->limitConditions($info->goods);
                if ($response) {//验证商品限购条件
                    continue;
                }
                $response = $this->goodsService->checkJyfw($info->goods);
                if ($response) {//验证商品经营范围
                    continue;
                }
                $collect->push($info);
            }
        }
        return $collect;
    }

    /**
     * @param $keys
     * @return float|int
     * 获取指定秒杀商品的汇总金额
     */
    public function getCacheCartGoodsAmount($keys)
    {
        $amount = 0;
        $userGoods = $this->getCacheUserGoods();
        foreach ($userGoods as $id) {
            if (in_array($id, $keys)) {
                $info = $this->getCacheCartGoods($this->user->user_id . $this->cacheKeys(6) . $id);
                if ($info) {
                    $amount += $info->goods_price * $info->goods_number;
                }
            }
        }
        return $amount;
    }

    /**
     * @param $goods
     * 保存单个秒杀商品
     */
    public function setCacheGoods($goods)
    {
        $this->store->hset($this->cacheKeys(2), $goods->group_id . $this->cacheKeys(6) . $goods->goods_id, serialize($goods));
    }

    /**
     * @param $userGoods
     * 保存会员对应的秒杀商品id
     */
    public function setCacheUserGoods($userGoods)
    {
        $this->store->hset($this->cacheKeys(4), $this->user->user_id, serialize($userGoods));
    }

    /**
     * @param $cartGoods
     * 保存秒杀商品
     */
    public function setCacheCartGoods($cartGoods)
    {
        $this->store->hset($this->cacheKeys(5), $cartGoods->user_id . $this->cacheKeys(6) . $cartGoods->group_id . $this->cacheKeys(6) . $cartGoods->goods_id, serialize($cartGoods));
    }

    /**
     * @param array $userGoods
     * 将秒杀商品设置为已提交状态
     */
    public function setCacheCartGoodsOrdered(array $userGoods)
    {
        foreach ($userGoods as $v) {
            $cartGoods = $this->getCacheCartGoods($this->user->user_id . $this->cacheKeys(6) . $v);
            if ($cartGoods) {
                $cartGoods->is_ordered = 1;
                $this->setCacheCartGoods($cartGoods);
            }
        }
    }

    /**
     * @return array|mixed|string
     * 获取当前会员包含的秒杀商品id
     */
    public function getCacheUserGoods()
    {
        if (!$this->user) {
            return [];
        }
        $userGoods = $this->store->hget($this->cacheKeys(4), $this->user->user_id);
        return $userGoods ? unserialize($userGoods) : [];
    }

    /**
     * @return \Illuminate\Support\Collection
     * 获取每日秒杀
     */
    public function getCacheGroupVisible($groupType = 1)
    {
        $collect = collect();
        $typeGroup = $this->getCacheTypeGroup($groupType);
        $userGoods = $this->getCacheUserGoods();
        foreach ($typeGroup as $group_id) {
            $groupGoods = $this->getCacheGroupGoods($group_id);
            $goods = collect();
            foreach ($groupGoods as $goods_id) {
                $info = $this->setGoodsAttr($this->getCacheGoods($group_id . $this->cacheKeys(6) . $goods_id));
                if ($info) {
                    if (in_array($info->group_id . $this->cacheKeys(6) . $info->goods_id, $userGoods)) {
                        $info->is_has = 1;
                    }
                    $goods->push($info);
                }
            }
            $group = $this->getCacheGroup($group_id);
            $group->setRelation('goods', $goods->sortByDesc('sort'));
            $collect->push($group);
        }
        return $collect->sortBy('start_time');
    }

    /**
     * @param $id
     * @return mixed
     * 获取单个秒杀商品组
     */
    public function getCacheGroup($id)
    {
        return unserialize($this->store->hget($this->cacheKeys(1), $id));
    }

    /**
     * @param $id
     * @return array|mixed
     * 获取商品组包含商品id
     */
    public function getCacheGroupGoods($id)
    {
        $groupGoods = $this->store->hget($this->cacheKeys(3), $id);
        return $groupGoods ? unserialize($groupGoods) : [];
    }

    /**
     * @param $groupType
     * @return array|mixed
     * 获取每日秒杀商品组
     */
    public function getCacheTypeGroup($groupType)
    {
        $typeGroup = $this->store->hget($this->cacheKeys(0), $groupType);
        return $typeGroup ? unserialize($typeGroup) : [];
    }

    /**
     * @param $goods
     * @return mixed
     * 格式化商品属性
     */
    protected function setGoodsAttr($goods)
    {
        if (!$goods) {
            return null;
        }
        foreach ($goods->goodsAttr as $attr) {
            if ($attr->attr_id == 1) {
                $goods->goods->sccj = $attr->attr_value;
            }
            if ($attr->attr_id == 2) {
                $goods->goods->dw = $attr->attr_value;
            }
            if ($attr->attr_id == 3) {
                $goods->goods->spgg = $attr->attr_value;
            }
            if ($attr->attr_id == 4) {
                $goods->goods->gyzz = $attr->attr_value;
            }
            if ($attr->attr_id == 5) {
                $goods->goods->jzl = $attr->attr_value;
            }
        }
        $goods->goods->real_price = $goods->goods_price;
        $goods->goods->goods_thumb = get_img_path($goods->goods->goods_thumb);
        $goods->goods->tsbz = $goods->tsbz;
        $goods->is_checked = 1;
        $goods->is_can_change = $goods->is_changed;
        $goods->rec_id = $goods->group_id . $this->cacheKeys(6) . $goods->goods_id;
        $goods->goods->goods_url = route('goods.index', ['id' => $goods->goods_id]);
        return $goods;
    }

    /**
     * @param $id
     * @return mixed
     * 获取单个秒杀商品
     */
    public function getCacheGoods($id)
    {
        return unserialize($this->store->hget($this->cacheKeys(2), $id));
    }

    /**
     * @param $id
     * @return mixed
     * 获取单个购物车秒杀商品
     */
    public function getCacheCartGoods($id)
    {
        return unserialize($this->store->hget($this->cacheKeys(5), $id));
    }

    /**
     * @param $id
     * 从购物车删除单个秒杀商品
     */
    public function delCacheCartGoods($id)
    {
        $userGoods = $this->getCacheUserGoods();
        unset($userGoods[$id]);
        $this->store->transaction(function () use ($userGoods, $id) {
            $this->setCacheUserGoods($userGoods);
            $this->store->hdel($this->cacheKeys(5), $this->user->user_id . $this->cacheKeys(6) . $id);
            $goods = $this->getCacheGoods($id);
            $goods->goods_number += $goods->min_number;
            $this->setCacheGoods($goods);
        });
    }

    public function checkGoodsCustom($goods)
    {
        if (in_array($goods->goods_id, [8864, 35702, 4619])) {
            if ($this->user->province != 26) {
                return [
                    'error' => 300,
                    'msg' => '商品限购'
                ];
            }
        }
    }
}