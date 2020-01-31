<?php

namespace App\Yaoyigou;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class MiaoshaGroup extends Model
{
    use SoftDeletes;

    protected $table = 'miaosha_group';

    protected $perPage = 15;

    public $fillable = ['name', 'start_time', 'test_start_time', 'end_time', 'test_end_time',
        'invalid_time', 'test_invalid_time', 'group_type', 'is_enabled', 'is_deleted', 'is_test'];

    public function miaoshaGoods()
    {
        return $this->hasMany(MiaoshaGoods::class, 'group_id');
    }

    public function scopeEnabled($query)
    {
        return $query->whereIsEnabled(1);
    }

    public function scopeNow($query)
    {
        $now = Carbon::now();
        return $query->where('start_time', '<=', $now)->where('end_time', '>', $now);
    }

    public function scopeBefore($query)
    {
        $now = Carbon::now();
        return $query->where('start_time', '>', $now);
    }

    public function scopeAfter($query)
    {
        $now = Carbon::now();
        return $query->where('end_time', '<=', $now);
    }

    public function setInvalidTimeAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['invalid_time'] = $this->attributes['end_time'];
        }
    }

    public function setTestInvalidTimeAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['test_invalid_time'] = $this->attributes['test_end_time'];
        }
    }

    public function setTestStartTimeAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['test_start_time'] = $this->attributes['start_time'];
        }
    }

    public function setTestEndTimeAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['test_end_time'] = $this->attributes['end_time'];
        }
    }

    public function getStartTimeAttribute($value)
    {
        if ($this->is_test == 1) {
            $user = auth()->user();
            if ($user && in_array($user->user_id, cs_arr())) {
                $value = $this->attributes['test_start_time'];
            }
        }
        return $value;
    }

    public function getEndTimeAttribute($value)
    {
        if ($this->is_test == 1) {
            $user = auth()->user();
            if ($user && in_array($user->user_id, cs_arr())) {
                $value = $this->attributes['test_end_time'];
            }
        }
        return $value;
    }

    public function getInvalidTimeAttribute($value)
    {
        if ($this->is_test == 1) {
            $user = auth()->user();
            if ($user && in_array($user->user_id, cs_arr())) {
                $value = $this->attributes['test_invalid_time'];
            }
        }
        return $value;
    }
}
