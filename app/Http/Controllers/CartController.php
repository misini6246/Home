<?php

namespace App\Http\Controllers;

use App\Ad;
use App\AdminLog;
use App\Cart;
use App\CollectGoods;
use App\Goods;
use App\Http\Controllers\Huodong\Action\HdcxController;
use App\Models\CzMoney;
use App\Models\HongbaoMoney;
use App\Models\JfMoney;
use App\Models\TjmOrder;
use App\Models\UserLevel;
use App\Models\UserTjm;
use App\Models\Yhq;
use App\OnlinePay;
use App\OrderGoods;
use App\OrderInfo;
use App\PayLog;
use App\Payment;
use App\Region;
use App\Services\MiaoshaService;
use App\Services\OrderService;
use App\Shipping;
use App\UserAddress;
use App\UserJnmj;
use App\YouHuiQ;
use App\ZqSy;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Jai\Contact\Http\Controllers\pay\upop;
use SoapClient;

class CartController extends Controller
{
    /**
     * 购物车需要的一些公共数据
     * 订单金额(order_amount) = 商品总金额(goods_amount)+运费(shipping_fee)-使用余额('surplus')
     * -优惠金额(zyzk)-折扣金额(discount)-充值余额(jnmj)-优惠券(pack_fee)-支付金额(money_paid)
     * goods_amount = real_price*goods_number
     * shipping_fee:宅急送12,其他没有
     * surplus:使用了jnmj和含麻黄碱的情况下不能使用余额,其他情况都可以
     * zyzk:终端会员享有优惠金额,其他会员优惠金额为零
     * discount:折扣金额不能和优惠券同时存在
     * jnmj:充值余额不能使用余额
     * pack_fee:优惠券不能和折扣金额同时存在,优惠券有使用条件
     */
    private $order = [
        'order_amount' => 0,
        'goods_amount' => 0,
        'ms_amount' => 0,
        'shipping_fee' => 0,
        'surplus' => 0,
        'zyzk' => 0,
        'zyzk_mhj' => 0,
        'zyzk_sy' => 0,
        'discount' => 0,
        'extension_code' => 1,//折扣比例
        'jnmj' => 0,
        'pack_fee' => 0,
        'jf_money' => 0,
        'cz_money' => 0,
        'hongbao_money' => 0,
        'zj_type' => 0,//1 立减1111,2 半价,3 免单
        'new_yhq' => [],//消费送优惠券
        'money_paid' => 0,
        'yhq_ids' => [],
        'goods_amount_mhj' => 0,//麻黄碱商品金额
        'goods_amount_sy' => 0,//尚医商品金额
        'jp_amount' => 0,//精品积分
        'jp_amount_mhj' => 0,//精品积分(麻黄碱精品)
        'sign_building' => '',
        'sign_building_mhj' => '',
        'jehg_amount' => 0,//金额换购
        'zy_amount' => 0,//优惠券-中药
        'fzy_amount' => 0,//优惠券-非中药
        'ty_amount' => 0,//优惠券-通用
        'tj_amount' => 0,//优惠券-通用
        'manjian_amount' => 0,//满减金额
        'yhq_list' => [],//优惠券列表
        'is_zy' => 0,//是否换购订单 3为换购
        'hg_goods' => [],//换购商品
        'hg_type' => 0,//换购类型 2金额 1是商品
        'is_can_zq' => true,//是否可以使用账期
        'is_can_use_jnmj' => false,//是否可以使用充值余额
        'is_no_tj' => true,//是否含有特价
        'is_no_mhj' => true,//是否含有麻黄碱
        'is_no_sy' => true,//是否含有尚医
        'is_no_hy' => true,//是否含有哈药商品
        'is_no_zyzk' => true,//是否含有优惠商品
        //20170901活动
        'relations_count' => 0,
        'relations_number' => [],
        'relations_arr' => [23779, 23781],
        'czb' => [22207, 12270, 22080, 22079, 22078, 22077],
        'yzy' => [22080, 22079, 22078, 22077],
        'has_czb' => 0,
        'has_ys' => 0,
        'gcp_num' => 0,
    ];
    private $user;

    private $user_jnmj;

    private $assign;

    private $hdcx;

    private $ms;

    private $tags;

    protected $is_hd = 0;

    protected $miaoshaService;

    protected $orderService;

    /*
     * 中间件
     */
    public function __construct(HdcxController $hdcx, MiaoshaService $miaoshaService, OrderService $orderService)
    {
        $this->middleware('jiesuan', ['only' => 'jiesuan']);//结算验证 是否有收货地址
        //$this->middleware('cartNum', ['only' => ['jiesuan', 'order']]);//结算验证 商品数量是否满两个
        $this->user = auth()->user()->is_new_user();
        $this->user_jnmj = UserJnmj::where('user_id', $this->user->user_id)->first();
        $now = time();
        if ($this->user->is_zq == 1 && $this->user->zq_start_date <= $now && $this->user->zq_end_date >= $now) {//合同时效内
            $this->order['is_can_zq'] = true;//可以使用账期
        } else {
            $this->order['is_can_zq'] = false;//不能使用
        }
//        if (!in_array($this->user->user_id, [2602, 6223, 18986, 30650, 2246, 21489])) {
//            $this->order['is_can_zq'] = false;//不能使用
//        }
//        $this->order['is_can_zq'] = false;
        $this->assign = [];
        $this->hdcx = $hdcx;
        $this->ms = new MiaoShaController();
        $this->tags = $this->ms->get_ms_tags();
        $this->is_hd();
        $this->miaoshaService = $miaoshaService;
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
        //为您推荐
        $wntj = Goods::rqdp('is_wntj', 10, -4);
        $cart = Cart::get_cart_goods_l($this->user);
        $total = array();
        $this->order['jp_amount'] = 0;
        $this->order['goods_amount'] = 0;
        $orderstr = "";
        $delId = [];
        $tip_info = [];
        $cache_cart = [];//缓存购物车
        $up_num_arr = [];
        $up_price_arr = [];
        $goods_ids = [];

        /**
         * 获取每日秒杀
         */
        $mrms = $this->miaoshaService->getCacheCartGoodsList();
        $mrmsIds = $mrms->lists('goods_id')->toArray();

        $wkc_goods = [];
        foreach ($cart as $k => $v) {
			
            $v->is_checked = 1;
            $v->goods = Goods::area_xg($v->goods, $this->user);
            $v->is_can_change = 1;
            if (in_array($v->goods->goods_id, $mrmsIds)) {
				if ($this->user->user_id == 1154){
            dd(111);
        }
                unset($cart[$k]);
            } elseif ($v->goods->is_can_buy == 0) {
				if ($this->user->user_id == 1154){
            dd(222);
        }
                $v->message = $v->goods->goods_name . "商品限购";
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);
            } elseif ($v->goods->xg_num == 0 && $v->goods->ls_ggg > 0 && $v->goods->is_xg == 2) {
                //商品有限购 而且商品剩余限购数量为零 而且商品没有在搞特价
				if ($this->user->user_id == 1154){
            dd(333);
        }
                $v->message = $v->goods->goods_name . "商品数量限购";
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);
            } elseif ($v->goods->real_price == 0) {//如果商品没有库存
			if ($this->user->user_id == 1154){
            dd(444);
        }
                $v->message = $v->goods->goods_name . "价格正在定制中";
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);
            } elseif ($v->goods->goods_number == 0) {//如果商品没有库存
                $v->goods_number = 0;
                //$v->message      = $v->goods->goods_name . trans('cart.kcbz');
                //$delId[] = $v->rec_id;
                $v->is_checked = 0;
                $v->is_can_change = 0;
                //$tip_info[]       = $v;
                $wkc_goods[] = $v;
                unset($cart[$k]);
            } elseif ($v->goods->is_on_sale == 0) {//商品已下架
                $v->message = $v->goods->goods_name . trans('cart.yxj');
                //$delId[] = $v->rec_id;
                $tip_info[] = $v;
                $v->is_checked = 0;
                $v->is_can_change = 0;
                unset($cart[$k]);
                $wkc_goods[] = $v;
            } elseif ($v->goods->is_delete == 1) {//商品已删除
                $v->message = $v->goods->goods_name . trans('cart.ysc');
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);;
            } elseif ($v->goods->is_alone_sale == 0) {//商品不能单独销售
                $v->message = $v->goods->goods_name . trans('cart.bnddxs');
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);;
            }
//            elseif($v->goods->hy_price>0&&$this->user->hymsy==0){//非哈药会员不能购买哈药
//
//                $delId[] = $v->rec_id;
//
//                unset($cart[$k]);;
//            }
            elseif (strpos($v->goods->cat_ids, '180') !== false && $this->user->mhj_number == 0) {//麻黄碱
                $v->message = $v->goods->goods_name . trans('cart.mhj');
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);;
            } else {
                $up_price = [];
                $up_num = [];
                $zbz = isset($v->goods->zbz) ? $v->goods->zbz : 1;
                if ($zbz == 0) {
                    $zbz = 1;
                }
                $jzl = isset($v->goods->jzl) ? intval($v->goods->jzl) : 0;
                $old_num = $v->goods_number;
                $result = final_num($v->goods->xg_num, $jzl, $zbz, $v->goods->goods_number, $old_num);
                $v->goods_number = $result['goods_number'];
                //$v->goods_number = Cart::cyn_num($v,$this->user,$v->goods_number);


                $orderstr .= $v->rec_id . '_';
                if ($v->goods->real_price != $v->goods_price && $v->product_id == $v->goods->product_id) {
                    $up_price['rec_id'] = $v->rec_id;
                    $up_price['goods_price'] = $v->goods->real_price;
                }

                if ($old_num != $v->goods_number && $v->goods_number > 0) {
                    $up_num['rec_id'] = $v->rec_id;
                    $up_num['goods_number'] = $v->goods_number;
                }
                if ($v->goods_number <= 0) {
                    $v->goods_number = 0;
                    $v->message = $v->goods->goods_name . trans('cart.kcbz');
                    //$delId[] = $v->rec_id;
                    $v->is_checked = 0;
                    $v->is_can_change = 0;
                    $tip_info[] = $v;
                    unset($cart[$k]);
                    $wkc_goods[] = $v;
                }
                $cache_cart[] = $v->rec_id;
                //精品
                if (strpos($v->goods->show_area, '2') !== false) {
                    $this->order['jp_amount'] += $v->goods->real_price * $v->goods_number;
                    $v->goods->is_jp = 1;
                }

                if (!empty($up_price)) {

                    $up_price_arr[] = $up_price;
                }
                if (!empty($up_num)) {

                    $up_num_arr[] = $up_num;
                }
                if (isset($goods_ids[$v->goods->goods_id . '_' . $v->goods->product_id])) {
                    $delId[] = $v->rec_id;
                    unset($cart[$k]);;
                } else {
                    if ($v->is_gift == 0) {
                        $goods_ids[$v->goods->goods_id . '_' . $v->goods->product_id] = 1;
                    }
                    $this->order['goods_amount'] += $v->goods->real_price * $v->goods_number;
                    foreach ($v->child as $child) {
                        $this->order['goods_amount'] += $child->goods_price * $child->goods_number;
                    }
                }
            }
        }

        if (count($wkc_goods) > 0) {
            foreach ($wkc_goods as $v) {
                $cart[] = $v;
            }
        }

        foreach ($mrms as $v) {
            $cart->push($v);
            $this->order['goods_amount'] += $v->goods_price * $v->goods_number;
            $cache_cart[] = $v->rec_id;
        }

        /**
         * 获取秒杀商品
         */
        $ms_goods = $this->ms->get_cart_goods();
        if (!empty($ms_goods)) {
            foreach ($ms_goods as $k => $v) {
                if (isset($goods_ids[$v->goods->goods_id . '_' . $v->goods->product_id])) {
                    foreach ($cart as $key => $val) {
                        if ($val->goods_id == $v->goods->goods_id) {
                            foreach ($cache_cart as $k1 => $value) {
                                if ($value == $val->rec_id) {
                                    unset($cache_cart[$k1]);
                                }
                            }
                            unset($cart[$key]);
                            $this->order['goods_amount'] -= $val->goods->real_price * $val->goods_number;
                            $this->order['goods_amount'] += $v->goods_price * $v->goods_number;
                        }
                    }
                } else {
                    $goods_ids[$v->goods->goods_id . '_' . $v->goods->product_id] = 1;
                    $this->order['goods_amount'] += $v->goods->real_price * $v->goods_number;
                }
                $cart->prepend($v);
                $cache_cart[] = $v->goods_id * (-1);
            }
        }
        if (!empty($delId)) {
            Cart::destroy($delId);
            Cache::tags([$this->user->user_id, 'cart'])->decrement('num', count($delId));
        }
        if (!empty($up_price_arr)) {

            Goods::updateBatch('ecs_cart', $up_price_arr);
        }
        if (!empty($up_num_arr)) {

            Goods::updateBatch('ecs_cart', $up_num_arr);
        }

        Cache::tags([$this->user->user_id, 'cart'])->put('cart_list', $cache_cart, 8 * 60);
        if ($this->user->province == 26 && $this->user->is_zhongduan == 1) {
            $userLevel = UserLevel::find($this->user->user_id);
            if ($userLevel) {
                $this->assign['month_amount'] = $userLevel->month_amount;
            } else {
                $this->assign['month_amount'] = 0;
            }
        }
        $total['jp_total_amount'] = sprintf('%.2f', $this->order['jp_amount']);
        $total['shopping_money'] = sprintf('%.2f', $this->order['goods_amount']);
        $this->assign['page_title'] = trans('common.cart') . '-';
        $this->assign['goods_list'] = $cart;
        $this->assign['tip_info'] = $tip_info;
        $this->assign['total'] = $total;
        $this->assign['wntj'] = $wntj;
        $this->assign['cartStep'] = "
        <li><img src='" . asset('images/cart_03.png') . "'/></li>
        <li><img src='" . asset('images/cart_04.png') . "'/></li>
        <li><img src='" . asset('images/cart_05.png') . "'/></li>
        ";
        return view('cart.index')->with($this->assign);
    }

    /**
     * @param Request $request
     * @return $this
     * 结算
     * 活动整理
     * 1.秒杀活动
     * 2.换购活动
     * 3.折扣活动
     * 4.账期(长期)
     * 5.充值余额(长期)
     * 6.精品专区(长期)
     * 优先级 秒杀活动>换购活动>充值余额>账期
     */
    public function jiesuan()
    {

        check_hdfk($this->user->user_id);
        $this->check_zzsx();
        /**
         * 验证账期是否逾期
         */
        $check_zq = $this->check_zq();
        if ($check_zq['error'] == 1) {
            return view('message')->with(messageSys($check_zq['msg'], route('cart.index'), [
                [
                    'url' => route('cart.index'),
                    'info' => trans('common.backToCart'),
                ],
            ]));
        }

        $addressId = $this->user->address_id;
        $rec_ids = Cache::tags([$this->user->user_id, 'cart'])->get('cart_list');
        $goods = Cart::get_cart_goods_l($this->user, $rec_ids);
        if (!$rec_ids) {
            return redirect()->route('cart.index');
        }
        $check_ids = Ad::check_ids();
        $now = time();
        $cs_arr = cs_arr();
        if (in_array($this->user->user_id, $cs_arr)) {
            $now = cs_time($now);
        }
        $yhq_tip = '此订单可参与优惠券金额';
        foreach ($goods as $k => $v) {
            if ($v->goods_id == 22073) {
                $this->check_gcp($v);
            }
            $v->goods->real_price = Cart::diff_price($v, $v->goods_number, $v->goods->real_price, $this->user);
            $v->subtotal = $v->goods->real_price * $v->goods_number;
            $v->goods = Goods::area_xg($v->goods, $this->user);//检查是否区域限购

            $message = Goods::check_cart($v->goods, $this->user);//检查各种限制条件
            if ($message['error'] == 1) {
                return view('message')->with(messageSys('(' . $v->goods->goods_name . ')' . $message['message'], route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => trans('common.backToCart'),
                    ],
                ]));
            }

            if ($v->goods_number > $v->goods->goods_number) {
                return view('message')->with(messageSys($v->goods->goods_name . '库存不足', route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => trans('common.backToCart'),
                    ],
                ]));
            }
            if ($v->goods_number > $v->goods->xg_num && $v->goods->xg_num > 0) {//超出限购数量
                return view('message')->with(messageSys($v->goods->goods_name . '超出限购数量', route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => trans('common.backToCart'),
                    ],
                ]));
            }

            /**
             * 需要统计的数据
             * is_no_tj is_no_mhj
             * jp_amount zyzk zyzk_mhj goods_amount_mhj
             */

            if ($v->goods->is_mhj == 1) {//麻黄碱商品
                $this->order['is_no_mhj'] = false;//含麻黄碱
                $this->order['goods_amount_mhj'] += $v->subtotal;
                if (strpos($v->goods->goods_name, '甘草片') !== false) {
                    $this->order['gcp_num'] += $v->goods_number;
                }
            } elseif ($v->goods->is_zyyp == 2) {//尚医商品
                $this->order['is_no_sy'] = false;//含尚医
                $this->order['goods_amount_sy'] += $v->subtotal;
            }

            if ($v->goods->is_cx == 1) {//特价
                $this->order['is_no_tj'] = false;//含特价
                if (!in_array($v->goods->goods_id, $check_ids)) {
                    $this->order['is_can_zq'] = false;
                }
            }

