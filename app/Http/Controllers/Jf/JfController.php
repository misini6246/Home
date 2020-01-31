<?php

namespace App\Http\Controllers\Jf;

use App\Http\Controllers\Controller;
use App\jf\AccountLog;
use App\jf\Cart;
use App\jf\Goods;
use App\jf\News;
use App\jf\Order;
use App\jf\OrderAddress;
use App\jf\OrderGoods;
use App\Region;
use App\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

require_once app_path() . '/Common/jf.php';

class JfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $focusList = getFocus(1);
        $Top5      = getTop5();
        $assign    = [
            'focusList' => $focusList,
            'Top5'      => $Top5,
        ];
        return view('jf/index')->with($assign);
    }

    /*
     * 积分范围搜索
     */
    public function search(Request $request)
    {
        $s      = $request->input('s', 1);
        $search = Goods::where(function ($query) use ($s) {
            if ($s == 1) {
                $query->whereBetween('jf', [0, 5000]);
            } elseif ($s == 2) {
                $query->whereBetween('jf', [5001, 15000]);
            } elseif ($s == 3) {
                $query->whereBetween('jf', [15001, 30000]);
            } elseif ($s == 4) {
                $query->where('jf', '>', '30000');
            }
        })->where('is_verify', 1)
            ->select('id', 'name', 'market_price', 'jf', 'goods_image')
            ->get();
        //llPrint($search);
        $Top5   = getTop5();
        $assign = [
            'Top5'   => $Top5,
            'search' => $search,
            's'      => $s,
        ];
        return view('jf/search')->with($assign);
    }

    /*
     * 商品详情
     */
    public function goods(Request $request)
    {
        $id    = $request->input('id');
        $goods = Goods::with('goodsImg')->where('is_verify', 1)->where('id', $id)
            ->first();
        //llPrint($goods,2);
        if (!$goods) {
            return redirect('jf');
        }
        $Top5   = getTop5();
        $assign = [
            'goods' => $goods,
            'Top5'  => $Top5,
        ];
        return view('jf/goods')->with($assign);
    }

    /*
     * ajax加入购物车
     */
    public function addCart(Request $request)
    {
        $id   = $request->input('id');
        $num  = $request->input('num');
        $user = Auth::user();
        if (!Auth::check()) {
            return [
                'flag'    => false,
                'content' => "会员没有登录请点击<a href='/auth/login'>登录</a>",
            ];
        } elseif ($user->user_id == 1497 || $user->user_id == 2404) {
            $message['flag']    = false;
            $message['content'] = "加入购物车失败！";
            return $message;
            exit;
        }
        $goods = Goods::where('id', $id)->where('is_verify', 1)
            ->select('id', 'goods_stock', 'name', 'jf', 'goods_image')
            ->first();
        if (!$goods) {
            $message['flag']    = false;
            $message['content'] = '商品不存在！';
            return $message;
            exit;
        }
        if ($goods->goods_stock < $num) {
            return [
                'flag'    => false,
                'content' => "商品库存不足",
            ];
        }
        $cart = Cart::where('goods_id', $id)->where('user_id', $user->user_id)
            ->first();
        if ($cart) {//购物车存在该商品
            $num             += $cart->goods_num;
            $cart->goods_num = $num;
            $cart->jf        = $goods->jf;
            $cart->save();
        } else {
            $cart              = new Cart();
            $cart->user_id     = $user->user_id;
            $cart->goods_id    = $goods->id;
            $cart->goods_name  = $goods->name;
            $cart->goods_num   = $num;
            $cart->jf          = $goods->jf;
            $cart->goods_image = $goods->goods_image;
            $cart->save();
        }
        return [
            'flag'    => true,
            'content' => "加入购物车成功!",
        ];
    }

    /*
     * 购物车
     */
    public function cart()
    {
        $user = Auth::user();
        if ($user->user_id == 1497 || $user->user_id == 2404) {
            return redirect('/');
        }
        $goods   = Cart::with(['goods' => function ($query) {
            $query->where('is_verify', 1)->select('id', 'goods_stock', 'jf');
        }])->where('user_id', $user->user_id)
            ->select('goods_id', 'goods_num', 'goods_name', 'jf', 'goods_image', 'id')
            ->get();
        $del_ids = [];
        foreach ($goods as $k => $v) {
            if (!$v->goods) {
                $del_ids[] = $v->id;
                unset($goods[$k]);
            } else {
                if ($v->goods->jf != $v->jf) {
                    $v->jf = $v->goods->jf;
                    Cart::where('id', $v->id)->where('user_id', $user->user_id)->update(['jf' => $v->goods->jf]);
                }
            }
        }
        if (!empty($del_ids)) {
            Cart::destroy($del_ids);
        }
        $assign = [
            'goods' => $goods,
        ];
        return view('jf/cart')->with($assign);
    }

    /*
     * 检查库存
     */
    public function checkNum(Request $request)
    {
        $id    = $request->input('id', 0);
        $num   = $request->input('num', 0);
        $goods = Goods::where('id', $id)->pluck('goods_stock');
        if ($num >= $goods) {
            return [
                'flag'  => true,
                'stock' => $goods,
            ];
        } else {
            return ['flag' => false];
        }
    }

    /*
     * 删除购物车商品
     */
    public function deleteCart(Request $request)
    {
        $id   = $request->input('id');
        $user = Auth::user();
        if (Cart::where('id', $id)->where('user_id', $user->user_id)->delete()) {
            return redirect()->back();
        }
    }

    /*
     * check购物车信息
     */
    public function check(Request $request)
    {
        $user = Auth::user();
        if (!Auth::check()) {
            return [
                'flag'    => false,
                'content' => "会员没有登录请点击<a href='/auth/login'>登录</a>",
            ];
        }
        $orderstr = $request->input('orderstr');
        $orderstr = rtrim($orderstr, '-');
        $request->session()->put('userInfo.jfOrderstr', $orderstr);
        $orderarr = explode('-', $orderstr);
        $data     = array();
        foreach ($orderarr as $k => $v) {
            $arr         = explode('_', $v);
            $data[$k][0] = $arr[0];
            $data[$k][1] = $arr[1];
        }
        $totalJf = 0;
        foreach ($data as $v) {
            $goods   = Goods::where('id', $v[0])->pluck('jf');
            $totalJf += $goods * $v[1];
        }
        if ($totalJf < 1) {
            return [
                'flag'    => false,
                'content' => "请选择兑换商品",
            ];
        }
        //检验用户积分是否足够
        if ($totalJf > $user->pay_points) {
            return [
                'flag'    => false,
                'content' => "积分不足!",
            ];
        }

        return [
            'flag' => true,
        ];
        //print_r(session('userInfo',1));die;
    }

    /*
     * 提交订单
     */
    public function make()
    {
        $user       = Auth::user();
        $addressId  = $user->address_id;
        $address    = address($user, $addressId);
        $addressAll = addressAll($user, $address->address_id);
        $orderstr   = session('userInfo.jfOrderstr', '');
        if (empty($orderstr)) {
            return redirect('jf');
        }
        $orderarr = explode('-', $orderstr);
        $data     = array();
        $totalJf  = 0;
        foreach ($orderarr as $k => $v) {
            $arr        = explode('_', $v);
            $goods      = Goods::where('id', $arr[0])
                ->select('id', 'name', 'jf', 'goods_image', 'market_price')
                ->first();
            $goods->num = $arr[1];
            $totalJf    += $goods->num * $goods->jf;
            $data[$k]   = $goods;
        }
        foreach ($addressAll as $v) {
            $v->full_address = '';
            if ($v->regionCountry) {
                $v->full_address .= $v->regionCountry->region_name . ' ';
            }
            if ($v->regionProvince) {
                $v->full_address .= $v->regionProvince->region_name . ' ';
            }
            if ($v->regionCity) {
                $v->full_address .= $v->regionCity->region_name . ' ';
            }
            if ($v->regionDistrict) {
                $v->full_address .= $v->regionDistrict->region_name . ' ';
            }
        }
        $province = getRegion(1);
        //llPrint($data);
        $assign = [
            'address'    => $address,
            'addressAll' => $addressAll,
            'goods'      => $data,
            'totalJf'    => $totalJf,
            'province'   => $province,
        ];
        return view('jf/make')->with($assign);
    }

    /*
     * 添加新收货地址
     */
    public function newAddress(Request $request)
    {
        //错误提示
        return redirect()->back();
        $rules = [];
        //验证
        $check              = Validator::make($request->all(), [

        ]);
        $user               = Auth::user();
        $id                 = $request->input('addressId');
        $address            = UserAddress::findOrNew($id);
        $address->consignee = $request->input('consignee');
        $address->user_id   = $user->user_id;
        $address->country   = 1;
        $address->province  = $request->input('province');
        $address->city      = $request->input('city');
        $address->district  = $request->input('district');
        $address->address   = $request->input('address');
        $address->tel       = $request->input('tel');
        $address->zipcode   = $request->input('zipcode');
        if ($address->save()) {
            $request->session()->put('userInfo.addressId', $address->address_id);
            return redirect()->back();
        }
    }

    /*
     * 提交订单
     */
    public function done(Request $request)
    {
        $user = Auth::user();
        //llPrint($orderSn);
        $orderstr = session('userInfo.jfOrderstr', '');
        if (empty($orderstr)) {
            return redirect('jf');
        }
        $orderarr    = explode('-', $orderstr);
        $totalJf     = 0;
        $insertGoods = array();
        foreach ($orderarr as $k => $v) {
            $arr                            = explode('_', $v);
            $goods                          = Goods::where('id', $arr[0])
                ->select('id', 'name', 'jf', 'goods_image')
                ->first();
            $goods->num                     = $arr[1];
            $totalJf                        += $goods->num * $goods->jf;
            $insertGoods[$k]['goods_id']    = $goods->id;
            $insertGoods[$k]['goods_name']  = $goods->name;
            $insertGoods[$k]['goods_image'] = $goods->goods_image;
            $insertGoods[$k]['goods_num']   = $arr[1];
            $insertGoods[$k]['jf']          = $goods->jf;
            $insertGoods[$k]['subtotal']    = $goods->jf * $arr[1];
            $insertGoods[$k]['update_time'] = time();
        }
        if ($totalJf > $user->pay_points) {
            return redirect('jf');
        }
        $orderSn                    = getOrderSn();
        $orderInsert                = new Order();
        $orderInsert->order_sn      = $orderSn;
        $orderInsert->goods_amount  = $totalJf;
        $orderInsert->order_amount  = $totalJf;
        $orderInsert->order_message = $request->input('message');
        $orderInsert->buyer_id      = $user->user_id;
        $orderInsert->add_time      = time();
        $orderInsert->update_time   = time();
        $address                    = address($user, $request->input('addressId', 0));
        DB::transaction(function () use ($orderInsert, $insertGoods, $user, $request, $address, $totalJf) {
            $orderInsert->save();//插入订单
            $order_id                   = $orderInsert->id;
            $insertAddress              = new OrderAddress();
            $insertAddress->order_id    = $order_id;
            $insertAddress->name        = $address->consignee;
            $insertAddress->address     = $address->full_address . $address->address;
            $insertAddress->zip_code    = $address->zipcode;
            $insertAddress->mob_phone   = $address->tel;
            $insertAddress->update_time = time();
            $insertAddress->save();//插入订单地址
            $recId = array();
            foreach ($insertGoods as $k => $v) {
                $recId[]                     = $v['goods_id'];
                $insertGoods[$k]['order_id'] = $order_id;
                Goods::where('id', $v['goods_id'])->decrement('goods_stock', $v['goods_num']);
            }
            Cart::whereIn('goods_id', $recId)->where('user_id', $user->user_id)->delete();//删除购物车商品
            OrderGoods::insert($insertGoods);//插入订单商品
            //User::where('user_id',$user->user_id)->decrement('pay_points',$totalJf);
            $request->session()->forget('userInfo.jfOrderstr');
        });
        $order_id = Order::where('order_sn', $orderSn)->pluck('id');
        $assign   = [
            'orderSn' => $orderSn,
            'orderId' => $order_id,
            'totalJf' => $totalJf,
        ];
        return view('jf.done')->with($assign);

    }

    /*
     * 确认兑换
     */
    public function sure(Request $request)
    {
        sleep(1);
        $user  = Auth::user();
        $id    = $request->input('id');
        $order = Order::where('buyer_id', $user->user_id)->where('id', $id)->where('order_state', 1)
            //->select('order_state','pay_time','order_amount','order_sn')
            ->first();
        if (empty($order)) {
            return redirect()->route('jf.index');
        }
        $order->order_state = 2;
        $order->pay_time    = time();
        if ($order->order_amount > $user->pay_points) {
            return redirect()->route('jf.index');
        }
        DB::transaction(function () use ($user, $order) {
            $order->save();
            //记录积分兑换日志
            $accountLog              = new AccountLog();
            $accountLog->user_id     = $user->user_id;
            $accountLog->pay_points  = $order->order_amount;
            $accountLog->change_time = time();
            $accountLog->change_desc = "兑换订单 {$order->order_sn}";
            $accountLog->change_type = 2;
            $accountLog->save();
            $user_money   = 0;
            $frozen_money = 0;
            $rank_points  = 0;
            $pay_points   = -($order->order_amount);
            log_account_change_type($user->user_id, $user_money, $frozen_money, $rank_points, $pay_points, $accountLog->change_desc, 2, 0, $order->id);
        });
        return view('jf.sure');
    }

    /*
     * 会员中心
     */
    public function member()
    {
        $user      = Auth::user();
        $orderList = Order::where('buyer_id', $user->user_id)
            ->orderBy('add_time', 'desc')
            ->Paginate(5);
        //获取总的消费积分
        $totalAmount = Order::where('order_state', '>', 1)->where('buyer_id', $user->user_id)->sum('order_amount');
        $orderState  = array(
            '1' => '未兑换',
            '2' => '已兑换',
            '3' => '已发货',
            '4' => '已收货',
            '5' => '<span style="color: red;">已取消</span>',
        );
        $assign      = [
            'pages'       => $orderList,
            'params'      => [
                'url' => 'jf.member',
            ],
            'orderState'  => $orderState,
            'action'      => 'index',
            'user'        => $user,
            'totalAmount' => $totalAmount,
        ];
        return view('jf.account')->with($assign);
    }

    /*
     * 我的订单
     */
    public function order()
    {
        $user       = Auth::user();
        $orderState = array(
            '1' => '未兑换',
            '2' => '已兑换',
            '3' => '已发货',
            '4' => '已收货',
            '5' => '<em style="color: red;">已取消</em>',
        );
        $orderList  = Order::where('buyer_id', $user->user_id)
            ->orderBy('add_time', 'desc')
            ->Paginate(5);
        $assign     = [
            'pages'      => $orderList,
            'params'     => [
                'url' => 'jf.order',
            ],
            'user'       => $user,
            'action'     => 'index',
            'orderState' => $orderState,
        ];
        return view('jf.order')->with($assign);
    }

    /*
     * 订单详情
     */
    public function orderInfo(Request $request)
    {
        $user       = Auth::user();
        $id         = $request->input('id');
        $order      = Order::with([
            'goods'   => function ($query) {
                $query->select('order_id', 'goods_name', 'goods_num', 'jf');
            },
            'address' => function ($query) {
                $query->select('order_id', 'name', 'address', 'zip_code', 'mob_phone');
            }
        ])->where('buyer_id', $user->user_id)->where('id', $id)
            ->select('id', 'order_sn', 'order_state', 'order_amount', 'shipping', 'shipping_code')
            ->first();
        $orderState = array(
            '1' => '未兑换',
            '2' => '已兑换',
            '3' => '已发货',
            '4' => '已收货',
            '5' => '已取消',
        );
        $assign     = [
            'user'       => $user,
            'order'      => $order,
            'action'     => 'index',
            'orderState' => $orderState,
        ];
        return view('jf.orderInfo')->with($assign);
    }

    /*
     * 积分查询
     */
    public function payPoints()
    {
        $user       = Auth::user();
        $accountLog = AccountLog::where('user_id', $user->user_id)
            ->select('pay_points', 'change_time', 'change_desc', 'change_type')
            ->orderBy('change_time', 'desc')
            ->Paginate(15);
        $assign     = [
            'pages'  => $accountLog,
            'params' => [
                'url' => 'jf.payPoints',
            ],
            'action' => 'payPoints',
            'user'   => $user,
        ];
        return view('jf.payPoints')->with($assign);
    }

    /*
     * 收货地址
     */
    public function address(Request $request)
    {
        $user        = Auth::user();
        $id          = $request->input('id', 0);
        $addressList = addressAll($user);
        $province    = getRegion(1);
        //print_r($addressList->toArray());
        foreach ($addressList as $v) {
            $v->full_address = '';
            if ($v->regionCountry) {
                $v->full_address .= $v->regionCountry->region_name . ' ';
            }
            if ($v->regionProvince) {
                $v->full_address .= $v->regionProvince->region_name . ' ';
            }
            if ($v->regionCity) {
                $v->full_address .= $v->regionCity->region_name . ' ';
            }
            if ($v->regionDistrict) {
                $v->full_address .= $v->regionDistrict->region_name . ' ';
            }
        }
        $assign = [
            'user'        => $user,
            'action'      => 'address',
            'edit'        => $id,
            'addressList' => $addressList,
            'province'    => $province,
        ];
        if ($id != 0) {
            $address               = address($user, $id);
            $address->cityList     = Region::where('parent_id', $address->province)->where('region_type', 2)->get();
            $address->districtList = Region::where('parent_id', $address->city)->where('region_type', 3)->get();
            $assign['address']     = $address;
        }
        return view('jf.address')->with($assign);
    }

    /*
     * 帮助中心
     */
    public function help(Request $request)
    {
        $id     = $request->input('id');
        $news   = News::find($id);
        $assign = [
            'news' => $news,
        ];
        return view('jf.help')->with($assign);
    }
}
