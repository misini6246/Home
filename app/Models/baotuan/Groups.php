<?php

namespace App\Models\baotuan;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'gid';
    public $timestamps = false;

    public function group_users()
    {
        return $this->hasMany('App\Models\baotuan\GroupUsers','gid');
    }
}
