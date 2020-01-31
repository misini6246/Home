<?php

namespace App\Http\Controllers;

use App\JpGoods;
use App\JpLog;
use App\UserCjCount;
use App\UserJnmj;
use App\YouHuiCate;
use App\YouHuiQ;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ChouJiangController extends Controller
{

    private $jishu=0;//中奖基数

    private $user;

    private $now;

    private $pay_points=10000;

    private $today_use=1;

    public function __construct(){
        $this->middleware('login_back', ['only' => ['cj','bm','jfdh']]);//登陆返回
        $this->middleware('check_cj',['except'=>'index']);//登陆验证
        $this->user = auth()->user();
        $this->now = time();
    }

    public function index(){

        return view('choujiang.index')->withEnd(strtotime('2017-01-13 00:00:00')-$this->now);
    }

    public function cj(){

        $flag = $this->check_yhq_zg();
//        if($flag==1){
//            return view('message')->with(messageSys('充值余额会员不参与活动',route('index'),[
//                [
//                    'url'=>route('index'),
//                    'info'=>'返回首页',
//                ],
//            ]));
//        }

        if($this->user->is_zhongduan==0){
            return view('message')->with(messageSys('只有终端会员可以参与',route('index'),[
                [
                    'url'=>route('index'),
                    'info'=>'返回首页',
                ],
            ]));
        }
//        $user_cj_count = UserCjCount::findOrNew($this->user->user_id);
//        $user_cj_count->user_id = $this->user->user_id;
//        if(!isset($user_cj_count->count)) {
//            $user_cj_count->count = 0;
//            $user_cj_count->type = 1;
//            $user_cj_count->save();
//        }

        $jp_goods = JpGoods::where('status',1)->where('type',0)->where('start','<',$this->now)->where('end','>',$this->now)->orderBy('sort_order')->get();
        //$jp_log = $this->get_jp_log();
        $is_ks = 0;
        if(count($jp_goods)>0){
            $is_ks = 1;
        }
        $start = strtotime('2017-01-04');
        $end = strtotime('2017-01-13');
        $this->user->cj_num = 10;

        $count = JpLog::where('user_id',$this->user->user_id)->whereBetween('add_time',[$start,$end])->count();
        return view('choujiang.choujiang')->with([
            'user'=>$this->user,
            //'jp_log'=>$jp_log,
            'is_ks'=>$is_ks,
            'count'=>$this->user->cj_num - $count,
        ]);
    }

    public function get_cj(){
//        $result = [
//            'id' => -1,
//            'msg' => '活动已结束',
//        ];
//        return $result;
        $flag = $this->check_yhq_zg();
//        if($flag==1){//充值会员不能抽奖
//            $result = [
//                'id' => -4,
//                'msg' => '充值余额会员不参与活动',
//            ];
//            return $result;
//        }

        if($this->user->is_zhongduan==0){
            $result = [
                'id' => -4,
                'msg' => '只限终端参与',
            ];
            return $result;
        }
//


        $arr = JpGoods::where('status',1)->where('type',0)->where('start','<',$this->now)->where('end','>',$this->now)->orderBy('sort_order')->get();

        if(count($arr)==0){
            $result = [
                'id' => -2,
                'msg' => '活动未开始',
            ];
            return $result;
        }

//        $start = strtotime(date('Ymd'));
//        $end = $start + 3600*24;
        $start = strtotime('2017-01-04');
        $end = strtotime('2017-01-12');
        $this->user->cj_num = 0;
        $this->user->cj_num = 10;

        $count = JpLog::where('user_id',$this->user->user_id)->whereBetween('add_time',[$start,$end])->count();
//        if($count==0){//今天没有抽奖
//            $this->user->cj_num = 1;
//            $this->today_use = 0;//今天没有抽
//        }
        $this->user->cj_num = $this->user->cj_num - $count;
        if($this->user->pay_points<5000){
            $result = [
                'id' => -3,
                'msg' => '积分不足',
            ];
            return $result;
        }
        if($this->user->cj_num<=0){
            $result = [
                'id' => -5,
                'msg' => '抽奖次数已用完',
            ];
            return $result;
        }


//        $user_cj_count = UserCjCount::where('user_id',$this->user->user_id)->pluck('count');
//        if($user_cj_count>=2){
//            $jp_log = new JpLog();
//            $jp_log->user_id = $this->user->user_id;
//            $jp_log->add_time = time();
//            $jp_log->log = '谢谢参与';
//            $jp_log->jp_id = 14;
//            $jp_log->bm = date('YmdHis').$this->user->user_id.'14';
//            $jp_log->is_zj = 0;
//            $jp_log->save();
//            $result = [
//                'id' => 1,
//                'msg' => '谢谢参与',
//                'jiaodu' => 281
//            ];
//            return $result;
//        }

        foreach($arr as $v){
            if(($v->number-$v->ls_num)>0) {//还有剩余数量
                $this->jishu += $v->zjgl;
            }
        }
        $a = $this->get_num($arr);

        if($a==-1){
            $result = [
                'id' => -1,
                'msg' => '活动已结束',
            ];
            return $result;
        }

        $jiaodu1 = 360/count($arr)*$a + 180/count($arr);
        $jiaodu2 = 360 - mt_rand($jiaodu1-8,$jiaodu1+8);
        $result = [
            'id' => $a,
            'msg' => $arr[$a]->jp_name,
            'jiaodu' => $jiaodu2
        ];


        return $result;
    }

    private function get_num($list){
        $res = -1;
        foreach($list as $k=>$v){
            if(($v->number-$v->ls_num)>0) {
                $rand = mt_rand(1, $this->jishu);
                if ($rand <= $v->zjgl) {
                    $res = $k;
                    break;
                } else {
                    $this->jishu -= $v->zjgl;
                }
            }
        }
        if($res==-1){
            return -1;
        }

        $this->jp_log($list[$res]);

        return $res;
    }

    private function jp_log($jp){
        DB::transaction(function()use($jp){
            $jp_log = new JpLog();
            $jp_log->user_id = $this->user->user_id;
            $jp_log->add_time = time();
            $jp_log->log = $jp->jp_name;
            $jp_log->jp_id = $jp->jp_id;
            $jp_log->bm = date('YmdHis').$this->user->user_id.$jp->jp_id;
            if($jp->jp_name!='谢谢参与'){
                $jp_log->is_zj = 1;
                DB::table('user_cj_count')->where('user_id',$this->user->user_id)->increment('count');
                log_account_change($this->user->user_id, 0, 0, 0, -5000, '使用积分抽奖 (抽奖前积分:'.$this->user->pay_points.')');
            }else{
                $jp_log->is_zj = 0;
            }
            $jp_log->save();
            $jp->ls_num = $jp->ls_num+1;
            $jp->save();
            if($jp->cat_id>0){
                $this->create_yhq_cj($jp->cat_id);
            }
        });
    }

    private function create_yhq_cj($cat_id,$sctj=5){
        /**
         * 查询有没有优惠券可以生成 在满足的条件中随机送
         */
        $status = 0;
        $youhuiq_cate = YouHuiCate::where('sctj',$sctj)
            ->where('status',1)->where('gz_start','<',$this->now)->where('gz_end','>',$this->now)
            ->where('num','>',0)->where('cat_id',$cat_id)
            ->where(function($query){
                $query->where('user_rank','like','%'.$this->user->user_rank.'%')->orwhere('user_rank','');
            })->where(function($query){
                $query->where('area','like','%'.$this->user->province.'%')->orwhere('area','');
            });
        $youhuiq_cate = $youhuiq_cate->first();
        if($youhuiq_cate){//有优惠券
            if($sctj==4){//积分兑换
                if($this->user->pay_points<$youhuiq_cate->goods_amount){//积分不足
                    return 2;
                }
            }
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
            if($youhuiq_cate->yxq_type==0){
                $youhuiq->start = strtotime(date('Y-m-d',time()));
                $youhuiq->end = $youhuiq->start + $youhuiq_cate->yxq_days*24*3600;
            }else{
                $youhuiq->start = $youhuiq_cate->start;
                $youhuiq->end = $youhuiq_cate->end;
            }
            $youhuiq->name = $youhuiq_cate->name;
            $youhuiq->add_time = $this->now;
            $youhuiq->enabled = 1;
            $youhuiq->save();
            $youhuiq_cate->num = $youhuiq_cate->num - 1;
            $youhuiq_cate->save();
            $youhuiq->gz_start = $youhuiq_cate->gz_start;
            $youhuiq->gz_end = $youhuiq_cate->gz_end;
            $status = 1;
            if($sctj==4) {//积分兑换
                log_account_change($this->user->user_id, 0, 0, 0, 0 - $youhuiq_cate->goods_amount, '使用积分兑换积分券 (优惠券id:'.$youhuiq->yhq_id.',兑换前积分:'.$this->user->pay_points.')');
            }
        }
        return $status;
    }

    private function check_yhq_zg(){
        $this->user = $this->user->is_zhongduan();
        $jnmj = UserJnmj::where('user_id', $this->user->user_id)->pluck('jnmj_amount');
        if($jnmj>0){
            $flag = 1;
        }else{
            $flag = 0;
        }
        return $flag;
    }

    private function get_jp_log(){
        $jp_log = JpLog::with([
            'user'=>function($query){
                $query->select('user_id','user_name');
            }
        ])->where('is_zj',1)->orderBy('log_id','desc')->take(30)->get();
        if($jp_log){
            foreach($jp_log as $v){
                $v->user->user_name = str_limit($v->user->user_name,2,'***');
            }
        }
        return $jp_log;
    }

    /**
     * 报名领券的页面
     */
    public function bm(){
        $flag = $this->check_yhq_zg();
//        if($flag==1){
//            return view('message')->with(messageSys('充值余额会员不参与活动',route('index'),[
//                [
//                    'url'=>route('index'),
//                    'info'=>'返回首页',
//                ],
//            ]));
//        }
        /**
         * 终端 非充值余额可领
         */
        if($this->user->is_zhongduan==0){
            return view('message')->with(messageSys('只有终端会员可以领取',route('index'),[
                [
                    'url'=>route('index'),
                    'info'=>'返回首页',
                ],
            ]));
        }

        $youhuiq_cate = YouHuiCate::with([
            'youhuiq'=>function($query){
                $query->where('user_id',$this->user->user_id)->select('cat_id');
            }
        ])->where('sctj',6)
            ->where('status',1)
            //->where('gz_start','<',$this->now)->where('gz_end','>',$this->now)
            ->where(function($query){
                $query->where('user_rank','like','%'.$this->user->user_rank.'%')->orwhere('user_rank','');
            })->where(function($query){
                $query->where('area','like','%'.$this->user->province.'%')->orwhere('area','');
            })
            ->select('cat_id','gz_start','gz_end')->get();
        if(count($youhuiq_cate)==0){
            return redirect()->route('index');
        }
        $ids = [];
        foreach($youhuiq_cate as $v){
            if($v->gz_end<$this->now){//活动已结束
                $v->is_ks = -2;
            }elseif($v->gz_start>$this->now){//活动未开始
                $v->is_ks = -1;
            }elseif(count($v->youhuiq)>0){//已领取
                $v->is_ks = -3;
            }else{
                $v->is_ks = 0;
            }
            $ids[] = $v->cat_id;
        }
        return view('choujiang.baoming')->with([
            'cat_ids'=>$youhuiq_cate,
        ]);
    }

    /**
     * 领券
     */
    public function get_bm(Request $request){
        $flag = $this->check_yhq_zg();
//        if($flag==1){
//            $result = [
//                'id' => -3,
//                'msg' => '充值余额会员不参与活动',
//            ];
//            return $result;
//        }
        /**
         * 终端 非充值余额可领
         */
        if($this->user->is_zhongduan==0){
            $result = [
                'id' => -3,
                'msg' => '只有终端可以领取',
            ];
            return $result;
        }

        $cat_id = intval($request->input('cat_id'));
        $arr = [1,2,3,4];
        $num1 = 0;
        $num2 = 0;
        foreach($arr as $v) {
            $is_cunz = YouHuiQ::where('cat_id', $v)->where('user_id', $this->user->user_id)->count();

            if ($is_cunz > 0) {//已经达到最大的拥有数量
//                $result = [
//                    'id' => -2,
//                    'msg' => '您已领取过该福利券',
//                ];
//                return $result;
                $num1 ++;
            }else {

                $status = $this->create_yhq_cj($v, 6);
                if($status==1){
                    $num2 ++;
                }
            }
        }

        //if($status==1){//获得优惠券
        if($num2>0){//获得优惠券
            $result = [
                'id' => 1,
                'msg' => '成功领取',
            ];
        }elseif($num1==0&&$num2==0){
            $result = [
                'id' => 0,
                'msg' => '活动未开始',
            ];
        }else{
            $result = [
                'id' => -2,
                'msg' => '您已领取过',
            ];
        }
        return $result;

    }

    /**
     * 积分兑换
     */
    public function jfdh(){

        $flag = $this->check_yhq_zg();
//        if($flag==1){
//            return view('message')->with(messageSys('充值余额会员不参与活动',route('index'),[
//                [
//                    'url'=>route('index'),
//                    'info'=>'返回首页',
//                ],
//            ]));
//        }

        $youhuiq_cate = YouHuiCate::with([
            'youhuiq'=>function($query){
                $query->select('cat_id');
            }
        ])->where('sctj',4)//积分兑换
            ->where('status',1)
            //->where('gz_start','<',$this->now)->where('gz_end','>',$this->now)
            ->where(function($query){
                $query->where('user_rank','like','%'.$this->user->user_rank.'%')->orwhere('user_rank','');
            })->where(function($query){
                $query->where('area','like','%'.$this->user->province.'%')->orwhere('area','');
            })
            ->select('cat_id','gz_start','gz_end','goods_amount')->get();
        if(count($youhuiq_cate)==0){
            return redirect()->route('index');
        }
        $ids = [];
        foreach($youhuiq_cate as $v){
            if($v->gz_end<$this->now){//活动已结束
                $v->is_ks = -2;
            }elseif($v->gz_start>$this->now){//活动未开始
                $v->is_ks = -1;
            }elseif($v->goods_amount>$this->user->pay_points){//积分不足
                $v->is_ks = -3;
            }else{
                $v->is_ks = 0;
            }
            $ids[] = $v->cat_id;
        }
        return view('choujiang.jfdh')->with([
            'cat_ids'=>$youhuiq_cate,
            'user'=>$this->user,
        ]);
    }

    /**
     * 兑换
     */
    public function get_jf(Request $request){

        $flag = $this->check_yhq_zg();
//        if($flag==1){
//            $result = [
//                'id' => -3,
//                'msg' => '不能参与活动',
//            ];
//            return $result;
//        }

        $cat_id = intval($request->input('cat_id'));


        $status = $this->create_yhq_cj($cat_id,4);

        if($status==1){//获得优惠券
            $result = [
                'id' => 1,
                'msg' => '兑换成功',
            ];
        }elseif($status==2){
            $result = [
                'id' => 0,
                'msg' => '积分不足',
            ];
        }else{
            $result = [
                'id' => 0,
                'msg' => '活动未开始',
            ];
        }
        return $result;

    }
}
