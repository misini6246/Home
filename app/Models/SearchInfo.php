<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchInfo extends Model
{
    protected $table = 'search_info';
    protected $primaryKey = 'search_id';
    public $timestamps = false;
}
