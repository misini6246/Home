<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberPrice extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'member_price';
    protected $primaryKey = 'price_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询goods
    public function goods(){
        return $this->belongsTo('App\goods','goods_id');
    }
    //关联查询ad
    public function cart(){
        return $this->belongsTo('App\Cart','goods_id','goods_id');
    }

    /**
     * @param $value
     * @return int
     */
    public function getUserRankAttribute($value)
    {
        return intval($value);
    }
}
