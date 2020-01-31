<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/30
 * Time: 9:09
 */

namespace Jai\Contact\Http\Controllers;

use App\Models\CzOrder;
use App\Payment;
use App\User;
use App\YouHuiCate;
use App\YouHuiQ;
use App\ZqOrder;
use App\ZqOrderSy;
use App\ZqOrderYwy;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\OnlinePay;
use App\OrderInfo;
use App\PayLog;
use Illuminate\Support\Facades\Log;
use Jai\Contact\Http\Controllers\pay\quickpay_service;
use Jai\Contact\Http\Controllers\pay\quickpay_conf;
use Jai\Contact\Http\Controllers\pay\upop;

class UnionPayController extends Controller{
    /*
 * 查詢支付
 */
    public function toSearch(Request $request){
        $id = $request->input('id','');
        $result = [
            'error' => 1,
        ];
        if (!empty($id)) {
            $row = OrderInfo::where('order_status',1)->where('order_id',$id)
                ->select('order_id','order_sn','pay_id','pay_name','pay_status','order_amount','add_time')
                ->first();
            if (!empty($row)) {
                $update_time = time();
                if ($row['pay_status'] == 0) {
                    /* 取得支付信息，生成支付代码 */
                    $order_payment = array(); //用于支付的订单
                    $order_payment['pay_id'] = $row->pay_id;
                    $order_payment['order_sn'] = $row->order_sn;
                    $order_payment['add_time'] = $update_time;
                    $order_payment['order_amount'] = $row->order_amount;
                    $order_payment['order_id'] = $row->order_id;

//                    if ($order_payment['order_amount'] > 0) {
//                        $payment_info = Payment::where('pay_id',4)->where('enabled',1)->first();
//                        $pay_obj = new upop();
//                        $msg = $pay_obj->query($order_payment, unserialize_config($payment_info->pay_config));
//                        if($msg['is_pay']==1){
//                            $result['error'] = 0;
//                        }
//                    }
                } elseif($row['pay_status']==2) {
                    $result['error'] = 0;
                }
            }
        }
        return $result;
    }


    public function toSearch_zq(Request $request){
        $id = $request->input('id','');
        $result = [
            'error' => 1,
        ];
        if (!empty($id)) {
            $row = ZqOrder::where('order_status',1)->where('zq_id',$id)
                ->select('zq_id','order_sn','pay_status','order_amount','add_time')
                ->first();
            if (!empty($row)) {
                $update_time = time();
                if ($row['pay_status'] == 0) {
                    /* 取得支付信息，生成支付代码 */
                    $order_payment = array(); //用于支付的订单
                    $order_payment['pay_id'] = 4;
                    $order_payment['order_sn'] = $row->order_sn;
                    $order_payment['add_time'] = $update_time;
                    $order_payment['order_amount'] = $row->order_amount;
                    $order_payment['order_id'] = $row->zq_id;

                    if ($order_payment['order_amount'] > 0) {
                        $payment_info = Payment::where('pay_id',4)->where('enabled',1)->first();
                        $pay_obj = new upop();
                        //dd($order_payment);
                        $msg = $pay_obj->query_zq($order_payment, unserialize_config($payment_info->pay_config));
                        if($msg['is_pay']==1){
                            $result['error'] = 0;
                        }
                    }
                } elseif($row['pay_status']==2) {
                    $result['error'] = 0;
                }
            }
        }
        return $result;
    }

