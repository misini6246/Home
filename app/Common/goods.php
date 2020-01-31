<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/29
 * Time: 8:56
 */
use App\Goods;
use App\OrderGoods;
use App\GoodsGallery;
use App\GoodsAttr;
use App\kxpzPrice;
use App\User;
use App\MemberPrice;
use App\Cart;
use App\OrderInfo;
use App\UserAddress;
use Illuminate\Support\Facades\Auth;
use App\KxPromote;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

/**
 * 获得商品的属性和规格
 *
 * @access  public
 * @param   integer $goods_id
 * @return  array
 */
function get_goods_gg($goods_id)
{
    /* 对属性进行重新排序和分组 */
    $res = GoodsAttr::with(['attribute'=>function($query){
        $query->orderBy('sort_order')->select('attr_id','attr_name');
    }])->where('goods_id',$goods_id)->orderBy('attr_price')->orderBy('goods_attr_id')
        ->select('attr_id','goods_attr_id','attr_value','attr_price')->get();
    foreach($res as $v){
        if(!empty($v->attribute->attr_name)) {
            $v->attr_name = $v->attribute->attr_name;
        }
        unset($v->attribute);
    }
    return $res;
}
/**
 * 判断某个商品是否正在特价促销期
 *
 * @access  public
 * @param   float   $price      促销限购个数
 * @param   string  $start      促销开始日期
 * @param   string  $end        促销结束日期
 * @return  float   如果还在促销期则返回促销限购个数，否则返回0
 */
function bargain_price1($xggs, $start, $end, $ylflag = false)
{
    if($ylflag) {
        return 0 ;
    } else {
        if ($xggs == 0)
        {
            return 0;
        }
        else
        {
            $time = time();
            if ($time >= $start && $time <= $end)
            {
                return $xggs;
            }
            else
            {
                return 0;
            }
        }
    }
}


/*
 * 商品信息
 */
function getGoodsInfo($goods_id){
    $goods = Goods::with(['group_goods'=>function($query){
        $query->select('parent_id');
    }])->where('is_on_sale',1)//上架
    //->where('is_alone_sale',1)//作为普通商品销售
    ->where('is_delete',0)//没有删除
    ->where('goods_id',$goods_id)//没有删除
    //->select('goods_id','')
    ->first();
    if(!empty($goods)) {
        if ($goods->goods_attr->where('attr_id', 1)->first()) {//生产厂家存在
            $goods->sccj = $goods->goods_attr->where('attr_id', 1)->first()->attr_value;
        }
        if ($goods->goods_attr->where('attr_id', 2)->first()) {//单位存在
            $goods->dw = $goods->goods_attr->where('attr_id', 2)->first()->attr_value;
        }
        if ($goods->goods_attr->where('attr_id', 3)->first()) {//规格存在
            $goods->spgg = $goods->goods_attr->where('attr_id', 3)->first()->attr_value;
        }
        if ($goods->goods_attr->where('attr_id', 4)->first()) {//国药准字存在
            $goods->gyzz = $goods->goods_attr->where('attr_id', 4)->first()->attr_value;
        }
        if ($goods->goods_attr->where('attr_id', 5)->first()) {//件装量存在
            $goods->jzl = $goods->goods_attr->where('attr_id', 5)->first()->attr_value;
        }
        if ($goods->goods_attr->where('attr_id', 211)->first()) {//中包装存在
            $goods->zbz = $goods->goods_attr->where('attr_id', 211)->first()->attr_value;
        }
        return $goods;
    }else{
        return false;
    }
}
/*
 *判断用户是否可以购买商品
 * @user 用户信息
 * @ajax 是否ajax请求
 * @result ajax返回值
 */
