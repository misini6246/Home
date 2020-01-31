<?php

namespace App\Http\Controllers;

use App\AccountLog;
use App\Models\JfMoney;
use App\Models\JfMoneyLog;
use App\ZqSy;
use App\ZqYwy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JfMoneyController extends Controller
{
    public $user;

    public $model;

    public $start;

    public $end;

    public $assign = [];

    public function __construct(JfMoney $model)
    {
        $this->middleware('auth', ['only' => 'index']);
        $this->model = $model;
        $this->user  = auth()->user();
        $this->start = strtotime(20171101);
        if ($this->user) {
            $this->user = $this->user->is_zhongduan();
            if (in_array($this->user->user_id, cs_arr())) {
                $this->start = strtotime(20171008);
            }
        }
        $this->end    = strtotime(20171110);
        $this->assign = [
            'page_title' => '用户中心-',
            'user'       => $this->user,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $time = time();
        if ($time > strtotime(20171110)) {
            show_msg('活动已结束');
        }
        $this->assign['rules']      = $this->rules();
        $this->assign['page_title'] = '积分兑换金币';
        return view('jf_money.index', $this->assign);
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
        if (!$this->user) {
            ajax_return('请登录后在操作!', 2);
        }
        $params = ['pay_points' => $this->user->pay_points];
        $id     = intval($request->input('id'));
        $time   = time();
        if ($time < $this->start) {
            ajax_return('活动未开始');
        }
        if ($time >= $this->end) {
            ajax_return('活动已结束');
        }
        $rules = $this->rules();
        if (!isset($rules[$id])) {
            ajax_return('该兑换规则不存在');
        }
        if ($this->user->pay_points < $rules[$id]) {
            ajax_return('可兑换积分不足', 1, $params);
        }
        DB::transaction(function () use ($rules, $id) {
            $jf_money = $this->model->find($this->user->user_id);
            if (!$jf_money) {
                $jf_money          = new $this->model;
                $jf_money->user_id = $this->user->user_id;
                $jf_money->money   = 0;
            }
//            $jf_money->money += $id;
//            $jf_money->save();
            $this->log_pay_points($rules[$id], '使用积分兑换金币 (金币价值:' . $id . '元,兑换前积分:' . $this->user->pay_points . ')');
            log_jf_money_change($jf_money, $id, '消耗' . $rules[$id] . '积分兑换' . $id . '积分金币');
        });
        $params['pay_points'] = $this->user->pay_points;
        ajax_return('兑换成功！', 0, $params);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

    public function log()
    {
        $jf_money = $this->model->find($this->user->user_id);
//        if (!$jf_money) {
//            show_msg('您请求的页面不存在');
//        }
        $result      = JfMoneyLog::where('user_id', $this->user->user_id)
            ->orderBy('log_id', 'desc')->Paginate();
        $sy_zq_type  = ZqSy::where('user_id', $this->user->user_id)->pluck('is_zq');
        $ywy_zq_type = ZqYwy::where('user_id', $this->user->user_id)->pluck('zq_amount');
        if ($ywy_zq_type > 0 || $this->user->zq_amount > 0) {
            $show_zq = 1;
        } else {
            $show_zq = 0;
        }
        $this->assign['page_title'] = '用户中心-';
        $this->assign['show_zq']    = $show_zq;
        $this->assign['sy_zq_type'] = $sy_zq_type;
        $this->assign['full_page']  = 1;
        $this->assign['result']     = $result;
        $this->assign['action']     = 'jf_money';
        $this->assign['jf_money']   = $jf_money;
        return view('jf_money.log', $this->assign);
    }

    protected function rules()
    {
        $arr = [
            10   => 5000,
            150  => 50000,
            700  => 200000,
            1900 => 500000,
            4000 => 1000000,
        ];
        return $arr;
    }

    private function log_pay_points($pay_points, $change_desc)
    {
        $account_log               = new AccountLog();
        $account_log->user_id      = $this->user->user_id;
        $account_log->user_money   = 0;
        $account_log->frozen_money = 0;
        $account_log->rank_points  = 0;
        $account_log->pay_points   = $pay_points * (-1);
        $account_log->change_time  = time();
        $account_log->change_desc  = $change_desc;
        $account_log->change_type  = 0;
        $account_log->save();
        $this->user->pay_points -= $pay_points;
        $this->user->save();
    }
}
