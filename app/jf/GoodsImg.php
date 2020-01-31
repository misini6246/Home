<?php

namespace App\jf;

use Illuminate\Database\Eloquent\Model as Models;

class GoodsImg extends Models
{
    protected $connection = 'mysql_jf';
    protected $table = 'goods_imgs';
    protected $primaryKey = 'id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联goods
    public function goods(){
        return $this->belongsTo('App\jf\GoodsImg','id','goods_id');
    }
}
