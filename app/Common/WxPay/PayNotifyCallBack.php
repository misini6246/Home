<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/10/16
 * Time: 12:50
 */

namespace App\Common\WxPay;


use App\OrderInfo;
use App\User;
use App\WeixinOrder;
use App\ZqOrder;
use App\ZqOrderSy;
use App\ZqOrderYwy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);

        $config = new WxPayConfig();
        $result = WxPayApi::orderQuery($config, $input);
        if (array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS") {
            return true;
        }
        return false;
    }

    /**
     *
     * 回包前的回调方法
     * 业务可以继承该方法，打印日志方便定位
     * @param string $xmlData 返回的xml参数
     *
     **/
    public function LogAfterProcess($xmlData)
    {
        return;
    }

    //重写回调处理函数

    /**
     * @param WxPayNotifyResults $data 回调解释出的参数
     * @param WxPayConfigInterface $config
     * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
     * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     */
    public function NotifyProcess($objData, $config, &$msg)
    {
        $data = $objData->GetValues();
        //TODO 1、进行参数校验
        if (!array_key_exists("return_code", $data)
            || (array_key_exists("return_code", $data) && $data['return_code'] != "SUCCESS")) {
            //TODO失败,不是支付成功的通知
            //如果有需要可以做失败时候的一些清理处理，并且做一些监控
            $msg = "异常异常";
            return false;
        }
        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";
            return false;
        }

        //TODO 2、进行签名验证
        try {
            $checkResult = $objData->CheckSign($config);
            if ($checkResult == false) {
                //签名错误
                return false;
            }
        } catch (\Exception $e) {
            Log::info(json_encode($e));
        }

        //TODO 3、处理业务逻辑
        $notfiyOutput = array();


        //查询订单，判断订单真实性
        if (!$this->Queryorder($data["transaction_id"])) {
            $msg = "订单查询失败";
            return false;
        }
        switch ($data['attach']) {
            case '普通订单':
                $type = 0;
                break;
            case '账期汇总订单':
                $type = 1;
                break;
            case '业务员账期汇总订单':
                $type = 2;
                break;
            default:
                $type = 0;
        }
        $online_order = WeixinOrder::where('order_sn', $data['out_trade_no'])->select('id', 'order_sn', 'order_id', 'update_time')->first();
        if ($online_order) {
            if ($type == 1) {//账期订单
                $order = ZqOrder::where('zq_id', $online_order->order_id)
                    ->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                    ->first();
            } elseif ($type == 2) {//账期订单
                $order = ZqOrderYwy::where('zq_id', $online_order->order_id)
                    ->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                    ->first();
            } elseif ($type == 3) {//尚医账期订单
                $order = ZqOrderSy::where('zq_id', $online_order->order_id)
                    ->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                    ->first();
            } else {
                $order = OrderInfo::where('order_id', $online_order->order_id)
                    ->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                    ->first();
            }
            if ($order) {
                $order->setRelation('online_order', $online_order);
                if (abs($order->order_amount - $data['total_fee'] / 100) < 0.000001) {
                    $this->payResult($data['transaction_id'], strtotime($data['time_end']), $data['total_fee'] / 100, $type, $order);
                }
            }
        }
        return true;
    }

    private function payResult($qid, $trace_time, $amount, $type, $order_data)
    {
        sleep(1);
        if ($order_data) {
            $user = User::find($order_data->user_id);
            $time = time();
            $note = "微信扫码支付:" . $qid;
            if ($order_data) {
                $order_data->order_status = 1;
                $order_data->pay_status = 2;
                $order_data->pay_time = $time;
                $order_data->qid = $qid;
                $order_data->money_paid = $amount;
                $order_data->order_amount = 0;
                $order_data->pay_id = 7;
                $order_data->o_paid = $amount;
                $order_data->trace_time = $trace_time;
                $order_data->pay_name = '微信扫码支付';
                DB::transaction(function () use ($order_data, $note, $user, $type) {
                    //dd($order_data);
                    if ($order_data->save()) {
                        if ($type == 1) {//账期订单
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
                        } elseif ($type == 2) {//账期订单
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
                        } elseif ($type == 3) {//账期订单
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
}