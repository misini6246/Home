<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2018-03-14
 * Time: 17:37
 */

namespace App\Common\AlipayPc;


class AlipayTradeService
{

    //支付宝网关地址
    public $gateway_url = "https://openapi.alipay.com/gateway.do";

    //支付宝公钥
    public $alipay_public_key = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgCBSTKyKsTHdtTDvLspAs8C5oBSZU/55E93zcbJLprx0TX6Z72+5Z2Bx4bMT07YKXCpDj3RnETd0fkEOyswx4zp+ekho7+XshOem7CFaSR1CiQo8LYOXFXw9ARQ6TEmzERiwRZ8d4UjREPil1l+zVb174nEbSWdn3SltB6eYE/yR90CRcskxv82jvyp5ev8a3N0zXPdrL8t2Uvod+n414EshnKNES/RJldJkVT705Ly/eHQNsKPRCdDxEv12bR481JLVAwN8ZxVSllnJrQR7SSuDXugyWIKlG+YbMMEv8Xuc+JnXCBXbOm0a67kON2ft2kTkgEZseLCOyYx7BIOCWwIDAQAB';
    //商户私钥
    public $private_key = 'MIIEpQIBAAKCAQEAsJXsVrJoughmTZgfH687URMX7/E8c+BaGw7/KXKFCsNpsb6PR+0aBqkRej4vsHNiC8k5BOHORp4tpZ14akkih+r21xSlt0m8oL2X898EyO8c1QdROH9pXKdoxvK9LefMoQq5oSiyjGzK86z2FOFuA42+RUahEL2PX8jI37jNEjgL/G8dDQJ9wEIADMakj53vRkDl9hiYHM50dLpGg9mcAtAfQ8auLYCiWGbQKT5v9VG9rJIogxYyCiPMXn9/X7N6hlRQwMx0XXzhQrll6ykeSw3ThjrHiCgzTvqBccq8R+TsXfFEngFltsbiU/AoZA0X0fYsW1Tb7Dn4qTF5okF8iQIDAQABAoIBAFrHR+8t2m7AgK8lI+Lq94hvU1/zWQuM62V7qSsKh2CIIt7QQuJL/pQr+CMqsuN3/ZBnipt65csh5/9623twS4MqBGl/YM2/52uO6/3fyZruaZkOIO/1eBm8qj2UbjKaNnUXiWRTAq70AsWQRhVn6mGDTaxZadWsTXeFRdbVLv9M3CUu/Ct2N/zpTuLJ6YR/1phYnwd0b1/bmxSOtjL8vOY+SAydoc/dLa1TxsSFUoPDFWERYFOGHCBzBW+bpUiFz97OwiX5Z+PCFon4tIUBC7qPPLSG9W7bIurDMqWx1SthxKMnCOKU0vtCb0Rsb8fpaVmZZ4A17ht0TElzSXL1UfECgYEA10Wbnl1rEOsETM7EZmrtaoF/YxbIiIC1VFyCWbWkP2fTrRdA4Gui++qEPeuyDresn/uhFbiZv3o/KF179oHmCop6FLKDT7LBHKIHaeUHtyGj5OPWkq29a0hVLdf9SowfaDtizNj0qy7XN7vg8zPpj2sDSNeILJqsB3xevrJaWWUCgYEA0f6ZrOleB82A5w4xcS3Zv0hxfSheVQrWn8FW0n6J+qlK67ZSxOitynUTzQ7THw64Sx8LnKKyfY93a876Lobl6LvkMk8aolBfZhoxYl6zl4lgB4N16zXShmQi8PsodbLArQAKBrj+P9CqYxvRsGMP8SWeeA9rCsdGQpZFNaKktlUCgYEAk3Y2NJQvjEZBCtA0jye9/FA6z8jCk2b/T4uTKxqXKWvY/1/HbDOvULuD3NrAfP5qvKhk3vk2MIjwDJmFGgY/a4cSO21RL932FMQVKf/eeh8MIvXDfXSQJZZF6wJimpdDyGWttz8C0uRiPuZvIIm1+y1F8bbarBtDrlkOmbiY1VUCgYEAo9QGnnC+TEYWb6ySBCNqQqJI8ATje2NmR+J1UuknymfzLGvkrPx+QXoPhaYwLYW1X94LmBsSN4UK/Q/P/SZ/DZAwmtM+Cy27D5QVvRH2+J1TTulPwL4PzYsn+2tmiFR5nz5tlAsVSEIJ/CJC+GKAmHjp5e7ZauJGvUIxIoQODrUCgYEAqrGhpOG60StXb0e4aPSYMlQgcTISyjFuW92E0wDNRSIpxGc621aM5i4EoshxeRKjUV9IQbRk6xygym4EcK0qjm61dxH7+aM7wtB8JGKnt7nHS8ETQPe8jhde6cKoId/WwH54ZQ4awr7uj/t4AilWQJ9uj5wHwratZqBPq/920Zg=';

    //应用id
    public $appid = '2018101561712228';

    //编码格式
    public $charset = "UTF-8";

    public $token = NULL;

    //返回数据格式
    public $format = "json";

    //签名方式
    public $signtype = "RSA2";

    function __construct()
    {

        if (empty($this->appid) || trim($this->appid) == "") {
            tips1("appid should not be NULL!");
        }
        if (empty($this->private_key) || trim($this->private_key) == "") {
            tips1("private_key should not be NULL!");
        }
        if (empty($this->alipay_public_key) || trim($this->alipay_public_key) == "") {
            tips1("alipay_public_key should not be NULL!");
        }
        if (empty($this->charset) || trim($this->charset) == "") {
            tips1("charset should not be NULL!");
        }
        if (empty($this->gateway_url) || trim($this->gateway_url) == "") {
            tips1("gateway_url should not be NULL!");
        }

    }

