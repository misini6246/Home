<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsGroup extends Model
{
    protected $table = 'ms_group';
    protected $primaryKey = 'group_id';

    protected $casts = [
        'type'       => 'integer',
        'group_name' => 'string',
    ];

    public function ms_goods()
    {
        return $this->hasMany(MsGoods::class, 'group_id', 'group_id');
    }
}
