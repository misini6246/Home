<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
    protected $primaryKey = "msg_id";

    const UPDATED_AT = 'add_time';
    const CREATED_AT = 'add_time';
    protected $dateFormat = 'U';

    protected $casts = [
        'start' => 'datetime',
        'end'   => 'datetime',
    ];

    public function msg_users()
    {
        return $this->hasMany(MessageUsers::class, 'msg_id');
    }
}
