<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/28
 * Time: 13:02
 */
$url = [
    'a' => 'http://127.0.0.1/',
    'b' => 'http://images.hezongyy.com/hzygy/',
    'c' => 'http://www.hezongyy.com/',
];
return [
    'abc'=>[
        "TrustPayConnectMethod" => "https",
        "TrustPayServerName" => "pay.abchina.com",
        "TrustPayServerPort" => "443",
        "TrustPayNewLine" => "2",
        "TrustPayTrxURL" => "/ebus/trustpay/ReceiveMerchantTrxReqServlet",
        "TrustPayIETrxURL" => "https://pay.abchina.com/ebus/ReceiveMerchantIERequestServlet",
        "MerchantErrorURL" => $url['a'],//
        "TrustPayCertFile" => storage_path("app/abcpay/certs/TrustPay.cer"),
        "MerchantID" => "103882281400004",
        "EnableLog" => "1",
        "LogPath" => storage_path("app/abcpay/log"),
        "MerchantKeyStoreType" => "0",
        "MerchantCertFile" => storage_path("app/abcpay/certs/103882281400004.pfx"),
        "MerchantCertPassword" => "abc95599",
        "SignServerIP" => "如果使用签名服务器，请在此设定签名服务器的IP",
        "SignServerPort" => "如果使用签名服务器，请在此设定签名服务器的端口号",
        "SignServerPassword" => "如果使用签名服务器，请在此设定签名服务器的密码",
    ],
    'union'=>[
        'SDK_SIGN_CERT_PATH' => storage_path("app/unionpay/certs/acp_test_sign.pfx"),
        'SDK_SIGN_CERT_PWD' => '000000',
        'SDK_ENCRYPT_CERT_PATH' => storage_path("app/unionpay/certs/acp_test_enc.cer"),
        'SDK_VERIFY_CERT_DIR' => storage_path("app/unionpay/certs/"),
        'SDK_FRONT_TRANS_URL' => 'https://101.231.204.80:5000/gateway/api/frontTransReq.do',
        'SDK_BACK_TRANS_URL' => 'https://101.231.204.80:5000/gateway/api/backTransReq.do',
        'SDK_SINGLE_QUERY_URL' => 'https://101.231.204.80:5000/gateway/api/queryTrans.do',
        'SDK_Card_Request_Url' => 'https://101.231.204.80:5000/gateway/api/cardTransReq.do',
        'SDK_App_Request_Url' => 'https://101.231.204.80:5000/gateway/api/appTransReq.do',
        'SDK_FRONT_NOTIFY_URL' => 'http://localhost:8085/upacp_sdk_php/demo/api_01_gateway/FrontReceive.php',
        'SDK_BACK_NOTIFY_URL' => 'http://222.222.222.222/upacp_sdk_php/demo/api_01_gateway/BackReceive.php',
        'SDK_FILE_DOWN_PATH' => storage_path("app/unionpay/file/"),
        'SDK_LOG_FILE_PATH' => storage_path("app/unionpay/log/"),
        'SDK_LOG_LEVEL' => 'INFO',
        'merId' => '777290058115007',
    ],
    'xyyh'=>[
        'appid' => 'Q0000612',        // 商户号，格式如A0000001
        // 商户私有密钥，该密钥需要严格保密，只能出现在后台服务端代码中，不能放在可能被用户查看到的地方，如html、js代码等
// 在发送报文给收付直通车时，会使用该密钥进行签名（SHA1算法方式）
// 在收到收付直通车返回的报文时，将使用该密钥进行验签
        'commKey' => '6D5CFC11FC174B96A5D9C9118567A801',
        // 商户客户端证书路径，该证书需要严格保密
// 在发送报文给收付直通车时，会使用该密钥进行签名（RSA算法方式）
        'mrch_cert' => storage_path("app/xyyh/certs/appsvr_client.pfx"),
        // 以下证书参数一般为默认值，无需更改
        'mrch_cert_pwd' => '123456',
        // 收付直通车服务器证书，RSA算法验签使用
        'epay_cert_test' => storage_path("app/xyyh/certs/appsvr_server_test.pem"),
        'epay_cert_prod' => storage_path("app/xyyh/certs/appsvr_server_prod.pem"),
        // 二级商户名称，可为空
        'sub_mrch' => '',
        // 是否为开发测试模式，true时将连接测试环境，false时将连接生产环境
        'isDevEnv' => false,
        // 是否验签，true验证应答报文签名，false不验证签名，开发调试时可修改此项为false，生产环境请更改为true
        'needChkSign' => true,
        // 代理设置，设为null为不使用代理
        'proxy_ip' => null,
        'proxy_port' => null,
    ],
   /* 'weixin'=>[
        'url'        => 'https://pay.swiftpass.cn/pay/gateway',
        'mchId'      => '280361000122',
        'key'        => '94b39b1dd9f8c77a439fecb7',
        'version'    =>'1.0',
        'notify_url' =>'http://www.hezongyy.com/weixin/response',
    ],*/
   'weixin' =>[
       'url'=>'https://pay.swiftpass.cn/pay/gateway',/*支付接口请求地址，请联系技术支持确认 */
       'mchId'=>'105570128791',/* 商户号，建议用正式的，于申请成功后的开户邮件中获取，若未开户需用测试的请联系技术支持 */
       'key'=>'261fe26dbd45cd8681cc168a0be0bd92',  /* MD5签名密钥，建议用正式的，于申请成功后的开户邮件中获取，若未开户需用测试的请联系技术支持 */
       'version'=>'2.0',
       'sign_type'=>'MD5',
   ]
];