//            if(strpos($v->goods->product_name,'哈药')!==false||$v->goods->hy_price>0){//哈药
//                $this->order['is_no_hy'] = false;//含哈药
//                $v->is_can_zk = 0;
//            }

            if ($v->goods->goods_id == 3048) {//哈药
                $this->order['is_no_hy'] = false;//含哈药
            }

            if ($v->goods->is_jp == 1) {//精品
                $this->order['jp_amount'] += $v->subtotal;
            }

            if ($v->goods->zyyp == 1) {//中药饮片
                $this->order['zyyp_amount'] += $v->subtotal;
            }

            if ($this->user->is_zhongduan == 1) {//终端用户
                $v->goods->zyzk = Goods::check_zyzk($v->goods, $this->user);
                $v->goods->zyzk = $this->diff_zyzk($v->goods->zyzk, $v->goods_id, $v->goods_number);
                $this->order['zyzk'] += $v->goods->zyzk * $v->goods_number;
                if ($v->goods->is_mhj == 1) {
                    $this->order['zyzk_mhj'] += $v->goods->zyzk * $v->goods_number;
                } elseif ($v->goods->is_zyyp == 2) {
                    $this->order['zyzk_sy'] += $v->goods->zyzk * $v->goods_number;
                }
            }

            if ($v->goods->zyzk > 0) {//优惠金额商品
                $this->order['is_no_zyzk'] = false;
            }
            // $v->goods->is_cx == 0 &&
            if ($v->goods->is_mhj == 0 && $v->goods->is_zyyp != 2 && !in_array($v->goods_id, $this->order['czb'])) {// 非麻黄碱 非尚医
                $this->order['ty_amount'] += ($v->goods->real_price - $v->goods->zyzk) * $v->goods_number;
                $this->order['manjian_amount'] = $this->order['ty_amount'];
                if ($v->goods->is_zyyp == 1) {
                    $this->order['zy_amount'] += ($v->goods->real_price - $v->goods->zyzk) * $v->goods_number;
                } else {
                    $this->order['fzy_amount'] += ($v->goods->real_price - $v->goods->zyzk) * $v->goods_number;
                }
            }

            $this->order['goods_amount'] += $v->goods->real_price * $v->goods_number;
            foreach ($v->child as $child) {
                $this->order['goods_amount'] += $child->goods_price * $child->goods_number;
            }
            if (in_array($v->goods_id, $this->order['relations_arr'])) {
                $this->order['relations_count']++;
                $this->order['relations_number'][$v->goods_id] = $v->goods_number;
            }

            if (in_array($v->goods_id, $this->order['czb'])) {
                $this->order['has_czb'] = 1;
                $this->order['is_can_use_jnmj'] = false;
                $this->order['is_can_zq'] = false;
                if (in_array($v->goods_id, $this->order['yzy'])) {
                    $this->order['has_czb'] = 2;
                }
            }
        }

        $mrms = $this->miaoshaService->getCacheCartGoodsList($rec_ids);
        foreach ($mrms as $v) {
            $goods->push($v);
            $this->order['goods_amount'] += $v->goods_price * $v->goods_number;
        }

        //$goods = $this->song_zp($goods);
        /**
         * 获取秒杀商品
         */
        $ms_goods = $this->ms->get_cart_goods($rec_ids, false);
        if (!empty($ms_goods)) {
            $this->order['ms_amount'] = $ms_goods->goods_amount;
            if ($this->order['ms_amount'] > 0) {
                $this->order['is_can_use_jnmj'] = false;
                $this->order['is_can_zq'] = false;
            }
            $this->ys_check($goods, $ms_goods);
            foreach ($ms_goods as $v) {
                if ($v->goods->is_mhj == 1) {//麻黄碱商品
                    $this->order['is_no_mhj'] = false;//含麻黄碱
                    $this->order['goods_amount_mhj'] += $v->subtotal;
                    if (strpos($v->goods->goods_name, '甘草片') !== false) {
                        $this->order['gcp_num'] += $v->goods_number;
                    }
                }
                $goods[] = $v;
            }
        }

        $this->cart_num();
        $this->order['goods_amount'] = $this->order['goods_amount'] + $this->order['ms_amount'];
        $tsbz_c = $this->hdcx->tsbz_c($goods, $this->order, $this->user);
        $this->order = $tsbz_c['order'];
        $goods = $tsbz_c['goods'];
        $this->order_amount();
        //限购金额
//        if($this->user->user_id == 58){
//            dd(formated_price(shopConfig('min_goods_amount')[0]));
//        }
            if ($this->is_hd == 0) {
                if ($this->order['goods_amount'] <  shopConfig('min_goods_amount') && $this->order['has_ys'] == 0) {
                    return view('message')->with(messageSys(trans('cart.minMoney') . ' ' . formated_price(shopConfig('min_goods_amount')) . '，' . trans('cart.cannot') . '。', route('cart.index'), [
                        [
                            'url' => route('cart.index'),
                            'info' => trans('common.backToCart'),
                        ],
                    ]));
                }
            }


        //收货地址
        $address = UserAddress::where(function ($query) use ($addressId) {
            $query->where('user_id', $this->user->user_id);
            if ($addressId > 0) {
                $query->where('address_id', $addressId);
            }
        })->first();

        if (!$address) {
            $address = UserAddress::where(function ($query) use ($addressId) {
                $query->where('user_id', $this->user->user_id);
            })->first();
        }

        if (!$address) {
            return redirect()->route('address.edit');
        } else {
            $this->user->address_id = $address->address_id;
            $this->user->save();
        }
        //dd($address);
        $province = Cache::tags(['shop', 'region'])->remember(1, 8 * 60, function () {
            return Region::where('parent_id', 1)->get();
        })->find($address->province);
        $city = Cache::tags(['shop', 'region'])->remember($address->province, 8 * 60, function () use ($address) {
            return Region::where('parent_id', $address->province)->get();
        })->find($address->city);
        $district = Cache::tags(['shop', 'region'])->remember($address->city, 8 * 60, function () use ($address) {
            return Region::where('parent_id', $address->city)->get();
        })->find($address->district);

        if (!$province || !$city) {
            return redirect()->route('address.edit');
        }
        //运费
        $shipping_name = $this->user->shipping_name;
       // $shipping_id = $this->user->shipping_id;

      /*  if ($shipping_id != 0) {
            //查询是否是新客户首单

            $first_order = DB::table('order_info')->where('user_id', $this->user->user_id)->where('order_status', 1)->count();
            if ($first_order > 0) {
                if (strpos($this->user->shipping_name, '京东') && $this->order['goods_amount'] < 800) {
                    $this->order['shipping_fee'] = 12;
                }
            }
        }

              if($this->user->user_id = '58'){
                if ($first_order > 0) {
                    if ( $this->order['goods_amount'] < 800) {
                        $this->order['shipping_fee'] = 12;
                    }
                }
                dd($this->order);
            }
      */

        if ($shipping_name == '京东') {
            //查询是否是新客户首单
            $first_order = DB::table('order_info')->where('user_id', $this->user->user_id)->where('pay_status', 2)->where('order_status', 1)->count();
            if ($first_order > 0) {
                if ( $this->order['goods_amount'] < 800) {
                    if(time() > strtotime('2019-09-01 00:00:00') && time() < strtotime('2019-11-30 00:00:00')){
                        $this->order['shipping_fee'] = 0;
                    }else{
                        $this->order['shipping_fee'] = 12;
                    }
                }
            }
        }
        //dd(222);

//        if ($this->is_hd == 1) {
//            $this->order['shipping_fee'] = 0;//运费设为零
//        }


        //dd($this->order['shipping_fee']);
        //物流
        if ($this->user->shipping_id == 0) {
            $shipping = Shipping::shipping_list([$address->country, $address->province, $address->city, $address->district]);
            $this->assign['shipping'] = $shipping;
        }
        
        if ($v->goods->is_cx == 1) {// 非麻黄碱 非尚医
            $this->order['tj_amount'] += ($v->goods->real_price - $v->goods->zyzk) * $v->goods_number;
        }
        //支付方式
        $payment = Payment::where('enabled', 1)->select('pay_id', 'pay_name', 'pay_desc', 'is_cod')->orderBy('pay_order', 'desc')->get();

        $this->assign = $this->hdcx->jpzq($this->user, $this->order['jp_amount'], $this->assign);

        $this->order_amount();

        $this->order = $this->hdcx->zhekou($goods, $this->order, $this->user);
        $this->order_amount();
//
//        $tejiaquan = Yhq::where('user_id', $this->user->user_id)->where('status', 0)->where('order_id', 0)
//            ->where('start', '<=', $now)->where('end', '>', $now)->get();
//        //dd($tejiaquan);
//        foreach ($tejiaquan as $v) {
//
//            $tj_type = $v['tj_type'];
//            //dd($tj_type);
//        }
//        //dd($this->order);
//        $now_amount = $this->order['ty_amount'] - $this->order['tj_amount'];
//        //dd($now_amount);
//        if (!empty($tj_type) && $tj_type == 1) {
//            $yhqResult = $this->orderService->useYhq($this->user, $now_amount);
//            //dd($now_amount,11,$yhqResult);
//        } else {
//            $yhqResult = $this->orderService->useYhq($this->user, $this->order['ty_amount']);
//            // dd($this->order['ty_amount'],22,$yhqResult);
//        }
        $this->order_yhq($goods);
        $this->order['num'] = $this->order['num'] + $this->order['goods_amount_mhj'] + $this->order['zyzk'];
        $yhqResult = $this->orderService->useYhq($this->user, $this->order['goods_amount'] - $this->order['num'] ,$goods);
        $this->order['pack_fee'] = $yhqResult['pack_fee'];
        $this->order['yhq_list'] = $yhqResult['list'];
        if ($this->order['pack_fee'] > 0 || !empty($this->order['yhq_list'])) {
            $this->order['yhq_count'] = $yhqResult['yhq_count'];
            $this->assign['yhq_count'] = $yhqResult['yhq_count'];
            $this->order['discount'] = 0;
            $this->order['extension_code'] = 1;
            $this->order['is_can_use_jnmj'] = false;
            $this->assign['next_tip'] = $yhqResult['next_tip'];
        }

        $this->manjian();
        $this->check_hongbao_money();
        $this->check_jf_money();
        //$this->check_cz_money();
        //$this->order = $this->hdcx->czye($this->user, $this->user_jnmj, $this->order);
        $this->order_amount();
        $this->check_cz_money();
        $this->surplus();
        if ($this->order['goods_amount'] == $this->order['goods_amount_mhj'] || $this->order['goods_amount'] == $this->order['goods_amount_sy']) {//订单中只有麻黄碱
            $this->order['cz_money'] = 0;
            $this->order['surplus'] = 0;
            $this->order_amount();
        }
        /**
         * 活动相关结束
         */

        /**
         * 判断是否能使用账期
         */
//        if(!empty($hg_goods)||$hg_type!=0){//有换购
//            $czfl_amount = 0;
//        }
        $order_num = $this->user->orderNum;
        if ($order_num == 0) {
            $order_num = DB::table('user_status')->where('user_id', $this->user->user_id)->count();
        }
//        dd($this->order);
//        foreach ($this->order['yhq_list'] as $key => $v) {
//            if ($this->order['goods_amount'] - $this->order['tj_amount'] < $v['min_je'] and $v['tj_type'] == 1 and $now_amount > $v['min_je']) {
//                unset($this->order['yhq_list'][$key]);
//            }
//        }

        $this->assign['order_num'] = $order_num;
        $this->assign['hg_goods'] = $this->order['hg_goods'];
        $this->assign['hg_type'] = $this->order['hg_type'];
        $this->assign['surplus'] = $this->order['surplus'];
        $this->assign['order_amount'] = $this->order['order_amount'];
        $this->assign['goods_amount'] = $this->order['goods_amount'];
        $this->assign['shipping_fee'] = $this->order['shipping_fee'];
        $this->assign['page_title'] = trans('cart.orderCheck') . '-';
        $this->assign['goods_list'] = $goods;
        $this->assign['address'] = $address;
        $this->assign['province'] = $province;
        $this->assign['city'] = $city;
        $this->assign['district'] = $district;
        $this->assign['user'] = $this->user;
        $this->assign['user_jnmj'] = $this->user_jnmj;
        $this->assign['payment'] = $payment;
        $this->assign['total'] = $this->order['goods_amount'];
        $this->assign['jnmj'] = $this->order['jnmj'];
        $this->assign['sy_num'] = isset($this->order['sy_num']) ? $this->order['sy_num'] : 0;
        $this->assign['today_num'] = isset($this->order['today_num']) ? $this->order['today_num'] : 0;
        $this->assign['use_num'] = isset($this->order['use_num']) ? $this->order['use_num'] : 0;
        $this->assign['pack_fee'] = $this->order['pack_fee'];
        $this->assign['jf_money'] = $this->order['jf_money'];
        $this->assign['hongbao_money'] = $this->order['hongbao_money'];
        $this->assign['cz_money'] = $this->order['cz_money'];
//        $time = date('Ymd');
//        if($time!='20170308'&&$time!='20170315'&&$time!='20170329'){
//            $this->assign['ty_amount'] = $this->order['zy_amount'];
//        }else{
//            $this->assign['ty_amount'] = $this->order['ty_amount'];
//        }
        $this->assign['ty_amount'] = $this->order['ty_amount'];
        $this->assign['yhq_tip'] = $yhq_tip;
        $this->assign['is_no_mhj'] = $this->order['is_no_mhj'];
        $this->assign['zyzk'] = $this->order['zyzk'];
        $this->assign['jp_amount'] = $this->order['jp_amount'];
        $this->assign['shipping_fee'] = $this->order['shipping_fee'];
        $this->assign['discount'] = $this->order['discount'];
        $this->assign['is_no_mhj'] = $this->order['is_no_mhj'];
        $this->assign['yhq_list'] = $this->order['yhq_list'];
        //dd($this->order);
        $this->assign['cartStep'] = "
        <li><img src='" . asset('images/cart_03.png') . "'/></li>
        <li><img src='" . asset('images/confirm2.png') . "'/></li>
        <li><img src='" . asset('images/cart_05.png') . "'/></li>
        ";
