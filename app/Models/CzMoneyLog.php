<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CzMoneyLog extends Model
{

    protected $table = 'cz_money_log';
    protected $primaryKey = 'log_id';
    public $timestamps = false;
}
