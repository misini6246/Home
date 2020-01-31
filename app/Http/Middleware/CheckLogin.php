<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\UnauthorizedException;
use Illuminate\Support\Facades\Cookie;

class CheckLogin
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
        $cookie = Cookie::get('laravel_session_17');
        if (auth()->guest()) {
            if ($request->ajax()) {
                throw new UnauthorizedException();
            } else {
                $request->session()->put('login_back' . $cookie, $request->fullUrl());
                return redirect()->guest('auth/login');
            }
        }
        $request->session()->forget('login_back' . $cookie);
        return $next($request);
    }
}
