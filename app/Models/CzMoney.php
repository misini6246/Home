<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CzMoney extends Model
{
    protected $table = 'cz_money';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function log_cz_money_change($cz_money, $money = 0, $change_desc = '', $order_id = 0)
    {
        $cz_money_log              = new CzMoneyLog();
        $cz_money_log->user_id     = $cz_money->user_id;
        $cz_money_log->money       = $money;
        $cz_money_log->change_time = time();
        $cz_money_log->change_desc = $change_desc;
        $cz_money_log->order_id    = $order_id;
        $cz_money_log->save();

        /* 更新用户信息 */
        $cz_money->money += $money;
        $cz_money->save();
    }
}
