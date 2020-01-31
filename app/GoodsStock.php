<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsStock extends Model
{
    protected $table = 'goods_stock';
    protected $primaryKey = 'id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
