<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $table = 'user_login';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;
}
