<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\abcpay\PaymentController;

class AbcPayController extends Controller
{
    public function pay(Request $request){
        $id = $request->input('id');
        $user = Auth::user();
        $order = Cache::tags(['user',$user->user_id])->get('online_pay'.$id);
        if(!$order){
            return view('message')->with(messageSys('订单不存在请咨询客服',route('user.orderList'),[
                [
                    'url'=>route('user.orderList'),
                    'info'=>'返回订单列表',
                ],
            ]));
        }
    }
}
