<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/29
 * Time: 11:19
 */

namespace Jai\Contact\Http\Controllers\abc;

use Jai\Contact\Http\Controllers\abc\LogWriter;
use Jai\Contact\Http\Controllers\abc\MerchantConfig;
use Jai\Contact\Http\Controllers\abc\TrxException;
use Jai\Contact\Http\Controllers\abc\XMLDocument;
use Jai\Contact\Http\Controllers\abc\TrxResponse;

class Result extends TrxException {
    private $iLogWriter = null;
    function __construct() {
    }
    public function init($aMessage) {
        $this->iLogWriter = new LogWriter();
        try {
            $this->iLogWriter->logNewLine("TrustPayClient V3.0.0 交易开始==========================");
            $this->iLogWriter->logNewLine("接收到的结果通知：\n[" . $aMessage ."]");
            //1、还原经过base64编码的信息
            $tMessage = base64_decode($aMessage);


            $this->iLogWriter->logNewLine("经过Base64解码后的结果通知：\n[" . iconv("GB2312","UTF-8",$tMessage) ."]");
            //2、取得经过签名验证的报文
            $this->iLogWriter->logNewLine("验证支付结果通知的签名：");
            MerchantConfig :: verifySignXML($tMessage);
            $this->iLogWriter->logNewLine("验证通过！\n");
            $tResponse = new TrxResponse($tMessage);

        } catch (TrxException $e) {
            $tResponse = new TrxResponse();
            if ($this->iLogWriter != null) {
                $this->iLogWriter->logNewLine('错误代码：[' . $e->getCode() . ']    错误信息：[' .
                    $e->getMessage() . " - " . $e->getDetailMessage() . ']');
            }
            $tResponse->initWithCodeMsg($e->getCode(), $e->getMessage());
        } catch (Exception $e) {
            $tResponse = new TrxResponse($tMessage);
            if ($this->iLogWriter != null) {
                $this->iLogWriter->logNewLine('错误代码：[' . TrxException :: TRX_EXC_CODE_199 . ']    错误信息：[' .
                    $e->getMessage() . ']');
            }
            $tResponse->initWithCodeMsg(TrxException :: TRX_EXC_CODE_199, $e->getMessage());
        }
        if ($this->iLogWriter != null) {
            $this->iLogWriter->logNewLine("交易结束==================================================\n\n\n\n");
            $this->iLogWriter->closeWriter(MerchantConfig :: getTrxLogFile());
        }
        return $tResponse;
    }
}