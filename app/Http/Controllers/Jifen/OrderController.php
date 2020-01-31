<?php

namespace App\Http\Controllers\Jifen;

use App\AccountLog;
use App\Http\Controllers\Controller;
use App\jf\Cart;
use App\jf\Goods;
use App\jf\Order;
use App\jf\OrderAddress;
use App\jf\OrderGoods;
use App\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use JfTrait;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->now  = time();
        $this->set_assign('wntj', $this->getTj8());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->action = 'user';
        $result       = Order::with('goods', 'address')->where('buyer_id', $this->user->user_id)
            ->orderBy('id', 'desc')->Paginate(5);
        $order_state  = $this->order_state();
        foreach ($result as $v) {
            $v->order_state = isset($order_state[$v->order_state]) ? $order_state[$v->order_state] : '未知状态';
        }
        $this->set_assign('result', $result);
        $this->set_assign('user_menu', 'order');
        $this->common_value();
        return view('jifen.order.index', $this->assign);
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
        $ids     = $request->input('ids', []);
        $address = UserAddress::where('user_id', $this->user->user_id)->where('address_id', $this->user->address_id)->first();
        if (!$address) {
            tips3('请选择收货地址', ['返回购物车' => route('jifen.cart.index')]);
        }
        $order = new Order();
        DB::transaction(function () use ($ids, $request, $address, $order) {
            $result       = Cart::with(['goods' => function ($query) {
                $query->where('is_verify', 1)->select('id', 'goods_stock', 'jf');
            }])->where('user_id', $this->user->user_id)->whereIn('id', $ids)->lockForUpdate()
                ->select('goods_id', 'goods_num', 'goods_name', 'jf', 'goods_image', 'id')
                ->get();
            $del_ids      = [];
            $jf_total     = 0;
            $insert_goods = [];
            $insert_ids   = [];
            $updates      = [];
            foreach ($result as $k => $v) {
                if (!$v->goods) {
                    $del_ids[] = $v->id;
                    unset($result[$k]);
                    continue;
                }
                if ($v->goods->goods_stock == 0) {
                    $del_ids[] = $v->id;
                    unset($result[$k]);
                    continue;
                }
                if ($v->goods->goods_stock < $v->goods_num) {
                    $v->goods_num = $v->goods->goods_stock;
                    Cart::where('id', $v->id)->where('user_id', $this->user->user_id)->update(['goods_num' => $v->goods->goods_stock]);
                } else {
                    if ($v->goods->jf != $v->jf) {
                        $v->jf = $v->goods->jf;
                        Cart::where('id', $v->id)->where('user_id', $this->user->user_id)->update(['jf' => $v->goods->jf]);
                    }
                }
                $jf_total       += $v->jf * $v->goods_num;
                $insert_ids[]   = $v->goods_id;
                $insert_goods[] = [
                    'goods_id'    => $v->goods_id,
                    'goods_name'  => $v->goods_name,
                    'goods_image' => $v->goods_image,
                    'goods_num'   => $v->goods_num,
                    'jf'          => $v->jf,
                    'subtotal'    => $v->jf * $v->goods_num,
                    'update_time' => $this->now,
                ];
                $updates[]      = [
                    'id'          => $v->goods_id,
                    'goods_stock' => $v->goods->goods_stock - $v->goods_num,
                ];
            }
            if ($jf_total > $this->user->pay_points) {
                tips3('积分不足', ['返回礼品车' => route('jifen.cart.index')]);
            }
            if (count($result) == 0) {
                tips3('请选择要购买的商品', ['返回礼品车' => route('jifen.cart.index')]);
            }
            if (!empty($del_ids)) {
                Cart::destroy($del_ids);
            }
            $order->order_sn      = $this->get_order_sn();
            $order->goods_amount  = $jf_total;
            $order->order_amount  = $jf_total;
            $order->order_message = trim($request->input('message'));
            $order->buyer_id      = $this->user->user_id;
            $order->add_time      = $this->now;
            $order->update_time   = $this->now;
            $order->order_state   = 2;
            $order->pay_time      = $this->now;
            $order->save();//插入订单
            if ($order->id == 0) {
                tips3('订单购买失败', ['返回礼品车' => route('jifen.cart.index')]);
            }
            $this->log_account_change_type($this->user->user_id, $order->goods_amount * (-1), "兑换积分订单 {$order->order_sn}", 2, 0, $order->id);
            $order_address              = new OrderAddress();
            $order_address->order_id    = $order->id;
            $order_address->name        = $address->consignee;
            $order_address->address     = get_region_name([$address->province, $address->city, $address->district], ' ') . $address->address;
            $order_address->zip_code    = $address->zipcode;
            $order_address->mob_phone   = $address->tel;
            $order_address->tel_phone   = $address->mobile;
            $order_address->update_time = $this->now;
            $order_address->save();//插入订单地址
            if ($order_address->id == 0) {
                tips3('订单购买失败', ['返回礼品车' => route('jifen.cart.index')]);
            }
            Cart::whereIn('goods_id', $insert_ids)->where('user_id', $this->user->user_id)->delete();//删除礼品车商品
            foreach ($insert_goods as $k => $v) {
                $insert_goods[$k]['order_id'] = $order->id;
            }
            OrderGoods::insert($insert_goods);//插入订单商品
            Goods::updateBatch('jf_goods', $updates);
            $order->order_goods = $insert_goods;
        });
        $this->set_assign('order', $order);
        $this->common_value();
        return view('jifen.order.ok', $this->assign);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->action = 'user';
        $info         = Order::with('goods', 'address')->where('buyer_id', $this->user->user_id)->find($id);
        if (!$info) {
            tips3('订单不存在', ['前往我的积分' => route('jifen.user.index')]);
        }
        $order_state       = $this->order_state();
        $info->order_state = isset($order_state[$info->order_state]) ? $order_state[$info->order_state] : '未知状态';
        $this->set_assign('info', $info);
        $this->set_assign('user_menu', 'order');
        $this->common_value();
        return view('jifen.order.show', $this->assign);
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

    public function get_order_sn()
    {
        /*
 * 获取订单号，确保订单号唯一
 */
        $is_order_exist = true; //标识，默认订单号已经存在
        do {
            $order_sn = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', 0);
            $count    = Order::where('order_sn', $order_sn)->count();
            if (empty($count)) {
                //如果计数为0
                $is_order_exist = false;
            }
        } while ($is_order_exist);
        return $order_sn;
    }

    protected function log_account_change_type($user_id, $pay_points = 0, $change_desc = '', $change_type = 99, $money_type = 0, $order_id = 0)
    {
        $account_log              = new AccountLog();
        $account_log->user_id     = $user_id;
        $account_log->pay_points  = $pay_points;
        $account_log->change_time = time();
        $account_log->change_desc = $change_desc;
        $account_log->change_type = $change_type;
        $account_log->money_type  = $money_type;
        $account_log->order_id    = $order_id;
        $account_log->save();
        /* 更新用户信息 */
        $this->user->pay_points = $this->user->pay_points + $account_log->pay_points;
        $this->user->save();
    }

    protected function order_state()
    {
        $arr = array(
            '1' => '未兑换',
            '2' => '已兑换',
            '3' => '已发货',
            '4' => '已收货',
            '5' => '<span style="color: #999;">已取消</span>',
        );
        return $arr;
    }

}
