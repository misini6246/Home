<?php

namespace App\Http\Controllers;

use App\YouHuiCate;
use App\YouHuiQ;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HdLoginController extends Controller
{
    private $user;

    private $now;

    private $assign;

    public function __construct(){
        $this->user = auth()->user()->is_zhongduan();
        $this->now = time();
        $this->assign['user'] = $this->user;
    }

    public function getShuang12(){
        if($this->user->is_zhongduan==0){
            show_msg('只有终端用户可以参与活动');
        }
        $youhuiq_cate = YouHuiCate::with([
            'youhuiq'=>function($query){
                $query->where('user_id',$this->user->user_id)->select('cat_id');
            }
        ])->where('sctj',6)
            ->where('status',1)
            ->where('gz_start','<',$this->now)->where('gz_end','>',$this->now)
            ->where(function($query){
                $query->where('user_rank','like','%'.$this->user->user_rank.'%')->orwhere('user_rank','');
            })->where(function($query){
                $query->where('area','like','%'.$this->user->province.'%')->orwhere('area','');
            })
            ->select('cat_id','gz_start','gz_end')->get();
        if(count($youhuiq_cate)==0){
            return redirect()->route('index');
        }
        $is_has = 0;
        foreach($youhuiq_cate as $v){
            if(count($v->youhuiq)>0){//已领取
                $is_has = 1;
            }
        }
        $this->assign['is_has'] = $is_has;
        return view('shuang12.new_yhq',$this->assign);
    }

    public function postYhq(Request $request){
        $start = strtotime('2016-12-01');
        $end = strtotime('2016-12-14');
        $result = [
            'error'=>0,
            'msg'=>''
        ];
        if($this->now<$start){
            $msg = '活动未开始';
            $this->assign['show'] = 1;
            $this->assign['show1'] = 1;
            $this->assign['error'] = 1;
            $this->assign['text'] = $msg;
            $content = response()->view('common.tanchuc',$this->assign)->getContent();
            $result['error'] = 1;
            $result['msg'] = $content;
        }elseif($this->now>$end){
            $msg = '活动已结束';
            $this->assign['show'] = 1;
            $this->assign['show1'] = 1;
            $this->assign['error'] = 1;
            $this->assign['text'] = $msg;
            $content = response()->view('common.tanchuc',$this->assign)->getContent();
            $result['error'] = 1;
            $result['msg'] = $content;
        }else{
            $arr = [22,23,24,25];
            $num1 = 0;
            $num2 = 0;
            foreach($arr as $v) {
                $is_cunz = YouHuiQ::where('cat_id', $v)->where('user_id', $this->user->user_id)->count();

                if ($is_cunz > 0) {//已经达到最大的拥有数量
                    $num1 ++;
                }else {

                    $status = $this->create_yhq_cj($v, 6);
                    if($status==1){
                        $num2 ++;
                    }
                }
            }

            if($num2>0){//获得优惠券
                $result['msg'] = '成功领取';
            }elseif($num1==0&&$num2==0){
                $msg = '活动未开始';
                $result['error'] = 1;
                $this->assign['show'] = 1;
                $this->assign['show1'] = 1;
                $this->assign['error'] = 1;
                $this->assign['text'] = $msg;
                $content = response()->view('common.tanchuc',$this->assign)->getContent();
                $result['error'] = 1;
                $result['msg'] = $content;
            }else{
                $msg = '已经领取过';
                $result['error'] = 1;
                $this->assign['show'] = 1;
                $this->assign['show1'] = 1;
                $this->assign['error'] = 1;
                $this->assign['text'] = $msg;
                $content = response()->view('common.tanchuc',$this->assign)->getContent();
                $result['error'] = 1;
                $result['msg'] = $content;
            }
        }
        //dd($result);
        return $result;
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
}
