<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaoRu extends Model
{
    protected $table = 'daoru';
    protected $primaryKey = 'goods_id';
    public $timestamps = false;
}
