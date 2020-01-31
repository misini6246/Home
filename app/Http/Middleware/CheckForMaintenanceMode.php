<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;


class CheckForMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance() &&
            !in_array($this->request->getClientIp(), ['123.123.123.123', '124.124.124.124']))
        {
            return response('Be right back!', 503);
        }

        return $next($request);
    }
}