    /**
     * alipay.trade.page.pay
     * @param $builder 业务参数，使用buildmodel中的对象生成。
     * @param $return_url 同步跳转地址，公网可以访问
     * @param $notify_url 异步通知地址，公网可以访问
     * @return $response 支付宝返回的信息
     */
    function pagePay($builder, $return_url, $notify_url)
    {

        $biz_content = $builder->getBizContent();
        //打印业务参数
        //$this->writeLog($biz_content);

        $request = new AlipayTradePagePayRequest();

        $request->setNotifyUrl($notify_url);
        $request->setReturnUrl($return_url);
        $request->setBizContent($biz_content);

        // 首先调用支付api
        $response = $this->aopclientRequestExecute($request, true);
        // $response = $response->alipay_trade_wap_pay_response;
        return $response;
    }

    /**
     * sdkClient
     * @param $request 接口请求参数对象。
     * @param $ispage  是否是页面接口，电脑网站支付是页面表单接口。
     * @return $response 支付宝返回的信息
     */
    function aopclientRequestExecute($request, $ispage = false)
    {

        $aop = new AopClient ();
        $aop->gatewayUrl = $this->gateway_url;
        $aop->appId = $this->appid;
        $aop->rsaPrivateKey = $this->private_key;
        $aop->alipayrsaPublicKey = $this->alipay_public_key;
        $aop->apiVersion = "1.0";
        $aop->postCharset = $this->charset;
        $aop->format = $this->format;
        $aop->signType = $this->signtype;
        // 开启页面信息输出
        $aop->debugInfo = true;
        if ($ispage) {
            $result = $aop->pageExecute($request, "post");
            echo $result;
        } else {
            $result = $aop->Execute($request);
        }

        //打开后，将报文写入log文件
        $this->writeLog("response: " . var_export($result, true));
        return $result;
    }

    /**
     * alipay.trade.query (统一收单线下交易查询)
     * @param $builder 业务参数，使用buildmodel中的对象生成。
     * @return $response 支付宝返回的信息
     */
    function Query($builder)
    {
        $biz_content = $builder->getBizContent();
        //打印业务参数
        $this->writeLog($biz_content);
        $request = new AlipayTradeQueryRequest();
        $request->setBizContent($biz_content);

        $response = $this->aopclientRequestExecute($request);
        $response = $response->alipay_trade_query_response;
        return $response;
    }

    /**
     * alipay.trade.refund (统一收单交易退款接口)
     * @param $builder 业务参数，使用buildmodel中的对象生成。
     * @return $response 支付宝返回的信息
     */
    function Refund($builder)
    {
        $biz_content = $builder->getBizContent();
        //打印业务参数
        $this->writeLog($biz_content);
        $request = new AlipayTradeRefundRequest();
        $request->setBizContent($biz_content);

        $response = $this->aopclientRequestExecute($request);
        $response = $response->alipay_trade_refund_response;
        return $response;
    }

    /**
     * alipay.trade.close (统一收单交易关闭接口)
     * @param $builder 业务参数，使用buildmodel中的对象生成。
     * @return $response 支付宝返回的信息
     */
    function Close($builder)
    {
        $biz_content = $builder->getBizContent();
        //打印业务参数
        $this->writeLog($biz_content);
        $request = new AlipayTradeCloseRequest();
        $request->setBizContent($biz_content);

        $response = $this->aopclientRequestExecute($request);
        $response = $response->alipay_trade_close_response;
        return $response;
    }

    /**
     * 退款查询   alipay.trade.fastpay.refund.query (统一收单交易退款查询)
     * @param $builder 业务参数，使用buildmodel中的对象生成。
     * @return $response 支付宝返回的信息
     */
    function refundQuery($builder)
    {
        $biz_content = $builder->getBizContent();
        //打印业务参数
        $this->writeLog($biz_content);
        $request = new AlipayTradeFastpayRefundQueryRequest();
        $request->setBizContent($biz_content);

        $response = $this->aopclientRequestExecute($request);
        return $response;
    }

    /**
     * alipay.data.dataservice.bill.downloadurl.query (查询对账单下载地址)
     * @param $builder 业务参数，使用buildmodel中的对象生成。
     * @return $response 支付宝返回的信息
     */
    function downloadurlQuery($builder)
    {
        $biz_content = $builder->getBizContent();
        //打印业务参数
        $this->writeLog($biz_content);
        $request = new alipaydatadataservicebilldownloadurlqueryRequest();
        $request->setBizContent($biz_content);

        $response = $this->aopclientRequestExecute($request);
        $response = $response->alipay_data_dataservice_bill_downloadurl_query_response;
        return $response;
    }

    /**
     * 验签方法
     * @param $arr 验签支付宝返回的信息，使用支付宝公钥。
     * @return boolean
     */
    function check($arr)
    {
        $aop = new AopClient();
        $aop->alipayrsaPublicKey = $this->alipay_public_key;
        $result = $aop->rsaCheckV1($arr, $this->alipay_public_key, $this->signtype);

        return $result;
    }

    /**
     * 请确保项目文件有可写权限，不然打印不了日志。
     */
    function writeLog($text)
    {
        // $text=iconv("GBK", "UTF-8//IGNORE", $text);
        //$text = characet ( $text );
        //file_put_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . "./../../log.txt", date("Y-m-d H:i:s") . "  " . $text . "\r\n", FILE_APPEND);
    }
}