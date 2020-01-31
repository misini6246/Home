<?php

namespace App\jf;


class QianDao extends Model
{
    protected $table = 'qiandao';
    public $timestamps = false;

    /**
     * 按照用户查找
     * @param $query
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Builder;
     */
    public function scopeUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function jf_rules()
    {
        return [
            1 => 50,
            2 => 50,
            3 => 50,
            4 => 50,
            5 => 50,
            6 => 50,
            7 => 50,
            8 => 150,
            9 => 150,
            10 => 150,
            11 => 150,
            12 => 150,
            13 => 150,
            14 => 150,
            15 => 300,
            16 => 300,
            17 => 300,
            18 => 300,
            19 => 300,
            20 => 300,
            21 => 300,
            22 => 500,
            23 => 500,
            24 => 500,
            25 => 500,
            26 => 500,
            27 => 500,
            28 => 500,
            29 => 500,
            30 => 500,
            31 => 500,
        ];
    }
}
