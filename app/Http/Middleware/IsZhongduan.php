<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class IsZhongduan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user()->is_zhongduan();
        if ($user->is_zhongduan == 0) {//非终端
            if ($request->ajax()) {
                $msg = '只有终端可以参与';
                $result['show']  = 1;
                $result['show1'] = 1;
                $result['error'] = 1;
                $result['text']  = $msg;
                $content         = response()->view('common.tanchuc', $result)->getContent();
                $result['msg'] = $content;
                return $result;
            } else {
                show_msg('只有终端会员可以参与');
            }
        }
        return $next($request);
    }
}
