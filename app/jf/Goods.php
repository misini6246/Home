<?php

namespace App\jf;

use Illuminate\Database\Eloquent\Model as Models;
use Illuminate\Support\Facades\DB;

class Goods extends Models
{
    protected $connection = 'mysql_jf';
    protected $table = 'goods';
    protected $primaryKey = 'id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    //关联 goodimg
    public function goodsImg()
    {
        return $this->hasMany('App\jf\GoodsImg', 'goods_id', 'id');
    }

    //关联cart
    public function cart()
    {
        return $this->hasMany('App\jf\Cart', 'id', 'goods_id');
    }

    public static function updateBatch($tableName = "", $multipleData = array())
    {

        if ($tableName && !empty($multipleData)) {

            // column or fields to update
            $updateColumn    = array_keys($multipleData[0]);
            $referenceColumn = $updateColumn[0]; //e.g id
            unset($updateColumn[0]);
            $whereIn = "";

            $q = "UPDATE " . $tableName . " SET ";
            foreach ($updateColumn as $uColumn) {
                $q .= $uColumn . " = CASE ";

                foreach ($multipleData as $data) {
                    $q .= "WHEN " . $referenceColumn . " = " . $data[$referenceColumn] . " THEN '" . $data[$uColumn] . "' ";
                }
                $q .= "ELSE " . $uColumn . " END, ";
            }
            foreach ($multipleData as $data) {
                $whereIn .= "'" . $data[$referenceColumn] . "', ";
            }
            $q = rtrim($q, ", ") . " WHERE " . $referenceColumn . " IN (" . rtrim($whereIn, ', ') . ")";

            // Update
            return DB::update(DB::raw($q));

        } else {
            return false;
        }
    }
}
