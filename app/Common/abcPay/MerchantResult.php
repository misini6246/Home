<?php
define('IN_ECS', true);
require_once ('./ebusclient/Result.php');
require( '../includes/init.php');
if(IS_ABC==1){//生产环境
    $url = 'http://www.hezongyy.com';
}
elseif(IS_ABC==2){
    $url = 'http://192.168.0.139';
}
else{
    $url = 'http://images.hezongyy.com/hzygy';
}
//1、取得MSG参数，并利用此参数值生成验证结果对象
$tResult = new Result();
$tResponse = $tResult->init($_POST['MSG']);
//print_r($tResponse);die;
if ($tResponse->isSuccess()) {
    $sql = "select oi.order_sn,oi.order_amount,oi.order_id from ecs_order_info as oi LEFT JOIN ecs_online_pay as op on op.order_id=oi.order_id where op.order_sn='{$tResponse->getValue('OrderNo')}'";
    $order_sn = $GLOBALS['db']->getRow($sql);
    $time = date('YmdHis',strtotime($tResponse->getValue("HostDate")." ".$tResponse->getValue("HostTime")));
    //print_r($time);
    if($tResponse->getValue("Amount")==$order_sn['order_amount']) {
        order_paid2("{$order_sn['order_sn']}", "{$tResponse->getValue('OrderNo')}", 0, PS_PAYED, $time, "Success!农行交易号:{$tResponse->getValue('OrderNo')}");
    }
	//2、、支付成功
//	print ("TrxType         = [" . $tResponse->getValue("TrxType") . "]<br/>");
//	print ("OrderNo         = [" . $tResponse->getValue("OrderNo") . "]<br/>");
//	print ("Amount          = [" . $tResponse->getValue("Amount") . "]<br/>");
//	print ("BatchNo         = [" . $tResponse->getValue("BatchNo") . "]<br/>");
//	print ("VoucherNo       = [" . $tResponse->getValue("VoucherNo") . "]<br/>");
//	print ("HostDate        = [" . $tResponse->getValue("HostDate") . "]<br/>");
//	print ("HostTime        = [" . $tResponse->getValue("HostTime") . "]<br/>");
//	print ("MerchantRemarks = [" . $tResponse->getValue("MerchantRemarks") . "]<br/>");
//	print ("PayType         = [" . $tResponse->getValue("PayType") . "]<br/>");
//	print ("NotifyType      = [" . $tResponse->getValue("NotifyType") . "]<br/>");
    echo "<script language='javascript'>";
    echo "window.location.href='".$url."/user.php?act=order_detail&order_id={$order_sn['order_id']}'";
    echo "</script>";
} else {
	//3、失败
    echo "<script language='javascript'>";
    echo "window.location.href='{$url}'";
    echo "</script>";
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