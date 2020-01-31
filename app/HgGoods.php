<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HgGoods extends Model
{
    protected $table = 'hg_goods';
    protected $primaryKey = 'rec_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;


    public function goods(){
        return $this->belongsTo('App\Goods','goods_id');
    }
}
