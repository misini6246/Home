<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = "region";
    protected $primaryKey = 'region_id';
    public $timestamps = false;
    //关联查询userAddress country
    public function userAddressCountry(){
        return $this->hasMany('App\UserAddress','region_id','country');
    }
    //关联查询userAddress province
    public function userAddressProvince(){
        return $this->hasMany('App\UserAddress','region_id','province');
    }
    //关联查询userAddress city
    public function userAddressCity(){
        return $this->hasMany('App\UserAddress','region_id','city');
    }
    //关联查询userAddress district
    public function userAddressDistrict(){
        return $this->hasMany('App\UserAddress','region_id','district');
    }

    public function child(){
        return $this->hasMany(Region::class,'parent_id','region_id');
    }
}
