<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/16
 * Time: 15:41
 */

namespace Jai\Contact\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JsyhController extends Controller{
    private  $pubstr = '30819d300d06092a864886f70d010101050003818b00308187028181008750410fafc6e1009fc7e89a6863b5f857a61765e75cc8f08e791701046f572b9f3d3ee74c85b2a4b6fa1b22a7e98daa273338f7fba944b7d994b5ec67d158e980579c012bec2a41982ef7b91aeb6c1fcb94623ccea734cf7537cc7afe374d8f36e8d88ec4a55365166db8c7c38b747db3d88a4df70d4402182d8d21f80387c5020111';            //建行提供的密钥，需要登陆建行商户后台下载
    private   $MERCHANTID = '';        //商户代码
    private  $POSID  = '';            //商户柜台代码
    private  $BRANCHID  = '';         //银行分行代码
    private  $ORDERID = '';           //订单编号
    private  $PAYMENT = '';           //订单金额

    private  $CURCODE = '';           //币种
    private  $TXCODE = '';            //交易码
    private  $REMARK1 = '';           //备注1
    private  $REMARK2 = '';           //备注2

    private  $TYPE = '';              //接口类型
    private  $GATEWAY = '';           //网关类型
    private  $CLIENTIP = '';          //客户端ip地址

    private  $PUB32TR2 = '';          //公钥后30位
    private  $bankURL = '';           //提交url
    private  $REGINFO = '';           //注册信息
    private  $PROINFO = '';           //商品信息
    private $REFERER = '';            //商户域名

    private  $URL = '';
    private  $tmp = '';
    private  $temp_New = '';
    private  $temp_New1 = '';
    /**
     * 构造函数  封装参数
     * @return  void
     */
    public function __construct(Request $request)
    {
        $this->MERCHANTID = '105510548160011';
        $this->POSID = '878557400';
        $this->BRANCHID = '510000000';

        $this->ORDERID = '19761';
        $this->PAYMENT = '0.01';
        $this->CURCODE = '01';

        $this->TXCODE = '520100';
        $this->REMARK1 = '';
        $this->REMARK2 = '';

        $this->bankURL = 'https://ibsbjstar.ccb.com.cn/app/ccbMain';
        $this->TYPE = 1;
        $this->PUB32TR2 = substr($this->pubstr, -30);

        $this->GATEWAY = '';
        $this->CLIENTIP = '';   //可以自己写个方法，我这里自己调用系统里
        $this->REGINFO = '';

        $this->PROINFO = '';
        $this->REFERER = '';
    }

    /*获取参数值*/
    public function getVar($name){
        return $this->$name;
    }

    /**
     * 生成url，文档用js，此url用于跳转到建行支付页
     * @access  public
     * @return  url
     */
    public  function getUrl()
    {
        $this->tmp .='MERCHANTID='.$this->MERCHANTID.'&POSID='.$this->POSID.'&BRANCHID='.$this->BRANCHID.'&ORDERID='.$this->ORDERID.'&PAYMENT='.$this->PAYMENT.'&CURCODE='.$this->CURCODE.'&TXCODE='.$this->TXCODE.'&REMARK1='.$this->REMARK1.'&REMARK2='.$this->REMARK2;
        $this->temp_New .=$this->tmp."&TYPE=".$this->TYPE."&PUB=".$this->PUB32TR2."&GATEWAY=".$this->GATEWAY."&CLIENTIP=".$this->CLIENTIP."&REGINFO=".$this->REGINFO."&PROINFO=".$this->PROINFO."&REFERER=".$this->REFERER;
        $this->temp_New1 .=$this->tmp."&TYPE=".$this->TYPE."&GATEWAY=".$this->GATEWAY."&CLIENTIP=".$this->CLIENTIP."&REGINFO=".$this->REGINFO."&PROINFO=".$this->PROINFO."&REFERER=".$this->REFERER;
        $strMD5 = md5($this->temp_New);
        $this->URL .= $this->bankURL."?".$this->temp_New1."&MAC=".$strMD5;
        return $this->URL;
    }

    /*记录支付日志信息*/
    public function writeLog($order){

        $fp = fopen('/'.$order['order_sn'].'.txt' , 'a');
        if(flock($fp, LOCK_EX)){
            fwrite($fp, "提交到建行支付页面时间：\r");
            fwrite($fp,  local_date('Y-m-d H:i:s'));
            fwrite($fp,"\n");
            fwrite($fp, "传递url参数信息：\n");
            fwrite($fp, $this->getUrl());
            fwrite($fp, "\n记录支付前数据信息:\n");
            fwrite($fp, "订单号：".$order['order_sn']."\r订单金额：".$order['order_amount']);
            fwrite($fp, "\r\n\n\n");
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }

    public function pay(){
        $this->Main();
        dd();
        $url = $this->getUrl();
        return redirect()->to($url);
    }

    public function sign(){
        $public_key = file_get_contents(storage_path("app/xyyh/rsa_public_key.pem"));
        $pkeyid = openssl_pkey_get_public($public_key);
        $data = 'abc';
        $sign = '5e37994b88768c4d10cc6a0a05f4331dd782b1bd800adbc90bde1c0a19739abec4496afc364c046b8222467c7796d257ca113b3ec81f6608e88d174fc30734885359b155d1bb81dc34cc62e4b99d1d04e9ae39e1c541674efbede73f04e8a033dea2bb7fb94bd8fa7786fba8dba9b936b118b18abf53266137578c55af96f8a7';
        $sign = base64_decode($sign);
        if ($pkeyid) {
            $verify = openssl_verify($data, $sign, $pkeyid, OPENSSL_ALGO_MD5);
            openssl_free_key($pkeyid);
        }
        dd($verify);
    }

    public function Main()
    {

        //签名串
        $signString =
        "5e37994b88768c4d10cc6a0a05f4331dd782b1bd800adbc90bde1c0a19739abec4496afc364c046b8222467c7796d257ca113b3ec81f6608e88d174fc30734885359b155d1bb81dc34cc62e4b99d1d04e9ae39e1c541674efbede73f04e8a033dea2bb7fb94bd8fa7786fba8dba9b936b118b18abf53266137578c55af96f8a7";
            //公钥
         $pubKey =
        "30819d300d06092a864886f70d010101050003818b00308187028181008750410fafc6e1009fc7e89a6863b5f857a61765e75cc8f08e791701046f572b9f3d3ee74c85b2a4b6fa1b22a7e98daa273338f7fba944b7d994b5ec67d158e980579c012bec2a41982ef7b91aeb6c1fcb94623ccea734cf7537cc7afe374d8f36e8d88ec4a55365166db8c7c38b747db3d88a4df70d4402182d8d21f80387c5020111";
            //签名源串
        $initString =
        "POSID=000000&BRANCHID=110000000&ORDERID=00320995&PAYMENT=0.01&CURCODE=01&REMARK1=test1&REMARK2=test2&SUCCESS=Y";

        $str = $this->StrToBin($pubKey);
        dd($str);
    }

    private function StrToBin($str)
    {
        $arr = preg_split('/(?<!^)(?!$)/u', $str);
        foreach($arr as &$v){
            $temp = unpack('H*', $v);
            $v = base_convert($temp[1], 16, 2);
            unset($temp);
        }
        return join(' ',$arr);
    }

}