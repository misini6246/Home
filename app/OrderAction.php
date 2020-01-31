<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderAction extends Model
{
    protected $table = "order_action";
    protected $primaryKey = 'action_id';
    public $timestamps = false;
}
