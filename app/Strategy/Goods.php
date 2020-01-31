<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/5/28
 * Time: 8:42
 */

namespace App\Strategy;

use App\Yyg\Goods as Model;

class Goods
{
    private $object;

    public function __construct(GoodsInterface $goods)
    {
        $this->object = $goods;
    }

    public function done(Model $goods)
    {
        return $this->object->done($goods);
    }
}