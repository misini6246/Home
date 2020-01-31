<?php

namespace App\Http\Controllers;

use App\AccountLog;
use App\Buy;
use App\Cart;
use App\CollectGoods;
use App\Common\Payfun;
use App\FeedBack;
use App\Goods;
use App\JnmjLog;
use App\Models\CzOrder;
use App\Models\FanKui;
use App\Models\MessageUsers;
use App\Models\MobileLogin;
use App\OldOrderGoods;
use App\OldOrderInfo;
use App\OrderAction;
use App\OrderGoods;
use App\OrderInfo;
use App\Payment;
use App\Region;
use App\Shipping;
use App\User;
use App\UserAccount;
use App\UserAddress;
use App\UserJnmj;
use App\YouHuiQ;
use App\ZqLog;
use App\ZqLogYwy;
use App\ZqOrder;
use App\ZqOrderSy;
use App\ZqOrderYwy;
use App\ZqSy;
use App\ZqYwy;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Jai\Contact\Http\Controllers\pay\upop;

require_once app_path() . '/Common/user.php';
require_once app_path() . '/Common/goods.php';

class UserController extends Controller
{
    use Payfun;

    /*
 * 中间件
 */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $nav_list;

    private $arr;

    private $user;

    public function __construct(Request $request)
    {
        $this->user = auth()->user();
        $sy_zq_type = ZqSy::where('user_id', $this->user->user_id)->pluck('is_zq');
        $ywy_zq_type = ZqYwy::where('user_id', $this->user->user_id)->pluck('zq_amount');
        if ($ywy_zq_type > 0 || $this->user->zq_amount > 0) {
            $show_zq = 1;
        } else {
            $show_zq = 0;
        }
        $this->arr = [
            'page_title' => '用户中心-',
            'action' => '',
            'show_zq' => $show_zq,
            'user' => $this->user,
            'sy_zq_type' => $sy_zq_type,
            'full_page' => 1,
        ];
        if ($request->ajax()) {
            $this->arr['full_page'] = 0;
        }
        //dd($this->nav_list);
    }

    public function index(Request $request)
    {
        $user = Auth::user()->is_new_user();
        if ($user->is_zq == 2) {
            $zq_ywy = ZqYwy::find($this->user->user_id);
            $user->zq_rq = $zq_ywy->zq_rq;
            $user->zq_ywy = $zq_ywy->zq_ywy;
            $user->zq_amount = $zq_ywy->zq_amount;
            $user->zq_je = $zq_ywy->zq_je;
            $user->zq_has = $zq_ywy->zq_has;
            $user->zq_start_date = $zq_ywy->zq_start_date;
            $user->zq_end_date = $zq_ywy->zq_end_date;
        }
        $sy_zq = ZqSy::find($user->user_id);
        $user_jnmj = UserJnmj::where('user_id', $user->user_id)->first();
        //dd($user_jnmj);
        //$pay_amount  = OrderInfo::pay_amount($user);// 消费总额
        $wait_amount = OrderInfo::wait_amount($user);//待付款金额
        $pay_order = OrderInfo::pay_order($user);//待发货数量
        $wait_order = OrderInfo::wait_order($user);//待付款数量
        $yyzz_time = $this->check_date($this->user->yyzz_time);
        $xkz_time = $this->check_date($this->user->xkz_time);
        $zs_time = $this->check_date($this->user->zs_time);
        $yljg_time = $this->check_date($this->user->yljg_time);
        $near_order = OrderInfo::near_order($user, 3);//最近的订单
        //print_r($near_order->toArray());
        $collection = CollectGoods::collect_near(3, $user);//我的收藏
        $collection = CollectGoods::collect_near(3, $user);//我的收藏
        $yhq_count = YouHuiQ::where('user_id', $this->user->user_id)->whereIn('cat_id', [50])
            ->where('end', '>', time())->where('enabled', 1)
            ->where('order_id', 0)->count();
        //dd($collection);
        //为您推荐
        $wntj = Goods::rqdp('is_wntj', 10, -4);
        $this->arr['user_jnmj'] = $user_jnmj;
        $this->arr['yhq_count'] = $yhq_count;
        $this->arr['sy_zq'] = $sy_zq;
        $this->arr['user'] = $user;
        //$this->arr['pay_amount']  = formated_price($pay_amount);
        $this->arr['wait_amount'] = formated_price($wait_amount);
        $this->arr['yyzz_time'] = $yyzz_time;
        $this->arr['xkz_time'] = $xkz_time;
        $this->arr['zs_time'] = $zs_time;
        $this->arr['yljg_time'] = $yljg_time;
        $this->arr['pay_order'] = $pay_order;
        $this->arr['wait_order'] = $wait_order;
        $this->arr['near_order'] = $near_order;
        $this->arr['collection'] = $collection;
        $this->arr['wntj'] = $wntj;
        return view('userCenter')->with($this->arr);
    }

    /*
     * 我的订单列表
     */
    public function orderList(Request $request)
    {
        $dates = $request->input('dates', 1);//日期
        $keys = $request->input('keys', '');//订单编号
        $status = $request->input('status', 0);//100待付款,101待发货
        if ($dates == 2 || $dates == 1) {//联表查询
            $query1 = OldOrderInfo::where('user_id', $this->user->user_id);
            $query = OrderInfo::where('user_id', $this->user->user_id);
        } elseif ($dates == 3) {//查询旧表
            $query = OldOrderInfo::where('user_id', $this->user->user_id);
        } else {
            $query = OrderInfo::where('user_id', $this->user->user_id);
        }
        $query->where(function ($where) {
            $where->whereNotIn('mobile_pay', [2, 6, 7, 8, 12, 13, 14, 17, 18])->orwhere(function ($where) {
                $where->where('mobile_pay', 2)->where(function ($where) {
                    $where->where('order_id', '<', 367858)->orwhere('order_id', '>', 394321);
                });
            });
        });
        $data_arr = [
            0 => strtotime(date('Y-m-d')),//今天
            //1=>strtotime(date('Y-m').'-01'),//当月
            1 => strtotime(date('Y-m', strtotime('-3 month')) . '-01'),//最近三个月
            2 => strtotime(date('Y') . '-01-01'),//今年
            3 => strtotime(date('Y' . '-01-01')),//往年
        ];
        if (isset($data_arr[$dates])) {
            if ($dates != 3) {
                $query1->where('add_time', '>=', $data_arr[$dates]);

                $query->where('add_time', '>=', $data_arr[$dates]);
            } else {
                $query->where('add_time', '<', $data_arr[$dates]);
            }
        } elseif ($keys != '') {
            $query->where('order_sn', $keys);
        }
//        if($dates==1){
//            $times = strtotime('-3 month');
//            $query->where('add_time','>',$times);
//        }elseif($dates==2){
//            $times = strtotime(date('Y').'-01-01');
//            $query->where('add_time','>',$times);
//        }elseif($dates==date('Y',strtotime('-1 year'))){
//            $times = strtotime($dates.'-01-01');
//            $times_end = strtotime(date('Y').'-01-01');
//            $query->whereBetween('add_time',[$times,$times_end]);
//        }elseif($dates=='old'){
//            $times = strtotime('2014-01-01');
//            $times_end = strtotime(date('Y').'-01-01');
//            $query->whereBetween('add_time',[$times,$times_end]);
//        }elseif($keys!=''){
//            $query->where('order_sn',$keys);
//        }
        if ($status == 100) {
            if ($dates == 2 || $dates == 1) {
                $query1->where('order_status', 1)->where('pay_status', 0)->where('shipping_status', 0);
            }
            $query->where('order_status', 1)->where('pay_status', 0)->where('shipping_status', 0);
        } elseif ($status == 101) {
            if ($dates == 2 || $dates == 1) {
                $query1->where('order_status', 1)->where(function ($query) {
                    $query->where('pay_status', 1)->orwhere('pay_status', 2);
                });
            }
            $query->where('order_status', 1)->where(function ($query) {
                $query->where('pay_status', 1)->orwhere('pay_status', 2);
            });
        }

        if ($dates == 2 || $dates == 1) {
            $count = $query->count();
            $count += $query1->count();
            $query1->select('order_id', 'add_time', 'order_status', 'pay_status', 'shipping_status', 'order_sn', 'goods_amount',
                'consignee', 'jnmj', 'is_zq', 'is_separate', 'fhwl_m', 'mobile_pay');
            $orderList = $query->unionAll($query1)
                ->select('order_id', 'add_time', 'order_status', 'pay_status', 'shipping_status', 'order_sn', 'goods_amount',
                    'consignee', 'jnmj', 'is_zq', 'is_separate', 'fhwl_m', 'mobile_pay')
                ->orderby('order_id', 'desc')
                ->Paginate(10, ['*'], 'page', $request->input('page'), $count);
        } else {
            $orderList = $query
                ->select('order_id', 'add_time', 'order_status', 'pay_status', 'shipping_status', 'order_sn', 'goods_amount',
                    'consignee', 'jnmj', 'is_zq', 'is_separate', 'fhwl_m', 'mobile_pay')
                ->orderby('order_id', 'desc')
                ->Paginate(10);
        }
        //dd($orderList);
        $this->arr['action'] = 'orderList';
        $this->arr['pages'] = $orderList;
        $this->arr['dates'] = $dates;
        $this->arr['keys'] = $keys;
        return view('orderList')->with($this->arr);
    }

