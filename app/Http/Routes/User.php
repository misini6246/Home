<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-12-04
 * Time: 14:39
 */

namespace App\Http\Routes;


use Illuminate\Contracts\Routing\Registrar;

class User
{
    public function map(Registrar $router)
    {
        $router->group(['middleware' => 'auth', 'namespace' => 'User', 'prefix' => 'member'], function ($router) {
            $router->get('/', 'IndexController@index')->name('member.index');
            $router->put('/', 'IndexController@update')->name('member.update');
            $router->get('zncg', 'IndexController@zncg')->name('member.zncg');
            $router->get('youhuiq', 'IndexController@youhuiq')->name('member.youhuiq');
            $router->get('money', 'IndexController@money')->name('member.money');
            $router->get('jf_money_log', 'IndexController@jf_money_log')->name('member.jf_money_log');
            $router->get('hongbao_money_log', 'IndexController@hongbao_money_log')->name('member.hongbao_money_log');
            $router->get('info', 'IndexController@info')->name('member.info');
            $router->get('buy', 'IndexController@buy')->name('member.buy');
            $router->get('fankui', 'IndexController@fankui')->name('member.fankui');
            $router->get('pswl', 'IndexController@pswl')->name('member.pswl');
            $router->post('set_wl', 'IndexController@set_wl')->name('member.set_wl');
            $router->get('order/wlxx', 'OrderController@wlxx')->name('member.order.wlxx');
            $router->get('order/guotong', 'OrderController@guotong')->name('member.order.guotong');
            $router->resource('order', 'OrderController', ['only' => ['index', 'show', 'update', 'store']]);
            $router->resource('collection', 'CollectionController', ['only' => ['index', 'destroy', 'store']]);
            $router->post('duohuiyuan/check_yzm', 'DuoHuiYuanController@check_yzm')->name('member.duohuiyuan.check_yzm');
            $router->post('duohuiyuan/set_pwd', 'DuoHuiYuanController@set_pwd')->name('member.duohuiyuan.set_pwd');
            $router->resource('duohuiyuan', 'DuoHuiYuanController', ['only' => ['index', 'destroy', 'store']]);
            $router->resource('wodexiaoxi', 'WoDeXiaoXiController', ['only' => ['index', 'destroy', 'update']]);
            $router->any('get_region', 'UserAddressController@get_region')->name('member.get_region');
            $router->resource('address', 'UserAddressController', ['only' => ['index', 'store']]);
            $router->get('zq_log', 'ZqOrderController@zq_log')->name('member.zq_log');
            $router->resource('zq_order', 'ZqOrderController', ['only' => ['index', 'show']]);
            $router->resource('cz_order', 'CzOrderController', ['only' => ['index', 'show']]);
        });
        $router->post('generate_tjm', 'User\IndexController@generateTjm')->name('member.generate_tjm')->middleware('check_login');
    }
}