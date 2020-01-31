<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2018-01-12
 * Time: 16:10
 */

namespace App\Http\Routes;


use Illuminate\Contracts\Routing\Registrar;

class v2
{
    public function map(Registrar $router)
    {
        $router->group(['namespace' => 'V2', 'prefix' => 'v2'], function ($router) {
            $router->resource('goods', 'GoodsController');
        });
    }
}