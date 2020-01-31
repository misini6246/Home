<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/5/28
 * Time: 8:41
 */

namespace App\Strategy;

use App\Yyg\Goods;

interface GoodsInterface
{
    public function done(Goods $goods);
}