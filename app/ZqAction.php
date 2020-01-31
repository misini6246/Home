<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZqAction extends Model
{
    protected $table = "zq_action";
    protected $primaryKey = 'action_id';
    public $timestamps = false;
}
