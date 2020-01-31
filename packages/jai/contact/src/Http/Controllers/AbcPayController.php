<?php

namespace Jai\Contact\Http\Controllers;

use App\OnlinePay;
use App\OrderInfo;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Jai\Contact\Http\Controllers\abc\PaymentRequest;
use Jai\Contact\Http\Controllers\abc\QueryOrderRequest;
use Jai\Contact\Http\Controllers\abc\Json;
use Jai\Contact\Http\Controllers\abc\QueryTrnxRecords;
use Jai\Contact\Http\Controllers\abc\Result;
use App\PayLog;

class AbcPayController extends Controller
{
    public function pay(Request $request){
        $id = $request->input('id');
        $user = Auth::user();
        $order = OrderInfo::with([
            'order_goods'=>function($query){
                $query->select('order_id','goods_id','goods_name','goods_price','goods_number');
            }])->where('user_id',$user->user_id)->where('order_id',$id)->first();
        if(!$order){
            return view('message')->with(messageSys('订单不存在请咨询客服',route('user.orderList'),[
                [
                    'url'=>route('user.orderList'),
                    'info'=>'返回订单列表',
                ],
            ]));
        }
        $orderSn = $this->getOrderSn();
        $update_time = time();
        $result = OnlinePay::where('order_id',$order->order_id)->select('id','order_sn','order_id','update_time')->first();
        if(empty($result->id)) {
            $result = new OnlinePay();
            $result->order_id = $order->order_id;
            $result->update_time = $update_time;
            $result->order_sn = $orderSn;
        }else{
            $search = $this->search($order->order_sn,$result->order_sn,$order->order_amount);
            if($search==1){
                return view('message')->with(messageSys('订单已支付',route('user.orderInfo',['id'=>$order->order_id]),[
                    [
                        'url'=>route('user.orderList'),
                        'info'=>'返回订单列表',
                    ],
                ]));
            }else{
                $result->order_sn = $orderSn;
            }
        }
        if($result->save()) {
            $tRequest = new PaymentRequest();
            $tRequest->order["PayTypeID"] = "ImmediatePay"; //设定交易类型
            $tRequest->order["OrderNo"] = $orderSn; //设定订单编号
            $tRequest->order["ExpiredDate"] = 30; //设定订单保存时间
            $tRequest->order["OrderAmount"] = $order->order_amount; //设定交易金额
            $tRequest->order["Fee"] = 0; //设定手续费金额
            $tRequest->order["CurrencyCode"] = '156'; //设定交易币种
            $tRequest->order["ReceiverAddress"] = ''; //收货地址
            $tRequest->order["InstallmentMark"] = '0'; //分期标识
            $installmentMerk = '0';
            $paytypeID = 'ImmediatePay';
            if (strcmp($installmentMerk, "1") == 0 && strcmp($paytypeID, "DividedPay") == 0) {
                $tRequest->order["InstallmentCode"] = ($_POST['InstallmentCode']); //设定分期代码
                $tRequest->order["InstallmentNum"] = ($_POST['InstallmentNum']); //设定分期期数
            }
            $tRequest->order["BuyIP"] = ''; //IP
            $tRequest->order["OrderDesc"] = $order->order_sn; //设定订单说明
            $tRequest->order["OrderURL"] = ''; //设定订单地址
            $tRequest->order["OrderDate"] = date('Y/m/d'); //设定订单日期 （必要信息 - YYYY/MM/DD）
            $tRequest->order["OrderTime"] = date('H:i:s'); //设定订单时间 （必要信息 - HH:MM:SS）
            $tRequest->order["orderTimeoutDate"] = ""; //设定订单有效期
            $tRequest->order["CommodityType"] = '0202'; //设置商品种类

//2、订单明细

            $orderitem = array();
            $orderitem["SubMerName"] = $order->consignee; //设定二级商户名称 用收货人代替
            $orderitem["SubMerId"] = $order->user_id; //设定二级商户代码
            $orderitem["SubMerMCC"] = ""; //设定二级商户MCC码
            $orderitem["SubMerchantRemarks"] = ""; //二级商户备注项
            $orderitem["ProductID"] = $order->order_id; //商品代码，预留字段 用order_id 代替
            $orderitem["ProductName"] = "网上订单{$order->order_sn}"; //商品名称
            $orderitem["UnitPrice"] = $order->order_amount; //商品总价
            $orderitem["Qty"] = "1"; //商品数量
            $orderitem["ProductRemarks"] = "商城订单编号{$order->order_sn}"; //商品备注项
            $orderitem["ProductType"] = ""; //商品类型
            $orderitem["ProductDiscount"] = "1"; //商品折扣
            $orderitem["ProductExpiredDate"] = "10"; //商品有效期
            $tRequest->orderitems[0] = $orderitem;
            $tRequest->request["PaymentType"] = 'A'; //设定支付类型
            $tRequest->request["PaymentLinkType"] = '1'; //设定支付接入方式
//        if ($_POST['PaymentType'] === "6" && $_POST['PaymentLinkType'] === "2") {
//            $tRequest->request["UnionPayLinkType"] = ($_POST['UnionPayLinkType']); //当支付类型为6，支付接入方式为2的条件满足时，需要设置银联跨行移动支付接入方式
//        }
            // $tRequest->request["ReceiveAccount"] = ($_POST['ReceiveAccount']); //设定收款方账号
            //$tRequest->request["ReceiveAccName"] = ($_POST['ReceiveAccName']); //设定收款方户名
            $tRequest->request["NotifyType"] = '1'; //设定通知方式
            $tRequest->request["ResultNotifyURL"] = route('abc.result'); //设定通知URL地址
            $tRequest->request["MerchantRemarks"] = "商城订单编号{$order->order_sn}"; //设定附言
            $tRequest->request["IsBreakAccount"] = '0'; //设定交易是否分账
            $tRequest->request["SplitAccTemplate"] = ''; //分账模版编号
//print_r($tRequest);die;
            $tResponse = $tRequest->postRequest();
            //dd($order);
            if ($tResponse->isSuccess()) {
                $PaymentURL = $tResponse->GetValue("PaymentURL");
                return redirect()->to($PaymentURL);
            } else {
                return redirect()->route('user.index');
            }
        }
    }
    /*
     * 查詢支付
     */
    public function toSearch(Request $request){
        $id = $request->input('id');
        $order = OnlinePay::with([
            'order_info' => function($query){
                $query->select('order_sn','order_amount','order_id','pay_status');
            }
        ])->where('order_id',$id)
            ->select('order_id','order_sn')
            ->first();
        $result = [];
        if(($order->order_info->pay_status==2&&$order->order_info->order_amount==0)||empty($order)){
            $result['error'] = 0;
        }else {
            $search = $this->search($order->order_info->order_sn, $order->order_sn, $order->order_info->order_amount);
            if ($search == 1) {
                $result['error'] = 0;
            } else {
                $result['error'] = 1;
            }
        }
        return $result;
    }
    /*
     * 支付结果查询
     */
    private function search($orderSn,$orderNo,$amount){
        $tRequest = new QueryOrderRequest();
        $tRequest->request["PayTypeID"] = 'ImmediatePay'; //设定交易类型
        $tRequest->request["OrderNo"] = $orderNo; //设定订单编号 （必要信息）
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
                $detail = new Json($orderDetail);
                $time = date('YmdHis',strtotime($tResponse->getValue("HostDate")." ".$tResponse->getValue("HostTime")));
                //print_r($time);
                //print_r($detail->GetValue("Status")=='04');
                if($detail->GetValue("OrderAmount")==$amount&&$detail->GetValue("Status")=='04') {
                    $this->payResult("{$orderSn}", "{$detail->getValue('OrderNo')}", 2, $time, "Success!农行交易号:{$detail->getValue('OrderNo')}");
                    return 1;
                }else{
                    return 2;
                }
            }
        }else{
            return $tResponse->getReturnCode();
        }
    }
    /*
     * 获取支付流水号
     */
    private function getOrderSn(){

        /*
         * 获取订单号，确保订单号唯一
         */
        $is_order_exist = true ; //标识，默认订单号已经存在
        $order_sn = '' ;
        do {
            $order_sn = date('YmdHis', time()).mt_rand(100, 999) ;
            $oid = OnlinePay::where('order_sn',$order_sn)->count();
            if(empty($oid)) {
                //如果计数为0
                $is_order_exist = false ;
            }
        } while($is_order_exist) ;
        /* 选择一个随机的方案 */
        //mt_srand((double) microtime() * 1000000);
        //return date('YmdHis', time()).mt_rand(10, 99) ;
        return $order_sn ;

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
    private function payResult($order_sn, $qid, $pay_status = 2, $trace_time, $note = ''){
        /* 取得所有未付款的订单 */
        $order_data = OrderInfo::where('order_sn',$order_sn)->where('pay_status','!=',2)
            ->first();
        $user = User::find($order_data->user_id);
        if($order_data){
            $order_data->order_status = 1;
            $order_data->confirm_time = time();
            $order_data->pay_status = $pay_status;
            $order_data->pay_time = time();
            $order_data->qid = $qid;
            $order_data->money_paid = $order_data->order_amount;
            $order_data->o_paid = $order_data->order_amount;
            $order_data->order_amount = 0;
            $order_data->pay_id = 5;
            $order_data->pay_name = '农行在线支付';
            $order_data->trace_time = $trace_time;
            DB::transaction(function()use($order_data,$note,$user){
                order_action($order_data,$note,$user->user_name);
                PayLog::where('order_id',$order_data->order_id)->update(['is_paid'=>1]);
                $order_data->save();
            });
        }
    }
    /*
     * 回调
     */
    public function result(Request $request){
        //1、取得MSG参数，并利用此参数值生成验证结果对象
        $tResult = new Result();
        $tResponse = $tResult->init($request->input('MSG'));
        if ($tResponse->isSuccess()) {
            $order = OnlinePay::with([
                'order_info' => function($query){
                    $query->select('order_sn','order_amount','order_id');
                }
            ])->where('order_sn',$tResponse->getValue('OrderNo'))
                ->select('order_id')
                ->first();
            $time = date('YmdHis',strtotime($tResponse->getValue("HostDate")." ".$tResponse->getValue("HostTime")));
            //print_r($time);
            if($tResponse->getValue("Amount")==$order->order_info->order_amount) {
                $this->payResult($order->order_info->order_sn, $tResponse->getValue('OrderNo'), 2, $time, "Success!农行交易号:{$tResponse->getValue('OrderNo')}");
            }
            if($request->input('sj')==1){
                return redirect()->to('http://app.hezongyy.com/index.php?m=default&c=user&a=index');
            }else {
                return redirect()->route('user.orderInfo', ['id' => $order->order_id]);
            }
        } else {
            return redirect()->route('index');
        }
    }


    /**
     * 查询对账信息
     */
    public function duizhang(Request $request){
        $tRequest = new QueryTrnxRecords();
        $tRequest->request["SettleDate"] = $request->input('date','2016/09/08'); //查询日期YYYY/MM/DD （必要信息）
        $tRequest->request["SettleStartHour"] = $request->input('start','0'); //查询开始时间段（0-23）
        $tRequest->request["SettleEndHour"] = $request->input('end','23'); //查询截止时间段（0-23）
        $tRequest->request["ZIP"] = '0';

//2、传送交易流水查询请求并取得交易流水
        $tResponse = $tRequest->postRequest();

//3、判断交易流水查询结果状态，进行后续操作
        $new_data = [];

        if ($tResponse->isSuccess()) {
            $data = $tResponse->GetValue("DetailRecords");
            $data = explode('^^',$data);
            foreach($data as $v){
                $v = explode('|',$v);
                if($v[4]==='0000'){//表示支付成功
                    $new_data[] = $v;
                }
            }
        }

        //dd($new_data,$tResponse);
        return $new_data;
    }
}
