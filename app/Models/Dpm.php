<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dpm extends Model
{
    protected $table = 'dpm';
    protected $primaryKey = 'group_id';

    public $timestamps = false;
}
