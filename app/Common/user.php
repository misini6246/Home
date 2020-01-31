<?php

use App\Cart;
use App\Goods;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/30
 * Time: 8:53
 */
/* 订单状态 */
define('OS_UNCONFIRMED', 0); // 未确认
define('OS_CONFIRMED', 1); // 已确认
define('OS_CANCELED', 2); // 已取消
define('OS_INVALID', 3); // 无效
define('OS_RETURNED', 4); // 退货
define('OS_SPLITED', 5); // 已分单
define('OS_SPLITING_PART', 6); // 部分分单
/* 支付状态 */
define('PS_UNPAYED', 0); // 未付款
define('PS_PAYING', 1); // 付款中
define('PS_PAYED', 2); // 已付款
// 2014-12-16
define('SS_UNSHIPPED', 0); // 未发货
define('SS_PREPARING', 1); // 已开票  改 3->1  改“备货中”为“已开票”
define('SS_SHIPPED_PART', 2); // 已拣货  改 4->2  改“已发货(部分商品)”为“已拣货”
define('SS_SHIPPED_ING', 3); // 已出库  改 5->3  改“发货中(处理分单)”为“已出库”
define('SS_SHIPPED', 4); // 已发货  改 1->4
define('SS_RECEIVED', 5); // 已完成  改 2->5   已收货->已完成
define('OS_SHIPPED_PART', 6); // 已发货(部分商品)  保留
/*
 * 订单状态
 */
function oStatus($type)
{
    $status = [
        0 => '未确认',
        1 => '已确认',
        2 => '已取消',
        3 => '无效',
        4 => '退货',
        5 => '已分单',
        6 => '部分分单',
    ];
    return $status[$type];
}

/*
 * 支付状态
 */
function pStatus($type)
{
    $status = [
        0 => '未付款',
        1 => '付款中',
        2 => '已付款',
    ];
    return $status[$type];
}

/*
 * 发货状态
 */
function sStatus($type)
{
    $status = [
        0 => '未发货',
        1 => '已开票',
        2 => '已拣货',
        3 => '已出库',
        4 => '已发货',
        5 => '已完成',
        6 => '已发货(部分商品)',
    ];
    return $status[$type];
}

/*
 * 订单状态
 * @order_id 订单id
 * @order_status 订单状态
 * @pay_status 支付状态
 * @shipping_status 物流状态
 * @name 返回内容
 */
function order_status($order_id, $order_status, $pay_status, $shipping_status, $name = '')
{
    $result = [
        'status' => 0,
        'content' => '',
        'tip' => '',
        'handle' => '',
    ];
    if ($order_status == OS_CONFIRMED && $pay_status == PS_UNPAYED && $shipping_status == SS_UNSHIPPED) {
        $result = [
            'status' => 1,//订单已确认，未付款，未发货
            'content' => '请您尽快完成付款，订单为未付款。',
            'tip' => '未付款',
            'handle' => "<a href='" . route('user.orderInfo', ['id' => $order_id]) . "'>付款</a>",
        ];
    }
    if ($order_status == OS_CONFIRMED && ($pay_status == PS_PAYED || $pay_status == PS_PAYING) && $shipping_status == SS_UNSHIPPED) {
        $result = [
            'status' => 2,//订单已确认，已付款，未发货
            'content' => '您的订单商家正在积极备货中，未发货。',
            'tip' => '已付款',
            'handle' => "<span>已付款</span>",
        ];
    }
    if ($order_status == OS_CONFIRMED && ($pay_status == PS_PAYED || $pay_status == PS_PAYING) && $shipping_status == SS_PREPARING) {
        $result = [
            'status' => 3,//订单已确认，已付款，已开票
            'content' => '您的订单商家已开票。',
            'tip' => '待发货',
            'handle' => "<span>已付款</span>",
        ];
    }
    if ($order_status == OS_CONFIRMED && ($pay_status == PS_PAYED || $pay_status == PS_PAYING) && $shipping_status == SS_SHIPPED_PART) {
        $result = [
            'status' => 4,//订单已确认，已付款，已拣货
            'content' => '您的订单正在已拣货，请您耐心等待。',
            'tip' => '已拣货',
            'handle' => "<span>已付款</span>",
        ];
    }
    if ($order_status == OS_CONFIRMED && ($pay_status == PS_PAYED || $pay_status == PS_PAYING) && $shipping_status == SS_SHIPPED_ING) {
        $result = [
            'status' => 5,//订单已确认，已付款，已出库
            'content' => '您的订单现已出库。',
            'tip' => '已出库',
            'handle' => "<span>已付款</span>",
        ];
    }
    if ($order_status == OS_CONFIRMED && ($pay_status == PS_PAYED || $pay_status == PS_PAYING) && $shipping_status == SS_SHIPPED) {
        $result = [
            'status' => 6,//订单已确认，已付款，已发货
            'content' => '您的订单已发货。',
            'tip' => '已发货',
            'handle' => "<a href='" . route('user.orderInfo', ['id' => $order_id]) . "'>确认收货</a>",
        ];
    }
    if ($order_status == OS_CONFIRMED && ($pay_status == PS_PAYED || $pay_status == PS_PAYING) && $shipping_status == SS_RECEIVED) {
        $result = [
            'status' => 7,//订单已确认，已付款，已完成
            'content' => "<font color='red'>您的订单已送达成功！已完成。</font>",
            'tip' => "已完成",
            'handle' => "<span>已完成</span>",
        ];
    }
    if ($order_status == OS_CANCELED && $pay_status == PS_UNPAYED) {
        $result = [
            'status' => 8,//订单已取消，未付款，未发货
            'content' => "<font color='red'>您的订单已取消。</font>",
            'tip' => "已取消",
            'handle' => "<span style='color:red'>已取消</span>",
        ];
    }
    if ($name == '') {
        return $result;
    } else {
        return $result[$name];
    }
}

