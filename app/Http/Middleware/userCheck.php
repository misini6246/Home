<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class userCheck
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
        if(!Auth::check()){
            if($request->ajax()) {
                $result['error'] = 1;
                $result['message'] = "请登陆后操作";
                return $result;
            }else{
                return view('message')->with(messageSys('请登录后操作','/auth/login',[
                    [
                        'url'=>'/auth/login',
                        'info'=>'前往登录',
                    ],
                ]));
            }
        }
        $user = Auth::user();
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
        if($user->ls_review==0){
            if($request->ajax()){
                $result['error'] = 1;
                $result['message'] = "未审核不能购买商品";
                return $result;
            }else {
                return view('message')->with(messageSys('未审核不能购买商品',route('index'),[
                    [
                        'url'=>route('index'),
                        'info'=>'返回首页',
                    ],
                ]));
            }
        }
        if($user->user_rank != 1){
            if($user->yyzz_time!='' && $user->yyzz_time < $time ){
                if($request->ajax()){
                    $result['error'] = 1;
                    $result['message'] = "你的营业执照已过期，请尽快重新邮寄";
                    return $result;
                }else {
                    return view('message')->with(messageSys('你的营业执照已过期，请尽快重新邮寄',route('cart.index'),[
                        [
                            'url'=>route('cart.index'),
                            'info'=>'返回购物车',
                        ],
                    ]));
                }
            }
            if($user->xkz_time!='' && $user->xkz_time < $time ){
                if($request->ajax()){
                    $result['error'] = 1;
                    $result['message'] = "你的药品经营许可证已过期，请尽快重新邮寄";
                    return $result;
                }else {
                    return view('message')->with(messageSys('你的药品经营许可证已过期，请尽快重新邮寄',route('cart.index'),[
                        [
                            'url'=>route('cart.index'),
                            'info'=>'返回购物车',
                        ],
                    ]));
                }
            }
            if($user->zs_time!='' && $user->zs_time < $time ){
                if($request->ajax()){
                    $result['error'] = 1;
                    $result['message'] = "你的GSP证书已过期，请尽快重新邮寄";
                    return $result;
                }else {
                    return view('message')->with(messageSys('你的GSP证书已过期，请尽快重新邮寄',route('cart.index'),[
                        [
                            'url'=>route('cart.index'),
                            'info'=>'返回购物车',
                        ],
                    ]));
                }
            }
            if($user->yljg_time!='' && $user->yljg_time < $time ){
                if($request->ajax()){
                    $result['error'] = 1;
                    $result['message'] = "你的医疗机构执业许可证已过期，请尽快重新邮寄";
                    return $result;
                }else {
                    return view('message')->with(messageSys('你的医疗机构执业许可证已过期，请尽快重新邮寄',route('cart.index'),[
                        [
                            'url'=>route('cart.index'),
                            'info'=>'返回购物车',
                        ],
                    ]));
                }
            }
        }
        return $next($request);
    }
}
