<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/12
 * Time: 15:40
 */

namespace Jai\Contact\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\CzOrder;
use App\OnlinePay;
use App\OrderInfo;
use App\User;
use App\XyyhOrder;
use App\YouHuiCate;
use App\YouHuiQ;
use App\ZqOrder;
use App\ZqOrderSy;
use App\ZqOrderYwy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jai\Contact\Http\Controllers\xyyh\EPay;
use Jai\Contact\Http\Controllers\xyyh\EPay_util;
use Jai\Contact\Http\Controllers\abc\PaymentRequest;
use Jai\Contact\Http\Controllers\abc\QueryOrderRequest;
use Jai\Contact\Http\Controllers\abc\Json;
use Jai\Contact\Http\Controllers\abc\Result;

class XyyhController extends Controller
{

    private $config;
    private $order_id;
    private $order_info;
    private $user;
    private $epay;
    private $type;
    private $bank;
    private $qid;
    private $ip;
    private $pay_name;
    private $pay_time;

    use PayType;

    public function __construct(Request $request)
    {
        $this->user     = auth()->user();
        $this->config   = config('contact.xyyh');
        $this->order_id = intval($request->input('id', 0));
        $this->epay     = new EPay($this->config);
        $this->bank     = intval($request->input('bank', 6));
        $this->ip       = $request->ip();
        switch ($this->bank) {
            case 5:
                $this->pay_name = '农行在线支付';
                break;
            case 6:
                $this->pay_name = '快捷支付';
                break;
            default :
                $this->pay_name = '快捷支付';
        }
    }


    public function pay(Request $request)
    {
        $this->get_order($request);
        if ($this->order_info->online_order->save()) {
            //dd($this->order_info->online_order);
            return $this->to_pay();
        }
    }


