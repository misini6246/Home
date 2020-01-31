<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCj extends Model
{
    protected $table = 'user_cj';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
}
