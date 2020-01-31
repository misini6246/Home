<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZqLog extends Model
{
    protected $table = "zq_log";
    protected $primaryKey = 'log_id';
    public $timestamps = false;
}
