<?php

namespace App\jf;

use Illuminate\Database\Eloquent\Model as Models;

class Order extends Models
{
    protected $connection = 'mysql_jf';
    protected $table = 'order';
    protected $primaryKey = 'id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联order goods
    public function goods(){
        return $this->hasMany('App\jf\OrderGoods','order_id','id');
    }
    //关联order address
    public function address(){
        return $this->hasOne('App\jf\OrderAddress','order_id','id');
    }
}
