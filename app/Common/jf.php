<?php
use App\jf\Cart;
use App\jf\News;
use App\jf\Focus;
use App\jf\Goods;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/7
 * Time: 14:52
 */
//cart_info
function jf_cart_info(){
    $cart_info = 0;
    if(Auth::check()) {
        $user = Auth::user();
        $cart_info = Cart::where('user_id', $user->user_id)->count('id');
    }
    return $cart_info;
}
/*
 * help
 */
function jf_helpList(){
    $news = News::where('cate_id',1)->select('id','name')->orderBy('id')->take(3)->get();
    return $news;
}
/**
 * 获得焦点图列表
 *
 * @access      public
 * @param       int     $pid    焦点图位置编号
 * @return      array
 */
function getFocus($pid) {
    $focusList = Focus::where('is_show',1)->where('position_id',$pid)
        ->select('img','url')
        ->orderBy('sort')
        ->get();
    return $focusList ;
}
//获取top5热榜
function getTop5() {
    $Top5 = Goods::where('is_verify',1)
        ->select('id','name','market_price','jf','goods_image')
        ->orderBy('sale_num','desc')
        ->take(5)
        ->get();
    return $Top5;
}
/**
 * 获取首页各栏目商品
 *
 * @access      public
 * @param       int     $cid    商品分类ID
 * @return      array
 */
function catGoods($cid) {
    $goods = Goods::where('is_verify',1)->where('cate_id',$cid)
        ->select('id','name','market_price','jf','goods_image')
        ->orderBy('sort','desc')
        ->take(5)->get();
    return $goods;
}
/*
 * 积分范围
 */
function jfContent($id){
    $jfContent = [
        1 => '5000积分以下',
        2 => '5000-15000',
        3 => '15000-30000',
        4 => '30000积分以上',
    ];
    if(!isset($jfContent[$id])){
        return false;
    }
    return $jfContent[$id];
}
//获取8个推荐
function getTj8() {
    $tj8 = Goods::where('is_best',1)->where('is_verify',1)
        ->select('id','name','goods_image')
        ->orderBy('sort','desc')
        ->take(8)->get();
    return $tj8;
}