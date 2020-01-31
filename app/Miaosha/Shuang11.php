<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-09-27
 * Time: 16:28
 */

namespace App\Miaosha;


use App\Models\MsGroup;

class Shuang11 implements MiaoshaInterface
{

    public function init()
    {
        $ms_group = MsGroup::with('ms_goods')->where('')->get();
    }

}