function order_status_zq($order_id, $order_status, $pay_status, $shipping_status, $name = '')
{
    $result = [
        'status' => 0,
        'content' => '',
        'tip' => '',
        'handle' => '',
    ];
    if ($order_status == OS_CONFIRMED && $pay_status == PS_UNPAYED && $shipping_status == SS_UNSHIPPED) {
        $result = [
            'status' => 1,//订单已确认，未付款，未发货
            'content' => '请您尽快完成付款，订单为未付款。',
            'tip' => '未付款',
            'handle' => "<a href='" . route('user.orderInfo', ['id' => $order_id]) . "'>付款</a>",
        ];
    }
    if ($order_status == OS_CONFIRMED && ($pay_status == PS_PAYED || $pay_status == PS_PAYING) && $shipping_status == SS_UNSHIPPED) {
        $result = [
            'status' => 2,//订单已确认，已付款，未发货
            'content' => '您的订单商家正在积极备货中，未发货。',
            'tip' => '已付款',
            'handle' => "<span>已付款</span>",
        ];
    }
    if ($order_status == OS_CONFIRMED && $shipping_status == SS_PREPARING) {
        $result = [
            'status' => 3,//订单已确认，已付款，已开票
            'content' => '您的订单商家已开票。',
            'tip' => '待发货',
            'handle' => "<span>已付款</span>",
        ];
    }
    if ($order_status == OS_CONFIRMED && $shipping_status == SS_SHIPPED_PART) {
        $result = [
            'status' => 4,//订单已确认，已付款，已拣货
            'content' => '您的订单正在已拣货，请您耐心等待。',
            'tip' => '已拣货',
            'handle' => "<span>已付款</span>",
        ];
    }
    if ($order_status == OS_CONFIRMED && $shipping_status == SS_SHIPPED_ING) {
        $result = [
            'status' => 5,//订单已确认，已付款，已出库
            'content' => '您的订单现已出库。',
            'tip' => '已出库',
            'handle' => "<span>已付款</span>",
        ];
    }
    if ($order_status == OS_CONFIRMED && $shipping_status == SS_SHIPPED) {
        $result = [
            'status' => 6,//订单已确认，已付款，已发货
            'content' => '您的订单已发货。',
            'tip' => '已发货',
            'handle' => "<a href='" . route('user.orderInfo', ['id' => $order_id]) . "'>确认收货</a>",
        ];
    }
    if ($order_status == OS_CONFIRMED && $shipping_status == SS_RECEIVED) {
        $result = [
            'status' => 7,//订单已确认，已付款，已完成
            'content' => "<font color='red'>您的订单已送达成功！已完成。</font>",
            'tip' => "已完成",
            'handle' => "<span>已完成</span>",
        ];
    }
    if ($order_status == OS_CANCELED && $pay_status == PS_UNPAYED) {
        $result = [
            'status' => 8,//订单已取消，未付款，未发货
            'content' => "<font color='red'>您的订单已取消。</font>",
            'tip' => "已取消",
            'handle' => "<span style='color:red'>已取消</span>",
        ];
    }
    if ($name == '') {
        return $result;
    } else {
        return $result[$name];
    }
}

