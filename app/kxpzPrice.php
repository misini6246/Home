<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kxpzPrice extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'kxpz_price';
    protected $primaryKey = 'price_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联查询users kxpz_price
    public function users(){
        return $this->belongsTo('App\User','district');
    }
    //关联查询users kxpz_price
    public function usersId(){
        return $this->belongsTo('App\User','user_id');
    }
    //关联查询 kx_promote
    public function kx(){
        return $this->hasOne('App\KxPromote','price_id');
    }
}
