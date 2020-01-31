<?php

namespace App\erp;

use Illuminate\Database\Eloquent\Model;

class Gxywhz_bj extends Model
{
    protected $connection = 'sqlsrv_zj';
    protected $table = 'gxywhz_bj';
    protected $primaryKey = 'id';
    public $timestamps = false;
    //关联goods
    public function lsb_bj(){
        return $this->hasMany('App\erp\Lsb_bj','djbh','djbh');
    }
}
