<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2018-01-12
 * Time: 10:34
 */

namespace App\Http\Routes;


use Illuminate\Contracts\Routing\Registrar;

class Hd
{
    public function map(Registrar $router)
    {
        $router->group(['middleware' => 'auth', 'namespace' => 'Hdzx', 'prefix' => 'hdzx'], function ($router) {
            $router->resource('dzp', 'DaZhuanPanController');
        });
    }
}