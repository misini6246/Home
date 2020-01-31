<?php

namespace App\jf;

use Illuminate\Database\Eloquent\Model as Model;

class OrderGoods extends Models
{
    protected $connection = 'mysql_jf';
    protected $table = 'order_goods';
    protected $primaryKey = 'id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    //关联order
    public function order(){
        return $this->belongsTo('App\jf\Order','id','order_id');
    }
}
