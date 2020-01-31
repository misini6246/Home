<?php

namespace App\Http\Controllers;

use App\AccountLog;
use App\YouHuiCate;
use App\YouHuiQ;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class JfdhController extends Controller
{
    protected $now;

    protected $user;

    protected $assign;

    public function __construct()
    {
        $this->now    = time();
        $this->user   = auth()->user()->is_zhongduan();
        $this->assign = [
            'user' => $this->user
        ];

    }

    public function getIndex()
    {
        if ($this->user->is_zhongduan == 0) {
            show_msg('只有终端会员可以参与');
        }

        $list = YouHuiCate::with([
            'youhuiq' => function ($query) {
                $query->select('cat_id');
            }
        ])->where('sctj', 4)//积分兑换
        ->where('union_type', 4)//原力券
        ->where('gz_start', '<', $this->now)->where('gz_end', '>', $this->now)
        ->where('status', 1)
            ->where(function ($query) {
                $query->where('user_rank', 'like', '%' . $this->user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) {
                $query->where('area', 'like', '%' . $this->user->province . '%')->orwhere('area', '');
            })
            ->select('cat_id', 'gz_start', 'gz_end', 'goods_amount','yhq_num')
            ->orderBy('goods_amount','desc')
            ->get();
        if (count($list) == 0) {
            return redirect()->route('index');
        }
        $this->assign['list'] = $list;
        $this->assign['user'] = $this->user;
        return view('jfdh.index', $this->assign);
    }

    public function postJfdh(Request $request)
    {
        $cat_id = intval($request->input('cat_id', 0));
        $info   = YouHuiCate::where('sctj', 4)->where('union_type', 4)
            ->where('status', 1)
//            ->where('gz_start', '<', $this->now)->where('gz_end', '>', $this->now)
            ->where('num', '>', 0)->where('cat_id', $cat_id)
            ->where(function ($query) {
                $query->where('user_rank', 'like', '%' . $this->user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) {
                $query->where('area', 'like', '%' . $this->user->province . '%')->orwhere('area', '');
            });
        $info   = $info->first();
        if (count($info) == 0) {
            $result = $this->ajax_return('活动不存在');
        } else {
            if ($this->now < $info->gz_start) {
                $result = $this->ajax_return('活动未开始');
            } elseif ($this->now > $info->gz_end) {
                $result = $this->ajax_return('活动已结束');
            } else {
                if ($this->user->pay_points < ($info->goods_amount * $info->yhq_num)) {//积分不足
                    $result = $this->ajax_return('积分不足');
                } else {
                    DB::transaction(function () use ($info) {
                        for ($i = 0; $i < $info->yhq_num; $i++) {
                            $youhuiq            = new YouHuiQ();
                            $youhuiq->user_id   = $this->user->user_id;
                            $youhuiq->cat_id    = $info->cat_id;
                            $youhuiq->min_je    = $info->min_je;
                            $youhuiq->area      = $info->area;
                            $youhuiq->user_rank = $info->user_rank;

                            $youhuiq->je         = $info->je;
                            $youhuiq->type       = $info->type;
                            $youhuiq->yxq_type   = $info->yxq_type;
                            $youhuiq->yxq_days   = $info->yxq_days;
                            $youhuiq->union_type = $info->union_type;
                            $youhuiq->sctj       = $info->sctj;
                            if ($info->yxq_type == 0) {
                                $youhuiq->start = strtotime(date('Y-m-d', time()));
                                $youhuiq->end   = $youhuiq->start + $info->yxq_days * 24 * 3600;
                            } else {
                                $youhuiq->start = $info->start;
                                $youhuiq->end   = $info->end;
                            }
                            $youhuiq->name     = $info->name;
                            $youhuiq->add_time = $this->now;
                            $youhuiq->enabled  = 1;
                            $youhuiq->save();
                            $this->log_pay_points($info->goods_amount,'使用积分兑换积分券 (优惠券id:' . $youhuiq->yhq_id . ',兑换前积分:' . $this->user->pay_points . ')');
                        }
                        $info->num = $info->num - $info->yhq_num;
                        $info->save();
                    });
                    $msg                   = '兑换成功';
                    $result['error']       = 0;
//                    $this->assign['error'] = 0;
//                    $this->assign['show']  = 1;
//                    $this->assign['show1'] = 1;
//                    $this->assign['text']  = $msg;
//                    $content               = response()->view('common.tanchuc', $this->assign)->getContent();

                    $result['msg'] = $msg;
                }
            }
        }
        return $result;
    }

    private function ajax_return($msg)
    {
//        $this->assign['show']  = 1;
//        $this->assign['show1'] = 1;
//        $this->assign['error'] = 1;
//        $this->assign['text']  = $msg;
//        $content               = response()->view('common.tanchuc', $this->assign)->getContent();
        $result['error']       = 1;
        $result['msg']         = $msg;
        return $result;
    }

    private function log_pay_points($pay_points,$change_desc)
    {
        $account_log = new AccountLog();
        $account_log->user_id = $this->user->user_id;
        $account_log->user_money = 0;
        $account_log->frozen_money = 0;
        $account_log->rank_points = 0;
        $account_log->pay_points = $pay_points*(-1);
        $account_log->change_time = $this->now;
        $account_log->change_desc = $change_desc;
        $account_log->change_type = 0;
        $account_log->save();
        $this->user->pay_points -= $pay_points;
        $this->user->save();
    }
}
