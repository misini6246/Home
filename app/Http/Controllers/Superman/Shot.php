<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/19
 * Time: 11:57
 */

namespace App\Http\Controllers\Superman;


class Shot {
    protected $atk;
    protected $range;
    protected $limit;
    public function __construct($atk, $range, $limit) {
        $this->atk = $atk;
        $this->range = $range;
        $this->limit = $limit;
    }
}