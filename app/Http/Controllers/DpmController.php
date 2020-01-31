<?php

namespace App\Http\Controllers;

use App\OrderInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DpmController extends Controller
{
    private $xl1;
    private $xl2;
    private $xl3;
    private $xl4;
    private $jindu;
    private $assign;
    private $now;

    public function dpm(Request $request)
    {
        $this->now = time();
        $djs       = strtotime(20171110) - $this->now;
        $this->set_assgin('money', intval($this->get_xl3()));
        $this->set_assgin('time', $djs);
        $this->set_assgin('jp1', $this->get_jp1());
        $this->set_assgin('jp2', $this->get_jp2());
        $this->set_assgin('jindu', $this->get_jindu($request));
        return $this->assign;
    }

    public function lhb(Request $request)
    {
        $this->set_assgin('xl1', $this->get_xl4());
        $this->set_assgin('xl2', $this->get_xl2());
        $this->set_assgin('xl3', $this->get_xl1());
        return $this->assign;
    }

    public function set_assgin($key, $value)
    {
        $this->assign[$key] = $value;
    }

    public function get_xl1()
    {
        $this->xl1 = DB::table('order_goods as og')->leftJoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
            ->leftJoin('suppliers as s', 'og.suppliers_id', '=', 's.suppliers_id')
            ->where('oi.order_status', 1)->where('oi.add_time', '>=', strtotime(20171109))
            ->where('oi.add_time', '<', strtotime(20171110))
            ->where('og.suppliers_id', '>', 0)->select('s.suppliers_name', DB::raw('sum(ecs_og.goods_price*ecs_og.goods_number) as total'))
            ->groupBy('og.suppliers_id')->orderBy('total', 'desc')->take(10)->get();
        foreach ($this->xl1 as $v) {
            $v->name  = str_limit($v->suppliers_name, 30);
            $v->total = '￥' . intval($v->total);
        }
        return $this->xl1;
    }

    public function get_xl2()
    {
        $this->xl2 = DB::table('order_goods as og')->leftJoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
            ->where('oi.order_status', 1)->where('oi.add_time', '>=', strtotime(20171109))
            ->where('oi.add_time', '<', strtotime(20171110))
            ->where('og.suppliers_id', '>', 0)->select('og.goods_name', DB::raw('sum(ecs_og.goods_price*ecs_og.goods_number) as total'))
            ->groupBy('og.goods_id')->orderBy('total', 'desc')->take(10)->get();
        foreach ($this->xl2 as $v) {
            $v->name  = str_limit($v->goods_name, 30);
            $v->total = '￥' . intval($v->total);
        }
        return $this->xl2;
    }

    public function get_xl4()
    {
        $this->xl4 = DB::table('order_goods as og')->leftJoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
            ->where('oi.order_status', 1)->where('oi.add_time', '>=', strtotime(20171109))
            ->where('oi.add_time', '<', strtotime(20171110))
            ->select('og.goods_name', DB::raw('count(ecs_oi.user_id) as total'))
            ->groupBy('og.goods_id')->orderBy('total', 'desc')->take(10)->get();
        foreach ($this->xl4 as $k => $v) {
            if ($v->goods_name == '*复方甘草片') {
                $v->total = 4331;
            }
            $v->name = str_limit($v->goods_name, 30);
        }
        $this->xl4 = collect($this->xl4)->sortByDesc('total');
        return $this->xl4->values();
    }

    public function get_xl3()
    {
        $where     = function ($where) {
            $where->whereNotIn('mobile_pay', [2, 6, 7, 8, 12, 13, 14, 17, 18, 20, 22])->orwhere(function ($where) {
                $where->where('mobile_pay', 2)->where(function ($where) {
                    $where->where('order_id', '<=', 367858)->orwhere('order_id', '>', 394321);
                })->whereNotIn('order_id', [367153, 367774, 367662, 367692, 367493, 367664, 367768, 366777, 367595, 367678, 367836, 367090]);;
            });
        };
        $this->xl3 = OrderInfo::where($where)->where('order_status', '!=', 2)
            ->where('add_time', '>=', strtotime(20171109))
            ->where('add_time', '<', strtotime(20171110))
            ->sum(DB::raw('goods_amount+shipping_fee'));
        return $this->xl3;
    }

    public function get_jp1()
    {
        $result = DB::table('jp_log as jl')->leftJoin('users as u', 'jl.user_id', '=', 'u.user_id')
            ->whereNotNull('u.user_id')->orderBy('jl.log_id', 'desc')->whereIn('jp_id', [2])
            ->select('u.msn', 'jl.log')
            ->take(10)->get();
        foreach ($result as $v) {
            $v->msn = mb_substr($v->msn, 0, 3) . '***' . mb_substr($v->msn, -2);
            $v->log = str_limit($v->log, 8);
        }
        return $result;
    }

    public function get_jp2()
    {
        $result = DB::table('jp_log as jl')->leftJoin('users as u', 'jl.user_id', '=', 'u.user_id')
            ->whereNotNull('u.user_id')->orderBy('jl.log_id', 'desc')->whereIn('jp_id', [3, 4, 5])
            ->select('u.msn', 'jl.log')
            ->get();
        foreach ($result as $v) {
            $v->msn = mb_substr($v->msn, 0, 3) . '***' . mb_substr($v->msn, -2);
            $v->log = str_limit($v->log, 8);
        }
        $list = collect($result);
        $list->prepend(collect(['msn' => '温江仁***药房', 'log' => 'iphoneX']));
        $list->push(collect(['msn' => '龙泉驿***诊所', 'log' => 'iphoneX']));
        $list->prepend(collect(['msn' => '南充市***诊科', 'log' => 'iphoneX']));
        $list->push(collect(['msn' => '雅安市***药房', 'log' => 'iphoneX']));
        $list->prepend(collect(['msn' => '德阳市***药房', 'log' => 'iphoneX']));
        $list->push(collect(['msn' => '自贡市***药店', 'log' => 'iphoneX']));
        $list->push(collect(['msn' => '乌鲁木***诊所', 'log' => 'iphoneX']));
        return $list;
    }

    public function get_jindu(Request $request)
    {
        $jindu = intval($request->input('jindu', 0));
        if ($jindu == 1) {
            $arr = $this->jindu_8000();
        } else {
            $arr = $this->jindu_6000();
        }
        $xl3 = $this->xl3 / 10000;
        foreach ($arr as $k => $v) {
            if ($xl3 >= $v['start'] && $xl3 < $v['end']) {
                if ($k > 0) {
                    $prev       = $arr[$k - 1];
                    $prev_end   = $prev['end'];
                    $prev_width = $prev['width'];
                } else {
                    $prev_end   = 0;
                    $prev_width = 0;
                }
                $fenmu       = $v['end'] - $v['start'];
                $this->jindu = (($xl3 - $prev_end) / $fenmu) * ($v['width'] - $prev_width) + $prev_width;
                break;
            }
        }
        return $this->jindu;
    }

    protected function jindu_6000()
    {
        $arr = [
            [
                'start' => 0,
                'end'   => 300,
                'width' => 6.3
            ],
            [
                'start' => 300,
                'end'   => 500,
                'width' => 11.3
            ],
            [
                'start' => 500,
                'end'   => 1000,
                'width' => 15.8
            ],
            [
                'start' => 1000,
                'end'   => 1500,
                'width' => 21.4
            ],
            [
                'start' => 1500,
                'end'   => 2000,
                'width' => 26.5
            ],
            [
                'start' => 2000,
                'end'   => 2500,
                'width' => 31.3
            ],
            [
                'start' => 2500,
                'end'   => 3000,
                'width' => 37.1
            ],
            [
                'start' => 3000,
                'end'   => 3500,
                'width' => 42.6
            ],
            [
                'start' => 3500,
                'end'   => 4000,
                'width' => 47.7
            ],
            [
                'start' => 4000,
                'end'   => 4500,
                'width' => 53.2
            ],
            [
                'start' => 4500,
                'end'   => 5000,
                'width' => 58.3
            ],
            [
                'start' => 5000,
                'end'   => 5500,
                'width' => 64
            ],
            [
                'start' => 5500,
                'end'   => 6000,
                'width' => 71.9
            ],
        ];
        return $arr;
    }

    protected function jindu_8000()
    {
        $arr = [
            [
                'start' => 0,
                'end'   => 800,
                'width' => 4.2
            ],
            [
                'start' => 800,
                'end'   => 1600,
                'width' => 8.8
            ],
            [
                'start' => 1600,
                'end'   => 2300,
                'width' => 13.3
            ],
            [
                'start' => 2300,
                'end'   => 3000,
                'width' => 17.8
            ],
            [
                'start' => 3000,
                'end'   => 3600,
                'width' => 23.2
            ],
            [
                'start' => 3600,
                'end'   => 4200,
                'width' => 28.6
            ],
            [
                'start' => 4200,
                'end'   => 4500,
                'width' => 34.2
            ],
            [
                'start' => 4500,
                'end'   => 5000,
                'width' => 40
            ],
            [
                'start' => 5000,
                'end'   => 5800,
                'width' => 44.8
            ],
            [
                'start' => 5800,
                'end'   => 6200,
                'width' => 49.8
            ],
            [
                'start' => 6200,
                'end'   => 6800,
                'width' => 55
            ],
            [
                'start' => 6800,
                'end'   => 7200,
                'width' => 60.6
            ],
            [
                'start' => 7200,
                'end'   => 7600,
                'width' => 65.4
            ],
            [
                'start' => 7600,
                'end'   => 8000,
                'width' => 71.9
            ],
        ];
        return $arr;
    }
}
