<?php

namespace App\Http\Controllers;

use App\Ad;
use App\AdminUser;
use App\Cart;
use App\CollectGoods;
use App\Goods;
use App\Http\Controllers\Huodong\Action\HdcxController;
use App\UserJnmj;
use App\OnlinePay;
use App\OrderGoods;
use App\OrderInfo;
use App\PayLog;
use App\Region;
use App\UserAddress;
use App\YouHuiQ;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Shipping;
use App\Payment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;
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
        'order_amount'=>0,
        'goods_amount'=>0,
        'ms_amount'=>0,
        'shipping_fee'=>0,
        'surplus'=>0,
        'zyzk'=>0,
        'zyzk_mhj'=>0,
        'discount'=>0,
        'extension_code'=>1,//折扣比例
        'jnmj'=>0,
        'pack_fee'=>0,
        'money_paid'=>0,
        'yhq_ids'=>[],
        'goods_amount_mhj'=>0,//麻黄碱商品金额
        'jp_amount'=>0,//精品积分
        'jp_amount_mhj'=>0,//精品积分(麻黄碱精品)
        'sign_building'=>'',
        'sign_building_mhj'=>'',
        'jehg_amount'=>0,//金额换购
        'zy_amount'=>0,//优惠券-中药
        'fzy_amount'=>0,//优惠券-非中药
        'ty_amount'=>0,//优惠券-通用
        'yhq_list'=>[],//优惠券列表
        'is_zy'=>0,//是否换购订单 3为换购
        'hg_goods'=>[],//换购商品
        'hg_type'=>0,//换购类型 2金额 1是商品
        'is_can_zq'=>true,//是否可以使用账期
        'is_can_use_jnmj'=>true,//是否可以使用充值余额
        'is_no_tj'=>true,//是否含有特价
        'is_no_mhj'=>true,//是否含有麻黄碱
        'is_no_hy'=>true,//是否含有哈药商品
        'is_no_zyzk'=>true,//是否含有优惠商品
    ];
    private $user;

    private $user_jnmj;

    private $assign;

    private $hdcx;

    private $ms;
    /*
     * 中间件
     */
    public function __construct(HdcxController $hdcx){
        $this->middleware('jiesuan', ['only' => 'jiesuan']);//结算验证 是否有收货地址
        $this->middleware('cartNum', ['only' => ['jiesuan','order']]);//结算验证 商品数量是否满两个
        $this->user = auth()->user()->is_new_user();
        $this->user_jnmj = UserJnmj::where('user_id',$this->user->user_id)->first();
        if($this->user->is_zq == 1){
            $this->order['is_can_zq'] = true;//可以使用账期
        }else{
            $this->order['is_can_zq'] = false;//不能使用
        }
        $this->assign = [];
        $this->hdcx = $hdcx;
        $this->ms = new MiaoShaController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //为您推荐
        $wntj = Goods::rqdp('is_wntj',10,-4);
        $wntj = goods_list($this->user,$wntj);
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





        foreach($cart as $k=>$v){
            Redis::zremrangebyscore('goods_list', $v->goods->goods_id, $v->goods->goods_id);
            $v->goods = Goods::area_xg($v->goods,$this->user);
            $v->is_can_change = 1;
            if($v->goods->is_can_buy==0){
                $v->message = $v->goods->goods_name."商品限购";
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);
            }
            elseif($v->goods->xg_num==0&&$v->goods->ls_ggg>0&&$v->goods->is_xg==2){
                //商品有限购 而且商品剩余限购数量为零 而且商品没有在搞特价
                $v->message = $v->goods->goods_name."商品数量限购";
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);
            }
            elseif($v->goods->real_price==0){//如果商品没有库存
                $v->message = $v->goods->goods_name."价格正在定制中";
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);
            }elseif($v->goods->goods_number==0){//如果商品没有库存
                $v->message = $v->goods->goods_name.trans('cart.kcbz');
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);
            }
            elseif($v->goods->is_on_sale==0){//商品已下架
                $v->message = $v->goods->goods_name.trans('cart.yxj');
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);;
            }
            elseif($v->goods->is_delete==1){//商品已删除
                $v->message = $v->goods->goods_name.trans('cart.ysc');
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);;
            }
            elseif($v->goods->is_alone_sale==0){//商品不能单独销售
                $v->message = $v->goods->goods_name.trans('cart.bnddxs');
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);;
            }
            elseif($v->goods->hy_price>0&&$this->user->hymsy==0){//非哈药会员不能购买哈药

                $delId[] = $v->rec_id;

                unset($cart[$k]);;
            }
            elseif(strpos($v->goods->cat_ids, '180') !== false && $this->user->mhj_number == 0){//麻黄碱
                $v->message = $v->goods->goods_name.trans('cart.mhj');
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);;
            }
            else {
                $up_price = [];
                $up_num = [];
                $zbz = isset($v->goods->zbz)?$v->goods->zbz:1;
                $jzl = isset($v->goods->jzl)?intval($v->goods->jzl):0;
                $old_num = $v->goods_number;
                $result = final_num($v->goods->xg_num,$jzl,$zbz,$v->goods->goods_number,$old_num);
                $v->goods_number = $result['goods_number'];


                $orderstr .= $v->rec_id . '_';
                if($v->goods->real_price!=$v->goods_price){
                    $up_price['rec_id'] = $v->rec_id;
                    $up_price['goods_price'] = $v->goods->real_price;
                }

                if($old_num!=$v->goods_number&&$v->goods_number>0){
                    $up_num['rec_id'] = $v->rec_id;
                    $up_num['goods_number'] = $v->goods_number;
                }
                if($v->goods_number<=0){
                    $v->message = $v->goods->goods_name.trans('cart.kcbz');
                    $delId[] = $v->rec_id;
                    $tip_info[] = $v;
                    unset($cart[$k]);;
                }
                $cache_cart[] = $v->rec_id;
                //精品
                if (strpos($v->goods->show_area, '2') !== false) {
                    $this->order['jp_amount'] += $v->goods->real_price * $v->goods_number;
                    $v->goods->is_jp = 1;
                }

                if(!empty($up_price)){

                    $up_price_arr[] = $up_price;
                }
                if(!empty($up_num)){

                    $up_num_arr[] = $up_num;
                }
                if(isset($goods_ids[$v->goods->goods_id])){
                    $delId[] = $v->rec_id;
                    unset($cart[$k]);;
                }else {
                    $goods_ids[$v->goods->goods_id] = 1;
                    $this->order['goods_amount'] += $v->goods->real_price * $v->goods_number;
                }
            }
        }

        /**
         * 获取秒杀商品
         */
        $ms_goods = $this->ms->get_cart_goods();
        if(!empty($ms_goods)) {
            foreach ($ms_goods as $k=>$v) {
                if (isset($goods_ids[$v->goods->goods_id])) {
                    foreach($cart as $key=>$val){
                        if($val->goods_id==$v->goods->goods_id) {
                            $delId[] = $val->rec_id;
                            unset($cart[$key]);
                            $this->order['goods_amount'] -= $val->goods->real_price * $val->goods_number;
                        }
                    }
                } else {
                    $goods_ids[$v->goods->goods_id] = 1;
                    $this->order['goods_amount'] += $v->goods->real_price * $v->goods_number;
                }
                $cart[] = $v;
            }
        }
        if(!empty($delId)) {
            Cart::destroy($delId);
            Cache::tags([$this->user->user_id,'cart'])->decrement('num',count($delId));
        }
        if(!empty($up_price_arr)){

            Goods::updateBatch('ecs_cart',$up_price_arr);
        }
        if(!empty($up_num_arr)){

            Goods::updateBatch('ecs_cart',$up_num_arr);
        }

        Cache::tags([$this->user->user_id,'cart'])->forever('cart_list',$cache_cart);

        $total['jp_total_amount'] = sprintf('%.2f',$this->order['jp_amount']);
        $total['shopping_money'] = sprintf('%.2f',$this->order['goods_amount']);
        $this->assign['page_title'] = trans('common.cart').'-';
        $this->assign['goods_list'] = $cart;
        $this->assign['tip_info'] = $tip_info;
        $this->assign['total'] = $total;
        $this->assign['wntj'] = $wntj;
        $this->assign['cartStep'] = "
        <li><img src='".asset('images/cart_03.png')."'/></li>
        <li><img src='".asset('images/cart_04.png')."'/></li>
        <li><img src='".asset('images/cart_05.png')."'/></li>
        ";
        return view('cart')->with($this->assign);
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
        /**
         * 验证账期是否逾期
         */
        $check_zq = $this->check_zq();
        if($check_zq['error']==1){
            return view('message')->with(messageSys($check_zq['msg'], route('cart.index'), [
                [
                    'url' => route('cart.index'),
                    'info' => trans('common.backToCart'),
                ],
            ]));
        }

        $addressId = $this->user->address_id;
        $rec_ids = Cache::tags([$this->user->user_id,'cart'])->get('cart_list');
        $goods = Cart::get_cart_goods_l($this->user,$rec_ids);
        if(!$rec_ids){
            return redirect()->route('cart.index');
        }
        $check_ids = Ad::check_ids();
        foreach($goods as $k=>$v){
            $v->subtotal = $v->goods->real_price*$v->goods_number;
            $v->goods = Goods::area_xg($v->goods,$this->user);//检查是否区域限购

            $message = Goods::check_cart($v->goods,$this->user);//检查各种限制条件
            if($message['error']==1){
                return view('message')->with(messageSys($message['message'],route('cart.index'),[
                    [
                        'url'=>route('cart.index'),
                        'info'=>trans('common.backToCart'),
                    ],
                ]));
            }

            if($v->goods_number>$v->goods->goods_number){
                return view('message')->with(messageSys($v->goods->goods_name.'库存不足',route('cart.index'),[
                    [
                        'url'=>route('cart.index'),
                        'info'=>trans('common.backToCart'),
                    ],
                ]));
            }
            if($v->goods_number>$v->goods->xg_num&&$v->goods->xg_num>0){//超出限购数量
                return view('message')->with(messageSys($v->goods->goods_name.'超出限购数量',route('cart.index'),[
                    [
                        'url'=>route('cart.index'),
                        'info'=>trans('common.backToCart'),
                    ],
                ]));
            }

            /**
             * 需要统计的数据
             * is_no_tj is_no_mhj
             * jp_amount zyzk zyzk_mhj goods_amount_mhj
             */

            if($v->goods->is_mhj==1){//麻黄碱商品
                $this->order['is_no_mhj'] = false;//含麻黄碱
                $this->order['goods_amount_mhj'] += $v->subtotal;
            }

            if($v->goods->is_cx==1){//特价
                $this->order['is_no_tj'] = false;//含特价
                if(!in_array($v->goods->goods_id,$check_ids)){
                    $this->order['is_can_zq'] = false;
                }
            }

            if(strpos($v->goods->product_name,'哈药')!==false||$v->goods->hy_price>0){//哈药
                $this->order['is_no_hy'] = false;//含哈药
                $v->is_can_zk = 0;
            }

            if($v->goods->goods_id==3048){//哈药
                $this->order['is_no_hy'] = false;//含哈药
            }

            if($v->goods->is_jp==1){//精品
                $this->order['jp_amount'] += $v->subtotal;
            }

            if($v->goods->zyyp==1){//中药饮片
                $this->order['zyyp_amount'] += $v->subtotal;
            }

            if($this->user->is_zhongduan==1){//终端用户
                $v->goods->zyzk = Goods::check_zyzk($v->goods,$this->user);
                $this->order['zyzk'] += $v->goods->zyzk*$v->goods_number;
                if($v->goods->is_mhj==1){
                    $this->order['zyzk_mhj'] += $v->goods->zyzk*$v->goods_number;
                }
            }

            if($v->goods->zyzk>0){//优惠金额商品
                $this->order['is_no_zyzk'] = false;
            }

            if($v->goods->is_mhj==0){// 非麻黄碱
                $this->order['ty_amount'] += ($v->goods->real_price-$v->goods->zyzk)*$v->goods_number;
                if($v->goods->is_zyyp==1){
                    $this->order['zy_amount'] += ($v->goods->real_price-$v->goods->zyzk)*$v->goods_number;
                }else{
                    $this->order['fzy_amount'] += ($v->goods->real_price-$v->goods->zyzk)*$v->goods_number;
                }
            }

            $this->order['goods_amount'] += $v->goods->real_price*$v->goods_number;

        }

        /**
         * 获取秒杀商品
         */
        $ms_goods = $this->ms->get_cart_goods($rec_ids,false);
        if(!empty($ms_goods)) {
            $this->order['ms_amount'] = $ms_goods->goods_amount;
            if ($this->order['ms_amount'] > 0) {
                $this->order['is_can_use_jnmj'] = false;
                $this->order['is_can_zq'] = false;
            }
            foreach ($ms_goods as $v) {
                $goods[] = $v;
            }
        }
        $this->order['goods_amount'] = $this->order['goods_amount'] + $this->order['ms_amount'];

        $tsbz_c = $this->hdcx->tsbz_c($goods,$this->order,$this->user);
        $this->order = $tsbz_c['order'];
        $goods = $tsbz_c['goods'];
        $this->order_amount();

        //限购金额
        if($this->order['goods_amount']<shopConfig('min_goods_amount')){
            return view('message')->with(messageSys(trans('cart.minMoney').' '.formated_price(shopConfig('min_goods_amount')).'，'.trans('cart.cannot').'。',route('cart.index'),[
                [
                    'url'=>route('cart.index'),
                    'info'=>trans('common.backToCart'),
                ],
            ]));
        }
        //收货地址
        $address = UserAddress::where(function($query)use($addressId){
            $query->where('user_id',$this->user->user_id);
            if($addressId>0){
                $query->where('address_id',$addressId);
            }
        })->first();
        if(!$address){
            $address = UserAddress::where(function($query)use($addressId){
                $query->where('user_id',$this->user->user_id);
            })->first();
        }
        if(!$address){
            return redirect()->route('address.edit');
        }else{
            $this->user->address_id = $address->address_id;
            $this->user->save();
        }
        //dd($address);
        $province = Cache::tags(['shop','region'])->rememberForever(1,function(){
            return Region::where('parent_id',1)->get();
        })->find($address->province);
        $city = Cache::tags(['shop','region'])->rememberForever($address->province,function()use($address){
            return Region::where('parent_id',$address->province)->get();
        })->find($address->city);
        $district = Cache::tags(['shop','region'])->rememberForever($address->city,function()use($address){
            return Region::where('parent_id',$address->city)->get();
        })->find($address->district);

        if(!$province||!$city||empty($address->consignee)||empty($address->tel)){
            return redirect()->route('address.edit');
        }
        //运费
        $shipping_id = $this->user->shipping_id;
        if($shipping_id!=0) {
            if (strpos($this->user->shipping_name, trans('cart.zjs')) !== false && $this->order['goods_amount']<800) {
                $this->order['shipping_fee'] = 12;
            }

        }
        //物流
        if($this->user->shipping_id==0) {
            $shipping = Shipping::shipping_list([$this->user->country,$this->user->province,$this->user->city,$this->user->district]);
            $this->assign['shipping'] = $shipping;
        }
        //支付方式
        $payment = Payment::where('enabled',1)->select('pay_id','pay_name','pay_desc','is_cod')->orderBy('pay_order','desc')->get();

        $this->assign = $this->hdcx->jpzq($this->user,$this->order['jp_amount'],$this->assign);

        $this->order_amount();

        $result = $this->hdcx->jehg($this->user,$this->order,$goods,$this->user_jnmj);
        $goods = $result['goods'];
        $this->order = $result['order'];
        $this->order_amount();

        $this->order = $this->hdcx->zhekou($goods,$this->order,$this->user);
        $this->order_amount();


        //if((!$this->user_jnmj||($this->user_jnmj&&$this->user_jnmj->jnmj_amount==0))){
        $this->order = $this->hdcx->yhq($this->user,$this->order,$goods);
        //}
        if($this->order['pack_fee']>0){
            $this->assign['min_je'] = $this->order['min_je'];
            $this->assign['yhq_end'] = $this->order['yhq_end'];
            $this->assign['yhq_start'] = $this->order['yhq_start'];
        }
        if($this->order['pack_fee']>0||!empty($this->order['yhq_list'])){
            $this->order['discount'] = 0;
            $this->order['extension_code'] = 1;
            $this->order['is_can_zq'] = false;
            $this->order['is_can_use_jnmj'] = false;
        }

        $this->order = $this->hdcx->czye($this->user,$this->user_jnmj,$this->order);

        $this->order_amount();
        $this->surplus();
        /**
         * 活动相关结束
         */

        /**
         * 判断是否能使用账期
         */
