<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsGoods extends Model
{
    protected $table = 'ms_goods';
    protected $primaryKey = 'goods_id';
    public $timestamps = false;
}
