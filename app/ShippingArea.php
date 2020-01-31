<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingArea extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'shipping_area';
    protected $primaryKey = 'shipping_area_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
