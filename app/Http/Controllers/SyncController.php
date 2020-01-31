<?php

namespace App\Http\Controllers;

use App\Ad;

class SyncController extends Controller
{

    public $assign = [];

    public $now;

    public function __construct()
    {
        $this->now                   = time();
        $this->assign['user']        = auth()->user();
        $this->assign['cart_number'] = 0;
        if (auth()->check()) {
            $this->assign['user']        = auth()->user()->is_new_user();
            $this->assign['cart_number'] = cart_info();
        }
        $this->assign['now'] = $this->now;
    }

    public function getTopleft()
    {
        $this->assign['view'] = response()->view('sync.top_left', $this->assign)->getContent();
        return $this->assign;
    }

    public function getFixright()
    {
        $this->assign['view'] = response()->view('sync.fix_right', $this->assign)->getContent();
        return $this->assign;
    }

    public function getMzjx()
    {
        $this->assign['ad124'] = ads(124);
        $this->assign['ad125'] = ads(125);
        $this->assign['view']  = response()->view('sync.mzjx', $this->assign)->getContent();
        return $this->assign;
    }

    public function getTancc()
    {
        $user = $this->assign['user'];
        if ($user) {
            $whereIn = [0];
            if ($user->province == 26) {
                $whereIn[] = 1;
            } else {
                $whereIn[] = 2;
            }
            if ($user->is_new_user == 1) {
                $whereIn[] = 3;
            } elseif ($user->is_new_user_xj == 1) {
                $whereIn[] = 4;
            }
        } else {
            $whereIn = [0, 1, 2];
        }
        $where = function ($where) use ($whereIn) {
            $where->whereIn('show_area', $whereIn);
        };
        //首页轮播图
        $ad27 = Ad::where('enabled', 1)->where('start_time', '<', $this->now)->where('end_time', '>', $this->now)->where('position_id', 27);
        if ($where instanceof \Closure) {
            $ad27->where($where);
        }
        $ad27 = $ad27->orderBy('sort_order', 'desc')->orderBy('ad_id', 'desc')->first();
        if (!$ad27) {
            $ad27 = Ad::where('enabled', 1)->where('start_time', '<', $this->now)
                ->where('end_time', '>', $this->now)->where('position_id', 154)->first();
        }
        $this->assign['ad27'] = $ad27;
        $this->assign['view'] = response()->view('sync.tancc', $this->assign)->getContent();
        return $this->assign;
    }
}
