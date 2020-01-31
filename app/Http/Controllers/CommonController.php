<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CollectGoods;
use App\Goods;
use App\OrderInfo;
use App\Services\MiaoshaService;
use App\YouHuiQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public $assign;

    public $miaoshaService;

    public function __construct(MiaoshaService $miaoshaService)
    {
        $this->middleware('auth', ['except' => ['updateBatch', 'search_info', 'kfdh', 'getOrderStatus']]);
        $this->miaoshaService = $miaoshaService;
    }

    static function updateBatch($tableName = "", $multipleData = array())
    {

        if ($tableName && !empty($multipleData)) {

            // column or fields to update
            $updateColumn = array_keys($multipleData[0]);
            $referenceColumn = $updateColumn[0]; //e.g id
            unset($updateColumn[0]);
            $whereIn = "";

            $q = "UPDATE " . $tableName . " SET ";
            foreach ($updateColumn as $uColumn) {
                $q .= $uColumn . " = CASE ";

                foreach ($multipleData as $data) {
                    $q .= "WHEN " . $referenceColumn . " = '" . $data[$referenceColumn] . "' THEN '" . $data[$uColumn] . "' ";
                }
                $q .= "ELSE " . $uColumn . " END, ";
            }
            foreach ($multipleData as $data) {
                $whereIn .= "'" . $data[$referenceColumn] . "', ";
            }
            $q = rtrim($q, ", ") . " WHERE " . $referenceColumn . " IN (" . rtrim($whereIn, ', ') . ")";

            // Update
            return DB::update(DB::raw($q));

        } else {
            return false;
        }
    }

    public function user_info()
    {
        $user = auth()->user();
        $user->load('UserJnmj');
        $wait_amount = OrderInfo::wait_amount($user);//待付款金额
        $now = time();
        $youhuiq = YouHuiQ::where('user_id', $user->user_id)
            ->where('status', 0)
            ->where('union_type', '!=', 3)
            ->where('sctj', '!=', 7)
            //->where('start','<=',$now)
            ->where('end', '>=', $now)
            ->where('enabled', 1);
        $yhq_num = $youhuiq->count();
        $this->assign['user'] = $user;
        $this->assign['wait_amount'] = $wait_amount;
        $this->assign['yhq_num'] = $yhq_num;
        return view('youce.user_info', $this->assign);
    }

    public function collect_list(Request $request)
    {
        $full_page = intval($request->input('full_page', 1));
        $user = auth()->user()->is_new_user();
        $result = CollectGoods::with([
            'goods' => function ($query) {
                $query->with(['goods_attr', 'goods_attribute', 'member_price']);
            }
        ])->where('user_id', $user->user_id)
            ->where('goods_id', '>', 0)
            ->orderBy('add_time', 'desc')
            ->Paginate(10);
        foreach ($result as $k => $v) {
            if ($v->goods) {
                $v->goods = Goods::attr($v->goods, $user);
            } else {
                unset($result[$k]);
            }
        }
        $this->assign['result'] = $result;
        $this->assign['full_page'] = $full_page;
        return view('youce.collect_list', $this->assign);
    }

    public function zncgsp(Request $request)
    {
        $full_page = intval($request->input('full_page', 1));
        $user = auth()->user()->is_new_user();
        $result = DB::table('order_info as oi')
            ->leftJoin('order_goods as og', 'oi.order_id', '=', 'og.order_id')
            ->leftJoin('goods as g', 'g.goods_id', '=', 'og.goods_id')
            ->where('oi.user_id', $user->user_id)->where('oi.pay_status', 2)->where('og.parent_id', 0)->where('g.goods_id', '>', 0)
            ->select(DB::raw('count(*) as goods_number'), 'g.goods_id')
            ->groupBy('og.goods_id')
            //->lists('goods_id');
            ->Paginate(10);
        $ids = [];
        $cgcs = [];
        foreach ($result as $v) {
            $ids[] = $v->goods_id;
            $cgcs[$v->goods_id] = $v->goods_number;
        }
        $goods_list = Goods::with('goods_attr')->whereIn('goods_id', $ids)->get();
        foreach ($goods_list as $v) {
            $v = Goods::attr($v, $user);
            $v = Goods::area_xg($v, $user);
            $v->goods_number = $cgcs[$v->goods_id];
        }
        $result->goods = $goods_list;
        $this->assign['result'] = $result;
        $this->assign['full_page'] = $full_page;
        return view('youce.zncg', $this->assign);
    }

    public function gwc(Request $request)
    {
        $miaoshaCart = $this->miaoshaService->getCacheCartGoodsList();
        $miaoshaIds = $miaoshaCart->lists('goods_id')->toArray();

        $full_page = intval($request->input('full_page', 1));
        $page = intval($request->input('page', 1));
        $user = auth()->user()->is_new_user();
        $query = Cart::with(
            [
                'goods' => function ($query) {
                    $query->with('goods_attr', 'member_price', 'goods_attribute');
                }
            ]
        )->where('user_id', $user->user_id)
            ->whereNotIn('goods_id', $miaoshaIds)
            ->where('goods_id', '>', 0)
            ->where('parent_id', 0)
            ->orderBy('rec_id', 'desc');
        if (!empty($str)) {
            $query->whereIn('rec_id', $str);
        }
        $query->select('goods_id', 'rec_id', 'goods_number', 'goods_price');
        $totalQuery = clone $query;
        $result = $query->Paginate(10);
        $delId = [];
        $up_num_arr = [];
        $up_price_arr = [];
        foreach ($result as $k => $v) {
            if ($v->goods) {
                $v->goods = Goods::attr($v->goods, $user, 0, $v->product_id);
                $old_num = $v->goods_number;
                $final_num = final_num($v->goods->xg_num, intval($v->goods->jzl), intval($v->goods->zbz) == 0 ? 1 : intval($v->goods->zbz), $v->goods->goods_number, $old_num);
                $v->goods_number = $final_num['goods_number'];
                if ($v->goods->real_price != $v->goods_price && $v->product_id == $v->goods->product_id) {
                    $up_price_arr[] = [
                        'rec_id' => $v->rec_id,
                        'goods_price' => $v->goods->real_price,
                    ];
                }
                if ($old_num != $v->goods_number && $v->goods_number > 0) {
                    $up_num_arr[] = [
                        'rec_id' => $v->rec_id,
                        'goods_number' => $v->goods_number,
                    ];
                }
            } else {
                $delId[] = $v->rec_id;
                unset($result[$k]);
            }
        }
        if (!empty($delId)) {
            Cart::destroy($delId);
            Cache::tags([$user->user_id, 'cart'])->decrement('num', count($delId));
        }
        if (!empty($up_price_arr)) {

            Goods::updateBatch('ecs_cart', $up_price_arr);
        }
        if (!empty($up_num_arr)) {

            Goods::updateBatch('ecs_cart', $up_num_arr);
        }
        $total = $totalQuery->sum(DB::raw('goods_price*goods_number'));
        foreach ($miaoshaCart as $v) {
            $total += $v->goods->real_price * $v->goods_number;
            $result[] = $v;
        }
        /**
         * 获取秒杀商品
         */
        $ms = New MiaoShaController();
        $ms_goods = $ms->get_cart_goods();
        if (!empty($ms_goods) && $page == 1) {
            foreach ($ms_goods as $k => $v) {
                if (isset($goods_ids[$v->goods->goods_id])) {
                    foreach ($result as $key => $val) {
                        if ($val->goods_id == $v->goods->goods_id) {
                            unset($result[$key]);
                            $total -= $val->goods->real_price * $val->goods_number;
                        }
                    }
                } else {
                    $goods_ids[$v->goods->goods_id] = 1;
                    $total += $v->goods->real_price * $v->goods_number;
                }
                $result[] = $v;
            }
        }
        $this->assign['result'] = $result;
        $this->assign['total'] = $total;
        $this->assign['full_page'] = $full_page;
        return view('youce.gwc', $this->assign);
    }

    public function delete_gwc(Request $request)
    {
        $user = auth()->user();
        $id = $request->input('id');
        $num = cart_info();
        $total = Cart::where('goods_id', '>', 0)
            ->where('user_id', $user->user_id)
            ->sum(DB::raw('goods_price*goods_number'));
        if ($id < 0) {
            $ms = New MiaoShaController();
            $ms_goods = $ms->get_cart_goods();
            $tags = $ms->get_ms_tags();
            foreach ($ms_goods as $k => $v) {
                if ($v->goods_id == -$id) {
                    unset($ms_goods[$k]);
                    Cache::store('miaosha')->tags(['miaosha', 'cart', $tags, $user->user_id])->forget($v->goods_id);
                } else {
                    $total += $v->goods->real_price * $v->goods_number;
                }
            }
            Cache::store('miaosha')->tags(['miaosha', 'cart', $tags, $user->user_id])->forever('ms_goods', $ms_goods);
            if (count($ms_goods) == 0) {
                Cache::store('miaosha')->tags(['miaosha', 'cart', $tags, $user->user_id])->forget('team');
            }
        } elseif (strpos($id, $this->miaoshaService->cacheKeys(6)) !== false) {
            $this->miaoshaService->delCacheCartGoods($id);
        } else {
            $info = Cart::where('rec_id', $id)->where('user_id', $user->user_id)->first();
            if ($info) {
                $total = $total - $info->goods_number * $info->goods_price;
                $info->delete();
            }
        }
        ajax_return('删除成功', 0, ['num' => $num - 1, 'total' => formated_price($total)]);
    }

    public function delete_collect(Request $request)
    {
        $user = auth()->user();
        $id = intval($request->input('id'));
        $num = CollectGoods::where('rec_id', $id)
            ->where('user_id', $user->user_id)
            ->where('goods_id', '>', 0)->count();
        CollectGoods::where('rec_id', $id)->where('user_id', $user->user_id)->delete();
        ajax_return('删除成功', 0, ['num' => $num - 1]);
    }

    public function search_info(Request $request)
    {
        $cookie = Cookie::get('laravel_session_17');
        Cache::put('search_info' . $cookie, 1, 1);
        return response()->json(['error' => 0]);
    }

    public function kfdh()
    {
        Cookie::queue('kfdh', 1, 24 * 60 * 365);
        return response()->json(['error' => 0]);
    }

    public function getOrderStatus($orderSn)
    {
        $order = OrderInfo::where('order_sn', $orderSn)->where('order_status', 1)->select('order_sn', 'pay_status')->first();
        if (!$order) {
            return 0;
        }
        return $order->pay_status == 2 ? 1 : 0;
    }
}
