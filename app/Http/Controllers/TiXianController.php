<?php

namespace App\Http\Controllers;

use App\AccountLog;
use App\Models\TiXian;
use App\Models\TiXianAction;
use App\ZqSy;
use App\ZqYwy;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TiXianController extends Controller
{
    public $assign;

    public $user;

    public function __construct(Request $request)
    {
        $this->user  = auth()->user();
        $sy_zq_type  = ZqSy::where('user_id', $this->user->user_id)->pluck('is_zq');
        $ywy_zq_type = ZqYwy::where('user_id', $this->user->user_id)->pluck('zq_amount');
        if ($ywy_zq_type > 0 || $this->user->zq_amount > 0) {
            $show_zq = 1;
        } else {
            $show_zq = 0;
        }
        $this->assign = [
            'page_title' => '用户中心-',
            'action'     => '',
            'show_zq'    => $show_zq,
            'user'       => $this->user,
            'sy_zq_type' => $sy_zq_type,
            'full_page'  => 1,
        ];
        if ($request->ajax()) {
            $this->assign['full_page'] = 0;
        }
        //dd($this->nav_list);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type  = intval($request->input('type', 0));
        $user  = auth()->user();
        $query = TiXian::where('user_id', $user->user_id)->where('sq_type', '!=', 1);
        if ($type > 0) {
            switch ($type) {
                case 1;
                    $query->where('sq_type', 0)->where('sh_type', '!=', 5)->where('sh_type', '!=', 4);
                    break;
                case 2;
                    $query->where('sh_type', 4)->where('sq_type', 2);
                    break;
            }
        }
        $result   = $query->orderBy('create_time', 'desc')->get();
        $jinxing  = collect();
        $wancheng = collect();
        $quxiao   = collect();
        foreach ($result as $v) {
            $v->sq_type_text = $this->sq($v->sq_type);
            $v->sh_type_text = $this->sh($v->sh_type);
            if ($v->sq_type == 0 && $v->sh_type != 2 && $v->sh_type != 5) {
                $jinxing[] = $v;
            }
            if ($v->sh_type == 2 || $v->sh_type == 5) {
                $wancheng[] = $v;
            }
            if ($v->sq_type == 1) {
                $quxiao[] = $v;
            }
        }
        $result->jinxing        = $jinxing;
        $result->wancheng       = $wancheng;
        $result->quxiao         = $quxiao;
        $this->assign['action'] = 'tixian';
        $this->assign['type']   = $type;
        $this->assign['result'] = $result;
        return view('tixian', $this->assign);
    }

    public function log(Request $request)
    {
        $type  = intval($request->input('type', 0));
        $user  = auth()->user();
        $query = TiXian::where('user_id', $user->user_id)->where('sq_type', '!=', 1);
        if ($type > 0) {
            switch ($type) {
                case 1;
                    $query->where('sq_type', 0)->where('sh_type', '!=', 5)->where('sh_type', '!=', 4);
                    break;
                case 2;
                    $query->where('sh_type', 4)->where('sq_type', 2);
                    break;
            }
        }
        $result   = $query->orderBy('create_time', 'desc')->get();
        $jinxing  = collect();
        $wancheng = collect();
        $quxiao   = collect();
        foreach ($result as $v) {
            $v->sq_type_text = $this->sq($v->sq_type);
            $v->sh_type_text = $this->sh($v->sh_type);
            if ($v->sq_type == 0 && $v->sh_type != 2 && $v->sh_type != 5) {
                $jinxing[] = $v;
            }
            if ($v->sh_type == 2 || $v->sh_type == 5) {
                $wancheng[] = $v;
            }
            if ($v->sq_type == 1) {
                $quxiao[] = $v;
            }
        }
        $result->jinxing        = $jinxing;
        $result->wancheng       = $wancheng;
        $result->quxiao         = $quxiao;
        return $result;
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
        $count = TiXian::where('user_id', $this->user->user_id)->where('sh_type', '!=', 2)->where('sh_type', '!=', 5)->count();
        if ($count > 0) {
            show_msg('请等待上一个提现申请完成再提交', route('user.accountInfo'), '返回上一页');
        }
        $id   = intval($request->input('id', 0));
        $zctj = TiXian::where('user_id', $this->user->user_id)->where('tx_id', $id)->first();
        if ($zctj) {
            $money     = $zctj->money;
            $bank      = $zctj->bank;
            $bank_sn   = $zctj->bank_sn;
            $bank_user = $zctj->bank_user;
        } else {
            $money     = floatval($request->input('money'));
            $bank      = trim($request->input('bank'));
            $bank_sn   = trim($request->input('bank_sn'));
            $bank_user = trim($request->input('bank_user'));
        }
        if ($money <= 0) {
            show_msg('请填写正确的提现金额', route('user.accountInfo'), '返回上一页');
        }
        if ($money > $this->user->user_money) {
            show_msg('超出可提现余额', route('user.accountInfo'), '返回上一页');
        }
        if (empty($bank) || empty($bank_user) || empty($bank_sn)) {
            show_msg('请完善银行信息', route('user.accountInfo'), '返回上一页');
        }
        $info            = new TiXian();
        $info->money     = $money;
        $info->bank      = $bank;
        $info->bank_sn   = $bank_sn;
        $info->bank_user = $bank_user;
        $info->user_id   = $this->user->user_id;
        $info->sq_type   = 0;
        $info->sh_type   = 1;
        DB::transaction(function () use ($info) {
            $info->save();
            //$this->log_account_change($info);
        });
        show_msg('申请提现成功', route('user.accountInfo'), '返回上一页');
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
        $info     = TiXian::find($id);
        $old_info = clone $info;
        if ($info->sq_type == 0 && ($info->sh_type == 0 || $info->sh_type == 5)) {
            $info->sq_type = 1;
            DB::transaction(function () use ($info, $old_info) {
                $info->save();
                if ($old_info->sq_type == 0) {
                    //$this->log_account_change($info, 1);
                    $this->tx_action($info, '取消提现申请');
                }
            });
        }
        show_msg('操作成功', route('user.accountInfo'), '返回上一页');
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

    private function sq($type)
    {
        $arr = [
            '0' => '申请中',
            '1' => '已取消',
            '2' => '已完成',
        ];
        if (isset($arr[$type])) {
            return $arr[$type];
        } else {
            return '未知状态';
        }
    }

    private function sh($type)
    {
        $arr = [
            '0' => '未审核',
            '1' => '审核中',
            '2' => '已审核',
            '3' => '转账中',
            '4' => '转账完成',
            '5' => '审核未通过',
        ];
        if (isset($arr[$type])) {
            return $arr[$type];
        } else {
            return '未知状态';
        }
    }

    private function log_account_change($info, $type = -1)
    {
        $account               = new AccountLog();
        $account->user_id      = $this->user->user_id;
        $account->user_money   = $info->money * $type;
        $account->frozen_money = $info->money * $type * (-1);
        $account->rank_points  = 0;
        $account->pay_points   = 0;
        $account->change_time  = time();
        if ($type == -1) {
            $account->change_desc = '申请提现冻结提现金额';
        } else {
            $account->change_desc = '取消提现返还冻结金额';
        }
        $account->change_type = 50;
        $account->money_type  = 50;
        $account->order_id    = $info->tx_id;
        $account->save();
        $this->user->user_money = $this->user->user_money + $info->money * ($type);
        $this->user->save();
    }

    private function tx_action($info, $action_note = '')
    {
        $action              = new TiXianAction();
        $action->tx_id       = $info->tx_id;
        $action->action_user = $this->user->user_name;
        $action->sq_type     = $info->sq_type;
        $action->sh_type     = $info->sh_type;
        $action->action_note = $action_note;
        $action->save();
    }
}
