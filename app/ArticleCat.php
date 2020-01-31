<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCat extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'article_cat';
    protected $primaryKey = 'cat_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询article
    public function article(){
        return $this->hasMany('App\Article','cat_id');
    }
    //自连 子集查父级
    public function articleCatParent(){
        return $this->hasMany('App\ArticleCat','cat_id','parent_id');
    }
    //自连 父级查子集
    public function articleCatChild(){
        return $this->hasMany('App\ArticleCat','parent_id','cat_id');
    }
}
