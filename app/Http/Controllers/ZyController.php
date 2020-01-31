<?php

namespace App\Http\Controllers;

use App\Category;
use App\Goods;
use App\GoodsGallery;
use App\OrderInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ZyController extends Controller
{

    private $nav_list;

    private $arr;

    public function __construct()
    {
        $this->arr = [
            'page_title' => '中药专区-',
            'dh_check'   => 48,
        ];
        $user      = auth()->user();
        if (auth()->check()) {
            $user = $user->is_new_user();
        }
        $this->arr['top1'] = $this->xl_top(strtotime('-7 days'), 'week');
        $this->arr['top2'] = $this->xl_top(strtotime('-30 days'), 'month');
        //dd($this->nav_list);
    }

    public function index()
    {
        $arr = $this->arr;
        /**
         * 广告
         */
        $arr['ad59'] = ads(59);     //轮播
        //dd($arr['ad59']);

        $arr['ad70'] = ads(70);


        return view('zy')->with($arr);
    }


    /**
     * 中药
     */
    public function zy_category(Request $request)
    {
        $arr  = $this->arr;
        $user = auth()->user();
        if (auth()->check()) {
            $user = $user->is_new_user();
        }
        $arr['page_title'] = '中药专区-';
        $select_arr        = [
        ];
        $sort              = $request->input('sort', 'sort_order');
        $order             = $request->input('order', 'desc');
        $product_name      = $request->input('product_name');//生产厂家
        $zm                = $request->input('zm', '');//字母
        $sccj              = [
            '四川德仁堂中药科技股份有限公司'    => '四川德仁堂中药科技股份有限公司',
            '四川博仁药业有限责任公司'       => '四川博仁药业有限责任公司',
            '成都市都江堰春盛中药饮片股份有限公司' => '成都市都江堰春盛中药饮片股份有限公司',
            '四川皓博药业有限公司'         => '四川皓博药业有限公司',
            '湖北金贵中药饮片有限公司'       => '湖北金贵中药饮片有限公司'
        ];
        $phaid             = $request->input('pid');//子类id
        $keywords          = $request->input('keywords');
        $goods_list        = Goods::goods_list_ls($user, $sort, $order, '', $product_name, '', $zm, '', $phaid, $keywords, 'zy');
        foreach ($goods_list as $v) {
            $v = Goods::attr($v, $user);
            if (isset($v->goods_attribute)) {
                $v->zf   = $v->goods_attribute->zf;
                $v->spgg = $v->goods_attribute->ypgg;
                $v->jzl  = $v->goods_attribute->jzl;
                $v->sccj = $v->goods_attribute->sccj;
                if (!isset($sccj[$v->sccj])) {
                    $sccj[$v->sccj] = $v->sccj;
                }
            }
        }

        //dd($goods_list);

        if (!empty($phaid)) {
            $cat = $this->get_cat_name($phaid);
            if (!$cat) {
                return redirect()->route('zy.index');
            }
            //dd($cat);
            $select_arr['pid'] = [
                'tip'  => $cat->name,
                'text' => $cat->cat_name,
                'url'  => build_url('category.zyyp', [
                    'product_name' => $product_name,
                    'zm'           => $zm,
                ]),
            ];
        }
        if (!empty($product_name)) {
            $select_arr['product_name'] = [
                'tip'  => '生产厂家',
                'text' => $product_name,
                'url'  => build_url('category.zyyp', [
                    'pid' => $phaid,
                    'zm'  => $zm,
                ]),
            ];
        }
        if (!empty($zm)) {
            $select_arr['zm'] = [
                'tip'  => '首字母',
                'text' => $zm,
                'url'  => build_url('category.zyyp', [
                    'pid'          => $phaid,
                    'product_name' => $product_name,
                ]),
            ];
        }
        $new_sccj = [];
        foreach ($sccj as $v) {
            $new_sccj[] = $v;
        }
        $arr['zm']                = zmsx();//字母
        $arr['sccj']              = $new_sccj;//字母
        $arr['pages']             = $goods_list;//字母
        $arr['order']             = $order;
        $arr['product_name_here'] = $product_name;
        $arr['zmhere']            = $zm;
        $arr['phaid']             = $phaid;
        $arr['keywords']          = $keywords;
        $arr['step']              = 'zy';
        $arr['select_arr']        = $select_arr;
        return view('zy_category')->with($arr);
    }

    private function get_cat_name($id)
    {
        $cate = DB::table('category as a')->leftJoin('category as b', 'a.parent_id', '=', 'b.cat_id')
            ->where('a.cat_id', $id)
            ->select(DB::raw('ecs_a.cat_name,ecs_b.cat_name as name'))
            ->first();
        return $cate;
    }


    public function zy_goods(Request $request)
    {
        $arr  = $this->arr;
        $user = auth()->user();
        if (auth()->check()) {
            $user = $user->is_new_user();
        }
        $id = intval($request->input('id'));
        if ($id == 0) {
            return redirect()->route('index');
        }
        //$goods = Goods::goods_info($id);
        $goods = Goods::with('goods_attr', 'goods_attribute', 'member_price')
            ->where('goods_id', $id)->where('is_on_sale', 1)
            ->where('is_delete', 0)->where('is_alone_sale', 1)->first();
        if (!$goods) {
            return view('message')->with(messageSys(trans('goods.yxj'), route('index'), [
                [
                    'url'  => route('index'),
                    'info' => trans('common.backPrePage'),
                ],
            ]));
        }
        $goods = Goods::attr($goods, $user);
        $url   = $request->server('HTTP_REFERER');
        if ($goods->is_on_sale != 1) {//下架
            return view('message')->with(messageSys(trans('goods.yxj'), route('index'), [
                [
                    'url'  => $url,
                    'info' => trans('common.backPrePage'),
                ],
            ]));
        }
        if (auth()->check()) {
            $goods = Goods::area_xg($goods, $user->is_zhongduan());
            if ($goods->is_can_buy == 0) {//商品限购
                return view('message')->with(messageSys(trans('goods.yxj'), route('index'), [
                    [
                        'url'  => $url,
                        'info' => '商品限购',
                    ],
                ]));
            }
        }
        $img             = GoodsGallery::where('goods_id', $id)->get();//商品图片
        $goods_attribute = $goods->goods_attribute;

        /**
         * 过去十次价格变动
         */
        if (!empty($goods_attribute->old_ten_price)) {
            $old_ten_price = explode(',', $goods_attribute->old_ten_price);
            $old_price     = [];
            $old_time      = [];
            foreach ($old_ten_price as $v) {
                if (!empty($v)) {
                    $v           = explode('-', $v);
                    $old_price[] = $v[0];
                    $old_time[]  = "'" . date("Y.m.d", $v[1]) . "'";
                }
            }
        }

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
        $cat_ids = Category::whereIn('cat_id', explode(',', $goods->cat_ids))
            ->select(DB::raw("group_concat(cat_name SEPARATOR '/') as cat_ids"))
            ->first();
        if ($cat_ids && isset($goods_attribute->cat_ids)) {
            $goods_attribute->cat_ids = $cat_ids->cat_ids;
        }

        $arr['goods']           = $goods;
        $arr['rqdp']            = $rqdp;
        $arr['img']             = $img;
        $arr['user']            = $user;
        $arr['page_title']      = $goods->goods_name . '-';
        $arr['goods_attribute'] = $goods_attribute;
        return view('zy_goods')->with($arr);
    }

    public function zdtjp(Request $request)
    {
        if ($request->ajax()) {
            /**
             * 重点推荐品
             */
            $user = auth()->user();
            if (auth()->check()) {
                $user = $user->is_new_user();
            }
            $zdtj = Goods::rqdp('is_wntj', 4, 4);
            return $zdtj;
        }
    }

    private function xl_top($time, $tag, $num = 7)
    {
        $result = Cache::tags('shop', 'zy')->remember($tag, 60 * 24, function () use ($time, $num) {
            $order_id = OrderInfo::where('add_time', '>', $time)
                ->orderBy('order_id', 'asc')->pluck('order_id');
            $result   = DB::table('order_goods as og')
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
                $v->goods_url   = route('goods.zyyp', ['id' => $v->goods_id]);
            }
            return $result;
        });
        return $result;
    }
}
