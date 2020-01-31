<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/6
 * Time: 11:54
 */

namespace App\Http\Controllers\Huodong;


interface MsGoods {

    /**
     * @param array $goods
     * @return mixed
     * 秒杀商品
     */
    public function goods(array $goods);
}