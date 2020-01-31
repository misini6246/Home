<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yhq extends Model
{
    protected $table = 'youhuiq';
    protected $primaryKey = 'yhq_id';
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(YhqCategory::class, 'cat_id');
    }

    /**
     * @param $query
     * @return mixed
     * 获取会员有效优惠券
     */
    public function scopeUserVisible($query)
    {
        $user = auth()->user();
        $now = time();
        return $query->where('user_id', $user->user_id)
            ->where('status', 0)->where('order_id', 0)
            ->where('start', '<=', $now)->where('end', '>', $now)
            ->where(function ($query) use ($user) {
                $query->where('user_rank', 'like', '%' . $user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) use ($user) {
                $query->where('area', 'like', '%' . $user->province . '%')->orwhere('area', '');
            })->where('union_type', 2)->where('enabled', 1)->orderBy('min_je')->orderBy('yhq_id');
    }
}
