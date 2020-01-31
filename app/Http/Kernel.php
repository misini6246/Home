<?php

namespace App\Http;

use App\Http\Middleware\CheckLogin;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        //\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //\App\Http\Middleware\VerifyCsrfToken::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\tongji::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'         => \App\Http\Middleware\Authenticate::class,
        'check.xg'     => \App\Http\Middleware\checkXg::class,
        'auth.basic'   => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'        => \App\Http\Middleware\RedirectIfAuthenticated::class,
        //goods操作
        'check.xg'     => \App\Http\Middleware\checkXg::class,
        'check.sale'   => \App\Http\Middleware\checkSale::class,
        //商店基本配置
        'shop.config'  => \App\Http\Middleware\shop::class,
        //添加购物车
        'cart'         => \App\Http\Middleware\checkCart::class,
        //ajax路由限制
        'ajax'         => \App\Http\Middleware\Ajax::class,
        //结算验证
        'jiesuan'      => \App\Http\Middleware\jieSuan::class,
        //用户资质验证
        'user.check'   => \App\Http\Middleware\userCheck::class,
        //用户是否有购买某类商品的权限
        'cat.check'    => \App\Http\Middleware\catCheck::class,
        //订单确认 提交
        'order.check'  => \App\Http\Middleware\orderCheck::class,
        //md5转hash
        'md5ToHash'    => \App\Http\Middleware\md5Tohash::class,
        //md5转hash
        'cartNum'      => \App\Http\Middleware\cartNum::class,
        //抽奖资格
        'check_cj'     => \App\Http\Middleware\CheckCj::class,
        //登陆成功返回页面
        'login_back'   => \App\Http\Middleware\LoginBack::class,
        //验证终端
        'is_zhongduan' => \App\Http\Middleware\IsZhongduan::class,
        //验证登录
        'check_login'  => CheckLogin::class,
    ];
}
