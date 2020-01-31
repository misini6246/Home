<?php

namespace App\Http\Controllers\zyzq;

use App\Category;
use App\Goods;
use App\GoodsGallery;
use App\Http\Controllers\User\UserTrait;
use App\Models\CxGoods;
use App\OrderInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    use UserTrait;

    public function index()
    {
        $this->setAssign('ad187', ads(187));

        $this->setAssign('ad188', ads(188));

        $this->setAssign('ad189', ads(189));

        $this->setAssign('ad190', ads(190));

        $this->setAssign('ad191', ads(191));

        $this->setAssign('ad192', ads(192));

        $this->setAssign('ad193', ads(193));

        $this->setAssign('ad194', ads(194));
        $this->setAssign('ad195', ads(195));
        $this->setAssign('ad196', ads(196));
        $this->setAssign('ad197', ads(197));

        if ($this->user) {
            $zp = $this->zp();
        } else {
            $zp = $this->zp1();
        }

        $this->setAssign('zp', $zp);
        $this->assign['dh_check'] = 48;
        // dd($this->assign['ad188']);
        return view('zyzq.index', $this->assign);
    }

    public function category(Request $request)
    {
        $select_arr = [
        ];
        $sort = $request->input('sort', 'sort_order');
        $order = $request->input('order', 'desc');
        $product_name = $request->input('product_name');//生产厂家
        $zm = $request->input('zm', '');//字母
        $sccj = [
            '四川德仁堂中药科技股份有限公司' => '四川德仁堂中药科技股份有限公司',
            '四川博仁药业有限责任公司' => '四川博仁药业有限责任公司',
            '四川禾一天然药业有限公司' => '四川禾一天然药业有限公司',
            '四川皓博药业有限公司' => '四川皓博药业有限公司',
            '湖北金贵中药饮片有限公司' => '湖北金贵中药饮片有限公司'
        ];
        $phaid = $request->input('pid');//子类id
        $keywords = $request->input('keywords');
        $result = Goods::goods_list_ls($this->user, $sort, $order, '', $product_name, '', $zm, '', $phaid, $keywords, 'zy');
        foreach ($result as $v) {

            $v = Goods::attr($v, $this->user);

            if (isset($v->goods_attribute)) {
                $v->zf = $v->goods_attribute->zf;
                $v->spgg = $v->goods_attribute->ypgg;
                $v->jzl = $v->goods_attribute->jzl;
                $v->sccj = $v->goods_attribute->sccj;
                $v->zbz = $v->goods_attribute->zbz;
                if (!isset($sccj[$v->sccj])) {
                    $sccj[$v->sccj] = $v->sccj;
                }
            }
        }

        if (!empty($phaid)) {
            $cat = $this->get_cat_name($phaid);
            if (!$cat) {
                return redirect()->route('zy.index');
            }
            //dd($cat);
            $select_arr['pid'] = [
                'tip' => $cat->name,
                'text' => $cat->cat_name,
                'url' => build_url('zyzq.category', [
                    'product_name' => $product_name,
                    'zm' => $zm,
                ]),
            ];
        }
        if (!empty($product_name)) {
            $select_arr['product_name'] = [
                'tip' => '生产厂家',
                'text' => $product_name,
                'url' => build_url('zyzq.category', [
                    'pid' => $phaid,
                    'zm' => $zm,
                ]),
            ];
        }

        if (!empty($zm)) {
            $select_arr['zm'] = [
                'tip' => '首字母',
                'text' => $zm,
                'url' => build_url('zyzq.category', [
                    'pid' => $phaid,
                    'product_name' => $product_name,
                ]),
            ];
        }
        $new_sccj = [];
        foreach ($sccj as $v) {
            $new_sccj[] = $v;
        }

        $zdtj = Goods::rqdp('is_wntj', 4, 4);

        $this->setAssign('zdtj', $zdtj);
//        $this->setAssign('top1', $this->xl_top(strtotime('-7 days'), 'week'));
//        $this->setAssign('top2', $this->xl_top(strtotime('-30 days'), 'month'));
        $this->setAssign('zm', zmsx());
        $this->setAssign('sccj', $new_sccj);
        $this->setAssign('result', $result);
        $this->setAssign('order', $order);
        $this->setAssign('product_name_here', $product_name);
        $this->setAssign('zmhere', $zm);
        $this->setAssign('phaid', $phaid);
        $this->setAssign('keywords', $keywords);
        $this->setAssign('step', 'zy');
        $this->setAssign('select_arr', $select_arr);
        $this->assign['dh_check'] = 48;
        return view('zyzq.category', $this->assign);
    }

    public function goods(Request $request)
    {
        $id = intval($request->input('id'));
        if ($id == 0) {
            return redirect()->route('index');
        }
        $info = Goods::with('goods_attr', 'goods_attribute', 'member_price')
            ->where('goods_id', $id)->where('is_on_sale', 1)
            ->where('is_delete', 0)->where('is_alone_sale', 1)->first();
        if (!$info) {
            tips1('此商品缺货');
        }
        $info = Goods::attr($info, $this->user);
        $url = $request->server('HTTP_REFERER');
        if ($info->is_on_sale != 1) {//下架
            tips1('此商品缺货');
        }
        if (auth()->check()) {
            $info = Goods::area_xg($info, $this->user);
            if ($info->is_can_buy == 0) {//商品限购
                return redirect()->route('index');
            }
        }
        $img = GoodsGallery::where('goods_id', $id)->get();//商品图片
        $goods_attribute = $info->goods_attribute;


        /**
         * 人气单品
         */
        $rqdp = Goods::rqdp('is_hot', 5, 4);


        if (!empty($old_price)) {
            $goods_attribute->old_price = implode(',', $old_price);
        }
        if (!empty($old_time)) {
            $goods_attribute->old_time = implode(',', $old_time);
        }
        /*获取商品分类属性*/
        $cat_ids = Category::whereIn('cat_id', explode(',', $info->cat_ids))
            ->select(DB::raw("group_concat(cat_name SEPARATOR '/') as cat_ids"))
            ->first();
        if ($cat_ids && isset($goods_attribute->cat_ids)) {
            $goods_attribute->cat_ids = $cat_ids->cat_ids;
        }
        $zdtj = Goods::rqdp('is_wntj', 4, 4);
        $this->setAssign('zdtj', $zdtj);
//        $this->setAssign('top1', $this->xl_top(strtotime('-7 days'), 'week'));
//        $this->setAssign('top2', $this->xl_top(strtotime('-30 days'), 'month'));
        $this->setAssign('info', $info);
        $this->setAssign('rqdp', $rqdp);
        $this->setAssign('img', $img);
        $this->setAssign('goods_attribute', $goods_attribute);
        return view('zyzq.goods', $this->assign);
    }

    private function get_cat_name($id)
    {
        $cate = DB::table('category as a')->leftJoin('category as b', 'a.parent_id', '=', 'b.cat_id')
            ->where('a.cat_id', $id)
            ->select(DB::raw('ecs_a.cat_name,ecs_b.cat_name as name'))
            ->first();
        return $cate;
    }

    private function xl_top($time, $tag, $num = 7)
    {
        $result = Cache::tags('shop', 'zy')->remember($tag, 60 * 24, function () use ($time, $num) {
            $order_id = OrderInfo::where('add_time', '>', $time)
                ->orderBy('order_id', 'asc')->pluck('order_id');
            $result = DB::table('order_goods as og')
                ->leftJoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
                ->leftJoin('goods_attribute as ga', 'og.goods_id', '=', 'ga.goods_id')
                ->leftJoin('goods as g', 'g.goods_id', '=', 'og.goods_id')
                ->where('og.order_id', '>=', $order_id)->where('oi.order_status', 1)
                ->where('og.goods_sn', 'like', '05%')
                ->orderBy('num', 'desc')->groupBy('og.goods_id')->take($num)
                ->select('g.goods_name', 'g.goods_id', 'g.goods_thumb', 'ga.ypgg as spgg',
                    DB::raw('sum(ecs_og.goods_number) as num'))
                ->get();
            foreach ($result as $v) {
                $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
                $v->goods_thumb = get_img_path($v->goods_thumb);
                $v->goods_url = route('goods.zyyp', ['id' => $v->goods_id]);
            }
            return $result;
        });
        return $result;
    }


    public function zp()
    {
        $result = CxGoods::with([
            'goods' => function ($query) {
                $query->with([
                    'zp_goods' => function ($query) {
                        if (auth()->check()) {
                            $query->wherePivot('zx_ranks', 'not like', '%' . $this->user->user_rank . '%');
                        }
                    },
                    'zp_goods1' => function ($query) {
                        if (auth()->check()) {
                            $query->wherePivot('zx_ranks', 'not like', '%' . $this->user->user_rank . '%');
                        }
                    }
                ])->select('goods_id');
            }
        ])->whereIn('type', [17,19,20])->orderBy('sort_order', 'desc')->get();

        $ids = $result->lists('goods_id')->toArray();
        $real_price = $this->real_price($ids);
        $lists = [];

        foreach ($result as $k => $v) {

//            if (count($v->goods->zp_goods) == 0 && count($v->goods->zp_goods1) > 0) {
//                $v->goods->setRelation('zp_goods', $v->goods->zp_goods1);
//            }

//            if (count($v->goods->zp_goods) > 0) {
//                $cxxx = [];
//                foreach ($v->goods->zp_goods as $zp_goods) {
//                    $cxxx[] = $zp_goods->pivot->message;
//                }
//                $v->cxxx = implode(';', $cxxx);
//            }


            $jh = new Goods();
            $arr = isset($real_price[$v->goods_id]) ? $real_price[$v->goods_id] : [];
            foreach ($arr as $key => $val) {
                $v->$key = $val;
            }
            $v->format_price = formated_price($v->real_price);
            $jh->forceFill(collect($v)->toArray());
            $lists[$v->type][] = $jh;
        }
        return $lists;
    }

    public function zp1()
    {
        $result = CxGoods::with([
            'goods' => function ($query) {
                $query->with([
                    'zp_goods' => function ($query) {
                        if (auth()->check()) {
                            $query->wherePivot('zx_ranks', 'not like', '%' . $this->user->user_rank . '%');
                        }
                    },
                    'zp_goods1' => function ($query) {
                        if (auth()->check()) {
                            $query->wherePivot('zx_ranks', 'not like', '%' . $this->user->user_rank . '%');
                        }
                    }
                ])->select('goods_id', 'goods_thumb');
            }
        ])->whereIn('type', [17,19,20])->orderBy('sort_order', 'desc')->get();
        $lists = [];
        foreach ($result as $k => $v) {
            if (count($v->goods->zp_goods) == 0 && count($v->goods->zp_goods1) > 0) {
                $v->goods->setRelation('zp_goods', $v->goods->zp_goods1);
            }
            if (count($v->goods->zp_goods) > 0) {
                $cxxx = [];
                foreach ($v->goods->zp_goods as $zp_goods) {
                    $cxxx[] = $zp_goods->pivot->message;
                }
                $v->cxxx = implode(';', $cxxx);
            }
            $v->goods_thumb = $v->goods->goods_thumb;
            $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
            $v->goods_thumb = get_img_path($v->goods_thumb);
            $v->format_price = '会员可见';
            $lists[$v->type][] = $v;
        }
        return $lists;
    }
}
