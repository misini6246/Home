<?php

namespace App\Http\Controllers;


use App\Ad;
use App\Buy;
use App\Goods;
use App\User;
use App\YouHuiQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $nav_list;

    private $arr;

    private $user;

    private $show_area;

    private $is_new_user;

    public function __construct(Request $request)
    {
        $this->nav_list = nav_list('middle', -1);
        $this->user = auth()->user();
        if ($this->user) {
            if ($this->user->province == 29) {
                $this->user = $this->user->is_new_user_xj();
            } else {
                $this->user = $this->user->is_new_user();
            }
            $this->is_new_user = $this->user->is_new_user;
            $this->show_area = auth()->user()->province;
        } else {
            $this->show_area = intval($request->input('show_area', 26));
        }
        $this->arr = [
            'page_title' => '',
            'middle_nav' => $this->nav_list,
            'nav_shijian' => 0,
        ];
        //dd($this->nav_list);
    }

    public function index(Request $request)
    {

        /**
         * 广告
         */
        //$this->arr['ad26'] = ads(26,1);//顶部
        //$this->old_ads();
        if (auth()->check()) {
            $user_id = auth()->user()->user_id;
            if ($user_id == 13960) {
                //$this->new_ads();
            }
        }
        $this->new_ads();
        /**
         * 求购信息
         */
        $buy = Cache::tags(['shop', 'buy'])->remember('buy', 60, function () {
            return Buy::buy(20);//求购信息
        });
        $this->arr['buy'] = $buy;
        if ($this->is_new_user == 1) {
            $ad27 = Ad::where('start_time', '<', time())->where('end_time', '>', time())->where('position_id', 27)
                ->where(function ($query) {
                    $query->where('ad_id', '=', 1133)->orwhere('ad_id', '=', 1188);
                })
                ->select('position_id', 'ad_id', 'ad_name', 'ad_code', 'start_time', 'ad_link', 'end_time', 'ad_bgc')->first();

            $ad1 = Ad::where('start_time', '<', time())->where('end_time', '>', time())->where('position_id', 1)
                //->where('ad_id','=', 1123)
                ->select('position_id', 'ad_id', 'ad_name', 'ad_code', 'start_time', 'ad_link', 'end_time', 'ad_bgc')
                ->orderBy('sort_order', 'desc')->orderBy('ad_id', 'desc')->get();
        } else {
            $ad27 = Ad::where('start_time', '<', time())->where('end_time', '>', time())->where('position_id', 27)
                ->where('ad_id', '!=', 1133)->where('ad_id', '!=', 1188)
                ->select('position_id', 'ad_id', 'ad_name', 'ad_code', 'start_time', 'ad_link', 'end_time', 'ad_bgc')->first();

            $ad1 = Ad::where('start_time', '<', time())->where('end_time', '>', time())->where('position_id', 1)
                ->where('ad_id', '!=', 1123)
                ->select('position_id', 'ad_id', 'ad_name', 'ad_code', 'start_time', 'ad_link', 'end_time', 'ad_bgc')
                ->orderBy('sort_order', 'desc')->orderBy('ad_id', 'desc')->get();
        }
        foreach ($ad1 as $v) {
            $v->ad_code = get_img_path($v->ad_code);
        }
        $this->arr['ad27'] = $ad27;//弹窗
        $this->arr['ad1'] = $ad1;//轮播

        /**
         * 新闻
         */
        $this->arr['art1'] = articles(4, 11);//公司动态
        $this->arr['art2'] = articles(12, 11);//行业新闻
        $this->arr['show_area'] = $this->show_area;
        if ($this->show_area == 26) {
            $url = '<li data-url="' . route('index', ['show_area' => 29]) . '">新疆</li>';
        } else {
            $url = '<li data-url="' . route('index', ['show_area' => 26]) . '">四川</li>';
        }
        $this->arr['show_area_url'] = $url;
        $this->arr['dh_check'] = 29;
        return view('index')->with($this->arr);
    }


    /*
     * 清除cache
     */
    public function cacheFlush(Request $request)
    {
        $name = $request->input('name');
        $key = $request->input('key');
        if (!empty($name) && !empty($key)) {
            if ($name == 'ad') {
                Cache::tags(['shop', $name, date("Y-m-d", time())])->forget($key);
            } else {
                Cache::tags(['shop', $name])->forget($key);
            }
        } elseif (!empty($name)) {
            Cache::tags($name)->flush();
        } else {
            Cache::tags('shop')->flush();
        }
        return redirect()->route('index');
    }


    private function old_ads()
    {
        if ($this->show_area != 26) {//争分夺秒
            $this->arr['zfdm'] = ads(24);
        } else {
            $this->arr['zfdm'] = ads(8);
        }

        //新品
        $this->arr['ad28'] = ads(28);
        $this->arr['ad29'] = ads(29);
        $this->arr['ad37'] = ads(37);
        //推荐
        $this->arr['ad30'] = ads(30);
        $this->arr['ad31'] = ads(31);
        $this->arr['ad32'] = ads(32);
        $this->arr['ad38'] = ads(38);
        //当季
        $this->arr['ad33'] = ads(33);
        $this->arr['ad39'] = ads(39);
        //家用
        $this->arr['ad35'] = ads(35);
        $this->arr['ad36'] = ads(36);
        $this->arr['ad41'] = ads(41);
        //中药
        $this->arr['ad42'] = ads(42);

        $this->arr = $this->arr;
    }

    private function new_ads()
    {
        if ($this->show_area != 26) {//争分夺秒
            $this->arr['zfdm'] = ads(24);
        } else {
            $this->arr['zfdm'] = ads(8);
        }

        //首页轮播图
        if ($this->is_new_user == 1) {
            $ad100 = Ad::where('start_time', '<', time())->where('end_time', '>', time())->where('position_id', 100)
                //->where('ad_id','=', 1123)
                ->select('position_id', 'ad_id', 'ad_name', 'ad_code', 'start_time', 'ad_link', 'end_time', 'ad_bgc')
                ->orderBy('sort_order', 'desc')->orderBy('ad_id', 'desc')->get();
        } else {
            $ad100 = Ad::where('start_time', '<', time())->where('end_time', '>', time())->where('position_id', 100)
                ->where('ad_id', '!=', 1234)
                ->select('position_id', 'ad_id', 'ad_name', 'ad_code', 'start_time', 'ad_link', 'end_time', 'ad_bgc')
                ->orderBy('sort_order', 'desc')->orderBy('ad_id', 'desc')->get();
        }
        $this->arr['ad100'] = $ad100;
        //轮播右和下
        $this->arr['ad101'] = ads(101);
        $this->arr['ad102'] = ads(102);

        //新品
        $this->arr['ad103'] = ads(103);
        $this->arr['ad104'] = ads(104);
        $this->arr['ad105'] = ads(105);
        $this->arr['ad37'] = ads(37);
        //推荐
        $this->arr['ad106'] = ads(106);
        $this->arr['ad107'] = ads(107);
        $this->arr['ad38'] = ads(38);
        //当季
        $this->arr['ad108'] = ads(108);
        $this->arr['ad109'] = ads(109);
        $this->arr['ad39'] = ads(39);
        //家用
        $this->arr['ad110'] = ads(110);
        $this->arr['ad111'] = ads(111);
        $this->arr['ad41'] = ads(41);
        //中药
        $this->arr['ad112'] = ads(112);
        $this->arr['ad113'] = ads(113);
        $this->arr['ad114'] = ads(114);
        $this->arr['ad115'] = ads(115);
        //求购动态上
        $this->arr['ad116'] = ads(116);
    }

    private function new_ads1($time)
    {
        if ($this->show_area != 26) {//争分夺秒
            $this->arr['ad124'] = ads(149);
            $this->arr['ad125'] = ads(150);
        } else {
            $this->arr['ad124'] = ads(124);
            $this->arr['ad125'] = ads(125);
        }
        if ($this->user) {
            $this->arr['sjtj'] = Ad::where('enabled', 1)->where('start_time', '<', $time)->where('end_time', '>', $time)->where('position_id', 154)->first();
            if ($this->arr['sjtj']) {
//                $sjtj_type = DB::table('user_sjtj')->where('user_id', $this->user->user_id)->first();
//                if (!empty($sjtj_type)) {
//                    $this->arr['sjtj_type'] = $sjtj_type->type;
//                } else {
//                    $this->arr['sjtj_type'] = 1;
//                }
                $yhq = YouHuiQ::where('user_id', $this->user->user_id)->where('cat_id', 50)->count();
                if ($yhq > 0) {
                    $this->arr['sjtj_type'] = 1;
                } else {
                    $this->arr['sjtj_type'] = 0;
                }
            }
            $whereIn = [0];
            if ($this->user->province == 26) {
                $whereIn[] = 1;
            } else {
                $whereIn[] = 2;
            }
            if ($this->user->is_new_user == 1) {
                $whereIn[] = 3;
            } elseif ($this->user->is_new_user_xj == 1) {
                $whereIn[] = 4;
            }
        } else {
            $whereIn = [0, 1, 2];
        }
        $where = function ($where) use ($whereIn) {
            $where->whereIn('show_area', $whereIn);
        };
        //首页轮播图
        $ad121 = Ad::where('enabled', 1)->where('start_time', '<', $time)->where('end_time', '>', $time)->where('position_id', 121);
        $ad27 = Ad::where('enabled', 1)->where('start_time', '<', $time)->where('end_time', '>', $time)->where('position_id', 27);
        if ($where instanceof \Closure) {
            $ad121->where($where);
            $ad27->where($where);
        }
        $ad121 = $ad121->select('position_id', 'ad_id', 'ad_name', 'ad_code', 'start_time', 'ad_link', 'end_time', 'ad_bgc')
            ->orderBy('sort_order', 'desc')->orderBy('ad_id', 'desc')->get();
        $ad27 = $ad27->orderBy('sort_order', 'desc')->orderBy('ad_id', 'desc')->first();
        $this->arr['ad27'] = $ad27;
        if (isset($this->arr['sjtj_type']) && $this->arr['sjtj_type'] == 1) {
            $this->arr['ad27'] = $this->arr['sjtj'];
            $this->arr['sjtj_type'] = 0;
        }
        $this->arr['ad121'] = $ad121;
        $this->arr['ad122'] = ads(122);
        $this->arr['ad123'] = ads(123);


        $this->arr['ad126'] = ads(126);
        $this->arr['ad127'] = ads(127);
        $this->arr['ad128'] = ads(128);
        $this->arr['ad129'] = ads(129);
        $this->arr['ad130'] = ads(130);
        $this->arr['ad131'] = ads(131);
        $this->arr['ad132'] = ads(132);
        $this->arr['ad133'] = ads(133);
        $this->arr['ad134'] = ads(134);
        $this->arr['ad135'] = ads(135);
        $this->arr['ad136'] = ads(136);
        $this->arr['ad137'] = ads(137);
        $this->arr['ad138'] = ads(138);
        $this->arr['ad139'] = ads(139);
        $this->arr['ad140'] = ads(140);
        $this->arr['ad141'] = ads(141);
        //轮播右和下
        $this->arr['ad101'] = ads(101);
        $this->arr['ad102'] = ads(102);

        //新品
        $this->arr['ad103'] = ads(103);
        $this->arr['ad104'] = ads(104);
        $this->arr['ad105'] = ads(105);
        $this->arr['ad37'] = ads(37);
        //推荐
        $this->arr['ad106'] = ads(106);
        $this->arr['ad107'] = ads(107);
        $this->arr['ad38'] = ads(38);
        //当季
        $this->arr['ad108'] = ads(108);
        $this->arr['ad109'] = ads(109);
        $this->arr['ad39'] = ads(39);
        //家用
        $this->arr['ad110'] = ads(110);
        $this->arr['ad111'] = ads(111);
        $this->arr['ad41'] = ads(41);
        //中药
        $this->arr['ad112'] = ads(112);
        $this->arr['ad113'] = ads(113);
        $this->arr['ad114'] = ads(114);
        $this->arr['ad115'] = ads(115);
        //求购动态上
        $this->arr['ad116'] = ads(116);
        $this->arr['ad147'] = ads(147);
        $where = function ($where) {
            $where->where('is_wntj', 1)->where('is_cx', 1)->where('goods_sn', 'not like', '05%');
        };
        $this->arr['wntj'] = Goods::cjsp($where, 'sy_wntj', 15);
        $ad142 = ads(142);
        foreach ($ad142 as $v) {
            $where = function ($where) use ($v) {
                $where->where('product_name', 'like', '%' . $v->ad_bgc . '%')->orwhere('goods_name', 'like', '%' . $v->ad_bgc . '%');
            };
            $v->goods_list = Goods::cjsp($where, $v->ad_bgc);
        }
        $this->arr['ad142'] = $ad142;
        $ad155 = ads(155);
        if (count($ad155) <= 2) {
            $ad155_width = 165;
        } elseif (count($ad155) <= 4) {
            $ad155_width = 165 * 2;
        } elseif (count($ad155) <= 6) {
            $ad155_width = 165 * 3;
        } elseif (count($ad155) <= 8) {
            $ad155_width = 165 * 4;
        } else {
            $ad155_width = 0;
        }
        $this->arr['ad155'] = $ad155;
        $this->arr['ad155_width'] = $ad155_width;
    }

    public function index_new(Request $request)
    {
        $time = time();
        if ($time > strtotime('20170402')) {
            $this->arr['yindao'] = 1;
        } else {
            $tags = 'yindao7' . date('Ymd');
            $yindao = Cookie::get($tags, 0);
            if ($yindao == 0) {
                Cookie::queue($tags, 1, 24 * 60);
            }
            $cookie = Cookie::get('laravel_session_17');
            $yindao1 = Cache::tags([$tags])->remember($cookie, 60 * 24, function () {
                return 0;
            });
            if ($yindao1 == 0) {
                Cache::tags([$tags])->put($cookie, 1, 60 * 24);
            }
            if ($yindao == 0 && $yindao1 == 0) {
                $this->arr['yindao'] = 0;
            } else {
                $this->arr['yindao'] = 1;
            }
        }
        $kfdh = Cookie::get('kfdh', 0);
        $this->arr['kfdh'] = $kfdh;
        /**
         * 广告
         */
        $this->arr['ad152'] = ads(152, 1);//顶部
        //$this->old_ads();
        $this->new_ads1($time);

        /**
         * 新闻
         */
        $this->arr['art1'] = articles(4, 4);//公司动态
        $this->arr['art2'] = articles(12, 4);//促销信息
        $this->arr['show_area'] = $this->show_area;
        if ($this->show_area == 26) {
            $url = '<a href="' . route('index', ['show_area' => 29]) . '"><p id="sichuan">新疆</p></a>';
        } else {
            $url = '<a href="' . route('index', ['show_area' => 26]) . '"><p id="sichuan">四川</p></a>';
        }
        $this->arr['show_area_url'] = $url;
        $this->arr['dh_check'] = 29;
//        if (!auth()->check()) {
//            $type = $request->input('type');
//            if ($type == 1) {
//                file_put_contents("index.html", view('hd', $this->arr)->__toString());
//            }
//        }
        return view('index_new')->with($this->arr);
    }

    public function index_yl(Request $request)
    {
        $time = time() + 3600 * 24 * $request->input('days');
        if ($this->user) {
            if ($this->user->province == 29) {
                $this->user = $this->user->is_new_user_xj_yl($time);
            } else {
                $this->user = $this->user->is_new_user_yl($time);
            }
            $this->is_new_user = $this->user->is_new_user;
            $this->show_area = auth()->user()->province;
        } else {
            $this->show_area = intval($request->input('show_area', 26));
        }
        $tags = 'yindao7' . date('Ymd');
        $yindao = Cookie::get($tags, 0);
        if ($yindao == 0) {
            Cookie::queue($tags, 1, 24 * 60);
        }
        $cookie = Cookie::get('laravel_session_17');
        $yindao1 = Cache::tags([$tags])->remember($cookie, 60 * 24, function () {
            return 0;
        });
        if ($yindao1 == 0) {
            Cache::tags([$tags])->put($cookie, 1, 60 * 24);
        }
        //dd($yindao1,$yindao);
        if ($yindao == 0 && $yindao1 == 0) {
            $this->arr['yindao'] = 0;
        } else {
            $this->arr['yindao'] = 1;
        }
        /**
         * 广告
         */
        $this->arr['ad152'] = ads(152, 1);//顶部
        //$this->old_ads();
        $this->new_ads1($time);
        if ($this->show_area != 26) {//争分夺秒
            $this->arr['ad124'] = ads_yl($time, 149);
            $this->arr['ad125'] = ads_yl($time, 150);
        } else {
            $this->arr['ad124'] = ads_yl($time, 124);
            $this->arr['ad125'] = ads_yl($time, 125);
        }
        /**
         * 新闻
         */
        $this->arr['art1'] = articles(4, 4);//公司动态
        $this->arr['art2'] = articles(12, 4);//促销信息
        $this->arr['show_area'] = $this->show_area;
        if ($this->show_area == 26) {
            $url = '<a href="' . route('index', ['show_area' => 29]) . '"><p id="sichuan">新疆</p></a>';
        } else {
            $url = '<a href="' . route('index', ['show_area' => 26]) . '"><p id="sichuan">四川</p></a>';
        }
        $this->arr['show_area_url'] = $url;
        $this->arr['dh_check'] = 29;
        return view('index_new')->with($this->arr);
    }


    public function log_by_id(Request $request)
    {
        $id = intval($request->input('id'));
        $user = User::find($id);
        Auth::loginUsingId($id);
        return redirect()->route('index');
    }
}
