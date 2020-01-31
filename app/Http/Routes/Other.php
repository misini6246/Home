<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2018-02-23
 * Time: 13:35
 */

namespace App\Http\Routes;


use Illuminate\Contracts\Routing\Registrar;

class Other
{
    public function map(Registrar $router)
    {
        $router->group(['namespace' => 'Other', 'prefix' => 'other'], function ($router) {
            $router->post('add_info', 'YzyController@add_info')->name('other.yzy_add_info');
            $router->group(['middleware' => 'check_login'], function ($router) {
                $router->put('add_c', 'YzyController@add_c')->name('other.yzy_add_c');
            });
        });
    }
}