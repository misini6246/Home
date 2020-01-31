<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-06-12
 * Time: 16:10
 */

namespace App\Common;


trait NewCommon
{

    private function check_auth(){
        if(!auth()->check()){
            ajax_return('请登录后操作',2);
        }
    }

}