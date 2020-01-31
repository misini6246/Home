<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsCart extends Model
{
    protected $table = 'ms_cart';
    protected $primaryKey = 'rec_id';

    public $dateFormat = 'U';

    const CREATED_AT = 'add_time';
    const UPDATED_AT = 'update_time';
}
