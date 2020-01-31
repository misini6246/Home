<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JfMoneyLog extends Model
{
    protected $table = 'jf_money_log';
    protected $primaryKey = 'log_id';
    public $timestamps = false;
}
