<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HongbaoMoneyLog extends Model
{
    protected $table = 'hongbao_money_log';
    protected $primaryKey = 'log_id';
    public $timestamps = false;
}
