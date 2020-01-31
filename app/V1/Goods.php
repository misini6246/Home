<?php

namespace App\V1;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'goods_id';
    protected $perPage = 40;
    public $timestamps = false;
}
