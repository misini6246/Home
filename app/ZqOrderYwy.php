<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZqOrderYwy extends Model
{
    protected $table = 'zq_order_ywy';
    protected $primaryKey = 'zq_id';
    public $timestamps = false;

    //关联order_info
    public function order_info(){
        return $this->hasMany('App\OrderInfo','zq_id');
    }
}
