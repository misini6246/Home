<?php

namespace App\Http\Controllers\Zs;

use App\Category;
use App\GoodsAttr;
use App\Http\Controllers\Controller;
use App\Models\CxGoods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    use ZsTrait;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $show_area = intval($request->input('show_area', 26));
        $this->set_assign('show_area', $show_area);
        $this->common_value();
        $this->set_assign('ad159', ads(159));
        $this->set_assign('ad167', ads(167));
        $this->set_assign('ad168', ads(168));
        $this->set_assign('ad169', ads(169));
        $this->set_assign('middle_nav', nav_list('middle'));
        $category = Category::with([
            'cate' => function ($query) {
                $query->with('cate');
            }
        ])->where('parent_id', 949)->get();
        $type1    = CxGoods::with([
            'goods' => function ($query) {
                $query->select('goods_id', 'goods_thumb');
            }
        ])->where('type', 1)->orderBy('sort_order', 'desc')->take(5)->get();

        $type2    = CxGoods::with([
            'goods' => function ($query) {
                $query->select('goods_id', 'goods_thumb');
            }
        ])->where('type', 2)->orderBy('sort_order', 'desc')->take(4)->get();

        $type3    = CxGoods::with([
            'goods' => function ($query) {
                $query->select('goods_id', 'goods_thumb');
            }
        ])->where('type', 3)->orderBy('sort_order', 'desc')->take(4)->get();

        $type4    = CxGoods::with([
            'goods' => function ($query) {
                $query->select('goods_id', 'goods_thumb');
            }
        ])->where('type', 4)->orderBy('sort_order', 'desc')->take(2)->get();

        $this->set_assign('category', $category);
        $this->set_assign('type1', $type1);
        $this->set_assign('type2', $type2);
        $this->set_assign('type3', $type3);
        $this->set_assign('type4', $type4);
        $cat_ids = collect($category->pluck('cat_id'));

        foreach ($category as $v) {
            $cat_ids = $cat_ids->merge($v->cate->pluck('cat_id')->toArray());
            foreach ($v->cate as $val) {
                $cat_ids = $cat_ids->merge($val->cate->pluck('cat_id')->toArray());
            }
        }

        if ($this->user) {
            $user_rank_name = DB::table('user_rank')->where('rank_id', $this->user->user_rank)->pluck('rank_name');
            $user_province  = get_region_name([$this->user->province]);
            $this->set_assign('user_rank_name', $user_rank_name);
            $this->set_assign('user_province', $user_province);
        }
        $week_sale = $this->xl_top($cat_ids);
        $this->set_assign('week_sale', $week_sale);
        $this->assign['dh_check'] = 51;
//        dd($this->assign);
        return view('zs.index', $this->assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function xl_top($cat_ids)
    {
        $result = Cache::tags(['shop', 'zs'])->remember('week', 60 * 24, function () use ($cat_ids) {
            $query  = DB::table('order_goods as og')
                ->leftJoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
                ->leftJoin('goods as g', 'g.goods_id', '=', 'og.goods_id')
                ->where('oi.order_status', 1)
                ->where('oi.add_time', '>', strtotime('-7 days'))
                ->orderBy('num', 'desc')->groupBy('og.goods_id')->take(10)
                ->select('g.goods_name', 'g.goods_id', 'g.goods_thumb',
                    DB::raw('sum(ecs_og.goods_number) as num'));
            $where  = function ($where) use ($cat_ids) {
                foreach ($cat_ids as $v) {
                    $where->orwhere('cat_ids', 'like', '%' . $v . '%');
                }
            };
            $result = $query->where($where)->get();
            foreach ($result as $v) {
                $v->ypgg        = GoodsAttr::where('goods_id', $v->goods_id)->where('attr_id', 3)->pluck('attr_value');
                $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
                $v->goods_thumb = get_img_path($v->goods_thumb);
                $v->goods_url   = route('goods.index', ['id' => $v->goods_id]);
            }
            return $result;
        });
        return $result;
    }
}
