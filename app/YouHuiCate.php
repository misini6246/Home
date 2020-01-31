<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YouHuiCate extends Model
{
    protected $table = 'youhuiq_category';
    protected $primaryKey = 'cat_id';
    public $timestamps = false;

    public function yhq_attr(){
        return $this->belongsTo('App\YhqAttr','attr_id','attr_id');
    }

    public function youhuiq(){
        return $this->hasMany('App\YouHuiQ','cat_id','cat_id');
    }
}
