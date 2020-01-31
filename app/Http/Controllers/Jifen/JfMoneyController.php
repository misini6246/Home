<?php

namespace App\Http\Controllers\Jifen;

use App\AccountLog;
use App\Http\Controllers\Controller;
use App\Models\JfMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JfMoneyController extends Controller
{

    use JfTrait;

    protected $model;

    public function __construct(JfMoney $jfMoney)
    {
        $this->middleware('auth');
        $this->user = auth()->user()->is_zhongduan();
        $this->model = $jfMoney;
    }

    public function index()
    {
        if ($this->user->is_zhongduan == 0) {
            tips1('只有终端可以兑换');
        }
        $rules = $this->model->rules();
        $this->set_assign('rules', $rules);
        $this->common_value();
        $this->set_assign('page_title', '兑换积分金币-');
        return view('jf_money.index', $this->assign);
    }

    public function store(Request $request)
    {
        if ($this->user->is_zhongduan == 0) {
            ajax_return('只有终端可以兑换', 1);
        }
//        if (!in_array($this->user->user_id, cs_arr())) {
//            ajax_return('活动未开始');
//        }
        $params = ['pay_points' => $this->user->pay_points];
        $id = intval($request->input('id'));
        $rules = $this->model->rules();
        if (!isset($rules[$id])) {
            ajax_return('该兑换规则不存在');
        }
        if ($this->user->pay_points < $rules[$id]) {
            ajax_return('可兑换积分不足', 1, $params);
        }
        DB::transaction(function () use ($rules, $id) {
            $jf_money = $this->model->find($this->user->user_id);
            if (!$jf_money) {
                $jf_money = new $this->model;
                $jf_money->user_id = $this->user->user_id;
                $jf_money->money = 0;
            }
            $this->log_pay_points($rules[$id], '使用积分兑换金币(金币价值:' . $id . '元,兑换前积分:' . $this->user->pay_points . ')');
            $this->model->log_jf_money_change($jf_money, $id, '消耗' . $rules[$id] . '积分兑换' . $id . '积分金币');
        });
        $params['pay_points'] = $this->user->pay_points;
        ajax_return('兑换成功！', 0, $params);
    }

    private function log_pay_points($pay_points, $change_desc)
    {
        $account_log = new AccountLog();
        $account_log->user_id = $this->user->user_id;
        $account_log->user_money = 0;
        $account_log->frozen_money = 0;
        $account_log->rank_points = 0;
        $account_log->pay_points = $pay_points * (-1);
        $account_log->change_time = time();
        $account_log->change_desc = $change_desc;
        $account_log->change_type = 0;
        $account_log->save();
        $this->user->pay_points -= $pay_points;
        $this->user->save();
    }
}
