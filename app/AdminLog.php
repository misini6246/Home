<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $table = 'admin_log';
    protected $primaryKey = 'log_id';
    public $timestamps = false;
}