//        if (in_array($this->user->user_id, cs_arr())) {
//            return view('cart.jiesuan')->with($this->assign);
//        } else {
//            return view('jiesuan')->with($this->assign);
//        }
        return view('cart.jiesuan')->with($this->assign);
    }

    /*
     * 插入订单
     */
    public function order(Request $request)
    {
        check_hdfk($this->user->user_id);
        $this->check_zzsx();
        /**
         * 验证账期是否逾期
         */
        $check_zq = $this->check_zq();
        if ($check_zq['error'] == 1) {
            return view('message')->with(messageSys($check_zq['msg'], route('cart.index'), [
                [
                    'url' => route('cart.index'),
                    'info' => trans('common.backToCart'),
                ],
            ]));
        }

        $address_id = $request->input('address_id', $this->user->address_id);
        $postscript = $request->input('postscript');//订单备注
        $shipping = $request->input('shipping', $this->user->shipping_id);//物流id
        $payment = $request->input('payment', '7');//支付方式
        $dzfp = intval($request->input('dzfp', $this->user->dzfp));
        if ($this->user->dzfp != $dzfp) {
            $this->user->dzfp = $dzfp;
            $this->user->save();
            $admin_log = new AdminLog();
            $admin_log->log_time = time();
            $admin_log->user_id = $this->user->user_id;
            $admin_log->log_info = '前台更改发票类型';
            $admin_log->ip_address = $request->ip();
            $admin_log->save();
        }

        /**
         * 优惠券id
         */
        $this->order['yhq_ids'] = $request->input('yhq_id', []);//优惠券
        if (!empty($this->order['yhq_ids'])) {
            foreach ($this->order['yhq_ids'] as $k => $v) {
                if (empty($v)) {
                    unset($this->order['yhq_ids'][$k]);
                }
            }
        }


        $gift = $request->input('gift', '');//礼品
        $area_name = $request->input('area_name', '');
        $kf_name = $request->input('kf_name', '');
        $rec_ids = Cache::tags([$this->user->user_id, 'cart'])->get('cart_list');
        Cache::tags([$this->user->user_id, 'cart'])->forget('cart_list');
        $goods = Cart::get_cart_goods_l($this->user, $rec_ids);
        if (!$rec_ids) {
            return view('message')->with(messageSys('不能重复提交订单', route('cart.index'), [
                [
                    'url' => route('cart.index'),
                    'info' => '返回购物车',
                ],
            ]));
        }

        $check_ids = Ad::check_ids();
        $now = time();
        $cs_arr = cs_arr();
        if (in_array($this->user->user_id, $cs_arr)) {
            $now = cs_time($now);
        }
        foreach ($goods as $k => $v) {
            if ($v->goods_id == 22073) {
                $this->check_gcp($v);
            }
            $v = $this->check_zp1($v);
            $v->goods->real_price = Cart::diff_price($v, $v->goods_number, $v->goods->real_price, $this->user);
            $v->subtotal = $v->goods->real_price * $v->goods_number;
            $v->goods = Goods::area_xg($v->goods, $this->user);//检查是否区域限购

            $message = Goods::check_cart($v->goods, $this->user);//检查各种限制条件
            if ($message['error'] == 1) {
                return view('message')->with(messageSys($message['message'], route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => trans('common.backToCart'),
                    ],
                ]));
            }

            if ($v->goods_number > $v->goods->goods_number) {
                return view('message')->with(messageSys($v->goods->goods_name . '库存不足', route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => trans('common.backToCart'),
                    ],
                ]));
            }
            if ($v->goods_number > $v->goods->xg_num && $v->goods->xg_num > 0) {//超出限购数量
                return view('message')->with(messageSys($v->goods->goods_name . '超出限购数量', route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => trans('common.backToCart'),
                    ],
                ]));
            }

            /**
             * 需要统计的数据
             * is_no_tj is_no_mhj
             * jp_amount zyzk zyzk_mhj goods_amount_mhj
             */

            if ($v->goods->is_mhj == 1) {//麻黄碱商品
                $this->order['is_no_mhj'] = false;//含麻黄碱
                $this->order['goods_amount_mhj'] += $v->subtotal;
                if (strpos($v->goods->goods_name, '甘草片') !== false) {
                    $this->order['gcp_num'] += $v->goods_number;
                }
            } elseif ($v->goods->is_zyyp == 2) {//尚医商品
                $this->order['is_no_sy'] = false;//含麻黄碱
                $this->order['goods_amount_sy'] += $v->subtotal;
            }

            if ($v->goods->is_cx == 1) {//特价
                $this->order['is_no_tj'] = false;//含特价
                if (!in_array($v->goods->goods_id, $check_ids)) {
                    $this->order['is_can_zq'] = false;
                }
            }

//            if(strpos($v->goods->product_name,'哈药')!==false||$v->goods->hy_price>0){//哈药
//                $this->order['is_no_hy'] = false;//含哈药
//                $v->is_can_zk = 0;
//            }

            if ($v->goods->goods_id == 3048) {//哈药
                $this->order['is_no_hy'] = false;//含哈药
            }

            if ($v->goods->is_jp == 1) {//精品
                $this->order['jp_amount'] += $v->subtotal;
                if ($v->goods->is_mhj == 1) {//麻黄碱
                    $this->order['jp_amount_mhj'] += $v->subtotal;
                }
            }

            if ($v->goods->zyyp == 1) {//中药饮片
                $this->order['zyyp_amount'] += $v->subtotal;
            }

            if ($this->user->is_zhongduan == 1) {//终端用户
                $v->goods->zyzk = Goods::check_zyzk($v->goods, $this->user);
                $v->goods->zyzk = $this->diff_zyzk($v->goods->zyzk, $v->goods_id, $v->goods_number);
                $this->order['zyzk'] += $v->goods->zyzk * $v->goods_number;
                if ($v->goods->is_mhj == 1) {
                    $this->order['zyzk_mhj'] += $v->goods->zyzk * $v->goods_number;
                }
            }

            if ($v->goods->zyzk > 0 && !empty($v->preferential_end_date ) && $v->preferential_end_date < time()) {//优惠金额商品
                $this->order['is_no_zyzk'] = false;
            }
            // && $v->goods->is_cx == 0
            if ($v->goods->is_mhj == 0 && $v->goods->is_zyyp != 2 && !in_array($v->goods_id, $this->order['czb'])) {//非尚医 非麻黄碱
                $this->order['ty_amount'] += ($v->goods->real_price - $v->goods->zyzk) * $v->goods_number;
                $this->order['manjian_amount'] = $this->order['ty_amount'];
                if ($v->goods->is_zyyp == 1) {
                    $this->order['zy_amount'] += ($v->goods->real_price - $v->goods->zyzk) * $v->goods_number;
                } else {
                    $this->order['fzy_amount'] += ($v->goods->real_price - $v->goods->zyzk) * $v->goods_number;
                }
            }


            $this->order['goods_amount'] += $v->goods->real_price * $v->goods_number;
            foreach ($v->child as $child) {
                $this->order['goods_amount'] += $child->goods_price * $child->goods_number;
            }
            if (in_array($v->goods_id, $this->order['relations_arr'])) {
                $this->order['relations_count']++;
                $this->order['relations_number'][$v->goods_id] = $v->goods_number;
            }

            if (in_array($v->goods_id, $this->order['czb'])) {
                $this->order['has_czb'] = 1;
                $this->order['is_can_use_jnmj'] = false;
                $this->order['is_can_zq'] = false;
                if (in_array($v->goods_id, $this->order['yzy'])) {
                    $this->order['has_czb'] = 2;
                }
            }
        }

        $mrms = $this->miaoshaService->getCacheCartGoodsList($rec_ids);
        foreach ($mrms as $v) {
            $goods->push($v);
            $this->order['goods_amount'] += $v->goods_price * $v->goods_number;
        }
        //$this->song_zp($goods);
        /**
         * 获取秒杀商品
         */
        $ms_goods = $this->ms->get_cart_goods($rec_ids, false);
        if (!empty($ms_goods)) {
            $this->order['ms_amount'] = $ms_goods->goods_amount;
            if ($this->order['ms_amount'] > 0) {
                $this->order['is_can_use_jnmj'] = false;
                $this->order['is_can_zq'] = false;
            }
            $this->ys_check($goods, $ms_goods);
            foreach ($ms_goods as $v) {
                if ($v->goods->is_mhj == 1) {//麻黄碱商品
                    $this->order['is_no_mhj'] = false;//含麻黄碱
                    $this->order['goods_amount_mhj'] += $v->subtotal;
                    if (strpos($v->goods->goods_name, '甘草片') !== false) {
                        $this->order['gcp_num'] += $v->goods_number;
                    }
                }
                $goods[] = $v;
            }
        }
        $this->cart_num($rec_ids);
        $this->order['goods_amount'] = $this->order['goods_amount'] + $this->order['ms_amount'];

        $tsbz_c = $this->hdcx->tsbz_c($goods, $this->order, $this->user);
        $this->order = $tsbz_c['order'];
        $goods = $tsbz_c['goods'];
        $this->order_amount();

        //限购金额
        if ($this->is_hd == 0) {

            if ($this->order['goods_amount'] < shopConfig('min_goods_amount') && $this->order['has_ys'] == 0) {
                return view('message')->with(messageSys(trans('cart.minMoney') . ' ' . formated_price(shopConfig('min_goods_amount')) . '，' . trans('cart.cannot') . '。', route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => trans('common.backToCart'),
                    ],
                ]));
            }
        }
        //获取收货地址
        $address = UserAddress::where('user_id', $this->user->user_id)->where('address_id', $address_id)
            ->select('consignee', 'country', 'province', 'city', 'district', 'address', 'zipcode', 'tel', 'mobile', 'email', 'best_time', 'sign_building')
            ->first();

        if (!$address) {
            return view('message')->with(messageSys('请选择收货地址', route('cart.index'), [
                [
                    'url' => route('cart.index'),
                    'info' => trans('common.backToCart'),
                ],
            ]));
        }


        if ($this->user->shipping_id == 0) {
            if ($shipping == -1) {//其他物流
                $shipping_name = $request->input('ps_wl');
            } else {
                $shipping_name = Shipping::where('enabled', 1)->where('shipping_id', $shipping)->pluck('shipping_name');
            }
        } else {
            $shipping_name = $this->user->shipping_name;
        }
        $first_order = DB::table('order_info')->where('user_id', $this->user->user_id)->where('pay_status', 2)->where('order_status', 1)->count();
        if ($first_order > 0) {
            if ( $this->user->shipping_name == '京东' && $this->order['goods_amount'] < 800) {
               // $this->order['shipping_fee'] = 12;
                if(time() > strtotime('2019-09-01 00:00:00') && time() < strtotime('2019-11-30 00:00:00')){
                    $this->order['shipping_fee'] = 0;
                }else{
                    $this->order['shipping_fee'] = 12;
                }
            }
        }
