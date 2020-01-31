<?php

namespace App\Http\Controllers\Pay;

use App\Common\Alipay\ClientResponseHandler;
use App\Common\Alipay\Config;
use App\Common\Alipay\PayHttpClient;
use App\Common\Alipay\RequestHandler;
use App\Common\Alipay\Utils;
use App\Common\Payfun;
use App\Http\Controllers\Controller;
use App\Models\Pay\AlipayOrder;
use App\OrderGoods;
use App\OrderInfo;
use App\ZqOrder;
use App\ZqOrderSy;
use App\ZqOrderYwy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlipayController extends Controller
{
    use Payfun;

    private $resHandler = null;
    private $reqHandler = null;
    private $pay = null;
    private $cfg = null;
    private $model;
    private $type;
    private $order;
    private $pay_id;
    private $pay_name;
    private $notify_url;

    public function __construct(Request $request, AlipayOrder $alipayOrder)
    {
        $this->Request();
        $this->model = $alipayOrder;
        $this->pay_id = 9;
        $this->pay_name = '支付宝扫码支付';
        $this->notify_url = route('alipay.notify');
    }

    public function Request()
    {
        $this->resHandler = new ClientResponseHandler();
        $this->reqHandler = new RequestHandler();
        $this->pay = new PayHttpClient();
        $this->cfg = new Config();

        $this->reqHandler->setGateUrl($this->cfg->C('url'));
        $this->reqHandler->setKey($this->cfg->C('key'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->type = intval($request->input('type', 0));
        $order_id = intval($request->input('id', 0));
        $user = auth()->user();
        $method = trim($request->input('method', 'submitOrderInfo'));
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
                ajax_return('货到付款订单不能在线支付', 1);
            }
            $mx_amount = OrderGoods::where('order_id', $order_id)->sum(DB::raw('goods_number*goods_price'));
            if (abs($mx_amount - $this->order->goods_amount) > 0.01) {
                ajax_return('订单总金额有误', 1);
            }
        }
        if (!$this->order) {
            ajax_return('订单不存在', 1);
        }
        if ($this->order->order_status == 2) {
            ajax_return('订单已取消', 1);
        }
        if ($this->order->pay_status == 2) {
            ajax_return('订单已支付', 2);
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
        if ($this->order->online_order->save()) {
            $this->Request();
            $arr = [
                'attach' => $this->order->order_sn . ' ' . $user->msn,
                'body' => $this->order->order_sn,
                'mch_create_ip' => $request->ip(),
                'method' => $method,
                'out_trade_no' => $this->order->online_order->order_sn,
                'time_expire' => '',
                'time_start' => '',
                'total_fee' => $this->order->order_amount * 100,
            ];
            $this->reqHandler->setReqParams($arr, ['method']);
            //$this->reqHandler->setParameter('service','pay.weixin.native');//接口类型：pay.weixin.native  表示微信扫码
            $this->reqHandler->setParameter('service', 'pay.alipay.native');//接口类型：pay.alipay.native  表示支付宝扫码
            $this->reqHandler->setParameter('mch_id', $this->cfg->C('mchId'));//必填项，商户号，由威富通分配
            $this->reqHandler->setParameter('version', $this->cfg->C('version'));



            $this->reqHandler->setParameter('time_start', date('YmdHis',time()));
            $this->reqHandler->setParameter('time_expire', date('YmdHis',time()+120));
            //通知地址，必填项，接收威富通通知的URL，需给绝对路径，255字符内格式如:http://wap.tenpay.com/tenpay.asp
            //$notify_url = 'http://'.$_SERVER['HTTP_HOST'];
            //$this->reqHandler->setParameter('notify_url',$notify_url.'/payInterface/request.php?method=callback');
            $this->reqHandler->setParameter('notify_url', $this->notify_url . '?type=' . $this->type);
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
                        $msg = response()->view('common.saoma', ['name' => '支付宝', 'img' => $this->resHandler->getParameter('code_img_url')]);
                        ajax_return($msg->getContent());
                    } else {
                        ajax_return($this->resHandler->getParameter('err_msg'), 1);
                    }
                }
                ajax_return($this->resHandler->getParameter('err_msg'), 1);
            } else {
                ajax_return($this->resHandler->getParameter('err_msg'), 1);
            }
        }
    }

    public function notify(Request $request)
    {
        return $this->notify_fun($request);
    }
}
