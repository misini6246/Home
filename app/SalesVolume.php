<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesVolume extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'sales_volume';
    protected $primaryKey = 'goods_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询ad
    public function goods(){
        return $this->belongsTo('App\goods','goods_id');
    }
}