function userCheck($user=array(),$ajax=false,$result){
    //采购、提货、收货委托书及身份证复印件  user_rank  weitsh_yxq
    $user->yyzz_time=strtotime($user->yyzz_time);
    $user->xkz_time=strtotime($user->xkz_time);
    $user->zs_time=strtotime($user->zs_time);
    $user->yljg_time=strtotime($user->yljg_time);

    // 2014-11-26 采购、提货、收货委托书及身份证复印件
    $user->user_rank=intval($user->user_rank) ;
    $user->ls_mzy=intval($user->ls_mzy) ;
    $user->ls_swzp=intval($user->ls_swzp) ;
    $user->mhj_number=intval($user->mhj_number) ;
    $time=time() ;
    if($user->user_rank != 1){
//        if($user->yyzz_time!='' && $user->yyzz_time < $time ){
//            if($ajax){
//                $result['error'] = 1;
//                $result['message'] = "你的营业执照已过期，请尽快重新邮寄";
//                echo json_encode($result);exit;
//            }else {
//                return '你的营业执照已过期，请尽快重新邮寄';
//            }
//        }
//        if($user->xkz_time!='' && $user->xkz_time < $time ){
//            if($ajax){
//                $result['error'] = 1;
//                $result['message'] = "你的药品经营许可证已过期，请尽快重新邮寄";
//                echo json_encode($result);exit;
//            }else {
//                return '你的药品经营许可证已过期，请尽快重新邮寄';
//            }
//        }
//        if($user->zs_time!='' && $user->zs_time < $time ){
//            if($ajax){
//                $result['error'] = 1;
//                $result['message'] = "你的GSP证书已过期，请尽快重新邮寄";
//                echo json_encode($result);exit;
//            }else {
//                return '你的GSP证书已过期，请尽快重新邮寄';
//            }
//        }
//        if($user->yljg_time!='' && $user->yljg_time < $time ){
//            if($ajax){
//                $result['error'] = 1;
//                $result['message'] = "你的医疗机构执业许可证已过期，请尽快重新邮寄";
//                echo json_encode($result);exit;
//            }else {
//                return '你的医疗机构执业许可证已过期，请尽快重新邮寄';
//            }
//        }
    }
    return true;
}
/*
 * 判断用户是否有购买权限
 * @user 用户信息
 * @goods_info 商品信息
 */
function userLimit($user,$goods_info,$ajax=false){
    $user_rank_o = $user->user_rank;
    if($user_rank_o == 6 || $user_rank_o == 7) $user_rank_o = 1 ;
    if(strpos($goods_info['show_area'],'4') !== false && $user['ls_mzy'] == 1) {
        if($ajax){
            $result['error'] = 1;
            $result['message'] = "你没有购买中药饮片的权限，如须购买请联系客服人员";
            echo json_encode($result);exit;
        }else {
            $GLOBALS['err']->add('你没有购买中药饮片的权限，如须购买请联系客服人员', ERR_NO_BASIC_GOODS);
            return false;
        }
    }

    if(strpos($goods_info['cat_ids'],'180') !== false && $user['mhj_number'] == 0) {
        if($ajax){
            $result['error'] = 1;
            $result['message'] = "你没有购买麻黄碱的权限，如须购买请联系客服人员";
            echo json_encode($result);exit;
        }else {
            $GLOBALS['err']->add('你没有购买麻黄碱的权限，如须购买请联系客服人员', ERR_NO_BASIC_GOODS);
            return false;
        }
    }

    // 2015-5-12 诊所不能购买食品
    if(strpos($goods_info['cat_ids'],'398') !== false && $user_rank_o == 5) {
        if($ajax){
            $result['error'] = 1;
            $result['message'] = "你没有购买食品的权限，如须购买请联系客服人员";
            echo json_encode($result);exit;
        }else {
            $GLOBALS['err']->add('你没有购买食品的权限，如须购买请联系客服人员', ERR_NO_BASIC_GOODS);
            return false;
        }
    }

    //2015-6-18 控销品种
//    if($goods_info['is_kxpz']){
//        $k_row = get_kxpz_price($goods_info->goods_id,$user->user_id);
//        if(!empty($k_row['ls_xs'])){
//            $GLOBALS['err']->add('你没有购买控销品种的权限，如须购买请联系客服人员。', ERR_NO_BASIC_GOODS);
//            return false;
//            if($ajax){
//                $result['error'] = 1;
//                $result['message'] = "你没有购买控销品种的权限，如须购买请联系客服人员";
//                echo json_encode($result);exit;
//            }else {
//                $GLOBALS['err']->add('你没有购买控销品种的权限，如须购买请联系客服人员', ERR_NO_BASIC_GOODS);
//                return false;
//            }
//        }
//    }//end
}
/*
 * 判断配件
 * @parent_id
 */
