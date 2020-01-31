<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/28
 * Time: 11:01
 */

namespace Jai\Contact\Http\Controllers;


use App\OnlinePay;
use App\OrderInfo;
use App\WeixinOrder;
use App\XyyhOrder;
use App\ZqOrder;
use App\ZqOrderSy;
use App\ZqOrderYwy;

trait PayType
{

    private function get_order_info()
    {
        switch ($this->bank) {
            case 5:
                $this->order_info->online_order = OnlinePay::where('order_id', $this->order_info->order_id)->where('check_num', $this->type)->select('id', 'order_sn', 'order_id', 'update_time')->orderBy('id', 'desc')->first();
                break;
            case 6:
                $this->order_info->online_order = XyyhOrder::where('order_id', $this->order_info->order_id)->where('check_num', $this->type)->select('id', 'order_sn', 'order_id', 'update_time')->orderBy('id', 'desc')->first();
                break;
            case 7:
                $this->order_info->online_order = WeixinOrder::where('order_id', $this->order_info->order_id)->where('check_num', $this->type)->select('id', 'order_sn', 'order_id', 'update_time')->orderBy('id', 'desc')->first();
                break;
            default :
                $this->order_info->online_order = XyyhOrder::where('order_id', $this->order_info->order_id)->where('check_num', $this->type)->select('id', 'order_sn', 'order_id', 'update_time')->orderBy('id', 'desc')->first();
        }
    }

    private function new_order()
    {
        switch ($this->bank) {
            case 5:
                return new OnlinePay();
                break;
            case 6:
                return new XyyhOrder();;
                break;
            case 7:
                return new WeixinOrder();;
                break;
            default :
                return new XyyhOrder();
        }
    }

    /**
     * 获取支付流水号
     */
    private function getOrderSn()
    {

        /*
         * 获取订单号，确保订单号唯一
         */
        $is_order_exist = true; //标识，默认订单号已经存在
        $order_sn       = '';
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
            switch ($this->bank) {
                case 5:
                    $oid = OnlinePay::where('order_sn', $order_sn)->count();
                    break;
                case 6:
                    $oid = XyyhOrder::where('order_sn', $order_sn)->count();
                    break;
                case 7:
                    $oid = WeixinOrder::where('order_sn', $order_sn)->count();
                    break;
                default :
                    $oid = XyyhOrder::where('order_sn', $order_sn)->count();
            }
            if (empty($oid)) {
                //如果计数为0
                $is_order_exist = false;
            }
        } while ($is_order_exist);
        /* 选择一个随机的方案 */
        //mt_srand((double) microtime() * 1000000);
        //return date('YmdHis', time()).mt_rand(10, 99) ;
        return $order_sn;

    }

    private function get_order($request)
    {
        $this->type = $request->input('type', 0);
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
        if (!$this->order_info) {
            return view('message')->with(messageSys('订单不存在请咨询客服', route('user.orderList'), [
                [
                    'url'  => route('user.orderList'),
                    'info' => '返回订单列表',
                ],
            ]));
        }
        $this->get_order_info();
        //dd($this->order_info,$this->bank);
//        if($this->bank==6){
//            $orderSn = $this->order_info->order_sn;
//        }else {
//            $orderSn = $this->getOrderSn();
//        }
        $orderSn = $this->getOrderSn();
        if (!empty($this->order_info->online_order->id)) {
            $search = $this->search();
            if (is_array($search) && $search['status'] == 200) {
                return 7;
            } elseif ($search == 1) {
                if ($this->type == 1 || $this->type == 2) {
                    $url1 = route('user.zq_order_info', ['id' => $this->order_info->order_id]);
                    $url2 = route('user.zq_order');
                } elseif ($this->type == 3) {
                    $url1 = route('user.zq_order_info_sy', ['id' => $this->order_info->order_id]);
                    $url2 = route('user.zq_order_sy');
                } else {
                    $url1 = route('user.orderInfo', ['id' => $this->order_info->order_id]);
                    $url2 = route('user.orderList');
                }
                return view('message')->with(messageSys('订单已支付', $url1, [
                    [
                        'url'  => $url2,
                        'info' => '返回订单列表',
                    ],
                ]));
            }
        }
        $this->order_info->online_order              = $this->new_order();
        $this->order_info->online_order->order_id    = $this->order_info->order_id;
        $this->order_info->online_order->update_time = time();
        $this->order_info->online_order->order_sn    = $orderSn;
        $this->order_info->online_order->check_num   = $this->type;
    }

    /**
     * 支付按钮
     */
    private function button($order, $bank, $type = 0)
    {
        $this->bank = $bank;
        switch ($this->bank) {
            case 5:
                $botton = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="' . route('xyyh.pay') . '" method="get" target="_blank">
                <input class="J_payonline" style="left: 200px;;" value="农业银行" type="submit" onclick="toSearch($(this))" searchUrl="' . route('xyyh.search', ['id' => $order->order_id, 'bank' => 5, 'type' => $type]) . '">
                <input value="' . $order->order_id . '" name="id" type="hidden">
                <input value="5" name="bank" type="hidden">
                <input value="' . $type . '" name="type" type="hidden">
                </form>';
                break;
            case 6:
                $botton = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="' . route('xyyh.pay') . '" method="get" target="_blank">
                <input class="J_payonline" style="left: 200px;;" value="快捷支付" type="submit" onclick="toSearch($(this))" searchUrl="' . route('xyyh.search', ['id' => $order->order_id, 'type' => $type]) . '">
                <input value="' . $order->order_id . '" name="id" type="hidden">
                <input value="' . $type . '" name="type" type="hidden">
                </form>';
                break;
            case 7:
                $botton = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="' . route('weixin.pay') . '" method="get" target="_blank">
                <input class="J_payonline" style="left: 300px;;" value="微信支付" type="button" onclick="weixin()" searchUrl="' . route('weixin.search', ['id' => $order->order_id, 'type' => $type]) . '">
                <input value="' . $order->order_id . '" name="id" type="hidden">\
                <input value="' . $type . '" name="type" type="hidden">
                </form>
                <script>
                function weixin(){
                    var mask = $("<div class=mask></div>");
                    $("body").append(mask);
                    $.ajax({
                        url:"' . route('weixin.pay', ['id' => $order->order_id, 'type' => $type]) . '",
                        type:"get",
                        dataType:"json",
                        success:function(data){
                            $("body").find(".mask").remove();
                            if(data.status === 500){
                                alert(data.msg);
                            }
                            else if(data.status === 200){
                                window.location="' . route('user.payOk', ['id' => $order->order_id, 'type' => $type]) . '";
                            }
                            else{
                                $("#code_img_url").attr("src",data.code_img_url);
                                $(".pop-wraper").show();
                                int = setInterval("search_weixin()", 3000)
                            }
                        }
                    })
                }
                function search_weixin(){
                    $.ajax({
                        url:"' . route('weixin.search', ['id' => $order->order_id, 'type' => $type]) . '",
                        type:"get",
                        dataType:"json",
                        success:function($result){
                            if($result==7){
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
                <input class="J_payonline" style="left: 200px;;" value="快捷支付" type="submit" onclick="toSearch($(this))" searchUrl="' . route('xyyh.search', ['id' => $order->order_id]) . '">
                <input value="' . $order->order_id . '" name="id" type="hidden">
                </form>';
        }
        return $botton;
    }
}