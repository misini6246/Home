<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YzyC extends Model
{
    protected $table = 'yzy_c';
    protected $primaryKey = 'user_id';

    const UPDATED_AT = 'add_time';
    const CREATED_AT = 'add_time';

    protected $dateFormat = 'U';
}
