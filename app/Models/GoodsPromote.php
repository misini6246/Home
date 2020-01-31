<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsPromote extends Model
{
    protected $table = 'goods_promote';
    protected $primaryKey = 'promote_id';

    public function goods_xg()
    {
        return $this->hasOne(GoodsXg::class, 'promote_id', 'promote_id');
    }
}
