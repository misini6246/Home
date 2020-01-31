<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2018-01-26
 * Time: 17:06
 */

namespace App\Http\Routes;


use Illuminate\Contracts\Routing\Registrar;

class zs
{
    public function map(Registrar $router)
    {
        $router->group(['namespace' => 'Zs', 'prefix' => 'zs'], function ($router) {
            $router->get('/', 'IndexController@index')->name('zs.index');
        });
    }
}