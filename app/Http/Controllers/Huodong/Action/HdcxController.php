<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/19
 * Time: 15:55
 */

namespace App\Http\Controllers\Huodong\Action;


use App\GiftGoods;
use App\Goods;
use App\Http\Controllers\Huodong\Hdcx;
use App\JpGoods;
use App\JpLog;
use App\YouHuiCate;
use App\YouHuiQ;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HdcxController implements Hdcx
{

    private $user;

    private $order;

    private $now;

    private $order_arr;

    public function __construct()
    {
        $this->now = time();
    }

    /**
     * 精品专区活动
     */
    public function jpzq($user, $jp_amount, $assign)
    {
        $assign['gifts']  = [];
        $start_time       = "2016-04-01 00:00:00";
        $end_time         = "2020-07-01 00:00:00";
        $is_jpzq_activity = false;
        $active_start     = strtotime($start_time);
        $active_end       = strtotime($end_time);

        $new_time = time();
        if ($new_time >= $active_start && $new_time < $active_end && in_array($user->user_rank, array('1', '2', '5', '7'))) {
            $is_jpzq_activity = true;
        }
        if ($is_jpzq_activity) {//精品专区活动
            $gift_id = $this->check_jpzq($jp_amount);
            if ($gift_id) {
                $gift_list = GiftGoods::where('is_show', 1)->where('cat_id', $gift_id)->orderBy('sort', 'desc')->orderBy('gift_id', 'desc')->take(5)->get();
                if ($gift_list) {
                    $gift_status     = 1;
                    $assign['gifts'] = $gift_list;
                }
            }
        }
        return $assign;
    }

    private function check_jpzq($fine_total_amount)
    {
        $cat_id = 0;
        if ($fine_total_amount >= 600 && $fine_total_amount < 1200) {
            $cat_id = 1;
        }
        if ($fine_total_amount >= 1200 && $fine_total_amount < 1800) {
            $cat_id = 2;
        }
        if ($fine_total_amount >= 1800 && $fine_total_amount < 2400) {
            $cat_id = 3;
        }
        if ($fine_total_amount >= 2400 && $fine_total_amount < 3000) {
            $cat_id = 4;
        }
        if ($fine_total_amount >= 3000) {
            $cat_id = 5;
        }
        return $cat_id;
    }

    /**
     * 充值余额
     */
    public function czye($user, $user_jnmj, $order)
    {
        $order['jnmj']         = $order['goods_amount'] - $order['goods_amount_mhj']
            - $order['discount'] - ($order['zyzk'] - $order['zyzk_mhj']) + $order['shipping_fee'];//排除麻黄碱之外的金额
        $order['czfl_message'] = "";//返利活动提示
        $czfl                  = $this->check_czfl($user, $user_jnmj, $order);
        if ($czfl['type'] == 0) {//可以参加充值余额活动
            if ($user_jnmj->jnmj_amount < $order['jnmj']) {
                $order['czfl_message']    = "充值金额不足";
                $order['jnmj']            = 0;
                $order['is_can_use_jnmj'] = false;
            } else {//能使用充值余额
                $order['is_can_zq'] = false;
            }
        } elseif ($czfl['type'] == 1) {//部分条件不满足 不能参加 给与提示
            $order['czfl_message']    = $czfl['message'];
            $order['is_can_use_jnmj'] = false;
            $order['jnmj']            = 0;
        } else {
            $order['is_can_use_jnmj'] = false;
            $order['jnmj']            = 0;
        }
        return $order;
    }

    private function check_czfl($user_info, $user_jnmj, $order)
    {
        $result = [
            'type'    => 0,
            'message' => "",
            'jnmj'    => ''
        ];
        $start  = strtotime('2016-05-25 00:00:00');
        $end    = strtotime('2018-04-01 00:00:00');
        $now    = time();
        if ($now > $end || $now < $start) {//不在活动范围内
            $result['type'] = 2;
            return $result;
        }
        if (!$user_jnmj || $order['goods_amount'] == $order['goods_amount_mhj']) {
            $result['type'] = 2;
            return $result;
        }
        if (!($user_info->is_zhongduan == 1 && $user_info->province == 26) || $order['is_can_use_jnmj'] == false) {//不是四川终端用户
            $result['type'] = 2;
            return $result;
        }
        if ($result['type'] == 0) {
            if ($user_info->zq_amount != 0) {//账期未结清
                $result['type']    = 1;
                $result['message'] .= "账期未结清 ";
                return $result;
            }
        }
        if ($user_jnmj) {//参加了充值返利
            if ($order['is_no_tj'] == false) {//含有特价商品
                $result['type']    = 1;
                $result['message'] .= "订单中含有特价商品 ";
            }
            if ($order['is_no_hy'] == false) {//含有哈药商品
                $result['type']    = 1;
                $result['message'] .= "订单中含有哈药商品 ";
            }
            if ($order['is_no_zyzk'] == false) {//含有优惠商品
                $result['type']    = 1;
                $result['message'] .= "订单中含有优惠商品 ";
            }
        }


        return $result;
    }

    /**
     * 换购
     */
    public function jehg($user, $order, $goods, $user_jnmj, $xz = 1)
    {
        $now    = time();
        $cs_arr = [13960, 18810, 12567, 18809];
        if (in_array($user->user_id, $cs_arr)) {
            $now = $now + 3600 * 24;
        }
        $status = $this->check_jehg($user, $user_jnmj, 2);
        if ($status == 1) {
            $hgs = DB::table('hg_goods')
                ->leftJoin('goods', 'hg_goods.goods_id', '=', 'goods.goods_id')
                ->leftJoin('goods_attr as ga', function ($join) {
                    $join->on('hg_goods.goods_id', '=', 'ga.goods_id')->where('ga.attr_id', '=', 3);
                })
                ->leftJoin('goods_attr as ga1', function ($join) {
                    $join->on('hg_goods.goods_id', '=', 'ga1.goods_id')->where('ga1.attr_id', '=', 1);
                })
                ->leftJoin('goods_attr as ga2', function ($join) {
                    $join->on('hg_goods.goods_id', '=', 'ga2.goods_id')->where('ga2.attr_id', '=', 2);
                })
                //->where('hg_goods.num','<=',$jehg)
                ->where('hg_goods.type', 1)//金额换购
                ->where('goods.is_change', 1)->where('change_start_date', '<=', $now)->where('change_end_date', '>=', $now)
                ->orderBy('hg_goods.num', 'desc')
                ->select('hg_goods.*', 'ga.attr_value as spgg', 'ga1.attr_value as sccj', 'ga1.attr_value as gyzz')
                ->get();
            if ($hgs) {//存在换购商品
                $ids_arr = [];//获取换购商品goods_id
                foreach ($hgs as $v) {
                    $ids_arr[] = $v->goods_id;
                }
                foreach ($goods as $k => $v) {//计算真实换购金额
                    $goods_status = $this->check_jehg_goods($v, $ids_arr, 0);
                    if ($goods_status == 1) {
                        //$order['jehg_amount'] += $v->subtotal;
                        if (strpos(strtolower($v->goods->tsbz), 'j') !== false) {
                            $order['jehg_amount'] += $v->subtotal;
                        }
                    }
                }
                $hg_goods_ids = [];//换购商品id
                foreach ($hgs as $v) {
                    $v->goods = Goods::where('goods_id', $v->hg_goods_id)->first();
                    //if ($order['jehg_amount'] > $v->num && $v->hg_goods_number <= $v->goods->goods_number && $v->hg_goods_number <= $v->total_number) {//实际商品金额大于换购金额 库存足够
                    if ($order['jehg_amount'] > $v->num && $v->hg_goods_number <= $v->goods->goods_number) {//实际商品金额大于换购金额 库存足够
//                        $has = DB::table('order_info as oi')->leftJoin('order_goods as og', 'oi.order_id', '=', 'og.order_id')
//                            ->where('oi.add_time', '>=', strtotime(20170607))
//                            ->where('oi.add_time', '<', strtotime(20170609))
//                            ->where('og.goods_id', $v->goods_id)
//                            ->where('og.tsbz', 'like', '%换%')
//                            ->where('oi.user_id', $user->user_id)
//                            ->count();
                        $has = 0;
                        if ($has == 0) {
                            $v->goods->real_price  = $v->hg_goods_price;
                            $v->goods_number       = $v->hg_goods_number;
                            $v->goods->tsbz        = '换';
                            $v->hg_id              = $v->rec_id;
                            $v->subtotal           = $v->goods->real_price * $v->goods_number;
                            $v->goods->goods_img   = !empty($v->goods->goods_img) ? $v->goods->goods_img : 'images/no_picture.gif';
                            $v->goods->goods_thumb = !empty($v->goods->goods_thumb) ? $v->goods->goods_thumb : 'images/no_picture.gif';
                            $v->goods->goods_img   = get_img_path($v->goods->goods_img);
                            $v->goods->goods_thumb = get_img_path($v->goods->goods_thumb);
                            $v->goods->sccj        = $v->sccj;
                            $v->goods->spgg        = $v->spgg;
                            $v->goods->gyzz        = $v->gyzz;
                            $order['hg_type']      = 2;
                            $order['hg_goods'][]   = $v;
                            if ($xz == 1) {
                                $goods[]               = $v;
                                $order['goods_amount'] += $v->subtotal;
                                $order['ty_amount']    += $v->subtotal;
                                $order['is_zy']        = 3;
                            }
                            $hg_goods_ids[] = $v->goods->goods_id;
                            if ($v->num >= 200) {
                                $order['is_can_zq']       = false;//不能使用账期
                                $order['is_can_use_jnmj'] = false;//不能使用充值余额
                            }
                        }
                    }
                }

                if ($order['is_zy'] == 3) {//存在换购商品
                    foreach ($goods as $k => $v) {//计算真实换购金额
                        if (in_array($v->goods->goods_id, $hg_goods_ids) && $v->goods->tsbz != '换') {//排除重复商品
                            $order['goods_amount'] -= $v->subtotal;
                            unset($goods[$k]);
                        }
                    }
                }

                if ($order['is_zy'] != 3) {
                    $order['jehg_message'] = '可参加换购商品金额为：' . formated_price($order['jehg_amount']);
                }
            }
        }

        return ['goods' => $goods, 'order' => $order];
    }

    private function check_jehg($user, $user_jnmj, $type = 0)
    {
        $status = 0;
        if ($type == 0) {
            if ($user->is_zhongduan == 1) {
                $status = 1;
            }
        } elseif ($type == 1) {
            if ((!$user_jnmj || ($user_jnmj && $user_jnmj->jnmj_amount == 0)) && $user->zq_amount == 0 && $user->is_zhongduan == 1) {
                $status = 1;
            }
        } elseif ($type == 2) {
            $status = 1;
        }
        return $status;
    }

    private function check_jehg_goods($v, $arr, $type = 0)
    {
        $status = 0;
        if ($type == 0) {
            if (!in_array($v->goods->goods_id, $arr)) {//不是和换购商品相同
                $status = 1;
            }
        } elseif ($type == 1) {
            if (!in_array($v->goods->goods_id, $arr) && $v->goods->is_cx == 0) {//不是和换购商品相同 且不是特价
                $status = 1;
            }
        }
        return $status;
    }

    /**
     * 优惠券
     */
    public function yhq($user, $order, $goods, $yhq_id = [])
    {
        return $this->yhq_new($user, $order, $goods, $yhq_id);
    }

    /**
     * 折扣活动
     */
    public function zhekou($goods, $order, $user)
    {
        $start = strtotime('2016-09-01 08:00:00');
        $end   = strtotime('2016-09-14 00:00:00');
        $now   = time();
        if ($user->is_zhongduan == 1) {//终端用户
            foreach ($goods as $k => $v) {
                if ($v->goods) {
                    if ($now >= $start && $now <= $end && strpos($v->goods->tsbz, 'b') !== false && $v->goods->is_mhj == 0) {//特殊标识为b的打9.8折
                        $order['discount']       += $v->subtotal;
                        $order['extension_code'] = 0.98;
                        $v->is_zhekou            = 1;
                    }
                }
            }
        }

        return $order;
    }

    /**
     * 秒杀商品
     */
    public function ms_goods($arr, $type = 0)
    {
        $goods_list = [];
        if ($type == 1) {
            Cache::tags(['miaosha', 'goods_list'])->flush();
        }
        if (!empty($arr)) {
            foreach ($arr as $v) {
                $goods        = Cache::tags(['miaosha', 'goods_list'])->rememberForever($v, function () use ($v) {
                    return Goods::with('goods_attr', 'member_price')->where('goods_id', $v)->first();
                });
                $goods_list[] = $goods;
            }
        }
        return $goods_list;
    }

    /**
     * 虚拟购物车(秒杀)
     */
    public function get_ms_goods($goods, $order, $user)
    {
        $cart_list = Cache::tags(['miaosha', 'cart_list'])->get($user->user_id);
        if (!empty($cart_list)) {
            foreach ($cart_list as $v) {
                $v->goods->tsbz        = '秒';
                $goods[]               = $v;
                $order['goods_amount'] += $v->goods->real_price * $v->goods_number;
            }
        }

        return [
            'goods' => $goods,
            'order' => $order,
        ];
    }

    /**
     * 对优惠券进行分类
     * union_type=0 该类优惠券累计到一起显示为一张,要么全部使用,要么全部不使用
     * union_type=1 该类优惠券分开显示(一般是呈现阶梯状:1000可以用a,2000可以用b),可以多选(3000选a后剩余2000满足条件可以选b)
     * union_type=2 该类优惠券券在满足条件下,一次只能使用一张
     */
    private function yhq_new($user, $order, $goods, $yhq_id = [])
    {
        $now    = time();
        $cs_arr = cs_arr();
//        if (in_array($user->user_id, $cs_arr)) {
//            $now = cs_time($now);
//        }
        if ($now >= strtotime(20171101) && $now < strtotime(20170901) && !in_array($user->user_id, $cs_arr)) {
            return $order;
        }
        $cat_id = [50];
        if ($now >= strtotime(20171007) && $now < strtotime(20171008)) {
            //$cat_id = [44];
        }
        /**
         * 查询有没有优惠券可以使用 满足该用户所有 满足未使用过 满足有效时间范围内 能够使用的
         */
        $youhuiq = YouHuiQ::where('user_id', $user->user_id)
            ->where('status', 0)->where('order_id', 0)//查询未使用的
            ->where('start', '<', $now)->where('end', '>', $now)
            ->where('union_type', '!=', 3)//不查询立减和打折
            ->where(function ($query) use ($user) {
                $query->where('user_rank', 'like', '%' . $user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) use ($user) {
                $query->where('area', 'like', '%' . $user->province . '%')->orwhere('area', '');
            })
            ->where('enabled', 1);
        if (!empty($yhq_id)) {
            if (in_array(-1, $yhq_id)) {//使用了所有能用的幸运券
                $youhuiq = $youhuiq->where(function ($query) use ($yhq_id) {
                    $query->where('union_type', 0)->orwhere('union_type', 4)->orwhereIn('yhq_id', $yhq_id);
                });
            } else {
                $youhuiq = $youhuiq->whereIn('yhq_id', $yhq_id);
            }
        }
//        $time = date('Ymd');
//        if ($time != '20170308' && $time != '20170315' && $time != '20170329') {
//            $youhuiq = $youhuiq->where('type', '!=', 0);
//        } else {
//            $youhuiq = $youhuiq->where('type', 0);
//        }
//        if (time() >= strtotime('2016-12-12') && time() < strtotime('2016-12-14')) {
//            $youhuiq = $youhuiq->where('type', 0);
//        }
        $youhuiq->orderBy('min_je')->orderBy('yhq_id');
        $this->take_num($order['ty_amount'], $youhuiq);
        // ->take(5)
        $youhuiq = $youhuiq->get();
        //dd($youhuiq,$order);
        $list       = [];
        $yhq_arr    = [];
        $ty_amount  = $order['ty_amount'];
        $zy_amount  = $order['zy_amount'];
        $fzy_amount = $order['fzy_amount'];
        if ($youhuiq) {
            $order['yhq_ids'] = [];
            $order['xyq_ids'] = [];
            foreach ($youhuiq as $k => $v) {
                $v->is_can_use_yhq = 1;
                if ($v->je >= 1) {//定额优惠券
                    if ($v->type == 0) {//通用优惠券
                        if ($v->union_type == 1 && $ty_amount < $v->min_je) {//累加类别优惠券
                            $v->is_can_use_yhq = 0;
                        } elseif ($order['ty_amount'] < $v->min_je) {
                            $v->is_can_use_yhq = 0;
                        }
                    } elseif ($v->type == 1) {//中药优惠券
                        if ($v->union_type == 1 && $zy_amount < $v->min_je) {//累加类别优惠券
                            $v->is_can_use_yhq = 0;
                        } elseif ($order['zy_amount'] < $v->min_je) {
                            $v->is_can_use_yhq = 0;
                        }
                    } elseif ($v->type == 2) {//非中药优惠券
                        if ($v->union_type == 1 && $fzy_amount < $v->min_je) {//累加类别优惠券
                            $v->is_can_use_yhq = 0;
                        } elseif ($order['fzy_amount'] < $v->min_je) {
                            $v->is_can_use_yhq = 0;
                        }
                    }
                }
//                else{//打折优惠券
//                    if ($ty_amount > $v->min_je) {//通用优惠券 超过最高金额
//                        $v->is_can_use_yhq = 0;
//                    }
//                }
                if ($v->union_type == 0 || $v->union_type == 4) {//union_type为零的直接默认使用,将所有券统一一起使用 显示方式与余额类似
                    if ($v->is_can_use_yhq == 1) {
                        $order['pack_fee']  += $v->je;
                        $order['min_je']    = $v->min_je;
                        $order['yhq_start'] = $v->start;
                        $order['yhq_end']   = $v->end;
                        $order['xyq_ids'][] = $v->yhq_id;
                    }
                }
                //dd($order);
                $list[$v->union_type][] = $v;
                if (!isset($yhq_arr[$v->union_type])) {//有可以使用的优惠券
                    $yhq_arr[$v->union_type] = 0;
                }
                if (!empty($yhq_id) && in_array($v->yhq_id, $yhq_id) && $v->is_can_use_yhq == 1) {
                    if ($v->union_type == 1) {
                        if ($v->type == 0) {
                            $ty_amount -= $v->min_je;
                        } elseif ($v->type == 1) {
                            $zy_amount -= $v->min_je;
                        } elseif ($v->type == 2) {
                            $fzy_amount -= $v->min_je;
                        }
                    }
                    if ($v->union_type == 2) {
                        if ($yhq_arr[$v->union_type] == 0) {//积分券只能使用1张
                            $order['pack_fee']  += $v->je;
                            $order['yhq_ids'][] = $v->yhq_id;
                            $yhq_arr[$v->union_type]++;
                        }
                    } else {
                        $order['pack_fee']  += $v->je;
                        $order['yhq_ids'][] = $v->yhq_id;
                        $yhq_arr[$v->union_type]++;
                    }
                }
            }

//            if($order['pack_fee']>0){//使用了优惠券
//                $order['is_can_zq'] = false;
//                $order['is_can_use_jnmj'] = false;
//                $order['discount'] = 0;
//                $order['extension_code'] = 0;
//            }
            $order['yhq_ids'] = array_merge($order['yhq_ids'], $order['xyq_ids']);
            //dd($order,$yhq_arr);
            $order['yhq_list'] = $list;
            $order['yhq_arr']  = $yhq_arr;
            $order['sy_num']   = 6;
        }
        return $order;
    }

    /**
     * tsbz = c
     */
    public function tsbz_c($goods, $order, $user)
    {
        $start = strtotime('2016-10-12 08:00:00');
        $end   = strtotime('2016-11-01 00:00:00');
        $now   = time();
        foreach ($goods as $k => $v) {
            if ($v->goods) {
                if ($now >= $start && $now <= $end && strpos($v->goods->tsbz, 'c') !== false && $v->goods->is_mhj == 0 && $v->goods_number >= 5) {//特殊标识为c的 满5盒单价减1元
                    $order['goods_amount'] -= 1 * $v->goods_number;
                    $v->goods->real_price  -= 1;
                }
            }
        }


        return [
            'goods' => $goods,
            'order' => $order,
        ];
    }

    /**
     * 生成优惠券
     * type = 0 通用 type = 1 中药 type = 2 非中药
     */
    public function create_yhq($order_info, $order, $user, $type = 0)
    {
        $now = time();
        /**
         * 查询有没有优惠券可以生成 按最高条件送
         */
        $youhuiq_cate = YouHuiCate::with('yhq_attr')->where('sctj', 3)
            //->where('goods_amount','<',$order['zy_amount'])
            ->where('status', 1)->where('gz_start', '<', $now)->where('gz_end', '>', $now)->where('num', '>', 0)
            ->where(function ($query) use ($user) {
                $query->where('user_rank', 'like', '%' . $user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) use ($user) {
                $query->where('area', 'like', '%' . $user->province . '%')->orwhere('area', '');
            });
        if ($type == 0) {
            $youhuiq_cate->where('goods_amount', '<', $order['ty_amount']);
        } elseif ($type == 1) {
            $youhuiq_cate->where('goods_amount', '<', $order['zy_amount']);
        } elseif ($type == 2) {
            $youhuiq_cate->where('goods_amount', '<', $order['fzy_amount']);
        }
        $youhuiq_cate = $youhuiq_cate->orderBy('goods_amount', 'desc')
            ->first();
        if ($youhuiq_cate) {//有优惠券规则
            $count = YouHuiQ::where('cat_id', $youhuiq_cate->cat_id)->where('user_id', $user->user_id)->count();//查询该优惠券规则已经生成的优惠券数量
            if ($count >= $youhuiq_cate->yhq_num) {//已达到最大可以拥有的数量
                return $order;
            }
            $youhuiq               = new YouHuiQ();
            $youhuiq->user_id      = $user->user_id;
            $youhuiq->old_order_id = $order_info->order_id;
            //$youhuiq->old_order_id1 = $this->order_info->other_order_id;
            $youhuiq->cat_id     = $youhuiq_cate->cat_id;
            $youhuiq->min_je     = $youhuiq_cate->min_je;
            $youhuiq->area       = $youhuiq_cate->area;
            $youhuiq->user_rank  = $youhuiq_cate->user_rank;
            $youhuiq->start      = $youhuiq_cate->start;
            $youhuiq->end        = $youhuiq_cate->end;
            $youhuiq->je         = $youhuiq_cate->je;
            $youhuiq->type       = $youhuiq_cate->type;
            $youhuiq->yxq_type   = $youhuiq_cate->yxq_type;
            $youhuiq->yxq_days   = $youhuiq_cate->yxq_days;
            $youhuiq->union_type = $youhuiq_cate->union_type;
            $youhuiq->sctj       = $youhuiq_cate->sctj;
            if ($youhuiq_cate->yxq_type == 0) {
                $youhuiq->start = strtotime(date('Y-m-d', time()));
                $youhuiq->end   = $youhuiq->start + $youhuiq_cate->yxq_days * 24 * 3600;
            } else {
                $youhuiq->start = $youhuiq_cate->start;
                $youhuiq->end   = $youhuiq_cate->end;
            }
            $youhuiq->name     = $youhuiq_cate->name;
            $youhuiq->add_time = $now;
            $youhuiq->save();
            $youhuiq_cate->num = $youhuiq_cate->num - 1;
            $youhuiq_cate->save();

            $order['new_yhq'] = $youhuiq;

        }
        return $order;
    }

    public function yhq_other($user, $order, $order_arr)
    {
        $this->user      = $user;
        $this->order     = $order;
        $this->order_arr = $order_arr;
        $arr             = JpGoods::where('status', 1)->where('type', 2)
            ->where('start', '<', $this->now)->where('end', '>', $this->now)
            ->orderBy('sort_order')->get();
        $jishu           = 0;
        if (count($arr) > 0) {
            foreach ($arr as $v) {
                if (($v->number - $v->ls_num) > 0) {//还有剩余数量
                    $jishu += $v->zjgl;
                }
            }
            $this->get_num($arr, $jishu);
        }
        return [
            'order'     => $this->order,
            'order_arr' => $this->order_arr,
        ];
    }

    private function get_num($list, $jishu)
    {
        $res = -1;
        foreach ($list as $k => $v) {
            if (($v->number - $v->ls_num) > 0) {
                $rand = mt_rand(1, $jishu);
                if ($rand <= $v->zjgl) {
                    $res = $k;
                    break;
                } else {
                    $jishu -= $v->zjgl;
                }
            }
        }
        if ($res == -1) {
            return -1;
        }

        $this->jp_log($list[$res]);

        return $res;
    }

    private function jp_log($jp)
    {
        DB::transaction(function () use ($jp) {
            $status = 0;
            if ($jp->cat_id > 0) {
                $status = $this->create_yhq_cj($jp->cat_id);
            }
            if ($status == 1 || $jp->cat_id == 0) {
                $jp_log           = new JpLog();
                $jp_log->user_id  = $this->user->user_id;
                $jp_log->add_time = time();
                $jp_log->log      = $jp->jp_name;
                $jp_log->jp_id    = $jp->jp_id;
                $jp_log->bm       = date('YmdHis') . $this->user->user_id . $jp->jp_id;
                if ($jp->jp_name != '未中奖') {
                    $jp_log->is_zj = 1;
                } else {
                    $jp_log->is_zj = 0;
                }
                $jp_log->save();
                $jp->ls_num = $jp->ls_num + 1;
                $jp->save();
            }
        });
    }

    private function create_yhq_cj($cat_id)
    {
        /**
         * 查询有没有优惠券可以生成 在满足的条件中随机送
         */
        $youhuiq_cate = YouHuiCate::where('sctj', 7)
            ->where('status', 1)->where('gz_start', '<', $this->now)->where('gz_end', '>', $this->now)
            ->where('num', '>', 0)->where('cat_id', $cat_id)
            ->where(function ($query) {
                $query->where('user_rank', 'like', '%' . $this->user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) {
                $query->where('area', 'like', '%' . $this->user->province . '%')->orwhere('area', '');
            });
        $youhuiq_cate = $youhuiq_cate->first();
        if ($youhuiq_cate) {//有优惠券
            $yhq_je = 0;
            $count  = YouHuiQ::where('cat_id', $youhuiq_cate->cat_id)->where('user_id', $this->user->user_id)->count();//查询该优惠券规则已经生成的优惠券数量
            if ($count >= $youhuiq_cate->yhq_num) {//已达到最大可以拥有的数量
                return 0;
            }

            if ($youhuiq_cate->union_type == 0) {//立减
                if ($this->order->order_amount < $youhuiq_cate->goods_amount) {//不满足使用要求
                    return 0;
                } else {
                    $this->order->pack_fee      += $youhuiq_cate->je;
                    $yhq_je                     = $youhuiq_cate->je;
                    $this->order->order_amount  -= $youhuiq_cate->je;
                    $this->order_arr['zj_type'] = 1;
                }
            } elseif ($youhuiq_cate->union_type == 3) {//免单,半价
                if ($this->order->order_amount > $youhuiq_cate->goods_amount || $youhuiq_cate->je > 1) {//不满足要求
                    return 0;
                } else {
                    $this->order->pack_fee     += $this->order->order_amount * $youhuiq_cate->je;
                    $yhq_je                    = $this->order->order_amount * $youhuiq_cate->je;
                    $this->order->order_amount -= $this->order->order_amount * $youhuiq_cate->je;
                    if ($this->order->order_amount > 0) {//半价
                        $this->order_arr['zj_type'] = 2;
                    } else {//免单
                        $this->order_arr['zj_type'] = 3;
                    }
                }
            }

            if ($this->order->order_amount == 0) {
                $this->order->pay_status = 2;
                $this->order->pay_time   = $this->now;
            }
            $youhuiq            = new YouHuiQ();
            $youhuiq->user_id   = $this->user->user_id;
            $youhuiq->cat_id    = $youhuiq_cate->cat_id;
            $youhuiq->min_je    = $youhuiq_cate->min_je;
            $youhuiq->area      = $youhuiq_cate->area;
            $youhuiq->user_rank = $youhuiq_cate->user_rank;
            if ($yhq_je > 0) {
                $youhuiq->je = $yhq_je;
            } else {
                $youhuiq->je = $youhuiq_cate->je;
            }
            $youhuiq->type       = $youhuiq_cate->type;
            $youhuiq->yxq_type   = $youhuiq_cate->yxq_type;
            $youhuiq->yxq_days   = $youhuiq_cate->yxq_days;
            $youhuiq->union_type = $youhuiq_cate->union_type;
            $youhuiq->sctj       = $youhuiq_cate->sctj;
            if ($youhuiq_cate->yxq_type == 0) {
                $youhuiq->start = strtotime(date('Y-m-d', time()));
                $youhuiq->end   = $youhuiq->start + $youhuiq_cate->yxq_days * 24 * 3600;
            } else {
                $youhuiq->start = $youhuiq_cate->start;
                $youhuiq->end   = $youhuiq_cate->end;
            }
            $youhuiq->name     = $youhuiq_cate->name;
            $youhuiq->add_time = $this->now;
            $youhuiq->enabled  = 1;
            $youhuiq->status   = 1;
            $youhuiq->order_id = $this->order->order_id;
            $youhuiq->use_time = time();
            $youhuiq->save();
            $youhuiq_cate->num = $youhuiq_cate->num - 1;
            $youhuiq_cate->save();
        }
        return 1;
    }

    private function take_num($goods_amount, $query)
    {
        $start = strtotime('2017-02-01');
        $end   = strtotime('2017-04-01');
        $num   = 0;
        if ($this->now >= $start && $this->now <= $end) {
            $goods_amount_l = $goods_amount;
            do {
                if ($goods_amount_l >= 5000) {
                    $num            += 15;
                    $goods_amount_l -= 5000;
                } elseif ($goods_amount_l >= 3000) {
                    $num += 8;
                    //dd($goods_amount_l);
                    $goods_amount_l -= 3000;
                } elseif ($goods_amount_l >= 2000) {
                    $num            += 5;
                    $goods_amount_l -= 2000;
                } elseif ($goods_amount_l >= 1000) {
                    $num            += 2;
                    $goods_amount_l -= 1000;
                }
            } while ($goods_amount_l >= 1000);
            $query->take($num);
        }
        return $query;
    }
}