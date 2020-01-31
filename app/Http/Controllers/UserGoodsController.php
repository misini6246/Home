<?php

namespace App\Http\Controllers;

use App\Models\UserGoods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class UserGoodsController extends Controller
{

    protected $user;

    protected $userGoods;

    public function __construct(UserGoods $userGoods)
    {
        $this->user = auth()->user();
        $this->userGoods = $userGoods;
    }

    public function index1(Request $request)
    {
        $goods_id = intval($request->input('goods_id'));
        $key = 'lsgm_' . $goods_id;
        $info = Redis::hget($key, $this->user->user_id);
        $status = false;
        if (!$info || empty($info)) {
            $this->get_info($goods_id);
            $response = Redis::hset($key, $this->user->user_id, json_encode($this->userGoods));
            if ($response) {
                $response = Redis::expire($key, 3600 * 24);
                $status = $response;
            }
        } else {
            $this->userGoods = json_decode($info);
        }
        return response([
            'count' => $this->userGoods->count,
            'num' => $this->userGoods->num,
            'avg_price' => formated_price($this->userGoods->avg_price),
            'status' => $status
        ])->setStatusCode(200);
    }

    public function index(Request $request)
    {
        $goods_ids = explode(',', trim($request->input('goods_ids'), ','));
        $result = DB::table('order_goods as og')->join('order_info as oi', 'oi.order_id', '=', 'og.order_id')
            ->where('oi.order_status', 1)->where('og.goods_number', '>', 0)
            ->where('oi.add_time', '>=', strtotime('-3 month'))->where('oi.user_id', $this->user->user_id)
            ->whereIn('og.goods_id', $goods_ids)->groupBy('goods_id')
            ->selectRaw('COUNT(ecs_og.order_id) AS count,SUM(ecs_og.goods_number) AS num,GROUP_CONCAT(ecs_og.goods_price) AS price_str,goods_id')->get();
        $arr = [];
        foreach ($result as $v) {
            $arr[$v->goods_id] = $v;
        }
        $response_arr = [];
        foreach ($goods_ids as $goods_id) {
            $key = 'lsgm_' . $goods_id;
            $info = Redis::hget($key, $this->user->user_id);
            $status = false;
            if (!$info || empty($info)) {
                if (!isset($arr[$goods_id])) {
                    $this->userGoods->count = 0;
                    $this->userGoods->num = 0;
                    $this->userGoods->price_str = '';
                } else {
                    $this->userGoods->count = $arr[$goods_id]->count;
                    $this->userGoods->num = $arr[$goods_id]->num;
                    $this->userGoods->price_str = $arr[$goods_id]->price_str;
                }
                $this->userGoods->goods_id = $goods_id;
                if (empty($arr[$goods_id]->price_str)) {
                    $this->userGoods->avg_price = 0;
                } else {
                    $price_arr = explode(',', $this->userGoods->price_str);
                    $this->userGoods->avg_price = collect($price_arr)->avg();
                }
                $response = Redis::hset($key, $this->user->user_id, json_encode($this->userGoods));
                if ($response) {
                    $response = Redis::expire($key, 10);
                    $status = $response;
                }
            } else {
                $this->userGoods = json_decode($info);
            }
            $response_arr[] = [
                'count' => $this->userGoods->count,
                'num' => $this->userGoods->num,
                'avg_price' => formated_price($this->userGoods->avg_price),
                'goods_id' => $this->userGoods->goods_id,
                'status' => $status
            ];
        }
        return response($response_arr)->setStatusCode(200);
    }

    protected function get_info($goods_id)
    {
        $info = DB::table('order_goods as og')->join('order_info as oi', 'oi.order_id', '=', 'og.order_id')
            ->where('oi.order_status', 1)->where('og.goods_number', '>', 0)
            ->where('oi.add_time', '>=', strtotime('-3 month'))->where('oi.user_id', $this->user->user_id)
            ->where('og.goods_id', $goods_id)->groupBy('goods_id')
            ->selectRaw('COUNT(ecs_og.order_id) AS count,SUM(ecs_og.goods_number) AS num,GROUP_CONCAT(ecs_og.goods_price) AS price_str')->first();
        if (!$info) {
            $this->userGoods->count = 0;
            $this->userGoods->num = 0;
            $this->userGoods->price_str = '';
        } else {
            $this->userGoods->forceFill(collect($info)->toArray());
        }
        if (empty($info->price_str)) {
            $this->userGoods->avg_price = 0;
        } else {
            $price_arr = explode(',', $this->userGoods->price_str);
            $this->userGoods->avg_price = collect($price_arr)->avg();
        }
    }
}
