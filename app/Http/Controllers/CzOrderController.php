<?php

namespace App\Http\Controllers;

use App\Common\Pay\Union;
use App\Models\CzOrder;
use App\Payment;
use App\YouHuiCate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Jai\Contact\Http\Controllers\WeixinController;
use Jai\Contact\Http\Controllers\XyyhController;

class CzOrderController extends Controller
{
    use Union;

    private $user;

    private $assign;

    private $now;

    public function __construct()
    {
        $this->user           = auth()->user()->is_zhongduan();
        $this->assign['user'] = $this->user;
        $this->now            = time();
    }

    public function getIndex()
    {
        if($this->user->ls_review==0 || $this->user->ls_review_7day == 0 || ($this->user->ls_review_7day == 1 && $this->user->day7_time < time())){
            show_msg('请审核后再购买');
        }
        $list = YouHuiCate::where('sctj', 8)->where('yhq_num', '>', 0)
            ->where('num', '>', 0)->where('status', 1)
            ->where('gz_end', '>', $this->now)
            ->where('gz_start', '<', $this->now)
            ->where(function ($query) {
                $query->where('user_rank', 'like', '%' . $this->user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) {
                $query->where('area', 'like', '%' . $this->user->province . '%')->orwhere('area', '');
            });
        $list = $list->get();
        if (count($list) == 0) {
            return redirect()->to('/');
        }
        //dd($list);
        $this->assign['result'] = $list;
        $this->assign['page_title'] = '充值送券活动-';
        return view('huodong.czsq',$this->assign);
    }

    public function postCz(Request $request)
    {
        $cat_id = intval($request->input('cat_id', 0));
        $pay_id = intval($request->input('pay_id', 7));
        if($cat_id==0){
            $msg    = '请选择充值包';
            $result = $this->error_tip($msg);
            return $result;
        }
        if($pay_id==0){
            $msg    = '请选择支付方式';
            $result = $this->error_tip($msg);
            return $result;
        }
        $info   = YouHuiCate::where('sctj', 8)->where('yhq_num', '>', 0)
            ->where('num', '>', 0)->where('status', 1)
            ->where('gz_end', '>', $this->now)->where('gz_start', '<', $this->now)
            ->where(function ($query) {
                $query->where('user_rank', 'like', '%' . $this->user->user_rank . '%')->orwhere('user_rank', '');
            })->where(function ($query) {
                $query->where('area', 'like', '%' . $this->user->province . '%')->orwhere('area', '');
            })->find($cat_id);
        if (count($info) == 0) {
            $msg    = '活动不存在';
            $result = $this->error_tip($msg);
        } else {
            if ($this->now < $info->start) {
                $msg    = '活动未开始';
                $result = $this->error_tip($msg);
            } elseif ($this->now > $info->end) {
                $msg    = '活动已结束';
                $result = $this->error_tip($msg);
            } else {
                $cz_order = CzOrder::where('cat_id',$cat_id)->where('user_id',$this->user->user_id)->where('pay_status',0)->first();//查询是否有未支付订单
                if(empty($cz_order)) {
                    $cz_order = new CzOrder();
                    $cz_order->order_sn     = $this->get_order_sn() . 'czo';
                    $cz_order->goods_amount = $info->goods_amount;
                    $cz_order->order_amount = $info->goods_amount;
                    $cz_order->user_id      = $this->user->user_id;
                    $cz_order->order_status = 1;
                    $cz_order->cat_id       = $cat_id;
                    $cz_order->pay_status   = 0;
                    $cz_order->add_time     = $this->now;
                    $cz_order->msn          = $this->user->msn;
                }
                $cz_order->pay_id       = $pay_id;
                $cz_order->pay_name     = $this->get_pay_name($pay_id);
                if($cz_order->save()){
                    $msg                   = '前往支付';
                    $result['error']       = 0;
                    $this->assign['error'] = 0;
                    $this->assign['show']  = 1;
                    $this->assign['show1'] = 1;
                    $this->assign['text']  = $msg;
                    $content               = response()->view('common.tanchuc', $this->assign)->getContent();

                    $result['msg'] = $content;
                    $result['order_id'] = $cz_order->order_id;
                }else{
                    $msg    = '生成订单失败';
                    $result = $this->error_tip($msg);
                }
            }
        }
        return $result;
    }

    private function error_tip($msg)
    {
        $this->assign['show']  = 1;
        $this->assign['show1'] = 1;
        $this->assign['error'] = 1;
        $this->assign['text']  = $msg;
        $content               = response()->view('common.tanchuc', $this->assign)->getContent();
        $result['error']       = 1;
        $result['msg']         = $content;
        return $result;
    }

    private function get_order_sn(){
        /*
             * 获取订单号，确保订单号唯一
             */
        $is_order_exist = true ; //标识，默认订单号已经存在
        do {
            $order_sn = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $count = CzOrder::where('order_sn',$order_sn)->count();
            if(empty($count)) {
                $is_order_exist = false ;
            }
        } while($is_order_exist) ;
        return $order_sn ;
    }

    private function get_pay_name($pay_id){
        $pay_name = Payment::where('pay_id',$pay_id)->pluck('pay_name');
        return $pay_name;
    }

    public function postPay(Request $request){
        $order_id = intval($request->input('order_id'));
        $pay_id = intval($request->input('pay_id'));
        $order_info = CzOrder::where('order_id',$order_id)->where('user_id',$this->user->user_id)->firstOrfail();
        switch ($pay_id){
            case 4:
                $this->get_code($request,$order_info);
                break;
            case 6:
                $xyyh = new XyyhController($request);
                $xyyh->new_to_pay($order_info);
                break;
            case 7:
                $weixin = new WeixinController($request);
                return $weixin->new_pay($request,$order_info);
                break;
            default:

        }
    }

    public function postSearch(Request $request){
        $order_id = intval($request->input('order_id'));
        $pay_id = intval($request->input('pay_id'));
        $order_info = CzOrder::where('order_id',$order_id)->firstOrfail();
        if($order_info->pay_status==2){
            return 0;
        }
        return 1;
    }

}
