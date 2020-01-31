<?php

namespace App\Http\Controllers;

use App\Models\Sjtj;
use Illuminate\Http\Request;

class SjtjController extends Controller
{
    public function index(Request $request)
    {
        $sjtj = Sjtj::all();
        $sj11 = collect();
        $sj12 = collect();
        $sj21 = collect();
        $sj22 = collect();
        $sj31 = collect();
        $sj32 = collect();
        $sj41 = 0;
        $sj42 = 0;
        $sj43 = 0;
        foreach ($sjtj as $v) {
            if ($v->id == 1) {
                $content = json_decode($v->content);
                foreach ($content as $val) {
                    $sj31->push($val->year . '年');
                    $sj32->push(round($val->total / 100000000, 2));
                    if ($val->year == 2018) {
                        $sj43 = $val->count;
                    }
                }
            }
            if ($v->id == 2) {
                $content = json_decode($v->content);
                foreach ($content as $val) {
                    $sj21->push($val->month . '月');
                    $sj22->push(round($val->total / 100000000, 2));
                    $sj41 += $val->total;
                }
            }
            if ($v->id == 3) {
                $content = json_decode($v->content);
                $total = collect($content)->sum('count');
                foreach ($content as $val) {
                    if (in_array($val->user_rank, [1, 2, 5, 7])) {
                        $sj11->push((round($val->count / $total, 4) * 100) . '%(' . $val->count . ')');
                        $sj12->push($val->count);
                        $sj42 += $val->count;
                    }
                }
            }
        }
        $sj41 = intval($sj41);
        $arr = [
            'sj11' => $sj11,
            'sj12' => $sj12,
            'sj21' => $sj21,
            'sj22' => $sj22,
            'sj31' => $sj31,
            'sj32' => $sj32,
            'sj41' => [
                substr($sj41, -1),
                substr($sj41, -2, 1),
                substr($sj41, -3, 1),
                substr($sj41, -4, 1),
                substr($sj41, -5, 1),
                substr($sj41, -6, 1),
                substr($sj41, -7, 1),
                substr($sj41, -8, 1),
                substr($sj41, -9, 1),
            ],
            'sj42' => $sj42,
            'sj43' => $sj43,
            'now' => time()
        ];
        if ($request->ajax()) {
            return $arr;
        }
        return view('hd.sjtj', $arr);
    }
}
