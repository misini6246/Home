<?php

namespace App\Http\Controllers\Xin;

use App\Http\Controllers\Controller;
use App\Services\GoodsService;
use App\Services\MiaoshaService;
use Illuminate\Http\Request;

class MiaoshaController extends Controller
{
    protected $miaoshaService;

    protected $goodsService;

    public function __construct(MiaoshaService $miaoshaService, GoodsService $goodsService)
    {
        $this->middleware('check_login', ['only' => ['addCart', 'meiri']]);
        $this->miaoshaService = $miaoshaService;
        $this->goodsService = $goodsService;
    }

    public function meiri()
    {
        $user = auth()->user()->is_zhongduan();
        if (!$user->is_zhongduan) {
            tips1('此活动只针对终端客户');
        }
        $today = $this->goodsService->getMrms();
        $tomorrow = $this->goodsService->getMrms(1);
        if (count($today) == 0 && count($tomorrow) == 0) {
            //tips1('活动未开始');
        }
        $page_title = '每日特价-';
        return view('miaosha.mrms', compact('today', 'tomorrow', 'page_title'));
    }

    public function index()
    {
        $user = auth()->user()->is_zhongduan();
        if (!$user->is_zhongduan) {
            tips1('此活动只针对终端客户');
        }
        $result = $this->miaoshaService->getCacheGroupVisible();
        $now = time();
        $collect = collect();
        foreach ($result as $v) {
            if (strtotime($v->start_time) <= $now && strtotime($v->end_time) > $now) {
                $v->goods->each(function ($item) use ($collect) {
                    $collect->push($item);
                });
            }
        }
        if (count($collect) == 0) {
            tips1('活动未开始');
        }
        $collect = $collect->sortByDesc('sort');
        $page_title = '每日特价-';
        return view('miaosha.meiri', compact('collect', 'page_title'));
    }

    public function getMeiri()
    {
        $result = $this->miaoshaService->getCacheGroupVisible();
        $now = time();
        $collect = collect();
        foreach ($result as $v) {
            if (strtotime($v->start_time) <= $now && strtotime($v->end_time) > $now) {
                $v->goods->each(function ($item) use ($collect) {
                    $collect->push($item);
                });
            }
        }
        $collect = $collect->sortByDesc('sort');
        return view('miaosha.meiri_goods', compact('collect'));
    }

    public function getZy()
    {
        if (!auth()->check()) {
            return '';
        }
        $user = auth()->user();
        $user = $user->is_zhongduan();
        if (!$user->is_zhongduan) {
            return '';
        }
        $result = $this->miaoshaService->getCacheGroupVisible(2);
        $now = time();
        $info = null;
        foreach ($result as $v) {
            if (strtotime($v->end_time) > $now) {//取第一个未结束的
                $info = $v->goods->first();
                $info->points = intval((($info->old_goods_number - $info->goods_number) / $info->old_goods_number) * 100);
                $info->djs_status = 0;//未开始
                $info->djs_time = strtotime($info->miaoshaGroup->start_time) - $now;
                $info->djs_time1 = strtotime($info->miaoshaGroup->end_time) - strtotime($info->miaoshaGroup->start_time);
                $info->djs_text = '距开始';
                if (strtotime($info->miaoshaGroup->start_time) <= $now) {//已开始
                    $info->djs_status = 1;
                    $info->djs_time = strtotime($info->miaoshaGroup->end_time) - $now;
                    $info->djs_text = '距结束';
                }
                break;
            }
        }
        return view('miaosha.zyms', compact('info'));
    }

    public function addCart(Request $request)
    {
        $group_id = intval($request->input('group_id'));
        $goods_id = intval($request->input('goods_id'));
        return $this->miaoshaService->setCacheCart($group_id, $goods_id);
    }
}
