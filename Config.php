<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-06-13
 * Time: 16:01
 */

namespace App\Common\Alipay;


class Config
{
    private $cfg = array(
        'url'        => 'https://cebmch.swiftpass.cn',
        'mchId'      => '105570128791',
        'key'        => '261fe26dbd45cd8681cc168a0be0bd92',
        'version'    =>'1.0',
    );

    public function C($cfgName)
    {
        return $this->cfg[$cfgName];
    }
}