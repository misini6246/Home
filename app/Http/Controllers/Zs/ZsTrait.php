<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2018-01-26
 * Time: 16:07
 */

namespace App\Http\Controllers\Zs;


trait ZsTrait
{
    protected $user;

    protected $now;

    protected $assign;

    protected function set_assign($key, $value)
    {
        $this->assign[$key] = $value;
    }


    protected function common_value()
    {
        $this->set_assign('user', $this->user);
        $this->set_assign('now', $this->now);
        $this->set_assign('page_title', '诊所专区-');
    }
}