<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/19
 * Time: 11:51
 */

namespace App\Http\Controllers\Superman;


class SuperModuleFactory {
    public function makeModule($moduleName, $options)
    {
        switch ($moduleName) {
            case 'Fight':
                return new Fight($options[0], $options[1]);
            case 'Shot':
                return new Shot($options[0], $options[1], $options[2]);
        }
    }
}