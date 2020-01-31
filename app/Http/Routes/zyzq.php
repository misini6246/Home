<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2018-01-12
 * Time: 16:10
 */

namespace App\Http\Routes;


use Illuminate\Contracts\Routing\Registrar;

class zyzq
{
    public function map(Registrar $router)
    {
        $router->group(['namespace' => 'zyzq', 'prefix' => 'zyzq'], function ($router) {
            $router->get('/', 'IndexController@index')->name('zyzq.index');
            $router->get('/category', 'IndexController@category')->name('zyzq.category');
            $router->get('/goods', 'IndexController@goods')->name('zyzq.goods');
        });
    }
}