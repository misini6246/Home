<?php

namespace App\erp\yongzheng;

use Illuminate\Database\Eloquent\Model;

class Keyeb extends Model
{
    protected $connection = 'sqlsrv_yz';
    protected $table = 'kcyeb';
    protected $primaryKey = 'dwbm';
    public $timestamps = false;
}
