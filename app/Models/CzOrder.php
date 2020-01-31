<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CzOrder extends Model
{
    protected $table = 'cz_order';
    protected $primaryKey = 'order_id';
    public $timestamps = false;
}
