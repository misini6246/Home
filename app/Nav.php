<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'nav';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