    /*
     * 订单跟踪
     */
    public function ddgz(Request $request)
    {
        if ($request->ajax()) {
            $order_id = $request->input('order_ids');
            $rows = OrderAction::where('order_id', $order_id)->orderBy('log_time', 'desc')->get();
            $status = [];  //订单操作记录
            //llPrint($status);
            if ($rows->isEmpty()) {
                $rs = OrderInfo::where('order_id', $order_id)
                    ->select('add_time')
                    ->first();
                $status[] = [
                    'status' => 0,
                    'con' => '您的订单已提交，等待系统审核。',
                    'times' => date('Y-m-d H:i:s', $rs['add_time']),
                ];
            } else {
                foreach ($rows as $row) {
                    if ($row->order_status == 1 && $row->pay_status == 0 && $row->shipping_status == 0) {
                        $status[] = [
                            'status' => 1,
                            'con' => '请您尽快完成付款，订单为未付款。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 0) {
                        $status[] = [
                            'status' => 2,
                            'con' => '您的订单商家正在积极备货中，未发货。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 1) {
                        $status[] = [
                            'status' => 3,
                            'con' => '您的订单商家已开票。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 2) {
                        $status[] = [
                            'status' => 4,
                            'con' => '您的订单正在已拣货，请您耐心等待。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 3) {
                        $status[] = [
                            'status' => 5,
                            'con' => '您的订单现已出库。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 4) {
                        $status[] = [
                            'status' => 6,
                            'con' => '您的订单已发货。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 5) {
                        $status[] = [
                            'status' => 7,
                            'con' => '<font color="red">您的订单已送达成功！已完成。</font>',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 2 && $row->pay_status == 0) {
                        $status[] = [
                            'status' => 8,
                            'con' => '<font color="red">您的订单已取消。</font>',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                }
            }
//            $str = '<ul>';
//            foreach ($status as $k => $v) {
//                $str .= '<li class="fn_clear @if($k==0) on_hover @endif">
//                    <span class="date_txt">' . $v['times'] . '</span> <span class="data_txt">' . $v['con'] . '</span>
//                    </li>';
//            }
//            $str .= '</ul>';
            //llPrint($status);
            return view('layout.ddgz')->with(['status' => $status]);
            //return $str;
        } else {
            exit;
        }
    }

    /*
     * 确认收货
     */
    public function sureShipping(Request $request)
    {
        $user = auth()->user();
        $id = $request->input('id');
        /* 查询订单信息，检查状态 */
        if ($id <= 467343) {
            $order = OldOrderInfo::select('order_sn', 'order_status', 'shipping_status', 'pay_status', 'order_id', 'user_id')->findOrfail($id);
        } else {
            $order = OrderInfo::select('order_sn', 'order_status', 'shipping_status', 'pay_status', 'order_id', 'user_id')->findOrfail($id);
        }
        $this->authorize('update-post', $order);
        // 如果用户ID大于 0 。检查订单是否属于该用户
        if (empty($order)) {
            return view('message')->with(messageSys('订单不存在请咨询客服', route('user.orderList'), [
                [
                    'url' => route('user.orderList'),
                    'info' => '返回订单列表',
                ],
            ]));
        } /* 检查订单 */
        elseif ($order->shipping_status == 5) {
            return view('message')->with(messageSys('订单已完成', route('user.orderInfo', ['id' => $id]), [
                [
                    'url' => route('user.orderList'),
                    'info' => '返回订单列表',
                ],
            ]));
        } elseif ($order['shipping_status'] != 4) {
            return view('message')->with(messageSys('订单状态有误', route('user.orderInfo', ['id' => $id]), [
                [
                    'url' => route('user.orderList'),
                    'info' => '返回订单列表',
                ],
            ]));
        } /* 修改订单发货状态为“确认收货” */
        else {
            $order->shipping_status = 5;
            DB::transaction(function () use ($order, $user) {
                $order->save();
                order_action($order, '', $user->user_name);
            });
            return view('message')->with(messageSys('订单确认收货成功', route('user.orderInfo', ['id' => $id]), [
                [
                    'url' => route('user.orderList'),
                    'info' => '返回订单列表',
                ],
            ]));
        }
    }

    /*
     * 我的订单详情
     */
    public function orderInfo(Request $request)
    {
        $id = intval($request->input('id'));//订单编号
        $is_zq = intval($request->input('is_zq', 0));//订单编号
        $is_separate = intval($request->input('is_separate', 0));//订单编号
        if ($is_zq == 0 && $is_separate == 0 && $id <= 467343) {
            $order = OldOrderInfo::with([
                'order_goods' => function ($query) {
                    $query->with([
                        'goods' => function ($query) {
                            $query->select('goods_id', 'goods_thumb');
                        }
                    ])->select('order_id', 'parent_id', 'goods_id', 'goods_name', 'goods_price', 'goods_number', 'user_bz', 'goods_number_f', 'is_jp', 'zyzk', 'xq');
                }])->where('user_id', $this->user->user_id)->where('order_id', $id)->first();
        } else {
            $order = OrderInfo::with([
                'order_goods' => function ($query) {
                    $query->with([
                        'goods' => function ($query) {
                            $query->select('goods_id', 'goods_thumb');
                        }
                    ])->select('order_id', 'parent_id', 'goods_id', 'goods_name', 'goods_price', 'goods_number', 'user_bz', 'goods_number_f', 'is_jp', 'zyzk', 'xq');
                }])->where('user_id', $this->user->user_id)->where('order_id', $id)->first();
        }
        //llPrint($order,2);
        if (!$order) {
            return view('message')->with(messageSys('订单不存在请咨询客服', route('user.orderList'), [
                [
                    'url' => route('user.orderList'),
                    'info' => '返回订单列表',
                ],
            ]));
        }
//        $zp = [];
//        foreach ($order->order_goods as $k => $order_goods) {
//            if ($order_goods->parent_id > 0) {
//                $zp[$order_goods->parant_id] = $order_goods;
//                unset($order->order_goods[$k]);
//            }
//        }
//        foreach ($order->order_goods as $order_goods) {
//            if (isset($zp[$order_goods->goods_id])) {
//                $order_goods->child = $zp[$order_goods->goods_id];
//            }
//        }
        $this->arr['order'] = $order;
        $this->arr['action'] = 'orderList';
        if ($order->pay_status != 2 && $order->order_status == 1 && $order->order_amount > 0 && $order->o_paid == 0) {
            /**
             * 支付限制
             */
            $status = pay_xz($order);
            if ($status == true) {
                //银联支付
                $user = auth()->user();
                $payment_info = Payment::where('pay_id', 4)->where('enabled', 1)->first();
                $payment = unserialize_config($payment_info->pay_config);
                //dd($payment);
                $order['user_name'] = $user->user_name;
                $order['pay_desc'] = Payment::where('pay_id', $order->pay_id)->where('enabled', 1)->pluck('pay_desc');
                $pay_obj = new upop();
                $unionpay = $pay_obj->get_code($order, $payment);
                //dd($order);
//            $unionpay = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="'.route('union.pay').'" method="get" target="_blank">
//                <input class="J_payonline" value="银联支付" type="submit">
//                <input value="'.$order->order_id.'" name="id" type="hidden">
//                <input value="'.route('union.search',['id'=>$order->order_id]).'" type="hidden" id="searchUrlUnion">
//                </form>';
                $abcpay = $this->button($order, 5);

                /**
                 * 兴业银行支付
                 */
                $xyyh = $this->button($order, 6);

                /**
                 * 微信扫码支付
                 */
                $weixin = $this->button($order, 9);

                /**
                 * 支付宝扫码支付
                 */
                $alipay = $this->button($order, 9);
                if ($order->pay_id == 8) {
                    $this->arr['zfbzz'] = $this->button($order, 8);
                }

                $this->arr['unionpay'] = $unionpay;
                $this->arr['abcpay'] = $abcpay;
                $this->arr['xyyh'] = $xyyh;
                $this->arr['weixin'] = $weixin;
                $this->arr['alipay'] = $alipay;
            }
        }
        return view('orderInfo')->with($this->arr);
    }

    /*
     * 追加使用余额
     */
    public function useSurplus(Request $request)
    {
        $surplus = floatval($request->input('surplus'));
        if ($surplus <= 0) {
            return redirect()->back();
        } else {
            $user = Auth::user();
            $orderId = $request->input('orderId');
            $orderInfo = OrderInfo::where('is_mhj', 0)
                ->select('order_id', 'order_sn', 'order_amount', 'order_status', 'pay_status', 'surplus', 'user_id', 'is_zq', 'goods_amount', 'mobile_pay')
                ->findOrfail($orderId);
            $this->authorize('update-post', $orderInfo);
            if ($orderInfo) {
                if ($orderInfo->order_status != 1 || $orderInfo->pay_status == 2) {
                    return view('message')->with(messageSys('该订单不用付款', route('user.orderList'), [
                        [
                            'url' => route('user.orderList'),
                            'info' => '返回订单列表',
                        ],
                    ]));
                } else {
                    if ($orderInfo->is_zq == 1 || $orderInfo->is_zq == 2) {
                        return view('message')->with(messageSys('账期订单不能直接支付', route('user.orderList'), [
                            [
                                'url' => route('user.orderList'),
                                'info' => '返回订单列表',
                            ],
                        ]));
                    }
                    $surplus = min([$orderInfo->order_amount, $surplus, $user->user_money]);
                    if ($surplus > 0) {//记录余额变动
                        if ($orderInfo->mobile_pay == -2) {
                            return view('message')->with(messageSys('充值包不能使用余额', route('user.orderList'), [
                                [
                                    'url' => route('user.orderList'),
                                    'info' => '返回订单列表',
                                ],
                            ]));
                        }
                        //dd($order_info->surplus);
                        $orderInfo->surplus = $orderInfo->surplus + $surplus;
                        $orderInfo->order_amount = $orderInfo->order_amount - $surplus;
                        if ($orderInfo->order_amount == 0) {
                            $orderInfo->pay_status = 2;
                            $orderInfo->pay_time = time();
                        }
                        //dd($orderInfo);
                        DB::transaction(function () use ($orderInfo, $user, $surplus) {//数据库事务
                            $orderInfo->save();
                            log_account_change($user->user_id, $surplus * (-1), 0, 0, 0, '支付订单' . $orderInfo->order_sn);  //2015-7-27
                        });
                        $youhuiq = new YouHuiController($orderInfo, $user, true);
                        $youhuiq->up_yhq();
                        return redirect()->route('user.orderInfo', ['id' => $orderId]);
                    } else {
                        return redirect()->back();
                    }
                }
            } else {
                return redirect()->back();
            }
        }
    }

    /*
     * 再次购买
     */
    public function orderBuy(Request $request)
    {
        $orderId = $request->input('id');
        $is_zq = intval($request->input('is_zq', 0));//订单编号
        $is_separate = intval($request->input('is_separate', 0));//订单编号
        $cart_num = cart_info(0);
        $take_num = 220 - $cart_num;

        $ids = OrderGoods::where('order_id', $orderId)->take($take_num)->where('parent_id', 0)->lists('goods_id');

        $result = orderBuy($ids, $this->user);
        if (!empty($result['insert_cart'])) {
            //dd($result);
            Cart::insert($result['insert_cart']);
            Cache::tags([$this->user->user_id, 'cart'])->increment('num', count($result['insert_cart']));
        }
        return view('message')->with(messageSys($result['messages'], route('user.orderList'), [
            [
                'url' => route('cart.index'),
                'info' => '前往购物车结算',
            ],
            [
                'url' => route('user.orderList'),
                'info' => '返回我的订单',
            ],
        ]));
    }

    /*
     * 我的收藏
     */
    public function collectList(Request $request)
    {
        $type = $request->input('type', 0);
        $user = Auth::user()->is_new_user();
        $collection = DB::table('collect_goods as cg')
            ->leftJoin('goods as g', 'cg.goods_id', '=', 'g.goods_id')
            //->leftJoin('order_goods as og','og.goods_id','=','g.goods_id')
            //->leftjoin('order_info as oi','og.order_id','=','oi.order_id')
            ->where('cg.user_id', $user->user_id)->where('g.goods_id', '>', 0);
        if ($type > 0) {
            $collection = $collection->where('g.show_area', 'like', '%' . $type . '%');
        }
        $collection = $collection->select('g.goods_id', 'cg.rec_id')
            ->orderBy('cg.add_time', 'desc')
            ->Paginate(20);
        $ids = [];
        $rec_ids = [];
        foreach ($collection as $v) {
            $ids[] = $v->goods_id;
            $rec_ids[$v->goods_id] = $v->rec_id;
        }
        $goods_list = Goods::with('goods_attr', 'goods_attribute')->whereIn('goods_id', $ids)->get();
        foreach ($goods_list as $k => $v) {
            $v = Goods::attr($v, $user);
            $v = Goods::area_xg($v, $user);
            if ($v->is_can_buy == 0) {
                CollectGoods::where('goods_id', $v->goods_id)->where('user_id', $user->user_id)->delete();
                unset($goods_list[$k]);
            } else {
                $v->rec_id = $rec_ids[$v->goods_id];
                $v->cgcs = DB::table('order_goods as og')->leftjoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
                    ->where('og.goods_id', $v->goods_id)->where('oi.user_id', $user->user_id)
                    ->pluck(DB::raw('count(*) as cgcs'));
            }
        }
        $collection->goods = $goods_list;
        $this->arr['action'] = 'collectList';
        $this->arr['pages'] = $collection;
        $this->arr['type'] = $type;
        return view('collectList')->with($this->arr);
    }

    /*
     * 取消收藏
     */
    public function deleteCollect(Request $request)
    {
        $id = $request->input('id');
        //$collection = new CollectGoods();
        CollectGoods::destroy($id);
        return redirect()->back();
    }

    /*
     * 批量取消收藏
     */
    public function deleteCollectPl(Request $request)
    {
        $id = $request->input('ids');
        $user = Auth::user();
        CollectGoods::whereIn('goods_id', $id)->where('user_id', $user->user_id)->delete();
        return redirect()->back();

    }

    /*
     * 智能采购
     */
    public function zncg()
    {
        $user = Auth::user()->is_new_user();
        $query = DB::table('order_info as oi')
            ->leftJoin('order_goods as og', 'oi.order_id', '=', 'og.order_id')
            ->leftJoin('goods as g', 'g.goods_id', '=', 'og.goods_id')
            ->where('oi.user_id', $user->user_id)->where('oi.pay_status', 2)->where('og.parent_id', 0)->where('g.goods_id', '>', 0)
            ->select(DB::raw('count(*) as goods_number'), 'g.goods_id')
            ->groupBy('og.goods_id');
        $query1 = DB::table('old_order_info as oi')
            ->leftJoin('old_order_goods as og', 'oi.order_id', '=', 'og.order_id')
            ->leftJoin('goods as g', 'g.goods_id', '=', 'og.goods_id')
            ->where('oi.user_id', $user->user_id)->where('oi.pay_status', 2)->where('og.parent_id', 0)->where('g.goods_id', '>', 0)
            ->select(DB::raw('count(*) as goods_number'), 'g.goods_id')
            ->groupBy('og.goods_id');
        $union = $query->unionAll($query1);
        $sql = DB::table(DB::raw("({$union->toSql()}) as ecs_og"))
            ->mergeBindings($union);
        $zncg = $sql->groupBy('og.goods_id')
            ->Paginate(20);
        $ids = [];
        $cgcs = [];
        foreach ($zncg as $v) {
            $ids[] = $v->goods_id;
            $cgcs[$v->goods_id] = $v->goods_number;
        }
        $goods_list = Goods::with('goods_attr', 'goods_attribute', 'member_price')->whereIn('goods_id', $ids)->get();
        foreach ($goods_list as $v) {
            $v = Goods::attr($v, $user, 0);
            $v = Goods::area_xg($v, $user);
            $v->goods_number = $cgcs[$v->goods_id];
        }
        $zncg->goods = $goods_list;
        $this->arr['action'] = 'zncg';
        $this->arr['pages'] = $zncg;
        return view('zncg')->with($this->arr);
    }

    /*
     * 批量购买
     */
    public function plBuy(Request $request)
    {
        $user = Auth::user()->is_new_user();
        $ids = $request->input('ids');
        $result = orderBuy($ids, $user);
        if (!empty($result['insert_cart'])) {

            Cart::insert($result['insert_cart']);
            Cache::tags([$user->user_id, 'cart'])->increment('num', count($result['insert_cart']));
        }
        return view('message')->with(messageSys($result['messages'], $request->server('HTTP_REFERER'), [
            [
                'url' => route('cart.index'),
                'info' => '前往购物车结算',
            ],
        ]));
    }

    /*
     * 基本信息
     */
    public function profile()
    {
        $user = Auth::user();
        $birth = explode('-', $user->birthday);
        $year = "";
        for ($i = 2010; $i > 1949; $i--) {
            if ($birth[0] == $i) {
                $year .= "<option value='$i' selected >$i</option>";
            } else {
                $year .= "<option value='$i'>$i</option>";
            }
        }
        $month = "";
        for ($i = 1; $i < 13; $i++) {
            if ($birth[1] == $i) {
                $month .= "<option value='" . sprintf('%02d', $i) . "' selected >" . sprintf('%02d', $i) . "</option>";
            } else {
                $month .= "<option value='" . sprintf('%02d', $i) . "'>" . sprintf('%02d', $i) . "</option>";
            }
        }
        $day = "";
        for ($i = 1; $i < 32; $i++) {
            if ($birth[2] == $i) {
                $day .= "<option value='" . sprintf('%02d', $i) . "' selected >" . sprintf('%02d', $i) . "</option>";
            } else {
                $day .= "<option value='" . sprintf('%02d', $i) . "'>" . sprintf('%02d', $i) . "</option>";
            }
        }
        $this->arr['action'] = 'profile';
        $this->arr['year'] = $year;
        $this->arr['month'] = $month;
        $this->arr['day'] = $day;
        return view('profile')->with($this->arr);
    }

    /*
     * 基本信息更新
     */
    public function infoUpdate(Request $request)
    {
        $user = Auth::user();
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');
        $sex = $request->input('sex');
        $email = $request->input('email');
        $qq = $request->input('qq');
        $mobile_phone = $request->input('mobile_phone');
        $birth = $year . "-" . $month . "-" . $day;
        $user->birthday = $birth;
        $user->sex = $sex;
        $user->email = $email;
        $user->qq = $qq;
        $user->mobile_phone = $mobile_phone;
        if ($request->hasFile('ls_file')) {
            $file = $request->file('ls_file');
            if ($file->isValid()) {

                $extension = $file->getClientOriginalExtension();

                //$mimeTye = $file->getMimeType();//文件格式

                $newName = md5(date('ymdhis') . rand(0, 9)) . "." . $extension;

                $path = $file->move('data/feedbackimg', $newName); //图片存放的地址
                $user->ls_file = $path->getFilename();
//                if(!$user->save()){
//                    return '图片保存失败';
//                }
                //print_r($path->getPath());
            }
        }
        if ($user->save()) {
            return view('message')->with(messageSys('您的个人资料已经成功修改', route('user.profile'), [
                [
                    'url' => route('user.profile'),
                    'info' => '查看我的个人资料',
                ],
            ]));
        }
    }

    /*
     * 重置密码
     */
    public function setPwd(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ], [
            'old_password.required' => '原密码不能为空',
            'old_password.min' => '原密码长度至少为6位',
            'password.required' => '新密码不能为空',
            'password.confirmed' => '新密码确认密码不符',
            'password.min' => '新密码长度至少为6位',
        ]);
        //$messages = $validator->errors();
        //print_r($messages->get('password'));die;
        if ($validator->fails()) {
            //print_r($validator->fails());die;
            return redirect('user/profile')
                ->withErrors($validator)
                ->withInput();
        } else {
            $oldPwd = $request->input('old_password');
            $newPwd = $request->input('password');
            $salt = $user->ec_salt;
            if ($salt) {
                $oldPwd_md5 = md5(md5($oldPwd) . $salt);
                $newPwd_md5 = md5(md5($newPwd) . $salt);
                //dd($oldPwd_md5,$user->password);
            } else {
                $oldPwd_md5 = md5($oldPwd);
                $newPwd_md5 = md5($newPwd);
            }
            if ($oldPwd_md5 == $user->password) {
                $user->password = $newPwd_md5;
                if ($user->save()) {
                    return view('message')->with(messageSys('密码重置成功', route('user.profile'), [
                        [
                            'url' => route('user.profile'),
                            'info' => '查看我的个人资料',
                        ],
                    ]));
                }
            } else {
                return view('message')->with(messageSys('原密码错误', route('user.profile'), [
                    [
                        'url' => route('user.profile'),
                        'info' => '查看我的个人资料',
                    ],
                ]));
            }
        }
    }

    /*
     * 余额管理
     */
    public function account()
    {
        $user = Auth::user();
        $userAccount = UserAccount::where('user_id', $user->user_id)
            ->select('amount', 'add_time', 'admin_note', 'user_note', 'process_type', 'is_paid')
            ->Paginate(10);
        $user_money = AccountLog::where('user_id', $user->user_id)->sum('user_money');
        $assign = [
            'page_title' => '用户中心-',
            'user' => $user,
            'action' => 'account',
            'pages' => $userAccount,
            'pagesForm' => '<form action="' . route('user.zncg') . '" type="get" class="submit_input">
        <span>共' . $userAccount->lastPage() . '页</span>
        <span>到第<input name="page" class="page_inout" value="' . $userAccount->currentPage() . '" type="text">页</span>
        <input value="确定" class="submit" type="submit">
    </form>',
            'params' => [
                'url' => 'user.account',
            ],
            'user_money' => $user_money,
        ];
        $this->arr['action'] = 'account';
        $this->arr['pages'] = $userAccount;
        $this->arr['user_money'] = $user_money;
        return view('account')->with($this->arr);
    }

    /*
     * 查看账户明细
     */
    public function accountInfo()
    {
        $user = Auth::user();
        $accountInfo = AccountLog::where('user_id', $user->user_id)->where('user_money', '!=', 0)
            ->select('change_time', 'user_money', 'change_desc')
            ->orderBy('change_time', 'desc')
            ->Paginate(10);
        $user_money = AccountLog::where('user_id', $user->user_id)->sum('user_money');

        $this->arr['action'] = 'account';
        $this->arr['pages'] = $accountInfo;
        $this->arr['user_money'] = $user_money;
        return view('accountInfo')->with($this->arr);
    }

    /*
     * 收货地址
     */
    public function addressList()
    {
        $user = Auth::user();
        $info = UserAddress::where('user_id', $user->user_id)
            ->where('address_id', $this->user->address_id)->first();
        if ($info) {
            $info->region_name = get_region_name([$info->province, $info->city, $info->district], ' ');
        }
        $province = Cache::tags(['shop', 'region'])->remember(1, 8 * 60, function () {
            return Region::where('parent_id', 1)->get();
        });
        $this->arr['action'] = 'addressList';
        $this->arr['info'] = $info;
        $this->arr['province'] = $province;
        return view('addressList')->with($this->arr);
    }

    /*
     * 收货地址更新
     */
    public function addressUpdate(Request $request)
    {
        $user_address = UserAddress::where('user_id', $this->user->user_id)->where('address_id', $this->user->address_id)->first();
        if ($user_address) {
            tips1('改变收货地址请联系客服人员');
        }
        $rules = [
            'required' => '不能为空',
        ];
        $validator = Validator::make($request->all(), [
            'consignee' => 'required',
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
//            'address' => 'required',
            'tel' => 'required',
        ], $rules);
        if ($validator->fails()) {
            //print_r($validator->fails());die;
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = Auth::user();
            $id = $request->input('addressId');
            $address = UserAddress::findOrNew($id);
            if ($address->address_id) {
                $this->authorize('update-post', $address);
            }
            $address->consignee = $request->input('consignee');
            $address->user_id = $user->user_id;
            $address->country = $request->input('country');
            $address->province = $request->input('province');
            $address->city = $request->input('city');
            $address->district = $request->input('district');
            $address->address = '';
            $address->tel = $request->input('tel');
            $address->mobile = $request->input('mobile');
            $address->sign_building = '';
            $address->best_time = '';
            $address->zipcode = $request->input('zipcode', '');
            $act = $request->input('act', 'user');
            if ($address->save()) {
                if ($id == 0) {
                    $user->address_id = $address->address_id;
                } else {
                    $user->address_id = $id;
                }
                $user->save();
                if ($act != 'user') {
                    return redirect()->route('cart.jiesuan');
                } else {
                    if ($id == 0) {
                        $messsage = '您的收货地址信息添加成功';
                    } else {
                        $messsage = '您的收货地址信息已成功更新';
                    }
                    return view('message')->with(messageSys($messsage, route('user.addressList'), [
                        [
                            'url' => route('user.addressList'),
                            'info' => '返回地址列表',
                        ],
                    ]));
                }
            }
        }
    }

    /*
     * 删除收货地址
     */
    public function addressDelete(Request $request)
    {
        if ($this->user->address_id > 0) {
            tips1('改变收货地址请联系客服人员');
        }
        $user = Auth::user();
        $id = $request->input('id');
        $act = $request->input('act', 'user');
        $userAddress = UserAddress::findOrfail($id);
        $this->authorize('update-post', $userAddress);
        if ($userAddress->delete()) {
            if ($user->address_id == $id) {
                $user->address_id = 0;
                $user->save();
            }
            if ($act != 'user') {
                return redirect()->back();
            } else {
                return view('message')->with(messageSys('收货地址删除成功！', route('user.addressList'), [
                    [
                        'url' => route('user.addressList'),
                        'info' => '返回地址列表',
                    ],
                ]));
            }
        }
    }

    /*
     * 物流配送
     */
    public function pswl()
    {
        $user = Auth::user();
        if ($user->shipping_id != -1 && $user->shipping_id != 0) {//不是其他物流
            $pswl = Shipping::where('shipping_id', $user->shipping_id)->pluck('shipping_name');
        } else {
            $pswl = $user->shipping_name;
        }
        $this->arr['action'] = 'pswl';
        $this->arr['pswl'] = $pswl;
        return view('pswl')->with($this->arr);
    }

    /*
     * 我的留言
     */
    public function messageList()
    {
        $user = Auth::user();
        $msg_type = [
            0 => '留言',
            1 => '投诉',
            2 => '询问',
            3 => '售后',
            4 => '求购',
        ];
        $messageList = FeedBack::where('user_id', $user->user_id)->where('parent_id', 0)->where('order_id', 0)
            ->select('msg_id', 'msg_title', 'msg_time', 'msg_content', 'msg_type', 'message_img')
            ->Paginate(10);
        $this->arr['action'] = 'messageList';
        $this->arr['msg_type'] = $msg_type;
        $this->arr['pages'] = $messageList;
        return view('messageList')->with($this->arr);
    }

    /*
     * 订单留言
     */
    public function messageOrder(Request $request)
    {
        $user = Auth::user();
        $orderId = $request->input('id');
        $messageList = FeedBack::where('user_id', $user->user_id)->where('parent_id', 0)->where('order_id', $orderId)
            ->select('msg_id', 'msg_title', 'msg_time', 'msg_content', 'msg_type', 'message_img', 'user_name')
            ->Paginate(10);
        $this->arr['action'] = 'orderList';
        $this->arr['orderId'] = $orderId;
        $this->arr['pages'] = $messageList;
        return view('messageOrder')->with($this->arr);
    }

    /*
     * 添加留言
     */
    public function msgCreate(Request $request)
    {
        $rules = [
            'required' => '不能为空',
            'numeric' => '请输入正确的价格',
            'date_format' => '日期格式不对',
            'integer' => '请输入整数',
        ];
        $validator = Validator::make($request->all(), [
            'msg_type' => 'required',
            'msg_title' => 'required',
            'msg_content' => 'required',
        ], $rules);
        if ($validator->fails()) {
            //print_r($validator->fails());die;
            return redirect('user/messageList')
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = Auth::user();
            $feedback = new FeedBack();
            $feedback->user_id = $user->user_id;
            $feedback->user_name = $user->user_name;
            $feedback->user_email = $user->email;
            $feedback->msg_type = $request->input('msg_type');
            $feedback->msg_title = $request->input('msg_title');
            $feedback->order_id = $request->input('order_id', 0);
            $feedback->msg_time = time();
            $feedback->msg_content = $request->input('msg_content');
            if ($request->hasFile('message_img')) {
                $file = $request->file('message_img');
                if ($file->isValid()) {

                    $extension = $file->getClientOriginalExtension();

                    //$mimeTye = $file->getMimeType();//文件格式

                    $newName = md5(date('ymdhis') . rand(0, 9)) . "." . $extension;

                    $path = $file->move('uploads/feedback', $newName); //图片存放的地址
                    $feedback->message_img = $path->getFilename();
//                if(!$user->save()){
//                    return '图片保存失败';
//                }
                    //print_r($path->getPath());
                }
            }
            if ($feedback->save()) {
                $url = $request->server('HTTP_REFERER');
                return view('message')->with(messageSys('发布留言成功！', $url, [
                    [
                        'url' => $url,
                        'info' => '返回留言列表',
                    ],
                ]));
            }
        }
    }

    /*
     * 删除留言
     */
    public function msgDelete(Request $request)
    {
        $user = Auth::user();
        $id = $request->input('id');
        $feedback = FeedBack::select('user_id', 'message_img', 'msg_id')->findOrfail($id);
        $this->authorize('update-post', $feedback);
        if ($feedback->delete()) {
            @unlink(public_path() . '/uploads/feedback/' . $feedback->message_img);
            $url = $request->server('HTTP_REFERER');
            return view('message')->with(messageSys('删除留言成功！', $url, [
                [
                    'url' => $url,
                    'info' => '返回留言列表',
                ],
            ]));
        }
    }

    /*
     * 我的求购
     */
    public function buyList()
    {
        $user = Auth::user();
        $buyList = Buy::where('buy_username', $user->user_name)
            ->Paginate(10);
        $this->arr['action'] = 'buyList';
        $this->arr['pages'] = $buyList;
        $this->arr['pages'] = $buyList;
        return view('buyList')->with($this->arr);
    }

    /*
     * 增加求购页面
     */
    public function buyNew()
    {
        $user = Auth::user();
        $this->arr['action'] = 'buyList';
        $this->arr['submitText'] = '增加求购';
        return view('buyNew')->with($this->arr);
    }

    /*
     * 修改求购页面
     */
    public function buyUpdate(Request $request)
    {
        $user = Auth::user();
        $id = $request->input('id');
        $buy = Buy::where('buy_username', $user->user_name)->where('buy_id', $id)->first();
        $this->arr['action'] = 'buyList';
        $this->arr['submitText'] = '修改求购';
        $this->arr['buy'] = $buy;
        return view('buyNew')->with($this->arr);
    }

    /*
     * 增加求购到数据库
     */
    public function buyCreate(Request $request)
    {
        $rules = [
            'required' => '不能为空',
            'numeric' => '请输入正确的价格',
            'date_format' => '日期格式不对',
            'integer' => '请输入整数',
        ];
        $validator = Validator::make($request->all(), [
            'buy_name' => 'required',
            'buy_tel' => 'required',
            'buy_goods' => 'required',
            'product_name' => 'required',
            'buy_spec' => 'required',
            'buy_number' => 'required|integer',
            'buy_price' => 'required|numeric',
            'buy_time' => 'required|date_format:Y.m.d',
        ], $rules);
        //$messages = $validator->errors();
        //print_r($messages->get('password'));die;
        if ($validator->fails()) {
            //print_r($validator->fails());die;
            return redirect('user/buyNew')
                ->withErrors($validator)
                ->withInput();
        } else {
            $buy_id = $request->input('buy_id');
            $user = Auth::user();
            $buy = Buy::findOrNew($buy_id);
//            if($buy->buy_id) {
//                $this->authorize('update-post',$buy);
//            }
            $buy->buy_username = $user->user_name;
            $buy->buy_name = $request->input('buy_name');
            $buy->buy_tel = $request->input('buy_tel');
            $buy->buy_goods = $request->input('buy_goods');
            $buy->product_name = $request->input('product_name');
            $buy->buy_spec = $request->input('buy_spec');
            $buy->buy_number = $request->input('buy_number');
            $buy->buy_price = $request->input('buy_price');
            $buy->buy_time = $request->input('buy_time');
            $buy->message = $request->input('message');
            $buy->buy_addtime = time();
            if ($buy->save()) {
                if ($buy_id == 0) {
                    $message = "增加求购信息成功!";
                } else {
                    $message = "修改求购信息成功!";
                }
                return view('message')->with(messageSys($message, route('user.buyList'), [
                    [
                        'url' => route('user.buyList'),
                        'info' => '返回求购列表',
                    ],
                ]));
            }
        }
    }

    /*
     * 注册成功跳转页面
     */
    public function regMsg()
    {
        $assign = [
            'title' => '系统提示',
            'user' => auth()->user(),
        ];
        return view('auth.message')->with($assign);
    }

    /*
 * 注册送优惠券
 */
    public function reg_success()
    {
        $this->arr['title'] = '系统提示';
        return view('auth.yhq_msg')->with($this->arr);
    }

    /**
     * 充值余额使用记录
     */
    public function czjl()
    {
        $arr = $this->arr;
        $user = auth()->user();
        $user_jnmj = UserJnmj::where('user_id', $user->user_id)->first();
//        if (!$user_jnmj) {
//            return view('message')->with(messageSys('您所请求的页面不存在', route('user.buyList'), [
//                [
//                    'url'  => route('user.buyList'),
//                    'info' => '返回求购列表',
//                ],
//            ]));
//        }
        $jnmj_log = JnmjLog::where('user_id', $user->user_id)
            ->select(DB::raw('*,jnmj_money as change_amount'))
            ->orderBy('log_id', 'desc')->Paginate(10);
        //dd($jnmj_log);
        $arr['pages'] = $jnmj_log;
        $arr['action'] = '';
        $arr['pages_top'] = '易诊云充值余额变动记录';
        $arr['user_jnmj'] = $user_jnmj;
        $arr['page_title'] = '用户中心-';
        $arr['pages_url'] = 'user.czjl';
        $arr['pages_text'] = '<tr><td colspan="4" class="al_right"><p class="balance">您当前的可用易诊云充值余额为:' . formated_price(collect($user_jnmj)->get('jnmj_amount', 0)) . '</p></td></tr>';
        return view('czjl')->with($arr);
    }

    /**
     * 账期额度变动记录
     */
    public function zq_log()
    {
        $arr = $this->arr;
        $user = auth()->user();
        if ($user->is_zq == 0) {//未开通账期
            return view('message')->with(messageSys('您所请求的页面不存在', route('user.buyList'), [
                [
                    'url' => route('user.buyList'),
                    'info' => '返回求购列表',
                ],
            ]));
        }
        if ($user->is_zq == 2) {
            $zq_ywy = ZqYwy::find($this->user->user_id);
            $user->zq_rq = $zq_ywy->zq_rq;
            $user->zq_ywy = $zq_ywy->zq_ywy;
            $user->zq_amount = $zq_ywy->zq_amount;
            $user->zq_je = $zq_ywy->zq_je;
            $user->zq_has = $zq_ywy->zq_has;
            $user->zq_start_date = $zq_ywy->zq_start_date;
            $user->zq_end_date = $zq_ywy->zq_end_date;
            $zq_log = ZqLogYwy::where('user_id', $user->user_id)
                ->orderBy('log_id', 'desc')->Paginate(10);
        } else {
            $zq_log = ZqLog::where('user_id', $user->user_id)
                ->orderBy('log_id', 'desc')->Paginate(10);
        }
        $arr['pages'] = $zq_log;
        $arr['user'] = $user;
        $arr['action'] = 'zq_log';
        $arr['pages_top'] = '账期变动记录';
        $arr['page_title'] = '用户中心-';
        $arr['pages_url'] = 'user.zq_log';
        $arr['pages_text'] = '<tr><td colspan="4" class="al_right"><p class="balance">您当前的账期剩余额度为:' . formated_price($user->zq_je - $user->zq_amount) . '</p></td></tr>';
        return view('czjl')->with($arr);
    }

    /**
     * 账期汇总订单
     */
    public function zq_order(Request $request)
    {
        $arr = $this->arr;
        $user = auth()->user();
//        if($this->user->is_zq==1) {
//            $zq_order = ZqOrder::where('user_id', $user->user_id)->where('order_status', '!=', 2)->orderBy('zq_id', 'desc')->Paginate(10);
//        }else{
//            $zq_order = ZqOrderYwy::where('user_id', $user->user_id)->where('order_status', '!=', 2)->orderBy('zq_id', 'desc')->Paginate(10);
//        }
        $query1 = ZqOrder::where('user_id', $user->user_id)->where('order_status', '!=', 2);
        $query2 = ZqOrderYwy::where('user_id', $user->user_id)->where('order_status', '!=', 2);
        $count = $query1->count();
        $count += $query2->count();
        $zq_order = $query1->unionAll($query2)->orderBy('zq_id', 'desc')->Paginate(10, ['*'], 'page', $request->input('page'), $count);
        $arr['pages'] = $zq_order;
        $arr['action'] = 'zq_order';
        $arr['pages_top'] = '账期汇总订单列表';
        $arr['page_title'] = '用户中心-';
        $arr['pages_url'] = 'user.zq_order';
        $arr['pages_text'] = '<tr><td colspan="4" class="al_right"><p class="balance">您当前的账期剩余额度为:' . formated_price($user->zq_je - $user->zq_amount) . '</p></td></tr>';
        return view('zq_order')->with($arr);

    }

    /**
     * 账期汇总订单详情
     */
    public function zq_order_info(Request $request)
    {
        $arr = $this->arr;
        $user = auth()->user();
        $id = intval($request->input('id', 0));
        $zq_order = ZqOrder::with([
            'order_info' => function ($query) {
                $query->where('user_id', $this->user->user_id)->where('order_status', 1)->where('is_zq', 1)->select('zq_id', 'order_amount', 'order_id', 'goods_amount', 'order_sn', 'add_time', 'order_status', 'pay_status', 'shipping_status');
            }
        ])->where('user_id', $user->user_id)->where('zq_id', $id)->first();
        $is_zq = 1;
        if (!$zq_order) {
            $zq_order = ZqOrderYwy::with([
                'order_info' => function ($query) {
                    $query->where('user_id', $this->user->user_id)->where('order_status', 1)->where('is_zq', 2)->select('zq_id', 'order_amount', 'order_id', 'goods_amount', 'order_sn', 'add_time', 'order_status', 'pay_status', 'shipping_status');
                }
            ])->where('user_id', $user->user_id)->where('zq_id', $id)->first();
            $is_zq = 2;
        }
        if (!$zq_order) {
            return view('message')->with(messageSys('您所请求的页面不存在', route('user.buyList'), [
                [
                    'url' => route('user.index'),
                    'info' => '返回会员中心',
                ],
            ]));
        }
        $order_amount = 0;
        if ($zq_order->order_info) {
            foreach ($zq_order->order_info as $v) {
                $order_amount += $v->order_amount;
            }
        }
        if ($zq_order->pay_status != 2 && $zq_order->order_status == 1 && $zq_order->order_amount > 0) {
            if (abs($order_amount - $zq_order->goods_amount) < 0.000001) {
                //银联支付
                $user = auth()->user();
                $payment_info = Payment::where('pay_id', 4)->where('enabled', 1)->first();
                $payment = unserialize_config($payment_info->pay_config);
                //dd($payment);
                $order['user_name'] = $user->user_name;
                $order['pay_desc'] = $payment_info->pay_desc;
                $order['order_amount'] = $zq_order->order_amount;
                $order['order_id'] = $zq_order->zq_id;
                $order['order_sn'] = $zq_order->order_sn;
                $pay_obj = new upop();
                if ($is_zq == 1) {
                    $unionpay = $pay_obj->get_code_zq($order, $payment);
                } else {
                    $unionpay = $pay_obj->get_code_zq_ywy($order, $payment);
                }
                $zq_order->order_id = $zq_order->zq_id;
                $abcpay = $this->button($zq_order, 5, $is_zq);

                /**
                 * 兴业银行支付
                 */
                $xyyh = $this->button($zq_order, 6, $is_zq);

                /**
                 * 微信扫码支付
                 */
                $weixin = $this->button($zq_order, 7, $is_zq);

                $alipay = $this->button($zq_order, 9, $is_zq);
                $arr['unionpay'] = $unionpay;
                $arr['abcpay'] = $abcpay;
                $arr['xyyh'] = $xyyh;
                $arr['weixin'] = $weixin;
                $arr['alipay'] = $alipay;
            } else {
                $arr['tip'] = '<span style="color: rgb(255, 97, 2);font-size: 14px;margin-left: 10px;">订单金额不符</span>';
            }
        }
        $arr['order'] = $zq_order;
        $arr['action'] = 'zq_order';
        $arr['pages_top'] = '账期汇总订单详情';
        $arr['page_title'] = '用户中心-';
        //dd($arr);
        return view('zq_order_info')->with($arr);

    }

    public function payOk(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type', 0);
        $next = intval($request->input('next'));
        if ($next == 1) {
            $info = OrderInfo::find($id);
            $wntj = Goods::rqdp('is_wntj', 10, -4);
            $this->arr['page_title'] = '订单支付成功-';
            $this->arr['info'] = $info;
            $this->arr['wntj'] = $wntj;
            return view('cart.payOk', $this->arr);
        }
        if ($type == 1 || $type == 2) {
            return view('message')->with(messageSys('订单支付成功', route('user.zq_order_info', ['id' => $id]), [
                [
                    'url' => route('user.zq_order'),
                    'info' => '返回订单列表',
                ],
            ]));
        } elseif ($type == 3) {
            return view('message')->with(messageSys('订单支付成功', route('user.zq_order_info_sy', ['id' => $id]), [
                [
                    'url' => route('user.zq_order_sy'),
                    'info' => '返回订单列表',
                ],
            ]));
        } elseif ($type == 4) {
            return view('message')->with(messageSys('订单支付成功', route('user.cz_order_info', ['id' => $id]), [
                [
                    'url' => route('user.cz_order'),
                    'info' => '返回充值订单列表',
                ],
            ]));
        }
        return view('message')->with(messageSys('订单支付成功', route('user.orderInfo', ['id' => $id]), [
            [
                'url' => route('user.orderList'),
                'info' => '返回订单列表',
            ],
        ]));
    }

    /**
     * 跳转质检报告
     */
    public function zhijian()
    {
        $wldwid1 = $this->user->wldwid1;
        $pwd = md5($wldwid1 . substr($wldwid1, -4) . 'yyg');
        $url = 'http://www.51yywd.com/user/hzapi/dwid/' . $wldwid1 . '/pwd/' . $pwd;
        return redirect()->to($url);
    }

    /**
     * 优惠券
     */
    public function youhuiq()
    {
        $user_rank = array(
            1 => '连锁公司',
            2 => '药店',
            5 => '诊所',
            6 => '黑名单',
            7 => '商业公司',
        );
        $now = time();
        $youhuiq = YouHuiQ::with('yhq_cate')->where('user_id', $this->user->user_id)
            ->where('status', 0)
            ->where('union_type', '!=', 3)
            ->where('sctj', '!=', 7)
            //->where('start','<=',$now)
            ->where('end', '>=', $now)
            ->where('enabled', 1);
        if (time() < strtotime('20161112')) {
            $youhuiq->where('sctj', '!=', 3);
        }
        $youhuiq = $youhuiq->orderBy('union_type')->orderBy('end')->orderBy('start')->orderBy('je')
            ->get();

        $province = Cache::tags(['shop', 'region'])->remember(1, 8 * 60, function () {
            return Region::where('parent_id', 1)->get();
        });
        foreach ($youhuiq as $k => $v) {
            $check = 1;
            if (!empty($v->user_rank)) {
                $user_rank_arr = explode(',', $v->user_rank);
                if (!in_array($this->user->user_rank, $user_rank_arr)) {
                    unset($youhuiq[$k]);
                    $check = 0;
                }
            }
            if (!empty($v->area)) {
                $area_arr = explode(',', $v->area);
                if (!in_array($this->user->province, $area_arr)) {
                    unset($youhuiq[$k]);
                    $check = 0;
                }
            }

            if ($check == 1) {
                $user_rank_str = [];
                $area_str = [];

                if (!empty($v->user_rank)) {
                    $v->user_rank = explode(',', $v->user_rank);
                    foreach ($v->user_rank as $val) {
                        if (isset($user_rank[$val])) {
                            $user_rank_str[] = $user_rank[$val];
                        }
                    }
                    $v->user_rank = implode(',', $user_rank_str);
                    $v->user_rank = '限' . $v->user_rank . '使用';
                } else {
                    $v->user_rank = '所有等级' . '使用';
                }
                if (!empty($v->area)) {
                    $v->area = explode(',', $v->area);
                    foreach ($v->area as $val) {
                        $region = $province->find($val);
                        $region_name = $region ? $region->region_name : '未知';
                        if (!empty($region_name)) {
                            $area_str[] = $region_name;
                        }
                    }
                    $v->area = implode(',', $area_str);
                    $v->area = '限' . $v->area . '可以使用';
                } else {
                    $v->area = '所有省份可以使用';
                }
            }
        }
        $this->arr['pages'] = $youhuiq;
        $this->arr['pages_top'] = '优惠券管理';
        $this->arr['action'] = 'youhuiq';
        return view('youhuiq', $this->arr);
    }

    public function dzfp()
    {
        $wldwid1 = $this->user->wldwid1;
        $url = 'http://www.dzfpcx.cn/dzfp/index.html#/wldwid/8171/' . $wldwid1 . '/' . $this->user->mobile_phone;
        return redirect()->to($url);
    }


    /**
     * 宅急送
     */
    public function zjs(Request $request)
    {
        $id = intval($request->input('id'));//订单编号
        $is_zq = intval($request->input('is_zq', 0));//订单编号
        $is_separate = intval($request->input('is_separate', 0));//订单编号
        if ($is_zq == 0 && $is_separate == 0 && $id <= 203538) {
            $order = OldOrderInfo::user($this->user->user_id)->where('order_id', $id);
        } else {
            $order = OrderInfo::user($this->user->user_id)->where('order_id', $id);
        }
        $order = $order->select('invoice_no', 'order_sn', 'order_id', 'add_time', 'consignee')->first();
        if (empty($order)) {
            show_msg('订单不存在', route('user.orderList'), '前往订单列表');
        }
        //$order = "0971097806  0971097816   0971097820   0971097831   0971097842   0971097853";
        $dh = explode(' ', $order->invoice_no);
        $dh_xml = "<order>
<mailNo>%s</mailNo>
</order>";
        $dh_str = '';
        foreach ($dh as $k => $v) {
            if (empty($v)) {
                unset($dh[$k]);
            } else {
                $v = trim($v);
                $dh_str .= sprintf($dh_xml, $v);
            }
        }

        $val = "<BatchQueryRequest>
<logisticProviderID>HZ_YiYao</logisticProviderID>
<orders>
%s
</orders>
</BatchQueryRequest>";
        $val = sprintf($val, $dh_str);
        //dd($val);
        $sjs1 = rand(1000, 9999);
        $sjs2 = rand(1000, 9999);
        $bz = "HZ_YiYao";
        $miyao = "981D965E-A63D-471F-8C7C-2403836E8BA5";
        $cs = "z宅J急S送g";
        $str = $sjs1 . $bz . $val . $miyao . $cs . $sjs2;
        $str = md5($str);
        $verifyData = $sjs1 . substr($str, 7, 21) . $sjs2;
        //dd($verifyData);
        $postdata = 'clientFlag=' . $bz . '&xml=' . $val . '&verifyData=' . $verifyData;
        $ch = curl_init(); //创建一个curl
// 2. 设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, "http://edi.zjs.com.cn/svst/tracking.asmx/Get");
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
// 3. 执行并获取HTML文档内容
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
// 4. 释放curl句柄
        curl_close($ch);
        if ($output === FALSE) {
            show_msg(curl_error($ch));
        } else {

            $output = str_replace(array('&lt;', '&gt;'), array('<', '>'), $output);
            $output = substr($output, 79);
            $output = str_replace('</string>', '', $output);
            $xml_str = simplexml_load_string($output);
            $orders = [];
            foreach ($xml_str->orders->order as $v) {
                $steps = [];
                $arr['mailNo'] = $v->mailNo;
                $arr['signinPer'] = $v->signinPer;
                $arr['remark'] = $v->remark;

                foreach ($v->steps->step as $val) {
                    $step['acceptTime'] = $val->acceptTime;
                    $step['acceptAddress'] = $val->acceptAddress;
                    $steps[strtotime($val->acceptTime)] = $step;
                }
                krsort($steps);
                $arr['steps'] = $steps;
                $orders[] = $arr;
            }
            //dd($orders, $xml_str->logisticProviderID);
            $this->arr['order'] = $order;
            $this->arr['orders'] = $orders;
            return view('zjs')->with($this->arr);
        }
    }

    /**
     * 站内信
     */
    public function znx_list(Request $request, MessageUsers $messageUsers)
    {
        $this->user = auth()->user()->is_zhongduan();
        $query = $messageUsers->with('message')->where('user_id', $this->user->user_id)
            ->where('status', '!=', 2);
        $status = intval($request->input('status'));
        if ($status > 0) {
            $query->where('status', $status - 1);
        }
        $result = $query->orderBy('rec_id', 'desc')->Paginate();
        $full_page = intval($request->input('full_page', 1));
        if ($full_page == 1) {
            $view = 'index';
        } else {
            $view = 'lists';
        }
        $this->arr['action'] = 'znx';
        $this->arr['status'] = $status;
        $this->arr['full_page'] = $full_page;
        $this->arr['pages'] = $result;
//        $messageUsers->where('user_id', $this->user->user_id)
//            ->where('status', 0)->update([
//                'status' => 1
//            ]);
        $now = time();
        $start = strtotime(20170906);
        $end = strtotime(20170907);
        if ($now >= $start && $now < $end && $this->user->is_zhongduan == 1) {
            $info = AccountLog::where('user_id', $this->user->user_id)->where('pay_points', 500)
                ->where('change_desc', '9月6日点击我的消息送积分')->first();
            if (!$info) {
                log_account_change($this->user->user_id, 0, 0, 0, 500, '9月6日点击我的消息送积分');  //2015-7-27
                $this->arr['sjf'] = 1;
            }
        }
        return view('message.' . $view)->with($this->arr);
    }

    /**
     * 站内信详情
     */
    public function znx_info(Request $request, MessageUsers $messageUsers)
    {
        $id = $request->input('id');
        $info = $messageUsers->with('message')->where('user_id', $this->user->user_id)
            ->where('msg_id', $id)
            ->where('status', '!=', 2)->first();
        if (!$info) {
            show_msg('信息不存在', route('user.znx_list'), '前往系统消息列表');
        }
        if (!$info->message) {
            show_msg('信息不存在', route('user.znx_list'), '前往系统消息列表');
        }
        $info->status = 1;
        $info->save();
        $this->arr['info'] = $info;
        return view('message.info')->with($this->arr);
    }

    public function yd_znx(Request $request, MessageUsers $messageUsers)
    {
        $str = trim($request->input('str', ''), ',');
        if (empty($str)) {
            ajax_return('未选中任何信息', 1);
        }
        $ids = explode(',', $str);
        foreach ($ids as $k => $v) {
            if (empty($v)) {
                unset($ids[$k]);
            }
        }
        if (count($ids) == 0) {
            ajax_return('未选中任何信息', 1);
        }
        $msg_count = msg_count();
        Cache::tags($this->user->user_id)->decrement('msg_count');
        $messageUsers->where('user_id', $this->user->user_id)->whereIn('msg_id', $ids)->update([
            'status' => 1,
            'update_time' => time(),
        ]);
        ajax_return('操作成功', 0, ['msg_count' => $msg_count - 1]);
    }

    public function shanchu_znx(Request $request, MessageUsers $messageUsers)
    {
        $str = trim($request->input('str', ''), ',');
        if (empty($str)) {
            ajax_return('未选中任何信息', 1);
        }
        $ids = explode(',', $str);
        foreach ($ids as $k => $v) {
            if (empty($v)) {
                unset($ids[$k]);
            }
        }
        if (count($ids) == 0) {
            ajax_return('未选中任何信息', 1);
        }
        $messageUsers->where('user_id', $this->user->user_id)->whereIn('msg_id', $ids)->update([
            'status' => 2,
            'delete_time' => time(),
        ]);
        ajax_return('操作成功');
    }

    protected function check_date($date)
    {
        if (empty(($date))) {
            return 1;
        }
        $y = intval(date('Y'));
        $m = intval(date('m'));
        $d = intval(date('d'));
        $time = $y . '-' . $m . '-' . $d;
        if ($date >= $time) {
            return 1;
        }
        return 0;
    }


    /**
     * 尚医账期汇总订单
     */
    public function zq_order_sy()
    {
        $arr = $this->arr;
        $user = auth()->user();
        $sy_zq = ZqSy::find($user->user_id);
        $zq_order = ZqOrderSy::where('user_id', $user->user_id)->where('order_status', '!=', 2)->orderBy('zq_id', 'desc')->Paginate(10);
        if (!$sy_zq) {
            show_msg('未开通尚医账期');
        }
        $arr['pages'] = $zq_order;
        $arr['action'] = 'zq_order_sy';
        $arr['pages_top'] = '尚医账期汇总订单列表';
        $arr['page_title'] = '用户中心-';
        $arr['pages_url'] = 'user.zq_order_sy';
        $arr['pages_text'] = '<tr><td colspan="4" class="al_right"><p class="balance">您当前的账期剩余额度为:' . formated_price($sy_zq->zq_je - $sy_zq->zq_amount) . '</p></td></tr>';
        return view('zq_sy/zq_order')->with($arr);

    }

    /**
     * 账期汇总订单详情
     */
    public function zq_order_info_sy(Request $request)
    {
        $arr = $this->arr;
        $user = auth()->user();
        $id = intval($request->input('id', 0));
        $sy_zq = ZqSy::find($user->user_id);
        $zq_order = ZqOrderSy::with([
            'order_info' => function ($query) {
                $query->where('user_id', $this->user->user_id)->where('order_status', 1)->where('is_zq', 3)->select('zq_id', 'order_amount', 'order_id', 'goods_amount', 'order_sn', 'add_time', 'order_status', 'pay_status', 'shipping_status');
            }
        ])->where('user_id', $user->user_id)->where('zq_id', $id)->first();
        if (!$zq_order) {
            return view('message')->with(messageSys('您所请求的页面不存在', route('user.buyList'), [
                [
                    'url' => route('user.index'),
                    'info' => '返回会员中心',
                ],
            ]));
        }
        $order_amount = 0;
        if ($zq_order->order_info) {
            foreach ($zq_order->order_info as $v) {
                $order_amount += $v->order_amount;
            }
        }
        if ($zq_order->pay_status != 2 && $zq_order->order_status == 1 && $zq_order->order_amount > 0) {
            if (abs($order_amount - $zq_order->goods_amount) < 0.000001) {
                //银联支付
                $user = auth()->user();
                $payment_info = Payment::where('pay_id', 4)->where('enabled', 1)->first();
                $payment = unserialize_config($payment_info->pay_config);
                //dd($payment);
                $order['user_name'] = $user->user_name;
                $order['pay_desc'] = $payment_info->pay_desc;
                $order['order_amount'] = $zq_order->order_amount;
                $order['order_id'] = $zq_order->zq_id;
                $order['order_sn'] = $zq_order->order_sn;
                $pay_obj = new upop();

                $unionpay = $pay_obj->get_code_zq_sy($order, $payment);

                $zq_order->order_id = $zq_order->zq_id;
                $abcpay = $this->button($zq_order, 5, 3);

                /**
                 * 兴业银行支付
                 */
                $xyyh = $this->button($zq_order, 6, 3);

                /**
                 * 微信扫码支付
                 */
                $weixin = $this->button($zq_order, 7, 3);
                $arr['unionpay'] = $unionpay;
                $arr['abcpay'] = $abcpay;
                $arr['xyyh'] = $xyyh;
                $arr['weixin'] = $weixin;
            } else {
                $arr['tip'] = '<span style="color: rgb(255, 97, 2);font-size: 14px;margin-left: 10px;">订单金额不符</span>';
            }
        }
        $arr['order'] = $zq_order;
        $arr['action'] = 'zq_order_sy';
        $arr['pages_top'] = '尚医账期汇总订单详情';
        $arr['page_title'] = '用户中心-';
        //dd($arr);
        return view('zq_sy/zq_order_info')->with($arr);

    }

    public function cz_order(Request $request)
    {
        $query = CzOrder::where('user_id', $this->user->user_id)->where('order_status', 1);
        $orderList = $query->Paginate(10);
        //dd($orderList);
        $this->arr['pages'] = $orderList;
        $this->arr['action'] = 'cz_order';
        $this->arr['pages_top'] = '充值订单';
        $this->arr['page_title'] = '用户中心-';
        return view('member.cz_order_list')->with($this->arr);
    }

    public function cz_order_info(Request $request)
    {
        $id = intval($request->input('id'));//订单编号
        $order = CzOrder::where('user_id', $this->user->user_id)->find($id);
        if (!$order) {
            return view('message')->with(messageSys('订单不存在请咨询客服', route('user.orderList'), [
                [
                    'url' => route('user.orderList'),
                    'info' => '返回订单列表',
                ],
            ]));
        }
        $this->arr['order'] = $order;
        $this->arr['action'] = 'orderList';
        $this->arr['action'] = 'cz_order';
        $this->arr['pages_top'] = '充值订单';
        $this->arr['page_title'] = '用户中心-';
        return view('member.cz_order_info')->with($this->arr);
    }

    public function feedback(Request $request)
    {
        $type = intval($request->input('type'));
        $connect_info = trim($request->input('connect_info'));
        $msg_content = trim($request->input('msg_content'));
        $start = strtotime(date('Ymd'));
        $end = strtotime('+1 day');
        $count = FanKui::where('user_id', $this->user->user_id)->whereBetween('add_time', [$start, $end])->count();
        if ($count >= 3) {
            $msg = '每位用户一天可以提交三条意见！感谢您的宝贵意见。';
            $result['error'] = 1;
            $assign['error'] = 1;
            $assign['show'] = 1;
            $assign['show1'] = 1;
            $assign['text'] = $msg;
            $content = response()->view('common.tanchuc', $assign)->getContent();

            $result['msg'] = $content;
            return $result;
        }
        $fankui = new FanKui();
        $fankui->user_id = $this->user->user_id;
        $fankui->type = $type;
        $fankui->connect_info = $connect_info;
        $fankui->msg_content = $msg_content;
        $fankui->add_time = time();
        $fankui->save();
        $msg = '提交成功！感谢您的宝贵意见。';
        $result['error'] = 0;
        $assign['error'] = 0;
        $assign['show'] = 1;
        $assign['show1'] = 1;
        $assign['text'] = $msg;
        $content = response()->view('common.tanchuc', $assign)->getContent();

        $result['msg'] = $content;
        return $result;
    }

    public function sjtj(Request $request)
    {
        $type = intval($request->input('type'));
        $sjtj = DB::table('user_sjtj')->where('user_id', $this->user->user_id)->first();
        if (empty($sjtj)) {
            $arr = [
                'user_id' => $this->user->user_id,
                'type' => $type,
            ];
            DB::table('user_sjtj')->insert($arr);
        } else {
            if ($sjtj->type == 1 && $type == 0) {
                DB::table('user_sjtj')->where('user_id', $this->user->user_id)->update([
                    'type' => 0
                ]);
            }
        }
    }

    public function order_search(Request $request)
    {
        $id = intval($request->input('id'));
        $type = intval($request->input('type'));
        if ($type == 1) {//账期订单
            $order = ZqOrder::where('zq_id', $id)
                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id', 'pay_status')
                ->first();
        } elseif ($type == 2) {//账期订单
            $order = ZqOrderYwy::where('zq_id', $id)
                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id', 'pay_status')
                ->first();
        } elseif ($type == 3) {//尚医账期订单
            $order = ZqOrderSy::where('zq_id', $id)
                ->select('zq_id as order_id', 'order_amount', 'order_sn', 'user_id', 'pay_status')
                ->first();
        } else {
            $order = OrderInfo::where('order_id', $id)
                ->select('order_id', 'order_amount', 'order_sn', 'user_id', 'pay_status')
                ->first();
        }
        if (!$order) {
            return ['error' => 1];
        }
        if ($order->pay_status == 2) {
            return ['error' => 0];
        }
    }

    public function mobile_login(MobileLogin $mobileLogin)
    {
        $mobile_login = $mobileLogin->where('user_ids', 'like', '%.' . $this->user->user_id . '.%')->first();
        if ($mobile_login) {
            $users = User::whereIn('user_id', $mobile_login->user_ids)
                ->select('user_id', 'user_name', 'msn')->get();
            $type = 0;
            foreach ($users as $k => $v) {
                if ($v->user_id == $this->user->user_id) {
                    unset($users[$k]);
                    $type = 1;
                }
            }
            if ($type == 1) {
                $users->prepend($this->user);
            }
        } else {
            $users = [];
        }

        $this->arr['mobile_login'] = $mobile_login;
        $this->arr['users'] = $users;
        $this->arr['action'] = 'mobile_login';
        return view('mobile_login.index', $this->arr);
    }
}