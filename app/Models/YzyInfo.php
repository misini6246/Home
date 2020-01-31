<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YzyInfo extends Model
{
    protected $table = 'yzy_info';
    protected $primaryKey = 'id';

    protected $dateFormat = 'U';
    const CREATED_AT = 'add_time';
    const UPDATED_AT = 'add_time';
}
