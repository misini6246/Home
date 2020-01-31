<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/10/16
 * Time: 10:48
 */

namespace App\Http\Controllers\Pay;

use App\Common\Payfun;
use App\Common\WxPay\NativePay;
use App\Common\WxPay\PayNotifyCallBack;
use App\Common\WxPay\WxPayConfig;
use App\Common\WxPay\WxPayUnifiedOrder;
use App\Http\Controllers\Controller;
use App\OrderGoods;
use App\OrderInfo;
use App\WeixinOrder;
use App\ZqOrder;
use App\ZqOrderSy;
use App\ZqOrderYwy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WxPayController extends Controller
{
    use Payfun;
    private $type;
    private $order;
    private $pay_id;
    private $pay_name;
    private $notify_url;
    private $model;

    public function __construct(Request $request, WeixinOrder $order)
    {
        $this->type = intval($request->input('type', 0));
        $this->model = $order;
        $this->pay_id = 7;
        $this->pay_name = '微信扫码支付';
        $this->notify_url = route('wechat.notify');
    }

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
            $input = new WxPayUnifiedOrder();
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
            $input->SetBody($this->order->order_sn);
            $input->SetAttach($type);
            $input->SetOut_trade_no($this->order->online_order->order_sn);
            $input->SetTotal_fee($this->order->order_amount * 100);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 7200));
            $input->SetNotify_url($this->notify_url);
            $input->SetTrade_type("NATIVE");
            $input->SetProduct_id($this->order->order_sn);
            $notify = new NativePay();
            $result = $notify->GetPayUrl($input);
            $msg = response()->view('common.saoma', ['name' => '微信', 'img' => '/qrcode.php?data=' . urlencode($result["code_url"])]);
            ajax_return($msg->getContent());
        }
        ajax_return('错误！', 1);
    }

    public function notify(Request $request)
    {
        $config = new WxPayConfig();
        $notify = new PayNotifyCallBack();
        $notify->Handle($config, false);
    }
}