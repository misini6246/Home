<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gxywhz_bj extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'gxywhz_bj';
    protected $primaryKey = 'rec_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    public function lsb(){
        return $this->hasMany('App\Lsb_bj','djbh');
    }
}