    public function toSearch_zq_ywy(Request $request){
        $id = $request->input('id','');
        $result = [
            'error' => 1,
        ];
        if (!empty($id)) {
            $row = ZqOrderYwy::where('order_status',1)->where('zq_id',$id)
                ->select('zq_id','order_sn','pay_status','order_amount','add_time')
                ->first();
            if (!empty($row)) {
                $update_time = time();
                if ($row['pay_status'] == 0) {
                    /* 取得支付信息，生成支付代码 */
                    $order_payment = array(); //用于支付的订单
                    $order_payment['pay_id'] = 4;
                    $order_payment['order_sn'] = $row->order_sn;
                    $order_payment['add_time'] = $update_time;
                    $order_payment['order_amount'] = $row->order_amount;
                    $order_payment['order_id'] = $row->zq_id;

                    if ($order_payment['order_amount'] > 0) {
                        $payment_info = Payment::where('pay_id',4)->where('enabled',1)->first();
                        $pay_obj = new upop();
                        //dd($order_payment);
                        $msg = $pay_obj->query_zq_ywy($order_payment, unserialize_config($payment_info->pay_config));
                        if($msg['is_pay']==1){
                            $result['error'] = 0;
                        }
                    }
                } elseif($row['pay_status']==2) {
                    $result['error'] = 0;
                }
            }
        }
        return $result;
    }

    public function toSearch_zq_sy(Request $request){
        $id = $request->input('id','');
        $result = [
            'error' => 1,
        ];
        if (!empty($id)) {
            $row = ZqOrderSy::where('order_status',1)->where('zq_id',$id)
                ->select('zq_id','order_sn','pay_status','order_amount','add_time')
                ->first();
            if (!empty($row)) {
                $update_time = time();
                if ($row['pay_status'] == 0) {
                    /* 取得支付信息，生成支付代码 */
                    $order_payment = array(); //用于支付的订单
                    $order_payment['pay_id'] = 4;
                    $order_payment['order_sn'] = $row->order_sn;
                    $order_payment['add_time'] = $update_time;
                    $order_payment['order_amount'] = $row->order_amount;
                    $order_payment['order_id'] = $row->zq_id;

                    if ($order_payment['order_amount'] > 0) {
                        $payment_info = Payment::where('pay_id',4)->where('enabled',1)->first();
                        $pay_obj = new upop();
                        //dd($order_payment);
                        $msg = $pay_obj->query_zq_sy($order_payment, unserialize_config($payment_info->pay_config));
                        if($msg['is_pay']==1){
                            $result['error'] = 0;
                        }
                    }
                } elseif($row['pay_status']==2) {
                    $result['error'] = 0;
                }
            }
        }
        return $result;
    }
    /*
     * 支付结果查询
     */
    private function search($orderSn,$orderNo,$amount,$time){

    }
    /*
     * 获取支付流水号
     */
    private function getOrderSn(){

    }
    /**
     * 修改订单的支付状态
     *
     * @access  public
     * @param   string  $log_id     支付编号
     * @param   integer $pay_status 状态
     * @param   string  $note       备注
     * @return  void
     */
    public function payResult($order_sn, $qid, $pay_status = 2, $trace_time, $note = ''){
        /* 取得所有未付款的订单 */
        //$user = Auth::user();
        $order_data = OrderInfo::where('order_sn',$order_sn)->where('pay_status','!=',2)->where('order_status',1)
            ->first();
        if($order_data){
            $user = User::find($order_data->user_id);
            $order_data->order_status = 1;
            $order_data->confirm_time = time();
            $order_data->pay_status = $pay_status;
            $order_data->pay_time = time();
            $order_data->qid = $qid;
            $order_data->money_paid = $order_data->order_amount;
            $order_data->o_paid = $order_data->order_amount;
            $order_data->order_amount = 0;
            $order_data->pay_id = 4;
            $order_data->pay_name = '银联在线支付';
            $order_data->trace_time = $trace_time;
            DB::transaction(function()use($order_data,$note,$user){
                $order_data->save();
                order_action($order_data,$note,$user->user_name);
                PayLog::where('order_id',$order_data->order_id)->update(['is_paid'=>1]);
            });
        }
    }
    public function payResult_cz($order_sn, $qid, $pay_status = 2, $trace_time, $note = ''){
        /* 取得所有未付款的订单 */
        //$user = Auth::user();
        $order_data = CzOrder::where('order_sn',$order_sn)->where('pay_status','!=',2)->where('order_status',1)
            ->first();
        if($order_data){
            $user = User::find($order_data->user_id);
            $order_data->order_status = 1;
            $order_data->confirm_time = time();
            $order_data->pay_status = $pay_status;
            $order_data->pay_time = time();
            $order_data->qid = $qid;
            $order_data->money_paid = $order_data->order_amount;
            $order_data->o_paid = $order_data->order_amount;
            $order_data->order_amount = 0;
            $order_data->pay_id = 4;
            $order_data->pay_name = '银联在线支付';
            $order_data->trace_time = $trace_time;
            DB::transaction(function()use($order_data,$note,$user){
                if($order_data->save()){
                    log_account_change_type($user->user_id, $order_data->o_paid, 0, 0, 0, '充值订单' . $order_data->order_sn . '转余额', 0, 0, $order_data->order_id);
                    $info = YouHuiCate::find($order_data->cat_id);
                    for ($i = 0; $i < $info->yhq_num; $i++) {
                        $youhuiq            = new YouHuiQ();
                        $youhuiq->user_id   = $user->user_id;
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
                        $youhuiq->add_time = time();
                        $youhuiq->enabled  = 1;
                        $youhuiq->save();
                    }
                    $info->num = $info->num - $info->yhq_num;
                    $info->save();
                }
            });
        }
    }
    /*
     * 后台回调
     */
    public function result(Request $request){
        sleep(1);
        Log::info($request->server('REQUEST_METHOD'));
        if($request->ajax()){
            Log::info(1);
            Log::info(response()->json($request->all())->getContent());
        }else{
            Log::info(response()->json($request->all())->getContent());
            Log::info(0);
        }
        //die;
        //1、取得MSG参数，并利用此参数值生成验证结果对象
        $orderSn = $request->input('qid');
        $order_sn = $request->input('orderNumber');
        $payment_amount = floatval($request->input('orderAmount'));
        $type = intval($request->input('type'));
        if($type==4){
            $order = CzOrder::where('order_sn',$order_sn)->select('order_id','order_sn','order_amount','pay_status')->first();
        }else {
            $order = OrderInfo::where('order_sn', $order_sn)->select('order_id', 'order_sn', 'order_amount', 'pay_status')->first();
        }
        if(!$order){
            return redirect()->route('index');
        }
        if(($order->pay_status==2&&$order->order_amount==0)){
            if($type==4){
                return redirect()->route('user.cz_order_info', ['id' => $order->order_id]);
            }else {
                return redirect()->route('user.orderInfo', ['id' => $order->order_id]);
            }
        }else {
            $time = strtotime($request->input('respTime'));
            //print_r($time);
            if(abs($order->order_amount*100-$payment_amount)<0.000001) {
                if($type==4){
                    $this->payResult_cz($order->order_sn, $orderSn, 2, $time, "Success！银联交易号：{$orderSn}");
                }else {
                    $this->payResult($order->order_sn, $orderSn, 2, $time, "Success！银联交易号：{$orderSn}");
                }
            }
            if(!$request->ajax()) {
                if($type==4){
                    return redirect()->route('user.cz_order_info', ['id' => $order->order_id]);
                }else {
                    return redirect()->route('user.orderInfo', ['id' => $order->order_id]);
                }
            }
        }
    }

