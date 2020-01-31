<?php

namespace App\jf;

use Illuminate\Database\Eloquent\Model as Models;

class News extends Models
{
    protected $connection = 'mysql_jf';
    protected $table = 'news';
    protected $primaryKey = 'id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
