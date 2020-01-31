<?php

namespace App\Http\Controllers\User;

use App\Common\Payfun;
use App\Http\Controllers\Controller;
use App\Models\ShippingInfo;
use App\OldOrderInfo;
use App\OrderAction;
use App\OrderInfo;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jai\Contact\Http\Controllers\pay\upop;
use App\AccountLog;
use App\User;
class OrderController extends Controller
{

    use UserTrait, Payfun;

    public function __construct()
    {
        $this->action = 'order';
        $this->user = auth()->user();
        $this->now = time();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dates = intval($request->input('dates', 1));//日期
        $keys = trim($request->input('keys', ''));//订单编号
        $status = intval($request->input('status'));//订单状态
        $query1 = DB::table('old_order_info')->where('user_id', $this->user->user_id)->where(function ($where) {
            $where->where('order_type', 0)->orwhere('mobile_pay', 3);
        })->whereNotIn('order_id', [829598, 829599]);
        $query = DB::table('order_info')->where('user_id', $this->user->user_id)->where(function ($where) {
            $where->where('order_type', 0)->orwhere('mobile_pay', 3);
        })->whereNotIn('order_id', [829598, 829599]);
        if ($keys != '') {
            $query->where('order_sn', $keys);
            $query1->where('order_sn', $keys);
        }
        $where = '';
        switch ($dates) {
            case 1:
                $time = strtotime(date('Y-m', strtotime('-3 month')) . '-01');//最近三个月
                $query->where('add_time', '>=', $time);
                $query1->where('add_time', '>=', $time);
                $where = function ($where) use ($time) {
                    $where->where('add_time', '>=', $time);
                };
                break;
            case 2:
                $time = strtotime(date('Y') . '-01-01');//今年
                $query->where('add_time', '>=', $time);
                $query1->where('add_time', '>=', $time);
                $where = function ($where) use ($time) {
                    $where->where('add_time', '>=', $time);
                };
                break;
            case 3:
                $time = strtotime(date('Y') . '-01-01');//今年
                $query->where('add_time', '<', $time);
                $query1->where('add_time', '<', $time);
                $where = function ($where) use ($time) {
                    $where->where('add_time', '<', $time);
                };
                break;
        }
        $status_value = '订单状态';
        switch ($status) {
            case 1://待付款
                $query->where('pay_status', 0)->where('order_status', 1);
                $query1->where('pay_status', 0)->where('order_status', 1);
                $status_value = '待付款';
                break;
            case 2://待收货
                $query->where('shipping_status', 4)->where('order_status', 1);
                $query1->where('shipping_status', 4)->where('order_status', 1);
                $status_value = '待收货';
                break;
            case 3://待发货
                $query->where('shipping_status', 3)->where('order_status', 1);
                $query1->where('shipping_status', 3)->where('order_status', 1);
                $status_value = '待发货';
                break;
            case 4://已完成
                $query->where('shipping_status', 5)->where('order_status', 1);
                $query1->where('shipping_status', 5)->where('order_status', 1);
                $status_value = '已完成';
                break;
            case 5://已取消
                $query->where('order_status', 2);
                $query1->where('order_status', 2);
                $status_value = '已取消';
                break;
        }
        $select = ['order_id', 'add_time', 'order_status', 'pay_status', 'shipping_status', 'order_sn', 'goods_amount', 'fhwl_m', 'shipping_fee', 'order_type',
            'consignee', 'is_mhj', 'is_separate', 'is_zq', 'user_id', 'mobile_pay', 'jnmj', 'order_amount', 'money_paid', 'o_paid', 'shipping_name', 'invoice_no','fanli','is_sync'];
        $union = $query->select($select)
            ->unionAll($query1->select($select));
        $sql = DB::table(DB::raw("({$union->toSql()}) as ecs_oi"))
            ->mergeBindings($union);
        $result = $sql->orderBy('order_id', 'desc')
            ->select($select)
            ->Paginate();
        $ids = $result->lists('order_id')->toArray();
        $order_acton = OrderAction::whereIn('order_id', $ids)->get();
        foreach ($result as $v) {
            $actions = $order_acton->where('order_id', $v->order_id);
            $v->order_action = $actions;
            $ddgz = $this->ddgz($v);
            $pay_xz = pay_xz($v);
            $v->ddgz = $ddgz;
            $v->pay_xz = $pay_xz;
        }
        $result->addQuery('dates', $dates);
        $result->addQuery('status', $status);
        $result->addQuery('keys', $keys);
        $this->set_assign('status_value', $status_value);
        $this->set_assign('result', $result);
        $this->set_assign('action', 'order');
        $this->set_assign('dates', $dates);
        $this->set_assign('keys', $keys);
        $this->set_assign('status', $status);
        $this->set_assign('dfk', $this->dfk($where));
        $this->set_assign('dsh', $this->dsh($where));
        $this->common_value();
        return view($this->view . 'user.order_list', $this->assign);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = OrderInfo::where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            $info = OldOrderInfo::where('user_id', $this->user->user_id)->find($id);
        }
        if (!$info) {
            tips1('订单不存在请咨询客服', ['前往订单列表' => route('member.order.index')]);
        }
        $info->load([
            'order_goods' => function ($query) {
                $query->with([
                    'goodsAttr' => function ($query) {
                        $query->whereIn('attr_id', [1, 3]);
                    },
                    'goods_attribute' => function ($query) {
                        $query->select('goods_id', 'sccj', 'ypgg');
                    },
                    'goods' => function ($query) {
                        $query->select('goods_id', 'goods_thumb');
                    }
                ]);
            },
            'order_action'
        ]);
        foreach ($info->order_goods as $v) {
            if ($v->is_zyyp == 0) {
                $v->sccj = collect($v->goodsAttr->where('attr_id', 1)->first())->get('attr_value');
                $v->ypgg = collect($v->goodsAttr->where('attr_id', 3)->first())->get('attr_value');
            } else {
                $v->sccj = $v->goods_attribute->sccj;
                $v->ypgg = $v->goods_attribute->ypgg;
            }
            $v->goods_thumb = !empty($v->goods->goods_thumb) ? $v->goods->goods_thumb : 'images/no_picture.gif';
            $v->goods_thumb = get_img_path($v->goods_thumb);
        }
        $info->ddgz = $this->ddgz($info);
        $info->pay_xz = pay_xz($info);
        if ($info->pay_xz == 1) {
//            if ($info->pay_id == 8) {
//                $this->set_assign('zfbzz', $this->button($info, 8));
//            }
            $this->set_assign('alipay', $this->button($info, 9));
            $this->set_assign('weixin', $this->button($info, 7));
        }
        $dzfp = dzfp();
        $info->dzfp_name = isset($dzfp[$info->dzfp]) ? $dzfp[$info->dzfp] : '未知类型';
        $region_name = get_region_name([$info->province, $info->city, $info->district], '-');
        $info->region_name = trim($region_name, '-');
        $this->set_assign('info', $info);
        $this->common_value();
        //dd($this->assign);
        return view($this->view . 'user.order_info', $this->assign);
    }

    public function orderInfo(Request $request)
    {
        $id = intval($request->input('id'));
        $info = OrderInfo::where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            $info = OldOrderInfo::where('user_id', $this->user->user_id)->find($id);
        }
        if (!$info) {
            tips1('订单不存在请咨询客服', ['前往订单列表' => route('member.order.index')]);
        }
        $info->load([
            'order_goods' => function ($query) {
                $query->with([
                    'goodsAttr' => function ($query) {
                        $query->whereIn('attr_id', [1, 3]);
                    },
                    'goods_attribute' => function ($query) {
                        $query->select('goods_id', 'sccj', 'ypgg');
                    },
                    'goods' => function ($query) {
                        $query->select('goods_id', 'goods_thumb');
                    }
                ]);
            },
            'order_action'
        ]);
        foreach ($info->order_goods as $v) {
            if ($v->is_zyyp != 1) {
                $v->sccj = collect($v->goodsAttr->where('attr_id', 1)->first())->get('attr_value');
                $v->ypgg = collect($v->goodsAttr->where('attr_id', 3)->first())->get('attr_value');
            } else {
			
				if(empty($v->goods_attribute->sccj)){
					$v->sccj = $v->GoodsAttr[0]->attr_value;
					$v->ypgg = $v->GoodsAttr[1]->attr_value;
				}else{
					$v->sccj = $v->goods_attribute->sccj;
                $v->ypgg = $v->goods_attribute->ypgg;
				}
                
            }
            $v->goods_thumb = !empty($v->goods->goods_thumb) ? $v->goods->goods_thumb : 'images/no_picture.gif';
            $v->goods_thumb = get_img_path($v->goods_thumb);
        }
        $info->ddgz = $this->ddgz($info);
        $info->pay_xz = pay_xz($info);
        if ($info->pay_xz == 1) {
//            if ($info->pay_id == 8) {
//                $this->set_assign('zfbzz', $this->button($info, 8));
//            }
            $this->set_assign('alipay', $this->button($info, 9));
            $this->set_assign('weixin', $this->button($info, 7));
        }
        $dzfp = dzfp();
        $info->dzfp_name = isset($dzfp[$info->dzfp]) ? $dzfp[$info->dzfp] : '未知类型';
        $region_name = get_region_name([$info->province, $info->city, $info->district], '-');
        $info->region_name = trim($region_name, '-');
        $cancel_reason = OrderAction::where('order_id', $info->order_id)->where('order_status', 2)->orderBy('action_id', 'desc')->first();
        $this->set_assign('info', $info);
        $this->set_assign('cancel_reason', $cancel_reason);
        $this->common_value();
        //dd($this->assign);
        return view($this->view . 'user.order_info', $this->assign);
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
        $flag = DB::transaction(function () use ($request, $id) {
            $info = OrderInfo::where('user_id', $this->user->user_id)->lockForUpdate()->find($id);
            if (!$info) {
                $info = OldOrderInfo::where('user_id', $this->user->user_id)->lockForUpdate()->find($id);
            }
            if (!$info) {
                tips1('订单不存在请咨询客服', ['前往订单列表' => route('member.order.index')]);
            }
            $act = trim($request->input('act', 'surplus'));
            if ($act == 'surplus') {
                $surplus = floatval($request->input('surplus'));
                if ($surplus <= 0) {
                    return 1;
                }
                $pay_xz = pay_xz($info);
                if ($pay_xz == 0 || $info->jnmj > 0 || $info->is_mhj > 0 || $info->mobile_pay == -2) {
                    return 2;
                }
                $surplus = min([$info->order_amount, $surplus, $this->user->user_money]);
                if ($surplus > 0) {//记录余额变动
                    $info->surplus = $info->surplus + $surplus;
                    $info->order_amount = $info->order_amount - $surplus;
                    if ($info->order_amount == 0) {
                        $info->pay_status = 2;
                        $info->pay_time = time();
                    }
                    $info->save();
                    log_account_change_type($this->user->user_id, $surplus * (-1), 0, 0, 0, '支付订单' . $info->order_sn, 0, 0, $id);  //2015-7-27
                }
            } elseif ($act == 'qrsh') {
                if ($info->order_status == 2) {
                    return 3;
                } elseif ($info->shipping_status == 5) {
                    return 4;
                } elseif ($info->shipping_status != 4) {
                    return 5;
                } else {
                    $info->shipping_status = 5;
                    $info->save();
                    order_action($info, '', $this->user->user_name);
                    return 6;
                }
            }
        });
        switch ($flag) {
            case 1:
                tips1('请输入正确的金额', ['返回订单详情' => route('member.order.show', ['id' => $id])]);
                break;
            case 2:
                tips1('该订单不能使用余额', ['返回订单详情' => route('member.order.show', ['id' => $id])]);
                break;
            case 3:
                tips1('订单已取消', ['返回订单详情' => route('member.order.show', ['id' => $id])]);
                break;
            case 4:
                tips1('订单已完成', ['返回订单详情' => route('member.order.show', ['id' => $id])]);
                break;
            case 5:
                tips1('订单状态有误', ['返回订单详情' => route('member.order.show', ['id' => $id])]);
                break;
            case 6:
                tips0('订单确认收货', ['返回订单详情' => route('member.order.show', ['id' => $id])]);
                break;
        }
        return redirect()->route('member.order.show', ['id' => $id]);
    }

    public function wlxx(Request $request)
    {
        $id = intval($request->input('id'));
        $info = OrderInfo::where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            $info = OldOrderInfo::where('user_id', $this->user->user_id)->find($id);
        }
        if (!$info) {
            tips1('订单不存在请咨询客服', ['前往订单列表' => route('member.order.index')]);
        }
        $shipping_info = ShippingInfo::where('order_sn', $info->order_sn)->groupBy('shipping_id')->get();
        if (count($shipping_info) == 0) {
            tips1('订单不存在物流信息', ['前往订单列表' => route('member.order.index')]);
        }
        foreach ($shipping_info as $v) {
            $steps = collect();
            if ($v->qs_time > 0) {
                $steps->push(['time' => $v->qs_time, 'action' => '已签收']);
            }
//            if ($v->fc_time > 0) {
//                $steps->push(['time' => $v->fc_time, 'action' => '已发车']);
//            }
            if ($v->zc_time > 0) {
                $steps->push(['time' => $v->zc_time, 'action' => '已发车']);
            }
            if ($v->dp_time > 0) {
                $steps->push(['time' => $v->dp_time, 'action' => '调派送货司机，司机姓名：' . $v->name . '，司机电话：' . $v->tel]);
            }
            if ($v->tms_time > 0) {
                $steps->push(['time' => $v->tms_time, 'action' => '已接收']);
            }
            $v->steps = $steps;
        }
        $this->set_assign('info', $info);
        $this->set_assign('shipping_info', $shipping_info);
        $this->set_assign('action', 'order');
        $this->common_value();
        return view('new.user.zjs', $this->assign);
    }

    public function guotong(Request $request)
    {
        $id = intval($request->input('id'));
        $info = OrderInfo::where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            $info = OldOrderInfo::where('user_id', $this->user->user_id)->find($id);
        }
        if (!$info) {
            tips1('订单不存在请咨询客服', ['前往订单列表' => route('member.order.index')]);
        }
        $dh = explode(' ', $info->invoice_no);
        $orders = collect();
        foreach ($dh as $k => $v) {
            $shipping = collect();
            $shipping->shipping_id = $v;
            $shipping->steps = [];
            if (!empty($v)) {
                $response = json_decode(file_get_contents('http://101.227.81.102:22229/gtoPlatform/track/taoBaoTrack!trackForJson.action?logistics_interface=' . $v));
                $steps = collect();
                foreach ($response->tracesList[0]->traces as $key => $value) {
                    $arr = [
                        'time' => strtotime($value->time),
                        'action' => $value->desc,
                        'key' => $key,
                    ];
                    $steps->push($arr);
                }
                $shipping->steps = $steps->sortByDesc('key')->values();
            }
            $orders->push($shipping);
        }
        $this->set_assign('info', $info);
        $this->set_assign('shipping_info', $orders);
        $this->set_assign('action', 'order');
        $this->common_value();
        return view('new.user.zjs', $this->assign);
    }

    public function rebate(Request $request)
    {
        $id = intval($request->input('id'));
        $num = 0;
        $info = OrderInfo::where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            $info = OldOrderInfo::where('user_id', $this->user->user_id)->find($id);
        }
        if (!$info) {
            tips1('订单不存在请咨询客服', ['前往订单列表' => route('member.order.index')]);
        }
        $info->load([
            'order_goods' => function ($query) {
                $query->with([
                    'goodsAttr' => function ($query) {
                        $query->whereIn('attr_id', [1, 3]);
                    },
                    'goods_attribute' => function ($query) {
                        $query->select('goods_id', 'sccj', 'ypgg');
                    },
                    'goods' => function ($query) {
                        $query->select('goods_id', 'goods_thumb','is_yhq_status');
                    }
                ]);
            },
            'order_action'
        ]);

        if($info->is_sync==1 && $info->fanli==1 && $info->is_mhj !=1){
            foreach ($info->order_goods as $k=>$v){
                if($v->goods->is_yhq_status != 2 ) {
                    $num += ($v->goods_price - $v->zyzk) * $v->goods_number;
//                      $num += $v->goods_price  * $v->goods_number;
                }else{
                    return  json_encode(['a'=>1]);
                }
                if($v->tsbz == '秒'){ $num -=  $v->goods_price * $v->goods_number_f;}
            }

            /*      if($info->zyzk > 0) $num =  $num - $info->zyzk;*/
//            if($info->pack_fee > 0) $num =  $num - $info->pack_fee;
//               if($info->surplus >0 ) $num =  $num - $info->surplus;
            if($num >= 500 && $num < 1000 ){
//                $fals =   DB::transaction(function()use($info){
                    $info->fanli = 2;
                    $info->save();
                    $this->log_account_change_rebate($info->user_id, 5, 0,  0, 0, '订单'.$info->order_sn.'确认收货返利5元',99,0,$info->order_id);
                    return  json_encode(['jine'=>5]);
//                });
            }else if($num >= 1000){
//                $fals =   DB::transaction(function()use($info,$num){
                    $info->fanli = 2;
                    $info->save();
                    $count = intval($num / 1000)*20;
                    $this->log_account_change_rebate($info->user_id, $count, 0, 0, 0, '订单' . $info->order_sn . '确认收货返利' . $count . '元', 99, 0, $info->order_id);
                    return json_encode(['jine'=>$count]);
//                });
            }
          /*  if($fals){
                return $fals;
            }else{
                return 0;
            }*/

        }
    }
    protected function log_account_change_rebate($user_id, $user_money = 0, $frozen_money = 0, $rank_points = 0, $pay_points = 0, $change_desc = '', $change_type = 99, $money_type = 0, $order_id = 0)
    {
        $account_log = new AccountLog();
        $account_log->user_id = $user_id;
        $account_log->user_money = $user_money;
        $account_log->frozen_money = $frozen_money;
        $account_log->rank_points = $rank_points;
        $account_log->pay_points = $pay_points;
        $account_log->change_time = time();
        $account_log->change_desc = $change_desc;
        $account_log->change_type = $change_type;
        $account_log->money_type = $money_type;
        $account_log->order_id = $order_id;
        /* 插入帐户变动记录 */
        $account_log->save();
        /* 更新用户信息 */
        $user = User::find($user_id);
        $user->user_money = $user->user_money + $account_log->user_money;
        $user->frozen_money = $user->frozen_money + $account_log->frozen_money;
        $user->rank_points = $user->rank_points + $account_log->rank_points;
        $user->pay_points = $user->pay_points + $account_log->pay_points;
        $user->save();

    }


}
