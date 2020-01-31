<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingInfo extends Model
{
    protected $table = 'shipping_info';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
