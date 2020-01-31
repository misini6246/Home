<?php

namespace App\erp;

use Illuminate\Database\Eloquent\Model;

class Xschmx extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'xschmx';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;
}
