<?php

namespace App\jf;

use Illuminate\Database\Eloquent\Model;

class AccountLog extends Model
{
    protected $connection = 'mysql_jf';
    protected $table = 'account_log';
    protected $primaryKey = 'id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
