<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/31
 * Time: 14:15
 */

namespace Jai\Contact\Http\Controllers\pay;

use App\OrderInfo;
use Illuminate\Support\Facades\DB;
use Jai\Contact\Http\Controllers\pay\quickpay_service;
use Jai\Contact\Http\Controllers\pay\quickpay_conf;
use Jai\Contact\Http\Controllers\UnionPayController;

class upop
{
    /**
     * 生成支付代码
     * @param   array   $order  订单信息
     * @param   array   $payment    支付方式信息
     */

    static $api_url = array(
        0  => array(
            'front_pay_url' => 'http://58.246.226.99/UpopWeb/api/Pay.action',
            'back_pay_url'  => 'http://58.246.226.99/UpopWeb/api/BSPay.action',
            'query_url'     => 'http://58.246.226.99/UpopWeb/api/Query.action',
        ),
        1  => array(
            'front_pay_url' => 'https://www.epay.lxdns.com/UpopWeb/api/Pay.action',
            'back_pay_url'  => 'https://www.epay.lxdns.com/UpopWeb/api/BSPay.action',
            'query_url'     => 'https://www.epay.lxdns.com/UpopWeb/api/Query.action',
        ),
        2  => array(
            'front_pay_url' => 'https://unionpaysecure.com/api/Pay.action',
            'back_pay_url'  => 'https://besvr.unionpaysecure.com/api/BSPay.action',
            'query_url'     => 'https://query.unionpaysecure.com/api/Query.action',
        ),
    );
    function get_code($order, $payment)
    {
        // 初始化变量
        $upop_evn		= $payment['upop_evn'];		// 环境

        // 商户名称
        quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

        if ($upop_evn == '2') // 生产环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
        }
        else if ($upop_evn == '1') // PM环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
        }
        else if ($upop_evn == '0') // 开发联调环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_test'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
        }

        mt_srand(quickpay_service::make_seed());

        $param = array();

        $param['transType']             = quickpay_conf::CONSUME;  // 交易类型，CONSUME or PRE_AUTH
        $param['orderAmount']           = $order['order_amount'] * 100 ;  // 交易金额 转化为分
        //$param['orderNumber']           = $order['order_sn'] . '-' . $this->_formatSN($order['log_id']);		   // 订单号，必须唯一
        $param['orderNumber']           = $order['order_sn'];
        $param['orderTime']             = date('YmdHis');		   // 交易时间, YYYYmmhhddHHMMSS
        $param['orderCurrency']         = quickpay_conf::CURRENCY_CNY;  //交易币种，CURRENCY_CNY=>人民币

        $param['customerIp']            = '127.0.0.1';  // 用户IP
        //$param['customerIp']            = $_SERVER['REMOTE_ADDR'];  // 用户IP
        //$param['frontEndUrl']           = return_url(basename(__FILE__, '.php'));   // 前台回调URL
        //$param['frontEndUrl']           = $GLOBALS['ecs']->url() . 'user.php?act=order_list' ;
        $param['frontEndUrl']           = route('union.result');
        $param['backEndUrl']            = route('union.result');    // 后台回调URL

        /* 可填空字段
           $param['commodityUrl']          = "http://www.example.com/product?name=商品";  //商品URL
           $param['commodityName']         = '商品名称';   //商品名称
           $param['commodityUnitPrice']    = 11000;        //商品单价
           $param['commodityQuantity']     = 1;            //商品数量
        */


        $button = "<input class='J_payonline' type='submit' value='银联支付' onclick='toSearch($(this))' searchUrl='".route('union.search',['id'=>$order['order_id']])."'/>";
        $pay_service = new quickpay_service($param, quickpay_conf::FRONT_PAY);
        $html = $pay_service->create_html($button);

        return $html;
    }
    function get_code_zq($order, $payment)
    {
        // 初始化变量
        $upop_evn		= $payment['upop_evn'];		// 环境

        // 商户名称
        quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

        if ($upop_evn == '2') // 生产环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
        }
        else if ($upop_evn == '1') // PM环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
        }
        else if ($upop_evn == '0') // 开发联调环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_test'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
        }

        mt_srand(quickpay_service::make_seed());

        $param = array();

        $param['transType']             = quickpay_conf::CONSUME;  // 交易类型，CONSUME or PRE_AUTH
        $param['orderAmount']           = $order['order_amount'] * 100 ;  // 交易金额 转化为分
        //$param['orderNumber']           = $order['order_sn'] . '-' . $this->_formatSN($order['log_id']);		   // 订单号，必须唯一
        $param['orderNumber']           = $order['order_sn'];
        $param['orderTime']             = date('YmdHis');		   // 交易时间, YYYYmmhhddHHMMSS
        $param['orderCurrency']         = quickpay_conf::CURRENCY_CNY;  //交易币种，CURRENCY_CNY=>人民币

        $param['customerIp']            = '127.0.0.1';  // 用户IP
        //$param['customerIp']            = $_SERVER['REMOTE_ADDR'];  // 用户IP
        //$param['frontEndUrl']           = return_url(basename(__FILE__, '.php'));   // 前台回调URL
        //$param['frontEndUrl']           = $GLOBALS['ecs']->url() . 'user.php?act=order_list' ;
        $param['frontEndUrl']           = route('union.result_zq');
        $param['backEndUrl']            = route('union.result_zq');    // 后台回调URL

        /* 可填空字段
           $param['commodityUrl']          = "http://www.example.com/product?name=商品";  //商品URL
           $param['commodityName']         = '商品名称';   //商品名称
           $param['commodityUnitPrice']    = 11000;        //商品单价
           $param['commodityQuantity']     = 1;            //商品数量
        */


        $button = "<input class='J_payonline' type='submit' value='银联支付' onclick='toSearch($(this))' searchUrl='".route('union.search_zq',['id'=>$order['order_id']])."'/>";
        $pay_service = new quickpay_service($param, quickpay_conf::FRONT_PAY);
        $html = $pay_service->create_html($button);

        return $html;
    }
    function get_code_zq_ywy($order, $payment)
    {
        // 初始化变量
        $upop_evn		= $payment['upop_evn'];		// 环境

        // 商户名称
        quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

        if ($upop_evn == '2') // 生产环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
        }
        else if ($upop_evn == '1') // PM环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
        }
        else if ($upop_evn == '0') // 开发联调环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_test'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
        }

        mt_srand(quickpay_service::make_seed());

        $param = array();

        $param['transType']             = quickpay_conf::CONSUME;  // 交易类型，CONSUME or PRE_AUTH
        $param['orderAmount']           = $order['order_amount'] * 100 ;  // 交易金额 转化为分
        //$param['orderNumber']           = $order['order_sn'] . '-' . $this->_formatSN($order['log_id']);		   // 订单号，必须唯一
        $param['orderNumber']           = $order['order_sn'];
        $param['orderTime']             = date('YmdHis');		   // 交易时间, YYYYmmhhddHHMMSS
        $param['orderCurrency']         = quickpay_conf::CURRENCY_CNY;  //交易币种，CURRENCY_CNY=>人民币

        $param['customerIp']            = '127.0.0.1';  // 用户IP
        //$param['customerIp']            = $_SERVER['REMOTE_ADDR'];  // 用户IP
        //$param['frontEndUrl']           = return_url(basename(__FILE__, '.php'));   // 前台回调URL
        //$param['frontEndUrl']           = $GLOBALS['ecs']->url() . 'user.php?act=order_list' ;
        $param['frontEndUrl']           = route('union.result_zq_ywy');
        $param['backEndUrl']            = route('union.result_zq_ywy');    // 后台回调URL

        /* 可填空字段
           $param['commodityUrl']          = "http://www.example.com/product?name=商品";  //商品URL
           $param['commodityName']         = '商品名称';   //商品名称
           $param['commodityUnitPrice']    = 11000;        //商品单价
           $param['commodityQuantity']     = 1;            //商品数量
        */


        $button = "<input class='J_payonline' type='submit' value='银联支付' onclick='toSearch($(this))' searchUrl='".route('union.search_zq_ywy',['id'=>$order['order_id']])."'/>";
        $pay_service = new quickpay_service($param, quickpay_conf::FRONT_PAY);
        $html = $pay_service->create_html($button);

        return $html;
    }
    function get_code_zq_sy($order, $payment)
    {
        // 初始化变量
        $upop_evn		= $payment['upop_evn'];		// 环境

        // 商户名称
        quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

        if ($upop_evn == '2') // 生产环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
        }
        else if ($upop_evn == '1') // PM环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
        }
        else if ($upop_evn == '0') // 开发联调环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_test'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
        }

        mt_srand(quickpay_service::make_seed());

        $param = array();

        $param['transType']             = quickpay_conf::CONSUME;  // 交易类型，CONSUME or PRE_AUTH
        $param['orderAmount']           = $order['order_amount'] * 100 ;  // 交易金额 转化为分
        //$param['orderNumber']           = $order['order_sn'] . '-' . $this->_formatSN($order['log_id']);		   // 订单号，必须唯一
        $param['orderNumber']           = $order['order_sn'];
        $param['orderTime']             = date('YmdHis');		   // 交易时间, YYYYmmhhddHHMMSS
        $param['orderCurrency']         = quickpay_conf::CURRENCY_CNY;  //交易币种，CURRENCY_CNY=>人民币

        $param['customerIp']            = '127.0.0.1';  // 用户IP
        //$param['customerIp']            = $_SERVER['REMOTE_ADDR'];  // 用户IP
        //$param['frontEndUrl']           = return_url(basename(__FILE__, '.php'));   // 前台回调URL
        //$param['frontEndUrl']           = $GLOBALS['ecs']->url() . 'user.php?act=order_list' ;
        $param['frontEndUrl']           = route('union.result_zq_sy');
        $param['backEndUrl']            = route('union.result_zq_sy');    // 后台回调URL

        /* 可填空字段
           $param['commodityUrl']          = "http://www.example.com/product?name=商品";  //商品URL
           $param['commodityName']         = '商品名称';   //商品名称
           $param['commodityUnitPrice']    = 11000;        //商品单价
           $param['commodityQuantity']     = 1;            //商品数量
        */


        $button = "<input class='J_payonline' type='submit' value='银联支付' onclick='toSearch($(this))' searchUrl='".route('union.search_zq_sy',['id'=>$order['order_id']])."'/>";
        $pay_service = new quickpay_service($param, quickpay_conf::FRONT_PAY);
        $html = $pay_service->create_html($button);

        return $html;
    }
    function get_code_flow($order, $payment)
    {
        // 初始化变量
        $upop_evn		= $payment['upop_evn'];		// 环境

        // 商户名称
        quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

        if ($upop_evn == '2') // 生产环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
        }
        else if ($upop_evn == '1') // PM环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
        }
        else if ($upop_evn == '0') // 开发联调环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_test'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
        }

        mt_srand(quickpay_service::make_seed());

        $param = array();

        $param['transType']             = quickpay_conf::CONSUME;  // 交易类型，CONSUME or PRE_AUTH
        $param['orderAmount']           = $order->order_amount * 100 ;  // 交易金额 转化为分
        //$param['orderNumber']           = $order['order_sn'] . '-' . $this->_formatSN($order['log_id']);		   // 订单号，必须唯一
        $param['orderNumber']           = $order->order_sn;
        $param['orderTime']             = date('YmdHis');		   // 交易时间, YYYYmmhhddHHMMSS
        $param['orderCurrency']         = quickpay_conf::CURRENCY_CNY;  //交易币种，CURRENCY_CNY=>人民币

        $param['customerIp']            = '127.0.0.1';  // 用户IP
        //$param['customerIp']            = $_SERVER['REMOTE_ADDR'];  // 用户IP
        //$param['frontEndUrl']           = return_url(basename(__FILE__, '.php'));   // 前台回调URL
        //$param['frontEndUrl']           = $GLOBALS['ecs']->url() . 'user.php?act=order_list' ;
        $param['frontEndUrl']           = route('union.result');
        $param['backEndUrl']            = route('union.result');    // 后台回调URL

        /* 可填空字段
           $param['commodityUrl']          = "http://www.example.com/product?name=商品";  //商品URL
           $param['commodityName']         = '商品名称';   //商品名称
           $param['commodityUnitPrice']    = 11000;        //商品单价
           $param['commodityQuantity']     = 1;            //商品数量
        */


        $button = "<input id='J_payonline' type='submit' value='立即支付' onclick='toSearch($(this))' searchUrl='".route('union.search',['id'=>$order['order_id']])."'/>";
        $pay_service = new quickpay_service($param, quickpay_conf::FRONT_PAY);
        $html = $pay_service->create_html_flow($button);

        return $html;
    }
    /**
     * 响应操作
     */
    function respond()
    {
        $payment        = get_payment('upop');

        // 初始化变量
        $upop_evn		= $payment['upop_evn'];		// 环境

        // 商户名称
        quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

        if ($upop_evn == '2') // 生产环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
        }
        else if ($upop_evn == '1') // PM环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
        }
        else if ($upop_evn == '0') // 开发联调环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_test'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
        }

        // 2015-6-12 如果未收到回应信息。
        //if (empty($_POST))
        //{
        //file_put_contents('./data-upop.txt', 'respCode'.date('YmdHis').PHP_EOL, FILE_APPEND);
        //}

        try {
            $response = new quickpay_service($_POST, quickpay_conf::RESPONSE);
            if ($response->get('respCode') != quickpay_service::RESP_SUCCESS)
            {
                $err = sprintf("Error: %d => %s", $response->get('respCode'), $response->get('respMsg'));
                throw new Exception($err);
            }

            $arr_ret = $response->get_args();

            // 2015-6-12 如果未收到回应信息。
            //if (empty($arr_ret))
            //{
            //file_put_contents('./data-upop.txt', 'data_null'.date('YmdHis').PHP_EOL, FILE_APPEND);
            //}

            /*if(!strpos($arr_ret['orderNumber'], '-')) return false;
            $order_sn_arr = explode('-', $arr_ret['orderNumber']);

            $order_sn		= $order_sn_arr[0];
            $pay_id = (int)$order_sn_arr[1];*/

            $order_sn		= $arr_ret['orderNumber'];
            $pay_id = '';

            $payment_amount = (int)$arr_ret['settleAmount'];

            //交易时间
            $trace_time = date("Y",gmtime()).$arr_ret['traceTime'];

            // 检查商户账号是否一致。
            if (quickpay_conf::$pay_params['merId'] != $arr_ret['merId'])
            {
                file_put_contents('./data.txt', 'quickpay_conf') ;
                return false;
            }

            // 检查价格是否一致。
            //$sql = "SELECT p.order_amount FROM " . $GLOBALS['ecs']->table('pay_log') . " AS p LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " AS o ON p.order_id = o.order_id WHERE o.order_sn = '"
            //. $order_sn . "'";
            /* 2014-5-8 */
            /* 在线预订的订单编号 */
            if(strlen($order_sn) == 14){
                $sql = "SELECT SUM(order_amount) as order_amount,SUM(money_paid) as money_paid FROM " . $GLOBALS['ecs']->table('online_order') . " WHERE order_sn LIKE '" . $order_sn . "%'";
            }
            /* 正常购物的订单编号 */
            if(strlen($order_sn) == 13 || strlen($order_sn) == 15){  //2015-7-31
                $sql = "SELECT SUM(order_amount) as order_amount,SUM(money_paid) as money_paid FROM " . $GLOBALS['ecs']->table('order_info') . " WHERE	order_sn = '" . $order_sn . "'";  //2015-7-31
            }

            $resdata = $GLOBALS['db']->getRow($sql) ;

            $order_amount = $resdata['order_amount'] * 100;
            $surplus = $resdata['surplus'] * 100;
            $money_paid = $resdata['money_paid'] * 100;

            if ($order_amount != $payment_amount){
                if($money_paid != $payment_amount) {
                    return false ;
                }
            }

            // 如果未支付成功。
            if ($arr_ret['respCode'] != '00')
            {
                file_put_contents('./data.txt', 'respCode'.date('YmdHis').PHP_EOL, FILE_APPEND) ;
                return false;
            }

            $action_note = $arr_ret['respCode'] . ':'
                . $arr_ret['respMsg']
                . $GLOBALS['_LANG']['upop_txn_id'] . ':'
                . $arr_ret['qid'];

            // 完成订单。
            /* 2014-5-8 */
            //order_paid($pay_id, PS_PAYED, $action_note);

            /* 在线预订的订单编号 */
            if(strlen($order_sn) == 14){
                order_paid3($order_sn, $arr_ret['qid'], $pay_id, PS_PAYED, $action_note);
            }

            /* 正常购物的订单编号 */
            if(strlen($order_sn) == 13 || strlen($order_sn) == 15){ //2015-7-31
                order_paid2($order_sn, $arr_ret['qid'], $pay_id, PS_PAYED, $trace_time, $action_note);
            }

            //file_put_contents('./data.txt', 'now111') ;
            //告诉用户交易完成

            return 'ok';
        }
        catch(Exception $exp)
        {
            return false;
        }
    }

    /**
     * 主动查询  2015-6-15
     */
    function query($order, $payment)
    {
        // 初始化变量
        $upop_evn		= $payment['upop_evn'];		// 环境

        // 商户名称
        quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

        if ($upop_evn == '2') // 生产环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
        }
        else if ($upop_evn == '1') // PM环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
        }
        else if ($upop_evn == '0') // 开发联调环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_test'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
        }

        mt_srand(quickpay_service::make_seed());

        $params = array();

        //需要填入的部分
        $params['transType']     = quickpay_conf::CONSUME;   //交易类型
        $params['orderNumber']   = $order['order_sn']; //订单号
        $orderTime = date('YmdHis',$order['add_time']);
        $params['orderTime']     = $orderTime;   //订单时间

        //提交查询
        $query  = new quickpay_service($params, quickpay_conf::QUERY);
        $ret    = $query->post();

        //返回查询结果
        $response = new quickpay_service($ret, quickpay_conf::RESPONSE);
        //查询成功
        $msg = array();
        if ($response->get('respCode') == quickpay_service::RESP_SUCCESS && $response->get('queryResult') == quickpay_service::QUERY_SUCCESS) {
            //后续处理
            $arr_ret = $response->get_args();
            //交易时间
            $trace_time = date("Y",time()).$arr_ret['traceTime'];

            $pay_id = '';
            $order_amount = $order['order_amount'] * 100;
            $payment_amount = (float)$arr_ret['settleAmount'];
            //转换交易时间
            $y = date("Y",time());
            $m = substr($arr_ret['traceTime'],0,2);
            $d = substr($arr_ret['traceTime'],2,2);

            $hh = substr($arr_ret['traceTime'],4,2);
            $mm = substr($arr_ret['traceTime'],6,2);
            $ss = substr($arr_ret['traceTime'],8,2);

            $dtime = array($y, $m, $d);
            $dc = implode("-", $dtime);
            $htime = array($hh, $mm, $ss);
            $dt = implode(":", $htime);
            $sd = array($dc, $dt);
            $ds = implode(" ", $sd);
            $ordertime = strtotime($ds);

            if ((abs($order_amount-$payment_amount) < 0.000001) && $arr_ret['respCode'] == '00'){
                $action_note = $arr_ret['respCode'] . ':'
                    . '交易成功,银联交易号:'
                    . $arr_ret['qid'];

                /* 正常购物的订单编号 */
                if(strlen($order['order_sn']) == 13 || strlen($order['order_sn']) == 15){  //2015-7-31
                    //order_paid_query($order['order_sn'], $arr_ret['qid'], $pay_id, PS_PAYED,$ordertime,$trace_time, $action_note);
                    $unionPay = new UnionPayController();
                    $status = $unionPay->payResult($order['order_sn'], $arr_ret['qid'], 2,$trace_time, $action_note);
                }
                $msg['is_pay'] = 1;
                $msg['con'] = "查询交易成功,订单状态已付款";
            }else{
                $msg['is_pay'] = 0;
                $msg['con'] = "查询交易失败,订单可能正在交易中,订单状态未付款";
            }
        }else{
            $msg['is_pay'] = 0;
            $msg['con'] = "查询交易失败,订单状态未付款";
        }
        return $msg;
    }

    /**
     * 主动查询  2015-6-15
     */
    function query_zq($order, $payment)
    {
        // 初始化变量
        $upop_evn		= $payment['upop_evn'];		// 环境

        // 商户名称
        quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

        if ($upop_evn == '2') // 生产环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
        }
        else if ($upop_evn == '1') // PM环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
        }
        else if ($upop_evn == '0') // 开发联调环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_test'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
        }

        mt_srand(quickpay_service::make_seed());

        $params = array();

        //需要填入的部分
        $params['transType']     = quickpay_conf::CONSUME;   //交易类型
        $params['orderNumber']   = $order['order_sn']; //订单号
        $orderTime = date('YmdHis',$order['add_time']);
        $params['orderTime']     = $orderTime;   //订单时间

        //提交查询
        $query  = new quickpay_service($params, quickpay_conf::QUERY);
        $ret    = $query->post();

        //返回查询结果
        $response = new quickpay_service($ret, quickpay_conf::RESPONSE);
        //查询成功
        $msg = array();
        if ($response->get('respCode') == quickpay_service::RESP_SUCCESS && $response->get('queryResult') == quickpay_service::QUERY_SUCCESS) {
            //后续处理
            $arr_ret = $response->get_args();
            //交易时间
            $trace_time = date("Y",time()).$arr_ret['traceTime'];

            $pay_id = '';
            $order_amount = $order['order_amount'] * 100;
            $payment_amount = (float)$arr_ret['settleAmount'];
            //转换交易时间
            $y = date("Y",time());
            $m = substr($arr_ret['traceTime'],0,2);
            $d = substr($arr_ret['traceTime'],2,2);

            $hh = substr($arr_ret['traceTime'],4,2);
            $mm = substr($arr_ret['traceTime'],6,2);
            $ss = substr($arr_ret['traceTime'],8,2);

            $dtime = array($y, $m, $d);
            $dc = implode("-", $dtime);
            $htime = array($hh, $mm, $ss);
            $dt = implode(":", $htime);
            $sd = array($dc, $dt);
            $ds = implode(" ", $sd);
            $ordertime = strtotime($ds);

            if ((abs($order_amount-$payment_amount) < 0.000001) && $arr_ret['respCode'] == '00'){
                $action_note = $arr_ret['respCode'] . ':'
                    . '交易成功,银联交易号:'
                    . $arr_ret['qid'];

                /* 正常购物的订单编号 */
                if(strlen($order['order_sn']) == 13 || strlen($order['order_sn']) == 15){  //2015-7-31
                    //order_paid_query($order['order_sn'], $arr_ret['qid'], $pay_id, PS_PAYED,$ordertime,$trace_time, $action_note);
                    $unionPay = new UnionPayController();
                    $status = $unionPay->payResult_zq($order['order_sn'], $arr_ret['qid'], 2,$trace_time, $action_note);
                }
                $msg['is_pay'] = 1;
                $msg['con'] = "查询交易成功,订单状态已付款";
            }else{
                $msg['is_pay'] = 0;
                $msg['con'] = "查询交易失败,订单可能正在交易中,订单状态未付款";
            }
        }else{
            $msg['is_pay'] = 0;
            $msg['con'] = "查询交易失败,订单状态未付款";
        }
        return $msg;
    }
    function query_zq_ywy($order, $payment)
    {
        // 初始化变量
        $upop_evn		= $payment['upop_evn'];		// 环境

        // 商户名称
        quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

        if ($upop_evn == '2') // 生产环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
        }
        else if ($upop_evn == '1') // PM环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
        }
        else if ($upop_evn == '0') // 开发联调环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_test'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
        }

        mt_srand(quickpay_service::make_seed());

        $params = array();

        //需要填入的部分
        $params['transType']     = quickpay_conf::CONSUME;   //交易类型
        $params['orderNumber']   = $order['order_sn']; //订单号
        $orderTime = date('YmdHis',$order['add_time']);
        $params['orderTime']     = $orderTime;   //订单时间

        //提交查询
        $query  = new quickpay_service($params, quickpay_conf::QUERY);
        $ret    = $query->post();

        //返回查询结果
        $response = new quickpay_service($ret, quickpay_conf::RESPONSE);
        //查询成功
        $msg = array();
        if ($response->get('respCode') == quickpay_service::RESP_SUCCESS && $response->get('queryResult') == quickpay_service::QUERY_SUCCESS) {
            //后续处理
            $arr_ret = $response->get_args();
            //交易时间
            $trace_time = date("Y",time()).$arr_ret['traceTime'];

            $pay_id = '';
            $order_amount = $order['order_amount'] * 100;
            $payment_amount = (float)$arr_ret['settleAmount'];
            //转换交易时间
            $y = date("Y",time());
            $m = substr($arr_ret['traceTime'],0,2);
            $d = substr($arr_ret['traceTime'],2,2);

            $hh = substr($arr_ret['traceTime'],4,2);
            $mm = substr($arr_ret['traceTime'],6,2);
            $ss = substr($arr_ret['traceTime'],8,2);

            $dtime = array($y, $m, $d);
            $dc = implode("-", $dtime);
            $htime = array($hh, $mm, $ss);
            $dt = implode(":", $htime);
            $sd = array($dc, $dt);
            $ds = implode(" ", $sd);
            $ordertime = strtotime($ds);

            if ((abs($order_amount-$payment_amount) < 0.000001) && $arr_ret['respCode'] == '00'){
                $action_note = $arr_ret['respCode'] . ':'
                    . '交易成功,银联交易号:'
                    . $arr_ret['qid'];

                /* 正常购物的订单编号 */
                if(strlen($order['order_sn']) == 13 || strlen($order['order_sn']) == 15){  //2015-7-31
                    //order_paid_query($order['order_sn'], $arr_ret['qid'], $pay_id, PS_PAYED,$ordertime,$trace_time, $action_note);
                    $unionPay = new UnionPayController();
                    $status = $unionPay->payResult_zq_ywy($order['order_sn'], $arr_ret['qid'], 2,$trace_time, $action_note);
                }
                $msg['is_pay'] = 1;
                $msg['con'] = "查询交易成功,订单状态已付款";
            }else{
                $msg['is_pay'] = 0;
                $msg['con'] = "查询交易失败,订单可能正在交易中,订单状态未付款";
            }
        }else{
            $msg['is_pay'] = 0;
            $msg['con'] = "查询交易失败,订单状态未付款";
        }
        return $msg;
    }
    function query_zq_sy($order, $payment)
    {
        // 初始化变量
        $upop_evn		= $payment['upop_evn'];		// 环境

        // 商户名称
        quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

        if ($upop_evn == '2') // 生产环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
        }
        else if ($upop_evn == '1') // PM环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
        }
        else if ($upop_evn == '0') // 开发联调环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_test'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
        }

        mt_srand(quickpay_service::make_seed());

        $params = array();

        //需要填入的部分
        $params['transType']     = quickpay_conf::CONSUME;   //交易类型
        $params['orderNumber']   = $order['order_sn']; //订单号
        $orderTime = date('YmdHis',$order['add_time']);
        $params['orderTime']     = $orderTime;   //订单时间

        //提交查询
        $query  = new quickpay_service($params, quickpay_conf::QUERY);
        $ret    = $query->post();

        //返回查询结果
        $response = new quickpay_service($ret, quickpay_conf::RESPONSE);
        //查询成功
        $msg = array();
        if ($response->get('respCode') == quickpay_service::RESP_SUCCESS && $response->get('queryResult') == quickpay_service::QUERY_SUCCESS) {
            //后续处理
            $arr_ret = $response->get_args();
            //交易时间
            $trace_time = date("Y",time()).$arr_ret['traceTime'];

            $pay_id = '';
            $order_amount = $order['order_amount'] * 100;
            $payment_amount = (float)$arr_ret['settleAmount'];
            //转换交易时间
            $y = date("Y",time());
            $m = substr($arr_ret['traceTime'],0,2);
            $d = substr($arr_ret['traceTime'],2,2);

            $hh = substr($arr_ret['traceTime'],4,2);
            $mm = substr($arr_ret['traceTime'],6,2);
            $ss = substr($arr_ret['traceTime'],8,2);

            $dtime = array($y, $m, $d);
            $dc = implode("-", $dtime);
            $htime = array($hh, $mm, $ss);
            $dt = implode(":", $htime);
            $sd = array($dc, $dt);
            $ds = implode(" ", $sd);
            $ordertime = strtotime($ds);

            if ((abs($order_amount-$payment_amount) < 0.000001) && $arr_ret['respCode'] == '00'){
                $action_note = $arr_ret['respCode'] . ':'
                    . '交易成功,银联交易号:'
                    . $arr_ret['qid'];

                /* 正常购物的订单编号 */
                if(strlen($order['order_sn']) == 13 || strlen($order['order_sn']) == 15){  //2015-7-31
                    //order_paid_query($order['order_sn'], $arr_ret['qid'], $pay_id, PS_PAYED,$ordertime,$trace_time, $action_note);
                    $unionPay = new UnionPayController();
                    $status = $unionPay->payResult_zq_sy($order['order_sn'], $arr_ret['qid'], 2,$trace_time, $action_note);
                }
                $msg['is_pay'] = 1;
                $msg['con'] = "查询交易成功,订单状态已付款";
            }else{
                $msg['is_pay'] = 0;
                $msg['con'] = "查询交易失败,订单可能正在交易中,订单状态未付款";
            }
        }else{
            $msg['is_pay'] = 0;
            $msg['con'] = "查询交易失败,订单状态未付款";
        }
        return $msg;
    }
    /**
     * 主动查询  2015-6-15
     */
    function test($order, $payment)
    {
        // 初始化变量
        $upop_evn		= $payment['upop_evn'];		// 环境

        // 商户名称
        quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

        if ($upop_evn == '2') // 生产环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
        }
        else if ($upop_evn == '1') // PM环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
        }
        else if ($upop_evn == '0') // 开发联调环境
        {
            quickpay_conf::$security_key			= $payment['upop_security_key_test'];
            quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
        }

        mt_srand(quickpay_service::make_seed());

        $params = array();

        //需要填入的部分
        $params['transType']     = quickpay_conf::CONSUME;   //交易类型
        $params['orderNumber']   = $order['order_sn']; //订单号
        $orderTime = date('YmdHis',$order['add_time']);
        $params['orderTime']     = $orderTime;   //订单时间

        //提交查询
        $query  = new quickpay_service($params, quickpay_conf::QUERY);
        $ret    = $query->post();

        //返回查询结果
        $response = new quickpay_service($ret, quickpay_conf::RESPONSE);
        //查询成功
        $msg = array();
        var_dump($response);
        if ($response->get('respCode') == quickpay_service::RESP_SUCCESS && $response->get('queryResult') == quickpay_service::QUERY_SUCCESS) {
            //后续处理
            $arr_ret = $response->get_args();
            var_dump($arr_ret);

        }
        exit;

    }

    /**
     * 格式订单号
     */
    function _formatSN($sn)
    {
        return str_repeat('0', 9 - strlen($sn)) . $sn;
    }
}