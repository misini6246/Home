<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBumen extends Model
{
    protected $table = 'user_bumen';
    protected $primaryKey = 'user_id';

    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'add_time';

    public $dateFormat = 'U';
}
