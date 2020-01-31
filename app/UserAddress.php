<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_address';
    protected $primaryKey = 'address_id';
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
        return $this->belongsTo('App\Region', 'district', 'region_id');
    }

    public function getConsigneeAttribute($value)
    {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getCountryAttribute($value)
    {
        if (is_null($value)) {
            $value = 1;
        }
        return $value;
    }

    public function getProvinceAttribute($value)
    {
        if (is_null($value)) {
            $value = 0;
        }
        return $value;
    }

    public function getCityAttribute($value)
    {
        if (is_null($value)) {
            $value = 0;
        }
        return $value;
    }

    public function getDistrictAttribute($value)
    {
        if (is_null($value)) {
            $value = 0;
        }
        return $value;
    }

    public function getAddressAttribute($value)
    {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getZipcodeAttribute($value)
    {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getTelAttribute($value)
    {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getMobileAttribute($value)
    {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getEmailAttribute($value)
    {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getBestTimeAttribute($value)
    {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }

    public function getSignBuildingAttribute($value)
    {
        if (is_null($value)) {
            $value = '';
        }
        return $value;
    }
}
