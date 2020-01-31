<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/8/27
 * Time: 8:53
 */

namespace App\Services;


use App\Repositories\GoodsRepository;
use Illuminate\Support\Facades\DB;

class GoodsService
{
    protected $user;

    protected $now;

    protected $goodsRepository;

    public function __construct(GoodsRepository $goodsRepository)
    {
        $this->user = auth()->user();
        $this->now = time();
        $this->goodsRepository = $goodsRepository;
    }

    public function getMrms($day = 0)
    {
        $result = $this->goodsRepository->getMrms($day);
        foreach ($result as $k => $v) {
            $v = $this->setGoodsAttr($v);
            $v = $this->checkPromotion($v);
            if ($v->is_promote == 0) {
                unset($result[$k]);
                continue;
            }
            $response = $this->checkJyfw($v);
            if ($response) {
                unset($result[$k]);
                continue;
            }
            $response = $this->limitConditions($v);
            if ($response) {
                unset($result[$k]);
                continue;
            }
        }
        return $result;
    }

    protected function setGoodsAttr($goods)
    {
        if (!$goods) {
            return $goods;
        }
        foreach ($goods->goodsAttr as $attr) {
            if ($attr->attr_id == 1) {
                $goods->sccj = $attr->attr_value;
            }
            if ($attr->attr_id == 2) {
                $goods->dw = $attr->attr_value;
            }
            if ($attr->attr_id == 3) {
                $goods->spgg = $attr->attr_value;
            }
            if ($attr->attr_id == 4) {
                $goods->gyzz = $attr->attr_value;
            }
            if ($attr->attr_id == 5) {
                $goods->jzl = $attr->attr_value;
            }
        }
        $goods->goods_thumb = get_img_path($goods->goods_thumb);
        return $goods;
    }

    public function checkPromotion($goods)
    {
        $buyNum = $this->goodsRepository->getBuyNum($goods->promote_start_date, $goods->promote_end_date, $goods->goods_id, $this->user->user_id);
        if ($buyNum > 0) {
            $goods->is_has = 1;
        }
        if ($goods->is_promote == 1 && in_array($goods->goods_id, [4619, 22073])) {
            $is_has = DB::table('except_user')->where('user_id', $this->user->user_id)->count();
            if ($is_has == 1) {
                $goods->is_promote = 0;
            }
        }
        return $goods;
    }

    /**
     * @param $goods
     * @return array
     * 商品限购判断
     */
    public function limitConditions($goods)
    {
        $arr = explode('.', $goods->ls_buy_user_id);//能购买的会员
        $arr1 = explode('.', $goods->ls_regions);//不能购买的区域
        $arr2 = explode('.', $goods->zs_regions);//不能购买的终端区域
        $arr3 = explode('.', $goods->yy_regions);//不能购买的商业区域
        $arr4 = explode('.', $goods->zs_user_ids);//不能购买的终端会员
        $arr5 = explode('.', $goods->yy_user_ids);//不能购买的商业会员
        $arr6 = explode(',', $goods->ls_ranks);//不能购买的等级
        if (!in_array($this->user->user_id, $arr)) {//不存在能购买的会员中
            if (in_array($this->user->user_rank, $arr6)) {
                return [
                    'error' => 300,
                    'msg' => '商品限购'
                ];
            }
            if (in_array($this->user->country, $arr1) || in_array($this->user->province, $arr1) || in_array($this->user->city, $arr1) || in_array($this->user->district, $arr1)) {
                return [
                    'error' => 300,
                    'msg' => '商品限购'
                ];
            }
            if (!$this->user->is_zhongduan &&
                (in_array($this->user->country, $arr3) || in_array($this->user->province, $arr3) || in_array($this->user->city, $arr3)
                    || in_array($this->user->district, $arr3) || in_array($this->user->user_id, $arr5))
            ) {
                return [
                    'error' => 300,
                    'msg' => '商品限购'
                ];
            }
            if ($this->user->is_zhongduan &&
                (in_array($this->user->country, $arr2) || in_array($this->user->province, $arr2) || in_array($this->user->city, $arr2)
                    || in_array($this->user->district, $arr2) || in_array($this->user->user_id, $arr4))
            ) {
                return [
                    'error' => 300,
                    'msg' => '商品限购'
                ];
            }
        }
    }

    /**
     * @param $goods
     * @return array
     * 会员经营范围判断
     */
    public function checkJyfw($goods)
    {
        $this->user = $this->user->get_jyfw();
        if (!empty($goods->erp_shangplx) && !in_array($goods->erp_shangplx, $this->user->jyfw)) {
            return [
                'error' => 300,
                'msg' => "您提供的资质不具备购买{$goods->erp_shangplx}的权限，如需购买请联系客服人员",
            ];
        }
        if (empty($goods->erp_shangplx) && $this->user->is_only_buy == 1) {
            return [
                'error' => 300,
                'msg' => "您提供的资质不具备购买{$goods->goods_name}的权限，如需购买请联系客服人员",
            ];
        }
        if ($goods->is_mhj == 1 && $this->user->mhj_number == 0) {
            return [
                'error' => 300,
                'msg' => "不能购买麻黄碱商品",
            ];
        }
        if ($goods->is_mhj == 1 && $this->user->is_mhj_hz == 0) {
            return [
                'error' => 300,
                'msg' => "有麻黄碱订单未收到回执，应GSP要求请将回执盖章拍照发给您的专属客服，补交回执后即可购买，如有疑问请联系客服或拨打电话4006028262！",
            ];
        }
    }

    /**
     * @return array
     * 会员资质时效判断
     */
    public function checkUser()
    {
        if ($this->user->ls_review==0 || $this->user->ls_review_7day == 0 || ($this->user->ls_review_7day == 1 && $this->user->day7_time < time())) {
            return [
                'error' => 300,
                'msg' => '审核后才能参加活动',
            ];
        }
        if ($this->checkTime($this->user->yyzz_time)) {
            return [
                'error' => 300,
                'msg' => '您的' . trans('user.yyzz_time') . '已过期，请尽快重新邮寄'
            ];
        }
        if ($this->checkTime($this->user->xkz_time)) {
            return [
                'error' => 300,
                'msg' => '您的' . trans('user.xkz_time') . '已过期，请尽快重新邮寄'
            ];
        }
        if ($this->checkTime($this->user->zs_time)) {
            return [
                'error' => 300,
                'msg' => '您的' . trans('user.zs_time') . '已过期，请尽快重新邮寄'
            ];
        }
        if ($this->checkTime($this->user->yljg_time)) {
            return [
                'error' => 300,
                'msg' => '您的' . trans('user.yljg_time') . '已过期，请尽快重新邮寄'
            ];
        }
        if ($this->checkTime($this->user->cgwts_time)) {
            return [
                'error' => 300,
                'msg' => '您的' . trans('user.cgwts_time') . '已过期，请尽快重新邮寄'
            ];
        }
        if ($this->checkTime($this->user->org_cert_validity)) {
            return [
                'error' => 300,
                'msg' => '您的' . trans('user.org_cert_validity') . '已过期，请尽快重新邮寄'
            ];
        }
    }

    /**
     * @param $time
     * @return bool
     * 判断时间
     */
    public function checkTime($time)
    {
        return $time && strtotime($time) < $this->now;
    }
}