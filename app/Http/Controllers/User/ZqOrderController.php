<?php

namespace App\Http\Controllers\User;

use App\Common\Payfun;
use App\Http\Controllers\Controller;
use App\Payment;
use App\ZqLog;
use App\ZqLogYwy;
use App\ZqOrder;
use App\ZqOrderYwy;
use App\ZqYwy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jai\Contact\Http\Controllers\pay\upop;

class ZqOrderController extends Controller
{
    use UserTrait, Payfun;

    public function __construct()
    {
        $this->action = 'zq_order';
        $this->user   = auth()->user()->is_zhongduan();
        $this->now    = time();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query1 = ZqOrder::where('user_id', $this->user->user_id)->where('order_status', '!=', 2)
            ->select('zq_id', 'order_sn', 'user_id', 'goods_amount', 'add_time', 'order_status', 'pay_status', 'add_time', DB::raw('1 as zq_type'));
        $query2 = ZqOrderYwy::where('user_id', $this->user->user_id)->where('order_status', '!=', 2)
            ->select('zq_id', 'order_sn', 'user_id', 'goods_amount', 'add_time', 'order_status', 'pay_status', 'add_time', DB::raw('2 as zq_type'));
        $count  = $query1->count();
        $count  += $query2->count();
        $result = $query1->unionAll($query2)->orderBy('order_sn', 'desc')
            ->Paginate(10, ['*'], 'page', $request->input('page'), $count);
        $this->set_assign('result', $result);
        $this->common_value();
        return view($this->view . 'user.zq_order_list', $this->assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $type = intval($request->input('type', 1));
        if ($type == 1) {
            $info = ZqOrder::with([
                'order_info' => function ($query) {
                    $query->where('user_id', $this->user->user_id)->where('order_status', 1)->where('is_zq', 1)
                        ->select('zq_id', 'order_amount', 'order_id', 'goods_amount', 'order_sn', 'add_time',
                            'order_status', 'pay_status', 'shipping_status', 'pay_name');
                }
            ])->where('user_id', $this->user->user_id)->where('zq_id', $id)->first();
        } else {
            $info = ZqOrderYwy::with([
                'order_info' => function ($query) {
                    $query->where('user_id', $this->user->user_id)->where('order_status', 1)->where('is_zq', 2)
                        ->select('zq_id', 'order_amount', 'order_id', 'goods_amount', 'order_sn', 'add_time',
                            'order_status', 'pay_status', 'shipping_status', 'pay_name');
                }
            ])->where('user_id', $this->user->user_id)->where('zq_id', $id)->first();
        }
        if (!$info) {
            tips1('订单不存在,请咨询客服', ['返回账期汇总订单列表' => route('member.zq_order.index')]);
        }
        $order_amount = 0;
        if ($info->order_info) {
            foreach ($info->order_info as $v) {
                $order_amount += $v->order_amount;
            }
        }
        if ($info->pay_status != 2 && $info->order_status == 1 && $info->order_amount > 0) {
            if (abs($order_amount - $info->goods_amount) < 0.000001) {
                //银联支付
                $payment_info    = Payment::where('pay_id', 4)->where('enabled', 1)->first();
                $payment         = unserialize_config($payment_info->pay_config);
                $info->user_name = $this->user->user_name;
                $info->pay_desc  = Payment::where('pay_id', $info->pay_id)->where('enabled', 1)->pluck('pay_desc');
                $pay_obj         = new upop();
                $info->order_id  = $info->zq_id;
                if ($type == 1) {
                    $unionpay = $pay_obj->get_code_zq($info, $payment);
                } else {
                    $unionpay = $pay_obj->get_code_zq_ywy($info, $payment);
                }
                $this->set_assign('alipay', $this->button($info, 9, $type));
                $this->set_assign('weixin', $this->button($info, 7, $type));
                $this->set_assign('xyyh', $this->button($info, 6, $type));
                $this->set_assign('unionpay', $unionpay);
            } else {
                $this->set_assign('tips', '(订单金额不符)');
            }
        }
        $this->set_assign('info', $info);
        $this->common_value();
        return view($this->view . 'user.zq_order_info', $this->assign);

    }

    public function zq_log()
    {
        $result = [];
        if ($this->user->is_zq == 2) {
            $zq_ywy = ZqYwy::where('user_id', $this->user->user_id)->first();
            if ($zq_ywy) {
                $zq_info            = collect();
                $zq_info->zq_amount = $zq_ywy->zq_amount;
                $zq_info->zq_je     = $zq_ywy->zq_je;
                $zq_info->zq_rq     = $zq_ywy->zq_rq;
                $zq_info->zq_has    = $zq_ywy->zq_has;
                $this->set_assign('zq_info', $zq_info);
                $result = ZqLogYwy::where('user_id', $this->user->user_id)->where('change_amount', '!=', 0)->Paginate();
            }
        } elseif ($this->user->is_zq == 1) {
            $zq_info            = collect();
            $zq_info->zq_amount = $this->user->zq_amount;
            $zq_info->zq_je     = $this->user->zq_je;
            $zq_info->zq_rq     = $this->user->zq_rq;
            $zq_info->zq_has    = $this->user->zq_has;
            $this->set_assign('zq_info', $zq_info);
            $result = ZqLog::where('user_id', $this->user->user_id)->where('change_amount', '!=', 0)->Paginate();
        } else {
            tips1('您请求的页面不存在', ['返回会员中心' => route('user.index')]);
        }
        $this->set_assign('result', $result);
        $this->common_value();
        return view($this->view . 'user.zq_log', $this->assign);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
