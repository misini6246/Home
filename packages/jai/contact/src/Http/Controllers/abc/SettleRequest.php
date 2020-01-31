<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/12
 * Time: 14:15
 */

namespace Jai\Contact\Http\Controllers\abc;

use Jai\Contact\Http\Controllers\abc\TrxRequest;
use Jai\Contact\Http\Controllers\abc\Json;
use Jai\Contact\Http\Controllers\abc\IChannelType;
use Jai\Contact\Http\Controllers\abc\IPaymentType;
use Jai\Contact\Http\Controllers\abc\INotifyType;
use Jai\Contact\Http\Controllers\abc\DataVerifier;
use Jai\Contact\Http\Controllers\abc\ILength;
use Jai\Contact\Http\Controllers\abc\IPayTypeID;
use Jai\Contact\Http\Controllers\abc\IInstallmentmark;
use Jai\Contact\Http\Controllers\abc\ICommodityType;
class SettleRequest extends TrxRequest {
    public $request = array (
        "TrxType" => IFunctionID :: TRX_TYPE_SETTLE,
        "SettleDate" => "",
        "ZIP" => ""
    );
    function __construct() {
    }

    protected function getRequestMessage() {
        Json :: arrayRecursive($this->request, "urlencode", false);
        $tMessage = json_encode($this->request);
        $tMessage = urldecode($tMessage);
        return $tMessage;
    }

    /// 支付请求信息是否合法
    protected function checkRequest() {
        if (!DataVerifier :: isValidDate($this->request["SettleDate"]))
            throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "对账日期不合法！");
        if (!($this->request["ZIP"] === "1") && !($this->request["ZIP"] === "0"))
            throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "压缩标识不合法！");

    }
}