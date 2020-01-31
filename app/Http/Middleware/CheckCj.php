<?php

namespace App\Http\Middleware;

use App\UserJnmj;
use Closure;

class CheckCj
{

    private $user;

    private $user_jnmj;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * 验证登陆
         */
        if(!auth()->check()){
            if($request->ajax()==1){
                $result['error'] = 2;
                $result['url'] = '/auth/login';
                $result['msg']   = '请登录';
                return $result;
            }
            return redirect()->to('/auth/login');
        }
        $this->user = auth()->user();
        /**
         * 判断是否审核通过
         */
        if($this->user->ls_review==0){
            if($request->ajax()==1){
                $result['error'] = 1;
                $result['url'] = route('index');
                $result['msg']   = '账号未审核';
                return $result;
            }
            return view('message')->with(messageSys('审核后才能参加活动',route('index'),[
                [
                    'url'=>route('index'),
                    'info'=>'返回首页',
                ],
            ]));
        }
        return $next($request);
    }
}
