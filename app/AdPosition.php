<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdPosition extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'ad_position';
    protected $primaryKey = 'position_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询ad
    public function ad(){
        return $this->hasMany('App\Ad','position_id');
    }
}
