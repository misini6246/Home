<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YouHuiQ extends Model
{
    protected $table = 'youhuiq';
    protected $primaryKey = 'yhq_id';
    public $timestamps = false;

    public function yhq_cate()
    {
        return $this->belongsTo(YouHuiCate::class, 'cat_id', 'cat_id');
    }
}