    public function response(Request $request)
    {
        Log::info(response()->json($request->all())->getContent());
        $method = $request->server('REQUEST_METHOD');
        if ('GET' === $method && $this->epay->VerifyMac($request->all(), $this->config['commKey']) ||
            'POST' === $method && $this->epay->VerifyMac($request->all(), $this->config['commKey'])
        ) {    //验签成功
//            $trans_status = intval($request->input('trans_status'), 2);
//            if ($trans_status != 1) {
//                echo '支付失败';
//                die;
//            }
            if ('GET' === $method) {                //前台通知

                // 商户可以在这边进行 [前台] 回调通知的业务逻辑处理
                // 注意：后台通知和前台通知有可能同时到来，注意 [需要防止重复处理]
                // 前台跳转回来的通知，需要显示内容，如支付成功等
                if ("NOTIFY_ACQUIRE_SUCCESS" === $request->input('event')) {            //支付成功通知

                    $order_no = $request->input('order_no');
                    if (strpos($order_no, '_') !== false) {
                        $order_no = explode('_', $order_no)[0];
                    }
                    $this->qid    = $request->input('sno');
                    $order_amount = $request->input('order_amount', 0);
                    $type         = substr($order_no, -2);
                    $type1        = substr($order_no, -3);
                    if ($type == 'zq') {
                        $this->type = 1;
                    } elseif ($type1 == 'yzq') {
                        $this->type = 2;
                    } elseif ($type1 == 'szq') {
                        $this->type = 3;
                    } elseif ($type1 == 'czo') {
                        $this->type = 4;
                    } else {
                        $this->type = 0;
                    }
                    if ($this->type == 4) {
                        $this->order_info = CzOrder::where('order_sn', $order_no)
                            ->select('order_id', 'order_amount', 'order_sn', 'user_id')
                            ->first();
                        $this->order_id   = $this->order_info->order_id;
                    } else {
                        $order          = XyyhOrder::where('order_sn', $order_no)
                            ->select('id', 'order_sn', 'order_id', 'update_time')
                            ->first();
                        $this->order_id = $order->order_id;
                        //$this->type = substr($order_no,-1);
                        if ($this->type == 1) {//账期订单
                            $this->order_info = ZqOrder::where('zq_id', $this->order_id)
                                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id')
                                ->first();
                        } elseif ($this->type == 2) {//账期订单
                            $this->order_info = ZqOrderYwy::where('zq_id', $this->order_id)
                                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id')
                                ->first();
                        } elseif ($this->type == 3) {//尚医账期订单
                            $this->order_info = ZqOrderSy::where('zq_id', $this->order_id)
                                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id')
                                ->first();
                        } else {
                            $this->order_info = OrderInfo::where('order_id', $this->order_id)
                                ->select('order_id', 'order_amount', 'order_sn', 'user_id')
                                ->first();
                        }
                        $this->order_info->online_order = $order;
                    }
                    //dd($this->order_info);
                    if ($order_amount == $this->order_info->order_amount) {
                        $this->search_xyyh();
                        die;
                        $this->pay_time               = strtotime($request->input('pay_time', time()));
                        $this->order_info->pay_amount = $order_amount;
                        $this->payResult();
                        $sn = $request->input('order_no');
                        XyyhOrder::where('order_id', $this->order_info->order_id)->where('check_num', $this->type)
                            ->where('order_sn', $sn)->update([
                                'is_pay' => 1
                            ]);
                    }
                    if ($this->type == 1 || $this->type == 2) {
                        return view('message')->with(messageSys('订单支付成功', route('user.zq_order_info', ['id' => $this->order_info->order_id]), [
                            [
                                'url'  => route('user.zq_order'),
                                'info' => '返回订单列表',
                            ],
                        ]));
                    } elseif ($this->type == 3) {
                        return view('message')->with(messageSys('订单支付成功', route('user.zq_order_info_sy', ['id' => $this->order_info->order_id]), [
                            [
                                'url'  => route('user.zq_order_sy'),
                                'info' => '返回订单列表',
                            ],
                        ]));
                    } elseif ($this->type == 4) {
                        return view('message')->with(messageSys('订单支付成功', route('user.cz_order_info', ['id' => $this->order_info->order_id]), [
                            [
                                'url'  => route('user.cz_order'),
                                'info' => '返回订单列表',
                            ],
                        ]));
                    }
                    return view('message')->with(messageSys('订单支付成功', route('user.orderInfo', ['id' => $this->order_info->order_id]), [
                        [
                            'url'  => route('user.orderList'),
                            'info' => '返回订单列表',
                        ],
                    ]));

                } else if ("NOTIFY_ACQUIRE_FAIL" === $request->input('event')) {        // 支付失败通知

                    // 支付失败业务逻辑处理

                } else if ("NOTIFY_REFUND_SUCCESS" === $request->input('event')) {        // 退款成功通知

                    // 退款成功业务逻辑处理

                } else if ("NOTIFY_AUTH_SUCCESS" === $request->input('event')) {        // 快捷支付认证成功通知

                    // 认证成功业务逻辑处理
                }

            } else if ('POST' === $method) {        // 后台通知
                // 商户可以在这边进行 [后台] 回调通知的业务逻辑处理
                // 注意：后台通知和前台通知有可能同时到来，注意 [需要防止重复处理]
                if ("NOTIFY_ACQUIRE_SUCCESS" === $request->input('event')) {            // 支付成功通知

                    $order_no = $request->input('order_no');
                    if (strpos($order_no, '_') !== false) {
                        $order_no = explode('_', $order_no)[0];
                    }
                    $this->qid    = $request->input('sno');
                    $order_amount = $request->input('order_amount', 0);
                    $type         = substr($order_no, -2);
                    $type1        = substr($order_no, -3);
                    if ($type == 'zq') {
                        $this->type = 1;
                    } elseif ($type1 == 'yzq') {
                        $this->type = 2;
                    } elseif ($type1 == 'szq') {
                        $this->type = 3;
                    } elseif ($type1 == 'czo') {
                        $this->type = 4;
                    } else {
                        $this->type = 0;
                    }
                    if ($this->type == 4) {
                        $this->order_info = CzOrder::where('order_sn', $order_no)
                            ->select('order_id', 'order_amount', 'order_sn', 'user_id')
                            ->first();
                        $this->order_id   = $this->order_info->order_id;
                    } else {
                        $order          = XyyhOrder::where('order_sn', $order_no)
                            ->select('id', 'order_sn', 'order_id', 'update_time')
                            ->first();
                        $this->order_id = $order->order_id;
                        if ($this->type == 1) {//账期订单
                            $this->order_info = ZqOrder::where('zq_id', $this->order_id)
                                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id')
                                ->first();
                        } elseif ($this->type == 2) {//账期订单
                            $this->order_info = ZqOrderYwy::where('zq_id', $this->order_id)
                                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id')
                                ->first();
                        } elseif ($this->type == 3) {//尚医账期订单
                            $this->order_info = ZqOrderSy::where('zq_id', $this->order_id)
                                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id')
                                ->first();
                        } else {
                            $this->order_info = OrderInfo::where('order_id', $this->order_id)
                                ->select('order_id', 'order_amount', 'order_sn', 'user_id')
                                ->first();
                        }
                        $this->order_info->online_order = $order;
                    }
                    if ($order_amount == $this->order_info->order_amount) {
                        $this->search_xyyh();
                        die;
                        $this->order_info->pay_amount = $order_amount;
                        $this->pay_time               = strtotime($request->input('pay_time', time()));
                        $this->payResult();
                        $sn = $request->input('order_no');
                        XyyhOrder::where('order_id', $this->order_info->order_id)->where('check_num', $this->type)
                            ->where('order_sn', $sn)->update([
                                'is_pay' => 1
                            ]);
                    }

                } else if ("NOTIFY_ACQUIRE_FAIL" === $request->input('event')) {    // 支付失败通知

                    // 支付失败业务逻辑处理

                } else if ("NOTIFY_REFUND_SUCCESS" === $request->input('event')) {    // 退款成功通知

                    // 退款成功业务逻辑处理

                } else if ("NOTIFY_AUTH_SUCCESS" === $request->input('event')) {        // 快捷支付认证成功通知

                    // 认证成功业务逻辑处理
                    //file_put_contents("notify_log.txt", "[后台通知]认证成功@".date('YmdHis')."\r\n", FILE_APPEND);
                }
            }

        } else {                    // 验签失败

            // 不应当进行业务逻辑处理，即把该通知当无效的处理
            // 商户可以在此记录日志等
            echo "验签失败";
        }

    }

