<?php

namespace App\jf;

use Illuminate\Database\Eloquent\Model as Models;

class UserAddress extends Models
{
    protected $connection = 'mysql_jf';
    protected $table = 'user_address';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['consignee', 'user_id', 'email', 'country',
        'province', 'city', 'district', 'address', 'tel', 'mobile',
        'sign_building', 'best_time', 'zipcode'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];
    public $timestamps = false;

    //关联查询region country
    public function regionCountry()
    {
        return $this->belongsTo('App\Region', 'country', 'region_id');
    }

    //关联查询region province
    public function regionProvince()
    {
        return $this->belongsTo('App\Region', 'province', 'region_id');
    }

    //关联查询region city
    public function regionCity()
    {
        return $this->belongsTo('App\Region', 'city', 'region_id');
    }

    //关联查询region district
    public function regionDistrict()
    {
        return $this->belongsTo('App\Region', 'area', 'region_id');
    }
}
