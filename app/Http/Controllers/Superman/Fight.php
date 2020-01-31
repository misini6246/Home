<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/19
 * Time: 11:53
 */

namespace App\Http\Controllers\Superman;


class Fight {
    protected $speed;
    protected $holdtime;
    public function __construct($speed, $holdtime) {
        $this->speed = $speed;
        $this->holdtime = $holdtime;
    }
}