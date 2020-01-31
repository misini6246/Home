<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/23
 * Time: 16:06
 */

namespace Jai\Contact\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\CzOrder;
use App\OrderInfo;
use App\User;
use App\WeixinOrder;
use App\YouHuiCate;
use App\YouHuiQ;
use App\ZqOrder;
use App\ZqOrderSy;
use App\ZqOrderYwy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jai\Contact\Http\Controllers\weixin\Utils;
use Jai\Contact\Http\Controllers\weixin\RequestHandler;
use Jai\Contact\Http\Controllers\weixin\ClientResponseHandler;
use Jai\Contact\Http\Controllers\weixin\PayHttpClient;
use Maatwebsite\Excel\Facades\Excel;


class WeixinController extends Controller
{

    use PayType;
    //$url = 'http://192.168.1.185:9000/pay/gateway';

    private $resHandler = null;
    private $reqHandler = null;
    private $pay = null;
    private $cfg = null;
    private $order_id;
    private $order_info;
    private $method;
    private $type;
    private $bank;

    public function __construct(Request $request)
    {
        $this->Request();
        $this->order_id = intval($request->input('id', 0));
        $this->method   = $request->input('method', 'submitOrderInfo');
        $this->bank     = 7;
    }

    public function Request()
    {
        $this->resHandler = new ClientResponseHandler();
        $this->reqHandler = new RequestHandler();
        $this->pay        = new PayHttpClient();
        $this->cfg        = config('contact.weixin');


        $this->reqHandler->setGateUrl($this->cfg['url']);
        $this->reqHandler->setKey($this->cfg['key']);
    }

    public function pay(Request $request)
    {
        $status = $this->get_order($request);
        if ($this->bank == $status) {
            return array('status' => 200, 'msg' => '查询订单成功！', 'data' => $this->resHandler->getAllParameters());
        }
        if ($this->order_info->online_order->save()) {
            //dd($this->order_info->online_order);
            $this->Request();
            $arr = [
                'attach'        => $this->order_info->order_sn,
                'body'          => '商城订单 ' . $this->order_info->order_sn,
                'mch_create_ip' => $request->ip(),
                'method'        => $this->method,
                'out_trade_no'  => $this->order_info->online_order->order_sn,
                'time_expire'   => '',
                'time_start'    => '',
                'total_fee'     => $this->order_info->order_amount * 100,
            ];
            $this->reqHandler->setReqParams($arr, ['method']);
            $this->reqHandler->setParameter('service', 'pay.weixin.native');//接口类型：pay.weixin.native
            $this->reqHandler->setParameter('mch_id', $this->cfg['mchId']);//必填项，商户号，由威富通分配
            $this->reqHandler->setParameter('version', $this->cfg['version']);

            //通知地址，必填项，接收威富通通知的URL，需给绝对路径，255字符内格式如:http://wap.tenpay.com/tenpay.asp
            //$notify_url = 'http://'.$_SERVER['HTTP_HOST'];
            //$this->reqHandler->setParameter('notify_url',$notify_url.'/payInterface/request.php?method=callback');
            $this->reqHandler->setParameter('notify_url', $this->cfg['notify_url'] . '?type=' . $this->type);
            $this->reqHandler->setParameter('nonce_str', mt_rand(time(), time() + rand()));//随机字符串，必填项，不长于 32 位
            $this->reqHandler->createSign();//创建签名

            $data = Utils::toXml($this->reqHandler->getAllParameters());
            //var_dump($data);

            $this->pay->setReqContent($this->reqHandler->getGateURL(), $data);
            if ($this->pay->call()) {
                $this->resHandler->setContent($this->pay->getResContent());
                $this->resHandler->setKey($this->reqHandler->getKey());
                //print_r($this->resHandler);die;
                if ($this->resHandler->isTenpaySign()) {
                    //当返回状态与业务结果都为0时才返回支付二维码，其它结果请查看接口文档
                    if ($this->resHandler->getParameter('status') == 0 && $this->resHandler->getParameter('result_code') == 0) {
                        return array('code_img_url' => $this->resHandler->getParameter('code_img_url'),
                                     'code_url'     => $this->resHandler->getParameter('code_url'),
                                     'code_status'  => $this->resHandler->getParameter('code_status'));
                    } else {
//                        if ($this->resHandler->getParameter('status') == 0 && $this->resHandler->getParameter('err_code') == 'ORDERPAID') {
//                            return $this->search($this->order_info->order_sn);
//                        }
                        //dd($this->resHandler->getAllParameters());
                        return array('status' => 500, 'msg' => 'Error Message:' . $this->resHandler->getParameter('err_msg'));
                    }
                }
                return array('status' => 500, 'msg' => 'Error Message:' . $this->resHandler->getParameter('message'));
            } else {
                return array('status' => 500, 'msg' => 'Error Info:' . $this->pay->getErrInfo());
            }
        }
    }

