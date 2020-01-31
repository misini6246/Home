<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\MsCart;
use App\Models\MsGoods;
use App\Models\MsGroup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class MsController extends Controller
{
    public $type;

    public $group_id;

    public $tags;

    public $user;

    public $model;

    public $assign;

    public $now;

    public $is_cs;

    public $start = 0;

    public $end = 0;

    public function __construct(Request $request, User $user)
    {
        $this->model              = Redis::connection('miaosha');
        $this->type               = intval($request->input('type'));
        $this->group_id           = intval($request->input('group_id'));
        $this->tags               = $this->type_tags($this->type);
        $this->now                = time();
        $this->user               = $user;
        $this->assign['now']      = $this->now;
        $this->assign['type']     = $this->type;
        $this->assign['group_id'] = $this->group_id;
    }

    public function index()
    {
        $this->user = auth()->user();
        $keys       = $this->bl($this->tags . 'ms_group*');
        $result     = collect();
        foreach ($keys as $v) {
            $ms_group         = $this->build_group($v);
            $key              = $this->bl($this->tags . 'ms_goods:' . $ms_group->group_id . ':*');
            $ms_goods_collect = collect();
            foreach ($key as $val) {
                $ms_goods = $this->build_goods($val);
                $new_key  = str_replace('ms_goods', 'goods', $val);
                $ms_goods->setRelation('goods', $this->build_info($new_key));
                $ms_goods_collect->push($ms_goods);
            }
            $ms_group->setRelation('ms_goods', $ms_goods_collect);
            $result->push($ms_group);
            if ($this->start == 0) {
                $this->start = $ms_group->start;
            } elseif ($ms_group->start < $this->start) {
                $this->start = $ms_group->start;
            }
            if ($ms_group->end > $this->end) {
                $this->end = $ms_group->end;
            }
        }
        $result = $result->sortByDesc('start');
        if (count($result) == 0) {
            show_msg('活动未开始');
        }
        if ($this->now < $this->start) {
            show_msg('活动未开始');
        }
        if ($this->now >= $this->end) {
            show_msg('活动已结束');
        }
        $this->assign['result'] = $result;
        if (count($result) == 1) {
            $view = 'miaosha.one';
        } else {
            $view = 'miaosha.three';
        }
        return view($view, $this->assign);
    }

    public function store(Request $request)
    {
        $this->user = auth()->user();
        if (!$this->user) {
            ajax_return('请登录后再操作', 2);
        }
        $this->user = $this->user->is_zhongduan();
        if ($this->user->is_zhongduan == 0) {
            ajax_return('该商品仅限终端客户购买', 1);
        }
        $this->user = $this->user->get_jyfw();
        $goods_id   = intval($request->input('goods_id'));
        $ms_group   = $this->build_group($this->cache_keys(), 1);
        $info       = $this->build_goods($this->cache_keys(1, $goods_id), 1);
        if ($this->now < $ms_group->start) {
            ajax_return('活动未开始', 1);
        }
        if ($this->now >= $ms_group->end) {
            ajax_return('活动已结束', 1);
        }
        if (count($info->area_xg) > 0) {
            if (!in_array($this->user->province, $info->area_xg)) {
                ajax_return('该商品仅限' . $info->area_xg_msg . '终端客户购买', 1);
            }
        }
        $goods = $this->model->get($this->cache_keys(2, $goods_id));
        $goods = json_decode($goods);
        if (!empty($goods->erp_shangplx) && !in_array($goods->erp_shangplx, $this->user->jyfw)) {
            ajax_return("您的经营范围没有购买" . $goods->erp_shangplx . "的权限，如需购买请联系客服人员", 1);
        }
        if (empty($goods->erp_shangplx) && $this->user->is_only_buy == 1) {
            ajax_return("您的经营范围没有购买" . $goods->erp_shangplx . "的权限，如需购买请联系客服人员", 1);
        }
        if ($goods->is_mhj == 1 && $this->user->mhj_number == 0) {
            ajax_return('不能购买麻黄碱商品', 1);
        }
        if ($this->model->hexists($this->cache_keys(3, $goods_id), 'goods_id') && $info->is_can_change == 0) {
            ajax_return('商品已抢购', 1, ['kc' => $info->goods_number]);
        }
        if ($info->cart_number > $info->goods_number) {
            ajax_return('库存不足', 1, ['kc' => $info->goods_number]);
        }
        $this->model->transaction(function () use ($info) {
            $this->model->pipeline(function ($pipe) use ($info) {
                $key = $this->cache_keys(3, $info->goods_id);
                $arr = [
                    'user_id'      => $this->user->user_id,
                    'goods_id'     => $info->goods_id,
                    'group_id'     => $info->group_id,
                    'type'         => $this->type,
                    'goods_price'  => $info->real_price,
                    'goods_number' => $info->cart_number,
                    'is_order'     => 0,
                    'add_time'     => $this->now,
                    'update_time'  => $this->now,
                ];
                foreach ($arr as $k => $v) {
                    $pipe->hset($key, $k, $v);
                }
                if ($this->is_cs == 1) {
                    $hkey = 'cs_num';
                } else {
                    $hkey = 'goods_number';
                }
                $pipe->hincrby($this->cache_keys(1, $info->goods_id), $hkey, $info->cart_number * (-1));
            });
        });
        ajax_return('商品成功加入购物车', 0, ['kc' => $info->goods_number - $info->cart_number]);
    }

    public function ms_cart($rec_ids = [])
    {
        $result = collect();
        if (!$this->user) {
            return $result;
        }
        $this->user = $this->user->is_zhongduan();
        if ($this->user->is_zhongduan == 0) {
            $result->total     = 0;
            $result->goods_ids = [];
            return $result;
        }
        $keys      = $this->bl($this->tags . 'ms_cart:' . $this->user->user_id . ':*');
        $goods_ids = [];
        $total     = 0;
        foreach ($keys as $v) {
            $ms_cart = $this->build_cart($v);
            if (is_numeric($ms_cart)) {
                continue;
            }
            if ($ms_cart->is_order != 0) {
                continue;
            }
            $this->type     = $ms_cart->type;
            $this->group_id = $ms_cart->group_id;
            $goods_id       = $ms_cart->goods_id;
            $ms_group       = $this->build_group($this->cache_keys(), 2);
            if (is_numeric($ms_group)) {
                continue;
            }
            $info = $this->build_goods($this->cache_keys(1, $goods_id), 2);
            if (is_numeric($info)) {
                continue;
            }
            if ($this->now < $ms_group->start) {
                continue;
            }
            if ($this->now >= $ms_group->end) {
                continue;
            }
            if (count($info->area_xg) > 0) {
                if (!in_array($this->user->province, $info->area_xg)) {
                    continue;
                }
            }
            $goods = $this->build_info($this->cache_keys(2, $goods_id), 2);
            if (is_numeric($goods)) {
                continue;
            }
            if (!empty($goods->erp_shangplx) && !in_array($goods->erp_shangplx, $this->user->jyfw)) {
                continue;
            }
            if (empty($goods->erp_shangplx) && $this->user->is_only_buy == 1) {
                continue;
            }
            if ($goods->is_mhj == 1 && $this->user->mhj_number == 0) {
                continue;
            }
            if (count($rec_ids) > 0 && !in_array($ms_cart->goods_id * (-1), $rec_ids)) {
                continue;
            }
            $new_cart = new Cart();
            $arr      = [
                'rec_id'        => $ms_cart->goods_id * (-1),
                'goods_id'      => $ms_cart->goods_id,
                'goods_number'  => $ms_cart->goods_number,
                'goods_price'   => $ms_cart->goods_price,
                'parent_id'     => 0,
                'is_checked'    => 1,
                'is_can_change' => $info->is_can_change,
                'is_ms'         => 1,
            ];
            $new_cart->forceFill($arr);
            $ms_cart->setRelation('ms_goods', $info);
            $goods = $this->attr($goods, $ms_cart);
            $new_cart->setRelation('goods', $goods);
            $result->push($new_cart);
            $goods_ids[] = $ms_cart->goods_id;
            $total       += $ms_cart->goods_number * $ms_cart->goods_price;
        }
        $result->goods_ids = $goods_ids;
        $result->total     = $total;
        return $result;
    }

    private function type_tags($key)
    {
        $arr = [
            0 => 'miaosha:',
            1 => 'yushou:',
            2 => 'other:',
        ];
        return isset($arr[$key]) ? $arr[$key] : $key;
    }

    protected function build_group($key, $type = 0)
    {
        if (!$this->model->hexists($key, 'group_id')) {
            return $this->retype('活动不存在', $type);
        }
        $info   = $this->model->hgetAll($key);
        $result = new MsGroup();
        $result->forceFill($info);
        if ($this->user && in_array($this->user->user_id, cs_arr()) && $result->is_cs == 1) {
            $this->is_cs   = 1;
            $result->start = $result->cs_start;
            $result->end   = $result->cs_end;
        }
        if ($result->enabled == 0) {
            return $this->retype('活动不存在', $type);
        }
        return $result;
    }

    protected function build_goods($key, $type = 0)
    {
        if (!$this->model->hexists($key, 'group_id')) {
            return $this->retype('商品不存在', $type);
        }
        $info   = $this->model->hgetAll($key);
        $result = new MsGoods();
        $result->forceFill($info);
        if ($this->is_cs == 1) {
            $result->goods_number = $result->cs_num;
        }
        return $result;
    }

    protected function build_info($key, $type = 0)
    {
        if (!$this->model->exists($key)) {
            return $this->retype('商品信息不存在', $type);
        }
        $result = $this->model->get($key);
        $result = json_decode($result);
        return $result;
    }

    protected function build_cart($key, $type = 0)
    {
        if (!$this->model->hexists($key, 'group_id')) {
            return $this->retype('商品不存在', $type);
        }
        $info   = $this->model->hgetAll($key);
        $result = new MsCart();
        $result->forceFill($info);
        return $result;
    }

    protected function build_ygm($key)
    {
        if ($this->model->exists($key)) {
            $result = $this->model->get($key);
            $result = json_decode($result);
            $result = collect($result);
        } else {
            $result = collect();
        }
        return $result;
    }

    public function cache_keys($type = 0, $id = 0)
    {
        $key = '';
        switch ($type) {
            case 0:
                $key = $this->tags . 'ms_group:' . $this->group_id;
                break;
            case 1:
                $key = $this->tags . 'ms_goods:' . $this->group_id . ':' . $id;
                break;
            case 2:
                $key = $this->tags . 'goods:' . $this->group_id . ':' . $id;
                break;
            case 3:
                $key = $this->tags . 'ms_cart:' . $this->user->user_id . ':' . $id;
                break;
            case 4:
                $key = $this->tags . 'ygm:' . $this->user->user_id . ':' . $id;
                break;
        }
        return $key;
    }

    private function attr($v, $info)
    {
        $v->goods_url = route('goods.index', ['id' => $v->goods_id]);
        if ($v->is_zyyp == 1) {
            $v->goods_url = route('goods.zyyp', ['id' => $v->goods_id]);
        }
        $v->spgg       = $v->ypgg;
        $v->is_xq_red  = 0;
        $v->zbz        = $info->cart_number;
        $v->real_price = $info->goods_price;
        $v->cxxx       = '';
        $v->bzxx       = '';
        $v->bzxx2      = '';
        $v->tsbz       = $info->ms_goods->tsbz;
        return $v;
    }

    protected function retype($msg, $type = 0)
    {
        switch ($type) {
            case 0:
                show_msg($msg);
                break;
            case 1:
                ajax_return($msg, 1);
                break;
            case 2:
                return 0;
                break;
        }
    }

    public function change_order($id, $order_id)
    {
        $this->model->transaction(function () use ($id, $order_id) {
            $ygm            = $this->build_ygm($this->cache_keys(4, $id));
            $ms_cart        = $this->build_cart($this->cache_keys(3, $id));
            $this->type     = $ms_cart->type;
            $this->group_id = $ms_cart->group_id;
            $ms_goods       = $this->build_goods($this->cache_keys(1, $id));
            if ($ms_goods->is_can_change == 1) {
                $ms_cart->order_id = $order_id;
                $ygm->push($ms_cart);
                $this->model->set($this->cache_keys(4, $id), $ygm);
            }
            $this->model->hset($this->cache_keys(3, $id), 'is_order', 1);
        });
    }

    public function del_cart($id)
    {
        $this->model->del($this->cache_keys(3, abs($id)));
    }

    public function get_cart($id)
    {
        $ms_cart        = $this->build_cart($this->cache_keys(3, abs($id)));
        $this->type     = $ms_cart->type;
        $this->group_id = $ms_cart->group_id;
        $ms_group       = $this->build_group($this->cache_keys(), 1);
        $ms_cart->setRelation('ms_group', $ms_group);
        $ms_goods = $this->build_goods($this->cache_keys(1, abs($id)), 1);
        $ms_cart->setRelation('ms_goods', $ms_goods);
        $goods = $this->build_info($this->cache_keys(2, abs($id)), 1);
        $ms_cart->setRelation('goods', $goods);
        return $ms_cart;
    }

    public function change_number($id, $num)
    {
        $this->model->transaction(function () use ($id, $num) {
            if ($this->is_cs == 1) {
                $hkey = 'cs_num';
            } else {
                $hkey = 'goods_number';
            }
            $this->model->hincrby($this->cache_keys(3, $id), 'goods_number', $num);
            $this->model->hincrby($this->cache_keys(1, $id), $hkey, $num * (-1));
        });
    }

    public function final_num($ms_cart, $num)
    {
        $msg          = '';
        $jzl          = $ms_cart->goods->jzl;
        $zbz          = $ms_cart->ms_goods->cart_number;
        $goods_number = $ms_cart->ms_goods->goods_number;
        $xg_number    = $ms_cart->ms_goods->xg_number;
        $fh           = 1;
        if ($num < 0) {
            $fh = -1;
        }
        $num       = ceil(abs($num) / $zbz) * $zbz * $fh;
        $final_num = $ms_cart->goods_number + $num;
        $final_num = ceil(abs($final_num) / $zbz) * $zbz;
        if ($final_num < $zbz) {
            $final_num = $zbz;
        }
        if ($jzl > 0) {//件装量不是中包装整数倍
            $jzl      = ceil($jzl / $zbz) * $zbz;
            $jzl_line = ceil(($jzl * 0.8) / $zbz) * $zbz;
            if ($final_num % $jzl >= $jzl_line) {
                if ($fh >= 0) {
                    $final_num = ceil($final_num / $jzl) * $jzl;
                    $msg       = '温馨提示：您所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。';
                } else {
                    $final_num = floor($final_num / $jzl) * $jzl + ($jzl_line - $zbz);
                }
            }
        }
        if ($xg_number > 0) {
            $ygm     = $this->build_ygm($this->cache_keys(4, $ms_cart->goods_id));
            $ygm_num = 0;
            foreach ($ygm as $v) {
                $ygm_num += $v->goods_number;
            }
            if ($final_num > $xg_number - $ygm_num) {
                $final_num = $xg_number - $ygm_num;
            }
        }
        $num = $final_num - $ms_cart->goods_number;
        if ($num > $goods_number) {
            $num = $goods_number;
        }
        $final_num = $ms_cart->goods_number + $num;
        return [
            'msg'           => $msg,
            'final_num'     => $final_num,
            'change_number' => $num,
        ];
    }

    protected function bl($key, $bh = 0, $arr = [])
    {
        $result = $this->model->scan($bh, ['count' => 100, 'match' => $key]);
        $bh     = $result[0];
        $arr    = array_merge($arr, $result[1]);
        if ($bh != 0) {
            $this->bl($key, $bh, $arr);
        }
        return $arr;
    }
}
