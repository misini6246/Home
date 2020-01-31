<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'category';
    protected $primaryKey = 'cat_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    public function cate(){
        return $this->hasMany('App\Category','parent_id','cat_id');
    }

    public function cate1(){
        return $this->hasOne('App\Category','cat_id','parent_id');
    }
}
