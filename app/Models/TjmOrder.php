<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TjmOrder extends Model
{
    protected $table = 'tjm_order';
    public $timestamps = false;

    public $fillable = ['tjm', 'order_id', 'is_ff'];
}
