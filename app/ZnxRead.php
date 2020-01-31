<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZnxRead extends Model
{
    protected $table = "znx_read";
    protected $primaryKey = "rec_id";
    public $timestamps = false;

    /**
     * 查询作用域
     */
    public function scopeUser($query,$user_id){//只查询自己的订单
        return $query->where('user_id',$user_id);
    }

}
