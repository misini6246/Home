<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shipping extends Model
{
    protected $table = 'shipping';
    protected $primaryKey = 'shipping_id';


    /**
     * 取得可用的配送方式列表
     * @param   array   $region_id_list     收货人地区id数组（包括国家、省、市、区）
     * @return  array   配送方式数组
     */
    public static function shipping_list($region_id_list)
    {

        $query = DB::table('shipping as s')
            ->leftJoin('shipping_area as a','s.shipping_id','=','a.shipping_id')
            ->leftJoin('area_region as r','r.shipping_area_id','=','a.shipping_area_id')
            ->whereIn('r.region_id',$region_id_list)->where('s.enabled',1)->orderBy('s.shipping_order')
        ;
        return $query->select('s.shipping_id','s.shipping_code','s.shipping_name',
            's.shipping_desc','a.configure','s.support_cod','s.insure')->get();
    }
}