    public function response_abc(Request $request)
    {
        //1、取得MSG参数，并利用此参数值生成验证结果对象
        $tResult        = new Result();
        $tResponse      = $tResult->init($request->input('MSG'));
        $url            = route('index');
        $this->type     = $request->input('type', 0);
        $this->bank     = 7;
        $this->pay_name = '农行在线支付';
        if ($tResponse->isSuccess()) {
            $order          = OnlinePay::where('order_sn', $tResponse->getValue('OrderNo'))
                ->select('id', 'order_sn', 'order_id', 'update_time')
                ->first();
            $this->order_id = $order->order_id;
            if ($this->type == 1) {//账期订单
                $this->order_info = ZqOrder::where('zq_id', $this->order_id)
                    ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id')
                    ->first();
            } elseif ($this->type == 2) {//账期订单
                $this->order_info = ZqOrderYwy::where('zq_id', $this->order_id)
                    ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id')
                    ->first();
            } elseif ($this->type == 3) {//尚医账期订单
                $this->order_info = ZqOrderSy::where('zq_id', $this->order_id)
                    ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id')
                    ->first();
            } else {
                $this->order_info = OrderInfo::where('order_id', $this->order_id)
                    ->select('order_id', 'order_amount', 'order_sn', 'user_id')
                    ->first();
            }
            $this->order_info->online_order = $order;
            if ($tResponse->getValue("Amount") == $this->order_info->order_amount) {
                $this->qid                    = $tResponse->getValue('OrderNo');
                $this->pay_time               = time();
                $this->order_info->pay_amount = $tResponse->getValue("Amount");
                $this->payResult();
            }
            if ($request->input('sj') == 1) {
                $url = 'http://app.hezongyy.com/index.php?m=default&c=user&a=index';
            } else {
                if ($this->type == 1 || $this->type == 2) {
                    $url = route('user.zq_order_info', ['id' => $order->order_id]);
                } elseif ($this->type == 3) {
                    $url = route('user.zq_order_info_sy', ['id' => $order->order_id]);
                } else {
                    $url = route('user.orderInfo', ['id' => $order->order_id]);
                }
            }
        }
        return redirect()->to($url);
    }

    /**
     * 主动查询
     */
    public function toSearch(Request $request)
    {
        $this->order_id = $request->input('id');
        $this->type     = $request->input('type', 0);
        if ($this->type == 1) {//账期订单
            $this->order_info = ZqOrder::where('zq_id', $this->order_id)
                ->select('zq_id as order_id', 'order_amount', 'order_sn')
                ->first();
        } elseif ($this->type == 2) {//账期订单
            $this->order_info = ZqOrderYwy::where('zq_id', $this->order_id)
                ->select('zq_id as order_id', 'order_amount', 'order_sn')
                ->first();
        } elseif ($this->type == 3) {//尚医账期订单
            $this->order_info = ZqOrderSy::where('zq_id', $this->order_id)
                ->select('zq_id as order_id', 'order_amount', 'order_sn')
                ->first();
        } else {
            $this->order_info = OrderInfo::where('order_id', $this->order_id)
                ->select('order_id', 'order_amount', 'order_sn')
                ->first();
        }
        if (empty($this->order_info)) {
            return ['error' => 1];
        }
        $this->get_order_info();
        if (empty($this->order_info->online_order)) {
            return ['error' => 1];
        }
        $result = [];
        if (($this->order_info->pay_status == 2 && $this->order_info->order_amount == 0)) {
            $result['error'] = 0;
        } else {
            $search = $this->search();
            if ($search == 1) {
                $result['error'] = 0;
            } else {
                $result['error'] = 1;
            }
        }
        return $result;
    }


