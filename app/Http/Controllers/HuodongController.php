<?php

namespace App\Http\Controllers;

use App\MzGoods;
use App\OrderInfo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HuodongController extends Controller
{

    /*
     * 促销专区
     */
    public function cxzq(){
//        $mz = Cache::tags(['shop','mz'])->remember('all',60,function(){
//            return MzGoods::where('is_show',1)->where('start_date','<=',time())->where('end_date','>=',time())
//                ->orderBy('sort','desc')->orderBy('mz_id','desc')->get();
//        });
        $mz = MzGoods::where('is_show',1)->where('start_date','<=',time())->where('end_date','>=',time())
            ->orderBy('sort','desc')->orderBy('mz_id','desc')->get();
        $cxzq = ads(40);
        $assign = [
            'page_title' => '超值换购-',
            'dis' => 10,
            'cxzq' => $cxzq,
            'mz' => $mz,
            'dh_check' => 28,
            'daohang' => 1,
        ];
        if (time() >= strtotime(20170505)) {
            $assign['daohang'] = 0;
        }
        //dd($cxzp);
        return view('cxzq')->with($assign);
    }
    /*
     * 买赠
     */
    public function mz(){
        $mz = Cache::tags(['shop','mz'])->remember('all',60,function(){
            return MzGoods::where('is_show',1)->where('start_date','<=',time())->where('end_date','>=',time())
                ->orderBy('sort','desc')->orderBy('mz_id','desc')->get();
        });
        //dd($goods);
        $cxzq = ads(40);
        $assign = [
            'page_title' => trans('common.huodong'),
            //'dis' => 10,
            'mz' => $mz,
            'cxzq' => $cxzq,
            'middle_nav' => nav_list('middle'),
        ];
        //dd($cxzp);
        return view('huodong.mz')->with($assign);
    }

    public function gzbl(){
        $assign = [
            'page_title' => '贵州百灵-',
            //'dis' => 10,
            'middle_nav' => nav_list('middle'),
        ];
        //dd($cxzp);
        return view('huodong.bailing')->with($assign);
    }

    public function zhengqing(){
        $assign = [
            'page_title' => '正清-',
            //'dis' => 10,
            'middle_nav' => nav_list('middle'),
        ];
        //dd($cxzp);
        return view('huodong.zqhd')->with($assign);
    }
    /**
     * 品牌专区
     */
    public function ppzq(){

        $ad117 = ads(117,true);
        $ad118 = ads(118);
        $ad119 = ads(119,true);

        $assign = [
            'page_title' => '品牌专区-',
            'ad117' => $ad117,
            'ad118' => $ad118,
            'ad119' => $ad119,
            'dh_check' => 44,
        ];
        //dd($cxzp);
        return view('huodong.ppzq')->with($assign);
    }

    /**
     * 大屏幕
     */
    public function dpm(){
        $goods_amount = OrderInfo::where('order_status',1)
            ->whereBetween('add_time',[strtotime('2016-11-11 00:00:00'),strtotime('2016-11-12 00:00:00')])
            ->sum('goods_amount');
        $goods_amount = 32601415;
        $goods_amount = intval($goods_amount);
        $len = strlen($goods_amount);
        $str = '';
        for($i=$len;$i<8;$i++){
            $str .= '0';
        }
        $str .= $goods_amount;
        $money_arr = [substr($str,0,2),substr($str,2,3),substr($str,5,3)];
        $arr = [
            [
                'start'=>0,
                'end'=>300,
                'px1'=>5,
                'px2'=>56,
            ],
            [
                'start'=>300,
                'end'=>600,
                'px1'=>56,
                'px2'=>112,
            ],
            [
                'start'=>600,
                'end'=>900,
                'px1'=>112,
                'px2'=>174,
            ],
            [
                'start'=>900,
                'end'=>1200,
                'px1'=>174,
                'px2'=>236,
            ],
            [
                'start'=>1200,
                'end'=>1500,
                'px1'=>236,
                'px2'=>305,
            ],
            [
                'start'=>1500,
                'end'=>1800,
                'px1'=>305,
                'px2'=>374,
            ],
            [
                'start'=>1800,
                'end'=>2000,
                'px1'=>374,
                'px2'=>442,
            ],
            [
                'start'=>2000,
                'end'=>2200,
                'px1'=>442,
                'px2'=>507,
            ],
            [
                'start'=>2200,
                'end'=>2500,
                'px1'=>507,
                'px2'=>577,
            ],
            [
                'start'=>2500,
                'end'=>2800,
                'px1'=>577,
                'px2'=>644,
            ],
            [
                'start'=>2800,
                'end'=>3000,
                'px1'=>644,
                'px2'=>704,
            ],
            [
                'start'=>3000,
                'end'=>4000,
                'px1'=>704,
                'px2'=>750,
            ],
        ];
        $px = 0;
        $goods_amount = $goods_amount/10000;
        foreach($arr as $v){
            if($goods_amount>$v['start']&&$goods_amount<=$v['end']){
                $bili = ($v['px2']-$v['px1'])/($v['end']-$v['start']);
                $px = $bili*($goods_amount-$v['start']) + $v['px1'];
            }
        }
        return [
            'amount'=>$money_arr,
            'px'=>$px,
            'end'=>strtotime('2016-11-12 00:00:00')-time(),
            'goods_amount'=>$goods_amount
        ];
    }

    /**
     * 获取用户信息判断登陆状态
     */
    public function get_user_info(){
        $time = strtotime('2016-12-12 00:00:00');
        $time1 = strtotime('2016-12-19 00:00:00');
        if(time()>=$time){
            $end = $time1 - time();
            $type = 1;
        }else{
            $end = $time-time();
            $type = 2;
        }
        $user = auth()->user();
        $content = response()->view('shuang12.member_info',['user'=>$user])->getContent();
        if(auth()->check()){

            return [
                'time'=>time(),
                'html'=>$content,
                'check'=>1,
                'province'=>$user->province,
                'cart_num'=>cart_info(),
                'end'=>$end,
            ];
        }else{
            return [
                'time'=>time(),
                'html'=>$content,
                'check'=>0,
                'province'=>0,
                'cart_num'=>0,
                'end'=>$end,
            ];
        }
    }
}
