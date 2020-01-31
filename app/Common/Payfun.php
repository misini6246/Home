<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-06-13
 * Time: 16:08
 */

namespace App\Common;


use App\Models\CzOrder;
use App\OrderInfo;
use App\User;
use App\ZqOrder;
use App\ZqOrderSy;
use App\ZqOrderYwy;
use Illuminate\Support\Facades\DB;

trait Payfun
{

    /**
     * 支付按钮
     */
    private function button($order, $bank, $type = 0)
    {
        $this->bank = $bank;
        switch ($this->bank) {
            case 12:
                $botton = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="' . route('alipay_pc.index') . '" method="get" target="_blank">
                <input class="J_payonline" value="支付宝支付" type="submit" onclick="toSearch($(this))" searchUrl="' . route('user.order_search', ['id' => $order->order_id, 'type' => $type]) . '">
                <input value="' . $order->order_id . '" name="id" type="hidden">
                <input value="12" name="bank" type="hidden">
                <input value="' . $type . '" name="type" type="hidden">
                </form>';
                break;
            case 5:
                $botton = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="' . route('xyyh.pay') . '" method="get" target="_blank">
                <input class="J_payonline" value="农业银行" type="submit" onclick="toSearch($(this))" searchUrl="' . route('xyyh.search', ['id' => $order->order_id, 'bank' => 5, 'type' => $type]) . '">
                <input value="' . $order->order_id . '" name="id" type="hidden">
                <input value="5" name="bank" type="hidden">
                <input value="' . $type . '" name="type" type="hidden">
                </form>';
                break;
            case 6:
                $botton = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="' . route('xyyh.pay') . '" method="get" target="_blank">
                <input class="J_payonline" value="快捷支付" type="submit" onclick="toSearch($(this))" searchUrl="' . route('xyyh.search', ['id' => $order->order_id, 'type' => $type]) . '">
                <input value="' . $order->order_id . '" name="id" type="hidden">
                <input value="' . $type . '" name="type" type="hidden">
                </form>';
                break;
            case 8:
                $botton = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" method="get">
                <input class="J_payonline zfbzz" value="支付宝转账" type="button">
                </form><div id="zfbsm" style="display:none;position:absolute;left:495px;;top:-207px;">
                <img style="width:190px;height:250px;" src="' . get_img_path('images/zfbsm.jpg') . '"/></div>
                <script>
                $(".zfbzz").hover(function(){
                    $("#zfbsm").show();
                },function(){
                    $("#zfbsm").hide();
                });
                </script>';
                break;
            case 7:
                $botton = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="' . route('wechat.index') . '" method="get" target="_blank">
                <input class="J_payonline" value="微信支付" type="button" onclick="weixin()" searchUrl="' . route('user.order_search', ['id' => $order->order_id, 'type' => $type]) . '">
                <input value="' . $order->order_id . '" name="id" type="hidden">
                <input value="' . $type . '" name="type" type="hidden">
                </form>
                <script>
                function weixin(){
                    var mask = $("<div class=mask></div>");
                    $("body").append(mask);
                    $.ajax({
                        url:"' . route('wechat.index', ['id' => $order->order_id, 'type' => $type]) . '",
                        type:"get",
                        dataType:"json",
                        success:function(data){
                            $("body").find(".mask").remove();
                            if(data.error === 1){
                                alert(data.msg);
                            }
                            else if(data.error === 2){
                                window.location="' . route('user.payOk', ['id' => $order->order_id, 'type' => $type]) . '";
                            }
                            else{
                                $("body").append(data.msg);
                                int = setInterval("search_weixin()", 3000)
                            }
                        }
                    })
                }
                function search_weixin(){
                    $.ajax({
                        url:"' . route('user.order_search', ['id' => $order->order_id, 'type' => $type]) . '",
                        type:"get",
                        dataType:"json",
                        success:function($result){
                            if($result.error==0){
                                window.location="' . route('user.payOk', ['id' => $order->order_id, 'type' => $type]) . '";
                            }
                        }
                    });
                }
                </script>
                ';
                break;
            case 9:
                $botton = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="' . route('alipay.index') . '" method="get" target="_blank">
                <input class="J_payonline" value="支付宝支付" type="button" onclick="alipay()" searchUrl="' . route('user.order_search', ['id' => $order->order_id, 'type' => $type]) . '">
                <input value="' . $order->order_id . '" name="id" type="hidden">
                <input value="' . $type . '" name="type" type="hidden">
                </form>
                <script>
                function alipay(){
                    var mask = $("<div class=mask></div>");
                    $("body").append(mask);
                    $.ajax({
                        url:"' . route('alipay.index', ['id' => $order->order_id, 'type' => $type]) . '",
                        type:"get",
                        dataType:"json",
                        success:function(data){
                            $("body").find(".mask").remove();
                            if(data.error === 1){
                                alert(data.msg);
                            }
                            else if(data.error === 2){
                                window.location="' . route('user.payOk', ['id' => $order->order_id, 'type' => $type]) . '";
                            }
                            else{
                                $("body").append(data.msg);
                                int = setInterval("search_alipay()", 3000)
                            }
                        }
                    })
                }
                function search_alipay(){
                    $.ajax({
                        url:"' . route('user.order_search', ['id' => $order->order_id, 'type' => $type]) . '",
                        type:"get",
                        dataType:"json",
                        success:function($result){
                            if($result.error==0){
                                window.location="' . route('user.payOk', ['id' => $order->order_id, 'type' => $type]) . '";
                            }
                        }
                    });
                }
                </script>
                ';
                break;
            default :
                $botton = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="' . route('xyyh.pay') . '" method="get" target="_blank">
                <input class="J_payonline" value="快捷支付" type="submit" onclick="toSearch($(this))" searchUrl="' . route('xyyh.search', ['id' => $order->order_id]) . '">
                <input value="' . $order->order_id . '" name="id" type="hidden">
                </form>';
        }
        return $botton;
    }


