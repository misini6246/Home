<?php

namespace App\erp\yongzheng;

use Illuminate\Database\Eloquent\Model;

class Wldw extends Model
{
    protected $connection = 'sqlsrv_yz';
    protected $table = 'wldw';
    protected $primaryKey = 'dwbm';
    public $timestamps = false;

}