    /**
     * 修改订单的支付状态
     *
     * @access  public
     * @param   string  $log_id     支付编号
     * @param   integer $pay_status 状态
     * @param   string  $note       备注
     * @return  void
     */
    public function payResult_zq($order_sn, $qid, $pay_status = 2, $trace_time, $note = ''){
        /* 取得所有未付款的订单 */
        //$user = Auth::user();
        $order_data = ZqOrder::where('order_sn',$order_sn)->where('pay_status','!=',2)->where('order_status',1)->where('o_paid',0)
            ->first();
        if($order_data){
            $user = User::find($order_data->user_id);
            $order_data->order_status = 1;
            $order_data->pay_status = 2;
            $order_data->pay_time = time();
            $order_data->qid = $qid;
            $order_data->money_paid = $order_data->order_amount;
            $order_data->pay_id = 4;
            $order_data->o_paid = $order_data->order_amount;
            $order_data->pay_name = '银联在线支付';
            $order_data->trace_time = $trace_time;
            $order_data->order_amount = 0;
            DB::transaction(function()use($order_data,$note,$user,$qid){
                $order_data->save();
                DB::table('order_info')
                    ->where('zq_id',$order_data->zq_id)
                    ->where('order_status',1)
                    ->where('is_zq',1)
                    ->where('pay_status','!=',2)
                    ->where('user_id',$user->user_id)->update([
                        'order_status'=>1,
                        'pay_status'=>2,
                        'pay_time'=>time(),
                        'money_paid'=>DB::raw('order_amount'),
                        'order_amount'=>0,
                    ]);
                //dd($order_data);
                order_action_zq($order_data,$note,$user->user_name);
                log_zq_change($user,0,0-$order_data->money_paid,$order_data->order_sn.'银联交易流水号:'.$qid);
                //PayLog::where('order_id',$order_data->order_id)->update(['is_paid'=>1]);
            });
        }
    }
    public function payResult_zq_ywy($order_sn, $qid, $pay_status = 2, $trace_time, $note = ''){
        /* 取得所有未付款的订单 */
        //$user = Auth::user();
        $order_data = ZqOrderYwy::where('order_sn',$order_sn)->where('pay_status','!=',2)->where('order_status',1)
            ->first();
        if($order_data){
            $user = User::find($order_data->user_id);
            $order_data->order_status = 1;
            $order_data->pay_status = 2;
            $order_data->pay_time = time();
            $order_data->qid = $qid;
            $order_data->money_paid = $order_data->order_amount;
            $order_data->pay_id = 4;
            $order_data->o_paid = $order_data->order_amount;
            $order_data->pay_name = '银联在线支付';
            $order_data->trace_time = $trace_time;
            $order_data->order_amount = 0;
            DB::transaction(function()use($order_data,$note,$user,$qid){
                $order_data->save();
                DB::table('order_info')
                    ->where('zq_id',$order_data->zq_id)
                    ->where('order_status',1)
                    ->where('is_zq',2)
                    ->where('pay_status','!=',2)
                    ->where('user_id',$user->user_id)->update([
                        'order_status'=>1,
                        'pay_status'=>2,
                        'pay_time'=>time(),
                        'money_paid'=>DB::raw('order_amount'),
                        'order_amount'=>0,
                    ]);
                //dd($order_data);
                order_action_zq_ywy($order_data,$note,$user->user_name);
                log_zq_change_ywy($user,0,0-$order_data->money_paid,$order_data->order_sn.'银联交易流水号:'.$qid);
                //PayLog::where('order_id',$order_data->order_id)->update(['is_paid'=>1]);
            });
        }
    }
    public function payResult_zq_sy($order_sn, $qid, $pay_status = 2, $trace_time, $note = ''){
        /* 取得所有未付款的订单 */
        //$user = Auth::user();
        $order_data = ZqOrderSy::where('order_sn',$order_sn)->where('pay_status','!=',2)->where('order_status',1)
            ->first();
        if($order_data){
            $user = User::find($order_data->user_id);
            $order_data->order_status = 1;
            $order_data->pay_status = 2;
            $order_data->pay_time = time();
            $order_data->qid = $qid;
            $order_data->money_paid = $order_data->order_amount;
            $order_data->pay_id = 4;
            $order_data->o_paid = $order_data->order_amount;
            $order_data->pay_name = '银联在线支付';
            $order_data->trace_time = $trace_time;
            $order_data->order_amount = 0;
            DB::transaction(function()use($order_data,$note,$user,$qid){
                $order_data->save();
                DB::table('order_info')
                    ->where('zq_id',$order_data->zq_id)
                    ->where('order_status',1)
                    ->where('is_zq',3)
                    ->where('pay_status','!=',2)
                    ->where('user_id',$user->user_id)->update([
                        'order_status'=>1,
                        'pay_status'=>2,
                        'pay_time'=>time(),
                        'money_paid'=>DB::raw('order_amount'),
                        'order_amount'=>0,
                    ]);
                //dd($order_data);
                order_action_zq_sy($order_data,$note,$user->user_name);
                log_zq_change_sy($user,0,0-$order_data->money_paid,$order_data->order_sn.'银联交易流水号:'.$qid);
                //PayLog::where('order_id',$order_data->order_id)->update(['is_paid'=>1]);
            });
        }
    }
    /*
     * 后台回调
     */
    public function result_zq(Request $request){
        //1、取得MSG参数，并利用此参数值生成验证结果对象
        //dd($request->all());
        $orderSn = $request->input('qid');
        $order_sn = $request->input('orderNumber');
        $payment_amount = floatval($request->input('orderAmount'));
        $order = ZqOrder::where('order_sn',$order_sn)->select('zq_id','order_sn','order_amount','pay_status')->first();
        if(!$order){
            if(auth()->user()->user_id==13960) {
                dd($request->all(), $order_sn, $orderSn, $order);
            }else{
                return redirect()->route('index');
            }
        }
        if (($order->pay_status == 2 && $order->order_amount == 0)) {
            return redirect()->route('user.zq_order_info', ['id' => $order->zq_id]);
        } else {
            $time = strtotime($request->input('respTime'));
            if(abs($order->order_amount*100-$payment_amount)<0.000001) {
                $this->payResult_zq($order->order_sn, $orderSn, 2, $time, "Success！银联交易号：{$orderSn}");
            }
            if(!$request->ajax()) {
                return redirect()->route('user.zq_order_info', ['id' => $order->zq_id]);
            }
        }
    }
    public function result_zq_ywy(Request $request){
        //1、取得MSG参数，并利用此参数值生成验证结果对象
        //dd($request->all());
        $orderSn = $request->input('qid');
        $order_sn = $request->input('orderNumber');
        $payment_amount = floatval($request->input('orderAmount'));
        $order = ZqOrderYwy::where('order_sn',$order_sn)->select('zq_id','order_sn','order_amount','pay_status')->first();
        if(!$order){
            if(auth()->user()->user_id==13960) {
                dd($request->all(), $order_sn, $orderSn, $order);
            }else{
                return redirect()->route('index');
            }
        }
        if (($order->pay_status == 2 && $order->order_amount == 0)) {
            return redirect()->route('user.zq_order_info', ['id' => $order->zq_id]);
        } else {
            $time = strtotime($request->input('respTime'));
            if(abs($order->order_amount*100-$payment_amount)<0.000001) {
                $this->payResult_zq_ywy($order->order_sn, $orderSn, 2, $time, "Success！银联交易号：{$orderSn}");
            }
            if($request->ajax()) {
                return redirect()->route('user.zq_order_info', ['id' => $order->zq_id]);
            }
        }
    }
    public function result_zq_sy(Request $request){
        //1、取得MSG参数，并利用此参数值生成验证结果对象
        //dd($request->all());
        $orderSn = $request->input('qid');
        $order_sn = $request->input('orderNumber');
        $payment_amount = floatval($request->input('orderAmount'));
        $order = ZqOrderSy::where('order_sn',$order_sn)->select('zq_id','order_sn','order_amount','pay_status')->first();
        if(!$order){
            if(auth()->user()->user_id==13960) {
                dd($request->all(), $order_sn, $orderSn, $order);
            }else{
                return redirect()->route('index');
            }
        }
        if (($order->pay_status == 2 && $order->order_amount == 0)) {
            return redirect()->route('user.zq_order_info_sy', ['id' => $order->zq_id]);
        } else {
            $time = strtotime($request->input('respTime'));
            if(abs($order->order_amount*100-$payment_amount)<0.000001) {
                $this->payResult_zq_sy($order->order_sn, $orderSn, 2, $time, "Success！银联交易号：{$orderSn}");
            }
            if(!$request->ajax()) {
                return redirect()->route('user.zq_order_info_sy', ['id' => $order->zq_id]);
            }
        }
    }
}