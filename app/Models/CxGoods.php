<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CxGoods extends Model
{
    protected $table = 'cx_goods';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;

    public function goods()
    {
        return $this->belongsTo(\App\Goods::class, 'goods_id');
    }
}
