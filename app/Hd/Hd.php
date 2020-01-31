<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-09-27
 * Time: 15:17
 */

namespace App\Hd;


class Hd
{

    protected $hd;

    public function __construct(HdInterface $hd)
    {
        $this->hd = $hd;
    }


}