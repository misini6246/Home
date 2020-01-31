<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KxPromote extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'kx_promote';
    protected $primaryKey = 'kx_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询kxpz_price
    public function kxpz(){
        return $this->belongsTo('App\kxpzPrice','price_id');
    }
}
