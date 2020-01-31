<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountLog extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'account_log';
    protected $primaryKey = 'log_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
