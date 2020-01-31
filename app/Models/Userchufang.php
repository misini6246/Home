<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userchufang extends Model
{
    protected $table = 'user_chufang';
    protected $primaryKey = 'wldwid';
    public $timestamps = false;

    public function getShangplxAttribute($value)
    {
        return trim($value);
    }

}
