<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QiugouGroupUser extends Model
{
    const CREATED_AT = 'add_time';
    const UPDATED_AT = 'update_time';

    protected $dateFormat = 'U';

    public function group()
    {
        return $this->belongsTo(QiugouGroup::class, 'group_id', 'id');
    }
}
