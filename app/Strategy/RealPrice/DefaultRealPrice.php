<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/7/4
 * Time: 16:36
 */

namespace App\Strategy\RealPrice;


use App\Strategy\GoodsInterface;
use App\Yyg\Goods;

class DefaultRealPrice implements GoodsInterface
{
    protected $goods;

    protected $user;

    public function done(Goods $goods)
    {
        $this->user = auth()->user();
        $this->goods = $goods;
        return 0;
    }
}