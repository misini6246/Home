<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $table = 'feedback';
    protected $primaryKey = 'msg_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
