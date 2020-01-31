<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-03-08
 * Time: 11:09
 */

namespace App\Common\Pay;


use App\Http\Requests\Request;
use App\Models\CzOrder;
use App\OrderInfo;
use App\User;
use App\YouHuiCate;
use App\YouHuiQ;
use App\ZqOrder;
use App\ZqOrderSy;
use App\ZqOrderYwy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait Union
{
    private $key = 'SDFJIW2E9FK3WEF8W3JEF8SDKJS2S9';

    private $signature;

    private $signMethod = 'md5';

    private $pay_arr = [
        "origQid"            => "",
        "acqCode"            => "",
        "merCode"            => "",
        "commodityUrl"       => "",
        "commodityName"      => "",
        "commodityUnitPrice" => "",
        "commodityQuantity"  => "",
        "commodityDiscount"  => "",
        "transferFee"        => "",
        "customerName"       => "",
        "defaultPayType"     => "",
        "defaultBankNumber"  => "",
        "transTimeout"       => "",
        "merReserved"        => "",
        'version'            => '1.0.0',
        'charset'            => 'UTF-8',
        'merId'              => '898510148990236',
        'merAbbr'            => '商户名称',
        'transType'          => '01',
        'orderAmount'        => 0,
        'orderNumber'        => '',
        'orderTime'          => '',
        'orderCurrency'      => '156',
        'customerIp'         => '127.0.0.1',
        'frontEndUrl'        => '',
        'backEndUrl'         => '',
    ];


    public function get_code($request, $order)
    {
        $this->pay_arr['orderTime']   = date('YmdHis');
        $this->pay_arr['customerIp']  = $request->ip();
        $this->pay_arr['frontEndUrl'] = route('union.result',['type'=>4]);
        $this->pay_arr['backEndUrl']  = route('union.result',['type'=>4]);
        $this->pay_arr['orderAmount'] = $order->order_amount * 100;
        $this->pay_arr['orderNumber'] = $order->order_sn;
        $this->signature              = $this->sign();
        $this->pay_arr['signature']   = $this->signature;
        $this->pay_arr['signMethod']  = $this->signMethod;
        $content                      = response()->view('pay.union', ['pay_arr' => $this->pay_arr])->getContent();
        exit($content);
    }

    private function sign()
    {
        if (strtolower($this->signMethod) == "md5") {
            ksort($this->pay_arr);
            $sign_str = "";
            foreach ($this->pay_arr as $key => $val) {
                $sign_str .= sprintf("%s=%s&", $key, $val);
            }
            return md5($sign_str . md5($this->key));
        } /* TODO: elseif (strtolower($sign_method) == "rsa")  */
        else {
            show_msg('只支持MD5签名');
        }
    }
    private function order_info($type, $order_sn)
    {
        switch ($type) {
            case 1:
                return OrderInfo::where('order_sn', $order_sn)->select('order_id', 'order_sn', 'order_amount', 'pay_status')->first();
                break;
            case 2:
                return ZqOrder::where('order_sn', $order_sn)->select('order_id', 'order_sn', 'order_amount', 'pay_status')->first();
                break;
            case 3:
                return ZqOrderYwy::where('order_sn', $order_sn)->select('order_id', 'order_sn', 'order_amount', 'pay_status')->first();
                break;
            case 4:
                return ZqOrderSy::where('order_sn', $order_sn)->select('order_id', 'order_sn', 'order_amount', 'pay_status')->first();
                break;
            case 5:
                return CzOrder::where('order_sn', $order_sn)->select('order_id', 'order_sn', 'order_amount', 'pay_status')->first();
                break;
            default:
                return OrderInfo::where('order_sn', $order_sn)->select('order_id', 'order_sn', 'order_amount', 'pay_status')->first();
                break;
        }
    }

    public function result(Request $request){
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
        $order = CzOrder::where('order_sn',$order_sn)->select('order_id','order_sn','order_amount','pay_status')->first();
        if(!$order){
            return redirect()->route('index');
        }
        if(($order->pay_status==2&&$order->order_amount==0)){
            return redirect()->route('user.cz_order_info', ['id' => $order->order_id]);
        }else {
            $time = strtotime($request->input('respTime'));
            //print_r($time);
            if(abs($order->order_amount*100-$payment_amount)<0.000001) {
                $this->payResult($order->order_sn, $orderSn, 2, $time, "Success！银联交易号：{$orderSn}");
            }
            if(!$request->ajax()) {
                return redirect()->route('user.cz_order_info', ['id' => $order->order_id]);
            }
        }
    }

    public function payResult($order_sn, $qid, $pay_status = 2, $trace_time, $note = ''){
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
                if($order_data->save()) {
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

}