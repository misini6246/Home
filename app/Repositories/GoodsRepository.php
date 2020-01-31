<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/8/30
 * Time: 15:03
 */

namespace App\Repositories;


use App\Yaoyigou\Goods;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GoodsRepository
{
    protected $goods;

    protected $user;

    public function __construct(Goods $goods)
    {
        $this->goods = $goods;
        $this->user = auth()->user();
    }

    public function getMrms($day = 0)
    {
        $this->user = $this->user->is_zhongduan();
        $today = Carbon::now();
        switch ($day) {
            case 0:
                $goodsIds = DB::table('miaosha_group as mgr')->leftJoin('miaosha_goods as mgo', 'mgr.id', '=', 'mgo.group_id')
                    ->where('is_enabled', 1)->where('mgr.start_time', '<=', $today)->where('mgr.end_time', '>', $today)
                    ->whereNull('mgo.delete_time')->whereNull('mgr.delete_time')->where('mgr.group_type', 1)
                    ->lists('mgo.goods_id');
                $query = function ($query) use ($today) {
                    $query->where('is_promote', 1)->where('promote_price', '>', 0)->where('promote_start_date', '<=', strtotime($today))
                        ->where('promote_end_date', '>', strtotime($today));
                };
                break;
            case 1:
                $tomorrow = Carbon::tomorrow();
                $tomorrow1 = Carbon::tomorrow()->addDay();
                $goodsIds = DB::table('miaosha_group as mgr')->leftJoin('miaosha_goods as mgo', 'mgr.id', '=', 'mgo.group_id')
                    ->where('is_enabled', 1)->where('mgr.start_time', '>=', $tomorrow)->where('mgr.start_time', '<', $tomorrow1)
                    ->whereNull('mgo.delete_time')->whereNull('mgr.delete_time')->where('mgr.group_type', 1)
                    ->lists('mgo.goods_id');
                $query = function ($query) use ($tomorrow, $tomorrow1) {
                    $query->where('is_promote', 1)->where('promote_price', '>', 0)
                        ->where('promote_start_date', '>=', strtotime($tomorrow))->where('promote_start_date', '<', strtotime($tomorrow1));
                };
                break;
        }
        if (count($goodsIds) == 0) {
            return collect();
        }
        $result = $this->goods->with([
            'goodsAttr' => function ($query) {
                $query->whereIn('attr_id', [1, 2, 3])->select('goods_id', 'attr_id', 'attr_value');
            }
        ])->whereIn('goods_id', $goodsIds)->onSale()
            ->where($query)
            ->select('goods_id', 'goods_name', 'goods_number', 'is_promote', 'promote_price', 'shop_price', 'promote_start_date', 'goods_thumb',
                'promote_end_date', 'ls_ggg', 'erp_shangplx', 'ls_buy_user_id', 'ls_regions', 'zs_regions', 'yy_regions', 'zs_user_ids',
                'yy_user_ids', 'ls_ranks', 'cat_ids', 'xq')
            ->get();
        return $result;
    }

    public function getBuyNum($start, $end, $goodsId, $userId)
    {
        return DB::table('order_goods as og')
            ->leftjoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
            ->where('oi.order_status', 1)
            ->where('oi.user_id', $userId)->where('og.goods_id', $goodsId)
            ->where('oi.add_time', '>=', $start)->where('oi.add_time', '<', $end)
            ->sum('og.goods_number');
    }
}