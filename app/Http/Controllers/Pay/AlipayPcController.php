<?php

namespace App\Http\Controllers\Pay;

use App\Common\AlipayPc\AlipayTradeCloseContentBuilder;
use App\Common\AlipayPc\AlipayTradePagePayContentBuilder;
use App\Common\AlipayPc\AlipayTradeService;
use App\Http\Controllers\Controller;
use App\OrderGoods;
use App\OrderInfo;
use App\User;
use App\WeixinOrder;
use App\ZqOrder;
use App\ZqOrderSy;
use App\ZqOrderYwy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlipayPcController extends Controller
{
    private $type;
    private $order;
    private $pay_id;
    private $pay_name;
    private $notify_url;
    private $model;

    public function __construct(Request $request, WeixinOrder $alipayOrder)
    {
        $this->type = intval($request->input('type', 0));
        $this->model = $alipayOrder;
        $this->pay_id = 12;
        $this->pay_name = '支付宝扫码支付';
        $this->notify_url = route('alipay_pc.notify');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $order_id = intval($request->input('id', 0));
        if ($this->type == 1) {//账期订单
            $this->order = ZqOrder::where('zq_id', $order_id)
                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id', 'pay_status')
                ->first();
        } elseif ($this->type == 2) {//账期订单
            $this->order = ZqOrderYwy::where('zq_id', $order_id)
                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id', 'pay_status')
                ->first();
        } elseif ($this->type == 3) {//尚医账期订单
            $this->order = ZqOrderSy::where('zq_id', $order_id)
                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id', 'pay_status')
                ->first();
        } else {
            $this->order = OrderInfo::where('order_id', $order_id)
                ->select('order_id', 'order_amount', 'order_sn', 'user_id', 'pay_status', 'is_separate', 'goods_amount')
                ->first();
            if ($this->order && $this->order->is_separate == 1) {
                tips1('货到付款订单不能在线支付');
            }
            $mx_amount = OrderGoods::where('order_id', $order_id)->sum(DB::raw('goods_number*goods_price'));
            if (abs($mx_amount - $this->order->goods_amount) > 0.01) {
                tips1('订单总金额有误', 1);
            }
        }
        if (!$this->order) {
            tips1('订单不存在');
        }
        if ($this->order->order_status == 2) {
            tips1('订单已取消');
        }
        if ($this->order->pay_status == 2) {
            tips1('订单已支付');
        }
        $this->order->online_order = $this->model->where('order_id', $this->order->order_id)
            ->where('check_num', $this->type)
            ->select('id', 'order_sn', 'order_id', 'update_time')
            ->orderBy('id', 'desc')->first();
        $orderSn = $this->getOrderSn();
        $this->order->online_order = new $this->model;
        $this->order->online_order->order_id = $this->order->order_id;
        $this->order->online_order->order_sn = $orderSn;
        $this->order->online_order->check_num = $this->type;
        $this->order->online_order->save();
        if ($this->order->online_order->id > 0) {
            $payRequestBuilder = new AlipayTradePagePayContentBuilder();
            switch ($this->type) {
                case 0:
                    $type = '普通订单';
                    break;
                case 1:
                    $type = '账期汇总订单';
                    break;
                case 2:
                    $type = '业务员账期汇总订单';
                    break;
                default:
                    $type = '普通订单';
            }
            //$this->close_order();
            $payRequestBuilder->setBody($type);
            $payRequestBuilder->setSubject($this->order->order_sn);
            $payRequestBuilder->setTotalAmount($this->order->order_amount);
            $payRequestBuilder->setOutTradeNo($this->order->online_order->order_sn);

            $aop = new AlipayTradeService();

            /**
             * pagePay 电脑网站支付请求
             * @param $builder 业务参数，使用buildmodel中的对象生成。
             * @param $return_url 同步跳转地址，公网可以访问
             * @param $notify_url 异步通知地址，公网可以访问
             * @return $response 支付宝返回的信息
             */
            $response = $aop->pagePay($payRequestBuilder, route('user.payOk', ['id' => $this->order->order_id]), $this->notify_url);
            return $response;
        }
    }

    public function notify(Request $request)
    {
        $arr = $request->all();
        $alipaySevice = new AlipayTradeService();
        $result = $alipaySevice->check($arr);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if ($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代


            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号

            $out_trade_no = trim($request->input('out_trade_no'));

            //支付宝交易号

            $trade_no = trim($request->input('trade_no'));

            //交易状态
            $trade_status = trim($request->input('trade_status'));


            if ($trade_status == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            } else if ($trade_status == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
                $type = trim($request->input('body'));
                switch ($type) {
                    case '普通订单':
                        $this->type = 0;
                        break;
                    case '账期汇总订单':
                        $this->type = 1;
                        break;
                    case '业务员账期汇总订单':
                        $this->type = 2;
                        break;
                    default:
                        $this->type = 0;
                }
                $online_order = $this->model->where('order_sn', $out_trade_no)->select('id', 'order_sn', 'order_id', 'update_time')->first();
                if (!$online_order) {
                    if ($this->type == 1) {//账期订单
                        $this->order = ZqOrder::where('order_sn', $out_trade_no)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } elseif ($this->type == 3) {//尚医账期订单
                        $this->order = ZqOrderSy::where('order_sn', $out_trade_no)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } elseif ($this->type == 2) {//账期订单
                        $this->order = ZqOrderYwy::where('order_sn', $out_trade_no)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } else {
                        $this->order = OrderInfo::where('order_sn', $out_trade_no)
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
                $total_fee = floatval($request->input('total_amount'));
                if (abs($this->order->order_amount - $total_fee) < 0.000001) {
                    $this->order->pay_amount = $total_fee * 100;
                    $this->payResult($trade_no, strtotime($request->input('gmt_payment')));
                }
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";    //请不要修改或删除
        } else {
            //验证失败
            echo "fail";

        }
    }

    public function close_order()
    {
        $RequestBuilder = new AlipayTradeCloseContentBuilder();
        $RequestBuilder->setOutTradeNo($this->order->order_sn);

        $aop = new AlipayTradeService();
        $aop->Close($RequestBuilder);
    }

    private function payResult($qid, $trace_time)
    {
        sleep(1);
        if ($this->type == 1) {
            $order_data = ZqOrder::where('zq_id', $this->order->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        } elseif ($this->type == 2) {
            $order_data = ZqOrderYwy::where('zq_id', $this->order->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        } elseif ($this->type == 3) {
            $order_data = ZqOrderSy::where('zq_id', $this->order->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
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
                $order_data->trace_time = $trace_time;
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
}
