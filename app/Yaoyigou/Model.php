<?php

namespace App\Yaoyigou;

use Illuminate\Database\Eloquent\Model as Base;

class Model extends Base
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    const DELETED_AT = 'delete_time';

    public $dates = ['delete_time'];

    public $appends = ['resource_url'];
}
