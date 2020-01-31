<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/12
 * Time: 14:04
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

class QueryTrnxRecords extends TrxRequest {
    public $request = array (
        "TrxType" => IFunctionID :: TRX_TYPE_QUERYTRNXRECORDS,
        "SettleDate" => "",
        "SettleStartHour" => "",
        "SettleEndHour" => "",
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
            throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "交易流水查询
			日期不合法！");
        if (!is_numeric($this->request["SettleStartHour"]) || !is_numeric($this->request["SettleEndHour"]))
            throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "查询起止时间不合法，必输输入0-23之间的有效时间段，且截止时间不小于开始时间！");
        $startLen = strlen($this->request["SettleStartHour"]);
        $endLen = strlen($this->request["SettleEndHour"]);
        $startHour = $startLen < 2 ? "0" . $this->request["SettleStartHour"] : $this->request["SettleStartHour"];
        $endHour = $endLen < 2 ? "0" + $this->request["SettleEndHour"] : $this->request["SettleEndHour"];
        if ($startHour < 0 || $startHour > 23 || $endHour < 0 || $endHour > 23 || $startHour > $endHour) {
            throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "对账起止时间不合法，必须输入0-23之间的有效时间段，且截止时间不小于开始时间！");
        }

        if (!($this->request["ZIP"] === "1") && !($this->request["ZIP"] === "0")) {
            throw new TrxException(TrxException :: TRX_EXC_CODE_1101, TrxException :: TRX_EXC_MSG_1101, "压缩标识不合法！");
        }
    }
}