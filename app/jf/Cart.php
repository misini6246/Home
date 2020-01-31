<?php

namespace App\jf;

use Illuminate\Database\Eloquent\Model as Models;

class Cart extends Models
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $connection = 'mysql_jf';
    protected $table = 'cart';
    protected $primaryKey = 'id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联goods
    public function goods(){
        return $this->belongsTo('App\jf\Goods','goods_id','id');
    }
}