    /**
     * 查询支付结果 兴业银行
     */
    private function search_xyyh($order_date = '')
    {
        // 当第二个参数$order_date省略时，为查询当天订单
        if (empty($order_date)) {
            $ex1_6result = $this->epay->epQuery($this->order_info->online_order->order_sn);                    //$order_no为调用epPay(...)时的订单号
        } else {
            $ex1_6result = $this->epay->epQuery($this->order_info->online_order->order_sn, $order_date);        //$order_date为发起交易的日期
        }
        $result                   = json_decode($ex1_6result);
        $this->order_info->result = $result;
        if (isset($result->trans_status) && $result->trans_status == 1) {//支付成功
            $this->qid = $this->order_info->result->sno;
            if ($result->order_amount == $this->order_info->order_amount) {
                $this->pay_time               = strtotime($result->pay_time);
                $this->order_info->pay_amount = $result->order_amount;
                $this->payResult();
                $sn = $this->order_info->online_order->order_sn;
                XyyhOrder::where('order_id', $this->order_info->order_id)->where('check_num', $this->type)
                    ->where('order_sn', $sn)->update([
                        'is_pay' => 1
                    ]);
            }
            return 1;
        }
        return 2;
    }

    /**
     * 查询支付结果 农业银行
     * @return int
     */
    private function search_abc()
    {
        $orderSn                          = $this->order_info->online_order->order_sn;
        $tRequest                         = new QueryOrderRequest();
        $tRequest->request["PayTypeID"]   = 'ImmediatePay'; //设定交易类型
        $tRequest->request["OrderNo"]     = $orderSn; //设定订单编号 （必要信息）
        $tRequest->request["QueryDetail"] = 'false'; //设定查询方式

        $tResponse = $tRequest->postRequest();
        //3、支付请求提交成功，返回结果信息
        if ($tResponse->isSuccess()) {
            $orderInfo = $tResponse->GetValue("Order");
            if ($orderInfo == null) {
                return 0;
            } else {
                //1、还原经过base64编码的信息
                $orderDetail = base64_decode($orderInfo);
                $orderDetail = iconv("GB2312", "UTF-8", $orderDetail);
                $detail      = new Json($orderDetail);
                if ((abs($detail->GetValue("OrderAmount") - $this->order_info->order_amount) < 0.000001) && $detail->GetValue("Status") == '04') {
                    $this->qid                    = $detail->getValue('OrderNo');
                    $this->pay_time               = time();
                    $this->order_info->pay_amount = $detail->GetValue("OrderAmount");
                    $this->payResult();
                    return 1;
                } else {
                    return 2;
                }
            }
        } else {
            return $tResponse->getReturnCode();
        }
    }

