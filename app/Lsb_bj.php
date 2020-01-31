<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lsb_bj extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'lsb_bj';
    protected $primaryKey = 'rec_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    public function gxywhz(){
        return $this->belongsTo('App\gxywhz_bj','djbh');
    }
}
