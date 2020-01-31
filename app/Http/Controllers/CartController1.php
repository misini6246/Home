<?php

namespace App\Http\Controllers;

use App\Ad;
use App\AdminUser;
use App\Attribute;
use App\Cart;
use App\CollectGoods;
use App\erp\Order;
use App\GiftGoods;
use App\Goods;
use App\HgGoods;
use App\Http\Controllers\Huodong\QiXi;
use App\UserJnmj;
use App\GoodsStock;
use App\OnlinePay;
use App\OrderGoods;
use App\erp\OrderGoods as erpOg;
use App\OrderInfo;
use App\PayLog;
use App\Region;
use App\ShippingArea;
use App\UserAddress;
use App\YouHuiQ;
use App\ZqLog;
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
require_once app_path() . '/Common/goods.php';

class CartController extends Controller
{

    use QiXi;

    private $user;

    private $user_jnmj;

    private $total_amount=0;

    private $goods_amount=0;

    private $goods_amount_mhj=0;

    private $shipping_fee=0;

    private $discount=0;

    private $surplus=0;

    private $order_amount=0;

    private $zy_amount=0;

    private $fzy_amount=0;

    private $extension_code=1;

    private $is_can_zq;

    private $is_can_use_jnmj;

    private $tsbz_a_amount=0;

    private $assign;

    private $pack_fee=0;

    private $yhq_id=0;

    private $is_xkh_tj=0;

    private $yhq_ty = 0;//优惠券通用金额

    private $yhq_zy = 0;//优惠券中药金额

    private $yhq_fzy = 0;//优惠券中药金额
    /*
     * 中间件
     */
    public function __construct(){
        $this->middleware('jiesuan', ['only' => 'jiesuan']);//结算验证
        $this->middleware('cartNum', ['only' => ['jiesuan','order']]);//结算验证
        $this->user = auth()->user()->is_new_user();
        $this->user_jnmj = UserJnmj::where('user_id',$this->user->user_id)->first();
        $this->xztj();
        if($this->user->is_zq == 1){
            $this->is_can_zq = true;//可以使用账期
        }else{
            $this->is_can_zq = false;//可以使用账期
        }
        $this->is_can_use_jnmj = true;
        $this->assign = [];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->is_new_user();
        //为您推荐
        $wntj = Goods::rqdp('is_wntj',10,-4);
        $wntj = goods_list($user,$wntj);
        if(1==2) {
            $cart = Cart::get_cart_goods($user);
            $cart = goods_list($user,$cart, 0, 'goods_list', true);
        }else{
            $cart = Cart::get_cart_goods_l($user);
        }
        $total = array();
        $total['jp_total_amount'] = 0;
        $total['shopping_money'] = 0;
        $orderstr = "";
        $delId = [];
        $tip_info = [];
        $price = [];//需要更新的商品价格
        $cache_cart = [];//缓存购物车
        $up_num_arr = [];
        $up_price_arr = [];
        $xkh_num = 0;
        $goods_ids = [];





        foreach($cart as $k=>$v){
            Redis::zremrangebyscore('goods_list', $v->goods->goods_id, $v->goods->goods_id);
            $v->goods = Goods::area_xg($v->goods,$user);
            $v->is_can_change = 1;
            //llPrint($v,2);
            if($v->goods->is_can_buy==0){
                $v->message = $v->goods->goods_name."商品限购";
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
            elseif($v->goods->hy_price>0&&$user->hymsy==0){//非哈药会员不能购买哈药

                $delId[] = $v->rec_id;

                unset($cart[$k]);;
            }
            elseif(strpos($v->goods->cat_ids, '180') !== false && $user->mhj_number == 0){//麻黄碱
                $v->message = $v->goods->goods_name.trans('cart.mhj');
                $delId[] = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);;
            }
            else {
//                if($v->goods->is_cx==1&&$v->goods->is_xkh_tj==1&&$user->is_new_user==true){//新客户特价商品
//                    if($xkh_num>=5){//多余的新客户商品删除
//                        $delId[] = $v->rec_id;
//                        unset($cart[$k]);;
//                    }else {
//                        $xkh_num++;
//                    }
//                }

                $up_price = [];
                $up_num = [];
                $zbz = isset($v->goods->zbz)?$v->goods->zbz:1;
                $jzl = isset($v->goods->jzl)?intval($v->goods->jzl):0;
                $old_num = $v->goods_number;
                $result = final_num($v->goods->xg_num,$jzl,$zbz,$v->goods->goods_number,$old_num);
                $v->goods_number = $result['goods_number'];
//                if(($v->goods_number%$zbz)!=0) {//不为中包装整数倍
//                    $v->goods_number = ceil($v->goods_number/$zbz) * $zbz;
//                }
//                if($jzl){//件装量存在
//                    if(($v->goods_number%$jzl)/$jzl>=0.8){//超过件装量80%
//                        $v->goods_number = ceil($v->goods_number/$jzl)*$jzl;
//                        if($v->goods_number>$v->goods->goods_number) {//购物车数量大于商品数量
//                            $v->goods_number = ceil($v->goods_number/$v->goods->jzl)*$v->goods->jzl - ceil($v->goods->jzl*0.2);
//                        }
//                    }
//                }
//                if($v->goods_number>$v->goods->goods_number){//购物车数量大于商品数量
//                    $v->goods_number = $v->goods->goods_number;
//                    if($zbz&&($v->goods_number%$zbz)!=0){//中包装存在 且不为中包装整数倍
//                        $v->goods_number = floor($v->goods_number/$zbz) * $zbz;
//                    }
//                }


                $orderstr .= $v->rec_id . '_';
                if($v->goods->real_price!=$v->goods_price){
                    $up_price['rec_id'] = $v->rec_id;
                    $up_price['goods_price'] = $v->goods->real_price;
                }
//                if($v->goods_number>$v->goods->xg_num&&$v->goods->xg_num>0){//超出限购数量
//                    $v->goods_number = $v->goods->xg_num;
//                }
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
                    $total['jp_total_amount'] += $v->goods->real_price * $v->goods_number;
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
                    $total['shopping_money'] += $v->goods->real_price * $v->goods_number;
                }
            }
        }

