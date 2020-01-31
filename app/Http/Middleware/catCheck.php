<?php

namespace App\Http\Middleware;

use App\Cart;
use App\Goods;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class catCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $goods = $request->input('goods','');
        $goods = json_decode($goods);
        $goods_info = Goods::where('goods_id',$goods->goods_id)
            ->select('cat_ids','goods_id','sales_volume','goods_name','goods_name_style','market_price','is_new','is_best','is_hot','shop_price',
                'is_zx','promote_price','goods_type','promote_start_date','promote_end_date','xg_type','xg_start_date','xg_end_date','is_promote',
                'ls_gg','ls_ggg','goods_brief','goods_number','goods_thumb','goods_img','ls_ranks','ls_regions','ls_bz','ls_sc','goods_sn',
                'is_real','extension_code','is_shipping','suppliers_id','zs_regions','zs_user_ids','yy_regions','yy_user_ids',
                'goods_desc','is_pz','is_xkh_tj','is_change','change_start_date','change_end_date','change_goods_id','is_kxpz','ls_buy_user_id','xq')
            ->first();
        if($goods_info->shop_price<=0){
            if($request->ajax()){
                $result['error'] = 1;
                $result['message'] = "价格正在制定中!";
                return $result;
            }else {
                return view('message')->with(messageSys('价格正在制定中!',route('cart.index'),[
                    [
                        'url'=>route('cart.index'),
                        'info'=>'返回购物车',
                    ],
                ]));
            }
        }
        $user = Auth::user();
        $user_rank_o = $user->user_rank;
        if($user_rank_o == 6 || $user_rank_o == 7) $user_rank_o = 1 ;
        if(strpos($goods_info->show_area,'4') !== false && $user->ls_mzy == 1) {
            if($request->ajax()){
                $result['error'] = 1;
                $result['message'] = "你没有购买中药饮片的权限，如须购买请联系客服人员";
                return $result;
            }else {
                return view('message')->with(messageSys('你没有购买中药饮片的权限，如须购买请联系客服人员',route('cart.index'),[
                    [
                        'url'=>route('cart.index'),
                        'info'=>'返回购物车',
                    ],
                ]));
            }
        }
        if(strpos($goods_info->cat_ids,'180') !== false && $user->mhj_number == 0) {
            if($request->ajax()){
                $result['error'] = 1;
                $result['message'] = "你没有购买麻黄碱的权限，如须购买请联系客服人员";
                return $result;
            }else {
                return view('message')->with(messageSys('你没有购买麻黄碱的权限，如须购买请联系客服人员',route('cart.index'),[
                    [
                        'url'=>route('cart.index'),
                        'info'=>'返回购物车',
                    ],
                ]));
            }
        }

        // 2015-5-12 诊所不能购买食品
        if(strpos($goods_info->cat_ids,'398') !== false && $user_rank_o == 5) {
            if($request->ajax()){
                $result['error'] = 1;
                $result['message'] = "你没有购买食品的权限，如须购买请联系客服人员";
                return $result;
            }else {
                return view('message')->with(messageSys('你没有购买食品的权限，如须购买请联系客服人员',route('cart.index'),[
                    [
                        'url'=>route('cart.index'),
                        'info'=>'返回购物车',
                    ],
                ]));
            }
        }
        //判断该商品是否对会员等级限购
        $ls_ranks = explode(',',$goods_info->ls_ranks);
        if(!empty($goods_info->ls_ranks)&&in_array($user->user_rank,$ls_ranks) !== false){
            if($request->ajax()){
                $result['error'] = 1;
                $result['message'] = "你没有购买该商品的权限，如须购买请联系客服人员";
                return $result;
            }else {
                return view('message')->with(messageSys('你没有购买该商品的权限，如须购买请联系客服人员',route('cart.index'),[
                    [
                        'url'=>route('cart.index'),
                        'info'=>'返回购物车',
                    ],
                ]));
            }
        }
        //判断该商品是否对地区限购
        if(!empty($goods_info->ls_regions)){
            $ls_country = strpos($goods_info->ls_regions,'.'.$user->country.'.');
            $ls_province = strpos($goods_info->ls_regions,'.'.$user->province.'.');
            $ls_city = strpos($goods_info->ls_regions,'.'.$user->city.'.');
            $ls_district = strpos($goods_info->ls_regions,'.'.$user->district.'.');
            if($ls_country!==false||$ls_province!==false||$ls_city!==false||$ls_district!==false) {
                if ($request->ajax()) {
                    $result['error'] = 1;
                    $result['message'] = "你没有购买该商品的权限，如须购买请联系客服人员";
                    return $result;
                } else {
                    return view('message')->with(messageSys('你没有购买该商品的权限，如须购买请联系客服人员', route('cart.index'), [
                        [
                            'url' => route('cart.index'),
                            'info' => '返回购物车',
                        ],
                    ]));
                }
            }
        }
        //判断商品是否对医药公司限购
        if((!empty($goods_info->yy_regions)||!empty($goods_info->yy_user_ids))&&$user_rank_o==1){
            $ls_country = strpos($goods_info->yy_regions,'.'.$user->country.'.');
            $ls_province = strpos($goods_info->yy_regions,'.'.$user->province.'.');
            $ls_city = strpos($goods_info->yy_regions,'.'.$user->city.'.');
            $ls_district = strpos($goods_info->yy_regions,'.'.$user->district.'.');
            $ls_user = strpos($goods_info->yy_user_ids,'.'.$user->user_id.'.');
            if($ls_country!==false||$ls_province!==false||$ls_city!==false||$ls_district!==false||$ls_user!==false) {
                if ($request->ajax()) {
                    $result['error'] = 1;
                    $result['message'] = "你没有购买该商品的权限，如须购买请联系客服人员";
                    return $result;
                } else {
                    return view('message')->with(messageSys('你没有购买该商品的权限，如须购买请联系客服人员', route('cart.index'), [
                        [
                            'url' => route('cart.index'),
                            'info' => '返回购物车',
                        ],
                    ]));
                }
            }
        }
        //判断商品是否对终端限购
        if((!empty($goods_info->zs_regions)||!empty($goods_info->zs_user_ids))&&$user_rank_o!=1){
            $ls_country = strpos($goods_info->zs_regions,'.'.$user->country.'.');
            $ls_province = strpos($goods_info->zs_regions,'.'.$user->province.'.');
            $ls_city = strpos($goods_info->zs_regions,'.'.$user->city.'.');
            $ls_district = strpos($goods_info->zs_regions,'.'.$user->district.'.');
            $ls_user = strpos($goods_info->zs_user_ids,'.'.$user->user_id.'.');
            if($ls_country!==false||$ls_province!==false||$ls_city!==false||$ls_district!==false||$ls_user!==false) {
                if ($request->ajax()) {
                    $result['error'] = 1;
                    $result['message'] = "你没有购买该商品的权限，如须购买请联系客服人员";
                    return $result;
                } else {
                    return view('message')->with(messageSys('你没有购买该商品的权限，如须购买请联系客服人员', route('cart.index'), [
                        [
                            'url' => route('cart.index'),
                            'info' => '返回购物车',
                        ],
                    ]));
                }
            }
        }
//        //判断商品库存
//        $zbz = $goods_info->goods_attr->where('attr_id',211)->first();
//        $num = $this->goodsNum($goods_info->ls_gg,$zbz);
//        if($num>$goods_info->goods_number){
//            if ($request->ajax()) {
//                $result['error'] = 1;
//                $result['message'] = "库存不足";
//                return $result;
//            } else {
//                return view('message')->with(messageSys('库存不足', route('cart.index'), [
//                    [
//                        'url' => route('cart.index'),
//                        'info' => '返回购物车',
//                    ],
//                ]));
//            }
//        }
//        $goods_info->goods_number = $num;
        Cache::tags([$user->user_id,'cart'])->put($goods->goods_id,$goods_info,1);
        //Cache::tags(['people', 'artists'])->put('John', 1);
        //llPrint($num);
        return $next($request);
    }
    /*
     * 判断商品最低购买量
     *
     * @ls_gg 最低购买量
     * @zbz 中包装
     */
    protected function goodsNum($ls_gg,$zbz){
        $num = 1;//最低够买1个
        if($ls_gg!=0){
            $num = intval($ls_gg);
        }elseif($zbz){
            $num = intval($zbz->attr_value);
        }
        return $num;
    }
}
