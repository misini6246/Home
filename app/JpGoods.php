<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JpGoods extends Model
{
    protected $table = 'jp_goods';
    protected $primaryKey = 'jp_id';
    public $timestamps = false;
}
