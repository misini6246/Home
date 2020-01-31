<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attribute';
    protected $primaryKey = 'attr_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询goods_attr attribute
    public function goods_attr(){
        return $this->hasMany('App\GoodsAttr','attr_id');
    }
}
