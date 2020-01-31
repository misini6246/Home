<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserJyfw extends Model
{
    protected $table = 'user_erp_jyfwkzlb';
    protected $primaryKey = 'wldwid';
    public $timestamps = false;

    public function getShangplxAttribute($value)
    {
        return trim($value);
    }
}