    private function getOrderSn()
    {

        /*
         * 获取订单号，确保订单号唯一
         */
        $is_order_exist = true; //标识，默认订单号已经存在
        $order_sn = '';
        do {
            $tsbz = '';
            if ($this->type == 1) {
                $tsbz = 'zq';
            } elseif ($this->type == 2) {
                $tsbz = 'yzq';
            } elseif ($this->type == 3) {
                $tsbz = 'szq';
            }
            $order_sn = date('YmdHis', time()) . mt_rand(100, 999) . $tsbz;
            $oid = $this->model->where('order_sn', $order_sn)->count();
            if (empty($oid)) {
                //如果计数为0
                $is_order_exist = false;
            }
        } while ($is_order_exist);
        return $order_sn;

    }

    private function payResult()
    {
        sleep(1);
        $qid = $this->resHandler->getParameter('transaction_id');
        if ($this->type == 1) {
            $order_data = ZqOrder::where('zq_id', $this->order->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        } elseif ($this->type == 2) {
            $order_data = ZqOrderYwy::where('zq_id', $this->order->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        } elseif ($this->type == 3) {
            $order_data = ZqOrderSy::where('zq_id', $this->order->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        } elseif ($this->type == 4) {
            $order_data = CzOrder::where('order_id', $this->order->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        } else {
            $order_data = OrderInfo::where('order_id', $this->order->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        }
        if ($order_data) {
            $user = User::find($order_data->user_id);
            $time = time();
            $note = $this->pay_name . ":" . $qid;
            if ($order_data) {
                $order_data->order_status = 1;
                $order_data->pay_status = 2;
                $order_data->pay_time = $time;
                $order_data->qid = $qid;
                $order_data->money_paid = $this->order->pay_amount / 100;
                $order_data->order_amount = 0;
                $order_data->pay_id = $this->pay_id;
                $order_data->o_paid = $this->order->pay_amount / 100;
                $order_data->trace_time = $this->resHandler->getParameter('time_end') != '' ? strtotime($this->resHandler->getParameter('time_end')) : $time;
                $order_data->pay_name = $this->pay_name;
                DB::transaction(function () use ($order_data, $note, $user) {
                    //dd($order_data);
                    if ($order_data->save()) {
                        if ($this->type == 1) {//账期订单
                            DB::table('order_info')
                                ->where('zq_id', $order_data->zq_id)
                                ->where('order_status', 1)
                                ->where('user_id', $user->user_id)
                                ->where('is_zq', 1)
                                ->where('pay_status', '!=', 2)->update([
                                    'order_status' => 1,
                                    'pay_status' => 2,
                                    'pay_time' => time(),
                                    'money_paid' => DB::raw('order_amount'),
                                    'order_amount' => 0,
                                ]);
                            log_zq_change($user, 0, 0 - $order_data->money_paid, $order_data->order_sn . $note);
                            order_action_zq($order_data, $note, $user->user_name);
                        } elseif ($this->type == 2) {//账期订单
                            DB::table('order_info')
                                ->where('zq_id', $order_data->zq_id)
                                ->where('order_status', 1)
                                ->where('user_id', $user->user_id)
                                ->where('is_zq', 2)
                                ->where('pay_status', '!=', 2)->update([
                                    'order_status' => 1,
                                    'pay_status' => 2,
                                    'pay_time' => time(),
                                    'money_paid' => DB::raw('order_amount'),
                                    'order_amount' => 0,
                                ]);
                            log_zq_change_ywy($user, 0, 0 - $order_data->money_paid, $order_data->order_sn . $note);
                            order_action_zq_ywy($order_data, $note, $user->user_name);
                        } elseif ($this->type == 3) {//账期订单
                            DB::table('order_info')
                                ->where('zq_id', $order_data->zq_id)
                                ->where('order_status', 1)
                                ->where('user_id', $user->user_id)
                                ->where('is_zq', 3)
                                ->where('pay_status', '!=', 2)->update([
                                    'order_status' => 1,
                                    'pay_status' => 2,
                                    'pay_time' => time(),
                                    'money_paid' => DB::raw('order_amount'),
                                    'order_amount' => 0,
                                ]);
                            log_zq_change_sy($user, 0, 0 - $order_data->money_paid, $order_data->order_sn . $note);
                            order_action_zq_sy($order_data, $note, $user->user_name);
                        } else {
                            order_action($order_data, $note, $user->user_name);
                        }
                    }
                });
            }
        }
    }

    public function notify_fun($request)
    {
        $xml = file_get_contents('php://input');
        $this->resHandler->setContent($xml);
        //var_dump($this->resHandler->setContent($xml));
        $this->resHandler->setKey($this->cfg->C('key'));
        if ($this->resHandler->isTenpaySign()) {
            if ($this->resHandler->getParameter('status') == 0 && $this->resHandler->getParameter('result_code') == 0) {
                $order_sn = $this->resHandler->getParameter('out_trade_no');
                $order_sn1 = $this->resHandler->getParameter('attach');
                $this->type = $request->input('type', 0);
                $online_order = $this->model->where('order_sn', $order_sn)->select('id', 'order_sn', 'order_id', 'update_time')->first();
                if (!$online_order) {
                    if ($this->type == 1) {//账期订单
                        $this->order = ZqOrder::where('order_sn', $order_sn1)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } elseif ($this->type == 3) {//尚医账期订单
                        $this->order = ZqOrderSy::where('order_sn', $order_sn1)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } elseif ($this->type == 2) {//账期订单
                        $this->order = ZqOrderYwy::where('order_sn', $order_sn1)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } else {
                        $this->order = OrderInfo::where('order_sn', $order_sn1)
                            ->select('order_id', 'order_amount', 'order_sn')
                            ->first();
                    }
                    $this->order_id = $this->order->order_id;
                } else {
                    $this->order_id = $online_order->order_id;
                    if ($this->type == 1) {//账期订单
                        $this->order = ZqOrder::where('zq_id', $online_order->order_id)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } elseif ($this->type == 2) {//账期订单
                        $this->order = ZqOrderYwy::where('zq_id', $online_order->order_id)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } elseif ($this->type == 3) {//尚医账期订单
                        $this->order = ZqOrderSy::where('zq_id', $online_order->order_id)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } else {
                        $this->order = OrderInfo::where('order_id', $online_order->order_id)
                            ->select('order_id', 'order_amount', 'order_sn')
                            ->first();
                    }
                    $this->order->online_order = $online_order;
                }
                $res = $this->resHandler->getAllParameters();
                if (abs($this->order->order_amount * 100 - $res['total_fee']) < 0.000001) {
                    $this->order->pay_amount = $res['total_fee'];
                    $this->payResult();
                    return 'success';
                }
            } else {
                return 'failure1';
            }
        } else {
            return 'failure2';
        }
    }
}