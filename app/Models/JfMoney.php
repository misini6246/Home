<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JfMoney extends Model
{
    protected $table = 'jf_money';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    public function log_jf_money_change($jf_money, $money = 0, $change_desc = '')
    {
        $jf_money_log = new JfMoneyLog();
        $jf_money_log->user_id = $jf_money->user_id;
        $jf_money_log->money = $money;
        $jf_money_log->change_time = time();
        $jf_money_log->change_desc = $change_desc;
        $jf_money_log->save();

        /* 更新用户信息 */
        $jf_money->money += $money;
        $jf_money->save();
    }

    public function rules()
    {
        $arr = [
            10 => 4000,
            20 => 8000,
            30 => 12000,
            40 => 16000,
            50 => 20000,
        ];
        return $arr;
    }
}
