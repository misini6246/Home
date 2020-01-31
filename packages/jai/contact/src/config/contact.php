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
        "MerchantID" => "103882281400002",
        "EnableLog" => "1",
        "LogPath" => storage_path("app/abcpay/log"),
        "MerchantKeyStoreType" => "0",
        "MerchantCertFile" => storage_path("app/abcpay/certs/103882281400002.pfx"),
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
    ]
];