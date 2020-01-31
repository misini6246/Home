<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/28
 * Time: 16:15
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
use Jai\Contact\Http\Controllers\abc\IIsBreakAccountType;

class QueryOrderRequest extends TrxRequest {
    public $request = array (
        "TrxType" => IFunctionID :: TRX_TYPE_QUERY,
        "PayTypeID" => "",
        "OrderNo" => "",
        "QueryDetail" => ""
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
        if (!DataVerifier :: isValidString($this->request["OrderNo"], ILength :: ORDERID_LEN))
            throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1100, "未设定交易编号！");
        if (!($this->request["QueryDetail"] === IQueryType :: QUERY_TYPE_STATUS) && !($this->request["QueryDetail"] === IQueryType :: QUERY_TYPE_DETAIL))
            throw new TrxException(TrxException :: TRX_EXC_CODE_1100, TrxException :: TRX_EXC_MSG_1100, "QueryType设定非法！");
    }
}