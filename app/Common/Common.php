<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/10
 * Time: 9:47
 */
namespace App\Common;

use App\Goods;
use App\Http\Controllers\Controller;

class Common extends Controller{
    public function goods($user,$goods_id){
        $goods = Goods::with([
            'goods_attr'=>function($query){
                $query->with([
                    'attribute'=>function($query){
                        $query->select('attr_id','attr_name');
                    }
                ]);
            },
            'member_price'=>function($query)use($user){
                $query->where('user_rank',$user->user_rank)->select('goods_id','user_price');
            }

        ])->where(function($query)use($goods_id){
            $query->where('goods_id',$goods_id);
        }) ->select('goods_id','sales_volume','goods_name','goods_name_style','market_price','is_new','is_best','is_hot','shop_price',
            'is_zx','promote_price','goods_type','promote_start_date','promote_end_date','xg_type','xg_start_date','xg_end_date','is_promote',
            'ls_gg','ls_ggg','goods_brief','goods_number','goods_thumb','goods_img','ls_ranks','ls_regions','ls_bz','ls_sc','goods_sn',
            'goods_desc','is_pz','is_xkh_tj','is_change','change_start_date','change_end_date','change_goods_id','is_kxpz','ls_buy_user_id','xq')->get();
        //llPrint($goods,2);
        $is_no_mhj = true;//不含麻黄碱
        $goods_amount = 0;//商品总计
        $jp_amount = 0;//精品总计
        $str = "";
        $zyzk = 0;//优惠金额
        foreach($goods as $v){
            if($v->goods_number>$v->goods->goods_number){//库存不足
                return [
                    'error'=>1,
                    'message'=>$v->goods_name.'库存不足!',
                ];
            }
            if($user->user_rank==2||$user->user_rank==5){//终端用户
                $zyzk += $v->goods->zyzk;
            }
            if(strpos($v->goods->cat_ids,'427') !== false) {
                $is_no_mhj = false;
            }//end
            $str .= $v->rec_id.'_';
            $v->is_jp = 0;
            //精品
            if(strpos($v->goods->show_area,'2') !== false){
                $jp_amount += $v->goods_price * $v->goods_number;
                $v->is_jp = 1;
            }
            // 2015-4-29 中药饮片
            $v->is_zyyp = 1;
            if(strpos($v->goods->show_area,'4') !== false){
                $v->is_zyyp = 1;
            }//end
            $goods_amount += $v->goods_price * $v->goods_number;
            $v->formated_market_price = formated_price($v->goods->market_price);
            $v->formated_goods_price = formated_price($v->goods->shop_price);
            $v->formated_total = formated_price($v->goods->shop_price*$v->goods_number);
            //2015-09-18 如果限购,获取限购标识
            $v->isXg = isXg($v->goods->xg_type,$v->goods->xg_start_date,$v->goods->xg_end_date);
            //是否促销
            $v->isCx = isCx($v->goods->is_promote,$v->goods->promote_start_date,$v->goods->promote_end_date);
            if(Auth::check()&&($user->ls_review=1 || ($user->ls_review_7day == 1 && $user->day7_time > time() )) {//会员已登录 已审核
                /* 2015-7-9 在某个时间段内换购 */
                $v->is_hg = isHg($v->goods->is_change,$v->goods->change_start_date,$v->goods->change_end_date,$v->goods->change_goods_id,$user->user_rank);
                $memberPrice = userPrice($v->member_price);
                //print_r($memberPrice);die;
//            if($v->goods_id==187){
//                llPrint($v,2);
//            }
                $isYl = xgYl($v->goods->xg_type,$v->goods->xg_start_date,$v->goods->xg_end_date,$v->goods->goods_id,$v->goods->ls_ggg,$user->user_id);
                if(!$isYl){//没有余量
                    $v->isXg = 0;
                }
                $kxpzPrice = kxpzPrice($v->goods_id,$v->goods->is_kxpz);//控销价
                $cxPrice = $v->isCx==1?$v->goods->promote_price:0;//促销价
                $v->shop_price = goodsPrice($v->goods->shop_price,$memberPrice,$cxPrice,$kxpzPrice,$isYl);
            }
        }
        $goods->is_no_mhj = $is_no_mhj;
        $goods->jp_amount = $jp_amount;
        $goods->goods_amount = $goods_amount;
        $goods->order_amount = $goods_amount;
        $goods->jp_points = $jp_amount;
        $goods->zyzk = $zyzk;
        return $goods;
    }
}