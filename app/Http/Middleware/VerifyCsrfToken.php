<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'abc/return',
        'abc/return_zq',
        'abc/return_sj',
        'union/return',
        'union/return_zq',
        'union/return_zq_ywy',
        'union/return_zq_sy',
        'xyyh/response',
        'weixin/response',
        'weixin/new_response',
        'ht_search',
        'wx_search',
        'xyyh/duizhang',
        'abc/duizhang',
        'weixin/get_data',
        'union/duizhang',
        'alipay/notify',
        'alipay_pc/notify',
        'wechat/notify',
        'jf_money',
        'yhq',
        'buy_ms',
        'search_info',
    ];

    public function handle($request, \Closure $next)
    {
        if ($this->isReading($request) || $this->shouldPassThrough($request) || $this->tokensMatch($request)) {
            return $this->addCookieToResponse($request, $next($request));
        }
        Log::info('上一页' . $request->server('HTTP_REFERER'));
        Log::info('请求路径' . $request->server('REQUEST_URI'));
        Log::info('请求ip' . $request->ip());
        throw new TokenMismatchException;
    }
}
