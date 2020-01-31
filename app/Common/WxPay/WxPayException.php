<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/10/16
 * Time: 10:45
 */

namespace App\Common\WxPay;


class WxPayException extends \Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }
}