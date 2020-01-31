<?php

define('IN_ECS', true);
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
//print_r($_SESSION);die;
//echo(($_POST['CommodityType']));
//echo(($_POST['PayTypeID']));
$user_id = $_SESSION['user_id'];//会员id
$order_id = $_REQUEST['order_id'];//订单编号
$sql = "select order_sn,order_amount,user_id,consignee from ecs_order_info where user_id='{$user_id}' and order_id='{$order_id}'";
$order = $GLOBALS['db']->getRow($sql);
//print_r($_SESSION);die;
$orderNo = getOrderSn();
$update_time = time();
$sql = "select id,order_sn from ecs_online_pay where order_id='{$order_id}'";
$result = $GLOBALS['db']->getRow($sql);
$status = 1;
if(empty($result['id'])) {
    $status = 2;
    $sql = "insert into ecs_online_pay (order_id,update_time,order_sn) VALUES ('{$order_id}','{$update_time}','{$orderNo}')";
}else{
    if($status!=2) {
//        if($_SESSION['user_id']==3442) {
//            die;
//        }
        require_once('./MerchantQueryOrder.php');
        $type = abcPay_search($order['order_sn'], $result['order_sn'], $order['order_amount']);
    }else{
        $type = 2;
    }
    if($type==2307){
        $sql = "update ecs_online_pay set order_sn='{$orderNo}' where id='{$result['id']}'";
    }elseif($type==2){
        $sql = "update ecs_online_pay set order_sn='{$orderNo}' where id='{$result['id']}'";
    }elseif($type==1){
        echo "订单已支付";
        die;
    }else{
        echo "请求出错";
        die;
    }
}
if($GLOBALS['db']->query($sql)) {
    require_once ('./ebusclient/PaymentRequest.php');
    $tRequest = new PaymentRequest();
    $tRequest->order["PayTypeID"] = "ImmediatePay"; //设定交易类型
    $tRequest->order["OrderNo"] = $orderNo; //设定订单编号
    $tRequest->order["ExpiredDate"] = 30; //设定订单保存时间
    $tRequest->order["OrderAmount"] = $order['order_amount']; //设定交易金额
    $tRequest->order["Fee"] = 0; //设定手续费金额
    $tRequest->order["CurrencyCode"] = '156'; //设定交易币种
    $tRequest->order["ReceiverAddress"] = ''; //收货地址
    $tRequest->order["InstallmentMark"] = '0'; //分期标识
    $installmentMerk = '0';
    $paytypeID = 'ImmediatePay';
    if (strcmp($installmentMerk, "1") == 0 && strcmp($paytypeID, "DividedPay") == 0) {
        $tRequest->order["InstallmentCode"] = ($_POST['InstallmentCode']); //设定分期代码
        $tRequest->order["InstallmentNum"] = ($_POST['InstallmentNum']); //设定分期期数
    }
    $tRequest->order["BuyIP"] = ''; //IP
    $tRequest->order["OrderDesc"] = $order['order_sn']; //设定订单说明
    $tRequest->order["OrderURL"] = ''; //设定订单地址
    $tRequest->order["OrderDate"] = date('Y/m/d'); //设定订单日期 （必要信息 - YYYY/MM/DD）
    $tRequest->order["OrderTime"] = date('H:i:s'); //设定订单时间 （必要信息 - HH:MM:SS）
    $tRequest->order["orderTimeoutDate"] = ""; //设定订单有效期
    $tRequest->order["CommodityType"] = '0202'; //设置商品种类

//2、订单明细

    $orderitem = array();
    $orderitem["SubMerName"] = $order['consignee']; //设定二级商户名称 用收货人代替
    $orderitem["SubMerId"] = $order['user_id']; //设定二级商户代码
    $orderitem["SubMerMCC"] = ""; //设定二级商户MCC码
    $orderitem["SubMerchantRemarks"] = ""; //二级商户备注项
    $orderitem["ProductID"] = $order['order_id']; //商品代码，预留字段 用order_id 代替
    $orderitem["ProductName"] = "网上订单{$order['order_sn']}"; //商品名称
    $orderitem["UnitPrice"] = $order['order_amount']; //商品总价
    $orderitem["Qty"] = "1"; //商品数量
    $orderitem["ProductRemarks"] = "商城订单编号{$order['order_sn']}"; //商品备注项
    $orderitem["ProductType"] = ""; //商品类型
    $orderitem["ProductDiscount"] = "1"; //商品折扣
    $orderitem["ProductExpiredDate"] = "10"; //商品有效期
    $tRequest->orderitems[0] = $orderitem;

//$orderitem = array ();
//$orderitem["SubMerName"] = "测试二级商户2"; //设定二级商户名称
//$orderitem["SubMerId"] = "12345"; //设定二级商户代码
//$orderitem["SubMerMCC"] = "0000"; //设定二级商户MCC码
//$orderitem["SubMerchantRemarks"] = "测试2"; //二级商户备注项
//$orderitem["ProductID"] = "IP000001"; //商品代码，预留字段
//$orderitem["ProductName"] = "测试"; //商品名称
//$orderitem["UnitPrice"] = "0"; //商品总价
//$orderitem["Qty"] = "1"; //商品数量
//$orderitem["ProductRemarks"] = "测试商品2"; //商品备注项
//$orderitem["ProductType"] = "充值类2"; //商品类型
//$orderitem["ProductDiscount"] = "1"; //商品折扣
//$orderitem["ProductExpiredDate"] = "10"; //商品有效期
//$tRequest->orderitems[1] = $orderitem;

//3、生成支付请求对象
    $tRequest->request["PaymentType"] = 'A'; //设定支付类型
    $tRequest->request["PaymentLinkType"] = '1'; //设定支付接入方式
    if ($_POST['PaymentType'] === "6" && $_POST['PaymentLinkType'] === "2") {
        $tRequest->request["UnionPayLinkType"] = ($_POST['UnionPayLinkType']); //当支付类型为6，支付接入方式为2的条件满足时，需要设置银联跨行移动支付接入方式
    }
    $tRequest->request["ReceiveAccount"] = ($_POST['ReceiveAccount']); //设定收款方账号
    $tRequest->request["ReceiveAccName"] = ($_POST['ReceiveAccName']); //设定收款方户名
    $tRequest->request["NotifyType"] = '1'; //设定通知方式
    $tRequest->request["ResultNotifyURL"] = $url.'/abcPay/MerchantResult.php'; //设定通知URL地址
    $tRequest->request["MerchantRemarks"] = "商城订单编号{$order['order_sn']}"; //设定附言
    $tRequest->request["IsBreakAccount"] = '0'; //设定交易是否分账
    $tRequest->request["SplitAccTemplate"] = ''; //分账模版编号
//print_r($tRequest);die;
    $tResponse = $tRequest->postRequest();
//支持多商户配置
//$tResponse = $tRequest->extendPostRequest(2);
    if ($tResponse->isSuccess()) {
        $PaymentURL = $tResponse->GetValue("PaymentURL");
        echo "<script language='javascript'>";
        echo "window.location.href='$PaymentURL'";
        echo "</script>";
    } else {
        echo "<script language='javascript'>";
        echo "window.location.href='{$url}'";
        echo "</script>";
    }
}
/**
 * 得到新订单号
 * @return  string
 */
function getOrderSn()
{
    /*
     * 获取订单号，确保订单号唯一
     */
    $is_order_exist = true ; //标识，默认订单号已经存在
    $order_sn = '' ;
    do {
        $order_sn = date('YmdHis', time()).mt_rand(100, 999) ;
        $sql = "select count(*) from ecs_online_pay where order_sn='{$order_sn}'";
        $oid = $GLOBALS['db']->getOne($sql);
        if(empty($oid)) {
            //如果计数为0
            $is_order_exist = false ;
        }
    } while($is_order_exist) ;
    /* 选择一个随机的方案 */
    //mt_srand((double) microtime() * 1000000);
    //return date('YmdHis', time()).mt_rand(10, 99) ;
    return $order_sn ;
}
?>


