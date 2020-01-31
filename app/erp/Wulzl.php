<?php

namespace App\erp;

use Illuminate\Database\Eloquent\Model;

class Wulzl extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'wulzl';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
