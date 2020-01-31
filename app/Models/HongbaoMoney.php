<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HongbaoMoney extends Model
{
    protected $table = 'hongbao_money';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    public function log_hongbao_money_change($hongbao_money, $money = 0, $change_desc = '')
    {
        $hongbao_money_log = new HongbaoMoneyLog();
        $hongbao_money_log->user_id = $hongbao_money->user_id;
        $hongbao_money_log->money = $money;
        $hongbao_money_log->change_time = time();
        $hongbao_money_log->change_desc = $change_desc;
        $hongbao_money_log->save();

        /* 更新用户信息 */
        $hongbao_money->money += $money;
        $hongbao_money->save();
    }
}
