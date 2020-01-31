<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftGoods extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'gift_goods';
    protected $primaryKey = 'gift_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
