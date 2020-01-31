<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'article';
    protected $primaryKey = 'article_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询article_cat
    public function articleCat(){
        return $this->belongsTo('App\ArticleCat','cat_id');
    }
}