/*
 * 再次购买
 * @ids 要购买的商品id集合
 */
function orderBuy($ids, $user)
{
    $goods = Goods::whereIn('goods_id', $ids)
        ->select('goods_id', 'sales_volume', 'goods_name', 'goods_name_style', 'market_price', 'is_new', 'is_best', 'is_hot', 'shop_price',
            'is_zx', 'promote_price', 'goods_type', 'promote_start_date', 'promote_end_date', 'xg_type', 'xg_start_date', 'xg_end_date', 'is_promote',
            'ls_gg', 'ls_ggg', 'goods_brief', 'goods_number', 'goods_thumb', 'goods_img', 'ls_ranks', 'ls_regions', 'ls_bz', 'ls_sc', 'goods_sn',
            'goods_desc', 'is_pz', 'is_xkh_tj', 'is_kxpz', 'ls_buy_user_id', 'xq',
            'zyzk', 'is_on_sale', 'is_delete', 'is_alone_sale', 'show_area', 'cat_ids')
        ->get();
    //dd($goods);
    $messages = '';//失败提示
    $insert_cart = [];//批量插入的数据
    $user_rank_o = $user->user_rank;
    if ($user_rank_o == 6 || $user_rank_o == 7) $user_rank_o = 1;
    foreach ($goods as $v) {
        $msg = '';
        //2015-09-18 如果限购,获取限购标识
        $v->isXg = isXg($v->xg_type, $v->xg_start_date, $v->xg_end_date);
        //是否促销
        $v->isCx = isCx($v->is_promote, $v->promote_start_date, $v->promote_end_date);
        /* 2015-7-9 在某个时间段内换购 */
        //$v->is_hg = isHg($v->goods->is_change,$v->goods->change_start_date,$v->goods->change_end_date,$v->goods->change_goods_id,$user->user_rank);
        $memberPrice = userPrice($v->member_price->where('user_rank', $user->user_rank));
        //print_r($memberPrice);die;
//            if($v->goods_id==187){
//                llPrint($v,2);
//            }
        $cxPrice = 0;//促销价
        $isYl = true;
        if ($v->isCx && ($user->user_rank == 2 || $user->user_rank == 5)) {//终端才能参加促销
            $cxPrice = $v->promote_price > 0 ? $v->promote_price : 0;//促销价
            $result = xgYl($v->xg_type, $v->xg_start_date, $v->xg_end_date, $v->goods_id, $v->ls_ggg, $user->user_id);
            if ($result['isYl'] == false) {//没有余量
                $v->isXg = 0;
                $v->isCx = 0;
                $cxPrice = 0;
            } else {
                $v->yl = $result['yl'];
            }
        }
        $kxpzPrice = kxpzPrice($v->goods_id, $v->is_kxpz);//控销价
        $v->shop_price = goodsPrice($v->shop_price, $memberPrice, $cxPrice, $kxpzPrice, $isYl);
        //限制条件
        if (strpos($v->show_area, '4') !== false && $user->ls_mzy == 1) {
            $msg = $v->goods_name . ',';
        }

        if (strpos($v->cat_ids, '180') !== false && ($user->mhj_number == 0)) {
            $msg = $v->goods_name . ',';
        }
        // 2015-5-12 诊所不能购买食品
        if (strpos($v->cat_ids, '398') !== false && $user->user_rank == 5) {
            $msg = $v->goods_name . ',';
        }

        $ls_buy_user_id = strpos($v->ls_buy_user_id, '.' . $user->user_id . '.');
        if ($ls_buy_user_id === false) {
            //判断该商品是否对会员等级限购
            $ls_ranks = explode(',', $v->ls_ranks);
            if (!empty($v->ls_ranks) && in_array($user->user_rank, $ls_ranks) !== false) {
                $msg = $v->goods_name . ',';
            }
            //判断该商品是否对地区限购
            if (!empty($v->ls_regions)) {
                $ls_country = strpos($v->ls_regions, '.' . $user->country . '.');
                $ls_province = strpos($v->ls_regions, '.' . $user->province . '.');
                $ls_city = strpos($v->ls_regions, '.' . $user->city . '.');
                $ls_district = strpos($v->ls_regions, '.' . $user->district . '.');
                if ($ls_country !== false || $ls_province !== false || $ls_city !== false || $ls_district !== false) {
                    $msg = $v->goods_name . ',';
                }
            }
            //判断商品是否对医药公司限购
            if ((!empty($v->yy_regions) || !empty($v->yy_user_ids)) && $user_rank_o == 1) {
                $ls_country = strpos($v->yy_regions, '.' . $user->country . '.');
                $ls_province = strpos($v->yy_regions, '.' . $user->province . '.');
                $ls_city = strpos($v->yy_regions, '.' . $user->city . '.');
                $ls_district = strpos($v->yy_regions, '.' . $user->district . '.');
                $ls_user = strpos($v->yy_user_ids, '.' . $user->user_id . '.');
                if ($ls_country !== false || $ls_province !== false || $ls_city !== false || $ls_district !== false || $ls_user !== false) {
                    $msg = $v->goods_name . ',';
                }
            }
            //判断商品是否对终端限购
            if ((!empty($v->zs_regions) || !empty($v->zs_user_ids)) && $user_rank_o != 1) {
                $ls_country = strpos($v->zs_regions, '.' . $user->country . '.');
                $ls_province = strpos($v->zs_regions, '.' . $user->province . '.');
                $ls_city = strpos($v->zs_regions, '.' . $user->city . '.');
                $ls_district = strpos($v->zs_regions, '.' . $user->district . '.');
                $ls_user = strpos($v->zs_user_ids, '.' . $user->user_id . '.');
                if ($ls_country !== false || $ls_province !== false || $ls_city !== false || $ls_district !== false || $ls_user !== false) {
                    $msg = $v->goods_name . ',';
                }
            }
        }
        //判断商品库存
        $zbz = $v->goods_attr->where('attr_id', 211)->first();
        /*
        * 判断商品最低购买量
        *
        */
        $num = 1;//最低够买1个
        if ($v->ls_gg != 0) {//最低购买量存在
            $num = $v->ls_gg;
        } elseif ($zbz) {//中包装存在
            $num = $zbz->attr_value;
        }
        if ($num > $v->goods_number) {
            $msg = $v->goods_name . ',';
        }
        if ($v->goods_number == 0) {//如果商品没有库存
            $msg = $v->goods_name . ',';
        } elseif ($v->is_on_sale == 0) {//商品已下架
            $msg = $v->goods_name . ',';
        } elseif ($v->is_delete == 1) {//商品已删除
            $msg = $v->goods_name . ',';
        } elseif ($v->is_alone_sale == 0) {//商品不能单独销售
            $msg = $v->goods_name . ',';
        }
        if ($v->yl && $v->goods_number > $v->yl) {
            $msg = $v->goods_name . ',';
        }

        if (empty($msg)) {
            $cart = Cart::where('user_id', $user->user_id)->where('goods_id', $v->goods_id)->first();
            if (empty($cart)) {//购物车中不存在
                $insert_cart[] = [
                    'user_id' => $user->user_id,
                    'goods_id' => $v->goods_id,
                    'goods_sn' => $v->goods_sn,
                    'goods_name' => $v->goods_name,
                    'goods_price' => $v->shop_price,
                    'is_real' => !isset($v->is_real) ? '' : $v->is_real,
                    'is_gift' => 0,
                    'is_shipping' => !isset($v->is_shipping) ? '' : $v->is_shipping,
                    'ls_gg' => $v->ls_gg,
                    'ls_bz' => $v->ls_bz,
                    'suppliers_id' => !isset($v->suppliers_id) ? '' : $v->suppliers_id,
                    'goods_number' => $num,
                    'extension_code' => time(),
                ];
            }
        }
        $messages .= $msg;
    }
    if (empty($messages)) {
        $messages = '加入购物车成功';
    } elseif (empty($insert_cart)) {
        $messages = '加入购物车失败';
    } else {
        $messages = rtrim($messages, ',');
        $messages .= '购买失败';
    }
    return [
        'insert_cart' => $insert_cart,
        'messages' => $messages,
    ];
}