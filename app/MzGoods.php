<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MzGoods extends Model
{
    protected $table = 'mz_goods';
    protected $primaryKey = 'mz_id';

    public function goods()
    {
        return $this->hasOne('App\Goods', 'goods_id','goods_id');
    }

    public function goods_zp()
    {
        return $this->hasOne('App\Models\GoodsZp', 'goods_id','goods_id')->where('is_delete',0);
    }
}
