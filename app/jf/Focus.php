<?php

namespace App\jf;

use Illuminate\Database\Eloquent\Model as Models;

class Focus extends Models
{
    protected $connection = 'mysql_jf';
    protected $table = 'focus';
    protected $primaryKey = 'id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
