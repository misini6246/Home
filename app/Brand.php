<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table='brand';
    protected $primaryKey='brand_id';
    public $timestamps = false;
    //关联goods
    public function goods(){
        return $this->hasMany('App\goods','brand_id');
    }
}
