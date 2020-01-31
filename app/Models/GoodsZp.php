<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsZp extends Model
{
    protected $table = 'goods_zp';
    protected $primaryKey = 'id';

    const UPDATED_AT = 'add_time';
    const CREATED_AT = 'add_time';

    protected $dateFormat = 'U';

    protected $dates = ['start', 'end'];

    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id', 'goods_id');
    }

    public function zp()
    {
        return $this->hasOne(ZpGoods::class, 'goods_id', 'zp_id');
    }
}
