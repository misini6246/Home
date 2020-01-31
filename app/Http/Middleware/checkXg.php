<?php

namespace App\Http\Middleware;

use Closure;
use App\Goods;
use Auth;

class checkXg
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*
     * 判断商品是否不能购买
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $goods_id = $request->input('id');
        //查询商品是限购
        $goods = Goods::where('goods_id',$goods_id)->where(function($query)use($user){
            $user_rank = $user->user_rank ;
            //2015-1-6
            if($user_rank == 6 || $user_rank == 7) $user_rank = 1 ;
                //如果已经登陆，获取地区、会员id
            $country = $user->country ;
            $province = $user->province ;
            $city = $user->city ;
            $district = $user->district ;
            $user_id = $user->user_id ;
            if($user_rank == 1){
                $query
                    ->where('yy_regions','not like','%'.$country.'%')//没有医院限制1,6,7
                    ->where('yy_regions','not like','%'.$province.'%')
                    ->where('yy_regions','not like','%'.$city.'%')
                    ->where('yy_regions','not like','%'.$district.'%')
                    ->where('yy_user_ids','not like','%'.$user_id.'%');

            }else{
                $query
                    ->where('zs_regions','not like','%'.$country.'%')//没有诊所限制
                    ->where('zs_regions','not like','%'.$province.'%')
                    ->where('zs_regions','not like','%'.$city.'%')
                    ->where('zs_regions','not like','%'.$district.'%')
                    ->where('zs_user_ids','not like','%'.$user_id.'%');
            }
            $query->where('ls_regions','not like','%'.$country.'%')//没有区域限制
            ->where('ls_regions','not like','%'.$province.'%')
                ->where('ls_regions','not like','%'.$city.'%')
                ->where('ls_regions','not like','%'.$district.'%')
                ->where('ls_user_ids','not like','%'.$user_id.'%')
                ->where('ls_ranks','not like','%'.$user_rank.'%')//没有等级限制
                ->orwhere('ls_buy_user_id','like','%'.$user_id.'%');//允许购买的用户
        })->first();
        if(empty($goods)){//商品不存在返回首页
            return redirect()->route('index');
        }
        return $next($request);
    }
}
