<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsAttribute extends Model
{
    protected $table = 'goods_attribute';
    protected $primaryKey = 'goods_id';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods(){
        return $this->belongsTo('App/Goods','goods_id');
    }
}