    public function toSearch(Request $request)
    {
        $status = $this->get_order($request);
        return $status;
    }

    public function response(Request $request)
    {
        $xml = file_get_contents('php://input');
        //$res = Utils::parseXML($xml);
        //log_zq_change(User::find(13960),0,0,1);
        $this->resHandler->setContent($xml);
        //var_dump($this->resHandler->setContent($xml));
        $this->resHandler->setKey($this->cfg['key']);
        if ($this->resHandler->isTenpaySign()) {
            if ($this->resHandler->getParameter('status') == 0 && $this->resHandler->getParameter('result_code') == 0) {
                $order_sn     = $this->resHandler->getParameter('out_trade_no');
                $order_sn1    = $this->resHandler->getParameter('attach');
                $this->type   = $request->input('type', 0);
                $online_order = WeixinOrder::where('order_sn', $order_sn)->select('id', 'order_sn', 'order_id', 'update_time')->first();
                if (!$online_order) {
                    if ($this->type == 1) {//账期订单
                        $this->order_info = ZqOrder::where('order_sn', $order_sn1)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } elseif ($this->type == 3) {//尚医账期订单
                        $this->order_info = ZqOrderSy::where('order_sn', $order_sn1)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } elseif ($this->type == 2) {//账期订单
                        $this->order_info = ZqOrderYwy::where('order_sn', $order_sn1)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } else {
                        $this->order_info = OrderInfo::where('order_sn', $order_sn1)
                            ->select('order_id', 'order_amount', 'order_sn')
                            ->first();
                    }
                    $this->order_id = $this->order_info->order_id;
                } else {
                    $this->order_id = $online_order->order_id;
                    if ($this->type == 1) {//账期订单
                        $this->order_info = ZqOrder::where('zq_id', $online_order->order_id)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } elseif ($this->type == 2) {//账期订单
                        $this->order_info = ZqOrderYwy::where('zq_id', $online_order->order_id)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } elseif ($this->type == 3) {//尚医账期订单
                        $this->order_info = ZqOrderSy::where('zq_id', $online_order->order_id)
                            ->select('zq_id as order_id', 'order_amount', 'order_sn')
                            ->first();
                    } else {
                        $this->order_info = OrderInfo::where('order_id', $online_order->order_id)
                            ->select('order_id', 'order_amount', 'order_sn')
                            ->first();
                    }
                    $this->order_info->online_order = $online_order;
                }
                $res = $this->resHandler->getAllParameters();
                if (abs($this->order_info->order_amount * 100 - $res['total_fee']) < 0.000001) {
                    $this->order_info->pay_amount = $res['total_fee'];
                    $this->payResult();
                    Log::info('后台通知' . $this->order_info->order_sn);
                    return 'success';
                }
            } else {
                return 'failure1';
            }
        } else {
            return 'failure2';
        }
    }