//        if ($this->is_hd == 1) {
//            $this->order['shipping_fee'] = 0;//运费设为零
//        }
        $pay_name = Payment::where('pay_id', $payment)->pluck('pay_name');
        /* 2015-01-19 组合礼品名称到标志建筑字段 */
        $old_sign_building = $address->sign_building;
        $this->order['sign_building'] = $old_sign_building;
        $this->order['sign_building_mhj'] = $old_sign_building;
        if (!empty($gift) && $gift != trans('cart.ljjf')) {

            if ($this->order['jp_amount'] == $this->order['jp_amount_mhj']) {//只含有麻黄碱精品
                $gift = str_replace(' ', '', $gift);
                $this->order['sign_building_mhj'] = trans('cart.hdlp') . ":" . $gift . " " . $address->sign_building;
                $this->order['jp_amount'] = 0;
                $this->order['jp_amount_mhj'] = 0;
            } elseif ($this->order['jp_amount_mhj'] == 0) {//不含麻黄碱精品
                $gift = str_replace(' ', '', $gift);
                $this->order['sign_building'] = trans('cart.hdlp') . ":" . $gift . " " . $address->sign_building;
                $this->order['jp_amount'] = 0;
                $this->order['jp_amount_mhj'] = 0;
            }

 
        }


        $this->order = $this->hdcx->zhekou($goods, $this->order, $this->user);
        $this->order_amount();
        $this->order_yhq($goods);
        $this->order['num'] = $this->order['num'] + $this->order['goods_amount_mhj'] + $this->order['zyzk'];
        $yhqResult = $this->orderService->useYhq($this->user, $this->order['goods_amount'] -$this->order['num'],$goods);

        $this->order['pack_fee'] = $yhqResult['pack_fee'];

        if ($this->order['pack_fee'] > 0) {
            $this->order['discount'] = 0;
            $this->order['extension_code'] = 1;
            $this->order['is_can_zq'] = false;
            $this->order['is_can_use_jnmj'] = false;
        }
        $this->manjian();
        $this->check_hongbao_money();
        $this->check_jf_money();
        //$this->order = $this->hdcx->czye($this->user, $this->user_jnmj, $this->order);


        $this->order_amount();
        $this->check_cz_money();
        $this->surplus();
        //判断赠品
        $goods = $this->check_zp($goods);
        if ($this->order['goods_amount'] == $this->order['goods_amount_mhj'] || $this->order['goods_amount'] == $this->order['goods_amount_sy']) {//订单中只有麻黄碱
            $this->order['cz_money'] = 0;
            $this->order['surplus'] = 0;
            $this->order_amount();
        }
        $bm_id = DB::table('user_bumen')->where('user_id', $this->user->user_id)->pluck('bm_id');
        $bm_id = intval($bm_id);
        $order_sn = get_order_sn($this->user->user_id);//订单编号$
        $order_info_mhj = '';
        $order_info_sy = '';
        $order_info = new OrderInfo;
        $fendan = false;//分单
        $order_info->order_sn = $order_sn;
        $order_info->user_id = $this->user->user_id;
        $order_info->msn = $this->user->msn;
        $order_info->ls_zpgly = $this->user->ls_zpgly;
        $order_info->consignee = $address->consignee;
        $order_info->country = $address->country;
        $order_info->province = $address->province;
        $order_info->city = $address->city;
        $order_info->district = $address->district;
        $order_info->address = $address->address;
        $order_info->zipcode = $address->zipcode;
        $order_info->tel = $address->tel;
        $order_info->mobile = $address->mobile;
        $order_info->email = $address->email;
        $order_info->best_time = $address->best_time;
        $order_info->sign_building = $this->order['sign_building'];
        $order_info->sign_building = $this->add_jmxx($order_info->sign_building);
        $order_info->postscript = $postscript;
        $order_info->shipping_id = $shipping;
        $order_info->pay_id = $payment;
        $order_info->pay_name = $pay_name;
        $order_info->referer = trans('common.bz');
        $order_info->add_time = time();
        $order_info->confirm_time = time();
        $order_num = $this->user->orderNum;
        if ($order_num == 0) {
            $order_num = DB::table('user_status')->where('user_id', $this->user->user_id)->count();
        }
        $tjm = $request->input('tjm');
        if (!empty($tjm)) {
            if ($order_num > 0 || $this->user->is_zhongduan == 0) {
                tips1('不符合使用推荐码的条件！', ['返回购物车' => route('cart.index')]);
            }
            $user_tjm = UserTjm::where('tjm', $tjm)->first();
            if (!$user_tjm) {
                tips1('找不到此推荐码！', ['返回购物车' => route('cart.index')]);
            }

        }
        if ($order_num == 0) {
            $order_info->is_xkh = 1;
        } else {
            $order_info->is_xkh = 0;
        }
        if ($this->order['has_czb'] > 0) {
            $order_info->mobile_pay = ($this->order['has_czb'] + 1) * -1;
        } elseif ($this->order['has_ys'] == 1) {
            $order_info->mobile_pay = -1;
        }
        $order_info->is_xkh = 0;
        $order_info->how_oos = trans('cart.how_oos');
        $order_info->goods_amount = $this->order['goods_amount'];
        $order_info->shipping_fee = $this->order['shipping_fee'];
        $order_info->surplus = $this->order['surplus'];
        $order_info->order_amount = $this->order['order_amount'];
        $order_info->jp_points = intval($this->order['jp_amount'] - $this->order['jp_amount_mhj']);
        $order_info->zyzk = $this->order['zyzk'];
        $order_info->jnmj = $this->order['jnmj'];
        $order_info->pack_fee = $this->order['pack_fee'];
        $order_info->jf_money = $this->order['jf_money'];
        $order_info->hongbao_money = $this->order['hongbao_money'];
        $order_info->cz_money = $this->order['cz_money'];
        $order_info->dzfp = $this->user->dzfp;
        $order_info->is_mhj = 0;
        $order_info->is_hmd = $this->user->is_hmd;
        $order_info->discount = $this->order['discount'];
        $order_info->is_zy = $this->order['is_zy'];
        $order_info->inv_content = is_null($this->user->question) ? '' : $this->user->question;
        $order_info->inv_payee = '';
        $order_info->pack_id = is_null($this->user->sex) ? '' : $this->user->sex;
        $order_info->is_gtkf = $this->user->is_gtkf;
        $order_info->bm_id = $bm_id;
        $order_info->is_jybg = $this->user->is_jybg;
        if ($this->user->passwd_question) {
            $order_info->card_message = $this->user->passwd_question;
        }
        /**
         * mycat
         */
        //$order_info = mycat_bc($order_info);
        if ($this->user->shipping_id == 0) {
//            if ($shipping == -1) {//其他物流
//                $shipping_name             = $request->input('ps_wl');
//                $order_info->shipping_name = $request->input('ps_wl');
//                $order_info->wl_dh         = $request->input('ps_dh');
//                $this->user->shipping_id   = -1;
//                $this->user->shipping_name = $shipping_name;
//                $this->user->wl_dh         = $order_info->wl_dh;
//                $this->user->save();
//            } else {
//                $shipping_name = Shipping::where('enabled', 1)->where('shipping_id', $shipping)->pluck('shipping_name');
//                if (empty($shipping_name)) {
//                    return view('message')->with(messageSys(trans('cart.wl'), route('cart.jiesuan'), [
//                        [
//                            'url'  => route('cart.index'),
//                            'info' => trans('common.backToCart'),
//                        ],
//                    ]));
//                }
//                if ($shipping == 13) {
//                    if (empty($kf_name)) {
//                        return view('message')->with(messageSys('请选择自提库房', route('cart.jiesuan'), [
//                            [
//                                'url'  => route('cart.index'),
//                                'info' => trans('common.backToCart'),
//                            ],
//                        ]));
//                    } else {
//                        $shipping_name .= '(' . $kf_name . ')';
//                    }
//                }
//                if ($shipping == 9) {
//                    if (empty($area_name)) {
//                        return view('message')->with(messageSys('请选择配送区域', route('cart.jiesuan'), [
//                            [
//                                'url'  => route('cart.index'),
//                                'info' => trans('common.backToCart'),
//                            ],
//                        ]));
//                    } else {
//                        $shipping_name .= $area_name;
//                    }
//                }
//                $order_info->shipping_name = $shipping_name;
//                if ($this->user->shipping_id == 0) {
//                    $this->user->shipping_id   = $shipping;
//                    $this->user->shipping_name = $shipping_name;
//                    $this->user->save();
//                }
//            }
        } else {
            $shipping_name = $this->user->shipping_name;
            $order_info->shipping_name = $this->user->shipping_name;
            $order_info->wl_dh = $this->user->wl_dh;
        }
        if ($this->order['goods_amount'] == $this->order['goods_amount_mhj']) {//订单中只有麻黄碱
            $order_info->is_mhj = 1;
            $order_info->jp_points = intval($this->order['jp_amount_mhj']);
            $this->order['is_can_zq'] = false;
            $order_info->sign_building = $this->order['sign_building_mhj'];
            $order_info->sign_building = $this->add_jmxx($order_info->sign_building);
            if ($this->user->is_zhongduan == 0 || $order_info->pay_id == 8) {
                $payment = 2;
                $order_info->pay_id = 2;
                $order_info->pay_name = '银行汇款/转帐';
            }
        } elseif ($this->order['goods_amount'] == $this->order['goods_amount_sy']) {//订单中只有尚医
            $order_info->is_mhj = 2;
            $order_info->is_zq = 0;
            $order_info->sign_building = $old_sign_building;
            $order_info->sign_building = $this->add_jmxx($order_info->sign_building);
            $payment = 2;
            $order_info->pay_id = 2;
            $order_info->pay_name = '银行汇款/转帐';
        } else {
            if ($this->order['is_no_mhj'] == false) {//含麻黄碱 要分单
                $fendan = true;
                $order_info_mhj = new OrderInfo();
                $order_info_mhj->order_sn = $order_sn . '_3';
                $order_info_mhj->user_id = $this->user->user_id;
                $order_info_mhj->msn = $this->user->msn;
                $order_info_mhj->ls_zpgly = $this->user->ls_zpgly;
                $order_info_mhj->is_admin = 0;
                $order_info_mhj->consignee = $address->consignee;
                $order_info_mhj->country = $address->country;
                $order_info_mhj->province = $address->province;
                $order_info_mhj->city = $address->city;
                $order_info_mhj->district = $address->district;
                $order_info_mhj->address = $address->address;
                $order_info_mhj->zipcode = $address->zipcode;
                $order_info_mhj->tel = $address->tel;
                $order_info_mhj->mobile = $address->mobile;
                $order_info_mhj->email = $address->email;
                $order_info_mhj->best_time = $address->best_time;
                $order_info_mhj->sign_building = $this->order['sign_building_mhj'];
                $order_info_mhj->sign_building = $this->add_jmxx($order_info_mhj->sign_building);
                $order_info_mhj->postscript = $postscript;
                $order_info_mhj->shipping_id = $shipping;
                $order_info_mhj->pay_id = $payment;
                $order_info_mhj->pay_name = $pay_name;
                if ($this->user->is_zhongduan == 0 || $order_info_mhj->pay_id == 8) {
                    $payment = 2;
                    $order_info_mhj->pay_id = 2;
                    $order_info_mhj->pay_name = '银行汇款/转帐';
                }
                $order_info_mhj->referer = trans('common.bz');
                $order_info_mhj->add_time = time();
                $order_info_mhj->confirm_time = time();
                $order_info_mhj->is_xkh = 0;
                $order_info_mhj->goods_amount = $this->order['goods_amount_mhj'];
                $order_info_mhj->shipping_fee = 0;
                $order_info_mhj->surplus = 0;
                $order_info_mhj->jf_money = 0;
                $order_info_mhj->hongbao_money = 0;
                $order_info_mhj->cz_money = 0;
                $order_info_mhj->order_amount = $this->order['order_amount_mhj'];
                $order_info_mhj->jp_points = intval($this->order['jp_amount_mhj']);
                $order_info_mhj->how_oos = trans('cart.how_oos');
                $order_info_mhj->zyzk = $this->order['zyzk_mhj'];
                $order_info_mhj->is_mhj = 1;
                $order_info_mhj->is_hmd = $this->user->is_hmd;
                $order_info_mhj->dzfp = $this->user->dzfp;
                $order_info_mhj->is_zy = $this->order['is_zy'];
                $order_info_mhj->inv_content = is_null($this->user->question) ? '' : $this->user->question;
                $order_info_mhj->inv_payee = '';
                $order_info_mhj->pack_id = is_null($this->user->sex) ? '' : $this->user->sex;
                $order_info_mhj->is_gtkf = $this->user->is_gtkf;
                $order_info_mhj->bm_id = $bm_id;
                $order_info_mhj->is_jybg = $this->user->is_jybg;
                if ($this->user->passwd_question) {
                    $order_info_mhj->card_message = $this->user->passwd_question;
                }
                /**
                 * mycat
                 */
                //$order_info_mhj = mycat_bc($order_info_mhj);

                if ($shipping == -1) {//其他物流
                    $order_info_mhj->shipping_name = $order_info->shipping_name;
                    $order_info_mhj->wl_dh = $order_info->wl_dh;

                } else {
                    $order_info_mhj->shipping_name = $order_info->shipping_name;;
                }
                //原订单 金额 做出相应改动
                $order_info->goods_amount = $order_info->goods_amount - $order_info_mhj->goods_amount;


                $order_info->order_amount = $order_info->order_amount - $order_info_mhj->order_amount;
                $order_info->zyzk = $order_info->zyzk - $order_info_mhj->zyzk;
            }
            if ($this->order['is_no_sy'] == false) {//含尚医 要分单
                $fendan = true;
                $order_info_sy = new OrderInfo();
                $order_info_sy->order_sn = $order_sn . '_2';
                $order_info_sy->user_id = $this->user->user_id;
                $order_info_sy->msn = $this->user->msn;
                $order_info_sy->ls_zpgly = $this->user->ls_zpgly;
                $order_info_sy->is_admin = 0;
                $order_info_sy->consignee = $address->consignee;
                $order_info_sy->country = $address->country;
                $order_info_sy->province = $address->province;
                $order_info_sy->city = $address->city;
                $order_info_sy->district = $address->district;
                $order_info_sy->address = $address->address;
                $order_info_sy->zipcode = $address->zipcode;
                $order_info_sy->tel = $address->tel;
                $order_info_sy->mobile = $address->mobile;
                $order_info_sy->email = $address->email;
                $order_info_sy->best_time = $address->best_time;
                $order_info_sy->sign_building = $this->order['sign_building_mhj'];
                $order_info_sy->sign_building = $this->add_jmxx($order_info_sy->sign_building);
                $order_info_sy->postscript = $postscript;
                $order_info_sy->shipping_id = $shipping;
                $order_info_sy->pay_id = 2;
                $order_info_sy->pay_name = '银行汇款/转帐';
                $order_info_sy->referer = trans('common.bz');
                $order_info_sy->add_time = time();
                $order_info_sy->confirm_time = time();
                $order_info_sy->is_xkh = 0;
                $order_info_sy->goods_amount = $this->order['goods_amount_sy'];
                $order_info_sy->shipping_fee = 0;
                $order_info_sy->surplus = 0;
                $order_info_sy->jf_money = 0;
                $order_info_sy->hongbao_money = 0;
                $order_info_sy->cz_money = 0;
                $order_info_sy->order_amount = $this->order['order_amount_sy'];
                $order_info_sy->jp_points = 0;
                $order_info_sy->how_oos = trans('cart.how_oos');
                $order_info_sy->zyzk = $this->order['zyzk_sy'];
                $order_info_sy->is_mhj = 2;
                $order_info_sy->is_hmd = $this->user->is_hmd;
                $order_info_sy->dzfp = $this->user->dzfp;
                $order_info_sy->is_zy = $this->order['is_zy'];
                $order_info_sy->inv_content = is_null($this->user->question) ? '' : $this->user->question;
                $order_info_sy->inv_payee = '';
                $order_info_sy->pack_id = is_null($this->user->sex) ? '' : $this->user->sex;
                $order_info_sy->is_zq = 0;
                $order_info_sy->is_gtkf = $this->user->is_gtkf;
                $order_info_sy->bm_id = $bm_id;
                $order_info_sy->is_jybg = $this->user->is_jybg;
                if ($this->user->passwd_question) {
                    $order_info_sy->card_message = $this->user->passwd_question;
                }
                /**
                 * mycat
                 */
                //$order_info_mhj = mycat_bc($order_info_mhj);

                if ($shipping == -1) {//其他物流
                    $order_info_sy->shipping_name = $order_info->shipping_name;
                    $order_info_sy->wl_dh = $order_info->wl_dh;

                } else {
                    $order_info_sy->shipping_name = $order_info->shipping_name;;
                }
                //原订单 金额 做出相应改动
                $order_info->goods_amount = $order_info->goods_amount - $order_info_sy->goods_amount;


                $order_info->order_amount = $order_info->order_amount - $order_info_sy->order_amount;
                $order_info->zyzk = $order_info->zyzk - $order_info_sy->zyzk;
                if ($order_info->goods_amount == 0) {//订单只有麻黄碱和尚医
                    $order_info = $order_info_sy;
                    $this->order['is_no_sy'] = true;
                    $this->order['is_can_zq'] = false;//不能使用普通账期
                }
            }
        }
        if ($this->order['is_can_zq'] == true && ($this->user->zq_je - $this->user->zq_amount) > $order_info->order_amount && $order_info->is_mhj == 0) {//能使用账期 且额度足够
            $order_info->is_zq = 1;
        } elseif ($order_info->is_mhj != 2) {
            $order_info->is_zq = 0;
        }
        $flag = DB::transaction(function () use ($order_info, $goods, $request, $order_info_mhj, $order_info_sy, $fendan, $rec_ids, $tjm, $yhqResult) {//数据库事务插入订单
            if ($order_info->jnmj > 0) {//使用充值余额支付
                $order_info->pay_name = '使用充值余额支付';
            }
            if (abs($order_info->order_amount) < 0.000001) {
                $order_info->pay_status = 2;
                $order_info->pay_time = time();
                if ($order_info->surplus > 0) {
                    $order_info->pay_name = '使用余额支付';
                }
            }
            if ($order_info->ls_zpgly == 'admin' && $order_info->is_xkh == 0) {
                $order_info->is_admin = 1;
            }
            $order_info->save();
            //dd($order_info);
            //dd($order_info,$order_info_sy);
            if ($order_info->order_id > 0) {
                if ($order_info->jnmj > 0) {//订单使用锦囊支付
                    log_jnmj_change($this->user_jnmj, 0 - $order_info->jnmj, '支付订单 ' . $order_info->order_sn);
                } elseif ($order_info->is_zq == 1) {//账期订单
                    log_zq_change($this->user, 0, $order_info->order_amount, '支付订单 ' . $order_info->order_sn);
                } elseif ($order_info->is_zq == 3) {//尚医账期订单
                    log_zq_change_sy($this->user, 0, $order_info->order_amount, '支付订单 ' . $order_info->order_sn);
                }
                $payLog = new PayLog();
                $payLog->order_amount = $order_info->order_amount;
                $payLog->order_type = 0;
                $payLog->is_paid = $order_info->pay_status == 2 ? 1 : 0;
                $order_info->payLog()->save($payLog);
                $tjm_arr[] = [
                    'tjm' => $tjm,
                    'order_id' => $order_info->order_id,
                    'is_ff' => 0,
                ];
                if ($fendan == true) {
                    if ($this->order['is_no_mhj'] == false) {//含麻黄碱
                        $order_info_mhj->save();
                        $payLog = new PayLog();
                        $payLog->order_amount = $order_info_mhj->order_amount;
                        $payLog->order_type = 0;
                        $payLog->is_paid = $order_info_mhj->pay_status == 2 ? 1 : 0;
                        $order_info_mhj->payLog()->save($payLog);
                        $tjm_arr[] = [
                            'tjm' => $tjm,
                            'order_id' => $order_info_mhj->order_id,
                            'is_ff' => 0,
                        ];
                    }
                    if ($this->order['is_no_sy'] == false) {//含尚医
                        $order_info_sy->save();
                        $payLog = new PayLog();
                        $payLog->order_amount = $order_info_sy->order_amount;
                        $payLog->order_type = 0;
                        $payLog->is_paid = $order_info_sy->pay_status == 2 ? 1 : 0;
                        $order_info_sy->payLog()->save($payLog);
                        if ($order_info_sy->is_zq == 3) {
                            log_zq_change_sy($this->user, 0, $order_info_sy->order_amount, '支付订单 ' . $order_info_sy->order_sn);
                        }
                        $tjm_arr[] = [
                            'tjm' => $tjm,
                            'order_id' => $order_info_sy->order_id,
                            'is_ff' => 0,
                        ];
                    }
                }
                $recId = array();//购物车商品记录id集合
                $a = [];
                $b = [];
                $c = [];
                foreach ($goods as $v) {
                    $recId[] = $v->rec_id;
                    $v->extension_code = 1;
                    if ($this->order['discount'] > 0 && isset($v->is_zhekou) && $v->is_zhekou == 1) {
                        $v->extension_code = $this->order['extension_code'];
                    }
                    if ($fendan == true && $v->goods->is_mhj == 1) {//分单了 麻黄碱
                        $insert_goods[] = [
                            'order_id' => $order_info_mhj->order_id,
                            'goods_id' => $v->goods->goods_id,
                            'goods_name' => $v->goods->goods_name,
                            'goods_sn' => $v->goods->goods_sn,
                            'goods_number' => $v->goods_number,
                            'goods_number_f' => $v->goods_number,
                            'market_price' => $v->goods->market_price,
                            'goods_price' => $v->goods->real_price,
                            'is_real' => 1,
                            'product_id' => isset($v->product_id) ? $v->product_id : 0,
                            'parent_id' => 0,
                            'is_gift' => 0,
                            'is_cur_p' => $v->goods->is_cx,
                            'is_jp' => $v->goods->is_jp,
                            'is_zyyp' => $v->goods->is_zyyp,
                            'xq' => $v->goods->xq,
                            'zyzk' => $v->goods->zyzk,
                            'suppliers_id' => $v->goods->suppliers_id,
                            'ckid' => $v->goods->ckid,
                            'tsbz' => $v->goods->tsbz,
                            'goods_attr' => '',
                            'extension_code' => $v->extension_code,
                        ];
                    } elseif ($fendan == true && $v->goods->is_zyyp == 2) {//分单了 尚医
                        $insert_goods[] = [
                            'order_id' => $order_info_sy->order_id,
                            'goods_id' => $v->goods->goods_id,
                            'goods_name' => $v->goods->goods_name,
                            'goods_sn' => $v->goods->goods_sn,
                            'goods_number' => $v->goods_number,
                            'goods_number_f' => $v->goods_number,
                            'market_price' => $v->goods->market_price,
                            'goods_price' => $v->goods->real_price,
                            'is_real' => 1,
                            'product_id' => isset($v->product_id) ? $v->product_id : 0,
                            'parent_id' => 0,
                            'is_gift' => 0,
                            'is_cur_p' => $v->goods->is_cx,
                            'is_jp' => $v->goods->is_jp,
                            'is_zyyp' => $v->goods->is_zyyp,
                            'xq' => $v->goods->xq,
                            'zyzk' => $v->goods->zyzk,
                            'suppliers_id' => $v->goods->suppliers_id,
                            'ckid' => $v->goods->ckid,
                            'tsbz' => $v->goods->tsbz,
                            'goods_attr' => '',
                            'extension_code' => $v->extension_code,
                        ];
                    } else {
                        $insert_goods[] = [
                            'order_id' => $order_info->order_id,
                            'goods_id' => $v->goods->goods_id,
                            'goods_name' => $v->goods->goods_name,
                            'goods_sn' => $v->goods->goods_sn,
                            'goods_number' => $v->goods_number,
                            'goods_number_f' => $v->goods_number,
                            'market_price' => $v->goods->market_price,
                            'goods_price' => $v->goods->real_price,
                            'is_real' => 1,
                            'product_id' => isset($v->product_id) ? $v->product_id : 0,
                            'parent_id' => 0,
                            'is_gift' => 0,
                            'is_cur_p' => $v->goods->is_cx,
                            'is_jp' => $v->goods->is_jp,
                            'is_zyyp' => $v->goods->is_zyyp,
                            'xq' => $v->goods->xq,
                            'zyzk' => $v->goods->zyzk,
                            'suppliers_id' => $v->goods->suppliers_id,
                            'ckid' => $v->goods->ckid,
                            'tsbz' => $v->goods->tsbz,
                            'goods_attr' => '',
                            'extension_code' => $v->extension_code,
                        ];
                        if (isset($v->child) && count($v->child) > 0) {
                            foreach ($v->child as $child) {
                                $recId[] = $child->rec_id;
                                if (isset($insert_goods[$child->zp_goods->goods_id * (-1)])) {
                                    $insert_goods[$child->zp_goods->goods_id * (-1)]['goods_number'] += $child->goods_number;
                                    $insert_goods[$child->zp_goods->goods_id * (-1)]['goods_number_f'] += $child->goods_number;
                                    if ($child->zp_goods->pivot->is_goods == 1) {
                                        foreach ($a as $k => $aa) {
                                            if ($aa['goods_id'] == $child->zp_goods->goods_id) {
                                                $a[$k]['goods_number'] -= $child->goods_number;
                                            }
                                        }
                                    } else {
                                        foreach ($b as $k => $bb) {
                                            if ($bb['goods_id'] == $child->zp_goods->goods_id) {
                                                $b[$k]['goods_number'] -= $child->goods_number;
                                            }
                                        }
                                    }
                                } else {
                                    $insert_goods[$child->zp_goods->goods_id * (-1)] = [
                                        'order_id' => $order_info->order_id,
                                        'goods_id' => $child->zp_goods->goods_id,
                                        'goods_name' => $child->zp_goods->goods_name,
                                        'goods_sn' => $child->zp_goods->goods_sn,
                                        'goods_number' => $child->goods_number,
                                        'goods_number_f' => $child->goods_number,
                                        'market_price' => $child->zp_goods->market_price,
                                        'goods_price' => $child->goods_price,
                                        'is_real' => 1,
                                        'product_id' => 0,
                                        'parent_id' => $v->goods_id,
                                        'is_gift' => 1,
                                        'is_cur_p' => 0,
                                        'is_jp' => 0,
                                        'is_zyyp' => 0,
                                        'xq' => $child->zp_goods->xq,
                                        'zyzk' => 0,
                                        'suppliers_id' => $child->zp_goods->suppliers_id,
                                        'ckid' => $child->zp_goods->ckid,
                                        'tsbz' => '',
                                        'goods_attr' => '',
                                        'extension_code' => 1,
                                    ];
                                    $child->zp_goods->goods_number = $child->zp_goods->goods_number - $child->goods_number;
                                    if ($child->zp_goods->pivot->is_goods == 1) {
                                        $a[] = [
                                            'goods_id' => $child->zp_goods->goods_id,
                                            'goods_number' => $child->zp_goods->goods_number,
                                        ];
                                    } else {
                                        $b[] = [
                                            'goods_id' => $child->zp_goods->goods_id,
                                            'goods_number' => $child->zp_goods->goods_number,
                                        ];
                                    }
                                }
                            }
                        }
                    }
                    if (strpos($v->goods->tsbz, '秒') === false && strpos($v->goods->tsbz, '享') === false && strpos($v->goods->tsbz, '预') === false) {
                        $v->goods->goods_number = $v->goods->goods_number - $v->goods_number;
                        if ($v->product_id == 0) {
                            $a[] = [
                                'goods_id' => $v->goods->goods_id,
                                'goods_number' => $v->goods->goods_number,
                            ];
                        } else {
                            $c[] = [
                                'ERPID' => $v->goods->ERPID,
                                'goods_number' => $v->goods->goods_number,
                            ];
                        }
                    }
//                    if(strpos($v->goods->tsbz,'换')!==false){
//                        HgGoods::where('rec_id',$v->hg_id)->decrement('total_number',$v->goods_number);
//                    }
                }
                //dd($insert_goods);
                Goods::updateBatch('ecs_goods', $a);
                if (count($b) > 0) {
                    Goods::updateBatch('ecs_zp_goods', $b);
                }
                if (count($c) > 0) {
                    Goods::updateBatch('ecs_spkc_tj', $c);
                }
                if (!empty($tjm)) {
                    TjmOrder::insert($tjm_arr);
                }
                Cart::whereIn('rec_id', $recId)->delete();//删除购物车
                $this->miaoshaService->setCacheCartGoodsOrdered($rec_ids);
                if ($this->order['ms_amount'] > 0) {
                    $old_ms_goods = $this->ms->get_cart_goods();
                    foreach ($old_ms_goods as $k => $v) {
                        if (in_array(0 - $v->goods_id, $rec_ids)) {//提交订单中的商品减少库存
                            unset($old_ms_goods[$k]);
                        }
                    }
                    Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forever('ms_goods', $old_ms_goods);
                }
                OrderGoods::insert($insert_goods);//插入订单商品
                $online = new OnlinePay();
                $online->update_time = time();
                $online->order_sn = $order_info->order_sn;
                $order_info->onlinePay()->save($online);
                /* 2015-6-15 为在线支付主动查询插入支付记录 */
                if ($fendan == true) {
                    if ($this->order['is_no_mhj'] == false) {//含麻黄碱
                        $online_mhj = new OnlinePay();
                        $online_mhj->update_time = time();
                        $online_mhj->order_sn = $order_info_mhj->order_sn;
                        $order_info_mhj->onlinePay()->save($online_mhj);
                    }
                    if ($this->order['is_no_sy'] == false) {//含尚医
                        $online_sy = new OnlinePay();
                        $online_sy->update_time = time();
                        $online_sy->order_sn = $order_info_sy->order_sn;
                        $order_info_sy->onlinePay()->save($online_sy);
                    }
                }
                if ($order_info->surplus > 0) {//记录余额变动
                    //log_account_change($this->user->user_id, $order_info->surplus * (-1), 0, 0, 0, trans('cart.payOrder') . ' ' . $order_info->order_sn);  //2015-7-27
                    log_account_change_type($this->user->user_id, $order_info->surplus * (-1), 0, 0, 0, trans('cart.payOrder') . ' ' . $order_info->order_sn, 0, 0, $order_info->order_id);  //2015-7-27
                }

                if ($this->order['pack_fee'] > 0) {//使用了pack_fee
                    $up_arr = [
                        'status' => 1,
                        'order_id' => $order_info->order_id,
                        'use_time' => time(),
                    ];
                    YouHuiQ::whereIn('yhq_id', $yhqResult['selected'])->update($up_arr);
                }
//                if($order_info->is_mhj==0) {
//                    if($this->order['zy_amount']<1000) {
//                        if($this->user->is_zhongduan==1&&$order_info->is_zq==0&&$order_info->jnmj==0) {//终端,非账期,非充值余额可以抽奖
//                            $old_pack_fee = $order_info->pack_fee;
//                            $result = $this->hdcx->yhq_other($this->user, $order_info,$this->order);
//                            $order_info = $result['order'];
//                            $this->order = $result['order_arr'];
//                            if ($old_pack_fee != $order_info->pack_fee) {
//                                $this->order['order_amount'] = $order_info->order_amount;
//                                $this->order['pack_fee'] = $order_info->pack_fee;
//                                if ($fendan == true) {
//                                    $this->order['order_amount'] += $order_info_mhj->order_amount;
//                                }
//                                $order_info->save();
//                            }
//                        }
//                    }else {
//
//                if($this->order['zy_amount']>=1000) {
//                    $this->order = $this->hdcx->create_yhq($order_info, $this->order, $this->user, 1);
//                }
//                    }
//                }

            } else {
                return -1;
            }
        });
        if ($flag == -1) {
            return view('message')->with(messageSys('订单购买失败', route('cart.index'), [
                [
                    'url' => route('cart.index'),
                    'info' => trans('common.backToCart'),
                ],
            ]));
        }

        @$this->toErp($order_info, $this->user);
        $order = [
            'goods_amount' => $this->order['goods_amount'],
            'zj_type' => $this->order['zj_type'],
            'zyzk' => $this->order['zyzk'],
            'discount' => $this->order['discount'],
            'order_amount' => $this->order['order_amount'],
            'surplus' => $this->order['surplus'],
            'shipping_fee' => $this->order['shipping_fee'],
            'pay_name' => $order_info->pay_name,
            'shipping_name' => $shipping_name,
            'order_sn' => $order_info->order_sn,
            'order_id' => $order_info->order_id,
            'jnmj' => $order_info->jnmj,
            'pack_fee' => $order_info->pack_fee,
            'jf_money' => $order_info->jf_money,
            'hongbao_money' => $order_info->hongbao_money,
            'cz_money' => $order_info->cz_money,
            'new_yhq' => $this->order['new_yhq'],
            'mhj_tip' => ''
        ];
        if ($order_info->is_mhj == 1) {
            $order['mhj_tip'] = '根据GSP规定，该订单只能单独转款，支持使用在线支付及转账到对公账户，并且含麻订单不能使用余额，不能使用支付宝转账。';
            if ($this->user->is_zhongduan == 0) {
                $order['mhj_tip'] = '根据GSP规定，该订单必须公对公转账，并且含麻订单不能使用余额。';
            }
        }
        if ($order_info->is_zq > 0) {
            $order['pay_name'] = '月结';
        }
        $onlinePay = '';
        if ($fendan == true) {//分单了
            if ($this->order['is_no_sy'] == false) {
                @$this->toErp($order_info_sy, $this->user);
                $order['order_sn_sy'] = $order_sn . '_2';
                $order['order_id_sy'] = $order_info_sy->order_id;
                $order['order_amount_sy'] = $order_info_sy->order_amount;
                if ($order_info_sy->is_zq == 3) {
                    $order_info_sy->pay_name = '月结';
                }
                $order['pay_name'] .= ' ' . $order_info_sy->pay_name;
            }
            if ($this->order['is_no_mhj'] == false) {
                @$this->toErp($order_info_mhj, $this->user);
                $order['order_sn_mhj'] = $order_sn . '_3';
                $order['order_id_mhj'] = $order_info_mhj->order_id;
                $order['order_amount_mhj'] = $order_info_mhj->order_amount;
                $order['pay_name'] .= ' ' . $order_info_mhj->pay_name;
                $order['mhj_tip'] = '根据GSP规定，该订单：' . $order['order_sn_mhj'] . '只能单独转款，支持使用在线支付及转账到对公账户，并且含麻订单不能使用余额，不能使用支付宝转账。';
                if ($this->user->is_zhongduan == 0) {
                    $order['mhj_tip'] = '根据GSP规定，该订单：' . $order['order_sn_mhj'] . '必须公对公转账，并且含麻订单不能使用余额。';
                }
            }
        } elseif ($this->order['order_amount'] > 0 && empty($order_info_mhj) && empty($order_info_sy)) {
            /**
             * 支付限制
             */
            $status = pay_xz($order_info);
            if ($this->user->is_zhongduan == 0 && $order_info->is_mhj == 1) {
                $onlinePay = '';
            } elseif ($status == true) {
                //dd($payment);
                if ($payment == 4) {//银联支付
                    $payment_info = Payment::where('pay_id', 4)->where('enabled', 1)->firstOrfail();
                    $payment = unserialize_config($payment_info->pay_config);
                    //dd($payment);
                    $order_info->user_name = $this->user->user_name;
                    $order_info->pay_desc = $payment_info->pay_desc;
                    $pay_obj = new upop();
                    $onlinePay = $pay_obj->get_code_flow($order_info, $payment);

                } elseif ($payment == 5) {//农行支付
                    //Cache::tags(['user',$this->user->user_id])->flush();
                    $onlinePay = "
                <form style='text-align:center;'  id='pay_form'
                 action='" . route('xyyh.pay') . "' method='get' target='_blank'>
                <input id='J_payonline' style='left: 250px;;' value='立即支付' type='submit' onclick='toSearch($(this))' searchUrl='" . route('xyyh.search', ['id' => $order_info->order_id, 'bank' => 5, 'type' => 0]) . "'>
               <input value='" . $order_info->order_id . "' name='id' type='hidden'>
              <input value='5' name='bank' type='hidden'>
              <input value='0' name='type' type='hidden'>
                </form>";
                } elseif ($payment == 12) {//农行支付
                    //Cache::tags(['user',$this->user->user_id])->flush();
                    $onlinePay = "
                <form style='text-align:center;'  id='pay_form'
                 action='" . route('alipay_pc.index') . "' method='get' target='_blank'>
                <input id='J_payonline' style='left: 250px;;' value='立即支付' type='submit' onclick='toSearch($(this))' searchUrl='" . route('user.order_search', ['id' => $order_info->order_id, 'type' => 0]) . "'>
               <input value='" . $order_info->order_id . "' name='id' type='hidden'>
              <input value='12' name='bank' type='hidden'>
              <input value='0' name='type' type='hidden'>
                </form>";
                } elseif ($payment == 6) {//兴业银行
                    //Cache::tags(['user',$this->user->user_id])->flush();
                    $onlinePay = "
                <form style='text-align:center;'  id='pay_form'
                 action='" . route('xyyh.pay') . "' method='get' target='_blank'>
                <input id='J_payonline' style='left: 250px;;' value='立即支付' type='submit'  onclick='toSearch($(this))' searchUrl='" . route('xyyh.search', ['id' => $order_info->order_id, 'type' => 0]) . "'>
               <input value='" . $order_info->order_id . "' name='id' type='hidden'>
                <input value='0' name='type' type='hidden'>
                </form>";
                } elseif ($payment == 7) {//兴业银行
                    Cache::tags(['user', $this->user->user_id])->flush();
                    $onlinePay = '
                <form style="text-align:center;" id="pay_form" action="' . route('wechat.index') . '" method="get">
                <input id="J_payonline" style="position:absolute;left:0;top:0;margin-left:0;background-color:#FF2A3E;" value="立即支付" type="button" onclick="weixin()" searchUrl="' . route('user.order_search', ['id' => $order_info->order_id, 'type' => 0]) . '">
                <input value="' . $order_info->order_id . '" name="id" type="hidden">
                <input value="0" name="type" type="hidden">
                </form>
                <script>
                function weixin(){
                    var mask = $("<div class=mask></div>");
                    $("body").append(mask);
                    $.ajax({
                        url:"' . route('wechat.index', ['id' => $order_info->order_id, 'type' => 0]) . '",
                        type:"get",
                        dataType:"json",
                        success:function(data){
                            $("body").find(".mask").remove();
                            if(data.error === 1){
                                alert(data.msg);
                            }
                            else if(data.error === 2){
                                window.location="' . route('user.payOk', ['id' => $order_info->order_id]) . '";
                            }
                            else{
                                $("body").append(data.msg);
                                int = setInterval("search_weixin()", 30000)
                            }
                        }
                    })
                }
                function search_weixin(){
                    $.ajax({
                        url:"' . route('user.order_search', ['id' => $order_info->order_id]) . '",
                        type:"get",
                        dataType:"json",
                        success:function($result){
                            if($result.error==0){
                                 window.location="' . route('user.payOk', ['id' => $order_info->order_id]) . '";
                            }
                        }
                    });
                }
                </script>
                ';
                } elseif ($payment == 8) {
                    $onlinePay = "
                <form style='text-align:center;'  id='pay_form'
                 action='" . route('xyyh.pay') . "' method='get' target='_blank'>
                <input id='J_payonline' style='left: 250px;width:135px;' value='支付宝扫码支付' type='button'>
                </form>
                <div id='zfbsm' style='display:none;position:absolute;left:340px;;top:-221px;'>
                <img style='width:190px;height:250px;' src='" . get_img_path('images/zfbsm.jpg') . "'/></div>
                <script>
                $('#J_payonline').hover(function(){
                    $('#zfbsm').show();
                },function(){
                    $('#zfbsm').hide();
                });
                </script>

                ";
                } elseif ($payment == 9) {
                    $onlinePay = '
                <form style="text-align:center;" id="pay_form" action="' . route('alipay.index') . '" method="get">
                <input id="J_payonline" style="left: 250px;" value="立即支付" type="button" onclick="alipay()" searchUrl="' . route('user.order_search', ['id' => $order_info->order_id, 'type' => 0]) . '">
                <input value="' . $order_info->order_id . '" name="id" type="hidden">
                <input value="0" name="type" type="hidden">
                </form>
                <script>
                function alipay(){
                    var mask = $("<div class=mask></div>");
                    $("body").append(mask);
                    $.ajax({
                        url:"' . route('alipay.index', ['id' => $order_info->order_id, 'type' => 0]) . '",
                        type:"get",
                        dataType:"json",
                        success:function(data){
                            $("body").find(".mask").remove();
                            if(data.error === 1){
                                alert(data.msg);
                            }
                            else if(data.error === 2){
                                window.location="' . route('user.payOk', ['id' => $order_info->order_id, 'next' => 1]) . '";
                            }
                            else{
                                $("body").append(data.msg);
                                int = setInterval("search_alipay()", 30000)
                            }
                        }
                    })
                }
                function search_alipay(){
                    $.ajax({
                        url:"' . route('user.order_search', ['id' => $order_info->order_id]) . '",
                        type:"get",
                        dataType:"json",
                        success:function($result){
                            if($result.error==0){
                                 window.location="' . route('user.payOk', ['id' => $order_info->order_id]) . '";
                            }
                        }
                    });
                }
                </script>
                ';
                }
            }
        }
        $assign = [
            'page_title' => trans('cart.orderOk') . '-',
            'order' => $order,
            'onlinePay' => $onlinePay,
            'info' => $order_info,
        ];
        $assign['cartStep'] = "
                <li><img src='" . asset('images/cart_03.png') . "'/></li>
                <li><img src='" . asset('images/confirm2.png') . "'/></li>
                <li><img src='" . asset('images/order22.png') . "'/></li>
                ";
