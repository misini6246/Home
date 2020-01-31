<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Ignited\LaravelOmnipay\Facades\OmnipayFacade;
use Omnipay\Omnipay;

class UnionPayController extends Controller
{
    public function pay(){

        $gateway = Omnipay::gateway('unionpay');

        $order = [
            'orderId' => date('YmdHis'),
            'txnTime' => date('YmdHis'),
            'orderDesc' => 'My test order title', //订单名称
            'txnAmt' => '100', //订单价格
        ];

        $response = $gateway->purchase($order)->send();
        $response->redirect();
    }
}
