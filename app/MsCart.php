<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsCart extends Model
{
    protected $table = 'ms_cart';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
}
