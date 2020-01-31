<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'buy';
    protected $primaryKey = 'buy_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /*
     * 求购信息
     */
    public static function buy($num){
        return static::select('buy_goods','buy_number','buy_addtime')
            ->orderBy('buy_addtime','desc')
            ->take($num)->get();
    }
}
