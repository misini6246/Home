<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QiugouGroup extends Model
{
    const CREATED_AT = 'add_time';
    const UPDATED_AT = 'update_time';

    protected $dateFormat = 'U';

    public function group_user()
    {
        return $this->hasMany(QiugouGroupUser::class, 'group_id');
    }
}