function checkPeijian($parent_id,$is_alone_sale){
    if($parent_id>0){//配件
        if(!Cart::where('goods_id',$parent_id)->pluck('goods_id')){//购物车不存在配件的基本件
            $result = array();
            $result['error'] = 1;
            $result['message'] = '购物车中没有该配件的基本件';
            echo json_encode($result);exit;
        }elseif($is_alone_sale==0){//不是配件但是不能单独销售
            $result = array();
            $result['error'] = 1;
            $result['message'] = '该商品不能单独销售';
            echo json_encode($result);exit;
        }
    }
}
/*
 * 判断是否超出限购数量
 */
function checkXg($goods_info,$user_id,$num){
    if($goods_info->xg_type == 2) {
        //如果是在时间段内限购
        $nowtime = time() ;
        $timeflag = false ;
        if($goods_info->xg_start_date <= $nowtime AND $nowtime <= $goods_info->xg_end_date) {
            //如果在限购范围内
            $timeflag = true ;
            // 2015-02-10
            if($goods_info->promote_price > 0){
                if($goods_info->is_xkh_tj == 1){
                    $timeflag = false ;
                }
                $timeflag = false ;
            }
        }

        if($timeflag) {
            $ls_ddnum = OrderGoods::with(['order_info'=>function($query)use($user_id){
                $query->where('order_status','!=',2)->where('order_status','!=',3)
                    ->where('user_id',$user_id)->whereBetween('add_time',['xg_start_date','xg_end_date']);
            }])->where('goods_id',$goods_info->goods_id)->sum('goods_number');
            if($goods_info->ls_ggg!=0 || $goods_info->ls_ggg!=''){

                if($ls_ddnum->goods_number >= $goods_info->ls_ggg) {
                    $ylflag = true ; //没有余量
                }else if($ls_ddnum->goods_number+$num > $goods_info->ls_ggg) {
                    $result = array();
                    $result['error'] = 1;
                    $result['message'] = '您购买的数量已超过限购数量';
                    echo json_encode($result);exit;
                }
            }
        }
    }
}
/*
 * 购物车商品信息
 * @orderstr 选中的商品
 * @user 登陆的用户
 */
function cartGoods($user,$orderstr=0,$flag=false){
    $goods = Cart::with([
        'goods'=>function($query)use($user){
            $query->with('goods_attr','member_price')->where('is_on_sale',1)->where('is_delete',0)
                ->select('goods_id','sales_volume','goods_name','goods_name_style','market_price','is_new','is_best','is_hot','shop_price',
                    'is_zx','promote_price','goods_type','promote_start_date','promote_end_date','xg_type','xg_start_date','xg_end_date','is_promote',
                    'ls_gg','ls_ggg','goods_brief','goods_number','goods_thumb','goods_img','ls_ranks','ls_regions','ls_bz','ls_sc','goods_sn',
                    'goods_desc','is_pz','is_xkh_tj','is_change','change_start_date','change_end_date','change_goods_id','is_kxpz','ls_buy_user_id','xq',
                    'zyzk','is_on_sale','is_delete','is_alone_sale','show_area','cat_ids','ckid','tsbz','suppliers_id');
        },

    ])->where(function($query)use($orderstr,$user){
        if($orderstr!=0){
            $query->whereIn('rec_id',$orderstr);
        }
        $query->where('user_id',$user->user_id)->where('goods_id','!=',0);
    })->select('goods_id','goods_number','goods_price','goods_name','rec_id')->get();
    //llPrint($goods,2);
    $is_no_mhj = true;//不含麻黄碱
    $zyzk = 0;//优惠金额
    foreach($goods as $v){
        if($flag) {
            Redis::zremrangebyscore('goods_list', $v->goods->goods_id, $v->goods->goods_id);
            Redis::zadd('goods_list', $v->goods->goods_id, serialize($v->goods));
        }
        if(!isset($v->goods)){
            Cart::destroy($v->rec_id);
            Cache::tags([$user->user_id,'cart'])->decrement('num',1);
        }else {
            $v->goods = Goods::attr($v->goods,$user);
            //dd($user,$v,$v->goods->shop_price,$memberPrice,$cxPrice,$kxpzPrice,$isYl);
            if ($user->user_rank == 2 || $user->user_rank == 5) {//终端用户
                $zyzk += $v->goods->zyzk;
            }
        }
    }
    if($flag==true){
        $goods = $goods->first();
    }
    return $goods;
}
/*
 * 判断商品是否在促销期
 * @ is_promote 是否促销
 * @start 促销开始日期
 * @end 促销结束日期
 */
