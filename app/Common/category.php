<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/29
 * Time: 9:07
 */
use App\Goods;
use App\User;
use App\SalesVolume;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
require_once app_path() . '/Common/goods.php';
//获取商品列表
function getgoods($sort, $order, $goods_name, $product_name, $jx, $zm, $cat_id, $phaid,$step='',$keywords){
    $user = Auth::user();
    $goods = Goods::with([
        'goods_attr'=>function($query){
            $query->select('goods_id','attr_id','attr_value');
        },
        'member_price'=>function($query)use($user){
            if(Auth::check()){
                $query->where('user_rank',$user->user_rank);
            }
            $query->select('goods_id','user_price');
        },
    ])
        ->where(function($query) use ($user, $sort, $order, $goods_name, $product_name, $jx, $zm, $cat_id, $phaid,$keywords,$step){
            $query
                ->where('is_on_sale',1)//上架
                ->where('is_alone_sale',1)//作为普通商品销售
                ->where('is_delete',0)//没有删除
            ;
            switch($step){
                case 'nextpro':$query->where('is_promote',1)->where('promote_price','>',0)->where('promote_start_date','>',time());break;
                case 'promotion':$query->where('is_promote',1)->where('promote_price','>',0)
                    ->where('promote_start_date','<=',time())->where('promote_end_date','>=',time());break;
            }
            if(Auth::check()) {
                $user_rank = $user->user_rank ;
                //2015-1-6
                if($user->user_rank==1){
                    $query->where('ls_ranks','!=',1);
                }
                if($user_rank == 6 || $user_rank == 7) $user_rank = 1 ;
                $query->where(function($query) use ($user,$user_rank){
                    //如果已经登陆，获取地区、会员id
                    $country = $user->country ;
                    $province = $user->province ;
                    $city = $user->city ;
                    $district = $user->district ;
                    $user_id = $user->user_id ;
                    if($user_rank == 1){
                        $query
                            ->where('yy_regions','not like','%.'.$country.'.%')//没有医院限制1,6,7
                            ->where('yy_regions','not like','%.'.$province.'.%')
                            ->where('yy_regions','not like','%.'.$city.'.%')
                            ->where('yy_regions','not like','%.'.$district.'.%')
                            ->where('yy_user_ids','not like','%.'.$user_id.'.%')
                            ->where('ls_ranks','not like','%'.$user->user_rank.'%');//没有等级限制;

                    }else{
                        $query
                            ->where('zs_regions','not like','%.'.$country.'.%')//没有诊所限制
                            ->where('zs_regions','not like','%.'.$province.'.%')
                            ->where('zs_regions','not like','%.'.$city.'.%')
                            ->where('zs_regions','not like','%.'.$district.'.%')
                            ->where('zs_user_ids','not like','%.'.$user_id.'.%')
                            ->where('ls_ranks','not like','%'.$user_rank.'%');//没有等级限制;
                    }
                    $query->where('ls_regions','not like','%.'.$country.'.%')//没有区域限制
                        ->where('ls_regions','not like','%.'.$province.'.%')
                        ->where('ls_regions','not like','%.'.$city.'.%')
                        ->where('ls_regions','not like','%.'.$district.'.%')
                        ->where('ls_user_ids','not like','%.'.$user_id.'.%')
                        ->orwhere('xzgm',1)
                        ->orwhere('ls_buy_user_id','like','%.'.$user_id.'.%');//允许购买的用户
                });
            }
//            if ($brand > 0) {
//                $query->where('brand_id',$brand);
//            }
            if(!empty($keywords)){
                $query->where(function($query)use($keywords){
                    $query->where('ZJMID','like',"%$keywords%")->orwhere('goods_name','like',"%$keywords%");
                });
            }
            //2014-8-19
            if ($cat_id > 0|| $cat_id=='a') {
                $query->where('show_area','like','%'.$cat_id.'%');//显示区域
            }

            if ($phaid > 0) {
                $query->where('cat_ids','like','%'.$phaid.'%');//药理分类
            }

            /* 2014-6-3 */
            if ($jx) {
                $query->where('jx','=',$jx);//剂型
            }

            if ($zm) {
                $query->where('ZJMID','like','%'.$zm.'%');//助记码
            }

//            if ($min > 0) {
//                $query->where('shop_price','>=',$min);
//            }
//
//            if ($max > 0) {
//                $query->where('shop_price','<=',$max);
//            }

            if ($goods_name) {//商品名称或助记码
                $query->where(function($query) use ($goods_name){
                    $query->where('goods_name','like','%'.$goods_name.'%')
                        ->orwhere('ZJMID','like','%'.$goods_name.'%');
                });
            }

            if ($product_name) {//生产厂家
                $query->where('product_name','like','%'.$product_name.'%');
            }
        })
        ->orderBy($sort,$order)->orderBy('goods_thumb','desc')
        ->select('xzgm','goods_id','sales_volume','goods_name','goods_name_style','market_price','is_new','is_best','is_hot','shop_price',
            'is_zx','promote_price','goods_type','promote_start_date','promote_end_date','xg_type','xg_start_date','xg_end_date','is_promote',
            'ls_gg','ls_ggg','goods_brief','goods_number','goods_thumb','goods_img','ls_ranks','ls_regions','ls_bz','ls_sc','goods_sn',
            'goods_desc','is_pz','is_xkh_tj','is_change','change_start_date','change_end_date','change_goods_id','is_kxpz','ls_buy_user_id','xq')
        ->Paginate(40)
        //->toArray()
    ;
    foreach($goods as $k=>$v){
        if($v->goods_attr->where('attr_id',1)->first()){//生产厂家存在
            $v->sccj = $v->goods_attr->where('attr_id',1)->first()->attr_value;
        }
        if($v->goods_attr->where('attr_id',2)->first()){//单位存在
            $v->dw = $v->goods_attr->where('attr_id',2)->first()->attr_value;
        }
        if($v->goods_attr->where('attr_id',3)->first()){//规格存在
            $v->spgg = $v->goods_attr->where('attr_id',3)->first()->attr_value;
        }
        if($v->goods_attr->where('attr_id',4)->first()){//国药准字存在
            $v->gyzz = $v->goods_attr->where('attr_id',4)->first()->attr_value;
        }
        if($v->goods_attr->where('attr_id',5)->first()){//件装量存在
            $v->jzl = $v->goods_attr->where('attr_id',5)->first()->attr_value;
        }
        if($v->goods_attr->where('attr_id',211)->first()){//中包装存在
            $v->zbz = $v->goods_attr->where('attr_id',211)->first()->attr_value;
        }
        //2015-09-18 如果限购,获取限购标识
        $v->isXg = isXg($v->xg_type,$v->xg_start_date,$v->xg_end_date);
        //是否促销
        $v->isCx = isCx($v->is_promote,$v->promote_start_date,$v->promote_end_date);
        if(Auth::check()&&($user->ls_review=1 || ($user->ls_review_7day == 1 && $user->day7_time > time() ))) {//会员已登录 已审核
            /* 2015-7-9 在某个时间段内换购 */
            $v->is_hg = isHg($v->is_change,$v->change_start_date,$v->change_end_date,$v->change_goods_id,$user->user_rank);
            $memberPrice = userPrice($v->member_price);
            $isYl = true;
            $cxPrice = 0;//促销价
            if($v->isCx&&($user->user_rank==2||$user->user_rank==5)) {//终端才能参加促销
                $cxPrice = $v->promote_price>0?$v->promote_price:0;//促销价
                $isYl = xgYl($v->xg_type, $v->xg_start_date, $v->xg_end_date, $v->goods_id, $v->ls_ggg, $user->user_id);
                if ($isYl['isYl']==false) {//没有余量
                    $v->isXg = 0;
                    $cxPrice = 0;
                }
            }
            $kxpzPrice = kxpzPrice($v->goods_id,$v->is_kxpz);//控销价
            $v->shop_price = goodsPrice($v->shop_price,$memberPrice,$cxPrice,$kxpzPrice,$isYl['isYl']);
        }
    }
    //print_r($goods->toArray());die;
    return $goods;
}

