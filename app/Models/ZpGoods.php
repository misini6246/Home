<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZpGoods extends Model
{
    protected $table = 'zp_goods';
    protected $primaryKey = 'goods_id';
    public $timestamps = false;
}
