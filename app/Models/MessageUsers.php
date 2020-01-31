<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageUsers extends Model
{
    protected $table = 'message_users';
    protected $primaryKey = "rec_id";

    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'add_time';
    protected $dateFormat = 'U';

    public function message()
    {
        return $this->hasOne(Message::class, 'msg_id','msg_id');
    }
}
