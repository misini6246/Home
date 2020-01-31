<?php

namespace App\Http\Middleware;

use Closure;
use App\UserAddress;
use Auth;
use Illuminate\Support\Facades\Crypt;

class jieSuan
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
        if(!UserAddress::where('user_id',Auth::user()->user_id)->first()){
            return redirect()->route('address.edit');
        }
        return $next($request);
    }
}
