<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class LoginBack
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
        $cookie = Cookie::get('laravel_session_17');
        if(!auth()->check()) {
            if($request->ajax()){
                $msg = '请登录后再操作';
                $assign['show'] = 1;
                $assign['show1'] = 0;
                $assign['show1_url1'] = '/auth/register';
                $assign['show1_url2'] = '/auth/login';
                $assign['show1_btn1'] = '注册';
                $assign['show1_btn2'] = '登录';
                $assign['error'] = 1;
                $assign['text'] = $msg;
                $content = response()->view('common.tanchuc',$assign)->getContent();
                $result['error'] = 1;
                $result['msg'] = $content;
                return $result;
            }else{
                $request->session()->put('login_back' . $cookie, $request->fullUrl());
            }
        }else{
            $request->session()->forget('login_back' . $cookie);
        }

        return $next($request);
    }
}