//剂型选项
function jixing($show_area){
    $jixing = Goods::jixing($show_area);
    return $jixing;
}
function get_cache_goods($sort, $order, $goods_name, $product_name, $jx, $zm, $cat_id, $phaid,$step='',$keywords){
    $user = Auth::user();
    $goods = Goods::where(function($query) use ($user, $sort, $order, $goods_name, $product_name, $jx, $zm, $cat_id, $phaid,$keywords,$step){
        $query
            ->where('is_on_sale',1)//上架
            ->where('is_alone_sale',1)//作为普通商品销售
            ->where('is_delete',0)//没有删除
        ;
        switch($step){
            case 'nextpro':$query->where('is_promote',1)->where('promote_price','>',0)->where('promote_start_date','>',time());break;
            case 'promotion':$query->where('is_promote',1)->where('promote_price','>',0)
                ->where('promote_start_date','<=',time())->where('promote_end_date','>=',time());break;
        }
        if(Auth::check()) {
            $user_rank = $user->user_rank ;
            //2015-1-6
            if($user->user_rank==1){
                $query->where('ls_ranks','!=',1);
            }
            if($user_rank == 6 || $user_rank == 7) $user_rank = 1 ;
            $query->where(function($query) use ($user,$user_rank){
                //如果已经登陆，获取地区、会员id
                $country = $user->country ;
                $province = $user->province ;
                $city = $user->city ;
                $district = $user->district ;
                $user_id = $user->user_id ;
                if($user_rank == 1){
                    $query
                        ->where('yy_regions','not like','%.'.$country.'.%')//没有医院限制1,6,7
                        ->where('yy_regions','not like','%.'.$province.'.%')
                        ->where('yy_regions','not like','%.'.$city.'.%')
                        ->where('yy_regions','not like','%.'.$district.'.%')
                        ->where('yy_user_ids','not like','%.'.$user_id.'.%')
                        ->where('ls_ranks','not like','%'.$user->user_rank.'%');//没有等级限制;

                }else{
                    $query
                        ->where('zs_regions','not like','%.'.$country.'.%')//没有诊所限制
                        ->where('zs_regions','not like','%.'.$province.'.%')
                        ->where('zs_regions','not like','%.'.$city.'.%')
                        ->where('zs_regions','not like','%.'.$district.'.%')
                        ->where('zs_user_ids','not like','%.'.$user_id.'.%')
                        ->where('ls_ranks','not like','%'.$user_rank.'%');//没有等级限制;
                }
                $query->where('ls_regions','not like','%.'.$country.'.%')//没有区域限制
                ->where('ls_regions','not like','%.'.$province.'.%')
                    ->where('ls_regions','not like','%.'.$city.'.%')
                    ->where('ls_regions','not like','%.'.$district.'.%')
                    ->where('ls_user_ids','not like','%.'.$user_id.'.%')
                    ->orwhere('xzgm',1)
                    ->orwhere('ls_buy_user_id','like','%.'.$user_id.'.%');//允许购买的用户
            });
        }
//            if ($brand > 0) {
//                $query->where('brand_id',$brand);
//            }
        if(!empty($keywords)){
            $query->where(function($query)use($keywords){
                $query->where('ZJMID','like',"%$keywords%")->orwhere('goods_name','like',"%$keywords%");
            });
        }
        //2014-8-19
        if ($cat_id > 0|| $cat_id=='a') {
            $query->where('show_area','like','%'.$cat_id.'%');//显示区域
        }

        if ($phaid > 0) {
            $query->where('cat_ids','like','%'.$phaid.'%');//药理分类
        }

        /* 2014-6-3 */
        if ($jx) {
            $query->where('jx','=',$jx);//剂型
        }

        if ($zm) {
            $query->where('ZJMID','like','%'.$zm.'%');//助记码
        }

//            if ($min > 0) {
//                $query->where('shop_price','>=',$min);
//            }
//
//            if ($max > 0) {
//                $query->where('shop_price','<=',$max);
//            }

        if ($goods_name) {//商品名称或助记码
            $query->where(function($query) use ($goods_name){
                $query->where('goods_name','like','%'.$goods_name.'%')
                    ->orwhere('ZJMID','like','%'.$goods_name.'%');
            });
        }

        if ($product_name) {//生产厂家
            $query->where('product_name','like','%'.$product_name.'%');
        }
    })
        ->orderBy($sort,$order)->orderBy('goods_thumb','desc')
        ->select('goods_id')
        ->Paginate(40)
        //->toArray()
    ;
    return $goods;
}