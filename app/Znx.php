<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Znx extends Model
{
    protected $table = "znx";
    protected $primaryKey = "znx_id";
    public $timestamps = false;

    /**
     * 关联znx_read
     */
    public function znx_read(){
        return $this->hasMany('App\ZnxRead','znx_id','znx_id');
    }
}
