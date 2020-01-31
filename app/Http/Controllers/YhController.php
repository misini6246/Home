<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Huodong\Action\MsContainer;
use App\Http\Controllers\Huodong\Action\MsTeamController;
use App\Http\Controllers\Huodong\Action\TeamController;
use App\MsCart;
use App\MsGoods;
use App\OrderGoods;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Huodong\Action\MsGoodsController as mgoods;

class YhController extends Controller
{
    private $user;

    private $team;

    private $goods;

    private $now;

    private $tags;

    private $assign = [];

    private $goods_arr = [];

    private $area_xg = [];

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['index', 'buy', 'ms_goods', 'get_cart_goods']]);
        if (auth()->check()) {
            $this->user           = auth()->user()->is_zhongduan();
            $this->user           = $this->user->get_jyfw();
            $this->assign['user'] = $this->user;
        }
        $this->middleware('is_zhongduan', ['only' => ['index', 'buy', 'ms_goods', 'get_cart_goods']]);
        //Cache::store('miaosha')->flush();
        $this->tags                 = '2017-05-04';
        $this->team                 = collect();
        $this->now                  = time();
        $this->area_xg              = [
            8  => '贵州',
            26 => '四川',
            28 => '西藏',
            29 => '新疆',
            30 => '云南',
            32 => '重庆',
        ];
        $this->assign['area_xg']    = $this->area_xg;
        $this->assign['page_title'] = '5月4号优惠活动-';
        $this->assign['now']        = $this->now;
        if (auth()->check() && in_array($this->user->user_id, [18810])) {
            $this->team[] = $this->get_team([strtotime('2017-04-11 15:00:00'), strtotime('2017-05-05 00:00:00'), 1]);
            //$this->team[] = $this->get_team([strtotime('2017-04-11 16:00:00'), strtotime('2017-04-13 00:00:00'), 14]);
        } else {
            $this->team[] = $this->get_team([strtotime('2017-04-12 09:00:00'), strtotime('2017-05-05 00:00:00'), 1]);
            //$this->team[] = $this->get_team([strtotime('2017-04-12 14:00:00'), strtotime('2017-04-13 00:00:00'), 14]);
        }
        $this->goods_arr();
    }

    public function index()
    {
//        if (!in_array($this->user->user_id, [13960, 12567, 18810])) {
//            show_msg('您请求的页面不存在');
//        }
        if($this->now>=strtotime(20170505)){
            return redirect()->route('index');
        }
        foreach ($this->goods_arr as $k => $v) {
            $v['id']   = $k;
            $v['tags'] = $this->tags;
            $this->get_goods($v);
        }
        $now_check = 0;
        foreach ($this->team as $v) {
            $start = $v->start;
            $end   = $v->end;
            if ($this->now < $start) {//活动未开始
                $v->hd_status = 0;
            } elseif ($this->now >= $end) {//活动已经结束
                $v->hd_status = 2;
                $now_check    = -1;
            } else {
                $v->hd_status = 1;
                $now_check    = $v->team;
            }
        }
        $this->assign['team']      = $this->team;
        $this->assign['now_check'] = $now_check;
            if( $this->user->user_id == '4349'){
                    dd($this->assign);
            }

        //dd($this->team,$now_check,date('Y-m-d H:i:s',1481079600),date('Y-m-d H:i:s',$this->now));
        return view('20170412.miaosha', $this->assign);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buy(Request $request)
    {
        if ($this->user->is_zhongduan == 0) {
            $result = $this->show_errors('只有终端会员可以参加活动');
            return $result;
        }
        $id         = intval($request->input('id'));
        $goods_info = $this->get_goods_info($id);
        if (empty($goods_info)) {
            $result = $this->show_errors('商品不存在');
            return $result;
        }
        if (count($goods_info->area_xg) > 0 && !in_array($this->user->province, $goods_info->area_xg)) {//限购
            $tip = '';
            foreach ($goods_info->area_xg as $v) {
                $tip .= '、' . $this->area_xg[$v];
            }
            $tip    = ltrim($tip, '、');
            $result = $this->show_errors('该商品仅限' . $tip . '终端客户购买');
            return $result;
        }
        if (!empty($goods_info->erp_shangplx) && !in_array($goods_info->erp_shangplx, $this->user->jyfw)) {
            $result = $this->show_errors("您的经营范围没有购买" . $goods_info->erp_shangplx . "的权限，如需购买请联系客服人员");
            return $result;
        }
        if ($goods_info->is_mhj == 1 && $this->user->mhj_number == 0) {
            $result = $this->show_errors('不能购买麻黄碱商品');
            return $result;
        }

        if ($id == 25957 && $this->user->mhj_number == 0) {
            $result = $this->show_errors('不能购买麻黄碱商品');
            return $result;
        }

        $cart_goods = Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->get($id);
        if (!empty($cart_goods)) {//已购买同一商品
            $result = $this->show_errors('商品已抢购', 0, 0);
            return $result;
        }
        $goods_arr = [
            '912'=>4088,
            '4088'=>912,
        ];
        $other_goods = Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->get($goods_arr[$id]);
        if (!empty($other_goods)) {//已购买同一商品
            $result = $this->show_errors('两种商品只能选购一种', 0, 0);
            return $result;
        }
        if ($goods_info->cart_number > $goods_info->goods_number) {
            $result = $this->show_errors('库存不足');
            return $result;
        }

        $now_team = $this->team->whereLoose('team', $goods_info->team)->first();
        if ($this->now < $now_team->start) {//活动未开始
            $result = $this->show_errors('活动未开始');
            return $result;
        } elseif ($this->now > $now_team->end) {//活动已经结束
            $result = $this->show_errors('活动已结束');
            return $result;
        }
        $cart                 = collect();
        $cart->user_id        = $this->user->user_id;
        $cart->goods_id       = $goods_info->goods_id;
        $cart->goods_sn       = $goods_info->goods_sn;
        $cart->goods_name     = $goods_info->goods_name;
        $cart->goods_price    = $goods_info->real_price;
        $cart->is_real        = $goods_info->is_real;
        $cart->extension_code = $goods_info->extension_code;
        $cart->is_gift        = 0;
        $cart->goods_attr     = '';
        $cart->is_shipping    = $goods_info->is_shipping;
        $cart->ls_gg          = $goods_info->ls_gg;
        $cart->ls_bz          = $goods_info->ls_bz;
        $cart->extension_code = $this->now;
        $cart->goods_number   = $goods_info->cart_number;
        $cart_goods[]         = $id;
        $ms_goods             = Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->rememberForever('ms_goods', function () {
            return [];
        });
        $ms_goods[]           = $cart;
        $user_ids             = Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags])->rememberForever('user_ids', function () {
            return [];
        });
        if (!in_array($this->user->user_id, $user_ids)) {
            $user_ids[] = $this->user->user_id;
        }
        Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forever('ms_goods', collect($ms_goods));
        Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forever($id, $cart_goods);
        Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->forever('team', $goods_info->team);
        Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags])->forever('user_ids', $user_ids);
        Cache::store('miaosha')->tags(['miaosha', 'goods', $this->tags, 'kc'])->decrement($id, $cart->goods_number);//减少库存
        $result = $this->show_errors('商品成功加入购物车', 0, 0);
        return $result;


    }


    /**
     * 获取商品信息
     */
    private function get_goods_info($id)
    {
        $goods         = $this->goods_arr[$id];
        $goods['id']   = $id;
        $goods['tags'] = $this->tags;
        $goods_info    = $this->get_goods($goods);
        if ($id == 25957) {
            $goods_info->is_mhj = 1;
        }
        return $goods_info;
    }

    public function get_cart_goods($ids = [], $status = true)
    {
        $this->user = auth()->user()->is_zhongduan();
        if ($this->user->is_zhongduan == 0) {
            return [];
        }
        $cart_goods = Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $this->user->user_id])->get('ms_goods');
        $ids_arr    = [];
        if (!empty($ids)) {
            foreach ($ids as $v) {
                if ($v < 0) {
                    $ids_arr[] = $v;
                }
            }
        }
        if (!empty($cart_goods)) {
            $quchong                  = [];
            $goods_arr = [
                '912'=>4088,
                '4088'=>912,
            ];
            $cart_goods->goods_amount = 0;
            foreach ($cart_goods as $k => $v) {
                if (isset($quchong[$v->goods_id])||isset($quchong[$goods_arr[$v->goods_id]])) {
                    unset($cart_goods[$k]);
                } else {
                    $quchong[$v->goods_id] = 1;
                    $v->subtotal           = $v->goods_price * $v->goods_number;
                    $v->rec_id             = 0 - $v->goods_id;
                    $v->is_checked         = 1;
                    $v->goods              = $this->get_goods_info($v->goods_id);
                    if (count($v->goods->area_xg) > 0 && !in_array($this->user->province, $v->goods->area_xg)) {//限购
                        unset($cart_goods[$k]);
                    } elseif (!empty($v->goods->erp_shangplx) && !in_array($v->goods->erp_shangplx, $this->user->jyfw)) {
                        unset($cart_goods[$k]);
                    } elseif ($v->goods->is_mhj == 1 && $this->user->mhj_number == 0) {
                        unset($cart_goods[$k]);
                    } else {
                        $v->is_can_change     = 0;
                        $v->goods->goods_sms  = str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $v->goods->goods_sms);
                        $v->goods->goods_desc = str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $v->goods->goods_desc);

                        $now_team            = $this->team->whereLoose('team', $v->goods->team)->first();
                        $v->goods->goods_url = route('goods.index', ['id' => $v->goods_id]);
                        if (!in_array(0 - $v->goods_id, $ids_arr) && $status == false) {
                            unset($cart_goods[$k]);
                        } elseif ($this->now < $now_team->start) {//活动未开始
                            unset($cart_goods[$k]);
                        } elseif ($this->now > $now_team->end) {//活动已经结束
                            unset($cart_goods[$k]);
                        } else {
                            $cart_goods->goods_amount += $v->subtotal;
                        }
                    }
                }

            }
        }
        return $cart_goods;
    }

    private function get_redis_cart($request)
    {
        if ($this->user->user_id != 13960) {
            dd($this->user->user_id);
        }
        $ids   = Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags])->get('user_ids');
        $cart  = [];
        $users = [
            ['企业名称', '管理员', '商品名称', '货号']
        ];
        if (!empty($ids)) {
            foreach ($ids as $v) {
                $ms_goods = Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $v])->get('ms_goods');
                if (count($ms_goods) > 0 && $request->input('daochu') == 1) {//购物车还存在商品
                    foreach ($ms_goods as $ms) {
                        $user    = User::where('user_id', $ms->user_id)
                            ->select('user_name', 'msn', 'ls_zpgly')->first();
                        $users[] = [
                            $user->msn,
                            $user->ls_zpgly,
                            $ms->goods_name,
                            $ms->goods_sn,
                        ];
                    }
                }
                $cart[] = $ms_goods;
            }
        }
        $kc = [];
        foreach ($cart as $val) {
            if (!empty($val)) {
                foreach ($val as $v) {
                    if (isset($kc[$v->goods_id])) {
                        $kc[$v->goods_id] += $v->goods_number;
                    } else {
                        $kc[$v->goods_id] = $v->goods_number;
                    }
                }
            }
        }
        $team = $request->input('team', 1);
        $gn   = [];
        foreach ($this->goods_arr as $k => $v) {
            $goods_number = OrderGoods::where('tsbz', 'like', '%秒%')->where('goods_id', $k)->where('order_id', '>', 333665)->sum('goods_number');
            //$goods_number = 0;
            $gn[$k] = $goods_number;
        }
        if ($request->input('daochu') == 1) {
            Excel::create('秒杀会员', function ($excel) use ($users) {
                $excel->sheet('users', function ($sheet) use ($users) {
                    $sheet->rows($users);
                });
            })->export('xls');
        }
        return [
            'kc' => $kc,
            'gn' => $gn,
        ];
    }

    public function up_kc(Request $request)
    {
        if (auth()->user()->user_id != 13960) {
            dd($this->user->user_id);
        }
        $id  = $request->input('id');
        $num = $request->input('num');
        Cache::store('miaosha')->tags(['miaosha', 'goods', $this->tags, 'kc'])->forever($id, $num);//设置库存
    }


    public function set_xml()
    {
        $dom = new \DOMDocument();
        $dom->load(public_path('kc.xml'));
        //查找 team 节点
        $root       = $dom->getElementsByTagName('goods_list');
        $root       = $root->item(0);
        $goods_list = $root->getElementsByTagName('goods');
        //遍历所有 goods 节点
        foreach ($goods_list as $goods) {
            //遍历每一个 goods 节点所有属性
            foreach ($goods->attributes as $attrib) {
                $attribName  = $attrib->nodeName;   //nodeName为属性名称
                $attribValue = intval($attrib->nodeValue); //nodeValue为属性内容

                //查找属性名称为kc的节点内容
                if ($attribName == 'id') {
                    $number = Cache::store('miaosha')->tags(['miaosha', 'goods', $this->tags, 'kc'])->get($attribValue);
                    //改变库存
                    $goods->setAttribute('kc', $number);
                    $dom->save(public_path('kc.xml'));
                }
            }
        }
    }


    public function ms_goods(Request $request)
    {
        if ($request->input('type') == 1) {
            $gid = $request->input('id', 5326);
            $uid = $request->input('uid', 13960);

            $cart_goods  = Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $uid])->get('ms_goods');
            $cart_goods1 = Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $uid])->get($gid);
            $ids         = [];
            foreach ($cart_goods as $v) {
                $ids[] = $v->goods_id;
            }
            if (!in_array($gid, $ids)) {
                //dd($gid,$ids,$cart_goods1,$cart_goods);
                Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $uid])->forget($gid);
            }
            dd($cart_goods, $cart_goods1);
        }
        if ($this->user->user_id != 13960) {
            return redirect()->route('index');
        }
        $result = $this->get_redis_cart($request);

        foreach ($this->goods_arr as $k => $v) {
            $v['id']   = $k;
            $v['tags'] = $this->tags;
            $v['new_gwc']  = isset($result['kc'][$k]) ? $result['kc'][$k] : 0;
            $v['ddsl'] = isset($result['gn'][$k]) ? $result['gn'][$k] : 0;
            $this->get_goods($v);
        }
        $arr = [
            'team'       => $this->team,
            'middle_nav' => nav_list('middle'),
            'user'       => $this->user,
            'action'     => '',
            'show_zq'    => 0,
            'page_title' => '秒杀商品管理',
        ];
        return view('miaosha.goods', $arr);
    }

    public function qchc()
    {
        if (auth()->check() && in_array($this->user->user_id, [18810,13960])) {
            Cache::store('miaosha')->flush();
        }
    }

    public function get_ms_tags()
    {
        return $this->tags;
    }

    /**
     * 获取商品库存
     */
    public function get_kc()
    {
        $gn = [];
        foreach ($this->goods_arr as $k => $v) {
            $v['id']   = $k;
            $v['tags'] = $this->tags;
            $this->get_goods($v);
            $gn[] = $k;
        }
        $arr = [];
        $yjs = [];
        foreach ($this->team as $team) {
            if ($this->now > $team->end) {//活动已经结束
                foreach ($team->goods as $goods) {
                    $yjs[] = $goods->goods_id;
                }
            }
        }
        foreach ($gn as $k => $v) {
            $kc = Cache::store('miaosha')->tags(['miaosha', 'goods', $this->tags, 'kc'])->get($v);
            if ($kc < 0) {
                $kc = 0;
            }
            if (in_array($v, $yjs)) {
                $kc = 0;
            }
            $arr[$k]['kc'] = $kc;
            $arr[$k]['id'] = $v;
        }
        return $arr;
    }

    /**
     * 将秒杀商品放入数据库
     */
    public function into_db(Request $request)
    {
//        $this->user = auth()->user()->is_zhongduan();
//        if($this->user->user_id!=13960){
//            return redirect()->route('index');
//        }
        $ids   = Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags])->get('user_ids');
        $cart  = [];
        $users = [
            ['企业名称', '管理员', '商品名称', '货号']
        ];
        if (!empty($ids)) {
            foreach ($ids as $v) {
                $ms_goods = Cache::store('miaosha')->tags(['miaosha', 'cart', $this->tags, $v])->get('ms_goods');
                if (count($ms_goods) > 0) {//购物车还存在商品
                    foreach ($ms_goods as $ms) {
                        $user    = User::where('user_id', $ms->user_id)
                            ->select('user_name', 'msn', 'ls_zpgly')->first();
                        $users[] = [
                            $user->msn,
                            $user->ls_zpgly,
                            $ms->goods_name,
                            $ms->goods_sn,
                        ];
                        $ms_cart = MsCart::where('user_id', $v)->where('goods_id', $ms->goods_id)->first();
                        if (empty($ms_cart)) {
                            $ms_cart          = new MsCart();
                            $ms_cart->user_id = $v;
                        }
                        $ms_cart->goods_id     = $ms->goods_id;
                        $ms_cart->goods_sn     = $ms->goods_sn;
                        $ms_cart->goods_name   = $ms->goods_name;
                        $ms_cart->goods_price  = $ms->goods_price;
                        $ms_cart->goods_number = $ms->goods_number;
                        $ms_cart->save();
                    }
                }
                $cart[] = $ms_goods;
            }
        }

        $gn  = [3497, 1218, 9840, 11088, 8781, 18059, 714, 814, 6127, 1210, 14417, 3076, 18014, 7262, 9838,
            22825, 8780, 18036, 4088, 2150, 912, 5637, 8229, 18010, 17921, 18018, 4098, 19486, 23916, 5326, 21887];
        $arr = [];
        foreach ($gn as $k => $v) {
            $goods_info                = $this->get_goods_info($v);
            $kc                        = Cache::store('miaosha')->tags(['miaosha', 'goods', $this->tags, 'kc'])->get($v);
            $redis_goods               = MsGoods::findOrNew($v);
            $redis_goods->goods_id     = $v;
            $redis_goods->real_price   = $goods_info->real_price;
            $redis_goods->cart_number  = $goods_info->cart_number;
            $redis_goods->area_xg      = $goods_info->area_xg;
            $redis_goods->team         = $goods_info->team;
            $redis_goods->goods_number = $kc;
            $redis_goods->save();
        }

    }


    protected function ms_container()
    {
        $container = new MsContainer;

        $container->bind('ms_team', function ($container, $moduleName) {
            return new MsTeamController($container->make($moduleName));
        });


        $container->bind('ms_goods', function ($container) {
            return new mgoods;
        });


        $a = $container->make('ms_team', ['ms_goods']);
        return $a;
    }

    protected function team_container()
    {
        $container = new MsContainer;

        $container->bind('miaosha', function ($container, $moduleName) {
            return new \App\Http\Controllers\Huodong\Action\MiaoShaController($container->make($moduleName));
        });

        $container->bind('ms_team', function ($container) {
            return new TeamController;
        });


        $a = $container->make('miaosha', ['ms_team']);
        return $a;
    }

    protected function get_goods($v)
    {
        $a = $this->ms_container();
        $b = $a->ms_goods()->goods($v);
        foreach ($this->team as $team) {
            if (count($b) > 0) {
                if ($team->team == $b->team) {
                    $b->xg_tip = '';
                    if (count($b->area_xg) > 0) {//限购
                        $tip = '';
                        foreach ($b->area_xg as $v) {
                            $tip .= '、' . $this->area_xg[$v];
                        }
                        $tip       = ltrim($tip, '、');
                        $b->xg_tip = '仅限' . $tip . '终端客户购买';
                    }
                    $team->goods[] = $b;
                }
            }
        }
        return $b;
    }

    protected function get_team(array $team)
    {
        $a = $this->team_container();
        $b = $a->ms_team()->team($team);
        if ($b->start > $this->now) {
            $b->time = $b->start - $this->now;
        } elseif ($b->end >= $this->now && $b->start <= $this->now) {
            $b->time = $b->end - $this->now;
        } else {
            $b->time = 0;
        }
        $b->goods = collect();
        return $b;
    }

    private function goods_arr()
    {
        $goods_arr = [
            912 => [
                'real_price'   => 7,
                'goods_number' => 10000,
                'cart_number'  => 10,
                'team'         => 1,
                'area_xg'      => []
            ],
            4088 => [
                'real_price'   => 5.85,
                'goods_number' => 12000,
                'cart_number'  => 10,
                'team'         => 1,
                'area_xg'      => []
            ],
        ];

        $this->goods_arr = $goods_arr;
    }

    private function show_errors($msg, $error = 1, $show1 = 1)
    {
        $this->assign['show']  = 1;
        $this->assign['show1'] = $show1;
        $this->assign['error'] = $error;
        $this->assign['text']  = $msg;
        $content               = response()->view('common.tanchuc', $this->assign)->getContent();
        $result['error']       = $error;
        $result['msg']         = $content;
        return $result;
    }
}