    /**
     * 查询支付结果
     */
    private function search()
    {
        $this->Request();
        $arr = [
            'method'         => 'queryOrder',
            'out_trade_no'   => $this->order_info->online_order->order_sn,
            'transaction_id' => '',
        ];
        $this->reqHandler->setReqParams($arr, array('method'));
        $reqParam = $this->reqHandler->getAllParameters();
        if (empty($reqParam['transaction_id']) && empty($reqParam['out_trade_no'])) {
            echo json_encode(array('status' => 500,
                                   'msg'    => '请输入商户订单号,威富通订单号!'));
            exit();
        }
        $this->reqHandler->setParameter('version', $this->cfg['version']);
        $this->reqHandler->setParameter('service', 'trade.single.query');//接口类型：trade.single.query
        $this->reqHandler->setParameter('mch_id', $this->cfg['mchId']);//必填项，商户号，由威富通分配
        $this->reqHandler->setParameter('nonce_str', mt_rand(time(), time() + rand()));//随机字符串，必填项，不长于 32 位
        $this->reqHandler->createSign();//创建签名
        //print_r($this->reqHandler);die;
        $data = Utils::toXml($this->reqHandler->getAllParameters());

        $this->pay->setReqContent($this->reqHandler->getGateURL(), $data);
        //dd($this->reqHandler);
        if ($this->pay->call()) {
            $this->resHandler->setContent($this->pay->getResContent());
            $this->resHandler->setKey($this->reqHandler->getKey());
            if ($this->resHandler->isTenpaySign()) {
                $res = $this->resHandler->getAllParameters();
                if ($res['status'] == 0 && $res['result_code'] == 0 && $res['trade_state'] == 'SUCCESS') {
                    if (abs($this->order_info->order_amount * 100 - $res['total_fee']) < 0.000001) {
//                        $this->order_info->pay_amount = $res['total_fee'];
//                        $this->payResult();
//                        $sn = trim($this->order_info->online_order->order_sn);
//                        WeixinOrder::where('order_id', $this->order_info->order_id)->where('check_num', $this->type)
//                            ->where('order_sn', $sn)->update([
//                                'is_pay' => 1
//                            ]);
                        Log::info('主动查询' . $this->order_info->order_sn);
                    }
                    return array('status' => 200, 'msg' => '查询订单成功！', 'data' => $res);
                }
            }
        }
        return 2;
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
        sleep(1);
        $qid = $this->resHandler->getParameter('transaction_id');
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
        if ($order_data) {
            $user = User::find($order_data->user_id);
            $time = time();
            $note = "微信扫码支付:" . $qid;
            if ($order_data) {
                $order_data->order_status = 1;
                $order_data->pay_status   = 2;
                $order_data->pay_time     = $time;
                $order_data->qid          = $qid;
                $order_data->money_paid   = $this->order_info->pay_amount / 100;
                $order_data->order_amount = 0;
                $order_data->pay_id       = 7;
                $order_data->o_paid       = $this->order_info->pay_amount / 100;
                $order_data->trace_time   = $this->resHandler->getParameter('time_end') != '' ? strtotime($this->resHandler->getParameter('time_end')) : $time;
                $order_data->pay_name     = '微信扫码支付';
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
                                    'pay_status'   => 2,
                                    'pay_time'     => time(),
                                    'money_paid'   => DB::raw('order_amount'),
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
                                    'pay_status'   => 2,
                                    'pay_time'     => time(),
                                    'money_paid'   => DB::raw('order_amount'),
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
                                    'pay_status'   => 2,
                                    'pay_time'     => time(),
                                    'money_paid'   => DB::raw('order_amount'),
                                    'order_amount' => 0,
                                ]);
                            log_zq_change_sy($user, 0, 0 - $order_data->money_paid, $order_data->order_sn . $note);
                            order_action_zq_sy($order_data, $note, $user->user_name);
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
                        } else {
                            order_action($order_data, $note, $user->user_name);
                        }
                    }
                });
            }
        }
    }

    public function wx_search(Request $request)
    {
        $order_sn   = $request->input('order_sn');
        $this->type = $request->input('type', 0);
        $this->bank = $request->input('bank', 7);
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
        if (($this->order_info->pay_status == 2 && $this->order_info->order_amount == 0)) {
            $result['error']   = 0;
            $result['message'] = '订单已支付';
        } else {
            $status = $this->get_order($request);
            if ($status == 7) {
                $result['error']   = 0;
                $result['message'] = '订单查询成功!(若订单状态未改变,说明支付金额对不上)';
            } else {
                $result['error']   = 1;
                $result['message'] = '订单查询失败';
            }
        }
        return $result;
    }


    /**
     * 微信对账
     */
    public function duizhang(Request $request)
    {
        $trans_date = $request->input('date', date("Ymd", strtotime('-1 day')));        //交易日期，格式：yyyyMMdd
        $file       = storage_path('app/weixindz/' . $trans_date . '.xls');
        Excel::filter('chunk')->load($file)->chunk(150, function ($results) {
            $new_arr = [];
            foreach ($results as $v) {
                if (!empty($v)) {
                    $new_arr[] = $v['_1'];
                    if (strpos($v['_1'], 'zq') !== false) {
                        $weixin_order = DB::table('weixin_order as xo')
                            ->leftJoin('zq_order as oi', 'xo.order_id', '=', 'oi.zq_id')
                            ->where('xo.is_pay', '!=', 2)
                            ->where('xo.order_sn', $v['_1'])
                            ->select('xo.order_id', 'oi.order_sn', 'oi.qid', 'oi.o_paid', 'xo.id', 'oi.money_paid')
                            ->first();
                        //dd($weixin_order,$v[4]);
                    } else {
                        $weixin_order = DB::table('weixin_order as xo')
                            ->leftJoin('order_info as oi', 'xo.order_id', '=', 'oi.order_id')
                            ->where('xo.is_pay', 0)
                            ->where('xo.order_sn', $v['_1'])
                            ->select('xo.order_id', 'oi.order_sn', 'oi.qid', 'oi.o_paid', 'xo.id', 'oi.money_paid')
                            ->first();
                    }
                    if ($weixin_order) {
                        //dd($weixin_order);
                        $update = [
                            'is_pay' => 1,
                        ];
                        if ($weixin_order->o_paid == 0) {
                            $weixin_order->o_paid = $weixin_order->money_paid;
                        }
                        if ($weixin_order->qid == $v['_2'] && $weixin_order->o_paid - $v['_6'] < 0.000001) {
                            $update['is_pay'] = 2;
                        }
                        WeixinOrder::where('id', $weixin_order->id)->update($update);
                    }
                }
            }
        });
    }

    public function get_data(Request $request)
    {
        $trans_date = $request->input('date', date("Ymd", strtotime('-1 day')));        //交易日期，格式：yyyyMMdd
        $skip       = $request->input('skip', 0);
        $take       = $request->input('take', 15);
        $file       = storage_path('app/weixindz/' . $trans_date . '.xls');
        $data       = Excel::load($file, function ($reader) use ($skip, $take) {
        });
        $result     = $data->get();
        $amount     = 0;
        foreach ($result as $v) {
            $amount += $v->_6;
        }
        return array('ls_zje' => $amount, 'data' => $result);

    }

    public function new_pay(Request $request, $order_info)
    {
        $this->Request();
        $arr                       = [
            'attach'        => $order_info->order_sn,
            'body'          => '商城订单 ' . $order_info->order_sn,
            'mch_create_ip' => $request->ip(),
            'method'        => $this->method,
            'out_trade_no'  => $order_info->order_sn . '_' . rand(100, 999),
            'time_expire'   => '',
            'time_start'    => '',
            'total_fee'     => $order_info->order_amount * 100,
        ];
        $this->type                = 4;
        $online_order              = new WeixinOrder();
        $online_order->order_id    = $order_info->order_id;
        $online_order->update_time = time();
        $online_order->order_sn    = $arr['out_trade_no'];
        $online_order->check_num   = $this->type;
        $online_order->save();
        $this->reqHandler->setReqParams($arr, ['method']);
        $this->reqHandler->setParameter('service', 'pay.weixin.native');//接口类型：pay.weixin.native
        $this->reqHandler->setParameter('mch_id', $this->cfg['mchId']);//必填项，商户号，由威富通分配
        $this->reqHandler->setParameter('version', $this->cfg['version']);

        //通知地址，必填项，接收威富通通知的URL，需给绝对路径，255字符内格式如:http://wap.tenpay.com/tenpay.asp
        //$notify_url = 'http://'.$_SERVER['HTTP_HOST'];
        //$this->reqHandler->setParameter('notify_url',$notify_url.'/payInterface/request.php?method=callback');

        $this->reqHandler->setParameter('notify_url', route('weixin.new_response', ['type' => $this->type]));
        $this->reqHandler->setParameter('nonce_str', mt_rand(time(), time() + rand()));//随机字符串，必填项，不长于 32 位
        $this->reqHandler->createSign();//创建签名

        $data = Utils::toXml($this->reqHandler->getAllParameters());
        //var_dump($data);

        $this->pay->setReqContent($this->reqHandler->getGateURL(), $data);
        if ($this->pay->call()) {
            $this->resHandler->setContent($this->pay->getResContent());
            $this->resHandler->setKey($this->reqHandler->getKey());
            //print_r($this->resHandler);die;
            if ($this->resHandler->isTenpaySign()) {
                //当返回状态与业务结果都为0时才返回支付二维码，其它结果请查看接口文档
                if ($this->resHandler->getParameter('status') == 0 && $this->resHandler->getParameter('result_code') == 0) {
                    return array('code_img_url' => $this->resHandler->getParameter('code_img_url'),
                                 'code_url'     => $this->resHandler->getParameter('code_url'),
                                 'code_status'  => $this->resHandler->getParameter('code_status'));
                } else {
                    return array('status' => 500, 'msg' => 'Error Message:' . $this->resHandler->getParameter('err_msg'));
                }
            }
            return array('status' => 500, 'msg' => 'Error Message:' . $this->resHandler->getParameter('message'));
        }
    }

    public function new_response(Request $request)
    {
        $xml = file_get_contents('php://input');
        //$res = Utils::parseXML($xml);
        //log_zq_change(User::find(13960),0,0,1);
        $this->resHandler->setContent($xml);
        //var_dump($this->resHandler->setContent($xml));
        $this->resHandler->setKey($this->cfg['key']);
        if ($this->resHandler->isTenpaySign()) {
            if ($this->resHandler->getParameter('status') == 0 && $this->resHandler->getParameter('result_code') == 0) {
                $order_sn = $this->resHandler->getParameter('out_trade_no');
                if (strpos($order_sn, '_') !== false) {
                    $order_sn = explode('_', $order_sn)[0];
                }
                $this->type = $request->input('type', 0);
                if ($this->type == 1) {//账期订单
                    $this->order_info = ZqOrder::where('order_sn', $order_sn)
                        ->select('zq_id as order_id', 'order_amount', 'order_sn')
                        ->first();
                } elseif ($this->type == 3) {//尚医账期订单
                    $this->order_info = ZqOrderSy::where('order_sn', $order_sn)
                        ->select('zq_id as order_id', 'order_amount', 'order_sn')
                        ->first();
                } elseif ($this->type == 2) {//账期订单
                    $this->order_info = ZqOrderYwy::where('order_sn', $order_sn)
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
                $this->order_id = $this->order_info->order_id;
                $res            = $this->resHandler->getAllParameters();
                if (abs($this->order_info->order_amount * 100 - $res['total_fee']) < 0.000001) {
                    $this->order_info->pay_amount = $res['total_fee'];
                    $this->payResult();
                    $sn = trim($res['out_trade_no']);
                    WeixinOrder::where('order_id', $this->order_info->order_id)->where('check_num', $this->type)
                        ->where('order_sn', $sn)->update([
                            'is_pay' => 1
                        ]);
                    Log::info('后台通知' . $this->order_info->order_sn);
                    return 'success';
                }
            } else {
                return 'failure1';
            }
        } else {
            return 'failure2';
        }
    }

    public function ht_search(Request $request)
    {
        $order_sn   = $request->input('order_sn');
        $this->type = $request->input('type', 0);
        $this->bank = $request->input('bank', 7);
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
        } elseif ($this->type == 4) {//尚医账期订单
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
        if (($this->order_info->pay_status == 2 || $this->order_info->order_amount == 0)) {
            $result['error']   = 0;
            $result['message'] = '订单已支付';
        } else {
            $online_order = WeixinOrder::where('order_id', $this->order_id)->where('check_num', $this->type)
                ->select('id', 'order_sn', 'order_id', 'update_time')->get('order_sn');
            $status       = 0;
            foreach ($online_order as $v) {
                $this->order_info->online_order = $v;
                $search                         = $this->search();
                if (is_array($search) && $search['status'] == 200) {
                    $status = 7;
                    break;
                }
            }
            if ($status == 7) {
                $result['error']   = 0;
                $result['message'] = '订单查询成功!(若订单状态未改变,说明支付金额对不上)';
            } else {
                $result['error']   = 1;
                $result['message'] = '订单查询失败';
            }
        }
        return $result;
    }


    /**
     * 查询支付修改
     */
   public function wx_xiugai(Request $request)
    {

        $this->Request();
        $arr = [
            'method'         => 'queryOrder',
          //  'out_trade_no'   => $this->order_info->online_order->order_sn,
            'transaction_id' => $request->input('transaction_id'),
        ];
        $this->reqHandler->setReqParams($arr, array('method'));
        $reqParam = $this->reqHandler->getAllParameters();
        if (empty($reqParam['transaction_id']) && empty($reqParam['out_trade_no'])) {
            echo json_encode(array('status' => 500,
                'msg'    => '请输入商户订单号,威富通订单号!'));
            exit();
        }
        $this->reqHandler->setParameter('version', $this->cfg['version']);
        $this->reqHandler->setParameter('service', 'unified.trade.query');//接口类型：trade.single.query
        $this->reqHandler->setParameter('mch_id', $this->cfg['mchId']);//必填项，商户号，由威富通分配
        $this->reqHandler->setParameter('nonce_str', mt_rand(time(), time() + rand()));//随机字符串，必填项，不长于 32 位
        $this->reqHandler->createSign();//创建签名

        $data = Utils::toXml($this->reqHandler->getAllParameters());

        $this->pay->setReqContent($this->reqHandler->getGateURL(), $data);
      //  dd($this->reqHandler);
        if ($this->pay->call()) {
            $this->resHandler->setContent($this->pay->getResContent());
            $this->resHandler->setKey($this->reqHandler->getKey());
            if ($this->resHandler->isTenpaySign()) {
                $res = $this->resHandler->getAllParameters();

                if ($res['status'] == 0 && $res['result_code'] == 0 && $res['trade_state'] == 'SUCCESS') {
                    $qid = $this->resHandler->getParameter('transaction_id');
//                    $order_data = OrderInfo::where('order_id', $request->input('order_id'))->where('pay_status', '!=', 2)->where('order_status', 1)->where('o_paid', 0)
                    $order_data = OrderInfo::where('order_id', $request->input('order_id'))
                    //$order_data = OrderInfo::where('order_id', $request->input('order_id'))->where('pay_status',  2)->where('order_status', 1)
                        ->first();

dd(111);
                   if ($order_data) {
                        $user = User::find($order_data->user_id);
                        $time = time();
                        $note = "微信扫码支付:" . $qid;
                        if ($order_data) {
                            $order_data->order_status = 1;
                            $order_data->pay_status   = 2;
                            $order_data->pay_time     = $time;
                            $order_data->qid          = $qid;
                            $order_data->money_paid   = $res['total_fee'] / 100;
                            $order_data->order_amount = ($order_data->order_amount*100 - $res['total_fee'])/100;
                            $order_data->pay_id       = 7;
                            $order_data->o_paid       = $res['total_fee'] / 100;
                            $order_data->trace_time   = $this->resHandler->getParameter('time_end') != '' ? strtotime($this->resHandler->getParameter('time_end')) : $time;
                            $order_data->pay_name     = '微信扫码支付';
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
                                                'pay_status'   => 2,
                                                'pay_time'     => time(),
                                                'money_paid'   => DB::raw('order_amount'),
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
                                                'pay_status'   => 2,
                                                'pay_time'     => time(),
                                                'money_paid'   => DB::raw('order_amount'),
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
                                                'pay_status'   => 2,
                                                'pay_time'     => time(),
                                                'money_paid'   => DB::raw('order_amount'),
                                                'order_amount' => 0,
                                            ]);
                                        log_zq_change_sy($user, 0, 0 - $order_data->money_paid, $order_data->order_sn . $note);
                                        order_action_zq_sy($order_data, $note, $user->user_name);
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
                                    } else {
                                        order_action($order_data, $note, $user->user_name);
                                    }
                                }
                            });
                        }
                    }
                       // $this->payResult();
//                        $sn = trim($this->order_info->online_order->order_sn);
//                        WeixinOrder::where('order_id', $this->order_info->order_id)->where('check_num', $this->type)
//                            ->where('order_sn', $sn)->update([
//                                'is_pay' => 1
//                            ]);
                      //  Log::info('主动查询' . $this->order_info->order_sn);
                 //   }
                    return array('status' => 200, 'msg' => '查询订单成功！', 'data' => $res);
                }
            }
        }
        return 2;
    }



}