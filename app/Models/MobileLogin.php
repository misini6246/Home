<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileLogin extends Model
{
    protected $table = 'mobile_login';
    protected $primaryKey = "rec_id";
    public $timestamps = false;

    public function mobile_code()
    {
        return $this->hasOne(MobileCode::class, 'mobile_phone', 'mobile_phone');
    }

    public function getUserIdsAttribute($value)
    {

        if (!empty($value)) {
            $value = explode('.', trim($value, '.'));
            foreach ($value as $k => $v) {
                if (empty($v)) {
                    unset($value[$k]);
                }
            }
        } else {
            $value = [];
        }
        return $value;
    }

    public function setUserIdsAttribute($value)
    {
        if (count($value) > 0) {
            $ids = '.' . implode('.', $value) . '.';
        } else {
            $ids = '';
        }
        $this->attributes['user_ids'] = $ids;
    }
}
