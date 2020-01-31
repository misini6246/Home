<?php

namespace App\Http\Controllers;

use App\erp\Gxywhz_bj;
use App\erp\Wldwzl;
use App\OldOrderInfo;
use App\OrderInfo;
use App\ZqOrder;
use App\ZqOrderYwy;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ErpController extends Controller
{

    public function wldwzl(Request $request){
        $page_size = $request->input('page_size',15);
        $order_sn = $request->input('order_sn');
        $consignee = $request->input('consignee');
        $order_ks = $request->input('order_ks');
        $order_js = $request->input('order_js');
        $order_qy = $request->input('order_qy');
        $users = Wldwzl::where('hsje','>=',0)->orderBy('rq','desc');
        if(!empty($order_sn)){
            $users->where('djbh','like','%'.$order_sn.'%');
        }
        if(!empty($consignee)){
            $users->where('shouhr','like','%'.$consignee.'%');
        }
        if(!empty($order_ks)&&!empty($order_js)){
            $users->whereBetween('rq',[$order_ks,$order_js]);
        }
        if(!empty($order_qy)){
            $users->where('wldwname','like','%'.$consignee.'%');
        }
        $users = $users->Paginate($page_size);
        if(count($users)>0){
            $users = $users->toArray();
            dd($users);
            //return view('shuang11.zhuanti');
            return $users;
        }
        return [];
    }

    protected function zjs($dh){
        $all = [];
        $all[] = ['运单号','收货时间','订单号'];
        if(!empty($dh)){
            $dh_xml = "<order>
<mailNo>%s</mailNo>
</order>";
            $dh_str = '';
            foreach($dh as $k=>$v){
                if(empty($v)){
                    unset($dh[$k]);
                }else{
                    $no = trim($v['no']);
                    $dh_str .= sprintf($dh_xml,$no);
                }
            }

            $val = "<BatchQueryRequest>
<logisticProviderID>HZ_YiYao</logisticProviderID>
<orders>
%s
</orders>
</BatchQueryRequest>";
            $val = sprintf($val,$dh_str);
            $sjs1 = rand(1000,9999);
            $sjs2 = rand(1000,9999);
            $bz = "HZ_YiYao";
            $miyao = "981D965E-A63D-471F-8C7C-2403836E8BA5";
            $cs = "z宅J急S送g";
            $str = $sjs1.$bz.$val.$miyao.$cs.$sjs2;
            $str = md5($str);
            $verifyData = $sjs1.substr($str,7,21).$sjs2;
            //dd($verifyData);
            $postdata='clientFlag='.$bz.'&xml='.$val.'&verifyData='.$verifyData;
            $ch = curl_init(); //创建一个curl
// 2. 设置选项，包括URL
            curl_setopt($ch, CURLOPT_URL, "http://edi.zjs.com.cn/svst/tracking.asmx/Get");
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
// 3. 执行并获取HTML文档内容
            $output = curl_exec($ch);
            $info = curl_getinfo($ch);
// 4. 释放curl句柄
            curl_close($ch);
            if ($output === FALSE) {
                show_msg(curl_error($ch));
            }
            else {

                $output = str_replace(array('&lt;', '&gt;'), array('<', '>'), $output);
                $output = substr($output, 79);
                $output = str_replace('</string>', '', $output);
                $xml_str = simplexml_load_string($output);
                $orders = [];

                if(isset($xml_str->orders)) {
                    foreach ($xml_str->orders->order as $v) {
                        $content = [];
                        $steps = [];
                        $arr['mailNo'] = $v->mailNo;
                        $arr['signinPer'] = $v->signinPer;
                        $arr['remark'] = $v->remark;

                        foreach ($v->steps->step as $val) {
                            if (strpos($val->acceptAddress, '签收') !== false) {//已签收
                                $content = [
                                    'zjs' => $v->mailNo,
                                    'time' => date('Y-m-d H:i:s', strtotime($val->acceptTime)),
                                ];

                                foreach($dh as $or){
                                    if($or['no']==$v->mailNo){
                                        $content['order_sn'] = $or['order_sn'];
                                    }
                                }
                            }
                            $step['acceptTime'] = $val->acceptTime;
                            $step['acceptAddress'] = $val->acceptAddress;
                            $steps[strtotime($val->acceptTime)] = $step;
                        }
                        krsort($steps);
                        $arr['steps'] = $steps;
                        $orders[] = $arr;
                        $all[] = $content;
                    }
                }
                //dd($orders, $xml_str->logisticProviderID);

                //dd($all);
                Excel::create('宅急送信息',function($excel) use ($all){
                    $excel->sheet('goods', function($sheet) use ($all){
                        $sheet->rows($all);
                    });
                })->export('xls');
                //return $all;
            }
        }
    }

    public function czjs1(){
        set_time_limit(600);
        $file = storage_path('app/daoru/zjs.xlsx');
        $data = Excel::load($file,function($reader){
        })->get();
        $arr = [];
        foreach($data as $k=>$val){

            if($k>2){
                $order_sn = explode('.',$val['_11'])[0];
                if(count($arr)<200) {
                    $id = OrderInfo::where('order_sn',$order_sn)->pluck('order_id');
                    if(empty($id)){
                        $id = OldOrderInfo::where('order_sn',$order_sn)->pluck('order_id');
                    }

                    if($id<=203538) {
                        $order = OldOrderInfo::where('order_id', $id)->where('fhwl_m','like','%宅急送%');
                    }else{
                        $order = OrderInfo::where('order_id', $id)->where('fhwl_m','like','%宅急送%');
                    }
                    $order = $order->select('invoice_no','order_sn','order_id','add_time','consignee')->first();

                    if(!empty($order)){
                        //$order = "0971097806  0971097816   0971097820   0971097831   0971097842   0971097853";
                        $dh = explode(' ',$order->invoice_no);
                        $dh_xml = "<order>
<mailNo>%s</mailNo>
</order>";
                        $dh_str = '';
                        foreach($dh as $key=>$v){

                                if (empty($v)) {
                                    unset($dh[$k]);
                                }

                        }
                        sort($dh);
                        foreach($dh as $key=>$v){
                            if($key==0){
                                $arr[] = [
                                    'order_sn'=>$order_sn,
                                    'no'=>$v,
                                ];
                            }
                        }
                        //dd($arr,$dh);
                    }

                }
            }
        }
        $all = [];
        foreach($arr as $k=>$v){
            if(empty($v['no'])){
                unset($arr[$k]);
            }
        }
        $a = $this->zjs($arr,$all);
    }

    public function czjs(){
        set_time_limit(600);
        $file = storage_path('app/daoru/zjs.xlsx');
        $data = Excel::load($file,function($reader){
        })->get();
        $arr = [];
        $all = [];
        $all[] = ['订单号','下单时间'];
        foreach($data as $k=>$val){

            if($k>2){
                $order_sn = explode('.',$val['_11'])[0];
                if(strpos($order_sn,'zq')!==false){
                    $add_time = ZqOrder::where('order_sn', $order_sn)->pluck('add_time');
                    if (empty($add_time)) {
                        $add_time = ZqOrderYwy::where('order_sn', $order_sn)->pluck('add_time');
                    }
                }else {
                    $add_time = OrderInfo::where('order_sn', $order_sn)->pluck('add_time');
                    if (empty($add_time)) {
                        $add_time = OldOrderInfo::where('order_sn', $order_sn)->pluck('add_time');
                    }
                }
                $all[] = [$order_sn,date('Y-m-d H:i:s',$add_time)];

            }
        }
        Excel::create('宅急送信息',function($excel) use ($all){
            $excel->sheet('goods', function($sheet) use ($all){
                $sheet->rows($all);
            });
        })->export('xls');
    }

    public function ls_order(Gxywhz_bj $bj){
        $order = $bj->with('lsb_bj')->where('rq','>','2016-12-25')->take(1)->get();
        dd($order);
    }
}