//        if(!empty($hg_goods)||$hg_type!=0){//有换购
//            $czfl_amount = 0;
//        }
        $this->assign['hg_goods'] = $this->order['hg_goods'];
        $this->assign['hg_type'] = $this->order['hg_type'];
        $this->assign['surplus'] = $this->order['surplus'];
        $this->assign['order_amount'] = $this->order['order_amount'];
        $this->assign['goods_amount'] = $this->order['goods_amount'];
        $this->assign['ty_amount'] = $this->order['ty_amount'];
        $this->assign['shipping_fee'] = $this->order['shipping_fee'];
        $this->assign['page_title'] = trans('cart.orderCheck').'-';
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
        $this->assign['sy_num'] = isset($this->order['sy_num'])?$this->order['sy_num']:0;
        $this->assign['today_num'] = isset($this->order['today_num'])?$this->order['today_num']:0;
        $this->assign['use_num'] = isset($this->order['use_num'])?$this->order['use_num']:0;
        $this->assign['pack_fee'] = $this->order['pack_fee'];
        $this->assign['ty_amount'] = $this->order['ty_amount'];
        $this->assign['is_no_mhj'] = $this->order['is_no_mhj'];
        $this->assign['zyzk'] = $this->order['zyzk'];
        $this->assign['jp_amount'] = $this->order['jp_amount'];
        $this->assign['shipping_fee'] = $this->order['shipping_fee'];
        $this->assign['discount'] = $this->order['discount'];
        $this->assign['is_no_mhj'] = $this->order['is_no_mhj'];
        $this->assign['yhq_list'] = $this->order['yhq_list'];
        $this->assign['cartStep'] = "
        <li><img src='".asset('images/cart_03.png')."'/></li>
        <li><img src='".asset('images/confirm2.png')."'/></li>
        <li><img src='".asset('images/cart_05.png')."'/></li>
        ";
        return view('jiesuan')->with($this->assign);
    }

    /*
     * 插入订单
     */
    public function order(Request $request)
    {
        /**
         * 验证账期是否逾期
         */
        $check_zq = $this->check_zq();
        if($check_zq['error']==1){
            return view('message')->with(messageSys($check_zq['msg'], route('cart.index'), [
                [
                    'url' => route('cart.index'),
                    'info' => trans('common.backToCart'),
                ],
            ]));
        }

        $address_id = $request->input('address_id');
        $postscript = $request->input('postscript');//订单备注
        $shipping = $request->input('shipping');//物流id
        $payment = $request->input('payment','7');//支付方式

        /**
         * 优惠券id
         */
        $this->order['yhq_ids'] = $request->input('yhq_id',[]);//优惠券
        if(!empty($this->order['yhq_ids'])){
            foreach($this->order['yhq_ids'] as $k=>$v){
                if(empty($v)){
                    unset($this->order['yhq_ids'][$k]);
                }
            }
        }


        $gift = $request->input('gift','');//礼品
        $area_name = $request->input('area_name','');
        $kf_name = $request->input('kf_name','');
        $rec_ids = Cache::tags([$this->user->user_id,'cart'])->get('cart_list');
        Cache::tags([$this->user->user_id,'cart'])->forget('cart_list');
        $goods = Cart::get_cart_goods_l($this->user,$rec_ids);
        if(!$rec_ids){
            return view('message')->with(messageSys('不能重复提交订单',route('cart.index'),[
                [
                    'url'=>route('cart.index'),
                    'info'=>'返回购物车',
                ],
            ]));
        }

        $check_ids = Ad::check_ids();

        foreach($goods as $k=>$v){
            $v->subtotal = $v->goods->real_price*$v->goods_number;
            $v->goods = Goods::area_xg($v->goods,$this->user);//检查是否区域限购

            $message = Goods::check_cart($v->goods,$this->user);//检查各种限制条件
            if($message['error']==1){
                return view('message')->with(messageSys($message['message'],route('cart.index'),[
                    [
                        'url'=>route('cart.index'),
                        'info'=>trans('common.backToCart'),
                    ],
                ]));
            }

            if($v->goods_number>$v->goods->goods_number){
                return view('message')->with(messageSys($v->goods->goods_name.'库存不足',route('cart.index'),[
                    [
                        'url'=>route('cart.index'),
                        'info'=>trans('common.backToCart'),
                    ],
                ]));
            }
            if($v->goods_number>$v->goods->xg_num&&$v->goods->xg_num>0){//超出限购数量
                return view('message')->with(messageSys($v->goods->goods_name.'超出限购数量',route('cart.index'),[
                    [
                        'url'=>route('cart.index'),
                        'info'=>trans('common.backToCart'),
                    ],
                ]));
            }

            /**
             * 需要统计的数据
             * is_no_tj is_no_mhj
             * jp_amount zyzk zyzk_mhj goods_amount_mhj
             */

            if($v->goods->is_mhj==1){//麻黄碱商品
                $this->order['is_no_mhj'] = false;//含麻黄碱
                $this->order['goods_amount_mhj'] += $v->subtotal;
            }

            if($v->goods->is_cx==1){//特价
                $this->order['is_no_tj'] = false;//含特价
                if(!in_array($v->goods->goods_id,$check_ids)){
                    $this->order['is_can_zq'] = false;
                }
            }

            if(strpos($v->goods->product_name,'哈药')!==false||$v->goods->hy_price>0){//哈药
                $this->order['is_no_hy'] = false;//含哈药
                $v->is_can_zk = 0;
            }

            if($v->goods->goods_id==3048){//哈药
                $this->order['is_no_hy'] = false;//含哈药
            }

            if($v->goods->is_jp==1){//精品
                $this->order['jp_amount'] += $v->subtotal;
                if($v->goods->is_mhj==1){//麻黄碱
                    $this->order['jp_amount_mhj'] += $v->subtotal;
                }
            }

            if($v->goods->zyyp==1){//中药饮片
                $this->order['zyyp_amount'] += $v->subtotal;
            }

            if($this->user->is_zhongduan==1){//终端用户
                $v->goods->zyzk = Goods::check_zyzk($v->goods,$this->user);
                $this->order['zyzk'] += $v->goods->zyzk*$v->goods_number;
                if($v->goods->is_mhj==1){
                    $this->order['zyzk_mhj'] += $v->goods->zyzk*$v->goods_number;
                }
            }

            if($v->goods->zyzk>0){//优惠金额商品
                $this->order['is_no_zyzk'] = false;
            }

            if($v->goods->is_mhj==0){//非特价 非麻黄碱
                $this->order['ty_amount'] += $v->subtotal;
                if($v->goods->is_zyyp==1){
                    $this->order['zy_amount'] += $v->subtotal;
                }else{
                    $this->order['fzy_amount'] += $v->subtotal;
                }
            }


            $this->order['goods_amount'] += $v->goods->real_price*$v->goods_number;

        }
        /**
         * 获取秒杀商品
         */
        $ms_goods = $this->ms->get_cart_goods($rec_ids,false);
        if(!empty($ms_goods)) {
            $this->order['ms_amount'] = $ms_goods->goods_amount;
            if ($this->order['ms_amount'] > 0) {
                $this->order['is_can_use_jnmj'] = false;
                $this->order['is_can_zq'] = false;
            }
            foreach ($ms_goods as $v) {
                $goods[] = $v;
            }
        }
        $this->order['goods_amount'] = $this->order['goods_amount'] + $this->order['ms_amount'];

        $tsbz_c = $this->hdcx->tsbz_c($goods,$this->order,$this->user);
        $this->order = $tsbz_c['order'];
        $goods = $tsbz_c['goods'];
        $this->order_amount();

        //限购金额
        if($this->order['goods_amount']<shopConfig('min_goods_amount')){
            return view('message')->with(messageSys(trans('cart.minMoney').' '.formated_price(shopConfig('min_goods_amount')).'，'.trans('cart.cannot').'。',route('cart.index'),[
                [
                    'url'=>route('cart.index'),
                    'info'=>trans('common.backToCart'),
                ],
            ]));
        }
        //获取收货地址
        $address = UserAddress::where('user_id',$this->user->user_id)->where('address_id',$address_id)
            ->select('consignee','country','province','city','district','address','zipcode','tel','mobile','email','best_time','sign_building')
            ->first();

        if(!$address){
            return view('message')->with(messageSys('请选择收货地址',route('cart.index'),[
                [
                    'url'=>route('cart.index'),
                    'info'=>trans('common.backToCart'),
                ],
            ]));
        }



        if($this->user->shipping_id==0) {
            if ($shipping == -1) {//其他物流
                $shipping_name = $request->input('ps_wl');
            } else {
                $shipping_name = Shipping::where('enabled', 1)->where('shipping_id', $shipping)->pluck('shipping_name');
            }
        }else{
            $shipping_name = $this->user->shipping_name;
        }
        if(strpos($shipping_name,'宅急送')!==false&&$this->order['goods_amount']<800){
            $this->order['shipping_fee'] = 12;
        }
        $pay_name = Payment::where('pay_id',$payment)->pluck('pay_name');
        /* 2015-01-19 组合礼品名称到标志建筑字段 */
        $old_sign_building = $address->sign_building;
        $this->order['sign_building'] = $old_sign_building;
        $this->order['sign_building_mhj'] = $old_sign_building;
        if(!empty($gift)&&$gift!=trans('cart.ljjf')){

            if($this->order['jp_amount'] == $this->order['jp_amount_mhj']){//只含有麻黄碱精品
                $gift = str_replace(' ','',$gift);
                $this->order['sign_building_mhj'] = trans('cart.hdlp').":".$gift." ".$address->sign_building;
                $this->order['jp_amount'] = 0;
                $this->order['jp_amount_mhj'] = 0;
            }elseif($this->order['jp_amount_mhj']==0){//不含麻黄碱精品
                $gift = str_replace(' ','',$gift);
                $this->order['sign_building'] = trans('cart.hdlp').":".$gift." ".$address->sign_building;
                $this->order['jp_amount'] = 0;
                $this->order['jp_amount_mhj'] = 0;
            }


        }

        $result = $this->hdcx->jehg($this->user,$this->order,$goods,$this->user_jnmj);
        $goods = $result['goods'];
        $this->order = $result['order'];
        $this->order_amount();


        $this->order = $this->hdcx->zhekou($goods,$this->order,$this->user);
        $this->order_amount();

        if(!empty($this->order['yhq_ids'])){
            $this->order = $this->hdcx->yhq($this->user,$this->order,$goods,$this->order['yhq_ids']);
        }

        if(empty($this->order['yhq_ids'])){//没有选择优惠券
            $this->order['pack_fee'] = 0;
        }

        if($this->order['pack_fee']>0){
            $this->order['discount'] = 0;
            $this->order['extension_code'] = 1;
            $this->order['is_can_zq'] = false;
            $this->order['is_can_use_jnmj'] = false;
        }
        $this->order = $this->hdcx->czye($this->user,$this->user_jnmj,$this->order);


        $this->order_amount();
        $this->surplus();

        $order_sn = getOrderSn();//订单编号$
        $order_info_mhj = '';
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
        $order_info->postscript = $postscript;
        $order_info->shipping_id = $shipping;
        $order_info->pay_id = $payment;
        $order_info->pay_name = $pay_name;
        $order_info->referer = trans('common.bz');
        $order_info->add_time = time();
        $order_info->confirm_time = time();
        $order_num = OrderInfo::where('order_status','!=',2)->where('user_id',$this->user->user_id)->count();
        if($order_num==0){
            $order_info->is_xkh = 1;
        }else{
            $order_info->is_xkh = 0;
        }
        $order_info->how_oos = trans('cart.how_oos');
        $order_info->goods_amount = $this->order['goods_amount'];
        $order_info->shipping_fee = $this->order['shipping_fee'];
        $order_info->surplus = $this->order['surplus'];
        $order_info->order_amount = $this->order['order_amount'];
        $order_info->jp_points = $this->order['jp_amount'];
        $order_info->zyzk = $this->order['zyzk'];
        $order_info->jnmj = $this->order['jnmj'];
        $order_info->pack_fee = $this->order['pack_fee'];
        $order_info->dzfp = $this->user->dzfp;
        $order_info->is_mhj = 0;
        $order_info->discount = $this->order['discount'];
        $order_info->is_zy = $this->order['is_zy'];
        $order_info->inv_content = is_null($this->user->question)?'':$this->user->question;
        $order_info->inv_payee = is_null($this->user->zq_ywy)?'':$this->user->zq_ywy;
        $order_info->card_name = is_null($this->user->answer)?'':$this->user->answer;
        $order_info->pack_id = is_null($this->user->sex)?'':$this->user->sex;

        /**
         * mycat
         */
        //$order_info = mycat_bc($order_info);
        if($this->user->shipping_id==0) {
            if ($shipping == -1) {//其他物流
                $shipping_name = $request->input('ps_wl');
                $order_info->shipping_name = $request->input('ps_wl');
                $order_info->wl_dh = $request->input('ps_dh');
                $this->user->shipping_id = -1;
                $this->user->shipping_name = $shipping_name;
                $this->user->wl_dh = $order_info->wl_dh;
                $this->user->save();
            } else {
                $shipping_name = Shipping::where('enabled', 1)->where('shipping_id', $shipping)->pluck('shipping_name');
                if (empty($shipping_name)) {
                    return view('message')->with(messageSys(trans('cart.wl'), route('cart.jiesuan'), [
                        [
                            'url' => route('cart.index'),
                            'info' => trans('common.backToCart'),
                        ],
                    ]));
                }
                if ($shipping == 13) {
                    if (empty($kf_name)) {
                        return view('message')->with(messageSys('请选择自提库房', route('cart.jiesuan'), [
                            [
                                'url' => route('cart.index'),
                                'info' => trans('common.backToCart'),
                            ],
                        ]));
                    } else {
                        $shipping_name .= '(' . $kf_name.')';
                    }
                }
                if ($shipping == 9) {
                    if (empty($area_name)) {
                        return view('message')->with(messageSys('请选择配送区域', route('cart.jiesuan'), [
                            [
                                'url' => route('cart.index'),
                                'info' => trans('common.backToCart'),
                            ],
                        ]));
                    } else {
                        $shipping_name .= $area_name;
                    }
                }
                $order_info->shipping_name = $shipping_name;
                if ($this->user->shipping_id == 0) {
                    $this->user->shipping_id = $shipping;
                    $this->user->shipping_name = $shipping_name;
                    $this->user->save();
                }
            }
        }else{
            $shipping_name = $this->user->shipping_name;
            $order_info->shipping_name = $this->user->shipping_name;
            $order_info->wl_dh = $this->user->wl_dh;
        }
        if($this->order['goods_amount']==$this->order['goods_amount_mhj']){//订单中只有麻黄碱
            $order_info->is_mhj = 1;
            $this->order['is_can_zq'] = false;
            $order_info->sign_building = $this->order['sign_building_mhj'];
        }else{
            if($this->order['is_no_mhj']==false){//含麻黄碱 要分单
                $fendan = true;
                $order_info_mhj = new OrderInfo();
                $order_info_mhj->order_sn = $order_sn.'_3';
                $order_info_mhj->user_id = $this->user->user_id;
                $order_info_mhj->msn = $this->user->msn;
                $order_info_mhj->ls_zpgly = $this->user->ls_zpgly;
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
                $order_info_mhj->postscript = $postscript;
                $order_info_mhj->shipping_id = $shipping;
                $order_info_mhj->pay_id = $payment;
                $order_info_mhj->pay_name = $pay_name;
                $order_info_mhj->referer = trans('common.bz');
                $order_info_mhj->add_time = time();
                $order_info_mhj->confirm_time = time();
                $order_info_mhj->is_xkh = 0;
                $order_info_mhj->goods_amount = $this->order['goods_amount_mhj'];
                $order_info_mhj->shipping_fee = 0;
                $order_info_mhj->surplus = 0;
                $order_info_mhj->order_amount = $this->order['order_amount_mhj'];
                $order_info_mhj->jp_points = $this->order['jp_amount_mhj'];
                $order_info_mhj->how_oos = trans('cart.how_oos');
                $order_info_mhj->zyzk = $this->order['zyzk_mhj'];
                $order_info_mhj->is_mhj = 1;
                $order_info_mhj->dzfp = $this->user->dzfp;
                $order_info_mhj->is_zy = $this->order['is_zy'];
                $order_info_mhj->inv_content = is_null($this->user->question)?'':$this->user->question;
                $order_info_mhj->inv_payee = is_null($this->user->zq_ywy)?'':$this->user->zq_ywy;
                $order_info_mhj->card_name = is_null($this->user->answer)?'':$this->user->answer;
                $order_info_mhj->pack_id = is_null($this->user->sex)?'':$this->user->sex;
                /**
                 * mycat
                 */
                //$order_info_mhj = mycat_bc($order_info_mhj);

                if($shipping==-1){//其他物流
                    $order_info_mhj->shipping_name = $order_info->shipping_name;
                    $order_info_mhj->wl_dh = $order_info->wl_dh;

                }else{
                    $order_info_mhj->shipping_name = $order_info->shipping_name;;
                }
                //原订单 金额 做出相应改动
                $order_info->goods_amount = $order_info->goods_amount-$order_info_mhj->goods_amount;


                $order_info->order_amount = $order_info->order_amount-$order_info_mhj->order_amount;
                $order_info->zyzk = $order_info->zyzk-$order_info_mhj->zyzk;
            }
        }
        if($this->order['is_can_zq']==true&&($this->user->zq_je-$this->user->zq_amount)>$order_info->order_amount){//能使用账期 且额度足够
            $order_info->is_zq = 1;
        }else{
            $order_info->is_zq = 0;
        }
        $flag = DB::transaction(function()use($order_info,$goods,$request,$order_info_mhj,$fendan,$rec_ids){//数据库事务插入订单
            if($order_info->jnmj>0){//使用充值余额支付
                $order_info->pay_name = '使用充值余额支付';
            }
            if($order_info->order_amount==0){
                $order_info->pay_status = 2;
                $order_info->pay_time = time();
                if($order_info->surplus>0){
                    $order_info->pay_name = '使用余额支付';
                }
            }

            $order_info->save();
            //dd($order_info);
            if($order_info->order_id>0) {
                if ($order_info->jnmj > 0) {//订单使用锦囊支付
                    log_jnmj_change($this->user_jnmj, 0 - $order_info->jnmj, '支付订单 ' . $order_info->order_sn);
                } elseif ($order_info->is_zq == 1) {//账期订单
                    log_zq_change($this->user, 0, $order_info->order_amount, '支付订单 ' . $order_info->order_sn);
                }
                $payLog = new PayLog();
                $payLog->order_amount = $order_info->order_amount;
                $payLog->order_type = 0;
                $payLog->is_paid = $order_info->pay_status == 2 ? 1 : 0;
                $order_info->payLog()->save($payLog);
                if ($fendan == true) {
                    $order_info_mhj->save();
                    $payLog = new PayLog();
                    $payLog->order_amount = $order_info_mhj->order_amount;
                    $payLog->order_type = 0;
                    $payLog->is_paid = $order_info_mhj->pay_status == 2 ? 1 : 0;
                    $order_info_mhj->payLog()->save($payLog);
                }
                $recId = array();//购物车商品记录id集合
                $a = [];
                foreach ($goods as $v) {
                    $recId[] = $v->rec_id;
                    $v->extension_code = 1;
                    if($this->order['discount']>0&&isset($v->is_zhekou)&&$v->is_zhekou==1){
                        $v->extension_code = $this->order['extension_code'];
                    }
                    if ($fendan == true && $v->goods->is_mhj) {//分单了
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
                            'extension_code' =>   $v->extension_code,
                        ];
                    }
                    if($v->goods->tsbz!='秒') {
                        $v->goods->goods_number = $v->goods->goods_number - $v->goods_number;
                        $a[] = [
                            'goods_id' => $v->goods->goods_id,
                            'goods_number' => $v->goods->goods_number,
                        ];
                    }

                    Redis::zremrangebyscore('goods_list', $v->goods_id, $v->goods_id);
                }
                //dd($insert_goods);
                Goods::updateBatch('ecs_goods', $a);
                Cart::whereIn('rec_id', $recId)->delete();//删除购物车
                if($this->order['ms_amount']>0){
                    $old_ms_goods = $this->ms->get_cart_goods();
                    foreach($old_ms_goods as $k=>$v){
                        if(in_array(0-$v->goods_id,$rec_ids)) {//提交订单中的商品减少库存
                            unset($old_ms_goods[$k]);
                        }
                    }
                    Cache::store('miaosha')->tags(['miaosha','cart','2016-11-03',$this->user->user_id])->forever('ms_goods',$old_ms_goods);
                }
                OrderGoods::insert($insert_goods);//插入订单商品
                $online = new OnlinePay();
                $online->update_time = time();
                $online->order_sn = $order_info->order_sn;
                $order_info->onlinePay()->save($online);
                /* 2015-6-15 为在线支付主动查询插入支付记录 */
                if ($fendan == true) {
                    $online_mhj = new OnlinePay();
                    $online_mhj->update_time = time();
                    $online_mhj->order_sn = $order_info_mhj->order_sn;
                    $order_info_mhj->onlinePay()->save($online_mhj);
                }
                if ($order_info->surplus > 0) {//记录余额变动
                    log_account_change($this->user->user_id, $order_info->surplus * (-1), 0, 0, 0, trans('cart.payOrder') . ' ' . $order_info->order_sn);  //2015-7-27
                }

                if($this->order['pack_fee']>0){//使用了pack_fee
                    $up_arr = [
                        'status'=>1,
                        'order_id'=>$order_info->order_id,
                        'use_time'=>time(),
                    ];
                    YouHuiQ::whereIn('yhq_id',$this->order['yhq_ids'])->update($up_arr);
                }

                $this->order = $this->hdcx->create_yhq($order_info,$this->order,$this->user,1);

            }else{
                return -1;
            }
        });
        if($flag==-1){
            return view('message')->with(messageSys('订单购买失败',route('cart.index'),[
                [
                    'url'=>route('cart.index'),
                    'info'=>trans('common.backToCart'),
                ],
            ]));
        }

        @$this->toErp($order_info,$this->user);
        $order = [
            'goods_amount'=>$this->order['goods_amount'],
            'zyzk'=>$this->order['zyzk'],
            'discount'=>$this->order['discount'],
            'order_amount'=>$this->order['order_amount'],
            'surplus'=>$this->order['surplus'],
            'shipping_fee'=>$this->order['shipping_fee'],
            'pay_name'=>$order_info->pay_name,
            'shipping_name'=>$shipping_name,
            'order_sn'=>$order_sn,
            'order_id'=>$order_info->order_id,
            'jnmj'=>$order_info->jnmj,
            'pack_fee'=>$order_info->pack_fee,
        ];
        if($order_info->is_zq==1){
            $order['pay_name'] = '月结';
        }
        $onlinePay = '';
        if($fendan==true){//分单了
            @$this->toErp($order_info_mhj,$this->user);
            $order['order_sn_mhj'] = $order_sn.'_3';
            $order['order_id_mhj'] = $order_info_mhj->order_id;
            $order['pay_name'] .= ' '.$order_info_mhj->pay_name;
        }elseif($this->order['order_amount']>0&&empty($order_info_mhj)){
            /**
             * 支付限制
             */
            $status = pay_xz($order_info);
            if($status==true) {
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
                <input id='J_payonline' style='left: 250px;;' value='立即支付' type='submit' onclick='toSearch($(this))' searchUrl='" . route('xyyh.search', ['id' => $order_info->order_id,'bank'=>5,'type'=>0]) . "'>
               <input value='" . $order_info->order_id . "' name='id' type='hidden'>
              <input value='5' name='bank' type='hidden'>
              <input value='0' name='type' type='hidden'>
                </form>";
                }elseif ($payment == 6) {//兴业银行
                    //Cache::tags(['user',$this->user->user_id])->flush();
                    $onlinePay = "
                <form style='text-align:center;'  id='pay_form'
                 action='" . route('xyyh.pay') . "' method='get' target='_blank'>
                <input id='J_payonline' style='left: 250px;;' value='立即支付' type='submit'  onclick='toSearch($(this))' searchUrl='" . route('xyyh.search', ['id' => $order_info->order_id,'type'=>0]) . "'>
               <input value='" . $order_info->order_id . "' name='id' type='hidden'>
                <input value='0' name='type' type='hidden'>
                </form>";
                }elseif ($payment == 7) {//兴业银行
                    //Cache::tags(['user',$this->user->user_id])->flush();
                    $onlinePay = '
                <form style="text-align:center;" id="pay_form" action="' . route('weixin.pay') . '" method="get">
                <input id="J_payonline" style="left: 250;;" value="立即支付" type="button" onclick="weixin()" searchUrl="' . route('weixin.search', ['id' => $order_info->order_id,'type'=>0]) . '">
                <input value="' . $order_info->order_id . '" name="id" type="hidden">\
                <input value="0" name="type" type="hidden">
                </form>
                <script>
                function weixin(){
                    var mask = $("<div class=mask></div>");
                    $("body").append(mask);
                    $.ajax({
                        url:"' . route('weixin.pay', ['id' => $order_info->order_id,'type'=>0]) . '",
                        type:"get",
                        dataType:"json",
                        success:function(data){
                            $("body").find(".mask").remove();
                            if(data.status === 500){
                                alert(data.msg);
                            }
                            else if(data.status === 200){
                                window.location="' . route('user.payOk', ['id' => $order_info->order_id]) . '";
                            }
                            else{
                                $("#code_img_url").attr("src",data.code_img_url);
                                $(".pop-wraper").show();
                                int = setInterval("search_weixin()", 3000)
                            }
                        }
                    })
                }
                function search_weixin(){
                    $.ajax({
                        url:"'.route('weixin.search', ['id' => $order_info->order_id]).'",
                        type:"get",
                        dataType:"json",
                        success:function($result){
                            if($result==7){
                                 window.location="' . route('user.payOk', ['id' => $order_info->order_id]) . '";
                            }
                        }
                    });
                }
                </script>
                ';
                }elseif($payment == 8){
                    $onlinePay = "
                <form style='text-align:center;'  id='pay_form'
                 action='" . route('xyyh.pay') . "' method='get' target='_blank'>
                <input id='J_payonline' style='left: 250px;width:135px;' value='支付宝扫码支付' type='button'>
                </form>
                <div id='zfbsm' style='display:none;position:absolute;left:340px;;top:-221px;'>
                <img style='width:190px;height:250px;' src='".get_img_path('images/zfbsm.jpg')."'/></div>
                <script>
                $('#J_payonline').hover(function(){
                    $('#zfbsm').show();
                },function(){
                    $('#zfbsm').hide();
                });
                </script>

                ";
                }
            }
        }
        $assign = [
            'page_title' => trans('cart.orderOk').'-',
            'order' => $order,
            'onlinePay' => $onlinePay,
        ];
        $assign['cartStep'] = "
                <li><img src='".asset('images/cart_03.png')."'/></li>
                <li><img src='".asset('images/confirm2.png')."'/></li>
                <li><img src='".asset('images/order22.png')."'/></li>
                ";
        return view('orderOk')->with($assign);



    }
    /*
     * 删除购物车中的商品
     */
    public function dropCart(Request $request){
        $this->user = Auth::user();
        $id = $request->input('id');
        if($id<0){
            $ms_goods = $this->ms->get_cart_goods();
            foreach($ms_goods as $k=>$v){
                if($v->goods_id==-$id){
                    unset($ms_goods[$k]);
                    Cache::store('miaosha')->tags(['miaosha','cart','2016-11-03',$this->user->user_id])->forget($v->goods_id);
                }
            }
            Cache::store('miaosha')->tags(['miaosha','cart','2016-11-03',$this->user->user_id])->forever('ms_goods',$ms_goods);
            if(count($ms_goods)==0) {
                Cache::store('miaosha')->tags(['miaosha', 'cart', '2016-11-03', $this->user->user_id])->forget('team');
            }
            return redirect()->back();
        }
        $cart = Cart::findOrfail($id);
        $this->authorize('update-post',$cart);
        if($cart->delete()){
            Cache::tags([$this->user->user_id,'cart'])->decrement('num');
            return redirect()->back();
        }
    }
    /*
     * 移动到收藏
     */
    public function dropToCollect(Request $request){
        $this->user = Auth::user();
        $id = $request->input('id');
        if($id<0){
            $ms_goods = $this->ms->get_cart_goods();
            foreach($ms_goods as $k=>$v){
                if($v->goods_id==-$id){
                    unset($ms_goods[$k]);
                    Cache::store('miaosha')->tags(['miaosha','cart','2016-11-03',$this->user->user_id])->forget($v->goods_id);
                }
            }
            Cache::store('miaosha')->tags(['miaosha','cart','2016-11-03',$this->user->user_id])->forever('ms_goods',$ms_goods);
            if(count($ms_goods)==0) {
                Cache::store('miaosha')->tags(['miaosha', 'cart', '2016-11-03', $this->user->user_id])->forget('team');
            }
            return redirect()->back();
        }
        DB::transaction(function()use($id){
            $goods_id = Cart::select('rec_id','user_id','goods_id')->findOrFail($id);
            $this->authorize('update-post',$goods_id);
            $goods_id->delete();
            Cache::tags([$this->user->user_id,'cart'])->decrement('num');
            $collectGoods = CollectGoods::where('goods_id',$goods_id->goods_id)->where('user_id',$this->user->user_id)->first();
            if(!$collectGoods) {
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
    public function dropCartMany(Request $request){
        $this->user = Auth::user();
        $id = $request->input('id');
        $id = rtrim($id,'_');
        $id = explode('_',$id);
        $ms_goods = $this->ms->get_cart_goods();
        if(count($ms_goods)>0) {
            foreach ($ms_goods as $k => $v) {
                if (in_array(0 - $v->goods_id, $id)) {
                    unset($ms_goods[$k]);
                    Cache::store('miaosha')->tags(['miaosha', 'cart', '2016-11-03', $this->user->user_id])->forget($v->goods_id);
                }
            }
        }
        Cache::store('miaosha')->tags(['miaosha','cart','2016-11-03',$this->user->user_id])->forever('ms_goods',$ms_goods);
        if(count($ms_goods)==0) {
            Cache::store('miaosha')->tags(['miaosha', 'cart', '2016-11-03', $this->user->user_id])->forget('team');
        }
        if(Cart::whereIn('rec_id',$id)->where('user_id',$this->user->user_id)->delete()){
            Cache::tags([$this->user->user_id,'cart'])->decrement('num',count($id));
            return redirect()->back();
        }
        return redirect()->back();
    }


    /*
     * 传输订单到 erp 中
     */
    private function toErp($order){
        //如果能连接上中间数据库，则插入erp
        $host = '171.221.207.113';

        $port = '3395';

        $num = 1; //Ping次数
        $fp = @fsockopen($host,$port,$errno,$errstr,1);
        $type = 0;
        if(!$fp){
            $type = 0;//链接超时
        }else{
            $type = 1;//链接上
        }

        fclose($fp);

        if($type == 1&&env('TRANS',true)==true) {
            if (!empty($order)) {
                @$this->sync_orderinfo_to_erp($order,$this->user);
            }
        }
    }

    private function sync_orderinfo_to_erp($order){
        $xf_ids = [];//使用现付的会员
//        $order_sn = str_replace('_3','',$order['order_sn']);
//        $this->goods_amount = OrderInfo::where('order_sn','like','%'.$order_sn.'%')->sum('goods_amount');//获取未分单前的总金额
        if (($order->province == 26 && $this->order['goods_amount'] >= 800)||in_array($order->user_id,$xf_ids)) {
            $fkfs = '现付';
        } else {
            $fkfs = '提付';
        }
        if(strpos($order->shipping_name, '申通') !== false) {
            $order->shipping_name = '成都申通快递实业有限公司郫县营业部' ;
        } elseif (strpos($order->shipping_name, '腾林物流') !== false) {
            $order->shipping_name = '四川腾林物流有限公司' ;
        } elseif (strpos($order->shipping_name, '余氏东风') !== false) {
            $order->shipping_name = '四川佳迅物流有限公司（余氏东风）' ;
        } elseif (strpos($order->shipping_name, '三江物流') !== false) {
            $order->shipping_name = '成都市三江运发货运有限公司' ;
        } elseif (strpos($order->shipping_name, '国通物流(送货上门)') !== false) {
            $order->shipping_name = '成都嘉宣物流有限公司（四川国通（增益）物流）' ;
        } elseif (strpos($order->shipping_name, '增益速递') !== false) {
            $order->shipping_name = '成都嘉宣物流有限公司（四川国通（增益）物流）' ;
        } elseif (strpos($order->shipping_name, '飞马货运') !== false) {
            $order->shipping_name = '飞马快运' ;
        } elseif (strpos($order->shipping_name, '东臣物流') !== false) {
            $order->shipping_name = '四川东臣物流有限公司' ;
        } elseif (strpos($order->shipping_name, '成昌信物流') !== false) {
            $order->shipping_name = '成都成昌信物流有限公司' ;
        } elseif (strpos($order->shipping_name, '光华托运部') !== false) {
            $order->shipping_name = '成都市光华托运部' ;
        } elseif (strpos($order->shipping_name, '鑫海洋') !== false) {
            $order->shipping_name = '四川鑫海洋货运代理有限公司' ;
        } elseif (strpos($order->shipping_name, '筋斗云') !== false) {
            $order->shipping_name = '新疆筋斗云物流有限责任公司成都分公司' ;
        } elseif (strpos($order->shipping_name, '力展') !== false) {
            $order->shipping_name = '四川力展物流有限责任公司' ;
        } elseif (strpos($order->shipping_name, '宇鑫物流') !== false) {
            $order->shipping_name = '成都宇鑫物流有限公司' ;
        } elseif (strpos($order->shipping_name, '宅急送') !== false) {
            $order->shipping_name = '成都宅急送快运有限公司' ;
        }

        //收货地址
        $province = Cache::tags(['shop','region'])->rememberForever(1,function(){
            return Region::where('parent_id',1)->get();
        })->find($order->province);
        $city = Cache::tags(['shop','region'])->rememberForever($order->province,function()use($order){
            return Region::where('parent_id',$order->province)->get();
        })->find($order->city);
        $district = Cache::tags(['shop','region'])->rememberForever($order->city,function()use($order){
            return Region::where('parent_id',$order->city)->get();
        })->find($order->district);
        if(empty($district)){
            $district = Region::find($order->district);
        }

        $add_dz = $province->region_name.$city->region_name.$district->region_name.$order->address;
        $order->order_sn = trim($order->order_sn);

        $fpfs_type = array('增值税普通发票','纸制发票','增值税专用发票');
        $fpfs = $fpfs_type[$this->user->dzfp];

        if($order->is_zq==1){//账期会员的账期订单
            $fukfs = '月结';
            $ywy = $this->user->zq_ywy;

            if(empty($ywy)){//账期业务员为空 读取otc客服
                $gly_arr = explode('.',$this->user->ls_zpgly);
                $otc_admin = AdminUser::whereIn('user_name',$gly_arr)
                    ->whereIn('role_id',[22,31])->pluck('user_name');
                $ywy = $otc_admin;

            }
        }
        else{
            $fukfs = '预付';
            if(empty($this->user->zq_ywy)) {
                $ywy = '药易购';
            }else{
                $ywy = $this->user->zq_ywy;
            }
        }

        $zk = "ZKZ00000003";
        if($order->jnmj>0) {//订单使用锦囊支付
            $jnmj = UserJnmj::where('user_id',$this->user->user_id)->pluck('jnmj_zk');
            if(!empty($jnmj)){
                if($jnmj==95){
                    $zk = "ZKZ00000001";
                }elseif($jnmj==92){
                    $zk = "ZKZ00000002";
                }
            }
        }


        $goods_list = $order->order_goods;

        $in_order = array(
            'order_id' => $order->order_sn,
            'order_num' => count($goods_list),
            'khinf_id' => $this->user->wldwid,
            'khinf_id1' => $this->user->wldwid1,
            'khinf_dh' => empty($order->tel)?$order->mobile:$order->tel,
            'lgistics_name' => $order->shipping_name,
            'lgistics_dh' => $order->wl_dh,
            'address' => $add_dz,
            'shr' => $order->consignee,
            'fkfs' => $fkfs,
            'beizhu' => $order->consignee.' '.$order->sign_building,
            'zp-zb' => 1,
            'fpfs' => $fpfs,
            'fukfs' => $fukfs,
            'ywy' => $ywy,
            'zk' => $zk,
            'zkljs' => 0,
        );
        $in_goods = [];
        foreach ($goods_list as $k => $v) {
            if (strpos(strtolower($v->tsbz), 'z') !== false) {
                $zp = 0;
            } else {
                $zp = 1;
            }

            //2016-03-14
            if($v->zyzk > 0) {
                $v->goods_price = $v->goods_price - $v->zyzk ;
            }

            if($v->extension_code>0) {
                $v->goods_price = round($v->goods_price * $v->extension_code, 2);
            }

            $val = array(
                'order_sn' => $k + 1,
                'sponfo_id' => $v->goods()->pluck('ERPID'),
                'ckinf_id' => $v->ckid,
                'order_sl' => $v->goods_number,
                'oreder_jg' => $v->goods_price,
                'uug_spbh' => $v->rec_id,
                'zp_dp' => $zp,
            );
            $in_goods[$k] = $val;
        }

        if($in_order['order_num']>0) {
            $this->to_webservice($in_order,$in_goods);
        }
    }

    private function to_webservice($order,$goods){
        $val = "<DATA><HZ>
<ORDER_ID>".$order['order_id']."</ORDER_ID>
<ORDER_NUM>".$order['order_num']."</ORDER_NUM>
<KHINFO_ID>".$order['khinf_id']."</KHINFO_ID>
<KHINFO_ID1>".$order['khinf_id1']."</KHINFO_ID1>
<KHINFO_DH>".$order['khinf_dh']."</KHINFO_DH>
<LGISTICS_NAME>".$order['lgistics_name']."</LGISTICS_NAME>
<LGISTICCS_DH>".$order['lgistics_dh']."</LGISTICCS_DH>
<ADDRESS>".$order['address']."</ADDRESS>
<SHR>".$order['shr']."</SHR>
<FKFS>".$order['fkfs']."</FKFS>
<BeiZhu>".$order['beizhu']."</BeiZhu>
<ZP_ZB>".$order['zp-zb']."</ZP_ZB>
<FPFS>".$order['fpfs']."</FPFS>
<FUKFS>".$order['fukfs']."</FUKFS>
<YWY>".$order['ywy']."</YWY>
<ZKID>".$order['zk']."</ZKID>
<ZKLJS>".$order['zkljs']."</ZKLJS>
</HZ>
<LIST>";
        $str = '';
        foreach($goods as $v){
            $str .= "<MX>
<ORDER_SN>".$v['order_sn']."</ORDER_SN>
<SPINFO_ID>".$v['sponfo_id']."</SPINFO_ID>
<CKINFO_ID>".$v['ckinf_id']."</CKINFO_ID>
<ORDER_SL>".$v['order_sl']."</ORDER_SL>
<ORDER_JG>".$v['oreder_jg']."</ORDER_JG>
<YYG_SPBH>".$v['uug_spbh']."</YYG_SPBH>
<ZP_DP>".$v['zp_dp']."</ZP_DP>
</MX>";
        }
        $str = $val.$str.'</LIST></DATA>';
        //dd($str,$order,$goods);
        $client = new SoapClient('http://171.221.207.113:3395/cszjc/webservice/cxfService?wsdl');
        //dd($client,$str,$order,$goods);
        //if(auth()->user()->user_id==13960||auth()->user()->user_id==18864) {
        $client->setOrder(array('param' => $str));
        //}
    }

    /**
     * 判断账期是否逾期 逾期不能购买
     */
    private function check_zq(){
        $result = [
            'error'=>0,
            'msg'=>'',
        ];
        if($this->user->is_zq==0&&($this->user->zq_has==1||$this->user->zq_amount>0)){

            $result['error'] = 1;
            $result['msg'] = '账期未结清,请结清后再购买!';
        }
        if($this->user->hz_zq==1||$this->user->zq_has==1){
            if($this->user->hz_zq==1){
                $tishi = '合纵线下';
            }else{
                $tishi = '上月';
            }
            $result['error'] = 1;
            $result['msg'] = $tishi.'账期未结清,请结清后再购买!';
        }
        return $result;
    }

    private function order_amount(){
        $this->order['order_amount'] = $this->order['goods_amount'] + $this->order['shipping_fee'] -$this->order['zyzk']
            - $this->order['discount'] - $this->order['surplus'] - $this->order['jnmj']
            - $this->order['pack_fee'] - $this->order['money_paid'];
        $this->order['order_amount_mhj'] = $this->order['goods_amount_mhj'] - $this->order['zyzk_mhj'];
    }
    private function surplus(){
        if($this->order['is_no_mhj']==true&&$this->order['is_can_zq']==false&&$this->order['is_can_use_jnmj']==false&&$this->user->user_money>0){
            $this->order['surplus'] = min([$this->user->user_money,$this->order['order_amount']]);
        }
        $this->order_amount();
    }

}



