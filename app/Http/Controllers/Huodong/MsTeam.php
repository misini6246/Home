<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/6
 * Time: 11:54
 */

namespace App\Http\Controllers\Huodong;


interface MsTeam {

    /**
     * @param $start
     * @param $end
     * @param $team
     * @return mixed
     * 秒杀商品分组
     */
    public function team(array $team);
}