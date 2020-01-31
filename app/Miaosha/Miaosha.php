<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-09-27
 * Time: 16:25
 */

namespace App\Miaosha;


class Miaosha
{
    protected $miaosha;

    public function __construct(MiaoshaInterface $miaosha)
    {
        $this->miaosha = $miaosha;
    }

}