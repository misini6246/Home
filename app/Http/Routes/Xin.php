<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2018-03-12
 * Time: 14:22
 */

namespace App\Http\Routes;


use Illuminate\Contracts\Routing\Registrar;

class Xin
{
    public function map(Registrar $router)
    {
        $router->group(['namespace' => 'Xin', 'prefix' => 'xin'], function ($router) {
            $router->get('miaosha/get_meiri', 'MiaoshaController@getMeiri')->name('xin.miaosha.get_meiri');
            $router->get('miaosha/get_zy', 'MiaoshaController@getZy')->name('xin.miaosha.get_zy');
            $router->get('miaosha/add_cart', 'MiaoshaController@addCart')->name('xin.miaosha.add_cart');
            $router->get('register/old', 'RegisterController@old')->name('xin.register.old');
            $router->get('register/step1', 'RegisterController@step1')->name('xin.register.step1');
            $router->post('register/step2', 'RegisterController@step2')->name('xin.register.step2');
            $router->get('register/step3', 'RegisterController@step3')->name('xin.register.step3');
            $router->post('register', 'RegisterController@store')->name('xin.register.store');
            $router->post('register/check_code', 'RegisterController@check_code')->name('xin.register.check_code');
            $router->get('help', 'ArticleController@help')->name('xin.help');
            $router->post('fankui', 'ArticleController@fankui')->name('xin.fankui');
            $router->resource('article', 'ArticleController', ['only' => ['index', 'show']]);
        });
    }
}