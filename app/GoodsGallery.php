<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsGallery extends Model
{
    protected $table = 'goods_gallery';
    protected $primaryKey = 'img_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询goods goods_gallery
    public function goods(){
        return $this->belongsTo('App\goods','goods_id');
    }
}
