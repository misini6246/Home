<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;
require_once app_path() . '/common/goods.php';
class checkCart
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
        $result = array('error' => 0, 'message' => '', 'content' => '', 'goods_id' => '');
        $goods = json_decode($request->input('goods'));
        if(empty($goods)){//数据错误 空字符串
            $result['error'] = 1;
            $result['message'] = '数据错误';
            return $result;
        }
        if (!is_numeric($goods->number) || intval($goods->number) <= 0) {
            $result['error'] = 1;
            $result['message'] = '商品数量错误';
            return $result;
        }
        //验证用户
        $user = Auth::user();
        userCheck($user,$request->ajax(),$result);//验证用户资质
        $goods_info = getGoodsInfo($goods->goods_id);
        userLimit($user,$goods_info,$request->ajax());//验证用户购买限制
        checkPeijian($goods_info->parent_id,$goods_info->is_alone_sale);//验证配件
        if($goods_info->zbz != '' || $goods_info->zbz != 0) {
            if($goods->number%$goods_info->zbz != 0) {
                $result['error'] = 1;
                $result['message'] = '该产品必须按中包装数量'.$goods_info->zbz.'的整数倍购买';
                return $result;
            }
        }
        checkXg($goods_info,$user->user_id,$goods->number);//验证限购
        $insert_arr = [
            'user_id'=>$user->user_id,
            'goods_id'=>$goods->goods_id,
            'goods_sn'=>$goods_info->goods_sn,
            'goods_name'=>$goods_info->goods_name,
            'market_price'=>$goods_info->shop_price,
            'market_price'=>$goods_info->shop_price,
            'is_real'=> $goods_info->is_real,
            'extension_code'=> $goods_info->extension_code,
            'is_gift'=> 0,
            'is_shipping'   => $goods_info->is_shipping,
            'ls_gg'   => $goods_info->ls_gg,
            'ls_bz'   => $goods_info->ls_bz,
            'suppliers_id' => $goods_info->suppliers_id ,
        ];
        return $next($request);
    }
}
