<?php

namespace App\Http\Controllers;

use App\Ppzq;
use Illuminate\Http\Request;
use App\Goods;

class PpzqController extends Controller
{
    private $assign;

    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
        if ($this->user) {
            $this->user = $this->user->is_zhongduan();
        }
        $this->assign = [
            'dh_check' => 44,
            'page_title' => '品牌专区-',
        ];
    }

    public function index()
    {
        $ad117 = ads(117, true);
        $ad119 = ads(119);
        $now = time();
        $ppzq = Ppzq::where('is_hot', 1)
            ->where('start_time', '<', $now)
            ->where('end_time', '>', $now)
            ->where('enabled', 1)
            ->orderBy('sort_order', 'desc')
            ->get();
        foreach ($ppzq as $v) {
            $v->img = get_img_path('data/afficheimg/' . $v->img);
        }
        $this->assign['ad117'] = $ad117;
        $this->assign['ppzq'] = $ppzq;
        $this->assign['ad119'] = $ad119;
        return view('ppzq.index', $this->assign);
    }

    public function new_index()
    {
        $ad119 = ads(200);
        $now = time();
        $ppzq = Ppzq::with([
            'goods' => function ($query) {
                $query->with([
                    'member_price' => function ($query) {
                        $query->select('goods_id', 'user_price', 'user_rank');
                    },
                    'goods_attr' => function ($query) {
                        $query->select('goods_id', 'attr_id', 'attr_value');
                    },
                    'goods_attribute' => function ($query) {
                        $query->select('goods_id', 'sccj', 'bzdw', 'ypgg', 'jzl', 'zf');
                    },
                ])->where('is_on_sale', 1)->where('is_alone_sale', 1)->where('is_delete', 0);
                $query = $this->user_tj($query);
            }
        ])->where('start_time', '<', $now)
            ->where('end_time', '>', $now)
            ->where('enabled', 1)
            ->orderBy('sort_order', 'desc')
            ->get();
        foreach ($ppzq as $v) {
            $v->img = get_img_path('data/afficheimg/' . $v->img);
            $v->child = collect();
            if (!empty($v->content)) {
                $content = json_decode($v->content);
                $child = $v->goods->filter(function ($item) use ($content) {
                    foreach ($content as $k => $v) {
                        if ($item->goods_id == $v) {
                            $item = $item->attr_new($item, $this->user);
                            $item->goods_url = route('goods.index', ['id' => $item->goods_id]);
                            $item->sort_order = 100 - $k;
                            return $item;
                        }
                    }
                })->sortByDesc('sort_order')->values();
                $v->child = $child;
                if (count($child) > 0) {
                    for ($i = 0; $i <= 3 - count($child); $i++) {
                        $child->push($child->first());
                    }
                }
            }
        }
        $this->assign['ppzq'] = $ppzq;
        $this->assign['ad119'] = $ad119;
        return view('ppzq.new', $this->assign);
    }

    public function ppzq_list(Request $request)
    {
        $keywords = trim($request->input('ppzq_key'));
        $this->assign['ad117'] = ads(117, true);
        $now = time();
        $pages = Ppzq::where('start_time', '<', $now)
            ->where('end_time', '>', $now)
            ->where('is_hot', 0)
            ->where('enabled', 1);
        if ($keywords != '') {
            $pages->where(function ($query) use ($keywords) {
                $query->where('product_name', 'like', '%' . $keywords . '%')
                    ->orwhere('sccj_zjm', 'like', '%' . $keywords . '%')
                    ->orwhere('ppzq_name', 'like', '%' . $keywords . '%');
            });
        }
        $pages = $pages->orderBy('sort_order', 'desc')->Paginate(24);
        foreach ($pages as $v) {
            $v->img = get_img_path('data/afficheimg/' . $v->img);
        }
        $this->assign['pages'] = $pages;
        $this->assign['ppzq_key'] = $keywords;
        return view('ppzq.list', $this->assign);
    }
    // 品牌专区，暂用
    public function tmp(Request $request)
    {
        $pp = trim($request->input('pp'));
        $pp = $pp == '' ? 'ynby' : $pp;
        $result = [];
        if ($pp == 'kh') {
            $result = Goods::whereIn('goods_sn', [3248 ,7309, 7834])->get();
            $this->assing['img'] = "/ppzq/imgs/kuihua.jpg";
            $this->assing['title'] = "葵花药业";
        } else if ($pp == 'jz') {
            $result = Goods::whereIn('goods_id', [7280, 8031, 11004, 11377, 12641, 18025])->get();
            $this->assing['img'] = "/ppzq/imgs/jz.jpg";
            $this->assing['title'] = "江中药业";
        }else if ($pp == 'zmsk') {
            $result = Goods::whereIn('goods_sn', [157707, 166513, 165631, 158315, 1445, 158329, 158330, 181771, 178953, 173398,2151,172914,738,212177])->get();
            $this->assing['img'] = "/ppzq/imgs/zmsk.jpg";
            $this->assing['title'] = "中美史克";
        }else {
            $result = Goods::whereIn('goods_id', [6525, 6526, 6984, 8030, 8863, 18444])->get();
            $this->assing['img'] = "/ppzq/imgs/ynby.jpg";
            $this->assing['title'] = "云南白药";
        }
        // dd($result);
        $this->assing['goods'] = $result;
        $this->assing['user'] = $this->user = auth()->user();
        return view('ppzq.index', $this->assing);
    }
    /*
    * 搜索框
    */
    public function key(Request $request)
    {
        $key = $request->input('ppzq_key');
        $goods = Ppzq::where(function ($query) use ($key) {
            $query->where('product_name', 'like', '%' . $key . '%')
                ->orwhere('sccj_zjm', 'like', '%' . $key . '%')
                ->orwhere('ppzq_name', 'like', '%' . $key . '%');
        })->where('is_hot', 0)->select('ppzq_name')
            ->take(10)
            ->groupBy('ppzq_name')
            ->get();
        $result = array();
        foreach ($goods as $v) {
            $result[] = $v->ppzq_name;
        }
        return $result;
    }

    private function user_tj($query)
    {
        if ($this->user) {
            if (strpos($this->user->msn, '拜欧') !== false) {
                $query->whereNotIn('goods_sn', [
                    '01011911', '01012446', '01012655',
                    '01044147', '01044148', '01045109', '01045110', '01045520', '01046613'
                ]);
            }
            $query->where(function ($query) {
                //如果已经登陆，获取地区、会员id
                $country = $this->user->country;
                $province = $this->user->province;
                $city = $this->user->city;
                $district = $this->user->district;
                if ($this->user->is_zhongduan == 0) {
                    $query
                        ->where('yy_regions', 'not like', '%.' . $country . '.%') //没有医院限制1,6,7
                        ->where('yy_regions', 'not like', '%.' . $province . '.%')
                        ->where('yy_regions', 'not like', '%.' . $city . '.%')
                        ->where('yy_regions', 'not like', '%.' . $district . '.%')
                        ->where('yy_user_ids', 'not like', '%.' . $this->user->user_id . '.%');
                } else {
                    $query
                        ->where('zs_regions', 'not like', '%.' . $country . '.%') //没有诊所限制
                        ->where('zs_regions', 'not like', '%.' . $province . '.%')
                        ->where('zs_regions', 'not like', '%.' . $city . '.%')
                        ->where('zs_regions', 'not like', '%.' . $district . '.%')
                        ->where('zs_user_ids', 'not like', '%.' . $this->user->user_id . '.%');
                }
                $query
                    ->where(function ($query) {
                        if (in_array($this->user->city, [339, 336, 332, 328, 324]) && in_array($this->user->user_rank, [1, 2, 5])) {
                            $query->where('ls_ranks', 'not like', '%' . $this->user->user_rank . '%')->orwhereNull('ls_ranks')->orwhere('goods_id', 25257);
                        } else {
                            $query->where('ls_ranks', 'not like', '%' . $this->user->user_rank . '%')->orwhereNull('ls_ranks');
                        }
                    }) //没有等级限制;
                    ->where('ls_regions', 'not like', '%.' . $country . '.%') //没有区域限制
                    ->where('ls_regions', 'not like', '%.' . $province . '.%')
                    ->where(function ($query) use ($city) {
                        $query->where('ls_regions', 'not like', '%.' . $city . '.%');
                    })
                    ->where('ls_regions', 'not like', '%.' . $district . '.%')
                    ->where('ls_user_ids', 'not like', '%.' . $this->user->user_id . '.%')
                    ->orwhere('xzgm', 1)
                    ->orwhere('ls_buy_user_id', 'like', '%.' . $this->user->user_id . '.%'); //允许购买的用户
            });
        }
    }
}
