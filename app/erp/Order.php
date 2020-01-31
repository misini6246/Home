<?php

namespace App\erp;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'csc_order';
    protected $primaryKey = 'order_sn';
    public $timestamps = false;
}
