<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2018-02-05
 * Time: 10:25
 */

namespace App\Http\Routes;

use Illuminate\Contracts\Routing\Registrar;

class jifen
{
    public function map(Registrar $router)
    {
        $router->group(['namespace' => 'Jifen', 'prefix' => 'jifen'], function ($router) {
            $router->get('/', 'IndexController@index')->name('jifen.index');
            $router->get('help', 'IndexController@help')->name('jifen.help');
            $router->group(['middleware' => 'check_login'], function ($router) {
                $router->post('cart/jiesuan', 'CartController@jiesuan')->name('jifen.cart.jiesuan');
                $router->resource('cart', 'CartController', ['only' => ['index', 'store', 'update', 'destroy']]);
                $router->post('address/set_default', 'UserAddressController@set_default');
                $router->resource('address', 'UserAddressController');
                $router->get('order/index', 'OrderController@index')->name('jifen.order');
                $router->resource('order', 'OrderController', ['except' => 'destroy']);
                $router->resource('user', 'UserController', ['except' => 'destroy']);
                $router->post('qiandao/change_date', 'QianDaoController@changeDate')->name('jifen.qiandao.change_date');
                $router->resource('qiandao', 'QianDaoController', ['except' => 'destroy']);
                $router->resource('jf_money', 'JfMoneyController', ['only' => ['index', 'store']]);
            });
            $router->resource('goods', 'GoodsController', ['only' => ['show', 'index']]);
        });
    }
}