        /**
         * 获取秒杀商品
         */
        $miaosha = new MiaoShaController();
        $ms_goods = $miaosha->get_cart_goods();
        if(!empty($ms_goods)) {
            foreach ($ms_goods as $k=>$v) {
                if (isset($goods_ids[$v->goods->goods_id])) {
                    foreach($cart as $key=>$val){
                        if($val->goods_id==$v->goods->goods_id) {
                            $delId[] = $val->rec_id;
                            unset($cart[$key]);
                            $total['shopping_money'] -= $val->goods->real_price * $val->goods_number;
                        }
                    }
                } else {
                    $goods_ids[$v->goods->goods_id] = 1;
                    $total['shopping_money'] += $v->goods->real_price * $v->goods_number;
                }
                $cart[] = $v;
            }
        }
        if(!empty($delId)) {
            Cart::destroy($delId);
            Cache::tags([$user->user_id,'cart'])->decrement('num',count($delId));
        }
        if(!empty($up_price_arr)){
            //dd($price);
            Goods::updateBatch('ecs_cart',$up_price_arr);
        }
        if(!empty($up_num_arr)){
            //dd($price);
            Goods::updateBatch('ecs_cart',$up_num_arr);
        }
        //dd($cache_cart);
        Cache::tags([$user->user_id,'cart'])->forever('cart_list',$cache_cart);
        //llPrint($cart,2);
        //Cart::whereIn('rec_id',$delId)->where('user_id',$user->user_id)->delete();
        //Cache::tags('cart_'.$user->user_id)->forever('total',$total);
        $total['jp_total_amount'] = sprintf('%.2f',$total['jp_total_amount']);
        $total['shopping_money'] = sprintf('%.2f',$total['shopping_money']);
        $this->assign['page_title'] = trans('common.cart').'-';
        $this->assign['goods_list'] = $cart;
        $this->assign['tip_info'] = $tip_info;
        $this->assign['total'] = $total;
        $this->assign['wntj'] = $wntj;
        $this->assign['cartStep'] = "
        <li><img src='".asset('images/cart_03.png')."'/></li>
        <li><img src='".asset('images/cart_04.png')."'/></li>
        <li><img src='".asset('images/cart_04.png')."'/></li>
        ";
        return view('cart')->with($this->assign);
    }
    /*
     * 加密跳转
     */
    public function checkout(Request $request){
        $orderstr = $request->input('orderstr');
        //Cache::tags('orderstr')->forever(auth()->user()->user_id,$orderstr,1);
        $request->session()->put('orderstr'.auth()->user()->user_id,$orderstr);
        return redirect()->route('cart.jiesuan');
    }
    /*
     * 结算
     */
    public function jiesuan(Request $request)
    {
        $user = auth()->user()->is_new_user();
        if($user->is_zq==0&&($user->zq_has==1||$user->zq_amount>0)){
            return view('message')->with(messageSys('账期未结清,请结清后再购买!', route('cart.index'), [
                [
                    'url' => route('cart.index'),
                    'info' => trans('common.backToCart'),
                ],
            ]));
        }
        if($user->hz_zq==1||$user->zq_has==1){
            if($user->hz_zq==1){
                $tishi = '合纵线下';
            }else{
                $tishi = '上月';
            }
            return view('message')->with(messageSys($tishi.'账期未结清,请结清后再购买!', route('cart.index'), [
                [
                    'url' => route('cart.index'),
                    'info' => trans('common.backToCart'),
                ],
            ]));
        }

        $user_jnmj = UserJnmj::where('user_id',$user->user_id)->first();
        $addressId = $user->address_id;
        $rec_ids = Cache::tags([$user->user_id,'cart'])->get('cart_list');
        if(1==2) {
            $goods = Cart::get_cart_goods($user,$rec_ids);
            $goods = goods_list($user,$goods,0,'goods_list',true);
        }else{
            $goods = Cart::get_cart_goods_l($user,$rec_ids);
        }
        if(!$rec_ids){
            return view('message')->with(messageSys('不能重复提交订单',route('cart.index'),[
                [
                    'url'=>route('cart.index'),
                    'info'=>'返回购物车',
                ],
            ]));
        }
        //dd($goods);
        $this->goods_amount = 0;//商品总额
        $this->goods_amount_mhj = 0;//麻黄碱商品总额
        $zyzk = 0;//优惠金额
        $zyzk_mhj = 0;//优惠金额麻黄碱
        $shipping_fee = 0;
        $this->discount = 0;
        $surplus = 0;

        /**
         * 活动相关开始
         */
        $jp_amount = 0;//精品金额
        $zyyp_amount = 0;//中药饮片金额
        $zk_total = 0;//折扣商品总金额
        $is_no_mhj = true;//不含麻黄碱
        $is_no_hy = true;//不含哈药
        $is_no_tj = true;//不含特价
        $is_no_zyzk = true;//不含优惠商品
        if($user->is_zq==0){
            $this->is_can_zq = false;
        }

        $hg_goods = [];
        $jehg_amount = 0;//商品换购的金额排除掉
        $hg_type = 0;//换购类型 0不换购 1商品换购 2金额换购
        $check_ids = Ad::check_ids();
        /**
         * 活动相关结束
         */
        foreach($goods as $k=>$v){

            $v->goods = Goods::area_xg($v->goods,$user);

            $message = Goods::check_cart($v->goods,$user);
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
             * 活动相关开始
             */
            /**
             * 换购
             */
            if($v->goods->is_hg==1){//商品换购 而且账期结清

                $num = $v->goods_number;
                $hg = HgGoods::where('num','<=',$num)->where('goods_id',$v->goods->goods_id)->where('type',0)->orderBy('num','desc')->first();
                if($hg) {
                    $hg->goods = Goods::where('goods_id',$hg->hg_goods_id)->first();
                    if($hg->hg_goods_number<=$hg->goods->goods_number) {
                        $hg_goods[] = $hg;
                        $this->is_can_zq = false;//不能使用账期
                        $this->assign['hg_amount'] = $hg->hg_goods_price*$hg->hg_goods_number;
                        $hg_type = 1;
                    }
                    //dd($hg_goods);
                }
            }

//            if($v->goods->goods_id!=19650&&$v->goods->is_cx==0){
//                $jehg_amount += $v->goods->real_price*$v->goods_number;
//            }
//            if($v->goods->goods_id!=20728&&$v->goods->is_cx==0&&$v->goods->is_zyyp==0){
//                $jehg_amount += $v->goods->real_price*$v->goods_number;
//            }
            if($v->goods->goods_id!=3294&&$v->goods->goods_id!=16348){
                $jehg_amount += $v->goods->real_price*$v->goods_number;
            }
            $v->is_can_zk = 1;//可以参加折扣活动
            if($v->goods->is_mhj==1){//麻黄碱商品
                $is_no_mhj = false;//含麻黄碱
                $v->is_can_zk = 0;
                $this->goods_amount_mhj += $v->goods->real_price*$v->goods_number;
            }

            if($v->goods->is_cx==1){//特价
                $is_no_tj = false;//含特价
                $v->is_can_zk = 0;
                if(!in_array($v->goods->goods_id,$check_ids)){
                    $this->is_can_zq = false;
//                    if($user->zq_amount>0){
//                        return view('message')->with(messageSys('有未付款账期订单,不能购买特价商品!',route('cart.index'),[
//                            [
//                                'url'=>route('cart.index'),
//                                'info'=>trans('common.backToCart'),
//                            ],
//                        ]));
//                    }
                }
                if($v->goods->is_xkh_tj==1){//新客户特价
                    $this->is_xkh_tj = 1;
                }
            }

            if(strpos($v->goods->product_name,'哈药')!==false||$v->goods->hy_price>0){//哈药
                $is_no_hy = false;//含哈药
                $v->is_can_zk = 0;
            }

            if($v->goods->goods_id==3048){//哈药
                $is_no_hy = false;//含哈药
                $v->is_can_zk = 0;
            }

            if($v->goods->is_jp==1){//精品
                $jp_amount += $v->goods->real_price * $v->goods_number;
            }

            if($v->goods->zyyp==1){//中药饮片
                $zyyp_amount += $v->goods->real_price * $v->goods_number;
            }

            if($user->is_zhongduan==1){//终端用户
                $v->goods->zyzk = Goods::check_zyzk($v->goods,$user);
                $zyzk += $v->goods->zyzk*$v->goods_number;
                if($v->goods->is_mhj==1){
                    $zyzk_mhj += $v->goods->zyzk*$v->goods_number;
                }
            }

            if($v->goods->zyzk>0){//优惠金额商品
                $v->is_can_zk = 0;
                $is_no_zyzk = false;
            }

            if($v->is_can_zk==1){//可以参加折扣
                $zk_total += $v->goods->real_price*$v->goods_number;
            }

            /**
             * 活动相关结束
             */

            $this->goods_amount += $v->goods->real_price*$v->goods_number;

            $v->subtotal = $v->goods->real_price*$v->goods_number;

            if($v->goods->is_zyyp==1){
                $this->zy_amount += $v->subtotal;
            }else{
                $this->fzy_amount += $v->subtotal;
            }
            if(isset($v->tsbz_a)) {
                if ($v->tsbz_a == 1) {
                    $this->tsbz_a_amount += $v->subtotal;
                }
            }

            /**
             * 计算优惠券金额
             */
            if($v->goods->is_cx==0&&$v->goods->is_mhj==0){
                if($v->goods->is_zyyp==1){//中药
                    $this->yhq_zy += ($v->goods->real_price-$v->goods->zyzk)*$v->goods_number;
                }else{//非中药
                    $this->yhq_fzy += ($v->goods->real_price-$v->goods->zyzk)*$v->goods_number;
                }
                $this->yhq_ty += ($v->goods->real_price-$v->goods->zyzk)*$v->goods_number;
            }

        }

        /**
         * 获取秒杀商品
         */
        $miaosha = new MiaoShaController();
        $ms_goods = $miaosha->get_cart_goods($rec_ids,false);
        if(!empty($ms_goods)) {
            $ms_amount = $ms_goods->goods_amount;
            if ($ms_amount > 0) {
                $this->is_can_use_jnmj = false;
                $this->is_can_zq = false;
            }
            foreach ($ms_goods as $v) {
                $goods[] = $v;
            }
        }else{
            $ms_amount = 0;
        }
        //dd($goods);
        $this->zy_discount();
        $type1 = $this->zy_hg();
        $type2 = $this->fzy_hg();
        $this->tsbz_a_discount();
        $this->goods_amount = $goods->sum('subtotal') + $ms_amount;

        $this->goods_amount = $this->goods_amount + $type1->num*$this->hg_price + $type2->num*$this->hg_price;

        $this->assign['type1'] = $type1;
        $this->assign['type2'] = $type2;
        $this->assign['zy_amount'] = $this->zy_amount;
        $this->assign['fzy_amount'] = $this->fzy_amount;
        $this->assign['xztj'] = $this->xztj;

        //限购金额
        if($this->goods_amount<shopConfig('min_goods_amount')){
            return view('message')->with(messageSys(trans('cart.minMoney').' '.formated_price(shopConfig('min_goods_amount')).'，'.trans('cart.cannot').'。',route('cart.index'),[
                [
                    'url'=>route('cart.index'),
                    'info'=>trans('common.backToCart'),
                ],
            ]));
        }

        /**
         * 金额换购
         * @params 不存在商品换购 不存在充值金额 不存在未还清账期 四川终端
         */
        //if(empty($hg_goods)&&(!$user_jnmj||($user_jnmj&&$user_jnmj->jnmj_amount==0))&&$user->zq_amount==0&&($user->province==26||$user->province==28||$user->province==29)&&$user->is_zhongduan==1){
        //if(empty($hg_goods)&&(!$user_jnmj||($user_jnmj&&$user_jnmj->jnmj_amount==0))&&$user->zq_amount==0&&$user->is_zhongduan==1){
        if(empty($hg_goods)&&$user->is_zhongduan==1){
            $jehg = $jehg_amount;
            $now = time();
            $hgs = DB::table('hg_goods')->leftJoin('goods','hg_goods.goods_id','=','goods.goods_id')
                ->where('hg_goods.num','<=',$jehg)->where('hg_goods.type',1)
                ->where('goods.is_change',1)->where('change_start_date','<=',$now)->where('change_end_date','>=',$now)
                ->orderBy('hg_goods.num','desc')
                ->select('hg_goods.*')
                ->get();
            if($hgs) {
                $this->assign['hg_amount'] = 0;
                foreach($hgs as $hg) {
                    $hg->goods = Goods::where('goods_id', $hg->hg_goods_id)->first();
                    if ($hg->hg_goods_number <= $hg->goods->goods_number && !($user->city == 357 && $hg->goods->goods_id == 19650)) {
                        $hg_goods[] = $hg;
                        //$this->is_can_zq = false;//不能使用账期
                        $this->assign['hg_amount'] += $hg->hg_goods_price * $hg->hg_goods_number;
                        $hg_type = 2;
                    }
                }
            }else{
                $this->assign['jehg_message'] = '可参加换购商品金额为：'.formated_price($jehg);
            }
        }
        if(!empty($hg_goods)){//有换购商品
            $this->goods_amount = $this->goods_amount + $this->assign['hg_amount'];
        }
        //收货地址
        $address = UserAddress::where(function($query)use($addressId,$user){
            $query->where('user_id',$user->user_id);
            if($addressId>0){
                $query->where('address_id',$addressId);
            }
        })->first();
        if(!$address){
            $address = UserAddress::where(function($query)use($addressId,$user){
                $query->where('user_id',$user->user_id);
            })->first();
        }
        if(!$address){
            return redirect()->route('address.edit');
        }else{
            $user->address_id = $address->address_id;
            $user->save();
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

        if(!$province||!$city){
            return redirect()->route('address.edit');
        }
        //运费
        $shipping_id = $user->shipping_id;
        if($shipping_id!=0) {
//            if (strpos($user->shipping_name, trans('cart.zjs')) !== false && $user->shipping_id == -1) {
//                $shipping_id = 17;
//                if($this->goods_amount<800) {
//                    $shipping_fee = 12;
//                }
//            }else {
//                $shipping_fee = shippingFee($this->goods_amount, $shipping_id);
//            }
            if (strpos($user->shipping_name, trans('cart.zjs')) !== false && $this->goods_amount<800) {
                $shipping_fee = 12;
            }

        }
        //物流
        if($user->shipping_id==0) {
            //$shipping = Shipping::where('enabled', 1)->select('shipping_id', 'shipping_name', 'support_cod', 'insure')->get();
            $shipping = Shipping::shipping_list([$user->country,$user->province,$user->city,$user->district]);
            $this->assign['shipping'] = $shipping;
        }
        //支付方式
        $payment = Payment::where('enabled',1)->select('pay_id','pay_name','pay_desc','is_cod')->orderBy('pay_order','desc')->get();

        /**
         * 活动相关开始
         */
        /**
         * 精品专区
         */
        $is_jpzq = jpzq($user);
        $gift_status = 0;
        if($is_jpzq){//精品专区活动
            $gift_id = check_jpzq($jp_amount);
            if($gift_id){
                $gift_list = GiftGoods::where('is_show',1)->where('cat_id',$gift_id)->orderBy('sort','desc')->orderBy('gift_id','desc')->take(5)->get();
                if($gift_list){
                    $gift_status = 1;
                    $this->assign['gifts'] = $gift_list;
                }
            }
        }

        /**
         * 充值返利 和 折扣 活动
         */
        //dd($this->goods_amount,$this->goods_amount_mhj,$zyzk,$zyzk_mhj,$shipping);
        $czfl_amount = ($this->goods_amount-$this->goods_amount_mhj)-$this->discount-($zyzk-$zyzk_mhj)+$shipping_fee;//排除麻黄碱之外的金额
        $this->assign['czfl_message'] = "";//返利活动提示
        $czfl = check_czfl($user,$is_no_tj,$is_no_hy,$is_no_zyzk);
        if($czfl['type']==0){//可以参加充值余额活动
            $this->assign['user_jnmj'] = $czfl['user_jnmj'];
            if($czfl['user_jnmj']->jnmj_amount<$czfl_amount){
                $this->assign['czfl_message'] = "充值金额不足";
                $this->is_can_use_jnmj =false;
            }else{
                $this->is_can_zq = false;
            }
        }elseif($czfl['type']==1){//部分条件不满足 不能参加 给与提示
            $this->assign['czfl_message'] = $czfl['message'];
            $this->is_can_use_jnmj =false;
        }elseif($czfl['type']==3){//能够参加折扣活动
            if($zk_total>=2000) {
                $this->discount = round($zk_total * 0.02,2);
                $this->is_can_zq = false;
            }
            $this->assign['czfl_message'] = "可折扣商品总金额：".formated_price($zk_total).", 折扣金额：".formated_price($this->discount);
            $this->is_can_use_jnmj =false;
        }else{
            $this->is_can_use_jnmj = false;
        }


        /**
         * 判断是否能使用优惠券
         * 不是账期客户 不是充值余额客户
         */
        $yhq_list = [];
        if($this->user->is_zq==0&&(!$this->user_jnmj||($this->user_jnmj&&$this->user_jnmj->jnmj_amount==0))&&$this->is_xkh_tj==0){
            $yhq = new YouHuiController('',$user);
            $yhq_list = $yhq->check_use_youhuiq($this->yhq_ty,$this->yhq_zy,$this->yhq_fzy);
        }
        $this->assign['yhq_list'] = $yhq_list;
        $order_amount = $this->goods_amount-$this->discount-$zyzk+$shipping_fee-$this->pack_fee;
        if($is_no_mhj==true&&$user->user_money>0&&$this->is_can_zq==false&&$this->is_can_use_jnmj==false){//不能使用账期和充值余额 不含麻黄碱 有余额可用
            $surplus = min([$user->user_money,$order_amount]);
        }
        //dd($surplus);
        /**
         * 活动相关结束
         */

        /**
         * 判断是否能使用账期
         */
//        if(!empty($hg_goods)||$hg_type!=0){//有换购
//            $czfl_amount = 0;
//        }
        $this->assign['pack_fee'] = $this->pack_fee;
        $this->assign['hg_goods'] = $hg_goods;
        $this->assign['hg_type'] = $hg_type;
        $this->assign['surplus'] = $surplus;
        $this->assign['order_amount'] = $this->goods_amount-$zyzk-$this->discount+$shipping_fee-$surplus-$this->pack_fee;
        $this->assign['page_title'] = trans('cart.orderCheck').'-';
        $this->assign['goods_list'] = $goods;
        $this->assign['address'] = $address;
        $this->assign['province'] = $province;
        $this->assign['city'] = $city;
        $this->assign['district'] = $district;
        $this->assign['user'] = $user;
        $this->assign['payment'] = $payment;
        $this->assign['total'] = $this->goods_amount;
        $this->assign['jnmj'] = 0;
        if($czfl['type']==0&&$czfl_amount>0&&$this->is_can_use_jnmj==true){//可以使用锦囊妙计
            if($czfl['user_jnmj']->jnmj_amount<$czfl_amount){
                $this->assign['czfl_message'] = "充值金额不足";
            }else{
                $this->assign['jnmj'] = $czfl_amount;
                $this->assign['order_amount'] = $order_amount - $this->assign['jnmj'];
            }
        }
        $this->assign['is_no_mhj'] = $is_no_mhj;
        $this->assign['zyzk'] = $zyzk;
        $this->assign['jp_amount'] = $jp_amount;
        $this->assign['gift_status'] = $gift_status;
        $this->assign['shipping_fee'] = $shipping_fee;
        $this->assign['discount'] = $this->discount;
        $this->assign['is_no_mhj'] = $is_no_mhj;
        $this->assign['cartStep'] = "
        <li><img src='".asset('images/cart_03.png')."'/></li>
        <li><img src='".asset('images/confirm2.png')."'/></li>
        <li><img src='".asset('images/cart_04.png')."'/></li>
        ";
        return view('jiesuan')->with($this->assign);
    }

    /*
     * 插入订单
     */
    public function order(Request $request)
    {
        $user = auth()->user()->is_new_user();

        if($user->hz_zq==1||$user->zq_has==1){
            if($user->hz_zq==1){
                $tishi = '合纵线下';
            }else{
                $tishi = '上月';
            }
            return view('message')->with(messageSys($tishi.'账期未结清,请结清后再购买!', route('cart.index'), [
                [
                    'url' => route('cart.index'),
                    'info' => trans('common.backToCart'),
                ],
            ]));
        }

        $user_jnmj = UserJnmj::where('user_id',$user->user_id)->first();
        $address_id = $request->input('address_id');
        $postscript = $request->input('postscript');//订单备注
        $shipping = $request->input('shipping');//物流id
        $payment = $request->input('payment','-1');//支付方式
        $gift = $request->input('gift','');//礼品
        $area_name = $request->input('area_name','');
        $kf_name = $request->input('kf_name','');
        //$huangou = intval($request->input('huangou',0));
        $huangou = 1;
        $gift_status = $request->input('gift_status');//礼品
        $surplus = $request->input('surplus');//使用余额
        $rec_ids = Cache::tags([$user->user_id,'cart'])->get('cart_list');
        Cache::tags([$user->user_id,'cart'])->forget('cart_list');
        if(1==2) {
            $goods = Cart::get_cart_goods($user,$rec_ids);
            $goods = goods_list($user,$goods,0,'goods_list',true);
        }else{
            $goods = Cart::get_cart_goods_l($user,$rec_ids);
        }
        if(!$rec_ids){
            return view('message')->with(messageSys('不能重复提交订单',route('cart.index'),[
                [
                    'url'=>route('cart.index'),
                    'info'=>'返回购物车',
                ],
            ]));
        }
        $this->goods_amount = 0;//订单商品总金额 未分单前
        $this->goods_amount_mhj = 0;//订单商品总金额 含麻黄碱部分
        $zyzk = 0;//优惠金额
        $zyzk_mhj = 0;//优惠金额麻黄碱
        $shipping_fee = 0;
        $this->discount = 0;
        $surplus = 0;

        /**
         * 活动相关开始
         */
        $jp_amount = 0;//精品金额
        $zyyp_amount = 0;//中药饮片金额
        $zk_total = 0;//折扣商品总金额
        $is_no_mhj = true;//不含麻黄碱
        $is_no_hy = true;//不含哈药
        $is_no_tj = true;//不含特价
        $is_no_zyzk = true;//不含优惠商品

        $hg_goods_ids = [];//换购商品 id 用来判断重复商品
        $jehg_amount = 0;
        $is_zy = 0;//is_zy=3 表示换购
        if($user->is_zq==0){
            $this->is_can_zq = false;
        }
        $check_ids = Ad::check_ids();
        /**
         * 活动相关结束
         */
        /**
         * 换购处理
         */
        foreach($goods as $v){
            if($v->goods->is_hg==1){//商品换购 而且账期结清

                $num = $v->goods_number;
                $hg = HgGoods::where('num','<=',$num)->where('goods_id',$v->goods->goods_id)->where('type',0)->orderBy('num','desc')->first();
                if($hg&&$huangou==1) {
                    $hg->goods = Goods::where('goods_id',$hg->hg_goods_id)->first();
                    if($hg->hg_goods_number<=$hg->goods->goods_number) {
                        $hg->goods->tsbz = '换';
                        $v->goods->tsbz = '换';
                        $hg->goods->real_price = $hg->hg_goods_price;
                        $hg->goods_number = $hg->hg_goods_number;
                        //$this->is_can_zq = false;//不能使用账期
                        $goods[] = $hg;
                        $hg_goods_ids[] = $hg->hg_goods_id;
                        $is_zy = 3;
                    }
                }
            }

//            if($v->goods->goods_id!=19650&&$v->goods->is_cx==0){
//                $jehg_amount += $v->goods->real_price*$v->goods_number;
//            }
//            if($v->goods->goods_id!=20728&&$v->goods->is_cx==0&&$v->goods->is_zyyp==0){
//                $jehg_amount += $v->goods->real_price*$v->goods_number;
//            }
            if($v->goods->goods_id!=3294&&$v->goods->goods_id!=16348){
                $jehg_amount += $v->goods->real_price*$v->goods_number;
            }
        }

        //if(empty($hg_goods_ids)&&(!$user_jnmj||($user_jnmj&&$user_jnmj->jnmj_amount==0))&&$user->zq_amount==0&&($user->province==26||$user->province==28||$user->province==29)&&$user->is_zhongduan==1&&$huangou==1){
        //if(empty($hg_goods_ids)&&(!$user_jnmj||($user_jnmj&&$user_jnmj->jnmj_amount==0))&&$user->zq_amount==0&&$user->is_zhongduan==1&&$huangou==1){
        if(empty($hg_goods_ids)&&$user->is_zhongduan==1&&$huangou==1){
            $jehg = $jehg_amount;
            $now = time();
            $hgs = DB::table('hg_goods')->leftJoin('goods','hg_goods.goods_id','=','goods.goods_id')
                ->where('hg_goods.num','<=',$jehg)->where('hg_goods.type',1)
                ->where('goods.is_change',1)->where('change_start_date','<=',$now)->where('change_end_date','>=',$now)
                ->orderBy('hg_goods.num','desc')
                ->select('hg_goods.*')
                ->get();
            if($hgs) {
                foreach($hgs as $hg) {
                    $hg->goods = Goods::where('goods_id', $hg->hg_goods_id)->first();
                    if ($hg->hg_goods_number <= $hg->goods->goods_number && !($user->city == 357 && $hg->goods->goods_id == 19650)) {
                        $hg->goods->tsbz = '换';
                        $hg->goods->real_price = $hg->hg_goods_price;
                        $hg->goods_number = $hg->hg_goods_number;
                        //$this->is_can_zq = false;//不能使用账期
                        $hg_goods_ids[] = $hg->hg_goods_id;
                        $is_zy = 3;
                        $goods[] = $hg;
                    }
                }
            }
        }

        foreach($goods as $k=>$v){
            if(in_array($v->goods->goods_id,$hg_goods_ids)&&$v->goods->tsbz!='换'){
                unset($goods[$k]);
            }else {
                $v->goods = Goods::area_xg($v->goods, $user);

                $message = Goods::check_cart($v->goods, $user);
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

                if (($v->goods->goods_id == 22207 || $v->goods->goods_id == 12270)) {
                    $zq_count = OrderInfo::where('user_id', $user->user_id)->where('is_zq', 1)->where('order_status', 1)->where('pay_status', 0)->count();
                    if ($zq_count > 0) {
                        return view('message')->with(messageSys('账期未结清不能购买充值礼包', route('cart.index'), [
                            [
                                'url' => route('cart.index'),
                                'info' => trans('common.backToCart'),
                            ],
                        ]));
                    } else {
                        if ($user->is_zq == 1) {
                            $user->is_zq = 0;
                            $user->save();
                            $zq_log = new ZqLog();
                            $zq_log->user_id = $user->user_id;
                            $zq_log->change_time = time();
                            $zq_log->change_desc = '参加充值返利活动关闭账期';
                            $zq_log->save();
                        }
                    }
                }
                /**
                 * 活动相关开始
                 */

                $v->is_can_zk = 1;//可以参加折扣活动
                if ($v->goods->is_mhj == 1) {//麻黄碱商品
                    $is_no_mhj = false;//含麻黄碱
                    $v->is_can_zk = 0;
                    $this->goods_amount_mhj += $v->goods->real_price * $v->goods_number;
                }

                if ($v->goods->is_cx == 1) {//特价
                    $is_no_tj = false;//含特价
                    $v->is_can_zk = 0;
                    if (!in_array($v->goods->goods_id, $check_ids)) {
                        $this->is_can_zq = false;
//                        if($user->zq_amount>0){
//                            return view('message')->with(messageSys('有未付款账期订单,不能购买特价商品!',route('cart.index'),[
//                                [
//                                    'url'=>route('cart.index'),
//                                    'info'=>trans('common.backToCart'),
//                                ],
//                            ]));
//                        }
                    }
                    if($v->goods->is_xkh_tj==1){
                        $this->is_xkh_tj = 1;
                    }
                }

                if (strpos($v->goods->product_name, '哈药') !== false || $v->goods->hy_price > 0) {//哈药
                    $is_no_hy = false;//含哈药
                    $v->is_can_zk = 0;
                }

                if ($v->goods->goods_id == 3048) {//哈药
                    $is_no_hy = false;//含哈药
                    $v->is_can_zk = 0;
                }

                if ($v->goods->is_jp == 1) {//精品
                    $jp_amount += $v->goods->real_price * $v->goods_number;
                }

                if ($v->goods->zyyp == 1) {//中药饮片
                    $zyyp_amount += $v->goods->real_price * $v->goods_number;
                }

                if ($user->is_zhongduan == 1) {//终端用户
                    $v->goods->zyzk = Goods::check_zyzk($v->goods, $user);
                    $zyzk += $v->goods->zyzk * $v->goods_number;
                    if ($v->goods->is_mhj == 1) {
                        $zyzk_mhj += $v->goods->zyzk * $v->goods_number;
                    }
                }

                if ($v->goods->zyzk > 0) {//优惠金额商品
                    $v->is_can_zk = 0;
                    $is_no_zyzk = false;
                }

                if ($v->is_can_zk == 1) {//可以参加折扣
                    $zk_total += $v->goods->real_price * $v->goods_number;
                }

                $this->goods_amount += $v->goods->real_price * $v->goods_number;

                $v->subtotal = $v->goods->real_price * $v->goods_number;

                if($v->goods->is_zyyp==1&&$v->goods_id!=21565){
                    $this->zy_amount += $v->subtotal;
                }elseif(!in_array($v->goods_id,$this->dls)){
                    $this->fzy_amount += $v->subtotal;
                }

                if(isset($v->tsbz_a)){
                    if($v->tsbz_a==1) {
                        $this->tsbz_a_amount += $v->subtotal;
                    }
                }

                /**
                 * 计算优惠券金额
                 */
                if($v->goods->is_cx==0&&$v->goods->is_mhj==0){
                    if($v->goods->is_zyyp==1){//中药
                        $this->yhq_zy += ($v->goods->real_price-$v->goods->zyzk)*$v->goods_number;
                    }else{//非中药
                        $this->yhq_fzy += ($v->goods->real_price-$v->goods->zyzk)*$v->goods_number;
                    }
                    $this->yhq_ty += ($v->goods->real_price-$v->goods->zyzk)*$v->goods_number;
                }

            }
        }
        //获取收货地址
        $address = UserAddress::where('user_id',$user->user_id)->where('address_id',$address_id)
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




        /**
         * 获取秒杀商品
         */
        $miaosha = new MiaoShaController();
        $ms_goods = $miaosha->get_cart_goods($rec_ids,false);
        if(!empty($ms_goods)) {
            $ms_amount = $ms_goods->goods_amount;
            if ($ms_amount > 0) {
                $this->is_can_use_jnmj = false;
                $this->is_can_zq = false;
            }
            foreach ($ms_goods as $v) {
                $goods[] = $v;
            }
        }else{
            $ms_amount = 0;
        }

        $this->zy_discount();
        $type1 = $this->zy_hg();
        $type2 = $this->fzy_hg();
        $this->tsbz_a_discount();
        $goods = $this->add_hg($goods,$type1->type,1);
        $goods = $this->add_hg($goods,$type2->type,2);
        //dd($this->zy_amount,$this->fzy_amount,$goods,$type1,$type2);


        $this->goods_amount = $goods->sum('subtotal') + $ms_amount;

        $this->goods_amount = $this->goods_amount + $type1->num*$this->hg_price + $type2->num*$this->hg_price;


//限购金额
        if($this->goods_amount<shopConfig('min_goods_amount')){
            return view('message')->with(messageSys(trans('cart.minMoney').' '.formated_price(shopConfig('min_goods_amount')).'，'.trans('cart.cannot').'。',route('cart.index'),[
                [
                    'url'=>route('cart.index'),
                    'info'=>trans('common.backToCart'),
                ],
            ]));
        }
        //运费
        //dd($shipping);
//        $shipping_fee = shippingFee($this->goods_amount,$shipping);
//        if($shipping==-1){
//            $shipping_name = $request->input('ps_wl',$user->shipping_name);
//            if(strpos($shipping_name,'宅急送')!==false){
//                if($this->goods_amount<800) {
//                    $shipping_fee = 12;
//                }
//            }
//        }
        if($user->shipping_id==0) {
            if ($shipping == -1) {//其他物流
                $shipping_name = $request->input('ps_wl');
            } else {
                $shipping_name = Shipping::where('enabled', 1)->where('shipping_id', $shipping)->pluck('shipping_name');
            }
        }else{
            $shipping_name = $user->shipping_name;
        }
        if(strpos($shipping_name,'宅急送')!==false&&$this->goods_amount<800){
            $shipping_fee = 12;
        }
        $pay_name = Payment::where('pay_id',$payment)->pluck('pay_name');
        /* 2015-01-19 组合礼品名称到标志建筑字段 */
        if(!empty($gift)&&$gift!=trans('cart.ljjf')){
            $gift = str_replace(' ','',$gift);
            $address->sign_building = trans('cart.hdlp').":".$gift." ".$address->sign_building;
            $jp_amount = 0;

        }

        /**
         * 充值返利 和 折扣 活动
         */
        //dd($this->goods_amount,$this->goods_amount_mhj,$zyzk,$zyzk_mhj,$shipping);
        $czfl_amount = ($this->goods_amount-$this->goods_amount_mhj)-$this->discount-($zyzk-$zyzk_mhj)+$shipping_fee;//排除麻黄碱之外的金额
//        if(!empty($hg_goods_ids)){//如果选择了换购
//            $czfl_amount = 0;
//        }
        $this->assign['czfl_message'] = "";//返利活动提示
        $czfl = check_czfl($user,$is_no_tj,$is_no_hy,$is_no_zyzk);
        if($czfl['type']==0){//可以参加充值余额活动
            if($czfl['user_jnmj']->jnmj_amount<$czfl_amount||$czfl['user_jnmj']->jnmj_amount<=0){
                $this->assign['czfl_message'] = "充值金额不足";
                $this->is_can_use_jnmj = false;
            }else{
                $this->is_can_zq = false;
            }
        }elseif($czfl['type']==1){//部分条件不满足 不能参加 给与提示
            $this->assign['czfl_message'] = $czfl['message'];
            $this->is_can_use_jnmj = false;
        }elseif($czfl['type']==3&&$zk_total>=2000){//能够参加折扣活动
            $this->discount = round($zk_total*0.02,2);
            $this->is_can_zq = false;
            $this->is_can_use_jnmj = false;
        }else{
            $this->is_can_use_jnmj = false;
        }

        /**
         * 判断能否使用优惠券
         */
        $this->yhq_id = $request->input('yhq_id',0);
        if($this->user->is_zq==0&&(!$this->user_jnmj||($this->user_jnmj&&$this->user_jnmj->jnmj_amount==0))&&$this->is_xkh_tj==0&&$this->yhq_id>0){
            $yhq = new YouHuiController('',$user);
            $yhq_list = $yhq->check_use_youhuiq($this->yhq_ty,$this->yhq_zy,$this->yhq_fzy,$this->yhq_id);
            $this->assign['yhq_list'] = $yhq_list;
            if(count($yhq_list)>0&&isset($yhq_list[0]['yhq_id'])){
                $this->pack_fee = $yhq_list[0]['je'];
                if($this->pack_fee>0){
                    $this->discount = 0;
                    $this->extension_code = 1;
                }
            }
        }

        if($is_no_mhj==true&&$user->user_money>0&&$this->is_can_zq==false&&$this->is_can_use_jnmj==false){//不能使用账期和充值余额 不含麻黄碱 有余额可用
            $surplus = min([$user->user_money,$this->goods_amount-$zyzk-$this->discount+$shipping_fee-$this->pack_fee]);
        }
        /**
         * 活动相关结束
         */



        $order_amount = $this->goods_amount-$zyzk-$this->discount-$surplus+$shipping_fee-$this->pack_fee;//应付金额 = 商品总金额 + 运费 - 优惠金额 - 折扣
        $order_amount_mhj = $this->goods_amount_mhj-$zyzk_mhj;//应付金额 = 商品总金额 - 优惠金额 - 折扣


        $jnmj = 0;
//        if(!empty($hg_goods_ids)){//有换购商品不能使用充值余额
//            $czfl_amount = 0;
//        }
        if($czfl['type']==0&&$czfl_amount>0&&$this->is_can_use_jnmj==true){//可以使用锦囊妙计
            if($czfl['user_jnmj']->jnmj_amount<$czfl_amount||$czfl['user_jnmj']->jnmj_amount<=0){
                $this->assign['czfl_message'] = "充值金额不足";
            }else{
                $jnmj = $czfl_amount;
                $order_amount = $order_amount - $jnmj;
            }

        }

        $order_sn = getOrderSn();//订单编号$
        $order_info_mhj = '';
        $order_info = new OrderInfo;
        $fendan = false;//分单
        $order_info->order_sn = $order_sn;
        $order_info->user_id = $user->user_id;
        $order_info->msn = $user->msn;
        $order_info->ls_zpgly = $user->ls_zpgly;
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
        $order_info->sign_building = $address->sign_building;
        $order_info->postscript = $postscript;
        $order_info->shipping_id = $shipping;
        $order_info->pay_id = $payment;
        $order_info->pay_name = $pay_name;
        $order_info->referer = trans('common.bz');
        $order_info->add_time = time();
        $order_info->confirm_time = time();
        $order_num = OrderInfo::where('order_status','!=',2)->where('user_id',$user->user_id)->count();
        if($order_num==0){
            $order_info->is_xkh = 1;
        }else{
            $order_info->is_xkh = 0;
        }
        $order_info->how_oos = trans('cart.how_oos');
        $order_info->goods_amount = $this->goods_amount;
        $order_info->shipping_fee = $shipping_fee;
        $order_info->surplus = $surplus;
        $order_info->order_amount = $order_amount;
        $order_info->jp_points = $jp_amount;
        $order_info->zyzk = $zyzk;
        $order_info->pack_fee = $this->pack_fee;
        $order_info->jnmj = $jnmj;
        $order_info->dzfp = $user->dzfp;
        $order_info->is_mhj = 0;
        $order_info->discount = $this->discount;
        $order_info->is_zy = $is_zy;
        $order_info->inv_content = is_null($user->question)?'':$user->question;
        $order_info->inv_payee = is_null($user->zq_ywy)?'':$user->zq_ywy;
        $order_info->card_name = is_null($user->answer)?'':$user->answer;

        /**
         * mycat
         */
        //$order_info = mycat_bc($order_info);
        if($user->shipping_id==0) {
            if ($shipping == -1) {//其他物流
                $shipping_name = $request->input('ps_wl');
                $order_info->shipping_name = $request->input('ps_wl');
                $order_info->wl_dh = $request->input('ps_dh');
                $user->shipping_id = -1;
                $user->shipping_name = $shipping_name;
                $user->wl_dh = $order_info->wl_dh;
                $user->save();
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
                if ($user->shipping_id == 0) {
                    $user->shipping_id = $shipping;
                    $user->shipping_name = $shipping_name;
                    $user->save();
                }
            }
        }else{
            $shipping_name = $user->shipping_name;
            $order_info->shipping_name = $user->shipping_name;
            $order_info->wl_dh = $user->wl_dh;
        }
        if($this->goods_amount==$this->goods_amount_mhj){//订单中只有麻黄碱
            $order_info->is_mhj = 1;
        }else{
            if($is_no_mhj==false){//含麻黄碱 要分单
                $fendan = true;
                $order_info_mhj = new OrderInfo();
                $order_info_mhj->order_sn = $order_sn.'_3';
                $order_info_mhj->user_id = $user->user_id;
                $order_info_mhj->msn = $user->msn;
                $order_info_mhj->ls_zpgly = $user->ls_zpgly;
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
                $order_info_mhj->sign_building = $address->sign_building;
                $order_info_mhj->postscript = $postscript;
                $order_info_mhj->shipping_id = $shipping;
                $order_info_mhj->pay_id = $payment;
                $order_info_mhj->pay_name = $pay_name;
                $order_info_mhj->referer = trans('common.bz');
                $order_info_mhj->add_time = time();
                $order_info_mhj->confirm_time = time();
                $order_info_mhj->is_xkh = 0;
                $order_info_mhj->goods_amount = $this->goods_amount_mhj;
                $order_info_mhj->shipping_fee = 0;
                $order_info_mhj->surplus = 0;
                $order_info_mhj->order_amount = $order_amount_mhj;
                $order_info_mhj->jp_points = 0;
                $order_info_mhj->how_oos = trans('cart.how_oos');
                $order_info_mhj->zyzk = $zyzk_mhj;
                $order_info_mhj->is_mhj = 1;
                $order_info_mhj->dzfp = $user->dzfp;
                $order_info_mhj->is_zy = $is_zy;
                $order_info_mhj->inv_content = is_null($user->question)?'':$user->question;
                $order_info_mhj->inv_payee = is_null($user->zq_ywy)?'':$user->zq_ywy;
                $order_info_mhj->card_name = is_null($user->answer)?'':$user->answer;
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
                $order_info->goods_amount = $this->goods_amount-$this->goods_amount_mhj;
                $order_info->shipping_fee = $shipping_fee;
                $order_info->surplus = $surplus;
                $order_info->order_amount = $order_amount-$order_amount_mhj;
                $order_info->jp_points = $jp_amount;
                $order_info->zyzk = $zyzk-$zyzk_mhj;
            }
        }
        if($this->is_can_zq==true){
            $check_zq = check_zq($user,$order_info->order_amount);
            if($check_zq['error']==1) {
                return view('message')->with(messageSys($check_zq['message'], route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => trans('common.backToCart'),
                    ],
                ]));
            }
            elseif($check_zq['error']==2){
                $order_info->is_zq = 0;
            }
            else {
                if($order_info->is_mhj==0) {
                    $order_info->is_zq = 1;
                }else{
                    $order_info->is_zq = 0;
                }
            }
        }
        $flag = DB::transaction(function()use($order_info,$goods,$request,$user,$is_no_mhj,$order_info_mhj,$fendan,$czfl,$ms_goods,$ms_amount,$miaosha,$rec_ids){//数据库事务插入订单
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
                    log_jnmj_change($czfl['user_jnmj'], 0 - $order_info->jnmj, '支付订单 ' . $order_info->order_sn);
                } elseif ($order_info->is_zq == 1) {//账期订单
                    log_zq_change($user, 0, $order_info['order_amount'], '支付订单 ' . $order_info->order_sn);
                }
                $payLog = new PayLog();
                $payLog->order_amount = $order_info->order_amount;
                $payLog->order_type = 0;
                $payLog->is_paid = $order_info->pay_status == 2 ? 1 : 0;
                $order_info->payLog()->save($payLog);
//            $onlinePay = new OnlinePay();
//            $onlinePay->update_time = time();
//            $onlinePay->order_sn = $order_info->order_sn;
//            $order_info->onlinePay()->save($onlinePay);
                if ($fendan == true) {
                    $order_info_mhj->save();
                    $payLog = new PayLog();
                    $payLog->order_amount = $order_info_mhj->order_amount;
                    $payLog->order_type = 0;
                    $payLog->is_paid = $order_info_mhj->pay_status == 2 ? 1 : 0;
                    $order_info_mhj->payLog()->save($payLog);
                }
                //dd($order_info);
                $recId = array();//购物车商品记录id集合
                //$insert_goods = [];//插入order_goods 集合
                //$insert_goods_mhj = [];//插入order_goods 集合
                $a = [];
                foreach ($goods as $v) {
                    $recId[] = $v->rec_id;
//                $orderGoods = new OrderGoods();
//                $orderGoods->goods_id = $v->goods_id;
//                $orderGoods->goods_name = $v->goods_name;
//                $orderGoods->goods_sn = $v->goods->goods_sn;
//                $orderGoods->goods_number = $v->goods_number;
//                $orderGoods->goods_number_f = $v->goods_number;
//                $orderGoods->market_price = $v->goods->market_price;
//                $orderGoods->goods_price = $v->goods->shop_price;
//                $orderGoods->is_real = 1;
//                $orderGoods->parent_id = 0;
//                $orderGoods->is_gift = 0;
//                $orderGoods->is_cur_p = 0;
//                $orderGoods->is_jp = $v->is_jp;
//                $orderGoods->is_zyyp = $v->is_zyyp;
//                $orderGoods->xq = $v->goods->xq;
//                $orderGoods->zyzk = $v->goods->zyzk;
//                $orderGoods->suppliers_id = 0;
                    $v->extension_code = 1;
//                if($v->is_can_zk&&$this->discount>0&&$czfl['type']==3){
//                    $v->extension_code = 0.98;
//                }
//                if($v->goods->is_zyyp==1&&$this->discount>0){
//                    $v->extension_code = $this->extension_code;
//                }
                    if(isset($v->tsbz_a)&&$this->discount>0) {
                        if ($v->tsbz_a == 1) {
                            $v->extension_code = $this->extension_code;
                        }
                    }
                    if ($fendan == true && $v->goods->is_mhj) {//分单了
                        //$insert_goods_mhj[] = $orderGoods;
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
                        //$insert_goods[] = $orderGoods;
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
                    //DB::table('goods')->where('goods_id',$v->goods_id)->decrement('goods_number',$v->goods_number);//减少库存
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
                if($ms_amount>0){
                    $old_ms_goods = $miaosha->get_cart_goods();
                    foreach($old_ms_goods as $k=>$v){
                        if(in_array(0-$v->goods_id,$rec_ids)) {//提交订单中的商品减少库存
                            unset($old_ms_goods[$k]);
                        }
                    }
                    Cache::tags(['miaosha','cart','20160824',$this->user->user_id])->forever('ms_goods',$old_ms_goods);
                }
                OrderGoods::insert($insert_goods);//插入订单商品

                if($this->pack_fee>0){//使用了优惠券
                    YouHuiQ::where('user_id',$this->user->user_id)->where('yhq_id',$this->yhq_id)->update([
                        'status'=>1,
                        'order_id'=>$order_info->order_id,
                    ]);
                }
                //$order_info->order_goods()->saveMany($insert_goods);
//            if($is_no_mhj==false){//含麻黄碱
//                $user->mhj_hz = 1;
//                $user->save();
//            }
                $online = new OnlinePay();
                $online->update_time = time();
                $online->order_sn = $order_info->order_sn;
                $order_info->onlinePay()->save($online);
                /* 2015-6-15 为在线支付主动查询插入支付记录 */
                if ($fendan == true) {
                    //$order_info_mhj->order_goods()->saveMany($insert_goods_mhj);
                    $online_mhj = new OnlinePay();
                    $online_mhj->update_time = time();
                    $online_mhj->order_sn = $order_info_mhj->order_sn;
                    $order_info_mhj->onlinePay()->save($online_mhj);
                }
                if ($order_info->surplus > 0) {//记录余额变动
                    //dd($order_info->surplus);
                    log_account_change($user->user_id, $order_info->surplus * (-1), 0, 0, 0, trans('cart.payOrder') . ' ' . $order_info->order_sn);  //2015-7-27
                }
            }else{
//            return view('message')->with(messageSys('订单购买失败',route('cart.jiesuan'),[
//                [
//                    'url'=>route('cart.index'),
//                    'info'=>trans('common.backToCart'),
//                ],
//            ]));
                return -1;
            }
        });
        if($flag==-1){
            return view('message')->with(messageSys('订单购买失败',route('cart.jiesuan'),[
                [
                    'url'=>route('cart.index'),
                    'info'=>trans('common.backToCart'),
                ],
            ]));
        }
        $this->total_amount = $order_info->goods_amount;
        if($fendan==true) {//分单了
            $this->total_amount = $this->total_amount + $order_info_mhj->goods_amount;
        }
        @$this->toErp($order_info,$user);
        $order = [
            'goods_amount'=>$this->goods_amount,
            'zyzk'=>$zyzk,
            'discount'=>$this->discount,
            'order_amount'=>$order_amount,
            'surplus'=>$surplus,
            'shipping_fee'=>$shipping_fee,
            'pay_name'=>$order_info->pay_name,
            'shipping_name'=>$shipping_name,
            'order_sn'=>$order_sn,
            'order_id'=>$order_info->order_id,
            'jnmj'=>$order_info->jnmj,
        ];
        if($order_info->is_zq==1){
            $order['pay_name'] = '月结';
        }
        $onlinePay = '';
        if($fendan==true){//分单了
            @$this->toErp($order_info_mhj,$user);
            $order['order_sn_mhj'] = $order_sn.'_3';
            $order['order_id_mhj'] = $order_info_mhj->order_id;
            $order['pay_name'] .= ' '.$order_info_mhj->pay_name;
        }elseif($order_amount>0&&empty($order_info_mhj)){
            /**
             * 支付限制
             */
            $status = pay_xz($order_info);
            if($status==true) {
                if ($payment == 4) {//银联支付
                    $payment_info = Payment::where('pay_id', 4)->where('enabled', 1)->firstOrfail();
                    $payment = unserialize_config($payment_info->pay_config);
                    //dd($payment);
                    $order_info->user_name = $user->user_name;
                    $order_info->pay_desc = $payment_info->pay_desc;
                    $pay_obj = new upop();
                    $onlinePay = $pay_obj->get_code_flow($order_info, $payment);

                } elseif ($payment == 5) {//农行支付
                    //Cache::tags(['user',$user->user_id])->flush();
                    $onlinePay = "
                <form style='text-align:center;'  id='pay_form'
                 action='" . route('xyyh.pay') . "' method='get' target='_blank'>
                <input id='J_payonline' style='left: 250px;;' value='立即支付' type='submit' onclick='toSearch($(this))' searchUrl='" . route('xyyh.search', ['id' => $order_info->order_id,'bank'=>5,'type'=>0]) . "'>
               <input value='" . $order_info->order_id . "' name='id' type='hidden'>
              <input value='5' name='bank' type='hidden'>
              <input value='0' name='type' type='hidden'>
                </form>";
                }elseif ($payment == 6) {//兴业银行
                    //Cache::tags(['user',$user->user_id])->flush();
                    $onlinePay = "
                <form style='text-align:center;'  id='pay_form'
                 action='" . route('xyyh.pay') . "' method='get' target='_blank'>
                <input id='J_payonline' style='left: 250px;;' value='立即支付' type='submit'  onclick='toSearch($(this))' searchUrl='" . route('xyyh.search', ['id' => $order_info->order_id,'type'=>0]) . "'>
               <input value='" . $order_info->order_id . "' name='id' type='hidden'>
                <input value='0' name='type' type='hidden'>
                </form>";
                }elseif ($payment == 7) {//兴业银行
                    //Cache::tags(['user',$user->user_id])->flush();
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
        $this->assign = [
            'page_title' => trans('cart.orderOk').'-',
            'order' => $order,
            'onlinePay' => $onlinePay,
            'pack_fee' => $this->pack_fee,
        ];
        $this->assign['cartStep'] = "
                <li><img src='".asset('images/cart_03.png')."'/></li>
                <li><img src='".asset('images/confirm2.png')."'/></li>
                <li><img src='".asset('images/order22.png')."'/></li>
                ";
        return view('orderOk')->with($this->assign);



    }
    /*
     * 删除购物车中的商品
     */
    public function dropCart(Request $request){
        $user = Auth::user();
        $id = $request->input('id');
        if($id<0){
            $miaosha = new MiaoShaController();
            $ms_goods = $miaosha->get_cart_goods();
            foreach($ms_goods as $k=>$v){
                if($v->goods_id==-$id){
                    unset($ms_goods[$k]);
                    Cache::tags(['miaosha','cart','20160824',$this->user->user_id])->forget($v->goods_id);
                }
            }
            Cache::tags(['miaosha','cart','20160824',$this->user->user_id])->forever('ms_goods',$ms_goods);
            if(count($ms_goods)==0) {
                Cache::tags(['miaosha', 'cart', '20160824', $this->user->user_id])->forget('team');
            }
            return redirect()->back();
        }
        $cart = Cart::findOrfail($id);
        $this->authorize('update-post',$cart);
        if($cart->delete()){
            Cache::tags([$user->user_id,'cart'])->decrement('num');
            return redirect()->back();
        }
    }
    /*
     * 移动到收藏
     */
    public function dropToCollect(Request $request){
        $user = Auth::user();
        $id = $request->input('id');
        if($id<0){
            $miaosha = new MiaoShaController();
            $ms_goods = $miaosha->get_cart_goods();
            foreach($ms_goods as $k=>$v){
                if($v->goods_id==-$id){
                    unset($ms_goods[$k]);
                    Cache::tags(['miaosha','cart','20160824',$this->user->user_id])->forget($v->goods_id);
                }
            }
            Cache::tags(['miaosha','cart','20160824',$this->user->user_id])->forever('ms_goods',$ms_goods);
            if(count($ms_goods)==0) {
                Cache::tags(['miaosha', 'cart', '20160824', $this->user->user_id])->forget('team');
            }
            return redirect()->back();
        }
        DB::transaction(function()use($user,$id){
            $goods_id = Cart::select('rec_id','user_id','goods_id')->findOrFail($id);
            $this->authorize('update-post',$goods_id);
            $goods_id->delete();
            Cache::tags([$user->user_id,'cart'])->decrement('num');
            $collectGoods = CollectGoods::where('goods_id',$goods_id->goods_id)->where('user_id',$user->user_id)->first();
            if(!$collectGoods) {
                $collectGoods = new CollectGoods();
                $collectGoods->user_id = $user->user_id;
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
        $user = Auth::user();
        $id = $request->input('id');
        $id = rtrim($id,'_');
        $id = explode('_',$id);
        $miaosha = new MiaoShaController();
        $ms_goods = $miaosha->get_cart_goods();
        if(count($ms_goods)>0) {
            foreach ($ms_goods as $k => $v) {
                if (in_array(0 - $v->goods_id, $id)) {
                    unset($ms_goods[$k]);
                    Cache::tags(['miaosha', 'cart', '20160824', $this->user->user_id])->forget($v->goods_id);
                }
            }
        }
        Cache::tags(['miaosha','cart','20160824',$this->user->user_id])->forever('ms_goods',$ms_goods);
        if(count($ms_goods)==0) {
            Cache::tags(['miaosha', 'cart', '20160824', $this->user->user_id])->forget('team');
        }
        if(Cart::whereIn('rec_id',$id)->where('user_id',$user->user_id)->delete()){
            Cache::tags([$user->user_id,'cart'])->decrement('num',count($id));
            return redirect()->back();
        }
        return redirect()->back();
    }


    /*
     * 传输订单到 erp 中
     */
    private function toErp($order,$user){
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
                @$this->sync_orderinfo_to_erp($order,$user);
            }
        }
    }

    private function sync_orderinfo_to_erp($order,$user){
        $xf_ids = [];//使用现付的会员
//        $order_sn = str_replace('_3','',$order['order_sn']);
//        $this->goods_amount = OrderInfo::where('order_sn','like','%'.$order_sn.'%')->sum('goods_amount');//获取未分单前的总金额
        $this->goods_amount = $this->total_amount;
        if (($order->province == 26 && $this->goods_amount >= 800)||in_array($order->user_id,$xf_ids)) {
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
        $fpfs = $fpfs_type[$user->dzfp];

        if($order->is_zq==1){//账期会员的账期订单
            $fukfs = '月结';
            $ywy = $user->zq_ywy;

            if(empty($ywy)){//账期业务员为空 读取otc客服
                $gly_arr = explode('.',$this->user->ls_zpgly);
                $otc_admin = AdminUser::whereIn('user_name',$gly_arr)
                    ->whereIn('role_id',[22,31])->pluck('user_name');
                $ywy = $otc_admin;

            }

        }
        else{
            $fukfs = '预付';
            if(empty($user->zq_ywy)) {
                $ywy = '药易购';
            }else{
                $ywy = $user->zq_ywy;
            }
        }

        $zk = "ZKZ00000003";
        if($order->jnmj>0) {//订单使用锦囊支付
            $jnmj = UserJnmj::where('user_id',$user->user_id)->pluck('jnmj_zk');
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
            'khinf_id' => $user->wldwid,
            'khinf_id1' => $user->wldwid1,
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

}
