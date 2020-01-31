<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAttr extends Model
{
    protected $table = 'user_attr';
    protected $primaryKey = 'user_id';

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}
