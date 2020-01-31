<?php

namespace App\Http\Controllers;

use App\Category;
use App\Goods;
use App\Ppzq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

require_once app_path() . '/Common/category.php';

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $nav_list;

    private $arr;

    public function __construct(Request $request)
    {
        $this->arr = [
            'page_title' => '',
        ];
        //dd($this->nav_list);
        $this->middleware('auth', ['only' => ['xkh', 'xkh_yl', 'xkh_xj', 'xkh_xj_yl']]);//新客户
    }


    public function index(Request $request)
    {
        $arr = $this->arr;
        //dd($this->nav_list);
        $user = Auth::user();
        if (auth()->check()) {
            $user = $user->is_new_user();
        }
        $product_name = $request->input('product_name');//生产厂家
        $goods_name = $request->input('goods_name');//商品名称
        $keywords = trim($request->input('keywords', ''));//关键字搜索
        $zm = $request->input('zm');//字母
        $jx = $request->input('jx');//剂型
        $dis = trim($request->input('dis'));
        $py = $request->input('py', 0);
        $phaid = $request->input('phaid');//子类id
        $step = $request->input('step', '');//促销 促销预览之类
        if (($step == 'nextpro' || $step == 'promotion') && time() > strtotime(20180329)) {
            return redirect()->route('index');
        }
        if ($step == 'nextpro' && time() > strtotime(20180327)) {
            $step = 'promotion';
            $request->offsetSet('step', $step);
        }
        //排序
        $sort = $request->input('sort', 'sort_order');
        $order = $request->input('order', 'desc');
        $goods_list = Goods::goods_list_ls($user, $sort, $order, $goods_name, $product_name, $jx, $zm, $dis, $phaid, $keywords, $step);
        foreach ($goods_list as $v) {
            $v = Goods::attr($v, $user);
        }
        if (count($goods_list) == 0 && in_array($dis, ['n', 'o', 'p', 'q'])) {
            show_msg('此类品种为控销品种，您未取得购买权限，如需购买请致电4006028262或者咨询客服人员', '/kxpz', '返回');
        }
        //dd($goods_list);die;
        $goods_list->setPath('category');
        if ($order == 'desc') {
            $arr[$sort]['next_order'] = 'asc';
            $arr[$sort]['order_class'] = 'arrow';
        } else {
            $arr[$sort]['next_order'] = 'desc';
            $arr[$sort]['order_class'] = 'arrow_asc';
        }
        //列表还是大图
        if (!empty($keywords) || in_array($dis, [2, 3, 7, 'a'])) {
            $showi = $request->input('showi', 0);
        } else {
            $showi = $request->input('showi', 1);
        }
//        if($step=='nextpro'||$step=='promotion'){
//            $showi = 0;
//        }
        if (in_array($step, ['nextpro', 'promotion', 'zy_tj', 'gzbl_nextpro', 'gzbl_promotion', 'jzqb', 'mjy', 'drt'])) {
            $showi = 0;
        }

        $url = route('category.index', [
            'dis' => $dis,
            'phaid' => $phaid,
            'py' => $py,
            'showi' => $showi,
            'keywords' => $keywords,

        ]);//链接
        $select_arr = array();//条件选择
        if (!empty($jx)) {
            $check_arr = array();
            $check_arr['name'] = trans('category.jx');
            $check_arr['text'] = $jx;
            $check_arr['url'] = $url . '&zm=' . $zm . '&sort=' . $sort . '&order=' . $order;
            $select_arr[] = $check_arr;
        }
        if (!empty($zm)) {
            $check_arr = array();
            $check_arr['name'] = trans('category.zm');
            $check_arr['text'] = $zm;
            $check_arr['url'] = $url . '&jx=' . $jx . '&sort=' . $sort . '&order=' . $order;
            $select_arr[] = $check_arr;
        }
        //一周销量排行榜
        $weekSales = xl_top(strtotime('-7 days'));
        $arr['jx'] = Cache::tags(['shop', 'category', 'jx'])->remember($dis, 8 * 60, function () use ($dis) {
            return Goods::jixing($dis);
        });//剂型
        $arr['zm'] = zmsx();//字母
        $arr['jxhere'] = $jx;
        $arr['zmhere'] = $zm;
        $arr['goods_name_here'] = $goods_name;
        $arr['product_name_here'] = $product_name;
        $arr['sorthere'] = $sort;
        $arr['order'] = $order;
        $arr['dis'] = $dis;
        $arr['py'] = $py;
        $arr['keywords'] = $keywords;
        $arr['phaid'] = $phaid;
        $arr['showi'] = $showi;
        $arr['select_arr'] = $select_arr;
        $arr['url'] = $url;
        $arr['pages'] = $goods_list;
        $arr['weekSales'] = $weekSales;
        $arr['step'] = $step;
        $arr['action'] = route('category.index');
        @$this->cache_search_info($keywords, $user, count($goods_list));
        //$arr['page_title'] = navChecked($dis,$py)."-";
        if (in_array($dis, trans('category.limit_arr'))) {
            if ($py == 1 && $dis == 1) {
                $trans = 'category.show_area.' . $dis . $py;
            } else {
                $trans = 'category.show_area.' . $dis;
            }
        } else {
            $trans = 'category.goods_search';
        }
        $arr['page_title'] = trans($trans) . "-";
        if (!empty($phaid)) {
            $cat_name = Category::where('cat_id', $phaid)->pluck('cat_name');
            if (!empty($cat_name)) {
                $arr['page_title'] = $cat_name . '-';
            }
        } elseif (!empty($step) && $step > 0) {
            $cat_name = Ppzq::where('rec_id', $step)->pluck('ppzq_name');
            if (!empty($cat_name)) {
                $arr['page_title'] = $cat_name . '-';
            }
        }
        $display = 'new.category';
        if ($step == 'nextpro' || $step == 'promotion' || $step == 'zy_tj' || $step == 'gzbl_promotion' || $step == 'gzbl_nextpro') {
            $arr['page_title'] = trans('category.cxsp') . "-";
            $arr['ad_img_url'] = get_img_path('images/0412tj.jpg');
            $arr['bg_color'] = "ffffff";
            $arr['daohang'] = 1;
            $display = 'tejia';
        } elseif ($step == 'jzqb') {
            $arr['page_title'] = "江中庆柏-";
            $arr['bg_color'] = "ffffff";
            $arr['ad_img_url'] = get_img_path('images/jzqb.jpg');
            $arr['daohang'] = 0;
            $display = 'tejia';
        } elseif ($step == 'drt') {
            $arr['page_title'] = "四川德仁堂中药-";
            $arr['bg_color'] = "ffffff";
            $arr['ad_img_url'] = get_img_path('images/scdrtzy.jpg');
            $arr['daohang'] = 0;
            $display = 'drt';
        } elseif ($step == 'mjy') {
            $arr['page_title'] = "成都岷江源药业股份有限公司-";
            $arr['bg_color'] = "ffffff";
            $arr['ad_img_url'] = get_img_path('images/mjy.jpg');
            $arr['daohang'] = 1;
            $display = 'tejia';
        } elseif ($step == 'zk') {
            //$display = 'shuang11.zk';
        } elseif ($step == 'mz') {
            //$display = 'shuang11.mz';
        } elseif ($step == 'hg') {
            //$display = 'shuang11.hg';
        }
        if ($dis == 1 && $py == 1) {
            $arr['dh_check'] = 26;
        } elseif ($dis == 2) {
            $arr['dh_check'] = 18;
        }
//        if($dis==7){
//            $arr['daohang']    = 1;
//        }
        if (time() >= strtotime(20180327)) {
            $arr['daohang'] = 0;
        }
        $arr['ad160'] = ads(160, true);
        $arr['ad163'] = ads(163, true);
        $arr['ad34'] = ads(34);
        return view($display)->with($arr);
    }

    /**
     * 新客户特价
     */
    public function xkh(Request $request)
    {
        $arr = $this->arr;
        $user = Auth::user();
        if (auth()->check()) {
            $user = $user->is_new_user();
        }
        //dd($user->is_new_user);
        if ($user->is_new_user == false) {
            return view('message')->with(messageSys('您请求的页面不存在！', route('index'), [
                [
                    'url' => route('index'),
                    'info' => '返回首页',
                ],
            ]));
        }
        //dd(strtotime('20160701'));
        $goods_list = Goods::with([
            'member_price' => function ($query) {
                $query->select('goods_id', 'user_price');
            },
            'goods_attr' => function ($query) {
                $query->select('goods_id', 'attr_id', 'attr_value');
            }
        ])->where('is_on_sale', 1)//上架
        ->where('is_alone_sale', 1)//作为普通商品销售
        ->where('is_delete', 0)//没有删除
        ->where('is_promote', 1)->where('promote_price', '>', 0)
            ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', 1);
        $user_rank = $user->user_rank;

        if ($user_rank == 6 || $user_rank == 7) $user_rank = 1;
        $goods_list->where(function ($query) use ($user, $user_rank) {
            //如果已经登陆，获取地区、会员id
            $country = $user->country;
            $province = $user->province;
            $city = $user->city;
            $district = $user->district;
            $user_id = $user->user_id;
            if ($user_rank == 1) {
                $query
                    ->where('yy_regions', 'not like', '%.' . $country . '.%')//没有医院限制1,6,7
                    ->where('yy_regions', 'not like', '%.' . $province . '.%')
                    ->where('yy_regions', 'not like', '%.' . $city . '.%')
                    ->where('yy_regions', 'not like', '%.' . $district . '.%')
                    ->where('yy_user_ids', 'not like', '%.' . $user_id . '.%')
                    ->where(function ($query) use ($user) {
                        $query->where('ls_ranks', 'not like', '%' . $user->user_rank . '%')->orwhereNull('ls_ranks');
                    });//没有等级限制;

            } else {
                $query
                    ->where('zs_regions', 'not like', '%.' . $country . '.%')//没有诊所限制
                    ->where('zs_regions', 'not like', '%.' . $province . '.%')
                    ->where('zs_regions', 'not like', '%.' . $city . '.%')
                    ->where('zs_regions', 'not like', '%.' . $district . '.%')
                    ->where('zs_user_ids', 'not like', '%.' . $user_id . '.%')
                    ->where(function ($query) use ($user_rank) {
                        $query->where('ls_ranks', 'not like', '%' . $user_rank . '%')->orwhereNull('ls_ranks');
                    });//没有等级限制;
            }
            $query->where('ls_regions', 'not like', '%.' . $country . '.%')//没有区域限制
            ->where('ls_regions', 'not like', '%.' . $province . '.%')
                ->where('ls_regions', 'not like', '%.' . $city . '.%')
                ->where('ls_regions', 'not like', '%.' . $district . '.%')
                ->where('ls_user_ids', 'not like', '%.' . $user_id . '.%')
                ->orwhere('ls_buy_user_id', 'like', '%.' . $user_id . '.%');//允许购买的用户
        });
        $goods_list = $goods_list->orderBy('goods_id')
            //->take(20)
            ->get();
        foreach ($goods_list as $k => $v) {
            $v = Goods::attr($v, $user);
            if ($v->is_xkh_tj == 0) {
                unset($goods_list[$k]);
            }
        }
        $this->arr['goods_list'] = $goods_list;
        $this->arr['page_title'] = '新客户特价-';
        return view('xkh_tj')->with($this->arr);
    }

    public function xkh_yl(Request $request)
    {
        $arr = $this->arr;
        $user = Auth::user();
        $time = time() + 3600 * 24 * $request->input('days');
        if (auth()->check()) {
            $user = $user->is_new_user_yl($time);
        }
        //dd($user);
        if ($user->is_new_user == false) {
            return view('message')->with(messageSys('您请求的页面不存在！', route('index'), [
                [
                    'url' => route('index'),
                    'info' => '返回首页',
                ],
            ]));
        }
        $goods_list = Goods::with([
            'member_price' => function ($query) {
                $query->select('goods_id', 'user_price');
            },
            'goods_attr' => function ($query) {
                $query->select('goods_id', 'attr_id', 'attr_value');
            }
        ])->where('is_on_sale', 1)//上架
        ->where('is_alone_sale', 1)//作为普通商品销售
        ->where('is_delete', 0)//没有删除
        ->where('is_promote', 1)->where('promote_price', '>', 0)
            ->where('promote_start_date', '<=', $time)->where('promote_end_date', '>=', $time)->where('is_xkh_tj', 1);
        $user_rank = $user->user_rank;
        if ($user_rank == 6 || $user_rank == 7) $user_rank = 1;
        $goods_list->where(function ($query) use ($user, $user_rank) {
            //如果已经登陆，获取地区、会员id
            $country = $user->country;
            $province = $user->province;
            $city = $user->city;
            $district = $user->district;
            $user_id = $user->user_id;
            if ($user_rank == 1) {
                $query
                    ->where('yy_regions', 'not like', '%.' . $country . '.%')//没有医院限制1,6,7
                    ->where('yy_regions', 'not like', '%.' . $province . '.%')
                    ->where('yy_regions', 'not like', '%.' . $city . '.%')
                    ->where('yy_regions', 'not like', '%.' . $district . '.%')
                    ->where('yy_user_ids', 'not like', '%.' . $user_id . '.%')
                    ->where(function ($query) use ($user) {
                        $query->where('ls_ranks', 'not like', '%' . $user->user_rank . '%')->orwhereNull('ls_ranks');
                    });//没有等级限制;

            } else {
                $query
                    ->where('zs_regions', 'not like', '%.' . $country . '.%')//没有诊所限制
                    ->where('zs_regions', 'not like', '%.' . $province . '.%')
                    ->where('zs_regions', 'not like', '%.' . $city . '.%')
                    ->where('zs_regions', 'not like', '%.' . $district . '.%')
                    ->where('zs_user_ids', 'not like', '%.' . $user_id . '.%')
                    ->where(function ($query) use ($user_rank) {
                        $query->where('ls_ranks', 'not like', '%' . $user_rank . '%')->orwhereNull('ls_ranks');
                    });//没有等级限制;
            }
            $query->where('ls_regions', 'not like', '%.' . $country . '.%')//没有区域限制
            ->where('ls_regions', 'not like', '%.' . $province . '.%')
                ->where('ls_regions', 'not like', '%.' . $city . '.%')
                ->where('ls_regions', 'not like', '%.' . $district . '.%')
                ->where('ls_user_ids', 'not like', '%.' . $user_id . '.%')
                ->orwhere('ls_buy_user_id', 'like', '%.' . $user_id . '.%');//允许购买的用户
        });
        $goods_list = $goods_list->select('goods_id', 'goods_name', 'product_name', 'goods_img', 'goods_thumb', 'show_area', 'cat_ids', 'ls_gg', 'ls_ggg', 'shop_price', 'is_xkh_tj', 'is_kxpz', 'hy_price',
            'is_promote', 'promote_price', 'promote_start_date', 'promote_end_date', 'xg_type', 'xg_start_date', 'xg_end_date', 'goods_number', 'xq')
            ->orderBy('goods_id')
            //->take(20)
            ->get();
        foreach ($goods_list as $k => $v) {
            $v = Goods::attr_yl($time, $v, $user);
            if ($v->is_xkh_tj == 0) {
                unset($goods_list[$k]);
            }
        }
        //dd($goods_list);
        $this->arr['goods_list'] = $goods_list;
        $this->arr['page_title'] = '新客户特价-';
        return view('xkh_tj')->with($this->arr);
    }

    /**
     * 新客户特价新疆
     */
    public function xkh_xj(Request $request)
    {
        $arr = $this->arr;
        $user = Auth::user();
        if (auth()->check()) {
            $user = $user->is_new_user_xj();
        }
        //dd($user);
        if ($user->is_new_user_xj == false) {
            return view('message')->with(messageSys('您请求的页面不存在！', route('index'), [
                [
                    'url' => route('index'),
                    'info' => '返回首页',
                ],
            ]));
        }
        $goods_list = Goods::with([
            'member_price' => function ($query) {
                $query->select('goods_id', 'user_price');
            },
            'goods_attr' => function ($query) {
                $query->select('goods_id', 'attr_id', 'attr_value');
            }
        ])->where('is_on_sale', 1)//上架
        ->where('is_alone_sale', 1)//作为普通商品销售
        ->where('is_delete', 0)//没有删除
        ->whereIn('goods_id', [3703, 1204, 25008, 23838, 26427, 8892, 366, 17022]);
        $user_rank = $user->user_rank;
        if ($user_rank == 6 || $user_rank == 7) $user_rank = 1;
        $goods_list->where(function ($query) use ($user, $user_rank) {
            //如果已经登陆，获取地区、会员id
            $country = $user->country;
            $province = $user->province;
            $city = $user->city;
            $district = $user->district;
            $user_id = $user->user_id;
            if ($user_rank == 1) {
                $query
                    ->where('yy_regions', 'not like', '%.' . $country . '.%')//没有医院限制1,6,7
                    ->where('yy_regions', 'not like', '%.' . $province . '.%')
                    ->where('yy_regions', 'not like', '%.' . $city . '.%')
                    ->where('yy_regions', 'not like', '%.' . $district . '.%')
                    ->where('yy_user_ids', 'not like', '%.' . $user_id . '.%')
                    ->where(function ($query) use ($user) {
                        $query->where('ls_ranks', 'not like', '%' . $user->user_rank . '%')->orwhereNull('ls_ranks');
                    });//没有等级限制;

            } else {
                $query
                    ->where('zs_regions', 'not like', '%.' . $country . '.%')//没有诊所限制
                    ->where('zs_regions', 'not like', '%.' . $province . '.%')
                    ->where('zs_regions', 'not like', '%.' . $city . '.%')
                    ->where('zs_regions', 'not like', '%.' . $district . '.%')
                    ->where('zs_user_ids', 'not like', '%.' . $user_id . '.%')
                    ->where(function ($query) use ($user_rank) {
                        $query->where('ls_ranks', 'not like', '%' . $user_rank . '%')->orwhereNull('ls_ranks');
                    });//没有等级限制;
            }
            $query->where('ls_regions', 'not like', '%.' . $country . '.%')//没有区域限制
            ->where('ls_regions', 'not like', '%.' . $province . '.%')
                ->where('ls_regions', 'not like', '%.' . $city . '.%')
                ->where('ls_regions', 'not like', '%.' . $district . '.%')
                ->where('ls_user_ids', 'not like', '%.' . $user_id . '.%')
                ->orwhere('ls_buy_user_id', 'like', '%.' . $user_id . '.%');//允许购买的用户
        });
        $goods_list = $goods_list->select('goods_id', 'goods_name', 'product_name', 'goods_img', 'goods_thumb', 'show_area', 'cat_ids', 'ls_gg', 'ls_ggg', 'shop_price', 'is_xkh_tj', 'is_kxpz', 'hy_price',
            'is_promote', 'promote_price', 'promote_start_date', 'promote_end_date', 'xg_type', 'xg_start_date', 'xg_end_date', 'goods_number', 'xq')
            ->orderBy('goods_id')
            //->take(20)
            ->get();
        foreach ($goods_list as $k => $v) {
            $v = Goods::attr($v, $user);
        }
        $this->arr['goods_list'] = $goods_list;
        $this->arr['page_title'] = '新人专享-';
        return view('xkh_tj_xj')->with($this->arr);
    }

    public function xkh_xj_yl(Request $request)
    {
        $arr = $this->arr;
        $user = Auth::user();
        $time = time() + 3600 * 24 * $request->input('days');
        if (auth()->check()) {
            $user = $user->is_new_user_xj_yl($time);
        }
        //dd($user);
        if ($user->is_new_user_xj == false) {
            return view('message')->with(messageSys('您请求的页面不存在！', route('index'), [
                [
                    'url' => route('index'),
                    'info' => '返回首页',
                ],
            ]));
        }
        //dd(strtotime('20160701'));
        $goods_list = Goods::with([
            'member_price' => function ($query) {
                $query->select('goods_id', 'user_price');
            },
            'goods_attr' => function ($query) {
                $query->select('goods_id', 'attr_id', 'attr_value');
            }
        ])->where('is_on_sale', 1)//上架
        ->where('is_alone_sale', 1)//作为普通商品销售
        ->where('is_delete', 0)//没有删除
        ->whereIn('goods_id', [3703, 1204, 25008, 23838, 26427, 8892, 366, 17022]);
        $user_rank = $user->user_rank;
        if ($user_rank == 6 || $user_rank == 7) $user_rank = 1;
        $goods_list->where(function ($query) use ($user, $user_rank) {
            //如果已经登陆，获取地区、会员id
            $country = $user->country;
            $province = $user->province;
            $city = $user->city;
            $district = $user->district;
            $user_id = $user->user_id;
            if ($user_rank == 1) {
                $query
                    ->where('yy_regions', 'not like', '%.' . $country . '.%')//没有医院限制1,6,7
                    ->where('yy_regions', 'not like', '%.' . $province . '.%')
                    ->where('yy_regions', 'not like', '%.' . $city . '.%')
                    ->where('yy_regions', 'not like', '%.' . $district . '.%')
                    ->where('yy_user_ids', 'not like', '%.' . $user_id . '.%')
                    ->where('ls_ranks', 'not like', '%' . $user->user_rank . '%');//没有等级限制;

            } else {
                $query
                    ->where('zs_regions', 'not like', '%.' . $country . '.%')//没有诊所限制
                    ->where('zs_regions', 'not like', '%.' . $province . '.%')
                    ->where('zs_regions', 'not like', '%.' . $city . '.%')
                    ->where('zs_regions', 'not like', '%.' . $district . '.%')
                    ->where('zs_user_ids', 'not like', '%.' . $user_id . '.%')
                    ->where('ls_ranks', 'not like', '%' . $user_rank . '%');//没有等级限制;
            }
            $query->where('ls_regions', 'not like', '%.' . $country . '.%')//没有区域限制
            ->where('ls_regions', 'not like', '%.' . $province . '.%')
                ->where('ls_regions', 'not like', '%.' . $city . '.%')
                ->where('ls_regions', 'not like', '%.' . $district . '.%')
                ->where('ls_user_ids', 'not like', '%.' . $user_id . '.%')
                ->orwhere('ls_buy_user_id', 'like', '%.' . $user_id . '.%');//允许购买的用户
        });
        $goods_list = $goods_list->select('goods_id', 'goods_name', 'product_name', 'goods_img', 'goods_thumb', 'show_area', 'cat_ids', 'ls_gg', 'ls_ggg', 'shop_price', 'is_xkh_tj', 'is_kxpz', 'hy_price',
            'is_promote', 'promote_price', 'promote_start_date', 'promote_end_date', 'xg_type', 'xg_start_date', 'xg_end_date', 'goods_number', 'xq')
            ->orderBy(DB::raw('rand()'))->orderBy('goods_id')
            //->take(20)
            ->get();
        foreach ($goods_list as $k => $v) {
            $v = Goods::attr_yl($time, $v, $user);
        }
        //dd($goods_list);
        $this->arr['goods_list'] = $goods_list;
        $this->arr['page_title'] = '新人专享-';
        return view('xkh_tj_xj')->with($this->arr);
    }


    private function cache_search_info($keywords, $user, $count)
    {
        if (!empty($keywords)) {
            $cookie = Cookie::get('laravel_session_17');
            $key = Cache::get('search_info' . $cookie, 0);
            if ($key == 1) {
                Cache::put('search_info' . $cookie, 0, 1);
                $search_info['keywords'] = $keywords;
                $search_info['log_time'] = date('Y-m-d H:i:s');
                if ($user) {
                    $search_info['user_id'] = $user->user_id;
                } else {
                    $search_info['user_id'] = 0;
                }
                $search_info['flag'] = 1;
                if ($count > 0) {
                    $search_info['flag'] = 0;
                }
                if (Redis::connection('search')->llen('search_info') < 10000) {
                    Redis::connection('search')->lpush('search_info', serialize($search_info));
                }
            }
        }
    }


    //控销专区建设中
    public function kxzq(){
        $ads = ads(205);

        return view('goods.kongxiaozhuangqu',compact('ads'));
    }
}
