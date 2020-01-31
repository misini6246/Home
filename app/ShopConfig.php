<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopConfig extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'shop_config';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
