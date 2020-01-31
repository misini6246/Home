<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsCids extends Model
{
    protected $table = 'goods_cids';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;

    public function category1(){
        return $this->hasOne('App\Category','cat1','cat_name');
    }
}
