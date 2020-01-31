<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ppzq extends Model
{
    protected $table = 'ppzq';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;

    public function ad()
    {
        return $this->hasMany(Ad::class, 'ad_bgc', 'rec_id')->where('position_id', 199);
    }

    public function goods()
    {
        return $this->hasMany(Goods::class, 'brand_id', 'rec_id');
    }
}
