<?php

namespace App\Http\Middleware;

use App\XyyhKjzf;
use Closure;

class XyyhRz
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
        $this->user = auth()->user();
        $xyyh_kjzf = XyyhKjzf::where('user_id',$this->user->user_id)->where('type',1)->first();
        if(!$xyyh_kjzf){
            return redirect()->route('xyyh.renzheng');
        }
        return $next($request);
    }
}
