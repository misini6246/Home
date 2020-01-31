<?php

namespace App\erp;

use Illuminate\Database\Eloquent\Model;

class Lsb_bj extends Model
{
    protected $connection = 'sqlsrv_zj';
    protected $table = 'lsb_bj';
    protected $primaryKey = 'id';
    public $timestamps = false;
    //关联goods
    public function gxywhz_bj(){
        return $this->belongsTo('App\erp\Gxywhz_bj','djbh','djbh');
    }
}
