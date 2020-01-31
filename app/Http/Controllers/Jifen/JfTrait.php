<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-12-28
 * Time: 17:17
 */

namespace App\Http\Controllers\Jifen;


use App\jf\Focus;
use App\jf\Goods;
use App\jf\News;

trait JfTrait
{

    protected $user;

    protected $now;

    protected $assign;

    protected $action;

    protected function set_assign($key, $value)
    {
        $this->assign[$key] = $value;
    }

    public function getFocus($pid)
    {
        $result = Focus::where('is_show', 1)->where('position_id', $pid)
            ->select('img', 'url')
            ->orderBy('sort')
            ->get();
        return $result;
    }

    public function getTop5()
    {
        $result = Goods::where('is_verify', 1)
            ->select('id', 'name', 'market_price', 'jf', 'goods_image')
            ->orderBy('sale_num', 'desc')
            ->take(5)
            ->get();
        return $result;
    }

    public function getTj8()
    {
        $result = Goods::where('is_best', 1)->where('is_verify', 1)
            ->select('id', 'name', 'goods_image', 'jf')
            ->orderBy('sort', 'desc')
            ->take(8)->get();
        return $result;
    }

    public function catGoods($cid)
    {
        $result = Goods::where('is_verify', 1)->where('cate_id', $cid)
            ->select('id', 'name', 'market_price', 'jf', 'goods_image')
            ->orderBy('sort', 'desc')
            ->take(5)->get();
        return $result;
    }

    protected function common_value()
    {
        $this->set_assign('user', $this->user);
        $this->set_assign('now', $this->now);
        $this->set_assign('action', $this->action);
        $this->set_assign('page_title', '积分商城-');
    }

    protected function news()
    {
        $result = News::where('cate_id', 1)->select('id', 'name')->orderBy('id')->take(3)->get();
        return $result;
    }

}