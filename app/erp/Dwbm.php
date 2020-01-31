<?php

namespace App\erp;

use Illuminate\Database\Eloquent\Model;

class Dwbm extends Model
{
    protected $connection = 'sqlsrv_yz';
    protected $table = 'goods';
    protected $primaryKey = 'id';
    public $timestamps = false;
    //关联goods
    public function goods(){
        return $this->belongsTo('App\Goods','ypbm','ERPID');
    }
}
