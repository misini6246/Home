<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class cartNum
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
        $start = strtotime('2016-06-28 08:00:00');
        $end = strtotime('2016-07-28 00:00:00');
        $now = time();
        //if($now>=$start&&$now<=$end) {
            $cart_num = Cache::tags([auth()->user()->user_id,'cart'])->get('cart_list');
            if (count($cart_num) < 2) {
                return view('message')->with(messageSys('需至少购买两个品种才能提交订单!', route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => trans('common.backToCart'),
                    ],
                ]));
            }
        //}
        return $next($request);
    }
}
