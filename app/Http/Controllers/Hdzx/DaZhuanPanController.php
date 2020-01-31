<?php

namespace App\Http\Controllers\Hdzx;

use App\Http\Controllers\Controller;
use App\JpGoods;
use App\JpLog;
use App\YouHuiCate;
use App\YouHuiQ;
use Illuminate\Http\Request;

class DaZhuanPanController extends Controller
{

    use HdzxTrait;

    protected $cjcs;

    protected $points = 5000;

    protected $default = 6;

    protected $jp;

    protected $start;

    protected $end;

    protected $bm = 0;

    public function __construct()
    {
        $this->action = 'collection';
        $this->user = auth()->user()->is_zhongduan();
        $this->now = time();
        $this->start = strtotime('2018-08-06');
        $this->end = strtotime('2019-01-18');
//        if (in_array($this->user->user_id, cs_arr())) {
//            $this->start = strtotime('2018-01-15');
//        }
        $this->set_cjcs();
        $this->yzzg();
        $this->bm = date('YmdHis');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->set_assign('cjcs', $this->cjcs);
        $this->common_value();
        return view('hdzx.dazhuanpan', $this->assign);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jp_goods = JpGoods::where('status', 1)->where('type', 1)->where('start', '<', $this->now)->where('end', '>', $this->now)->orderBy('sort_order')->get();
        if (count($jp_goods) == 0) {
            ajax_return('活动未开始', 1);
        }
        if ($this->cjcs <= 0) {
            ajax_return('抽奖次数已用完', 1);
        }
        if ($this->user->pay_points < $this->points) {
            ajax_return('积分不足', 1);
        }
//        if (in_array($this->user->user_id, [11895, 10596, 1099, 5238])) {
//            $this->jp = $jp_goods->whereLoose('jp_id', 5)->first();
//            $this->log_jp_goods();
//        } elseif (in_array($this->user->user_id, [173])) {
//            $this->jp = $jp_goods->whereLoose('jp_id', 3)->first();
//            $this->log_jp_goods();
//        }
        $this->cj_rules($jp_goods);
        if (!$this->jp) {
            ajax_return('活动未开始', 1);
        }
        $jiaodu1 = 360 / count($jp_goods) * $this->jp->sort_order + 180 / count($jp_goods);
        $jiaodu2 = 360 - mt_rand($jiaodu1 - 8, $jiaodu1 + 8);
        ajax_return($this->jp->jp_name, 0, ['jiaodu' => $jiaodu2]);
    }

    protected function set_cjcs()
    {
        $this->cjcs = 5;
        $count = JpLog::where('user_id', $this->user->user_id)->where('add_time', '>=', $this->start)
            ->where('add_time', '<', $this->end)->count();
        $this->cjcs -= $count;
        if ($this->cjcs < 0) {
            $this->cjcs = 0;
        }
    }

    protected function yzzg()
    {
        if ($this->user->is_zhongduan == 0) {
            $msg = '只有终端会员可以参与';
            if (\Illuminate\Support\Facades\Request::ajax()) {
                ajax_return($msg, 1);
            } else {
                tips1($msg);
            }
        }
        if ($this->now < $this->start) {
            $msg = '活动未开始';
            if (\Illuminate\Support\Facades\Request::ajax()) {
                ajax_return($msg, 1);
            } else {
                //tips1($msg);
            }
        }
        if ($this->now >= $this->end) {
            $msg = '活动已结束';
            if (\Illuminate\Support\Facades\Request::ajax()) {
                ajax_return($msg, 1);
            } else {
                tips1($msg);
            }
        }
    }

    protected function create_yhq_cj()
    {
        /**
         * 查询有没有优惠券可以生成 在满足的条件中随机送
         */
        $status = 1;
        $now = time();
        $youhuiq_cate = YouHuiCate::where('sctj', 7)
            ->where('status', 1)->where('gz_start', '<=', $now)->where('gz_end', '>', $now)
            ->where('num', '>', 0)->where('cat_id', $this->jp->cat_id)
            ->where(function ($query) {
                $query->where('user_rank', 'like', '%' . $this->user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) {
                $query->where('area', 'like', '%' . $this->user->province . '%')->orwhere('area', '');
            })->lockForUpdate();
        $youhuiq_cate = $youhuiq_cate->first();
        if ($youhuiq_cate) {//有优惠券
            if ($this->default != $this->jp->cat_id) {
                $count = YouHuiQ::where('cat_id', $youhuiq_cate->cat_id)->where('user_id', $this->user->user_id)
                    ->where('add_time', '>=', $this->start)->where('add_time', '<', $this->end)
                    ->count();//查询该优惠券规则已经生成的优惠券数量
            } else {
                $count = 0;
            }
            if ($count < $youhuiq_cate->yhq_num) {//满足可送券条件
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
                $youhuiq->union_type = $youhuiq_cate->union_type;
                $youhuiq->sctj = $youhuiq_cate->sctj;
                if ($youhuiq_cate->yxq_type == 0) {
                    $youhuiq->start = strtotime(date('Y-m-d', time()));
                    $youhuiq->end = $youhuiq->start + $youhuiq_cate->yxq_days * 24 * 3600;
                } else {
                    $youhuiq->start = $youhuiq_cate->start;
                    $youhuiq->end = $youhuiq_cate->end;
                }
                $youhuiq->name = $youhuiq_cate->name;
                $youhuiq->add_time = $now;
                $youhuiq->enabled = 1;
                $youhuiq->status = 0;
                $youhuiq->order_id = 0;
                $youhuiq->save();
                if ($youhuiq->yhq_id > 0) {
                    $youhuiq_cate->num = $youhuiq_cate->num - 1;
                    $youhuiq_cate->save();
                    $status = 0;
                    log_account_change_type($this->user->user_id, 0, 0, 0, $this->points * (-1), '使用积分抽奖 (抽奖前积分:' . $this->user->pay_points . ')');
                }
            }
        }
        return $status;
    }
}
