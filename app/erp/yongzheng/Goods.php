<?php

namespace App\erp\yongzheng;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $connection = 'sqlsrv_yz';
    protected $table = 'goods';
    protected $primaryKey = 'ypbm';
    public $timestamps = false;
}
