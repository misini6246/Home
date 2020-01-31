<?php

namespace App\Http\Controllers;


use App\AdminLog;
use App\Models\UserDfqr;
use App\Models\Yhq;
use App\OrderInfo;
use App\YouHuiCate;
use App\YouHuiQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YhqController extends Controller
{
    public $user;

    public $model;

    public $assign = [];

    static $ids = [67, 68, 69, 70, 71, 72, 73, 74, 75, 76];

    public function __construct(YouHuiCate $model)
    {
        $this->middleware('check_login', ['only' => 'dfqr']);
        $this->model = $model;
        $this->user = auth()->user();
        if ($this->user) {
            $this->user = $this->user->is_zhongduan();
        }
        $this->assign['user'] = $this->user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $time = time();
        $where = '';
        if ($this->user) {
            $where = function ($where) {
                $where->where('user_rank', '')->orwhere('user_rank', 'like', '%' . $this->user->user_rank . '%');
            };
        }
        $query = $this->model->where('sctj', 6)->where('status', 1)
            ->where('gz_start', '<', $time)
            ->where('gz_end', '>', $time)->where('num', '>', 0);
        //dd($query);
        if ($where instanceof \Closure) {
            $query->where($where);
        }

        if ($this->user) {
            $num = DB::table('order_info')->where('user_id', $this->user->user_id)->where('order_status','!=', 2)->count();
            if ($num > 0) {
                $result = $query->orderBy('je', 'asc')->where('cat_id', '<>', 1)->get();
            } else {
                $result = $query->orderBy('je', 'asc')->get();
            }
        } else {
            $result = $query->orderBy('je', 'asc')->get();
        }




        /*  */

        if ($this->user && $this->user->is_zhongduan == 0) {
            show_msg('此活动只针对终端客户！');
        }
        //        if ($this->user && $time >= strtotime(20180627) && $this->user->city != 322) {
        //            show_msg('此活动只针对成都地区终端客户');
        //        }
        //        if (count($result) == 0) {
        //            show_msg('活动未开始');
        //        }
        if ($this->user) {
            $result->load([
                'youhuiq' => function ($query) {
                    $query->where('user_id', $this->user->user_id)->select('cat_id', 'user_id');
                }
            ]);
        }



        $has = 0;
        foreach ($result as $v) {
            if ($this->user) {
                if ($v->youhuiq && count($v->youhuiq) > 0) {
                    $v->has = 1;
                }
            }
        }

        //        dd($result);

        //查询用户领取用户卷
        //$time = time();
        //$users_yhq = Yhq::where('user_id',$this->user->user_id)->where('start','<=',$time)->where('end','>=',$time)->get();


        $ad209 = ads(209);
        //暂时限制领取优惠卷 $order_count
        if ($this->user) {
            $order_count = DB::table('order_info')->where('user_id', $this->user->user_id)->where('order_status', 1)->count();
        } else {
            $order_count = 0;
        }

        $this->assign['order_count'] = $order_count;

        $this->assign['result'] = $result;
        $this->assign['has'] = $has;
        $this->assign['page_title'] = '优惠券领取-';
        $this->assign['dh_check'] = 53;
        $this->assign['ad209'] = $ad209;
        //$this->assign['users_yhq'] = $users_yhq;
        // dd($this->assign);

        return view('youhuiq.index', $this->assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cate_id = $request->id;
        //dd($cate_id);
        if (!$this->user) {
            ajax_return('请登录后再操作!', 2);
        }
        if ($cate_id == 1) {
            $exist = YouHuiQ::where('cat_id', $cate_id)->where('user_id', $this->user->user_id)->count();
            if ($exist > 0) {
                ajax_return('已领取过！', 401);
            }
            $num = OrderInfo::where('user_id', $this->user->user_id)->where('pay_status', 2)->count();

            if ($num > 0) {
                ajax_return('新人用户才能领取！', 401);
            }
        }else{
            $exist = YouHuiQ::where('cat_id', $cate_id)->where('user_id', $this->user->user_id)->count();
            if ($exist > 0) {
                ajax_return('不能重复领取！', 401);
            }
        }



        if ($this->user->is_zhongduan == 0) {
            ajax_return('此活动只针对终端客户！', 1);
        }
        $time = time();
        $cs_arr = cs_arr();
        if (in_array($this->user->user_id, $cs_arr)) {
            // $time += 3600 * 24;
        }
        DB::transaction(function () use ($time, $cate_id) {
            $category = $this->model->where('sctj', 6)->where('status', 1)->where(function ($where) {
                $where->where('user_rank', '')->orwhere('user_rank', 'like', '%' . $this->user->user_rank . '%');
            })->where('gz_end', '>', $time)->where('num', '>', 0)->where('cat_id', $cate_id)->lockForUpdate()->get();
            //            where('gz_end', '>', $time)->where('num', '>', 0)->whereIn('cat_id', self::$ids)->lockForUpdate()->get();
            if (count($category) == 0) {
                ajax_return('已经领取或活动不存在！', 1);
            }

            foreach ($category as $cate) {
                if ($cate->gz_start > $time) {
                    ajax_return('活动未开始！', 1);
                }
                $yhq_num = YouHuiQ::where('cat_id', $cate->cat_id)->where('user_id', $this->user->user_id)->lockForUpdate()->count();
                if ($yhq_num >= $cate->yhq_num) {
                    continue;
                }
                $insert = [];
                for ($i = 0; $i < ($cate->yhq_num - $yhq_num); $i++) {
                    $info = [
                        'user_id' => $this->user->user_id,
                        'old_order_id' => 0,
                        'cat_id' => $cate->cat_id,
                        'min_je' => $cate->min_je,
                        'area' => $cate->area,
                        'user_rank' => $cate->user_rank,
                        'start' => $cate->start,
                        'end' => $cate->end,
                        'je' => $cate->je,
                        'type' => $cate->type,
                        'yxq_type' => $cate->yxq_type,
                        'yxq_days' => $cate->yxq_days,
                        'union_type' => $cate->union_type,
                        'tj_type' => $cate->tj_type,
                        'sctj' => $cate->sctj,
                        'name' => $cate->name,
                        'add_time' => $time,
                        'enabled' => 1,
                    ];
                    //                    if ($cate->yxq_type == 0) {
                    //                        $info['start'] = strtotime(date('Y-m-d', time()));
                    //                        $info['end'] = $cate->start + $cate->yxq_days * 24 * 3600;
                    //                    } else {
                    //                        $info['start'] = $cate->start;
                    //                        $info['end'] = $cate->end;
                    //                    }
                    //                    if ($this->user->city == 322) {//成都
                    //                        $info['start'] += 3600 * 24 * 2;
                    //                        $info['end'] += 3600 * 24 * 2;
                    //                    }
                    $insert[] = $info;
                }


                YouHuiQ::insert($insert);
                $cate->num -= count($insert);
                $cate->save();
                $admin_log = new AdminLog();
                $admin_log->log_time = time();
                $admin_log->user_id = $this->user->user_id;
                $admin_log->log_info = '(Id:' . $this->user->user_id . ')领取优惠券' . count($insert) . '张';
                $admin_log->ip_address = '';
                $admin_log->save();
            }
        });
        ajax_return('领取成功！');
    }

    public function dfqr(Request $request)
    {
        $ip = $request->server('HTTP_X_FORWARDED_FOR');
        if (is_null($ip)) {
            $ip = $request->ip();
        }
        DB::table('mhj_qrh')->where('user_id', $this->user->user_id)->update([
            'is_confirm' => 1,
            'confirm_time' => time(),
            'ip' => $ip,
        ]);
        ajax_return('确认成功');
    }

    public function mhj_qrh(Request $request)
    {
        $type = intval($request->input('type'));
        DB::transaction(function () use ($type, $request) {
            $dfqr = UserDfqr::lockForUpdate()->find($this->user->user_id);
            if (!$dfqr) {
                ajax_return('您还未在网站消费过！', 1);
            }
            if ($dfqr->is_confirm > 0) {
                ajax_return('您已经确认授权！', -1);
            }
            $time = time();
            $cs_arr = cs_arr();
            if (in_array($this->user->user_id, $cs_arr)) {
                $time += 3600 * 24;
            }
            $dfqr->is_confirm = $type;
            $dfqr->ip = $request->server('HTTP_X_FORWARDED_FOR');
            if (is_null($dfqr->ip)) {
                $dfqr->ip = $request->ip();
            }
            $cate = $this->model->where('sctj', 6)->where('status', 1)->where(function ($where) {
                $where->where('user_rank', '')->orwhere('user_rank', 'like', '%' . $this->user->user_rank . '%');
            })->where('gz_end', '>', $time)->where('num', '>', 0)->where('cat_id', 51)->lockForUpdate()->first();
            if (!$cate) {
                ajax_return('活动不存在！', 1);
            }
            if ($cate->gz_start > $time) {
                ajax_return('活动未开始！', 1);
            }
            $yhq_num = YouHuiQ::where('cat_id', $cate->cat_id)->where('user_id', $this->user->user_id)->lockForUpdate()->count();
            if ($yhq_num >= $cate->yhq_num) {
                $dfqr->save();
                ajax_return('您已经确认授权！', -1);
            }
            $insert = [];
            for ($i = 0; $i < ($cate->yhq_num - $yhq_num); $i++) {
                $info = [
                    'user_id' => $this->user->user_id,
                    'old_order_id' => 0,
                    'cat_id' => $cate->cat_id,
                    'min_je' => $cate->min_je,
                    'area' => $cate->area,
                    'user_rank' => $cate->user_rank,
                    'start' => $cate->start,
                    'end' => $cate->end,
                    'je' => $cate->je,
                    'type' => $cate->type,
                    'yxq_type' => $cate->yxq_type,
                    'yxq_days' => $cate->yxq_days,
                    'union_type' => $cate->union_type,
                    'sctj' => $cate->sctj,
                    'name' => $cate->name,
                    'add_time' => $time,
                    'enabled' => 1,
                ];
                if ($cate->yxq_type == 0) {
                    $info['start'] = strtotime(date('Y-m-d', time()));
                    $info['end'] = $cate->start + $cate->yxq_days * 24 * 3600;
                } else {
                    $info['start'] = $cate->start;
                    $info['end'] = $cate->end;
                }
                $insert[] = $info;
            }

            YouHuiQ::insert($insert);
            $cate->num -= count($insert);
            $cate->save();
            $dfqr->save();
        });
        ajax_return('确认授权成功！获得50元感恩券');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function check_has_yhq()
    {
        $time = time();
        $where = '';
        if ($this->user) {
            $where = function ($where) {
                $where->where('user_rank', '')->orwhere('user_rank', 'like', '%' . $this->user->user_rank . '%');
            };
        } else {
            ajax_return('信息', 0, ['login_type' => auth()->check(), 'has' => 0, 'now' => time()]);
        }
        $query = $this->model->where('sctj', 6)->where('status', 1)->whereIn('cat_id', self::$ids)->where(function ($where) {
            $where->where('user_rank', '')->orwhere('user_rank', 'like', '%' . $this->user->user_rank . '%');
        })->where('gz_end', '>', $time)->where('num', '>', 0);
        if ($where instanceof \Closure) {
            $query->where($where);
        }
        $result = $query->orderBy('je', 'asc')->get();
        if ($this->user) {
            $result->load([
                'youhuiq' => function ($query) {
                    $query->where('user_id', $this->user->user_id)->select('cat_id', 'user_id');
                }
            ]);
        }
        $has = 0;
        foreach ($result as $v) {
            if ($v->youhuiq && count($v->youhuiq) > 0) {
                $has = 1;
            }
        }
        //        foreach ($result as $v) {
        //            if ($v->youhuiq && count($v->youhuiq) >= 0) {
        //                $has++;
        //            }
        //        }
        //        if ($has < 4) {
        //            $has = 0;
        //        } else {
        //            $has = 1;
        //        }
        ajax_return('信息', 0, ['login_type' => auth()->check(), 'has' => $has, 'now' => time()]);
    }
}
