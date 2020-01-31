<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/28
 * Time: 9:25
 */
return [
    'abc'=>[
        //网上支付平台通讯方式（http / https）
        'TrustPayConnectMethod' => 'https',
        //网上支付平台服务器名
        'TrustPayServerName' => 'pay.abchina.com',
        //网上支付平台交易端口
        'TrustPayServerPort' => 443,
        //网上支付平台接口特性
        'TrustPayNewLine' => 2,
        //网上支付平台交易网址
        'TrustPayTrxURL' => '/ebus/trustpay/ReceiveMerchantTrxReqServlet',
        //商户通过浏览器提交网上支付平台交易网址
        'TrustPayIETrxURL' => 'https://pay.abchina.com/ebus/ReceiveMerchantIERequestServlet',
        //商户通过浏览器提交网上支付平台交易失败网址 指商户通过浏览器提交接收网上支付平台返回错误页面；该页面是商户端页面；路径商户可以根据自己的应用情况自行配置
        'MerchantErrorURL' => '',
        //网上支付平台证书TrustPay.cer存放路径
        'TrustPayCertFile' => '/path/to/storage/app/abcpay/certs/TrustPay.cer',
        //商户资料段 (请更改)
        //商户编号
        'MerchantID' => '103882281400002',
        //交易日志开关
        'EnableLog' => true,
        //交易日志文件存放目录
        'LogPath' => '/path/to/storage/app/abcpay/log',
        //证书储存媒体 0: File;1: Hardware
        'MerchantKeyStoreType' => 0,
        //商户证书储存目录档名（当KeyStoreType=0时，必须设定）。指pfx证书，商户根据存放位置自行配置。如D:\WORK\cert\merchant.pfx
        'MerchantCertFile' => '/path/to/storage/app/abcpay/certs/103882281400002.pfx',
        //商户私钥加密密码（当KeyStoreType0时，必须设定）。指由商户设定的pfx证书密码
        'MerchantCertPassword' => 'abc95599',
    ],
];