function isCx($is_promote,$start,$end){
    if($is_promote==1&&time()>=$start&&time()<=$end){
        return 1;
    }else{
        return 0;
    }
}
/*
 * 判断商品是否换购
 * @ is_hg 是否换购
 * @start 开始日期
 * @end 结束日期
 * @change_goods_id 被换购的商品id
 * @user_rank 2.5终端用户可参与
 */
function isHg($is_change,$start,$end,$change_goods_id,$user_rank){
    $is_hg = 0;
    if($is_change == 1){
        $nowtimes = time();
        if($start <= $nowtimes AND $nowtimes <= $end AND $change_goods_id > 0 AND in_array($user_rank, array('2', '5'))) {
            $is_hg = 1;
        }
    }
    return $is_hg;
}
/*
 * 判断商品是否在时间段限购
 * @ $xg_type 1单张订单限购 2时间段内限购 0不限购 3 每天限购
 * @start 促销开始日期
 * @end 促销结束日期
 */
function isXg($xg_type,$start,$end){
    if($xg_type==2&&time()>=$start&&time()<=$end){
        return $xg_type;
    }elseif($xg_type==1||$xg_type==3){
        return $xg_type;
    }else{
        return 0;
    }
}
/*
 * 判断限购商品是否还有余量
 * @ $xg_type 1单张订单限购 2时间段内限购
 * @start 促销开始日期
 * @end 促销结束日期
 * @goods_id
 * @ls_ggg最高购买量
 * @user_id
 */
function xgYl($xg_type,$start,$end,$goods_id,$ls_ggg,$user_id){
    $isXg = isXg($xg_type,$start,$end);
    $flag = true;
    $result = [
        'yl'=>$ls_ggg,
    ];
    if ($isXg==2||$isXg==3) {//时间段内限购 或者每天限购
        if($isXg==2){
            $timeArr = [$start,$end];
        }else{
            $timeArr = [strtotime(date('Y-m-d')),strtotime(date('Y-m-d',strtotime('+1 day')))];
        }
        if($ls_ggg!=''&&$ls_ggg>0){//最高购买量存在
            //在限购时间内已购买的的商品数量
//                    $ls_ddnum = OrderGoods::with(['order_info' => function ($query) use ($v,$user) {
//                        $query->where('order_status', '!=', 2)->where('order_status', '!=', 3)->whereBetween('add_time', [$v->xg_start_date, $v->xg_end_date])
//                            ->where('user_id', $user->user_id)
//                            ->select('order_id');
//                    }])->where('goods_id', $v->goods_id)
//                        ->select(DB::raw('sum(goods_number) as goods_number'))
//                        ->sum('')
//                        ->first();
            $ls_ddnum = DB::table('order_goods as og')
                ->leftjoin('order_info as oi','og.order_id','=','oi.order_id')
                ->where('oi.order_status','!=',2)->where('oi.order_status','!=',3)
                ->where('og.goods_id',$goods_id)->where('oi.user_id',$user_id)
                ->whereBetween('oi.add_time', $timeArr)
                ->sum('og.goods_number');
            if($ls_ddnum>=$ls_ggg){//购买数量大于等于限购数量
                $flag = false; //没有余量
            }else{
                $result['yl'] = $ls_ggg-$ls_ddnum;
            }
        }
    }
    $result['isYl'] = $flag;
    return $result;
}
/* 2015-6-18 取得控销商品的售价 */
/*
 * 控销价
 * @goods_id
 * @is_kxpz 1控销商品
 */
