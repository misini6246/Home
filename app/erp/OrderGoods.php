<?php

namespace App\erp;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'csc_order_goods';
    protected $primaryKey = 'order_sn';
    public $timestamps = false;
}