//        if (in_array($this->user->user_id, $cs_arr)) {
//            return view('cart.orderOk')->with($assign);
//        } else {
//            return view('orderOk')->with($assign);
//        }
        return view('cart.orderOk')->with($assign);

    }

    /*
     * 删除购物车中的商品
     */
    public function dropCart(Request $request)
    {
        $this->user = Auth::user();
        $id = $request->input('id');
        if ($id < 0) {
            $ms_goods = $this->ms->get_cart_goods();
            foreach ($ms_goods as $k => $v) {
                if ($v->goods_id == -$id) {
                    unset($ms_goods[$k]);
                }
            }
            Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forget(-$id);
            Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forever('ms_goods', $ms_goods);
            if (count($ms_goods) == 0) {
                Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forget('team');
            }
            $this->dropOther($request, $id);
            return redirect()->back();
        }
        if (strpos($id, $this->miaoshaService->cacheKeys(6)) !== false) {
            $this->miaoshaService->delCacheCartGoods($id);
            return redirect()->back();
        }
        $cart = Cart::findOrfail($id);
        $this->authorize('update-post', $cart);
        if ($cart->delete()) {
            Cache::tags([$this->user->user_id, 'cart'])->decrement('num');
            return redirect()->back();
        }
    }

    /*
     * 移动到收藏
     */
    public function dropToCollect(Request $request)
    {
        $this->user = Auth::user();
        $id = $request->input('id');
        if ($id < 0) {
            $ms_goods = $this->ms->get_cart_goods();
            foreach ($ms_goods as $k => $v) {
                if ($v->goods_id == -$id) {
                    unset($ms_goods[$k]);
                    Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forget($v->goods_id);
                }
            }
            Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forever('ms_goods', $ms_goods);
            if (count($ms_goods) == 0) {
                Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forget('team');
            }
            $this->dropOther($request, $id);
            return redirect()->back();
        }
        if (strpos($id, $this->miaoshaService->cacheKeys(6)) !== false) {
            $this->miaoshaService->delCacheCartGoods($id);
            return redirect()->back();
        }
        DB::transaction(function () use ($id) {
            $goods_id = Cart::select('rec_id', 'user_id', 'goods_id')->findOrFail($id);
            $this->authorize('update-post', $goods_id);
            $goods_id->delete();
            Cache::tags([$this->user->user_id, 'cart'])->decrement('num');
            $collectGoods = CollectGoods::where('goods_id', $goods_id->goods_id)->where('user_id', $this->user->user_id)->first();
            if (!$collectGoods) {
                $collectGoods = new CollectGoods();
                $collectGoods->user_id = $this->user->user_id;
                $collectGoods->goods_id = $goods_id->goods_id;
                $collectGoods->add_time = time();
                $collectGoods->save();
            }
        });
        return redirect()->back();
    }

    /*
     * 批量删除购物车
     */
    public function dropCartMany(Request $request)
    {
        $this->user = Auth::user();
        $id = $request->input('id');
        $id = rtrim($id, '_');
        $id = explode('_', $id);
        $ms_goods = $this->ms->get_cart_goods();
        if (count($ms_goods) > 0) {
            foreach ($ms_goods as $k => $v) {
                if (in_array(0 - $v->goods_id, $id)) {
                    unset($ms_goods[$k]);
                    Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forget($v->goods_id);
                }
                $this->dropOther($request, 0 - $v->goods_id);
            }
        }
        Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forever('ms_goods', $ms_goods);
        if (count($ms_goods) == 0) {
            Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forget('team');
        }

        $mrms = $this->miaoshaService->getCacheCartGoodsList($id);
        foreach ($mrms as $v) {
            $this->miaoshaService->delCacheCartGoods($v->rec_id);
        }

        if (Cart::whereIn('rec_id', $id)->where('user_id', $this->user->user_id)->delete()) {
            if (count($id) > 10) {
                $admin_log = new AdminLog();
                $admin_log->log_time = time();
                $admin_log->user_id = $this->user->user_id;
                $admin_log->log_info = '删除购物车商品(' . count($id) . ')';
                $admin_log->ip_address = $request->ip();
                $admin_log->save();
            }
            Cache::tags([$this->user->user_id, 'cart'])->decrement('num', count($id));
            return redirect()->back();
        }
        return redirect()->back();
    }


    /*
     * 传输订单到 erp 中
     */
    private function toErp($order)
    {
        if (env('TRANS', true) == true) {
            if (!empty($order)) {
                @$this->sync_orderinfo_to_erp($order, $this->user);
            }
        }
    }

    private function sync_orderinfo_to_erp($order)
    {
        $xf_ids = [];//使用现付的会员
//        $order_sn = str_replace('_3','',$order['order_sn']);
//        $this->goods_amount = OrderInfo::where('order_sn','like','%'.$order_sn.'%')->sum('goods_amount');//获取未分单前的总金额
        if (($order->province == 26 && $this->order['goods_amount'] >= 800) || in_array($order->user_id, $xf_ids)) {
            $fkfs = '现付';
        } elseif ($order->province != 26 && $this->order['goods_amount'] >= 800 && $this->user->fkfs == 1) {
            $fkfs = '现付';
        } elseif ($order->province != 26 && $this->order['goods_amount'] >= 800 && $this->user->fkfs == 2) {
            $fkfs = '月结';
        } else {
            $fkfs = '提付';
        }
        if ($this->is_hd == 1) {
            $fkfs = '现付';
        }
        if ($order->shipping_name == '成都万联国通物流有限公司' || strpos($order->shipping_name, '宅急送') !== false) {
            $fkfs = '现付';
        }
        if (strpos($order->shipping_name, '申通') !== false) {
            $order->shipping_name = '成都申通快递实业有限公司郫县营业部';
        } elseif (strpos($order->shipping_name, '腾林物流') !== false) {
            $order->shipping_name = '四川腾林物流有限公司';
        } elseif (strpos($order->shipping_name, '余氏东风') !== false) {
            $order->shipping_name = '四川佳迅物流有限公司（余氏东风）';
        } elseif (strpos($order->shipping_name, '三江物流') !== false) {
            $order->shipping_name = '成都市三江运发货运有限公司';
        } elseif (strpos($order->shipping_name, '国通物流(送货上门)') !== false) {
            $order->shipping_name = '成都嘉宣物流有限公司（四川国通（增益）物流）';
        } elseif (strpos($order->shipping_name, '增益速递') !== false) {
            $order->shipping_name = '成都嘉宣物流有限公司（四川国通（增益）物流）';
        } elseif (strpos($order->shipping_name, '飞马货运') !== false) {
            $order->shipping_name = '飞马快运';
        } elseif (strpos($order->shipping_name, '东臣物流') !== false) {
            $order->shipping_name = '四川东臣物流有限公司';
        } elseif (strpos($order->shipping_name, '成昌信物流') !== false) {
            $order->shipping_name = '成都成昌信物流有限公司';
        } elseif (strpos($order->shipping_name, '光华托运部') !== false) {
            $order->shipping_name = '成都市光华托运部';
        } elseif (strpos($order->shipping_name, '鑫海洋') !== false) {
            $order->shipping_name = '四川鑫海洋货运代理有限公司';
        } elseif (strpos($order->shipping_name, '筋斗云') !== false) {
            $order->shipping_name = '新疆筋斗云物流有限责任公司成都分公司';
        } elseif (strpos($order->shipping_name, '力展') !== false) {
            $order->shipping_name = '四川力展物流有限责任公司';
        } elseif (strpos($order->shipping_name, '宇鑫物流') !== false) {
            $order->shipping_name = '成都宇鑫物流有限公司';
        } elseif (strpos($order->shipping_name, '宅急送') !== false) {
            $order->shipping_name = '成都宅急送快运有限公司';
        }

        //收货地址
        $province = Cache::tags(['shop', 'region'])->remember(1, 8 * 60, function () {
            return Region::where('parent_id', 1)->get();
        })->find($order->province);
        $city = Cache::tags(['shop', 'region'])->remember($order->province, 8 * 60, function () use ($order) {
            return Region::where('parent_id', $order->province)->get();
        })->find($order->city);
        $district = Cache::tags(['shop', 'region'])->remember($order->city, 8 * 60, function () use ($order) {
            return Region::where('parent_id', $order->city)->get();
        })->find($order->district);
        if (empty($district)) {
            $district = Region::find($order->district);
        }

        $add_dz = $province->region_name . $city->region_name . $district->region_name . $order->address;
        $order->order_sn = trim($order->order_sn);

        $fpfs_type = array('增值税普通发票', '纸制发票', '增值税专用发票');
        $fpfs = $fpfs_type[$this->user->dzfp];

        if ($order->is_zq > 0) {//账期会员的账期订单
            $fukfs = '月结';
//            $ywy = $this->user->zq_ywy;
//
//            if(empty($ywy)){//账期业务员为空 读取otc客服
//                $gly_arr = explode('.',$this->user->ls_zpgly);
//                $otc_admin = AdminUser::whereIn('user_name',$gly_arr)
//                    ->whereIn('role_id',[22,31])->pluck('user_name');
//                $ywy = $otc_admin;
//
//            }
        } else {
            $fukfs = '预付';
//            if(empty($this->user->zq_ywy)) {
//                $ywy = '药易购';
//            }else{
//                $ywy = $this->user->zq_ywy;
//            }
        }


        $ywy = '药易购';


//        $zk = 0;
//        if($order->jnmj>0) {//订单使用锦囊支付
//            $jnmj = UserJnmj::where('user_id',$this->user->user_id)->pluck('jnmj_zk');
//            if(!empty($jnmj)){
//                if($jnmj==95){
//                    $zk = "ZKZ00000001";
//                }elseif($jnmj==92){
//                    $zk = "ZKZ00000002";
//                }
//            }
//        }

        $zk = 0;
        $goods_list = OrderGoods::where('order_id', $order->order_id)->orderBy('is_gift')->orderBy('rec_id')->get();
        $zkljs = 0;
        if ($order->is_mhj == 0) {
            $cz_money_zk = floatval(CzMoney::where('user_id', $this->user->user_id)->pluck('zk'));
            $yhje = $order->cz_money * $cz_money_zk + $order->pack_fee + $order->jf_money + $order->hongbao_money;
            if ($yhje > 0 && ($order->goods_amount - $order->zyzk - $yhje) > 0) {
                $zkljs = $yhje / ($order->goods_amount - $order->zyzk - $yhje);
            } elseif ($order->jnmj > 0) {
                $zkljs = $this->user_jnmj->jnmj_zk / 1000;
            }
        }
        //判断付款方式
        if ($fkfs == '现付') {
            $fkfs = 1;
        } else {
            $fkfs = 0;
        }
        //判断发票方式
        if ($fpfs == '增值税专用发票') {
            $fpfs = 2;
        } elseif ($fpfs == '增值税普通发票') {
            $fpfs = 1;
        } else {
            $fpfs = 0;
        }
        //判断付款方式
        if ($fukfs == '月结') {
            $fukfs = 2;
        } elseif ($fukfs == '送货收款') {
            $fukfs = 1;
        } else {
            $fukfs = 0;
        }

        //  $add_dz = iconv('UTF-8', 'GBK', $add_dz);//将字符串的编码从GB2312转到UTF-8
		
		 if (empty($order->tel)){
            $tel = $order->mobile;
        }else{
            $tel = $order->tel;
        }

       // dd($order);
        $in_order = array(
            'id' => $order->order_id,
            'order_id' => $order->order_sn,
            'order_num' => count($goods_list),
            'khinf_id' => $this->user->wldwid1,
            'khinf_id1' => $this->user->wldwid,
            'pack_fee' => $order->pack_fee,
            'goods_amount' => $order->goods_amount,
            'khinf_dh' => iconv('UTF-8','GBK//IGNORE',$tel),
            'lgistics_name' => iconv('UTF-8', 'GBK', $order->shipping_name),
            'address' => iconv('UTF-8', 'GBK', $add_dz),
            'createtime' => '' . date('Y-m-d H:i:s', time()),
            'shr' => iconv('UTF-8', 'GBK', $order->consignee),
            'fkfs' => $fkfs,
            'beizhu' => iconv('UTF-8', 'GBK', $order->consignee . ' ' . $order->sign_building),
            'fpfs' => $fpfs,
            'fukfs' => $fukfs,
            'bmid' => '',
            'bmname' => iconv('UTF-8', 'GBK', ''),
            'UserName' => iconv('UTF-8', 'GBK', '今瑜电商'),
        );
        if ($order->bm_id == 3) {
            if ($order->ls_zpgly == 'admin') {
                $in_order['UserName'] = '袁卫红';
            } else {
                $in_order['UserName'] = $order->ls_zpgly;
            }
        }
        $in_goods = [];
        foreach ($goods_list as $k => $v) {
            if (strpos(strtolower($v->tsbz), 'z') !== false || strpos(strtolower($v->tsbz), 'e') !== false) {//e和z都代表开赠品
                $zp = 0;
            } else {
                $zp = 1;
            }

            //2016-03-14
 /*          if ($v->zyzk > 0) {
                $v->goods_price = $v->goods_price - $v->zyzk;
            }*/ 

            if ($v->extension_code > 0) {
                $v->goods_price = round($v->goods_price * $v->extension_code, 2);
            }

            $val = array(
                'order_id' => $order->order_sn,
                'order_sn' => $k + 1,
                'spinfo_id' => $v->goods()->pluck('ERPID'),
                'ckinf_id' => $v->ckid,
                'order_sl' => $v->goods_number,
                'oreder_jg' => $v->goods_price,
                'createtime' => date('Y-m-d H:i:s', time()),
                'mh_spbh' => $v->rec_id
            );
            $in_goods[$k] = $val;
        }

        if ($in_order['order_num'] > 0) {
            $this->to_webservice($in_order, $in_goods);
        }
    }

    private function to_webservice($order, $goods)
    {
     /*   if($this->user->user_id == 58){
            dd($order,$goods);
            exit();
        }*/

        header("Content-Type: text/html;charset=utf-8");
        $tns = "  
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 183.230.3.128)(PORT = 9001))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = orcl)
    )
  )
       ";
        //dd($order,$goods);
        $db_username = "HZJK";
        $db_password = "hzjk";
        $conn = new \PDO('oci:dbname=' . $tns, $db_username, $db_password);


        $query = "INSERT INTO ZJJ_ORDER VALUES('{$order['id']}','{$order['order_id']}','{$order['order_num']}','{$order['khinf_id']}','{$order['khinf_id1']}','{$order['khinf_dh']}','{$order['lgistics_name']}','{$order['address']}',TO_DATE('{$order['createtime']}','yyyy-mm-dd hh24:mi:ss'),'{$order['shr']}','{$order['fkfs']}','{$order['beizhu']}','','','','','','','{$order['fpfs']}','{$order['fukfs']}','{$order['bmid']}','{$order['bmname']}','{$order['UserName']}')";


        $res = $conn->query($query);
        //插入中间库中order订单表
        //dd($query,$res);

        //插入中间库中order_goods表
        $query1 = 'false';
        
        //dd($id);
        $zkbl = 0;//折扣比例
        if ($order['pack_fee'] > 0){
            $pack_fee = $order['pack_fee'];
            $zkbl = round($pack_fee/$order['goods_amount'],4);
        }
       // dd($zkbl,$order);
        foreach ($goods as $v) {

            $goods_time_price = 0;
            if ($zkbl == 0){
                //dd(1);
                $goods_time_price = $v['oreder_jg'];
            }else{
                //dd(2);
                $goods_time_price = round($v['oreder_jg'] * (1-$zkbl),2);
            }

            //dd($goods_time_price);

			$sql_id = "select zjj_order_info_seq.nextval from dual";

			$rs = $conn->prepare($sql_id);
			$rs->execute();
			$id = $rs->fetch();
            //dd($v);
            $sql = "INSERT INTO ZJJ_ORDER_INFO(ID,ORDER_ID,ORDER_SN,SPINFO_ID,CKINFO_ID,ORDER_SL,ORDER_JG,ORDER_SDSL,ORDER_FKSL,ORDER_KPSL,ORDER_CKSL,CREATETIME,MH_SPBH,CKFLAG,ORDER_YJG,TIME_PRICE) VALUES ('{$id['NEXTVAL']}','{$v['order_id']}','{$v['order_sn']}','{$v['spinfo_id']}','{$v['ckinf_id']}','{$v['order_sl']}','{$v['oreder_jg']}','','','','',TO_DATE('{$v['createtime']}','yyyy-mm-dd hh24:mi:ss'),'{$v['mh_spbh']}','','','{$goods_time_price}')";
            $query1 = $conn->query($sql);
        }
    }

    /**
     * 判断账期是否逾期 逾期不能购买
     */
    private function check_zq()
    {
        $result = [
            'error' => 0,
            'msg' => '',
        ];
//        return $result;
//        if($this->user->is_zq==0&&($this->user->zq_has==1||$this->user->zq_amount>0)){
//
//            $result['error'] = 1;
//            $result['msg'] = '账期未结清,请结清后再购买!';
//        }
        if ($this->user->zq_has == 1) {

            $tishi = '上月';

            $result['error'] = 1;
            $result['msg'] = $tishi . '账期未结清,请结清后再购买!';
        }
        if ($this->user->hz_zq == 1) {
            if ($this->user->hz_zq == 1) {
                $tishi = '合纵线下有款项未结清';
            } else {
                $tishi = '上月账期未结清';
            }
            $result['error'] = 1;
            $result['msg'] = $tishi . ',请结清后再购买!';
        }
        return $result;
    }

    private function order_amount()
    {
        $this->order['order_amount'] = $this->order['goods_amount'] + $this->order['shipping_fee'] - $this->order['zyzk']
            - $this->order['discount'] - $this->order['surplus'] - $this->order['jnmj']
            - $this->order['pack_fee'] - $this->order['jf_money'] - $this->order['hongbao_money'] - $this->order['cz_money'] - $this->order['money_paid'];
        $this->order['order_amount_mhj'] = $this->order['goods_amount_mhj'] - $this->order['zyzk_mhj'];
        $this->order['order_amount_sy'] = $this->order['goods_amount_sy'] - $this->order['zyzk_sy'];
    }
    private function order_yhq($goods)
    {
        $time = time();
        $this->order['num'] = 0;
        foreach ($goods as $v) {
            if($v->goods->is_yhq_status == 2){ 
                $this->order['num'] +=  $v->goods_price * $v->goods_number ;
            }
            if ($v->goods->is_yhq_status == 1) {
                if ($v->goods->is_promote == 1) {
                    if ($v->goods->promote_start_date < $time && $v->goods->promote_end_date > $time) {
                        $this->order['num'] += $v->goods_price * $v->goods_number;

                    }
                }
                if ($time >= $v->goods->preferential_start_date && $time < $v->goods->preferential_end_date && $v->goods->zyzk > 0.01) {
                    $this->order['num'] +=  $v->goods_price * $v->goods_number;
                }
            }
            if($v->goods->tsbz == '秒'){
                $this->order['num'] +=  $v->goods->real_price * $v->goods->cart_number;
            }
        }
    }
    private function surplus()
    {
        if ($this->order['is_can_zq'] == false && $this->order['is_can_use_jnmj'] == false && $this->user->user_money > 0 && $this->order['has_czb'] == 0) {
            $this->order['surplus'] = min([$this->user->user_money, $this->order['order_amount'] - $this->order['order_amount_mhj'] - $this->order['order_amount_sy']]);
        }
        $this->order_amount();
    }

    public function del_no_num()
    {
        $goods = DB::table('cart as c')->leftJoin('goods as g', 'c.goods_id', '=', 'g.goods_id')->where(function ($query) {
            $query->where('g.goods_number', 0)->orwhere('g.is_on_sale', 0);
        })->where('user_id', $this->user->user_id)->lists('rec_id');
        //dd($goods);
        Cart::where('user_id', $this->user->user_id)->whereIn('rec_id', $goods)->delete();
        return redirect()->back();
    }

    private function sy_zq($order_info)
    {
        $zq_info = ZqSy::find($this->user->user_id);
        if (isset($zq_info->is_zq) && $zq_info->is_zq == 1) {//开通了尚医账期
            $now = time();
            if ($zq_info->zq_start_date <= $now && $zq_info->zq_end_date >= $now && ($zq_info->zq_je - $zq_info->zq_amount) > $order_info->order_amount) {//合同时效内 且额度足够
                $order_info->is_zq = 3;
            } else {
                $order_info->is_zq = 0;
            }
        }
        return $order_info;
    }

    private function check_zp($goods)
    {
        $start = strtotime(20170717);
        $end = strtotime(20170726);
        $now = time();
        if (in_array($this->user->user_id, [18810, 13960])) {
            $start = $start - 3600 * 24 * 3;
        }
        if ($start <= $now && $now < $end && $this->user->province == 26 && $this->user->is_zhongduan == 1) {
            $arr = [18059, 714];
            $has = 0;
            $count = 0;
            foreach ($goods as $v) {
                if (in_array($v->goods_id, $arr)) {
                    $count += $v->goods_number;
                    $has++;
                }
            }
            foreach ($goods as $v) {
                if (in_array($v->goods_id, $arr)) {
                    if ($count >= 100 && $has >= 1) {
                        $v->goods->tsbz .= 'z';
                    } else {
                        $v->goods->tsbz = str_replace('z', '', $v->goods->tsbz);
                    }
                }
            }
        }
        return $goods;
    }

    private function check_zp1($goods)
    {
        $start = strtotime(20170517);
        $end = strtotime(20170526);
        $now = time();
        if (in_array($this->user->user_id, [18810, 13960])) {
            $start = $start - 3600 * 24 * 3;
        }
        if ($start <= $now && $now < $end && $this->user->city == 322 && $this->user->user_rank == 5) {
            if ($goods->goods_id == 1013) {
                if ($goods->goods_number >= 30) {
                    $goods->goods->tsbz .= 'z';
                } else {
                    $goods->goods->tsbz = str_replace('z', '', $goods->goods->tsbz);
                }
            }
            if ($goods->goods_id == 3493) {
                if ($goods->goods_number >= 30) {
                    $goods->goods->tsbz .= 'z';
                } else {
                    $goods->goods->tsbz = str_replace('z', '', $goods->goods->tsbz);
                }
            }
        }
        return $goods;
    }

    private function song($goods)
    {
        $start = strtotime('20170831');
        $end = strtotime('20171008');
        $now = time();
        $goods_id = 18018;
        $cs_arr = [13960, 18810, 12567, 18809];
        if (in_array($this->user->user_id, $cs_arr)) {
            $start = $start - 3600 * 24 * 2;
        }
        if ($now >= $start && $now < $end) {
            if ($this->order['relations_count'] == 2) {
                $min_number = min($this->order['relations_number']);
                $number = floor($min_number / 60) * 30;
                if ($number == 0) {
                    return $goods;
                }
                foreach ($goods as $k => $v) {
                    if ($v->goods_id == $goods_id) {
                        unset($goods[$k]);
                        $this->order['goods_amount'] -= $v->goods->real_price * $v->goods_number;
                    }
                }
                $song_goods = Goods::with(['goods_attr', 'member_price', 'goods_attribute',
                    'zp_goods' => function ($query) {
                        $query->wherePivot('zx_ranks', 'not like', '%' . $this->user->user_rank . '%');
                    }])->where('goods_id', $goods_id)->first();
                $song_goods = Goods::attr($song_goods, $this->user);
                if ($song_goods->goods_number <= 0) {
                    return $goods;
                }
                if ($song_goods->goods_number < $number) {//库存不足
                    $number = $song_goods->goods_number;
                }
                $info = collect();
                $info->goods_id = $goods_id;
                $info->rec_id = 0;
                $info->goods_number = $number;
                $info->goods_price = 0.01;
                $info->parent_id = 0;
                $info->product_id = 0;
                $info->subtotal = 0.01 * $number;
                $info->goods = $song_goods;
                $info->child = [];
                $info->goods->real_price = 0.01;
                $info->goods->tsbz = '';
                $info->goods->is_cx = 0;
                $goods[] = $info;
                $this->order['goods_amount'] += $info->goods->real_price * $info->goods_number;
            }
        }
        return $goods;
    }

    protected function cart_num($rec_ids = [])
    {
        if (count($rec_ids) > 0) {
            $cart_num = $rec_ids;
        } else {
            $cart_num = Cache::tags([$this->user->user_id, 'cart'])->get('cart_list');
        }
        if ($this->order['has_czb'] > 0 && count($cart_num) > 1) {
           // show_msg('充值包只能单独提交订单', route('cart.index'), '返回购物车');
        }
        if ($this->is_hd == 0) {
//            if (count($cart_num) < 2 && $this->order['has_czb'] == 0 && $this->order['has_ys'] == 0) {
//                show_msg('需至少购买两个品种才能提交订单', route('cart.index'), '返回购物车');
//            }
        }
        if ($this->order['gcp_num'] > 720 && $this->user->is_zhongduan == 1) {
            tips1('单张订单甘草片数量不能超过720', ['返回购物车' => route('cart.index')]);
        }
    }

    protected function ys_check($goods, $ms_goods)
    {
        $start = strtotime(20171101);
        $cs_arr = cs_arr();
        $end = strtotime(20171108);
        if (in_array($this->user->user_id, $cs_arr)) {
            $start = strtotime(20171030);
            $end = strtotime(20171107);
        }
        $time = time();
        if (count($ms_goods) > 0 && $time >= $start && $time < $end) {
            $this->order['has_ys'] = 1;
            $this->order['is_can_use_jnmj'] = false;
            $this->order['is_can_zq'] = false;
            if (count($goods) > 0) {
                show_msg('预售商品只能单独提交', route('cart.index'), '返回购物车');
            }
        }
    }

    private function check_jf_money()
    {
        $start = strtotime(20180601);
        if (in_array($this->user->user_id, cs_arr())) {
            $start = strtotime(20180601);
        }
        $end = strtotime(20200601);
        $now = time();
        if ($now >= $start && $now < $end && $this->user->is_zhongduan == 1) {
            $jf_money = JfMoney::where('user_id', $this->user->user_id)->first();
            if ($jf_money) {
                $this->user->setRelation('jf_money', $jf_money);
                $min = min([$this->order['goods_amount'] - $this->order['zyzk'] - $this->order['goods_amount_mhj']
                    - $this->order['goods_amount_sy'] - $this->order['pack_fee'] - $this->order['hongbao_money'] - 1,
                    $this->order['ty_amount'] - $this->order['pack_fee'] - $this->order['hongbao_money'], $jf_money->money]);
                if ($min > 0) {
                    $this->order['jf_money'] = intval($min);
                }
            }
        }
        if ($this->order['jf_money'] > 0) {
            $this->order['discount'] = 0;
            $this->order['extension_code'] = 1;
            //$this->order['is_can_zq'] = false;
            $this->order['is_can_use_jnmj'] = false;
        }
    }

    private function check_hongbao_money()
    {
        $start = strtotime(20180601);
        if (in_array($this->user->user_id, cs_arr())) {
            $start = strtotime(20180601);
        }
        $end = strtotime(20200601);
        $now = time();
        if ($now >= $start && $now < $end && $this->user->is_zhongduan == 1 && $this->user->province == 26) {
            $hongbao_money = HongbaoMoney::where('user_id', $this->user->user_id)->first();
            if ($hongbao_money) {
                $this->user->setRelation('hongbao_money', $hongbao_money);
                $min = min([$this->order['goods_amount'] - $this->order['zyzk'] - $this->order['goods_amount_mhj']
                    - $this->order['goods_amount_sy'] - $this->order['pack_fee'] - 1, $this->order['ty_amount'] - $this->order['pack_fee'], $hongbao_money->money]);
                if ($min > 0) {
                    $this->order['hongbao_money'] = $min;
                }
            }
        }
        if ($this->order['hongbao_money'] > 0) {
            $this->order['discount'] = 0;
            $this->order['extension_code'] = 1;
            //$this->order['is_can_zq'] = false;
            $this->order['is_can_use_jnmj'] = false;
        }
    }

    private function check_cz_money()
    {
        $start = strtotime(20171109);
        if (in_array($this->user->user_id, cs_arr())) {
            $start = strtotime(20171101);
        }
        $now = time();
        if ($now >= $start) {
            $cz_money = CzMoney::where('user_id', $this->user->user_id)->first();
            if ($cz_money) {
                $this->user->setRelation('cz_money', $cz_money);
                if ($this->order['is_can_zq'] == false && $this->order['is_can_use_jnmj'] == false && $this->order['has_czb'] == 0) {
                    $this->order['cz_money'] = min([$cz_money->money, $this->order['order_amount'] - $this->order['order_amount_mhj'] - $this->order['order_amount_sy']]);
                }
                $this->order_amount();
            }
        }
    }

    protected function check_zzsx()
    {
        $user = $this->user;
        $yyzz_time = strtotime(trim($user->yyzz_time));
        $xkz_time = strtotime(trim($user->xkz_time));
        $zs_time = strtotime(trim($user->zs_time));
        $yljg_time = strtotime(trim($user->yljg_time));
        $cgwts_time = strtotime(trim($user->cgwts_time));
        $org_cert_validity = strtotime(trim($user->org_cert_validity));

        // 2014-11-26 采购、提货、收货委托书及身份证复印件
        $user->user_rank = intval($user->user_rank);
        $user->ls_mzy = intval($user->ls_mzy);
        $user->ls_swzp = intval($user->ls_swzp);
        $user->mhj_number = intval($user->mhj_number);
        $time = time();
        if ($user->ls_review==0 &&( $user->ls_review_7day == 0 || ($user->ls_review_7day == 1 && $user->day7_time < time()))) {
            show_msg('未审核不能购买商品1', route('cart.index'), '返回购物车');
        }
        //dd($user,$user->yyzz_time , $time);
        //if($user->user_rank != 1){
        if ($yyzz_time && $yyzz_time < $time) {
            show_msg('您的营业执照已过期，请尽快重新邮寄', route('cart.index'), '返回购物车');
        }
        if ($xkz_time && $xkz_time < $time) {
            show_msg('您的药品经营许可证已过期，请尽快重新邮寄', route('cart.index'), '返回购物车');
        }
        if ($zs_time && $zs_time < $time) {
            show_msg('您的GSP证书已过期，请尽快重新邮寄', route('cart.index'), '返回购物车');
        }
        if ($yljg_time && $yljg_time < $time) {
            show_msg('您的医疗机构执业许可证已过期，请尽快重新邮寄', route('cart.index'), '返回购物车');
        }
        if ($cgwts_time && $cgwts_time < $time) {
            show_msg('您的采购委托书已过期，请尽快重新邮寄', route('cart.index'), '返回购物车');
        }
        if ($org_cert_validity && $org_cert_validity < $time) {
            show_msg('您的年度公示已过期，请尽快重新邮寄', route('cart.index'), '返回购物车');
        }
    }

    protected function dropOther($request, $id)
    {
        if ($id == -9855) {
            $type = intval($request->input('type', 0));
            if ($type == 0) {
                $request->offsetSet('id', -18154);
                $request->offsetSet('type', 1);
                $this->dropCart($request);
            }
        }
        if ($id == -18154) {
            $type = intval($request->input('type', 0));
            if ($type == 0) {
                $request->offsetSet('id', -9855);
                $request->offsetSet('type', 1);
                $this->dropCart($request);
            }
        }
    }

    public function is_hd()
    {
        $start = strtotime(20180911);
        if (in_array($this->user->user_id, cs_arr())) {
            $start -= 3600 * 24;
        }
        $end = strtotime(20180912);
        $now = time();
        if ($now >= $start && $now < $end) {
            $this->is_hd = 1;
        }
    }

    public function diff_zyzk($zyzk, $id, $num)
    {
        $start = strtotime('2018-03-29 00:00:00');
        $end = strtotime('2019-01-01 00:00:00');
        if (in_array($this->user->user_id, cs_arr())) {
            $start = $start - 3600 * 24;
        }
        $now = time();
        $ids = [17937];
        if ($now >= $start && $now < $end && in_array($id, $ids) && $num >= 500) {
            $zyzk = 1.08;
        }
        $zyzk = $this->zmsk($zyzk, $id, $num);
        return $zyzk;
    }

    public function zmsk($zyzk, $id, $num)
    {
        $start = strtotime('2018-03-15 00:00:00');
        $end = strtotime('2018-04-01 00:00:00');
        if (in_array($this->user->user_id, cs_arr())) {
            $start = $start - 3600 * 24;
        }
        $now = time();
        if ($now >= $start && $now < $end && $this->user->user_rank == 5) {
            switch ($id) {
                case 10862:
                    if ($num >= 30) {
                        $zyzk = 0.63;
                    }
                    break;
                case 5007:
                    if ($num >= 30) {
                        $zyzk = 0.65;
                    }
                    break;
                case 10869:
                    if ($num >= 40) {
                        $zyzk = 0.3;
                    }
                    break;
            }
        }
        return $zyzk;
    }

    protected function zyj($yhq_list, $ty_amount, $yhq_count)
    {
        $count = 0;
        foreach ($yhq_list as $v) {
            if (in_array($v->cat_id, [52, 53])) {
                $count++;
            }
        }
        if ($ty_amount >= 5000 && $ty_amount < 6000 && $count == 2) {
            foreach ($yhq_list as $v) {
                if (in_array($v->cat_id, [52, 53])) {
                    if ($v->min_je <= $ty_amount && $v->union_type != 0) {
                        $yhq_count++;
                        $v->use = $v->yhq_id;
                        $ty_amount -= $v->min_je;
                        $this->order['pack_fee'] += $v->je;
                    }
                }
            }
        } else {
            foreach ($yhq_list as $k => $v) {
                if ($yhq_list[count($yhq_list) - 1 - $k]->min_je <= $ty_amount && $v->union_type != 0) {
                    $yhq_count++;
                    $yhq_list[count($yhq_list) - 1 - $k]->use = $yhq_list[count($yhq_list) - 1 - $k]->yhq_id;
                    $ty_amount -= $yhq_list[count($yhq_list) - 1 - $k]->min_je;
                    $this->order['pack_fee'] += $yhq_list[count($yhq_list) - 1 - $k]->je;
                } else {
                    if (empty($tip)) {
                        $next_tip = '当前可参与使用优惠券金额：' . formated_price($this->order['ty_amount']) . '；再购买' . formated_price($yhq_list[count($yhq_list) - 1 - $k]->min_je - $ty_amount) . ' 商品，可以享受'
                            . formated_price($this->order['pack_fee'] + $yhq_list[count($yhq_list) - 1 - $k]->je) . ' 优惠券';
                        $this->assign['next_tip'] = $next_tip;
                    }
                }
            }
        }
        return $yhq_count;
    }

    public function zhekou()
    {
        $start = strtotime(20180726);
        $start1 = strtotime(20180724);
        if (in_array($this->user->user_id, cs_arr())) {
            $start -= 3600 * 24;
            $start1 -= 3600 * 24;
        }
        $end = strtotime(20180727);
        $end1 = strtotime(20180725);
        $time = time();
        if ((($time >= $start && $time < $end && in_array($this->user->city, [322]))
                || ($time >= $start1 && $time < $end1 && !in_array($this->user->city, [322])))
            && $this->user->is_zhongduan == 1) {
            $this->assign['manjian_amount'] = $this->order['manjian_amount'];
            if ($this->order['manjian_amount'] >= 10000) {
                $this->order['pack_fee'] = 300;
            } elseif ($this->order['manjian_amount'] >= 6000) {
                $this->next_tip(10000, 300);
                $this->order['pack_fee'] = 140;
            } elseif ($this->order['manjian_amount'] >= 3000) {
                $this->order['pack_fee'] = 50;
                $this->next_tip(6000, 140);
            } elseif ($this->order['manjian_amount'] >= 1500) {
                $this->order['pack_fee'] = 20;
                $this->next_tip(3000, 50);
            } else {
                $this->next_tip(1500, 20);
            }
        }
    }

    public function manjian()
    {
        $start = strtotime(20190116);
        $end = strtotime(20190201);
    //打折设置
        $result  = Db::table('zk_goods')->where('zk_id',2)->get();
        foreach ($result as $v){
            $info =$v;
        }

            if($info->is_show == 1){
                $start = $info->start_date;
                $end = $info->end_date;
            }
        

        $time = time();

        if ($time >= $start && $time < $end
            && $this->user->is_zhongduan == 1) {
            $this->assign['manjian_amount'] = $this->order['manjian_amount']-$this->order['pack_fee'];
			$this->order['manjian_amount'] = $this->order['manjian_amount']-$this->order['pack_fee'];
            //var_dump($this->assign['manjian_amount']);
            if ($this->order['manjian_amount']) {
                $this->order['pack_fee'] += round($this->order['manjian_amount'] * $info->scale_price, 2);
            }
            
        /*    if ($this->order['manjian_amount'] >= 8000) {
                $this->order['pack_fee'] += round($this->order['manjian_amount'] * 0.05, 2);
            } elseif ($this->order['manjian_amount'] >= 5000) {
                $this->order['pack_fee'] += round($this->order['manjian_amount'] * 0.04, 2);
                $this->next_tip1(8000, 9.5);
            } elseif ($this->order['manjian_amount'] >= 3000) {
                $this->order['pack_fee'] += round($this->order['manjian_amount'] * 0.03, 2);
                $this->next_tip1(5000, 9.6);
            } elseif ($this->order['manjian_amount'] >= 1000) {
                $this->order['pack_fee'] += round($this->order['manjian_amount'] * 0.02, 2);
                $this->next_tip1(3000, 9.7);
            }*/
        }
    }

    public function check_gcp($v)
    {
        $start = strtotime("this week Monday", time());
        $end = strtotime("next week Monday", time());
        $num = OrderGoods::xg_num($v->goods_id, $this->user->user_id, [$start, $end]);//已购买的数量
        if ($num + $v->goods_number > 720) {
            tips1('复方甘草片(国药集团新疆制药有限公司)每周限购720');
        }
    }

    protected function song_zp($goods)
    {
        $start = strtotime('2018-07-30 13:00:00');
        if (in_array($this->user->user_id, cs_arr())) {
            $start -= 3600 * 24;
        }
        $end = strtotime('2017-09-01 00:00:00');
        $time = time();
        if ($time >= $start && $time < $end) {
            if ($this->user->user_rank == 5 && $this->user->province == 26) {
                $goods = $this->add_zp($goods, 26995, 5);
            }
//            if (in_array($this->user->user_rank, [2, 5])) {
//                $goods = $this->add_zp($goods, 2189, 30);
//            }
        }
        return $goods;
    }

    protected function add_zp($goods, $goods_id, $number)
    {
        $song_goods = Goods::with(['goods_attr', 'member_price', 'goods_attribute'])
            ->where('goods_id', $goods_id)->first();
        $song_goods = Goods::attr($song_goods, $this->user);
        if ($song_goods->goods_number <= 0) {
            return $goods;
        }
        foreach ($goods as $k => $v) {
            if ($v->goods_id == $goods_id) {
                unset($goods[$k]);
                $this->order['goods_amount'] -= $v->goods->real_price * $v->goods_number;
                $this->order['manjian_amount'] -= $v->goods->real_price * $v->goods_number;
                $this->order['ty_amount'] -= $v->goods->real_price * $v->goods_number;
            }
        }
        if ($song_goods->goods_number < $number) {//库存不足
            $number = $song_goods->goods_number;
        }
        $info = collect();
        $info->goods_id = $goods_id;
        $info->rec_id = 0;
        $info->goods_number = $number;
        $info->goods_price = 0.01;
        $info->parent_id = 0;
        $info->product_id = 0;
        $info->subtotal = 0.01 * $number;
        $info->goods = $song_goods;
        $info->child = [];
        $info->goods->real_price = 0.01;
        $info->goods->tsbz = '';
        $info->goods->is_cx = 0;
        $goods[] = $info;
        $this->order['goods_amount'] += $info->goods->real_price * $info->goods_number;
        $this->order['manjian_amount'] += $info->goods->real_price * $info->goods_number;
        $this->order['ty_amount'] += $info->goods->real_price * $info->goods_number;
        return $goods;
    }

    protected function next_tip($amount, $pack_fee)
    {
        $next_tip = '当前可参与' . trans('common.pack_fee') . '金额：' . formated_price($this->order['manjian_amount']) .
            '；再购买' . formated_price($amount - $this->order['manjian_amount']) . ' 商品，可以享受'
            . formated_price($pack_fee) . trans('common.pack_fee');
        $this->assign['next_tip'] = $next_tip;
    }

    protected function next_tip1($amount, $zhekou)
    {
        $next_tip = '当前可参与' . trans('common.pack_fee') . '金额：' . formated_price($this->order['manjian_amount']) .
            '；再购买' . formated_price($amount - $this->order['manjian_amount']) . ' 商品，可以享受' . $zhekou . '折优惠';
        $this->assign['next_tip'] = $next_tip;
    }

    protected function add_jmxx($sign_building)
    {
        if ($this->user->province == 26 && $this->user->user_rank == 2) {//四川药店
            $sign_building .= ' 加盟三折页';
        }
        return $sign_building;
    }
}



