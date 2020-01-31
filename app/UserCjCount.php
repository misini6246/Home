<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCjCount extends Model
{
    protected $table = 'user_cj_count';
    protected $primaryKey = 'user_id';
    public $timestamps;
}
