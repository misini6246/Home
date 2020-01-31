<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Goods;
use App\Http\Controllers\User\UserTrait;
use App\Models\CxGoods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    use UserTrait;
    public $show_area = 26;
    public $cache = false;

    public function __construct(Request $request)
    {
        $this->user = auth()->user();
        $this->now = time();
        if ($this->user) {
            if ($this->user->province == 29) {
                $this->user = $this->user->is_new_user_xj();
            } else {
                $this->user = $this->user->is_new_user();
            }
            $this->show_area = $this->user->province;
            if (($this->now >= strtotime(20180510) && $this->now < strtotime(20180801)) || in_array($this->user->user_id, cs_arr())) {
                $this->set_assign('mhj_qrh', DB::table('mhj_qrh')->where('is_confirm', 0)->where('user_id', $this->user->user_id)->get());
            }
        } else {
            $this->show_area = intval($request->input('show_area', 26));
        }
        $this->set_assign('page_title', '');
        $this->set_assign('show_area', $this->show_area);
        $this->set_assign('user', $this->user);
        $this->set_assign('middle_nav', nav_list('middle', -1));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kfdh = Cookie::get('kfdh', 0);
        $this->set_assign('kfdh', $kfdh);
        if ($this->user) {
            if ($this->cache == true) {
                $cache_key = 'is_new_user' . $this->user->is_new_user . '-user_rank'
                    . $this->user->user_rank . '-province' . $this->user->province
                    . '-city' . $this->user->city . '-district' . $this->user->district;
                $cache_key = 'user_rank' . $this->user->user_rank;
                $cx_goods = Cache::tags(['shop', 'index'])->remember($cache_key . '-cx_goods', 1, function () {
                    return $this->cx_goods();
                });
                $zp = Cache::tags(['shop', 'index'])->remember($cache_key . '-zp', 1, function () {
                    return $this->zp();
                });
            } else {
                $cx_goods = $this->cx_goods();
//                $zp = $this->zp();
            }
        } else {
            if ($this->cache == true) {
                $cache_key = 'visit';
                $cx_goods = Cache::tags(['shop', 'index'])->remember($cache_key . '-cx_goods', 1, function () {
                    return $this->cx_goods1();
                });
//                $zp = Cache::tags(['shop', 'index'])->remember($cache_key . '-zp', 1, function () {
//                    return $this->zp1();
//                });
            } else {
                $cx_goods = $this->cx_goods1();
                $zp = $this->zp1();
            }
        }
        //dd($cx_goods[8]);
        $this->set_assign('cx_goods', $cx_goods);
        $this->set_assign('dh_check', 29);
//        $this->set_assign('zp', $zp);
        $art1=articles(17,4);
        $art2=articles(20,4);
        $this->set_assign('art1', $art1);//公司动态
        $this->set_assign('art2', $art2);//公司动态
        //dd($art1,$art2);
        $this->yindao();

        // 当前用户当日是否签到
        // $this->set_assign('is_qiandao',$this->is_qiandao());
        $this->set_assign('is_show_yhq',$this->is_show_yhq());
        if ($this->cache == false) {
           // dd(11);
            $this->ads($this->now);

            return view('new.index', $this->assign);
        } else {
            //dd(22);
            $this->ads1();
            return view('new.cache', $this->assign);
        }
    }

    public function index_yl(Request $request)
    {
        $this->now += intval($request->input('days')) * 3600 * 24;
        $kfdh = Cookie::get('kfdh', 0);
        $this->set_assign('kfdh', $kfdh);
        if ($this->user) {
            if ($this->cache == true) {
                $cache_key = 'is_new_user' . $this->user->is_new_user . '-user_rank'
                    . $this->user->user_rank . '-province' . $this->user->province
                    . '-city' . $this->user->city . '-district' . $this->user->district;
                $cache_key = 'user_rank' . $this->user->user_rank;
                $cx_goods = Cache::tags(['shop', 'index'])->remember($cache_key . '-cx_goods', 1, function () {
                    return $this->cx_goods();
                });
                $zp = Cache::tags(['shop', 'index'])->remember($cache_key . '-zp', 1, function () {
                    return $this->zp();
                });
            } else {
                $cx_goods = $this->cx_goods();
                $zp = $this->zp();
            }
        } else {
            if ($this->cache == true) {
                $cache_key = 'visit';
                $cx_goods = Cache::tags(['shop', 'index'])->remember($cache_key . '-cx_goods', 1, function () {
                    return $this->cx_goods1();
                });
                $zp = Cache::tags(['shop', 'index'])->remember($cache_key . '-zp', 1, function () {
                    return $this->zp1();
                });
            } else {
                $cx_goods = $this->cx_goods1();
                $zp = $this->zp1();
            }
        }
        //dd($cx_goods[8]);
        $this->set_assign('cx_goods', $cx_goods);
        $this->set_assign('dh_check', 29);
        $this->set_assign('zp', $zp);
        $this->set_assign('art1', articles(4, 4));//公司动态
        $this->set_assign('art2', articles(12, 4));//公司动态
        $this->ads($this->now);
        if ($this->show_area != 26) {//争分夺秒
            $ad124 = ads_yl($this->now, 175);
        } else {
            $ad124 = ads_yl($this->now, 174);
        }
        $this->set_assign('ad124', $ad124);
        return view('new.index', $this->assign);
    }

    public function cx_goods($type = [5, 6, 7, 9, 11, 12, 13, 14, 15, 16,18])
    {
        $result = CxGoods::whereIn('type', $type)->orderBy('sort_order', 'desc')->get();
        $ids = $result->lists('goods_id')->toArray();
        $real_price = $this->real_price($ids);
        $lists = [];
        foreach ($result as $k => $v) {
            $jh = new Goods();
            $arr = isset($real_price[$v->goods_id]) ? $real_price[$v->goods_id] : [];
            foreach ($arr as $key => $val) {
                $v->$key = $val;
            }
            if ($this->user->ls_review == 1 || ($this->user->ls_review_7day == 1 && $this->user->day7_time > time())){
                $v->format_price = formated_price($v->real_price);
            }else{
                $v->format_price = '会员可见';
            }
            $jh->forceFill(collect($v)->toArray());
            $lists[$v->type][] = $jh;
        }
        //dd($lists);
        return $lists;
    }

    public function cx_goods1($type = [5, 6, 7, 9, 11, 12, 13, 14, 15, 16,18])
    {
        $result = CxGoods::with([
            'goods' => function ($query) {
                $query->select('goods_id', 'goods_thumb');
            }
        ])->whereIn('type', $type)
            ->orderBy('sort_order', 'desc')->get();
        $lists = [];
        foreach ($result as $v) {
            //dd($v->goods->goods_thumb);
            //$v->goods_thumb = $v->goods->goods_thumb;
            $v->goods_thumb = !empty($v->goods->goods_thumb) ? $v->goods->goods_thumb : 'images/no_picture.gif';
            $v->goods_thumb = get_img_path($v->goods_thumb);
            $v->format_price = '会员可见';
            $lists[$v->type][] = $v;
        }
        return $lists;
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
        ])->whereIn('type', [8, 10])->orderBy('sort_order', 'desc')->get();

        $ids = $result->lists('goods_id')->toArray();
        $real_price = $this->real_price($ids);
        $lists = [];


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
        ])->whereIn('type', [8, 10])->orderBy('sort_order', 'desc')->get();
        $lists = [];
        foreach ($result as $k => $v) {

        }
        return $lists;
    }

    private function ads($time)
    {
        if ($this->show_area != 26) {//争分夺秒
            $ad124 = ads(174);
        } else {
            $ad124 = ads(174);
        }

        // dd($ad124);
        if ($this->user) {
            $whereIn = [0];
            if ($this->user->province == 26) {
                $whereIn[] = 1;
                if ($this->user->is_zhongduan == 1) {
                    $whereIn[] = 9;
                }
            } else {
                $whereIn[] = 2;
            }

            if ($this->user->is_new_user == 1) {
                $whereIn[] = 3;
            } elseif ($this->user->is_new_user_xj == 1) {
                $whereIn[] = 4;
            }
            if ($this->user->is_zhongduan == 1) {
                $whereIn[] = 5;
            }
            if ($this->user->city == 322) {
                $whereIn[] = 6;
            } else {
                $whereIn[] = 7;
            }
            if (in_array($this->user->district, [2730, 2736])) {
                $whereIn[] = 8;
            }
        } else {
            $whereIn = [0, 1, 2, 5, 7, 8, 9];
        }

        $where = function ($where) use ($whereIn) {
            $where->whereIn('show_area', $whereIn);
        };
        //首页轮播图
        $ad121 = Ad::where('enabled', '>', 0)->where('start_time', '<', $time)->where('end_time', '>', $time)->where('position_id', 173);

        $ad27 = Ad::where('enabled', '>', 0)->where('start_time', '<', $time)->where('end_time', '>', $time)->where('position_id', 27);
        $ad124 = Ad::where('enabled', '>', 0)->where('start_time', '<', $time)->where('end_time', '>', $time)->where('position_id', 174);
        if ($where instanceof \Closure) {
            $ad121->where($where);
            $ad27->where($where);
            $ad124->where($where);
        }

        $ad121 = $ad121->orderBy('sort_order', 'desc')->orderBy('ad_id', 'desc')->get();

        $ad27 = $ad27->orderBy('sort_order', 'desc')->orderBy('ad_id', 'desc')->first();
        $ad124 = $ad124->orderBy('sort_order', 'desc')->orderBy('ad_id', 'desc')->get();
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
        $this->set_assign('ad155', $ad155);
        $this->set_assign('ad155_width', $ad155_width);
        $this->set_assign('ad27', $ad27);
        $this->set_assign('ad121', $ad121);
        $this->set_assign('ad123', ads(123));
        $this->set_assign('ad124', $ad124);
        $this->set_assign('ad126', ads(176));
        $this->set_assign('ad128', ads(128));
        $this->set_assign('ad129', ads(177));
        $this->set_assign('ad131', ads(131));
        $this->set_assign('ad133', ads(178));
        $this->set_assign('ad137', ads(179));
        $this->set_assign('ad140', ads(180));
        $this->set_assign('ad198', ads(198));
        $this->set_assign('ad201', ads(201));
        $this->set_assign('ad202', ads(202));
        $this->set_assign('ad203', ads(203));
        $this->set_assign('ad207', ads(207));
        $this->set_assign('ad208', ads(208));
    }

    private function ads1()
    {
        if ($this->show_area != 26) {//争分夺秒
            $ad124 = ads(175);
        } else {
            $ad124 = ads(174);
        }
        //首页轮播图
        $ad121 = ads(173);
        $ad27 = ads(27, true);
        if ($this->user) {
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
        foreach ($ad121 as $k => $v) {
            if (!in_array($v->show_area, $whereIn)) {
                unset($ad121[$k]);
            }
        }
        if (!in_array($ad27->show_area, $whereIn)) {
            $ad27 = null;
        }
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
        $this->set_assign('ad155', $ad155);
        $this->set_assign('ad155_width', $ad155_width);
        $this->set_assign('ad27', $ad27);
        $this->set_assign('ad121', $ad121);
        $this->set_assign('ad123', ads(123));
        $this->set_assign('ad124', $ad124);
        $this->set_assign('ad126', ads(176));
        $this->set_assign('ad128', ads(128));
        $this->set_assign('ad129', ads(177));
        $this->set_assign('ad131', ads(131));
        $this->set_assign('ad133', ads(178));
        $this->set_assign('ad137', ads(179));
        $this->set_assign('ad140', ads(180));
    }

    protected function yindao()
    {
        if ($this->now > strtotime('20180701')) {
            $yindao = 1;
        } else {
            $tags = 'download_web';
            $yindao = Cookie::get($tags, 0);
            if ($yindao == 0) {
                Cookie::queue($tags, 1, 24 * 60 * 15);
            }
        }
        $this->set_assign('yindao', $yindao);
    }

    public function show_yindao()
    {
        $this->set_assign('page_title', '网站入口下载引导');
        return view('new.yindao', $this->assign);
    }

    //当前用户当日是否签到
    public function is_qiandao()
    {
        $year=intval(date('Y'));
        $month=intval(date('m'));
        $day=intval(date('d'));
        if ($this->user) {
            $info = DB::connection('mysql_jf')->table('qiandao')
                ->where('user_id','=',$this->user->user_id)->where('year','=',$year)
                ->where('month','=',$month)->where('day','=',$day)
                ->first();
            if ($info) {
                return 1;
            } else{
                return 0;
            }
        }else{
            //未登录返回false
            return 0;
        }
    }
    // 判断是否显示优惠券弹窗
    public function is_show_yhq()
    {
        $today=strtotime(date('Y-m-d',time()).' 00:00:00');
        if(is_null($this->user)) {
            // 未登录则显示
            return true;
        }
        if($this->user->last_login<$today){
            // 最后登录时间小于今天则显示
            return true;
        }
        return false;
    }
}