function kxpzPrice($goods_id,$is_kxpz){
    $shopPrice = 0;
    if($is_kxpz==1) {
        $user = Auth::user();
        $user_rank = ($user->user_rank == 1 || $user->user_rank == 6 || $user->user_rank == 7) ? 1 : $user->user_rank;
        $kxpzPrice = kxpzPrice::where('user_id', $user->id)->where('goods_id', $goods_id)
            ->where('country', 'like', "%$user->country%")
            ->where('province', 'like', "%$user->province%")
            ->where('city', 'like', "%$user->city%")
            ->where('district', 'like', "%$user->district%")
            ->select('area_price', 'company_price','price_id')
            ->first();//查询会员控销价
        if (!$kxpzPrice) {
            $kxpzPrice = kxpzPrice::where('goods_id', $goods_id)
                ->where(function ($query) use ($user) {
                    $query->where('ls_regions', 'like', "%.$user->district.%")
                        ->orwhere('ls_regions', 'like', "%.$user->city.%")
                        ->orwhere('ls_regions', 'like', "%.$user->province.%")
                        ->orwhere('ls_regions', 'like', "%.$user->country.%");
                })->select('area_price', 'company_price')
                ->first();
            if($kxpzPrice) {
                if ($kxpzPrice->company_price > 0 && $user_rank == 1) {
                    $shopPrice = $kxpzPrice->company_price;
                } elseif ($kxpzPrice->area_price > 0) {
                    $shopPrice = $kxpzPrice->area_price;
                }
            }
        }else{
            if ($kxpzPrice->company_price > 0 && $user_rank == 1) {
                $shopPrice = $kxpzPrice->company_price;
            } elseif ($kxpzPrice->area_price > 0) {
                $shopPrice = $kxpzPrice->area_price;
            }
            //如果存在控销价格 判断是否促销 限购
            $kxPromote = KxPromote::where('price_id',$kxpzPrice->price_id)->first();
            //在促销
            if($kxPromote) {
                $isCx = isCx($kxPromote->is_promote, $kxPromote->promote_start_date, $kxPromote->promote_end_date);
                if ($user->user_rank == 2 || $user->user_rank == 5) {//终端才能参加促销
                    $isYl = xgYl($kxPromote->xg_type, $kxPromote->xg_start_date, $kxPromote->xg_end_date, $kxPromote->goods_id, $kxPromote->ls_ggg, $user->user_id);
                    if ($isYl&&$isCx&&$kxPromote->promote_price>0) {//有余量 在促销 存在促销价
                        $shopPrice = $kxPromote->promote_price;
                    }
                }
            }
        }
    }
    return $shopPrice;
} // end func
/*
 * 会员价格
 */
function userPrice($memberPrice){
    if(!$memberPrice->isEmpty()){
        //print_r($memberPrice);die;
        $userPrice = $memberPrice[0]->user_price;
    }else{
        $userPrice = 0;
    }
    return $userPrice;
}
/*
 * 获得商品当前价格
 * kxpzPrice>promote_price>member_price>shop_price
 * @shop_price 本店售价
 * @member_price 会员等级对应价
 * @promote_price 促销价
 * @kxpxPrice 控销价
 * @xgYl 限购余量
 */
function goodsPrice($shop_price,$member_price,$promote_price,$kxpzPrice,$xgYl){
    if($member_price>0){//会员价存在
        $shop_price = $member_price;
    }
    if($promote_price>0&&$xgYl){//促销价存在,而且有余量
        $shop_price = $promote_price;
    }
    if($kxpzPrice>0){//控销价存在
        $shop_price = $kxpzPrice;
    }
    return $shop_price;
}
/*
 * 获取商品当前价格
 * @user 会员信息
 * @v 商品信息
 */
function goodsPromote($v,$user){

    return $v;
}