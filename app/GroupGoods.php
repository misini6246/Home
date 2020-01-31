<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupGoods extends Model
{
    protected $table = 'group_goods';
    protected $primaryKey = 'parent_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询goods
    public function goods(){
        return $this->belongsTo('App\Goods','goods_id');
    }
}
