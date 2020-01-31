<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/19
 * Time: 15:51
 */

namespace App\Http\Controllers\Huodong;


interface Hdcx {

    public function jpzq($user,$jp_amount,$assign);

    public function czye($user,$user_jnmj,$order);

    public function jehg($user,$order,$goods,$user_jnmj);

    public function yhq($user,$order,$goods);

    public function zhekou($goods,$order,$user);

    public function tsbz_c($goods,$order,$user);

    public function create_yhq($order_info,$order,$user,$type);

    public function yhq_other($user,$order,$order_arr);
}