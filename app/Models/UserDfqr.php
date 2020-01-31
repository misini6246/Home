<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDfqr extends Model
{
    protected $table = 'user_dfqr';
    protected $primaryKey = 'user_id';

    const UPDATED_AT = 'confirm_time';
    const CREATED_AT = 'confirm_time';
    protected $dateFormat = 'U';
}
