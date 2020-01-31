<?php

namespace App\Http\Controllers;

use App\JpGoods;
use App\JpLog;
use App\OrderInfo;
use App\YouHuiCate;
use App\YouHuiQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class JpController extends Controller
{
    public $user;

    public $model;

    public $jp;

    public $order;

    public $assign = [];

    public $start;

    public $end;

    public $jp_all;
    public function __construct(JpGoods $model)
    {

        $this->model = $model;
        $this->user  = auth()->user();
        if ($this->user) {
            $this->user = $this->user->is_zhongduan();
        }
        $this->start = strtotime('2019-11-01 00:00:00');
        $this->end = strtotime('2019-11-02 00:00:00');
    }
    //测试功能是否正常使用
/*
    public function choujiang(){
        $file = public_path('cj.xls');
        $data = Excel::load($file, function ($reader) {
        })->get();
      return $data;

    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //网站
    public function index(Request $request)
    {
        if($this->start > time() || $this->end < time()){
            return ['start'=>0,'message'=>'活动未开始'];
        }
        if (!auth()->check()) {
            return ['start'=>0,'message'=>'请登录后再操作',];
        }
        if (!in_array($this->user->user_rank, [2, 5])) {
            return ['start'=>0,'message'=>'只有终端客户可参与抽奖'];
        }
        $this->jp_all  = JpLog::whereIn('jp_id', [1, 2, 3, 4])->get();
        $this->order = OrderInfo::where('user_id', $this->user->user_id)
            ->where('is_mhj','!=',1)
            ->orderBy('goods_amount','ASC')
            ->where('add_time','>',$this->start)
            ->where('add_time','<',$this->end)
            ->where('pay_status',2)
            ->where('mobile_pay', 0)
            ->first();

        if (!$this->order) {
            return ['jp_all'=>$this->jp_all,'start'=>0,'message'=>'未获取抽奖资格'];

        }
        $this->assign['user'] = $this->user;
        foreach ($this->jp_all as $v){
            $v->user_name = $this->substr_cut(\App\User::where('user_id',$v->user_id)->lists('msn')->toArray()[0])  ;
        }

        $zj_user  = JpLog::whereIn('jp_id', [1, 2, 3,4,5])->lockForUpdate()->lists('user_id')->toArray();
        if (in_array($this->user->user_id, $zj_user)) {
            $jp = JpLog::where('user_id',$this->user->user_id)->first();
            $jp->user_name =  $this->substr_cut($this->user->user_name);
            if(!empty($jp) && $jp->log == '谢谢惠顾'){
                $jp->log = '未抽中!';
            }
            return ['jp_all'=>$this->jp_all,'cj_user'=>$jp,'start'=>0];
        }

        return ['jp_all'=>$this->jp_all,'cj_user'=>$this->user,'start'=>1];
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
        if($this->start > time() || $this->end < time()){
            return ['start'=>0,'message'=>'活动未开始'];
        }

        if (!auth()->check()) {
            return ['start'=>0,'message'=>'请登录后再操作'];

        }

        if (!in_array($this->user->user_rank, [2, 5])) {
            return ['start'=>0,'message'=>'只有终端客户可参与抽奖'];

        }

        $this->order = OrderInfo::where('user_id', $this->user->user_id)
            ->where('is_mhj','!=',1)
            ->orderBy('goods_amount','ASC')
            ->where('add_time','>',$this->start)
            ->where('pay_status',2)
            ->where('add_time','<',$this->end)
            ->where('mobile_pay', 0)
            ->first();

        if (!$this->order) {
            return ['start'=>0,'message'=>'未获取抽奖资格'];

        }

        $fendan   = JpLog::where('user_id', $this->order->user_id)->count();


        if($fendan){
            return ['start'=>0,'message'=>'活动期间每个用户只有一次抽奖机会'];

        }
        $jp_ids   = [5];
        $zj_user  = JpLog::whereIn('jp_id', [1, 2, 3, 4])->lockForUpdate()->lists('user_id')->toArray();
        if (!in_array($this->user->user_id, $zj_user)) {
            if (($this->order->money_paid+$this->order->surplus) < 1000 && ($this->order->money_paid+$this->order->surplus) >= 200 && $fendan == 0) {
                $jp_ids =   $this->ids([1,2,3,4]);
            }elseif (($this->order->money_paid+$this->order->surplus) > 1000 && ($this->order->money_paid+$this->order->surplus) >= 200 && $fendan == 0){
                $jp_ids =  $this->ids([4]);
            }
        }
        $now = time();
        DB::transaction(function () use ($jp_ids, $now) {
            $jp_goods  = JpGoods::where('status', 1)->where('type', 4)
                ->whereIn('jp_id', $jp_ids)
               ->where('start', '<', $now)->where('end', '>', $now)
                ->orderBy('sort_order')->lockForUpdate()->get();

            $log_count = $this->log_count();

            if ($log_count > 0) {
                return ['start'=>0,'message'=>'每人只有一次抽奖机会'];

            }

            $this->cj_rules($jp_goods);
        });

        if (!$this->jp) {
            return ['start'=>0,'message'=>'活动未开始'];

        }
        if ($this->jp->jp_name == '未中奖') {
            $bm = 0;
        } else {
            $len = strlen($this->jp->jp_log_id);
            $bm  = $this->jp->jp_log_id;
            for ($i = $len; $i < 5; $i++) {
                $bm = '0' . $bm;
            }
        }
//        $content = response()->view('choujiang.content', ['id' => $this->jp->jp_id, 'bm' => $bm])->getContent();
       return ['jp'=>$this->jp];
    }

    private function ids($ids){

        $arr = [];
        $jp_goods  = JpGoods::where('status', 1)->where('type', 4)
            ->whereIn('jp_id',$ids)
            ->where('start', '<', time())->where('end', '>', time())
            ->orderBy('sort_order')->lockForUpdate()->get();
        foreach ($jp_goods as $v){
            if (($v->number - $v->ls_num) > 0) {//还有剩余数量
                $arr[] =$v->jp_id;
            }
        }
        if(!$arr){
            $arr= [5] ;
        }
        return $arr;
    }
    private function cj_rules($jp_goods)
    {
//        $cj_type = Cache::tags('shop')->rememberForever('cj_type', function () {
//            return 0;
//        });
//        if ($cj_type == 0) {
//            $this->jp = $jp_goods->where('jp_name', '未中奖')->first();
//            $this->log_jp_goods();
//            return -1;
//        }
//        if (in_array($this->user->user_id, [11895, 10596, 1099, 5238])) {
//            $this->jp = $jp_goods->whereLoose('jp_id', 5)->first();
//            $this->log_jp_goods();
//            return 0;
//        } elseif (in_array($this->user->user_id, [173])) {
//            $this->jp = $jp_goods->whereLoose('jp_id', 3)->first();
//            $this->log_jp_goods();
//            return 0;
//        }
        $jishu = 0;
        $res   = -1;


        if (count($jp_goods) > 0) {
            foreach ($jp_goods as $v) {
                if (($v->number - $v->ls_num) > 0) {//还有剩余数量
                    $jishu += $v->zjgl;
                }
            }

            foreach ($jp_goods as $k => $v) {
              
                if (($v->number - $v->ls_num) > 0) {
                    //随机奖品
                    $rand = mt_rand(1, $jishu);

                    if ($rand <= $v->zjgl) {
                        $res      = $k;
                        $this->jp = $v;

                        $status   = $this->log_jp_goods();

                        if ($status == 1) {

                            $this->jp = $jp_goods->whereLoose('jp_name', '五折大奖')->first();

                            $this->log_jp_goods();
                        }
                        break;
                    } else {
                        $jishu -= $v->zjgl;
                    }
                }
            }

        }
        return $res;
    }

    private function log_jp_goods()
    {
        $flag = DB::transaction(function () {
            $status = 0;
            if ($this->jp->cat_id > 0) {
                $status = $this->create_yhq_cj();
                if ($status == 1) {
                    return 1;
                }
            } elseif ($this->jp->jp_id == 12) {
                log_account_change_type($this->user->user_id, 0, 0, 0, 1000, '周年庆下单抽奖:' . $this->order->order_sn);
            }
            if ($status == 0 || $this->jp->cat_id == 0) {
                $jp_log           = new JpLog();
                $jp_log->user_id  = $this->user->user_id;
                $jp_log->add_time = time();
                $jp_log->log      = $this->jp->jp_name;
                $jp_log->jp_id    = $this->jp->jp_id;
                $jp_log->bm       = $this->order->order_sn;
                if (strpos($this->jp->jp_name, '未中奖') !== false) {
                    $jp_log->is_zj = 1;
                } else {
                    $jp_log->is_zj = 0;
                }
                $jp_log->save();
                $this->jp->ls_num = $this->jp->ls_num + 1;
                $this->jp->save();
                $this->jp->setRelation('jp_log_id', $jp_log->log_id);
            }
        });
        return $flag;
    }

    private function create_yhq_cj()
    {
        /**
         * 查询有没有优惠券可以生成 在满足的条件中随机送
         */
        $now          = time();
        $youhuiq_cate = YouHuiCate::where('sctj', 7)
            ->where('status', 1)->where('gz_start', '<', $now)->where('gz_end', '>', $now)
            ->where('num', '>', 0)->where('cat_id', $this->jp->cat_id)
            ->where(function ($query) {
                $query->where('user_rank', 'like', '%' . $this->user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) {
                $query->where('area', 'like', '%' . $this->user->province . '%')->orwhere('area', '');
            });
        $youhuiq_cate = $youhuiq_cate->first();
        if ($youhuiq_cate) {//有优惠券
            $count = YouHuiQ::where('cat_id', $youhuiq_cate->cat_id)->where('user_id', $this->user->user_id)->count();//查询该优惠券规则已经生成的优惠券数量
            if ($count < $youhuiq_cate->yhq_num && $this->order->order_amount < $youhuiq_cate->goods_amount && $youhuiq_cate->je <= 1) {//满足可送券条件
                $yhq_je                     = $this->order->order_amount * $youhuiq_cate->je;
                $this->order->pack_fee      += $yhq_je;
                $this->order->order_amount  -= $yhq_je;
                $this->order->change_status = 1;
                if ($this->order->order_amount == 0) {
                    $this->order->pay_status = 2;
                    $this->order->pay_time   = $now;
                }
                $youhuiq            = new YouHuiQ();
                $youhuiq->user_id   = $this->user->user_id;
                $youhuiq->cat_id    = $youhuiq_cate->cat_id;
                $youhuiq->min_je    = $youhuiq_cate->min_je;
                $youhuiq->area      = $youhuiq_cate->area;
                $youhuiq->user_rank = $youhuiq_cate->user_rank;
                if ($yhq_je > 0) {
                    $youhuiq->je = $yhq_je;
                } else {
                    $youhuiq->je = $youhuiq_cate->je;
                }
                $youhuiq->type       = $youhuiq_cate->type;
                $youhuiq->yxq_type   = $youhuiq_cate->yxq_type;
                $youhuiq->yxq_days   = $youhuiq_cate->yxq_days;
                $youhuiq->union_type = $youhuiq_cate->union_type;
                $youhuiq->sctj       = $youhuiq_cate->sctj;
                if ($youhuiq_cate->yxq_type == 0) {
                    $youhuiq->start = strtotime(date('Y-m-d', time()));
                    $youhuiq->end   = $youhuiq->start + $youhuiq_cate->yxq_days * 24 * 3600;
                } else {
                    $youhuiq->start = $youhuiq_cate->start;
                    $youhuiq->end   = $youhuiq_cate->end;
                }
                $youhuiq->name     = $youhuiq_cate->name;
                $youhuiq->add_time = $now;
                $youhuiq->enabled  = 1;
                $youhuiq->status   = 1;
                $youhuiq->order_id = $this->order->order_id;
                $youhuiq->use_time = time();
                $youhuiq->save();
                $youhuiq_cate->num = $youhuiq_cate->num - 1;
                $youhuiq_cate->save();
                $this->order->save();
                return 0;
            }
        }
        return 1;
    }

    public function check_log_count()
    {
        if (!in_array($this->user->user_rank, [2, 5])) {
            return ['start'=>0,'message'=>'只有终端客户可参与抽奖'];

        }
        $html = <<<box
<a class="choujiang_btn" onclick="cj()"></a>
box;
        $now  = time();
        if (in_array($this->user->user_id, cs_arr())) {
            $now += 3600 * 24;
        }
        $jp_goods = JpGoods::where('status', 1)->where('type', 4)
            ->where('start', '<', $now)->where('end', '>', $now)
            ->orderBy('sort_order')->get();
        if (count($jp_goods) == 0) {
            return ['start'=>0,'message'=>'活动未开始'];

        }
        $log_count = $this->log_count();
        if ($log_count == 0) {
            ajax_return($html);
        }
        return ['start'=>0,'message'=>'没有抽奖机会'];
    }

    protected function log_count()
    {
        if (in_array($this->user->user_id, cs_arr())) {
            return 0;
        }
        return JpLog::where('user_id', $this->user->user_id)
            ->whereIn('jp_id', [1, 2, 3, 4])
            ->where('log_id', '>', 13900)
            ->lockForUpdate()->count();
    }


    private function substr_cut($user_name){
        $strlen         = mb_strlen($user_name, 'utf-8');
        $firstStr     = mb_substr($user_name, 0, 2, 'utf-8');
        $lastStr     = mb_substr($user_name, -2, 2, 'utf-8');
        return  $firstStr . '******' . $lastStr;
    }

}
