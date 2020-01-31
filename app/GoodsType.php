<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsType extends Model
{
    protected $table = 'goods_type';
    protected $primaryKey = 'cat_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询goods goods_type
    public function goods(){
        return $this->hasMany('App\goods','cat_id','goods_type');
    }
}
