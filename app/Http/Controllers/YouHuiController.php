<?php

namespace App\Http\Controllers;

use App\AdminLog;
use App\OrderInfo;
use App\Region;
use App\User;
use App\YouHuiCate;
use App\YouHuiQ;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class YouHuiController extends Controller
{

    private $user;

    private $order_info;

    private $status;

    public function __construct($order_info, $user_info, $status = false)
    {
        $this->user = $user_info;
        $this->order_info = $order_info;
        $this->status = $status;
    }


    /**
     * 判断能否使用优惠券
     */
    public function check_use_youhuiq($goods_amount, $zy_amount, $fzy_amount, $yhq_id = 0)
    {
        $now = time();
        $province = Cache::tags(['shop', 'region'])->remember(1, 8 * 60, function () {
            return Region::where('parent_id', 1)->get();
        });
        /**
         * 查询有没有优惠券可以使用 满足该用户所有 满足未使用过 满足有效时间范围内 能够使用的
         */
        $youhuiq = YouHuiQ::where('user_id', $this->user->user_id)
            ->where('status', 0)->where('order_id', 0)->where('start', '<', $now)->where('end', '>', $now)
            ->where(function ($query) {
                $query->where('user_rank', 'like', '%' . $this->user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) {
                $query->where('area', 'like', '%' . $this->user->province . '%')->orwhere('area', '');
            })
            ->where('enabled', 1);
        if ($yhq_id > 0) {
            $youhuiq = $youhuiq->where('yhq_id', $yhq_id);
        }
        $youhuiq = $youhuiq->take(5)->get();
        $user_rank = array(
            1 => '连锁公司',
            2 => '药店',
            5 => '诊所',
            6 => '黑名单',
            7 => '商业公司',
        );
        if ($youhuiq) {
            foreach ($youhuiq as $k => $v) {
                $check = 1;
                if (!empty($v->user_rank)) {
                    $user_rank_arr = explode(',', $v->user_rank);
                    if (!in_array($this->user->user_rank, $user_rank_arr)) {
                        unset($youhuiq[$k]);
                        $check = 0;
                    }
                }
                if (!empty($v->area)) {
                    $area_arr = explode(',', $v->area);
                    if (!in_array($this->user->province, $area_arr)) {
                        unset($youhuiq[$k]);
                        $check = 0;
                    }
                }
                if ($v->type == 1 && $zy_amount < $v->min_je) {//中药优惠券 不满足最低金额
                    unset($youhuiq[$k]);
                    $check = 0;
                }

                if ($v->type == 2 && $fzy_amount < $v->min_je) {//非中药优惠券 不满足最低金额
                    unset($youhuiq[$k]);
                    $check = 0;
                }

                if ($v->type == 0 && $goods_amount < $v->min_je) {//通用优惠券 不满足最低金额
                    unset($youhuiq[$k]);
                    $check = 0;
                }
                if ($check == 1) {
                    $user_rank_str = [];
                    $area_str = [];
                    if (!empty($v->user_rank)) {
                        $v->user_rank = explode(',', $v->user_rank);
                        foreach ($v->user_rank as $val) {
                            if (isset($user_rank[$val])) {
                                $user_rank_str[] = $user_rank[$val];
                            }
                        }
                        $v->user_rank = implode(',', $user_rank_str);
                        $v->user_rank = '限' . $v->user_rank;
                    } else {
                        $v->user_rank = '所有等级';
                    }
                    if (!empty($v->area)) {
                        $v->area = explode(',', $v->area);
                        foreach ($v->area as $val) {
                            $region = $province->find($val);
                            $region_name = $region ? $region->region_name : '未知';
                            if (!empty($region_name)) {
                                $area_str[] = $region_name;
                            }
                        }
                        $v->area = implode(',', $area_str);
                        $v->area = '限' . $v->area;
                    } else {
                        $v->area = '所有省份';
                    }
                }
            }
            $youhuiq = $youhuiq->values();
        }
        return $youhuiq;

    }


    /**
     * 生成优惠券
     */
    public function new_youhuiq($type = 0, $sctj)
    {
        if ($type == 1) {
            $status = $this->create_yhq($sctj);
        } else {
            $status = $this->create_yhq_zc($sctj);
        }
        return $status;
    }


    private function create_yhq($sctj)
    {
        $now = time();
        $result = collect();
        $result->type = 0;
        $result->yhq = '';
        /**
         * 查询有没有优惠券可以生成 按最高条件送
         */
        $youhuiq_cate = YouHuiCate::with('yhq_attr')->where('sctj', 3)->where('goods_amount', '<', $this->order_info->goods_amount)
            ->where('status', 1)->where('gz_start', '<', $now)->where('gz_end', '>', $now)->where('num', '>', 0)
            ->where('user_rank', 'like', '%' . $this->user->user_rank . '%')->where('area', 'like', '%' . $this->user->province . '%')
            ->orderBy(DB::raw('rand()'))
            ->first();
        if ($youhuiq_cate) {//有优惠券
            if (!empty($youhuiq_cate->user_rank)) {
                $user_rank_arr = explode(',', $youhuiq_cate->user_rank);
                if (!in_array($this->user->user_rank, $user_rank_arr)) {
                    return $result;
                }
            }
            if (!empty($youhuiq_cate->area)) {
                $area_arr = explode(',', $youhuiq_cate->area);
                if (!in_array($this->user->province, $area_arr)) {
                    return $result;
                }
            }
            if ($this->order_info->goods_amount < $youhuiq_cate->goods_amount) {
                return $result;
            }
            $is_cunz = YouHuiQ::where(function ($query) {
                $query->where('old_order_id', $this->order_info->order_id)->orwhere('old_order_id1', $this->order_info->order_id);
            })->where('cat_id', $youhuiq_cate->cat_id)->where('user_id', $this->user->user_id)->count();

            if ($is_cunz > 0) {
                return $result;
            }
            $youhuiq = new YouHuiQ();
            $youhuiq->user_id = $this->order_info->user_id;
            $youhuiq->old_order_id = $this->order_info->order_id;
            $youhuiq->old_order_id1 = $this->order_info->other_order_id;
            $youhuiq->cat_id = $youhuiq_cate->cat_id;
            $youhuiq->min_je = $youhuiq_cate->min_je;
            $youhuiq->area = $youhuiq_cate->area;
            $youhuiq->user_rank = $youhuiq_cate->user_rank;
            $youhuiq->start = $youhuiq_cate->start;
            $youhuiq->end = $youhuiq_cate->end;
            $youhuiq->je = $youhuiq_cate->je;
            $youhuiq->type = $youhuiq_cate->type;
            $youhuiq->name = $youhuiq_cate->name;
            $youhuiq->add_time = $now;
            if ($this->status == true) {//为true才生成
                $youhuiq->enabled = 1;
            }
            $youhuiq->save();
            if ($this->status == true) {//为true才生成
                $youhuiq_cate->num = $youhuiq_cate->num - 1;
                $youhuiq_cate->save();
                $result->type = 2;
                $result->yhq = $youhuiq;
                return $result;
            }
            $youhuiq->gz_start = $youhuiq_cate->gz_start;
            $youhuiq->gz_end = $youhuiq_cate->gz_end;
            $result->type = 1;
            $result->yhq = $youhuiq;
            return $result;

        }
    }

    private function create_yhq_zc($sctj)
    {
        $admin_log = new AdminLog();
        $admin_log->log_time = time();
        $admin_log->user_id = auth()->user()->user_id;
        $admin_log->log_info = '非法注册';
        $admin_log->save();
        $now = time();
        /**
         * 查询有没有优惠券可以生成 在满足的条件中随机送
         */
        $youhuiq_cate = YouHuiCate::with('yhq_attr')->where('sctj', $sctj)
            ->where('status', 1)->where('gz_start', '<', $now)->where('gz_end', '>', $now)->where('num', '>', 0)
            ->where(function ($query) {
                $query->where('user_rank', 'like', '%' . $this->user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) {
                $query->where('area', 'like', '%' . $this->user->province . '%')->orwhere('area', '');
            })
            ->orderBy(DB::raw('rand()'))
            ->first();
        if ($youhuiq_cate) {//有优惠券
            if (!empty($youhuiq_cate->user_rank)) {
                $user_rank_arr = explode(',', $youhuiq_cate->user_rank);
                if (!in_array($this->user->user_rank, $user_rank_arr)) {
                    return 0;
                }
            }
            if (!empty($youhuiq_cate->area)) {
                $area_arr = explode(',', $youhuiq_cate->area);
                if (!in_array($this->user->province, $area_arr)) {
                    return 0;
                }
            }

            $is_cunz = YouHuiQ::where('cat_id', $youhuiq_cate->cat_id)->where('user_id', $this->user->user_id)->count();

            if ($is_cunz >= $youhuiq_cate->yhq_num) {//已经达到最大的拥有数量
                return 0;
            }
            $sy_num = $youhuiq_cate->yhq_num - $is_cunz;
            for ($i = 0; $i < $sy_num; $i++) {
                $youhuiq = new YouHuiQ();
                $youhuiq->user_id = $this->user->user_id;
                $youhuiq->cat_id = $youhuiq_cate->cat_id;
                $youhuiq->min_je = $youhuiq_cate->min_je;
                $youhuiq->area = $youhuiq_cate->area;
                $youhuiq->user_rank = $youhuiq_cate->user_rank;

                $youhuiq->je = $youhuiq_cate->je;
                $youhuiq->type = $youhuiq_cate->type;
                $youhuiq->yxq_type = $youhuiq_cate->yxq_type;
                $youhuiq->yxq_days = $youhuiq_cate->yxq_days;
                $youhuiq->attr_id = $youhuiq_cate->yhq_attr->attr_id;
                $youhuiq->union_type = $youhuiq_cate->yhq_attr->union_type;
                $youhuiq->day_num = $youhuiq_cate->yhq_attr->day_num;
                $youhuiq->order_num = $youhuiq_cate->yhq_attr->order_num;
                if ($youhuiq_cate->yxq_type == 0) {
                    $youhuiq->start = strtotime(date('Y-m-d', time()));
                    $youhuiq->end = $youhuiq->start + $youhuiq_cate->yxq_days * 24 * 3600;
                } else {
                    $youhuiq->start = $youhuiq_cate->start;
                    $youhuiq->end = $youhuiq_cate->end;
                }
                $youhuiq->name = $youhuiq_cate->name;
                $youhuiq->add_time = $now;
                if ($this->status == true) {//为true才生成
                    $youhuiq->enabled = 1;
                }
                $youhuiq->save();
                if ($this->status == true) {//为true才生成
                    $youhuiq_cate->num = $youhuiq_cate->num - 1;
                    $youhuiq_cate->save();
                }
                $youhuiq->gz_start = $youhuiq_cate->gz_start;
                $youhuiq->gz_end = $youhuiq_cate->gz_end;
            }
            return 1;

        }
    }

    public function up_yhq()
    {
        $now = time();
        $result = collect();
        $result->type = 0;

        /**
         * 查询是否存在未激活优惠券
         */
        $youhuiq = YouHuiQ::where(function ($query) {
            $query->where('old_order_id', $this->order_info->order_id)->orwhere('old_order_id1', $this->order_info->order_id);
        })->where('start', '<=', $now)->where('end', '>=', $now)->where('user_id', $this->user->user_id)
            ->where('enabled', 0)
            ->first();
        if ($youhuiq) {//有优惠券

            if ($youhuiq->old_order_id > 0 && $youhuiq->old_order_id1 > 0) {//判断该优惠券是否是分单生成的
                if ($this->order_info->order_id == $youhuiq->old_order_id) {
                    $other_order_id = $youhuiq->old_order_id1;
                } else {
                    $other_order_id = $youhuiq->old_order_id;
                }
                /**
                 * 查询分单订单是否已支付已确认
                 */
                $other_order = OrderInfo::where('order_id', $other_order_id)
                    ->where('pay_status', 2)->where('order_status', 1)
                    ->first();
                if (!$other_order) {
                    return $result;
                }
            }

            if (!empty($youhuiq->user_rank)) {
                $user_rank_arr = explode(',', $youhuiq->user_rank);
                if (!in_array($this->user->user_rank, $user_rank_arr)) {
                    return $result;
                }
            }
            if (!empty($youhuiq->area)) {
                $area_arr = explode(',', $youhuiq->area);
                if (!in_array($this->user->province, $area_arr)) {
                    return $result;
                }
            }
            if ($this->order_info->goods_amount < $youhuiq->goods_amount) {
                return $result;
            }

            $youhuiq->enabled = 1;

            $youhuiq->save();
            $result->type = 1;

            return $result;

        }
        return $result;
    }
}
