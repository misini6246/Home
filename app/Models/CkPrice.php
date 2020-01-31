<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CkPrice extends Model
{
    protected $table = 'spkc_tj';
    protected $primaryKey = 'ERPID';
    public $timestamps = false;

    protected $appends = ['is_xqpz'];

    public function getERPIDAttribute($value)
    {
        return $value;
    }

    public function getIsXqpzAttribute()
    {
        $value = 0;
        if (!empty($this->xq)) {
            $xq_end_time = strtotime('+6 month');
            if ($xq_end_time > strtotime($this->xq)) {//效期在6个月内为效期品种
                $value = 1;
            }
        }
        return $value;
    }
}
