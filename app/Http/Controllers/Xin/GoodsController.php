<?php

namespace App\Http\Controllers\Xin;

use App\Ad;
use App\Category;
use App\Common\Page;
use App\GoodsAttr;
use App\GoodsGallery;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserTrait;
use App\kxpzPrice;
use App\Models\CkPrice;
use App\Models\Goods;
use App\Models\YzyC;
use App\Ppzq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class GoodsController extends Controller
{

    use Page, UserTrait;

    private $sort;

    private $order;

    private $page_mum = 40;

    private $start;

    private $end;

    private $middle;

    protected $product_id = 0;

    public function __construct()
    {
        $this->assign['page_title'] = '商品搜索-';
        $this->user = auth()->user();
        if ($this->user) {
            $this->user = $this->user->is_new_user();
        }
        $this->now = time();
        $this->assign['daohang'] = 1;
        $this->assign['user'] = $this->user;
        $this->sort = trim(\Illuminate\Support\Facades\Request::input('sort', 'sort_order'));
        $this->order = trim(\Illuminate\Support\Facades\Request::input('order', 'desc'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Goods $goods)
    {
        $step = trim($request->step);
        if (in_array($step, ['nextpro', 'promotion'])) {
            $view = $this->promotion($request, $goods);
            return response($view);
        }
        if (in_array($step, ['zy_nextpro', 'zy_promotion'])) {
            $view = $this->zy_promotion($request, $goods);
            return response($view);
        }
        if (in_array($step, ['tejia'])) {
            $view = $this->tejia($request, $goods);
            return response($view);
        }
        if (in_array($step, ['hrsj', 'yzj'])) {
            $view = $this->hrsj($request, $goods);
            return response($view);
        }
        if ((in_array($step, [18, 28, 29, 30, 32, 35, 36]) || $step >= 38) && !in_array($step, [40, 48, 53])) {
            $view = $this->ppzq($request, $goods);
            return response($view);
        }
        if (in_array($step, ['tjcl1'])) {
            $view = $this->tjcl($request, $goods);
            return response($view);
        }
        if (in_array($step, ['tjcl'])) {
            $this->product_id = 1;
            $this->assign['page_title'] = '特卖专区-';
            $this->get_list($request, $goods);
            return view('goods.ck_price1', $this->assign);
        }
        $this->get_list($request, $goods);
        foreach ($this->assign['result'] as $v){
            if($v->zyzk > 0 && $v->preferential_end_date > time()) {
                $round = round(($v->shop_price - $v->zyzk) / $v->shop_price, 2) * 10;
                $v->round = $round;
            }
        }
        return view('goods.index', $this->assign);
    }

    public function xkh(Request $request, Goods $goods)
    {
        if ($this->user&&$this->user->is_new_user!=1) {
            return redirect()->route('index');
        }
        $this->page_mum = 20;
        $step = 'xkh';
        $request->offsetSet('step', $step);
        $this->get_list($request, $goods);
        $this->assign['page_title'] = '新客户特价-';
        $this->assign['daohang'] = 0;
        return view('goods.xkh', $this->assign);
    }

    public function tjcl(Request $request, Goods $goods)
    {
        $this->product_id = 1;
        $step = trim($request->input('step', 'hrsj'));
        $request->offsetSet('step', $step);
        $this->get_list($request, $goods);
        $this->assign['ad_img_url'] = get_img_path('adimages1/201806/tejia.jpg');
        $this->assign['page_title'] = '特卖专区-';
        $this->assign['daohang'] = 0;
        return view('goods.ck_price', $this->assign);
    }

    public function promotion(Request $request, Goods $goods)
    {
        $step = trim($request->input('step', 'nextpro'));
        $request->offsetSet('step', $step);
        $this->get_list($request, $goods);
        $this->assign['ad160'] = ads(160, true);
        $this->assign['ad_img_url'] = get_img_path('images/0412tj.jpg');
        $this->assign['page_title'] = '特价促销-';
        if ($this->now >= $this->middle) {
            $this->assign['daohang'] = 0;
        }
        return view('goods.tejia', $this->assign);
    }

    public function zy_promotion(Request $request, Goods $goods)
    {
        $step = trim($request->input('step', 'zy_nextpro'));
        $request->offsetSet('step', $step);
        $this->get_list($request, $goods);
        $this->assign['ad160'] = ads(160, true);
        $this->assign['ad_img_url'] = 'http://images.hezongyy.com/adimages1/201808/erji/zytj_banner.jpg';
        $this->assign['page_title'] = '特价促销-';
        if ($this->now >= $this->middle) {
            $this->assign['daohang'] = 0;
        }
        return view('goods.tejia', $this->assign);
    }

    public function tejia(Request $request, Goods $goods)
    {

        $this->start = strtotime(20180601);
        $this->end = strtotime(20180701);
        $this->middle = strtotime(20180520);
        $this->check_user1();
        $step = trim($request->input('step', 'tejia'));
        if ($this->now >= $this->start) {
            $step = 'tejia';
        }
        $request->offsetSet('step', $step);
        $this->get_list($request, $goods);
        $this->assign['ad_img_url'] = get_img_path('adimages1/201806/tejia.jpg');
        $this->assign['page_title'] = '特价活动-';
        $this->assign['daohang'] = 0;
        return view('goods.tejia', $this->assign);
    }
    // ==================== start 单页面 =================================
    // 2019 8月活动
    public function hd_1908()
    {
        $start=strtotime('2019-10-28 00:00:00');
        $end=strtotime('2019-11-2 00:00:00');
        $type = [];
        /*    if($start < time() && $end > time()){
                $type=[188372,199393,159751,199753,211812,54956,195741,196227,192017,180103,3768,200683,160700,205961,207946,209053,186595,200285,191320,99999];
            }*/
        $type=[188372,199393,159751,199753,211812,54956,195741,196227,192017,180103,3768,200683,160700,205961,207946,209053,186595,200285,191320,99999];
        $goods= Goods::with(['goods_attr','goods_attribute','member_price'])->where('is_on_sale',1)
            ->whereIn('goods_sn',$type)->where('is_promote',1)
            ->where('is_delete',0)->where('is_alone_sale',1)->get();
        $this->assign['goods'] = $goods->map(function($itme){
                   if($itme->promote_price == 0.01) {
                       return $itme;
                   }
                })->filter(function ($itme){
                   if(!empty($itme)){
                       return \App\Goods::attr($itme,$this->user);
                   }
               });

        return view("hd.single.hd_807", $this->assign);

    }
    public function zhuchang()
    {
        $sn = [
            156885, 156543, 1691, 9350, 5352, 95299, 156402, 156628, 191328, 30556, 733,
            886, 175711, 185933, 170939, 158475, 174636, 9508, 138308, 142927, 5984, 156406, 2813,
            1829, 7442, 169355, 156422, 204196, 4858, 3248, 7309, 95943, 156497, 7431, 59796, 156420,
            194820, 12972, 199993, 156534, 1652, 6387, 171764, 195263, 156763, 156892, 180191, 3560,
            61436, 197696
        ];
        $now = date("Y-m-d");
        $goods = DB::table('goods')->whereIn('goods_sn', $sn)->get();
        $this->assign['goods'] = $goods;
        $this->assign['user'] = $this->user;
        // dd($this->assign);
        return view("hd.single.zhuchang", $this->assign);
        // dd($this->assign);
    }
    // 2019.8.21中药活动
    public function hd_821zy()
    {
        $sn = [
            166179,
            209283,
            195249,
            208806,
            207304,
            193650,
            195929,
            205446,
            210242,
            205659
        ];
        $now = date("Y-m-d");
        $query = Goods::with(['goods_attr', 'goods_attribute'])->whereIn('goods_sn', $sn)->orderBy('goods_id', 'DESC');
        $goods = $query->get();
        $this->assign['goods'] = $goods;
        $this->assign['user'] = $this->user;
        $this->assign['now'] = $now;
        // dd($goods[0]->goods_attr);
        return view("hd.single.hd_821zy", $this->assign);
    }
    // 2019.8.21普药活动
    public function hd_821py()
    {
        $sn = [
            156406,
            12972,
            2813,
            76156,
            30556,
            61436,
            161116,
            886,
            59796,
            194986,
            5984,
            169355,
            126830,
            171764,
            733,
            156402,
            191731,
            7442,
            156797
        ];
        $now = date("Y-m-d");
        $query = Goods::with(['goods_attr', 'goods_attribute'])->whereIn('goods_sn', $sn)->orderBy('goods_id', 'DESC');
        $goods = $query->get();
        $this->assign['goods'] = $goods;
        $this->assign['user'] = $this->user;
        $this->assign['now'] = $now;
        // dd($goods[0]->goods_attr);
        return view("hd.single.hd_821py", $this->assign);
    }
    // =========================== end 单页面 =====================
    public function hrsj(Request $request, Goods $goods)
    {
        $step = trim($request->input('step', 'hrsj'));
        $request->offsetSet('step', $step);
        $this->get_list($request, $goods);
        $this->assign['ad_img_url'] = get_img_path('adimages1/201806/erji/' . $step . '.jpg');
        $this->assign['page_title'] = '厂家活动-';
        $this->assign['daohang'] = 0;
        return view('goods.tejia', $this->assign);
    }
    public function ppzq(Request $request, Goods $goods)
    {
        $step = intval($request->input('step'));
        $ppzq = Ppzq::where('rec_id', $step)->first();
        if (!$ppzq) {
            return redirect()->route('index');
        }
        $request->offsetSet('step', $step);
        $this->get_list($request, $goods);
        $ad = Ad::where('position_id', 199)->where('ad_bgc', $step)->first();
        if ($ad) {
            $ad->ad_code = get_img_path('data/afficheimg/' . $ad->ad_code);
            $this->assign['ad_img_url'] = $ad->ad_code;
        } else {
            $this->assign['ad_img_url'] = get_img_path('adimages1/201806/erji/ppzq' . $step . '.jpg');
        }
        $this->assign['page_title'] = $ppzq->ppzq_name . '-';
        $this->assign['daohang'] = 0;
        $this->assign['height'] = 480;
        $this->assign['hide_shop_price'] = 0;
        return view('goods.tejia', $this->assign);
    }

    protected function get_list($request, $goods)
    {
        $shaixuan = [
            'ylfl' => [],
            'jx' => [],
            'ypgg' => [],
            'sccj' => [],
        ];
        $show_area_list = trans('category.show_area');
        $keywords = trim($request->input('keywords'));
        $step = trim($request->input('step'));
        $dis = trim($request->input('dis'));
        $ylfl = trim($request->input('ylfl'));
        $ylfl1 = intval($request->input('ylfl1'));
        $ylfl2 = intval($request->input('ylfl2'));
        $jx = trim($request->input('jx'));
        $product = trim($request->input('product'));
        $ypgg = trim($request->input('ypgg'));
        $kc = intval($request->input('kc'));
        $style = trim($request->input('style', 'l'));
        $query = $goods->where('is_alone_sale', 1)->where('is_delete', 0);
        switch ($dis) {
            case 1:
                $this->set_assign('dh_check', 26);
                break;
            case 2:
                $this->set_assign('dh_check', 57);
                break;
        }
        $this->assign['fl_list'] = [];
        if (!empty($keywords) || in_array($dis, [2, 3, 7, 'a'])) {
            $style = 'g';
        }
        if (!empty($keywords)) {
            $query->where(function ($where) use ($keywords) {
                $where->where('goods_name', 'like', '%' . $keywords . '%')
                    ->orwhere('product_name', 'like', '%' . $keywords . '%')
                    ->orwhere('ZJMID', 'like', '%' . $keywords . '%');
            });
        } elseif (!empty($ylfl)) {
            if (in_array($ylfl, trans('category.limit_arr'))) {
                if ($ylfl == 1) {
                    $query->where('show_area', 'not like', '%4%'); //显示区域
                } elseif ($ylfl != 'n') {
                    $query->where('show_area', 'like', '%' . $ylfl . '%'); //显示区域
                }
                $page_title = trans('category.show_area.' . $ylfl);
                $this->assign['page_title'] = isset($page_title) ? $page_title . "-" : '商品搜索-';
            }
            $fl_list = $this->category($ylfl);
            $shaixuan['ylfl'] = $fl_list;
            if ($ylfl1 > 0) {
                $cate_tree = $this->cate_tree();
                $this->fl_tj($query, $cate_tree, $ylfl1);
                $page_title = $this->get_cat_name($ylfl1);
                $this->assign['page_title'] = !empty($page_title) ? $page_title . "-" : '商品搜索-';
                $this->assign['ylfl1_name'] = $page_title;
                if ($ylfl2 > 0) {
                    $this->fl_tj($query, $cate_tree, $ylfl2);
                    $page_title = $this->get_cat_name($ylfl2);
                    $this->assign['page_title'] = !empty($page_title) ? $page_title . "-" : '商品搜索-';
                    $this->assign['ylfl2_name'] = $page_title;
                } else {
                    if ($fl_list['type'] == 2) {
                        $new_list = [];
                        foreach ($fl_list['list'] as $v) {
                            if ($v->cat_id == $ylfl1) {
                                foreach ($v->cate as $val) {
                                    if ($ylfl1 == 682) {
                                        $new_list[] = $val;
                                    } else {
                                        foreach ($val->cate as $value) {
                                            $new_list[] = $value;
                                        }
                                    }
                                }
                            }
                        }
                        $this->assign['fl_list'] = $new_list;
                    } elseif ($fl_list['type'] == 3) {
                        $new_list = [];
                        foreach ($fl_list['list'] as $v) {
                            if ($v->cat_id == $ylfl1) {
                                foreach ($v->cate as $val) {
                                    $new_list[] = $val;
                                }
                            }
                        }
                        $this->assign['fl_list'] = $new_list;
                    }
                }
            } else {
                if ($fl_list['type'] == 1) {
                    $new_list = [];
                    foreach ($fl_list['list'][0]->cate as $v) {
                        foreach ($v->cate as $val) {
                            $new_list[] = $val;
                        }
                    }
                    $this->assign['fl_list'] = $new_list;
                } else {
                    $this->assign['fl_list'] = $fl_list['list'];
                }
            }
        } else {
            $shaixuan['ylfl'] = $this->show_area_list();
            $this->assign['fl_list'] = $shaixuan['ylfl'];
        }
        if (!empty($dis)) {
            if (in_array($dis, trans('category.limit_arr'))) {
                if ($dis == 1) {
                    $query->where('show_area', 'not like', '%4%'); //显示区域
                } else {
                    $query->where('show_area', 'like', '%' . $dis . '%'); //显示区域
                }
                $page_title = $show_area_list[$dis];
                $this->assign['page_title'] = isset($page_title) ? $page_title . "-" : '商品搜索-';
            }
        }
        if (!empty($ypgg)) {
            $query->where('ypgg', 'like', '%' . $ypgg . '%'); //药品规格
        }
        if ($kc > 0) {
            $query->where('goods_number', '>', 0);
        }
        $this->user_tj($query);
        $this->step($query, $step);
        if (!empty($product)) {
            $query->where('product_name', 'like', '%' . $product . '%'); //厂家
            $query_ypgg = clone $query;
            if (!empty($jx)) {
                $query_ypgg->where('is_on_sale', 1)->where('jx', 'like', '%' . $jx . '%'); //剂型
            }
            $shaixuan['ypgg'] = $query_ypgg->where('ypgg', '!=', '')->orderBy('ypgg')->groupBy('ypgg')->lists('ypgg');
        }
        $query_jx = clone $query;
        if (!empty($jx)) {
            $query->where('jx', 'like', '%' . $jx . '%'); //剂型
        }
        $query2 = clone $query;
        $shaixuan['jx'] = $query_jx->where('is_on_sale', 1)->where('jx', '!=', '')->orderBy('jx')->groupBy('jx')->lists('jx');
        if (count($this->assign['fl_list']) == 0) {
            $sccj = $query2->where('is_on_sale', 1)->where('product_name', '!=', '')->orderBy('product_name')->groupBy('product_name')->lists('product_name');
            if (count($sccj) > 0) {
                foreach ($sccj as $v) {
                    $v = trim($v);
                    $py = $this->shoupin($v);
                    if (!empty($py)) {
                        $shaixuan['sccj'][$py][] = $v;
                    }
                }
            }
        }
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
            'zp_goods' => function ($query) {
                if (auth()->check()) {
                    $query->wherePivot('zx_ranks', 'not like', '%' . $this->user->user_rank . '%');
                }
            },
            'zp_goods1' => function ($query) {
                if (auth()->check()) {
                    $query->wherePivot('zx_ranks', 'not like', '%' . $this->user->user_rank . '%');
                }
            },
            'ck_price'
        ]);
        if ($this->product_id == 1) {
            $erpids = CkPrice::where('goods_number', '>', 0)->where('goods_price', '>', 0)->where('is_on_sale', 1)->lists('ERPID');
            $query->whereIn('ERPID', $erpids);
        } elseif (in_array($step, ['nextpro', 'promotion'])) {
            $query->where(function ($query) {
                $query->where('is_on_sale', 1);
            });
        } else {
            $query->where(function ($query) {
                $query->where('is_on_sale', 1)->orwhere('is_tm_on_sale', 1);
            });
        }
        $result = $query->orderBy($this->sort, $this->order)->orderBy('goods_number', 'desc')
            ->Paginate($this->page_mum);
        foreach ($result as $k => $v) {
            if ($this->product_id == 0) {
                if ($v->is_on_sale == 0) {
                    $v->product_id = 1;
                }
                $result[$k] = \App\Goods::attr($v, $this->user, 1, $v->product_id);
            } else {
                $result[$k] = \App\Goods::attr($v, $this->user, 1, $this->product_id);
            }
        }
        $params = [
            'style' => $style,
        ];
        $inputs = $request->all();
        if (isset($inputs['step']) && $inputs['step'] == 'zyzk') {
            unset($inputs['step']);
            $this->assign['step'] = 'zyzk';
        }
        if (!empty($keywords)) {
            unset($inputs['ylfl']);
            unset($inputs['ylfl1']);
            unset($inputs['ylfl2']);
        }
        $result = $this->add_params($result, array_merge($params, $inputs));
        $fl_url = '';
        $fl_url1 = '';
        $fl_url2 = '';
        if (empty($keywords)) {
            if ($ylfl2 > 0) {
                $fl_url = str_replace('&ylfl2=' . $ylfl2, '', $result->url(1));
                $fl_url = str_replace('ylfl2=' . $ylfl2, '', $fl_url);
                $fl_url = str_replace('&ylfl1=' . $ylfl1, '', $fl_url);
                $fl_url = str_replace('ylfl1=' . $ylfl1, '', $fl_url);
                $fl_url = str_replace('&ylfl=' . $ylfl, '', $fl_url);
                $fl_url = str_replace('ylfl=' . $ylfl, '', $fl_url);
                $fl_url1 = str_replace('&ylfl2=' . $ylfl2, '', $result->url(1));
                $fl_url1 = str_replace('ylfl2=' . $ylfl2, '', $fl_url1);
                $fl_url1 = str_replace('ylfl1=' . $ylfl1, '', $fl_url1);
                $fl_url1 = str_replace('ylfl1=' . $ylfl1, '', $fl_url1);
                $fl_url2 = str_replace('&ylfl2=' . $ylfl2, '', $result->url(1));
                $fl_url2 = str_replace('ylfl2=' . $ylfl2, '', $fl_url2);
            } elseif ($ylfl1 > 0) {
                $fl_url = str_replace('&ylfl1=' . $ylfl1, '', $result->url(1));
                $fl_url = str_replace('ylfl1=' . $ylfl1, '', $fl_url);
                $fl_url = str_replace('ylfl=' . $ylfl, '', $fl_url);
                $fl_url = str_replace('ylfl=' . $ylfl, '', $fl_url);
                $fl_url1 = str_replace('&ylfl1=' . $ylfl1, '', $result->url(1));
                $fl_url1 = str_replace('ylfl1=' . $ylfl1, '', $fl_url1);
                $fl_url2 = '';
            } else {
                $fl_url = str_replace('&ylfl=' . $ylfl, '', $result->url(1));
                $fl_url = str_replace('ylfl=' . $ylfl, '', $fl_url);
                $fl_url1 = '';
                $fl_url2 = '';
            }
        }
        $sort_arr = [
            'sort_order',
            'click_count',
            'sales_volume',
            'goods_name',
            'product_name',
            'shop_price',
        ];
        //dd($shaixuan,$this->assign);
        if (!empty($keywords)) {
            $home = new HomeController($request);
            if ($this->user) {
                $mzhg = $home->zp();
            } else {
                $mzhg = $home->zp1();
            }
            $this->assign['mzhg'] = $mzhg;
        }
        $xz_arr['jx'] = $jx;
        $xz_arr['product'] = $product;
        $result->sort = $this->sort_arr($result->url($result->currentPage()), $sort_arr);
        $this->result = $result;
        $pages_view = $this->pagesView();
        $this->assign['result'] = $result;
        $this->assign['fl_url'] = $fl_url;
        $this->assign['fl_url1'] = $fl_url1;
        $this->assign['fl_url2'] = $fl_url2;
        $this->assign['show_area'] = $this->show_area_list();
        $this->assign['pages_view'] = $pages_view;
        $this->assign['shaixuan'] = $shaixuan;
        $this->assign['xz_arr'] = $xz_arr;
        @$this->cache_search_info($keywords, $this->user, count($result));
        if ($dis == 1) {
            $this->assign['page_title'] = '普药-';
        }
        if (count($result) == 0) {
            $wntj = \App\Goods::rqdp('is_wntj', 10, -4);
            $this->assign['wntj'] = $wntj;
        }
        $home = new HomeController($request);
        if ($this->user) {
            $cx_goods = $home->cx_goods([6]);
        } else {
            $cx_goods = $home->cx_goods1([6]);
        }
        $this->set_assign('cx_goods', $cx_goods);
        //        echo ($request->input('ylfl'));
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
        if ($id == 0) {
            return redirect()->route('index');
        }
        $this->product_id = intval(\Illuminate\Support\Facades\Request::input('product_id'));
        $query = \App\Goods::with([
            'goods_attr', 'goods_attribute', 'member_price',
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
        ])
            ->where('goods_id', $id)
            ->where('is_delete', 0)->where('is_alone_sale', 1);
        $this->user_tj($query);
        $info = $query->first();

        if (!$info) {
            tips1('此商品缺货');
        }
        $info = \App\Goods::attr($info, $this->user, 1, $this->product_id);

        if (!$info) {
            tips1('此商品缺货');
        }
        if ($info->is_on_sale != 1) { //下架
            tips1('此商品缺货');
        }
        if (strpos($info->show_area, '4') !== false) {
            return redirect()->route('goods.zyyp', ['id' => $id]);
        }
        if (auth()->check()) {
            $info = Goods::area_xg($info, $this->user->is_zhongduan());
            if ($info->is_can_buy == 0) { //商品限购
                return redirect()->route('index');
            }
            $yzy1 = [22080, 22079];
            $yzy2 = [22077, 22078];
            $yzy_c = YzyC::where('type', 1)->find($this->user->user_id);
            if (in_array($id, $yzy1) && $yzy_c) { //单独购买
                return redirect()->route('goods.index', ['id' => ($id - 2)]);
            }
            if (in_array($id, $yzy2) && !$yzy_c) { //升级包
                return redirect()->route('goods.index', ['id' => ($id + 2)]);
            }
        }
        $img = GoodsGallery::where('goods_id', $id)->get(); //商品图片
        //一周销量排行榜
        if($info->zyzk > 0 && $info->preferential_end_date > time()){
            $round = round(($info->shop_price - $info->zyzk) / $info->shop_price, 2) * 10;
            $info->round = $round;
        }

        $xl_top = $this->xl_top();
        $this->set_assign('info', $info);
        $this->set_assign('img', $img);
        $this->set_assign('page_title', $info->goods_name . '-');
        $this->set_assign('xl_top', $xl_top);
        // dd($info);
        return view('goods.show', $this->assign);
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

    private function show_area_list()
    {
        $arr = [
            'b' => '呼吸系统用药',
            'c' => '清热、消炎',
            'd' => '五官、皮肤及外用',
            'e' => '消化、肝胆系统',
            'f' => '补益安神及维矿类 ',
            'g' => '妇、儿科 ',
            'h' => '心脑血管及神经类用药',
            'i' => '内分泌系统（含糖尿病）',
            'j' => '风湿骨伤及其他药品',
            'k' => '特殊复方制剂、生物制品',
            //'l' => '中药饮片',
            'm' => '非药品',
            'n' => '诊所专区',
        ];
        return $arr;
    }

    private function add_params($result, $params = [])
    {
        $params = array_merge($params, [
            'sort' => $this->sort,
            'order' => $this->order,
            'page_num' => $this->page_mum,
        ]);
        foreach ($params as $k => $v) {
            if (!empty($v)) {
                $this->assign[$k] = $v;
                $result->appends([$k => $v]);
            }
        }
        $result->params = $params;
        return $result;
    }

    private function sort_arr($page, $sort_arr)
    {
        $arr = [];
        $order_arr = [
            'desc' => 'asc',
            'asc' => 'desc',
        ];
        foreach ($sort_arr as $v) {
            if ($v == $this->sort) {
                $this_page = str_replace($this->order, $order_arr[$this->order], $page);
                if (isset($this->assign['step']) && $this->assign['step'] == 'cx') {
                    $this_page = str_replace('&step=' . $this->assign['step'], '', $this_page);
                    $this_page = str_replace('step=' . $this->assign['step'], '', $this_page);
                }
                $arr[$v] = 'class="sorting_' . $this->order . '" href="' . $this_page . '"';
            } else {
                $this_page = str_replace($this->order, 'desc', $page);
                if ($v == 'shop_price') {
                    $this_page = str_replace($this->order, 'asc', $page);
                }
                $this_page = str_replace($this->sort, $v, $this_page);
                if (isset($this->assign['step']) && $this->assign['step'] == 'cx') {
                    $this_page = str_replace('&step=' . $this->assign['step'], '', $this_page);
                    $this_page = str_replace('step=' . $this->assign['step'], '', $this_page);
                }
                $arr[$v] = 'class="sorting" href="' . $this_page . '"';
            }
        }
        return $arr;
    }

    private function get_cat_name($cat_id)
    {
        $cate_tree = $this->cate_tree();
        $cate_name = collect($cate_tree->whereLoose('cat_id', $cat_id)->first())->get('cat_name');
        return $cate_name;
    }

    private function cate_tree()
    {
        $cate_tree = Cache::tags(['shop', 'category', date('Ymd')])->remember('list', 60 * 12, function () {
            $cate_tree = Category::where('is_show', 1)
                ->select('cat_id', 'cat_name', 'parent_id', 'is_show')
                ->orderBy('sort_order', 'desc')->orderBy('cat_id', 'desc')->get();
            return $cate_tree;
        });
        return $cate_tree;
    }

    private function shoupin($str)
    {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{
            0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{
            0});
        $s1 = iconv('UTF-8', 'GBK', $str);
        $s2 = iconv('GBK', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        @$asc = ord($s{
            0}) * 256 + ord($s{
            1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) return 'A';
        if ($asc >= -20283 && $asc <= -19776) return 'B';
        if ($asc >= -19775 && $asc <= -19219) return 'C';
        if ($asc >= -19218 && $asc <= -18711) return 'D';
        if ($asc >= -18710 && $asc <= -18527) return 'E';
        if ($asc >= -18526 && $asc <= -18240) return 'F';
        if ($asc >= -18239 && $asc <= -17923) return 'G';
        if ($asc >= -17922 && $asc <= -17418) return 'H';
        if ($asc >= -17417 && $asc <= -16475) return 'J';
        if ($asc >= -16474 && $asc <= -16213) return 'K';
        if ($asc >= -16212 && $asc <= -15641) return 'L';
        if ($asc >= -15640 && $asc <= -15166) return 'M';
        if ($asc >= -15165 && $asc <= -14923) return 'N';
        if ($asc >= -14922 && $asc <= -14915) return 'O';
        if ($asc >= -14914 && $asc <= -14631) return 'P';
        if ($asc >= -14630 && $asc <= -14150) return 'Q';
        if ($asc >= -14149 && $asc <= -14091) return 'R';
        if ($asc >= -14090 && $asc <= -13319) return 'S';
        if ($asc >= -13318 && $asc <= -12839) return 'T';
        if ($asc >= -12838 && $asc <= -12557) return 'W';
        if ($asc >= -12556 && $asc <= -11848) return 'X';
        if ($asc >= -11847 && $asc <= -11056) return 'Y';
        if ($asc >= -11055 && $asc <= -10247) return 'Z';
        return null;
    }

    private function category($key = '')
    {
        $cate_tree = cate_tree_new();
        if ($key == 'n') {
            $cate_tree = $cate_tree->merge(Category::with([
                'cate' => function ($query) {
                    $query->with([
                        'cate' => function ($query) {
                            $query->where('is_show', 1)
                                ->select('cat_id', 'cat_name', 'parent_id', 'is_show');
                        }
                    ])->where('is_show', 1)
                        ->select('cat_id', 'cat_name', 'parent_id', 'is_show');
                }
            ])->where('is_show', 1)->where('parent_id', 949)
                ->select('cat_id', 'cat_name', 'parent_id', 'is_show')
                ->orderBy('sort_order', 'desc')->orderBy('cat_id', 'desc')->get());
        }
        $result = [];
        foreach ($cate_tree as $v) {
            if (in_array($v->cat_id, [490])) {
                $result['b']['list'][] = $v;
                $result['b']['type'] = 1;
            }
            if (in_array($v->cat_id, [496])) {
                $result['c']['list'][] = $v;
                $result['c']['type'] = 1;
            }
            if (in_array($v->cat_id, [531, 548])) {
                $result['d']['list'][] = $v;
                $result['d']['type'] = 2;
            }
            if (in_array($v->cat_id, [575])) {
                $result['e']['list'][] = $v;
                $result['e']['type'] = 1;
            }
            if (in_array($v->cat_id, [620])) {
                $result['f']['list'][] = $v;
                $result['f']['type'] = 1;
            }
            if (in_array($v->cat_id, [536, 584])) {
                $result['g']['list'][] = $v;
                $result['g']['type'] = 2;
            }
            if (in_array($v->cat_id, [619, 767])) {
                $result['h']['list'][] = $v;
                $result['h']['type'] = 2;
            }
            if (in_array($v->cat_id, [788, 778, 796])) {
                $result['i']['list'][] = $v;
                $result['i']['type'] = 2;
            }
            if (in_array($v->cat_id, [801, 655, 665])) {
                $result['j']['list'][] = $v;
                $result['j']['type'] = 2;
            }
            if (in_array($v->cat_id, [674, 682])) {
                $result['k']['list'][] = $v;
                $result['k']['type'] = 2;
            }
            if (in_array($v->cat_id, [683, 12, 732, 739, 751, 899, 922])) {
                $result['m']['list'][] = $v;
                $result['m']['type'] = 3;
            }
            if (in_array($v->cat_id, [934, 937, 941, 946, 950])) {
                $result['n']['list'][] = $v;
                $result['n']['type'] = 2;
            }
        }
        if (!empty($key)) {
            return $result[$key];
        }
        return $result;
    }

    private function fl_tj($query, $cate_tree, $ylfl)
    {
        $cat_ids = $cate_tree->whereLoose('parent_id', $ylfl)->pluck('cat_id')->toArray();
        if (count($cat_ids) == 0) {
            $query->where('cat_ids', 'like', '%' . $ylfl . '%');
        } else {
            $query->where(function ($where) use ($cat_ids, $cate_tree) {
                if (count($cat_ids) > 0) {
                    foreach ($cat_ids as $cat_id) {
                        $where->orwhere('cat_ids', 'like', '%' . $cat_id . '%');
                        $cids = $cate_tree->where('parent_id', $cat_id)->pluck('cat_id')->toArray();
                        if (count($cids) > 0) {
                            foreach ($cids as $cid) {
                                $where->orwhere('cat_ids', 'like', '%' . $cid . '%');
                            }
                        }
                    }
                }
            }); //药理分类
        }
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
                        } elseif (in_array($this->user->city, [322, 342, 327, 331]) && in_array($this->user->user_rank, [2])) {
                            if (in_array($this->user->city, [322]) && in_array($this->user->user_rank, [2])) {
                                $query->where('ls_ranks', 'not like', '%' . $this->user->user_rank . '%')->orwhereNull('ls_ranks')->orwhereIn('goods_id', [14063, 14288, 7579]);
                            } else {
                                $query->where('ls_ranks', 'not like', '%' . $this->user->user_rank . '%')->orwhereNull('ls_ranks')->orwhereIn('goods_id', [14203]);
                            }
                        } else {
                            $query->where('ls_ranks', 'not like', '%' . $this->user->user_rank . '%')->orwhereNull('ls_ranks');
                        }
                    }) //没有等级限制;
                    ->where('ls_regions', 'not like', '%.' . $country . '.%') //没有区域限制
                    ->where('ls_regions', 'not like', '%.' . $province . '.%')
                    ->where(function ($query) use ($city) {
                        if (in_array($this->user->city, [322, 342, 327, 331]) && in_array($this->user->user_rank, [2])) {
                            $query->where('ls_regions', 'not like', '%.' . $city . '.%')->orwhereIn('goods_id', [14203]);
                        } else {
                            $query->where('ls_regions', 'not like', '%.' . $city . '.%');
                        }
                    })
                    ->where('ls_regions', 'not like', '%.' . $district . '.%')
                    ->where('ls_user_ids', 'not like', '%.' . $this->user->user_id . '.%')
                    ->orwhere('xzgm', 1)
                    ->orwhere('ls_buy_user_id', 'like', '%.' . $this->user->user_id . '.%'); //允许购买的用户
            });
        }
    }

    private function step($query, $step)
    {
        switch ($step) {
            case 'cx':
                $query->where(function ($where) {
                    $where->where('zyzk', '>', 0)->orwhere('is_zx', 1);
                });
                $this->sort = 'zyzk';
                $this->assign['page_title'] = '促销产品-';
                break;
            case 'nextpro':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->where('promote_start_date', '>', time())->where('is_xkh_tj', '!=', 1); //不查新客户特价
                if (auth()->check()) {
                    $kx_ids = self::kx_goods();
                    if (count($kx_ids) > 0) {
                        $query->whereNotIn('goods_id', $kx_ids);
                    }
                }

                break;
            case 'cj';
                $query->whereIn('goods_id', ['763', '13595']);
                break;
            case 'jery';
                $query->whereIn('goods_id', ['16525', '18069']);
                break;
            case 'promotion':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
                if (auth()->check()) {
                    $kx_ids = self::kx_goods();
                    if (count($kx_ids) > 0) {
                        $query->whereNotIn('goods_id', $kx_ids);
                    }
                }
                break;
            case 'zy_nextpro':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)->where('show_area', 'like', '%4%')
                    ->where('promote_start_date', '>', time())->where('is_xkh_tj', '!=', 1); //不查新客户特价
                if (auth()->check()) {
                    $kx_ids = self::kx_goods();
                    if (count($kx_ids) > 0) {
                        $query->whereNotIn('goods_id', $kx_ids);
                    }
                }
                break;
            case 'zy_promotion':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)->where('show_area', 'like', '%4%')
                    ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
                if (auth()->check()) {
                    $kx_ids = self::kx_goods();
                    if (count($kx_ids) > 0) {
                        $query->whereNotIn('goods_id', $kx_ids);
                    }
                }
                break;
            case 'xkh':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', 1);
                if (auth()->check()) {
                    $kx_ids = self::kx_goods();
                    if (count($kx_ids) > 0) {
                        $query->whereNotIn('goods_id', $kx_ids);
                    }
                }
                break;
            case 'tejia':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)->whereIn('goods_sn', [
                    '01070991', '01010214', '01011139',
                    '0600156', '01010040', '01046065', '01030164', '01030287', '01010372', '01020283', '01010542', '01070188',
                    '01020385', '01041134', '01043989', '01040898', '01020754', '01011240', '0600153', '00200002'
                ])
                    ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
                if (auth()->check()) {
                    $kx_ids = self::kx_goods();
                    if (count($kx_ids) > 0) {
                        $query->whereNotIn('goods_id', $kx_ids);
                    }
                }
                break;
            case 'cjtj':
                $query->whereIn('goods_sn', [
                    '01021194', '01046198', '01045815', '01046200', '01046544', '01045448', '01071688', '01071838',
                    '01044463', '01046956', '01061289', '01012675', '01071065', '01045074', '01011918', '01045915', '01060891', '01045388', '01045626'
                ]);
                break;
            case 'jzqb':
                $query->where('tsbz', 'like', '%y%');
                break;
            case 'mjy':
                $query->where('product_name', 'like', '%成都岷江源药业股份有限公司%');
                break;
            case 'drt':
                $query->where('product_name', 'like', '%四川德仁堂中药%');
                break;
            case 'zy':
                $query->where('show_area', 'like', '%4%');
                break;
            case 'zyhd':
                $query->where(function ($query) {
                    $query
                        ->where('product_name', 'like', '%湖北金贵中药饮片有限公司%')
                        ->orwhere('product_name', 'like', '%四川天然生中药饮片有限公司%')
                        ->orwhere('product_name', 'like', '%成都岷江源药业股份有限公司%')
                        ->orwhere('product_name', 'like', '%广东正韩药业股份有限公司%');
                });
                break;
            case 'zk':
                $query->where('goods_weight', '>', 0);
                break;
            case 'hg':
                $query->where('tsbz', 'like', '%h%');
                break;
            case 'id':
                $query->whereIn('goods_id', [18046, 9758]);
                break;
            case 'trt':
                $query->whereIn('goods_sn', ['02010565', '02010501']);
                break;
            case 'jfk':
                $query->whereIn('goods_sn', ['01010478', '01030114']);
                break;
            case 'tj':
                $query->whereIn('goods_sn', ['01060652', '01060413', '01061238', '01042625', '01061239', '01060585']);
                break;
            case 'dkyy':
                $query->whereIn('goods_sn', ['01046739', '01040450', '01013093', '01031422']);
                break;
            case 'bjsla':
                $query->whereIn('goods_sn', ['0600538', '0600257', '01045260', '01040271']);
                break;
            case 'dls':
                $query->whereIn('goods_sn', ['02020186', '02020184', '02020185', '02020401', '02020183']);
                break;
            case 'zytj':
                $query->whereIn('goods_sn', [
                    '05002169', '05003714', '05003719', '05004075', '05004123', '05004194',
                    '05004312', '05004320', '05004504', '05004647', '05004652', '05004761', '05004820', '05004951',
                    '05005024', '05005749', '05005753', '05005844', '05005868', '05005884', '05005912', '05005939',
                    '05005962', '05005979', '05006124', '05006155', '05006157'
                ]);
                break;
            case 'tjhz':
                $query->whereIn('goods_sn', [
                    '0600448', '01012832', '01021335', '01032154', '01045851', '01032155', '01021332', '01021334',
                    '01021337', '01021374', '01012834', '03030703', '03030704', '01045821', '01032275', '03030719', '01045636', '01044561', '01012833'
                ]);
                break;
            case 'tjhzhd':
                $query->whereIn('goods_sn', [
                    '01012834', '01021332', '01012832', '01045851', '01032154', '01021374', '01021337', '01021334', '01021335', '03030704', '01032275', '01045821', '03030703'
                ]);
                break;
            case 'ydyy':
                $query->whereIn('goods_sn', ['01070317', '01071624', '01070540', '01071666', '01070935']);
                break;
            case 'zshd':
                $query->whereIn('goods_sn', ['01011240', '01070335', '01011239']);
                break;
            case 'njzd':
                $query->whereIn('goods_sn', ['01040453', '01046206', '01021186', '01045762', '01046207', '01045453']);
                break;
            case 'jrzz':
                $query->where('tsbz', 'like', '%j%');
                break;
            case 'jwxsp':
                $query->whereIn('goods_sn', ['01043977', '01042502']);
                break;
            case 'cjhd':
                $query->whereIn('goods_sn', ['01042444', '01070198']);
                break;
            case 'fybgq':
                $query->whereIn('goods_sn', ['02010658', '02010659', '02010660']);
                break;
            case 'wtgk':
                $query->whereIn('goods_sn', ['01043628', '01043988']);
                break;
            case 'fys':
                $query->whereIn('goods_sn', [
                    '03020086', '03020167', '03040329', '03040328', '03040327', '02010547',
                    '02010546', '02010495', '02010497', '03030309', '03030304', '03030305', '03030307', '03030308',
                    '06000288', '0600287', '06000428', '03030626', '0600427', '06000427', '06000426', '0600426',
                    '03030625', '03030440', '03030441', '03030442', '03030443', '03030444', '03030445', '03030446', '03030447'
                ]);
                break;
                //慢严舒柠
            case 'mysn':
                $query->whereIn('goods_sn', ['01031260', '03030019', '03030020', '03030215', '03030022']);
                break;
                //丽珠医药
            case 'lzyy':
                $query->whereIn('goods_sn', ['01010149', '01030090', '01030092']);
                break;
                //华润三九
            case 'hrsj':
                $query->whereIn('goods_sn', [
                    '01070021', '01070120', '01070176', '01070171', '01071830', '01071829', '01071828',
                    '01070173', '01070518', '01071831', '01021111', '01021110', '01021535', '01030217', '01013170', '01030235',
                    '01032589', '01032499', '01020371', '01021548', '01031530', '01032708', '01031620', '01031689', '01021008',
                    '01021711', '01070818', '01021712', '01020896', '01030688', '01032498', '01070059', '01031296', '01030079',
                    '01013095', '01013452', '01071827', '01070981'
                ]);
                break;
                //扬子江系列
            case 'yzj':
                $query->whereIn('goods_sn', [
                    '01044745', '01043869', '01044351', '01044023', '01013101', '01012824', '01030403',
                    '01042680', '01010984', '01045668', '01040934', '01042428', '01030213', '01043301', '01030639', '01042363',
                    '01020189', '01013311'
                ]);
                break;
                //韩金靓
            case 'hjl':
                $query->whereIn('goods_sn', ['03010085', '03010055', '03010056', '03010054', '03010086']);
                break;
            case 'sht':
                $query->whereIn('goods_sn', [
                    '06000385', '06000384', '0600386', '0600387', '0600384',
                    '0600389', '0600390', '0600383', '0600380', '06000389', '0600388', '0600381', '0600385', '06000390', '06000391', '06000395', '0600382'
                ]);
                break;
            case 'cxhd':
                $query->whereIn('goods_sn', [
                    '01071688', '01071838', '01044463', '01046956', '01013228', '01061576', '01060891',
                    '01061241', '01071065', '01060889', '01061289', '01045626', '01045279', '01044876', '01045388', '01012675'
                ]);
                break;
            case 'mz':
                $query->where('tsbz', 'like', '%m%');
                break;
            case 'zyzk':
                $query->where(function ($where) {
                    $where->where('zyzk', '>', 0)->orwhere('is_zx', 1);
                });
                break;
            case 'trt':
                $query->where(function ($where) {
                    $where->where('zyzk', '>', 0)->orwhere('is_zx', 1);
                });
                break;
            default:
                if ($step != '' && $step > 0) {
                    $query->where('brand_id', intval($step));
                }
        }
    }

    public function kx_goods()
    {
        $ids = [];
        if (auth()->check()) {
            $user = auth()->user()->is_zhongduan();
            $kxpz = kxpzPrice::where(function ($query) use ($user) {
                $query->where('ls_regions', 'like', '%.' . $user->country . '.%') //区域限制
                    ->orwhere('ls_regions', 'like', '%.' . $user->province . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $user->city . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $user->district . '.%')
                    ->orwhere('user_id', $user->user_id); //会员限制
            })->select('area_price', 'company_price', 'goods_id')->get();
            if (count($kxpz) > 0) {
                foreach ($kxpz as $v) {
                    if ($user->is_zhongduan && $v->area_price > 0) { //终端客户
                        $ids[] = $v->goods_id;
                    } elseif (!$user->is_zhongduan && $v->company_price > 0) {
                        $ids[] = $v->goods_id;
                    }
                }
            }
        }
        return $ids;
    }

    protected function xl_top()
    {
        $result = Cache::tags(['shop', 'xl_top'])->remember('week', 60 * 24, function () {
            $query = DB::table('order_goods as og')
                ->leftJoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
                ->leftJoin('goods as g', 'g.goods_id', '=', 'og.goods_id')
                ->where('oi.order_status', 1)
                ->where('og.goods_sn', 'not like', '05%')
                ->where('oi.add_time', '>', strtotime('-7 days'))
                ->orderBy('num', 'desc')->groupBy('og.goods_id')->take(10)
                ->select(
                    'g.goods_name',
                    'g.goods_id',
                    'g.goods_thumb',
                    DB::raw('sum(ecs_og.goods_number) as num')
                );
            $result = $query->get();
            foreach ($result as $v) {
                $v->ypgg = GoodsAttr::where('goods_id', $v->goods_id)->where('attr_id', 3)->pluck('attr_value');
                $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
                $v->goods_thumb = get_img_path($v->goods_thumb);
                $v->goods_url = route('goods.index', ['id' => $v->goods_id]);
            }
            return $result;
        });
        return $result;
    }

    protected function check_user()
    {

        if ($this->user) {
            if ($this->user->is_zhongduan == 0) {
                tips1('特价活动只针对终端');
            }
            $start1 = strtotime(20180907);
            $start2 = strtotime(20180912);
            if (in_array($this->user->user_id, cs_arr())) {
                //$start1 -= 3600 * 24;
                //$start2 -= 3600 * 24;
            }
            $end1 = strtotime(20180912);
            $end2 = strtotime(20180914);
            $time = time();
            //成都区域不能访问
            if ($time > $start1 && $time < $end1 && in_array($this->user->city, [322])) {
                tips1('该活动针对成都以外地区终端客户，成都地区活动时间9月13号敬请期待！');
            }
            //成都以外区域不能访问
            if ($time > $start2 && $time < $end2 && !in_array($this->user->city, [322])) {
                tips1('该活动只针对成都地区终端客户');
            }
        }
    }

    protected function check_user1()
    {
        if ($this->now > $this->end) {
            tips1('活动未开始');
        }
        if ($this->user) {
            if ($this->user->is_zhongduan == 0) {
                tips1('特价活动只针对终端');
            }
            $start = strtotime(20180531);
            if (in_array($this->user->user_id, cs_arr())) {
                $start -= 3600 * 24;
            }
            $end = strtotime(20180701);
            $time = time();
            //区域特价
            if ($time > $start && $time < $end && !((in_array($this->user->city, [331]) && !in_array($this->user->district, [2826])) || in_array($this->user->district, [2791]))) {
                tips1('该活动只针对乐山（除夹江）及中江地区终端客户');
            }
        }
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




}
