<?php
define('IN_ECS', true);
require_once ('../abcPay/ebusclient/QueryOrderRequest.php');
//1、生成交易查询对象
$payTypeID = ($_POST['PayTypeID']);
$queryType = ($_POST['QueryType']);
function abcPay_search($order_sn,$orderNo,$amount){
    $queryType = '0';
    if ($queryType === "0") {
        $QueryType = "false";
    } else
        if ($queryType === "1") {
            $QueryType = "true";
        }
//2、传送请求
    $tRequest = new QueryOrderRequest();
    $tRequest->request["PayTypeID"] = 'ImmediatePay'; //设定交易类型
    $tRequest->request["OrderNo"] = $orderNo; //设定订单编号 （必要信息）
    $tRequest->request["QueryDetail"] = $QueryType; //设定查询方式

    $tResponse = $tRequest->postRequest();
//3、支付请求提交成功，返回结果信息
    if ($tResponse->isSuccess()) {
//	print ("<br>Success!!!" . "</br>");
//	print ("ReturnCode   = [" . $tResponse->getReturnCode() . "]</br>");
//	print ("ReturnMsg   = [" . $tResponse->getErrorMessage() . "]</br>");
        //4、获取结果信息
        $orderInfo = $tResponse->GetValue("Order");
        if ($orderInfo == null) {
            return 0;
        } else {

            //1、还原经过base64编码的信息
            $orderDetail = base64_decode($orderInfo);
            $orderDetail = iconv("GB2312", "UTF-8", $orderDetail);
            $detail = new Json($orderDetail);
            $time = date('YmdHis',strtotime($tResponse->getValue("HostDate")." ".$tResponse->getValue("HostTime")));
            //print_r($time);
            //print_r($detail->GetValue("Status")=='04');
            if($detail->GetValue("OrderAmount")==$amount&&$detail->GetValue("Status")=='04') {
                order_paid2("{$order_sn}", "{$detail->getValue('OrderNo')}", 0, PS_PAYED, $time, "Success!农行交易号:{$detail->getValue('OrderNo')}");
                return 1;
            }else{
                return 2;
            }
        }
    }else{
        return $tResponse->getReturnCode();
    }
}
/**
 * 修改订单的支付状态（2014-5-8为分单合并支付修改版）
 *
 * @access  public
 * @param   string  $log_id     支付编号
 * @param   integer $pay_status 状态
 * @param   string  $note       备注
 * @return  void
 */
function order_paid2($order_sn, $qid, $log_id, $pay_status = PS_PAYED, $trace_time, $note = '')
{
    /* 取得所有未付款的订单 */
    /*$sql = 'SELECT *' . ' FROM ' . $GLOBALS['ecs']->table('order_info') .
                       " WHERE pay_status != 2 AND order_sn LIKE '{$order_sn}%'";*/
    $sql = 'SELECT *' . ' FROM ' . $GLOBALS['ecs']->table('order_info') .
        " WHERE pay_status != 2 AND order_sn = '{$order_sn}'";
    $order_data = $GLOBALS['db']->getRow($sql);
    $order_id = $order_data['order_id'];
    $order_sn = $order_data['order_sn'];
    //print_r($order_data);exit;
    //修改支付记录信息
    //修改订单支付状态
    if(!empty($order_data)) {
        //foreach($order_data as $k => $v) {
        /* 修改订单状态为已付款 */
        $sql = 'UPDATE ' . $GLOBALS['ecs']->table('order_info') .
            " SET order_status = '" . OS_CONFIRMED . "', " .
            " confirm_time = '" . gmtime() . "', " .
            " pay_status = '$pay_status', " .
            " pay_time = '".gmtime()."', " .
            " qid = '$qid', " .
            " money_paid = order_amount," .
            " o_paid = order_amount," .
            " order_amount = 0,".
            " pay_id = 5,".
            " pay_name = '农行在线支付',".
            " trace_time = '$trace_time'".
            "WHERE order_id = {$order_id} ";
        $GLOBALS['db']->query($sql);

        /* 记录订单操作记录 */
        order_action($order_sn, OS_CONFIRMED, SS_UNSHIPPED, $pay_status, $note, $GLOBALS['_LANG']['buyer']);

        /* 修改此次支付操作的状态为已付款 */
        $sql = 'UPDATE ' . $GLOBALS['ecs']->table('pay_log') .
            " SET is_paid = '1' WHERE order_id = {$order_id} ";
        $GLOBALS['db']->query($sql);

        //sync_orderinfo_to_erp2($order_data) ;
        //DS_order_hz($v['order_sn'],$v['add_time'],'已付款','药易购',$order['user']['msn'],$v['consignee'],$v['tel'],'',$v['shipping_name'],$v['wl_dh'],$add_dz,'',$order['user']['wldwid']);
    }
}
?>