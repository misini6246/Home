<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiXian extends Model
{
    protected $table = 'tixian';
    protected $primaryKey = "tx_id";
    //public $timestamps = false;

    const UPDATED_AT = 'update_time';
    const CREATED_AT = 'create_time';
    protected $dateFormat = 'U';

    public function tx_action()
    {
        return $this->hasMany(TiXianAction::class, 'tx_id', 'tx_id');
    }
}
