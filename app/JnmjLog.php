<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JnmjLog extends Model
{
    protected $table = 'jnmj_log';
    protected $primaryKey = 'log_id';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User(){

        return $this->belongsTo('App\User','user_id');

    }
}
