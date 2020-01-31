<?php

namespace App\Providers;

use App\Http\Controllers\Huodong\Action\HdcxController;
use Illuminate\Support\ServiceProvider;

class HdcxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('hdcx',function(){
            return new HdcxController();
        });
        //使用bind绑定实例到接口以便依赖注入
        $this->app->bind('App\Http\Controllers\Huodong\Hdcx',function(){
            return new HdcxController();
        });
    }
}
