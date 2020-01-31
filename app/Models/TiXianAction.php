<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiXianAction extends Model
{
    protected $table = 'tixian_action';
    protected $primaryKey = "rec_id";
    //public $timestamps = false;

    const UPDATED_AT = 'create_time';
    const CREATED_AT = 'create_time';
    protected $dateFormat = 'U';
}
