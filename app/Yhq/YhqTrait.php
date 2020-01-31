<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-09-27
 * Time: 17:14
 */

namespace App\Yhq;


trait YhqTrait
{

    public function choose_yhq($where = '')
    {
        $use_ids = $this->order->yhq_all->pluck('yhq_id')->toArray();
        $youhuiq = $this->yhq_list($where);
        $this->order->setRelation('yhq_list', $youhuiq);
        $this->order->setRelation('use_ids', $use_ids);
        $this->order->setRelation('total', $youhuiq->where('union_type', 0)->sum('je'));
    }

    public function use_yhq($where = '')
    {
        $use_ids  = $this->order->use_ids;
        $youhuiq  = $this->yhq_list($where);
        $pack_fee = $youhuiq->whereIn('yhq_id', $use_ids)->sum('je');
        if (in_array(-1, $use_ids)) {
            $pack_fee += $youhuiq->where('union_type', 0)->sum('je');
            $use_ids  = array_merge($use_ids, $youhuiq->where('union_type', 0)->pluck('yhq_id')->toArray());
        }
        $use_ids = $youhuiq->whereIn('yhq_id', $use_ids)->pluck('yhq_id')->toArray();
        $this->order->setRelation('use_ids', $use_ids);
        $this->order->setRelation('real_pack_fee', $pack_fee);
    }

    protected function yhq_list($where = '')
    {
        $now    = $this->order->add_time;
        $cs_arr = cs_arr();
        if (in_array($this->order->user_id, $cs_arr)) {
            $now = cs_time($now);
        }
        $query = Yhq::where('user_id', $this->order->user_id)->where('min_je', '<=', $this->yhq_amount)
            ->where(function ($where) {
                $where->where('order_id', 0)->orwhere('order_id', $this->order->order_id);
            })->where('start', '<=', $now)->where('end', '>', $now)
            ->where('sctj', '!=', 7)->where('union_type', '!=', 3)//不查询立减和打折
            ->where(function ($query) {
                $query->where('user_rank', 'like', '%' . $this->order->user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) {
                $query->where('area', 'like', '%' . $this->order->user->province . '%')
                    ->orwhere('area', 'like', '%' . $this->order->user->city . '%')
                    ->orwhere('area', 'like', '%' . $this->order->user->district . '%')
                    ->orwhere('area', '');
            })
            ->where('enabled', 1);
        if ($where instanceof \Closure) {
            $query->where($where);
        }
        $query->orderBy('min_je')->orderBy('yhq_id');
        $youhuiq    = $query->get();
        $count      = 0;
        $yhq_amount = $this->yhq_amount;
        foreach ($youhuiq as $v) {
            if ($yhq_amount >= $v->min_je) {
                $yhq_amount -= $v->min_je;
                $count++;
            }
        }
        $this->order->setRelation('yhq_count', $count);
        return $youhuiq;
    }

}