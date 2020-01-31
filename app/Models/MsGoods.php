<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsGoods extends Model
{
    protected $table = 'ms_goods';
    protected $primaryKey = 'rec_id';

    protected $casts = [
        'goods_id'      => 'integer',
        'real_price'    => 'float',
        'old_price'     => 'float',
        'goods_number'  => 'integer',
        'cart_number'   => 'integer',
        'xg_number'     => 'integer',
        'group_id'      => 'integer',
        'is_can_change' => 'integer',
    ];

    public function getAreaXgAttribute($value)
    {
        if (!empty($value)) {
            $value = explode('.', trim($value, '.'));
        } else {
            $value = [];
        }
        return $value;
    }
}
