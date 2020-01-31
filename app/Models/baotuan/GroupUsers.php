<?php

namespace App\Models\baotuan;

use Illuminate\Database\Eloquent\Model;

class GroupUsers extends Model
{
    protected $table = 'group_users';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;
}
