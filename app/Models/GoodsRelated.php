<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsRelated extends Model
{
    protected $table = 'goods_related';
    protected $primaryKey = 'goods_id';
    public $timestamps = false;

    public function goods()
    {
        return $this->hasOne(\App\Goods::class, 'goods_id', 'related');
    }
}
