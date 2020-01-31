<?php

namespace App\Http\Middleware;

use Closure;
use App\Goods;

class checkSale
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
        $goods_id = $request->input('id');
        $goods = Goods::where('goods_id',$goods_id)
            ->where('is_on_sale',1)->where('is_delete',0)
            ->where('is_alone_sale',1)->pluck('goods_id');
        if(empty($goods)) {//商品不存在跳转首页
            return redirect()->route('index');
        }
        //print_r($next($request));die;
        return $next($request);
    }
}