    /**
     * 修改订单的支付状态
     *
     * @access  public
     * @param   string $log_id 支付编号
     * @param   integer $pay_status 状态
     * @param   string $note 备注
     * @return  void
     */
    private function payResult()
    {
        $qid = $this->qid;
        if ($this->type == 1) {
            $order_data = ZqOrder::where('zq_id', $this->order_info->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        } elseif ($this->type == 2) {
            $order_data = ZqOrderYwy::where('zq_id', $this->order_info->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        } elseif ($this->type == 3) {
            $order_data = ZqOrderSy::where('zq_id', $this->order_info->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        } elseif ($this->type == 4) {
            $order_data = CzOrder::where('order_id', $this->order_info->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        } else {
            $order_data = OrderInfo::where('order_id', $this->order_info->order_id)->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                ->first();
        }
        $user = User::find($order_data->user_id);
        $note = $this->pay_name . ':' . $qid;
        if ($order_data) {
            $order_data->order_status = 1;
            $order_data->pay_status   = 2;
            $order_data->pay_time     = $this->pay_time;
            $order_data->qid          = $qid;
            $order_data->money_paid   = $this->order_info->pay_amount;
            $order_data->order_amount = 0;
            $order_data->pay_id       = $this->bank;
            $order_data->o_paid       = $this->order_info->pay_amount;
            $order_data->trace_time   = $this->pay_time;
            $order_data->pay_name     = $this->pay_name;
            DB::transaction(function () use ($order_data, $note, $user, $qid) {
//                $up_arr = [
//                    'order_status'   => 1,
//                    'pay_status'     => 2,
//                    'pay_time'       => time(),
//                    'qid'            => $qid,
//                    'money_paid'     => $order_data->order_amount,
//                    'order_amount'   => 0,
//                    'pay_id'         => $this->pay_name,
//                ];
//                $table = "zq_order";
//                $id = "zq_id";
//                if($this->type==0){
//                    $up_arr['o_paid']     = $order_data->order_amount;
//                    $up_arr['trace_time'] = time();
//                    $up_arr['pay_name']   = time();
//                    $table                = "order_info";
//                    $id                   = 'order_id';
//                }
//                DB::table($table)->where($id,$this->order_info->order_id)->where('pay_status','!=',2)->update($up_arr);
                $order_data->save();
                if ($this->type == 1) {//账期订单
                    order_action_zq($order_data, $note, $user->user_name);
                    log_zq_change($user, 0, 0 - $order_data->money_paid, $order_data->order_sn . $note);
                    DB::table('order_info')
                        ->where('zq_id', $order_data->zq_id)
                        ->where('order_status', 1)
                        ->where('is_zq', 1)
                        ->where('user_id', $user->user_id)
                        ->where('pay_status', '!=', 2)->update([
                            'order_status' => 1,
                            'pay_status'   => 2,
                            'pay_time'     => time(),
                            'money_paid'   => DB::raw('order_amount'),
                            'order_amount' => 0,
                        ]);
                    //dd($order_data,$note,$user->user_name);
                } elseif ($this->type == 2) {//账期订单
                    order_action_zq_ywy($order_data, $note, $user->user_name);
                    log_zq_change_ywy($user, 0, 0 - $order_data->money_paid, $order_data->order_sn . $note);
                    DB::table('order_info')
                        ->where('zq_id', $order_data->zq_id)
                        ->where('order_status', 1)
                        ->where('is_zq', 2)
                        ->where('user_id', $user->user_id)
                        ->where('pay_status', '!=', 2)->update([
                            'order_status' => 1,
                            'pay_status'   => 2,
                            'pay_time'     => time(),
                            'money_paid'   => DB::raw('order_amount'),
                            'order_amount' => 0,
                        ]);
                    //dd($order_data,$note,$user->user_name);
                } elseif ($this->type == 3) {//尚医账期订单
                    order_action_zq_sy($order_data, $note, $user->user_name);
                    log_zq_change_sy($user, 0, 0 - $order_data->money_paid, $order_data->order_sn . $note);
                    DB::table('order_info')
                        ->where('zq_id', $order_data->zq_id)
                        ->where('order_status', 1)
                        ->where('is_zq', 3)
                        ->where('user_id', $user->user_id)
                        ->where('pay_status', '!=', 2)->update([
                            'order_status' => 1,
                            'pay_status'   => 2,
                            'pay_time'     => time(),
                            'money_paid'   => DB::raw('order_amount'),
                            'order_amount' => 0,
                        ]);
                    //dd($order_data,$note,$user->user_name);
                } elseif ($this->type == 4) {//充值订单
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
//                    XyyhOrder::where('check_num',4)->where('order_id',$order_data->order_id)->delete();
                } else {
                    order_action($order_data, $note, $user->user_name);
                }
            });
        }
    }

    /**
     * 分配查询
     */
    private function search()
    {
        switch ($this->bank) {
            case 5:
                return $this->search_abc();
                break;
            case 6:
                return $this->search_xyyh();
                break;
            default :
                return $this->search_xyyh();
        }
    }

    private function to_pay()
    {
        switch ($this->bank) {
            case 5:
                $tRequest                           = new PaymentRequest();
                $tRequest->order["PayTypeID"]       = "ImmediatePay"; //设定交易类型
                $tRequest->order["OrderNo"]         = $this->order_info->online_order->order_sn; //设定订单编号
                $tRequest->order["ExpiredDate"]     = 30; //设定订单保存时间
                $tRequest->order["OrderAmount"]     = $this->order_info->order_amount; //设定交易金额
                $tRequest->order["Fee"]             = 0; //设定手续费金额
                $tRequest->order["CurrencyCode"]    = '156'; //设定交易币种
                $tRequest->order["ReceiverAddress"] = ''; //收货地址
                $tRequest->order["InstallmentMark"] = '0'; //分期标识
                $installmentMerk                    = '0';
                $paytypeID                          = 'ImmediatePay';
                if (strcmp($installmentMerk, "1") == 0 && strcmp($paytypeID, "DividedPay") == 0) {
                    $tRequest->order["InstallmentCode"] = ($_POST['InstallmentCode']); //设定分期代码
                    $tRequest->order["InstallmentNum"]  = ($_POST['InstallmentNum']); //设定分期期数
                }
                $tRequest->order["BuyIP"]            = ''; //IP
                $tRequest->order["OrderDesc"]        = $this->order_info->order_sn; //设定订单说明
                $tRequest->order["OrderURL"]         = ''; //设定订单地址
                $tRequest->order["OrderDate"]        = date('Y/m/d'); //设定订单日期 （必要信息 - YYYY/MM/DD）
                $tRequest->order["OrderTime"]        = date('H:i:s'); //设定订单时间 （必要信息 - HH:MM:SS）
                $tRequest->order["orderTimeoutDate"] = ""; //设定订单有效期
                $tRequest->order["CommodityType"]    = '0202'; //设置商品种类

//2、订单明细

                $orderitem                            = array();
                $orderitem["SubMerName"]              = $this->order_info->consignee; //设定二级商户名称 用收货人代替
                $orderitem["SubMerId"]                = $this->order_info->user_id; //设定二级商户代码
                $orderitem["SubMerMCC"]               = ""; //设定二级商户MCC码
                $orderitem["SubMerchantRemarks"]      = ""; //二级商户备注项
                $orderitem["ProductID"]               = $this->order_info->order_id; //商品代码，预留字段 用order_id 代替
                $orderitem["ProductName"]             = "网上订单{$this->order_info->order_sn}"; //商品名称
                $orderitem["UnitPrice"]               = $this->order_info->order_amount; //商品总价
                $orderitem["Qty"]                     = "1"; //商品数量
                $orderitem["ProductRemarks"]          = "商城订单编号{$this->order_info->order_sn}"; //商品备注项
                $orderitem["ProductType"]             = ""; //商品类型
                $orderitem["ProductDiscount"]         = "1"; //商品折扣
                $orderitem["ProductExpiredDate"]      = "10"; //商品有效期
                $tRequest->orderitems[0]              = $orderitem;
                $tRequest->request["PaymentType"]     = 'A'; //设定支付类型
                $tRequest->request["PaymentLinkType"] = '1'; //设定支付接入方式
//        if ($_POST['PaymentType'] === "6" && $_POST['PaymentLinkType'] === "2") {
//            $tRequest->request["UnionPayLinkType"] = ($_POST['UnionPayLinkType']); //当支付类型为6，支付接入方式为2的条件满足时，需要设置银联跨行移动支付接入方式
//        }
                // $tRequest->request["ReceiveAccount"] = ($_POST['ReceiveAccount']); //设定收款方账号
                //$tRequest->request["ReceiveAccName"] = ($_POST['ReceiveAccName']); //设定收款方户名
                $tRequest->request["NotifyType"]       = '1'; //设定通知方式
                $tRequest->request["ResultNotifyURL"]  = route('abc.result', ['type' => $this->type]); //设定通知URL地址
                $tRequest->request["MerchantRemarks"]  = "商城订单编号{$this->order_info->order_sn}"; //设定附言
                $tRequest->request["IsBreakAccount"]   = '0'; //设定交易是否分账
                $tRequest->request["SplitAccTemplate"] = ''; //分账模版编号
//print_r($tRequest);die;
                $tResponse = $tRequest->postRequest();
                //dd($order);
                if ($tResponse->isSuccess()) {
                    $PaymentURL = $tResponse->GetValue("PaymentURL");
                    return redirect()->to($PaymentURL);
                } else {
                    return redirect()->route('user.index');
                };
                break;
            case 6:
                $order_no     = $this->order_info->online_order->order_sn;
                $order_amount = $this->order_info->order_amount;
                $order_title  = "合纵医药网订单" . $this->order_info->order_sn;                                //订单标题
                $order_desc   = "合纵医药网订单";            //订单详情
                $remote_ip    = $this->ip;    // 客户端IP地址，可以使用自己实现的方法

                // 【重要】出于安全考虑，在调用函数前，需要对上面的参数进行防护过滤等操作
                return $this->epay->epAuthPay($order_no, $order_amount, $order_title, $order_desc, $remote_ip);
                break;
            default :
                $order_no     = $this->order_info->online_order->order_sn;
                $order_amount = $this->order_info->order_amount;
                $order_title  = "合纵医药网订单" . $this->order_info->order_sn;                                //订单标题
                $order_desc   = "合纵医药网订单";            //订单详情
                $remote_ip    = $this->ip;    // 客户端IP地址，可以使用自己实现的方法

                // 【重要】出于安全考虑，在调用函数前，需要对上面的参数进行防护过滤等操作
                return $this->epay->epAuthPay($order_no, $order_amount, $order_title, $order_desc, $remote_ip);
        }
    }

    /**
     * 主动查询(后台发起的)
     */
    public function ht_search(Request $request)
    {
        $order_sn   = $request->input('order_sn');
        $this->type = $request->input('type', 0);
        $this->bank = $request->input('bank', 6);
        if ($this->type == 1) {//账期订单
            $this->order_info = ZqOrder::where('order_sn', $order_sn)
                ->select('zq_id as order_id', 'order_amount', 'order_sn')
                ->first();
        } elseif ($this->type == 2) {//账期订单
            $this->order_info = ZqOrderYwy::where('order_sn', $order_sn)
                ->select('zq_id as order_id', 'order_amount', 'order_sn')
                ->first();
        } elseif ($this->type == 3) {//尚医账期订单
            $this->order_info = ZqOrderSy::where('order_sn', $order_sn)
                ->select('zq_id as order_id', 'order_amount', 'order_sn')
                ->first();
        } else {
            $this->order_info = OrderInfo::where('order_sn', $order_sn)
                ->select('order_id', 'order_amount', 'order_sn')
                ->first();
        }
        if (empty($this->order_info)) {
            return ['error' => 1, 'message' => '订单不存在'];
        }
        $this->order_id = $this->order_info->order_id;
        $this->get_order_info();
        if (empty($this->order_info->online_order)) {
            return ['error' => 1, 'message' => '订单支付信息不存在'];
        }
        $result = [];
        if (($this->order_info->pay_status == 2 && $this->order_info->order_amount == 0)) {
            $result['error']   = 0;
            $result['message'] = '订单已支付';
        } else {
            $search = $this->search();
            if ($search == 1) {
                $result['error']   = 0;
                $result['message'] = '订单查询成功!(若订单状态未改变,说明支付金额对不上)';
            } else {
                $result['error']   = 1;
                $result['message'] = '订单查询失败';
            }
        }
        return $result;
    }

    public function duizhang(Request $request)
    {
        $trans_date = $request->input('date', date("Ymd", strtotime('-1 day')));        //交易日期，格式：yyyyMMdd
        $rcpt_type  = "0";            //$rcpt_type 回单类型：0-快捷入账回单；1-快捷出账回单；2-快捷手续费回单；3-网关支付入账回单；4-网关支付出账回单；5-网关支付手续费回单；6-代付入账回单；7-代付出账回单；8-代付手续费回单
        $file       = storage_path("app/duizhang/" . $trans_date . '.zip');
        if (!file_exists($file)) {
// $order_date 指定需要下载的对账文件的日期，最后一个参数为保存的文件名
            $ex4_1result = $this->epay->dlSettleFile($rcpt_type, $trans_date, $file);
        }
        //dd($ex4_1result);
        $zip = zip_open($file);
        $arr = [];
        if ($zip) {

            while ($zip_entry = zip_read($zip)) {
//                echo "Name: " . zip_entry_name($zip_entry) . "n";
//                echo "Actual Filesize: " . zip_entry_filesize($zip_entry) . "n";
//                echo "Compressed Size: " . zip_entry_compressedsize($zip_entry) . "n";
//                echo "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "n";

                if (zip_entry_open($zip, $zip_entry, "r")) {
                    $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    $arr = explode("\r\n", $buf);
                    zip_entry_close($zip_entry);
                }
            }

            zip_close($zip);

        }
        $old_arr = $arr;
        if (count($arr) > 1) {
            unset($arr[0]);
        }
        $new_arr = [];
        foreach ($arr as $v) {
            $v = explode('|', $v);
            if (!empty($v[0])) {
                $new_arr[] = $v[4];
                if (strpos($v[4], 'zq') !== false) {
                    $xyyh_order = DB::table('xyyh_order as xo')
                        ->leftJoin('zq_order as oi', 'xo.order_id', '=', 'oi.zq_id')
                        ->where('xo.is_pay', '!=', 2)
                        ->where('xo.order_sn', $v[4])
                        ->select('xo.order_id', 'oi.order_sn', 'oi.qid', 'oi.o_paid', 'xo.id', 'oi.money_paid')
                        ->first();
                    //dd($xyyh_order,$v[4]);
                } else {
                    $xyyh_order = DB::table('xyyh_order as xo')
                        ->leftJoin('order_info as oi', 'xo.order_id', '=', 'oi.order_id')
                        ->where('xo.is_pay', 0)
                        ->where('xo.order_sn', $v[4])
                        ->select('xo.order_id', 'oi.order_sn', 'oi.qid', 'oi.o_paid', 'xo.id', 'oi.money_paid')
                        ->first();
                }
                if ($xyyh_order) {
                    $update = [
                        'is_pay' => 1,
                    ];
                    if ($xyyh_order->qid == $v[2] && $xyyh_order->o_paid == $v[5]) {
                        $update['is_pay'] = 2;
                    }
                    XyyhOrder::where('id', $xyyh_order->id)->update($update);
                }
            }
        }

        return $old_arr;
    }


    public function new_to_pay($order_info)
    {
        $order_no                  = $order_info->order_sn . '_' . rand(100, 999);
        $online_order              = new XyyhOrder();
        $online_order->order_id    = $order_info->order_id;
        $online_order->update_time = time();
        $online_order->order_sn    = $order_no;
        $online_order->check_num   = 4;
        $online_order->save();
        $order_amount = $order_info->order_amount;
        $order_title  = "合纵医药网订单" . $order_info->order_sn;                                //订单标题
        $order_desc   = "合纵医药网订单";            //订单详情
        $remote_ip    = $this->ip;    // 客户端IP地址，可以使用自己实现的方法

        // 【重要】出于安全考虑，在调用函数前，需要对上面的参数进行防护过滤等操作
        exit($this->epay->epAuthPay($order_no, $order_amount, $order_title, $order_desc, $remote_ip));
    }

    public function new_ht_search(Request $request)
    {
        $order_sn   = $request->input('order_sn');
        $this->type = $request->input('type', 0);
        $this->bank = $request->input('bank', 6);
        if ($this->type == 1) {//账期订单
            $this->order_info = ZqOrder::where('order_sn', $order_sn)
                ->select('zq_id as order_id', 'order_amount', 'order_sn')
                ->first();
        } elseif ($this->type == 2) {//账期订单
            $this->order_info = ZqOrderYwy::where('order_sn', $order_sn)
                ->select('zq_id as order_id', 'order_amount', 'order_sn')
                ->first();
        } elseif ($this->type == 3) {//尚医账期订单
            $this->order_info = ZqOrderSy::where('order_sn', $order_sn)
                ->select('zq_id as order_id', 'order_amount', 'order_sn')
                ->first();
        } elseif ($this->type == 4) {//充值订单
            $this->order_info = CzOrder::where('order_sn', $order_sn)
                ->select('order_id', 'order_amount', 'order_sn')
                ->first();
        } else {
            $this->order_info = OrderInfo::where('order_sn', $order_sn)
                ->select('order_id', 'order_amount', 'order_sn')
                ->first();
        }
        if (empty($this->order_info)) {
            return ['error' => 1, 'message' => '订单不存在'];
        }
        $this->order_id = $this->order_info->order_id;
        $this->get_order_info();
        if (empty($this->order_info->online_order)) {
            return ['error' => 1, 'message' => '订单支付信息不存在'];
        }
        $result = [];
        if (($this->order_info->pay_status == 2 && $this->order_info->order_amount == 0)) {
            $result['error']   = 0;
            $result['message'] = '订单已支付';
        } else {
            $online_order = XyyhOrder::where('order_id', $this->order_id)->where('check_num', $this->type)
                ->select('id', 'order_sn', 'order_id', 'update_time')->get('order_sn');
            $search       = 0;
            foreach ($online_order as $v) {
                $this->order_info->online_order = $v;
                $search                         = $this->search();
                if ($search == 1) {
                    break;
                }
            }
            if ($search == 1) {
                $result['error']   = 0;
                $result['message'] = '订单查询成功!(若订单状态未改变,说明支付金额对不上)';
            } else {
                $result['error']   = 1;
                $result['message'] = '订单查询失败';
            }
        }
        return $result;
    }
}