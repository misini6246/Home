<?php

namespace App\Http\Controllers;


use App\Goods;
use App\GoodsGallery;
use App\Models\GoodsRelated;
use App\Models\YzyC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class GoodsController extends Controller
{

    public $id;

    public function __construct(Request $request)
    { 

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $id = intval($request->input('id'));
        $goods_show = new \App\Http\Controllers\Xin\GoodsController();
        return $goods_show->show($id);
        $user = Auth::user();
        if (auth()->check()) {
            $user = $user->is_new_user();
        }
        if ($id == 0) {
            return redirect()->route('index');
        }
        $goods = Goods::with([
            'goods_attr', 'goods_attribute', 'member_price',
            'zp_goods' => function ($query) use ($user) {
                if (auth()->check()) {
                    $query->wherePivot('zx_ranks', 'not like', '%' . $user->user_rank . '%');
                }
            },
            'zp_goods1' => function ($query) use ($user) {
                if (auth()->check()) {
                    $query->wherePivot('zx_ranks', 'not like', '%' . $user->user_rank . '%');
                }
            }
        ])
            ->where('goods_id', $id)->where('is_on_sale', 1)
            ->where('is_delete', 0)->where('is_alone_sale', 1)->first();
        if (!$goods) {
            return redirect()->route('index');
        }
        $goods = Goods::attr($goods, $user);
        if ($goods->is_on_sale != 1) { //下架
            return redirect()->route('index');
        }
        if (strpos($goods->show_area, '4') !== false) {
            return redirect()->route('goods.zyyp', ['id' => $id]);
        }
        if (auth()->check()) {
            $goods = Goods::area_xg($goods, $user->is_zhongduan());
            if ($goods->is_can_buy == 0) { //商品限购
                return redirect()->route('index');
            }
            $yzy1 = [22080, 22079];
            $yzy2 = [22077, 22078];
            $yzy_c = YzyC::where('type', 1)->find($user->user_id);
            if (in_array($id, $yzy1) && $yzy_c) { //单独购买
                return redirect()->route('goods.index', ['id' => ($id - 2)]);
            }
            if (in_array($id, $yzy2) && !$yzy_c) { //升级包
                return redirect()->route('goods.index', ['id' => ($id + 2)]);
            }
        }
        $img = GoodsGallery::where('goods_id', $id)->get(); //商品图片
        $goods_related = GoodsRelated::where('goods_id', $id)->select('related as goods_id')->get();
        $goods_related = Goods::with('goods_attr', 'goods_attribute', 'member_price')
            ->whereIn('goods_id', $goods_related)->where('is_on_sale', 1)
            ->where('is_delete', 0)->where('is_alone_sale', 1)->get();
        foreach ($goods_related as $v) {
            $v = $v->attr($v, $user);
        }
        //一周销量排行榜
        $weekSales = xl_top(strtotime('-7 days'));
        $arr = array();
        $arr['goods'] = $goods;
        $arr['goods_related'] = $goods_related;
        $arr['img'] = $img;
        $arr['user'] = $user;
        $arr['page_title'] = $goods->goods_name . '-';
        $arr['weekSales'] = $weekSales;
        $arr['middle_nav'] = nav_list('middle');
        return view('goods')->with($arr);
    }

    public function create(Request $request)
    {
        $ip = $request->server('HTTP_X_FORWARDED_FOR');
        $start = strtotime(date('Y-m-d 00:00:00'));
        $end = $start + 3600 * 24;
        $has = DB::table('ad_tongji')->where('ad_id', 1726)->where('ip', $ip)
            ->where('create_time', '>=', $start)->where('create_time', '<', $end)->count();
        $count = DB::table('ad_tongji')->where('ad_id', 1726)->count();
        return [
            'count' => $count,
            'has' => $has,
            'ip' => $ip,
        ];
    }


    public function Festival_goods()
    {
        $start = strtotime('2019-09-05 00:00:00');
        $end = strtotime('2019-09-10 23:59:59');
        $user = Auth::user();
        if (auth()->check()) {
            $user = $user->is_new_user();
        }
        if (time() > $start && time() < $end) {
            $type = [
                4991, 195263, 180191, 18790, 199381, 156892, 196155, 95299, 1691,
                156420, 1652, 185933, 194820, 50536, 30233, 95943, 733, 3560, 200760, 156543, 142927, 147452, 6387, 157231, 156797, 156497, 1488, 7442, 9508,
                5744, 161116, 156404, 170093, 180052, 23031, 180720, 204196, 20710, 177894, 7431, 138308, 211379, 731, 156402, 183651, 198697,
                207372, 59796, 158475, 729, 141867, 5338, 142692, 191328, 4859, 156422, 157912, 49216, 5290, 156885, 179437, 156639, 156760,
                202720, 156461, 7309, 178163, 156645, 3248, 175075
            ];
            $goods = Goods::with(['goods_attr', 'goods_attribute', 'member_price'])->where('is_on_sale', 1)
                ->whereIn('goods_sn', $type)
                ->where('is_delete', 0)->where('is_alone_sale', 1)->get();

            foreach ($goods as $k => $v) {
                $goods[$k] = Goods::attr($v, $user);
            }

            return view('hd.single.mid-autumn', ['goods' => $goods, 'user' => auth()->user()]);
        } else {
            return view('hd.single.mid-autumn');
        }
    }
    public function qiufen()
    {
        $start = strtotime('2019-09-23 00:00:00');
        $end = strtotime('2019-09-29 23:59:59');
        $user = Auth::user();
        if (auth()->check()) {
            $user = $user->is_new_user();
        }
        $goods = Goods::where('is_on_sale', 1)
            ->Where(function ($where) {
                $where->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
            })->orWhere(function ($where) {
                $where->where('preferential_start_date', '<=', time())->where('preferential_end_date', '>=', time())->where('zyzk', '>', 0);
            })->orderBy('sort_order', 'desc')->get();

        foreach ($goods as $k => $v) {
            $goods[$k] = Goods::attr($v, $user);
        }
        return view('hd.single.qiufen', ['goods' => $goods, 'user' => $user]);
    }
    public function guoqing()
    {
        $start = strtotime('2019-09-23 00:00:00');
        $end = strtotime('2019-09-29 23:59:59');
        $user = Auth::user();
        if (auth()->check()) {
            $user = $user->is_new_user();
        }
        $goods = Goods::where('is_on_sale', 1)
            ->Where(function ($where) {
                $where->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
            })->orWhere(function ($where) {
                $where->where('preferential_start_date', '<=', time())->where('preferential_end_date', '>=', time())->where('zyzk', '>', 0);
            })->orderBy('sort_order', 'desc')->get();

        foreach ($goods as $k => $v) {
            $goods[$k] = Goods::attr($v, $user);
        }
        return view('hd.single.guoqing', ['goods' => $goods, 'user' => $user]);
    }
    public function tejia111(Request $request)
    {
        $user = Auth::user();
        if (auth()->check()) {
            $user = $user->is_new_user();
        }
        $total = 0;
        if ($request['tab'] == '') $tab = 0;
        else $tab = $request['tab'];
        $start = strtotime('2019-01-23 00:00:00');
        $end = strtotime('2019-11-01 23:59:59');
        if ($tab == 1) {
            // 折扣
            $goods = Goods::where('is_on_sale', 1)
                ->Where(function ($where) {
                    $now = time();
                    $now = strtotime('2019-11-01 01:59:59');
                    $where->where('preferential_start_date', '<=', $now)
                        ->where('preferential_end_date', '>=', $now)
                        ->where('zyzk', '>', 0)
                        ->where('erp_shangplx', 'not like', '%中药%');
                })->orderBy('sort_order', 'desc');
                $total=$goods->count();
                $goods=$goods->paginate(50);
        } else if ($tab == 2) {
            // 中药
            $goods = Goods::where('is_on_sale', 1)
                ->Where(function ($where) {
                    $now = time();
                    $now = strtotime('2019-11-01 01:59:59');
                    $where->where('is_promote', 1)->where('promote_price', '>', 0)
                        ->where('promote_start_date', '<=', $now)
                        ->where('promote_end_date', '>=', $now)
                        ->where('promote_price','>','0.01')
                        ->where('is_xkh_tj', '!=', 1)
                        ->where('erp_shangplx', 'like', '%中药%');
                })
                ->orWhere(function ($where) {
                    $now = time();
                    $now = strtotime('2019-11-01 01:59:59');
                    $where->where('preferential_start_date', '<=', $now)
                    ->where('preferential_end_date', '>=', $now)
                    ->where('zyzk', '>', 0)
                    ->where('erp_shangplx', 'like', '%中药%');
                })->orderBy('sort_order', 'desc');
            $total=$goods->count();
            $goods=$goods->paginate(50);
        } else {
            // 特价
            $goods = Goods::where('is_on_sale', 1)
                ->Where(function ($where) {
                    $now = time();
                    $now = strtotime('2019-11-01 01:59:59');
                    $where->where('is_promote', 1)->where('promote_price', '>', 0)
                        ->where('promote_start_date', '<=', $now)
                        ->where('promote_end_date', '>=', $now)
                        ->where('promote_price','>','0.01')
                        ->where('is_xkh_tj', '!=', 1)
                        ->where('erp_shangplx', 'not like', '%中药%');
                })->orderBy('sort_order', 'desc');
            $total=$goods->count();
            $goods=$goods->paginate(50);
        }
        foreach ($goods as $k => $v) {
            $goods[$k] = Goods::attr($v, $user);
            $round = sprintf("%.2f",($v->shop_price - $v->zyzk) / $v->shop_price * 10);
            $v->round = $round;
        }
        $now = time();
        $now = strtotime('2019-11-01 01:59:59');
        return view('hd.111.tejia', ['goods' => $goods, 'user' => $user, 'total'=>$total,'now'=>$now]);
    }
}
