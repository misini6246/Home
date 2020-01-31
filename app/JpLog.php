<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JpLog extends Model
{
    protected $table = 'jp_log';
    protected $primaryKey = 'log_id';
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
