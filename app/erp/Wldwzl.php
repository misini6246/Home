<?php

namespace App\erp;

use Illuminate\Database\Eloquent\Model;

class Wldwzl extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'wldwzl';
    protected $primaryKey = 'wldwid';
    public $timestamps = false;

}
