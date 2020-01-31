<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileCode extends Model
{
    protected $table = 'mobile_code';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;
}
