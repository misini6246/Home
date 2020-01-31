<?php

namespace App\Http\Controllers\Ajax;

use App\Cart;
use App\Goods;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MiaoShaController;
use App\Services\MiaoshaService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

require_once app_path() . '/Common/goods.php';

class CartController extends Controller
{
    protected $miaoshaService;

    public function __construct(MiaoshaService $miaoshaService)
    {
        $this->miaoshaService = $miaoshaService;
    }
    /*
     * 中间件
     */
//    public function __construct(){
//        $this->middleware('user.check', ['only' => 'store']);//添加购物车验证
//        //$this->middleware('cat.check', ['only' => 'store']);//添加购物车验证
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        $result = [
            'error' => 0,
            'message' => 0,
            'confirm_type' => 1,
            'content' => 6,
        ];
        $user = auth()->user()->is_new_user();
        $goods = json_decode($request->input('goods', ''));
        $goods_info = Goods::with('goods_attr', 'goods_attribute', 'member_price')
            ->where('goods_id', $goods->goods_id)->where('is_on_sale', 1)
            ->where('is_delete', 0)->where('is_alone_sale', 1)->first();
        if ($goods_info) {
            $goods_info = Goods::attr($goods_info, $user, 0);
            $goods_info = Goods::area_xg($goods_info, $user);
            if ($goods_info['is_can_buy'] == 0) {
                $msg = '商品限购';
                $result['show'] = 1;
                $result['show1'] = 1;
                $result['error'] = 1;
                $result['text'] = $msg;
                $result['content'] = '';
                $content = response()->view('common.tanchuc', $result)->getContent();
                $result['msg'] = $content;
                return $result;
            }
            if ($goods_info->xg_num == 0 && $goods_info->ls_ggg > 0 && $goods_info->is_xg == 2) {
                //商品有限购 而且商品剩余限购数量为零 而且商品没有在搞特价
                $msg = '该商品限购数量为' . $goods_info->ls_ggg;
                if ($goods_info->goods_id == 22207) {
                    $msg = '你已购买过充值包，每个会员限购' . $goods_info->ls_ggg . '个';
                }
                $result['show'] = 1;
                $result['show1'] = 1;
                $result['error'] = 1;
                $result['text'] = $msg;
                $result['content'] = '';
                $content = response()->view('common.tanchuc', $result)->getContent();
                $result['msg'] = $content;
                return $result;
            }
        } else {
            $result['show'] = 1;
            $result['show1'] = 1;
            $result['error'] = 1;
            $result['text'] = '商品已下架！';
            $result['content'] = '';
            $content = response()->view('common.tanchuc', $result)->getContent();
            $result['msg'] = $content;
            return $result;
        }
        $message = Goods::check_cart($goods_info, $user);
        if ($message['error'] == 1) {
            $msg = $message['message'];
            $result['show'] = 1;
            $result['show1'] = 1;
            $result['error'] = 1;
            $result['text'] = $msg;
            $result['content'] = '';
            $content = response()->view('common.tanchuc', $result)->getContent();
            $result['msg'] = $content;
            return $result;
        }
        /**
         * 只能购买5个新客户特价
         */
//        if($user->is_new_user==true&&$goods_info->is_xkh_tj==1&&$goods_info->is_cx==1){
//            //todo
//            $xkh_goods = DB::table('cart')->leftJoin('goods','cart.goods_id','=','goods.goods_id')
//                ->where('cart.user_id',$user->user_id)->where('goods.is_promote',1)->where('goods.promote_price','>',0)
//                ->where('goods.promote_start_date','<=',time())->where('goods.promote_end_date','>=',time())
//                ->where('goods.is_xkh_tj',1)->where('goods.goods_id','!=',$goods_info->goods_id)->count();
//            if($xkh_goods>=5){
//                $result['error'] = 1;
//                $result['message'] = '新客户特价商品只能购买5个品种';
//                return $result;
//            }
//        }

        $cart = Cart::where('goods_id', $goods->goods_id)->where('user_id', $user->user_id)->first();
        $type = 0;
        if (!$cart) {
            $cart_num = Cache::tags([$user->user_id, 'cart'])->get('num');
            if ($cart_num > 220) {
                $result['show'] = 1;
                $result['show1'] = 1;
                $result['error'] = 1;
                $result['text'] = '为保证提交成功，购物车单次提交品种只能220个，请分开提交，你也可将本次不提交的品种加入收藏夹或删除。';
                $result['content'] = '';
                $content = response()->view('common.tanchuc', $result)->getContent();
                $result['msg'] = $content;
                return $result;
            }


            $cart = new Cart();
            $type = 1;
        }
        $cart->user_id = $user->user_id;
        $cart->goods_id = $goods->goods_id;
        $cart->goods_sn = $goods_info->goods_sn;
        $cart->goods_name = $goods_info->goods_name;
        $cart->goods_price = $goods_info->real_price;
        $cart->is_real = $goods_info->is_real;
        $cart->extension_code = $goods_info->extension_code;
        $cart->is_gift = 0;
        $cart->goods_attr = '';
        $cart->is_shipping = $goods_info->is_shipping;
        $cart->ls_gg = $goods_info->ls_gg;
        $cart->ls_bz = $goods_info->ls_bz;
        $cart->extension_code = time();
        if ($type == 0) {
            $cart->goods_number = $cart->goods_number + $goods->number;
        } else {
            $cart->goods_number = $goods->number;
        }
        if ($cart->goods_number > $goods_info->goods_number) {
            $result['show'] = 1;
            $result['show1'] = 1;
            $result['error'] = 1;
            $result['text'] = '库存不足！';
            $result['content'] = '';
            $content = response()->view('common.tanchuc', $result)->getContent();
            $result['msg'] = $content;
            return $result;
        }
        if ($cart->save()) {
            if ($type == 1) {
                Cache::tags([$user->user_id, 'cart'])->increment('num');
            }
//            Redis::zremrangebyscore('goods_list',$goods->goods_id,$goods->goods_id);
//            Redis::zadd('goods_list',$goods->goods_id,serialize(Goods::goods_info($goods->goods_id)));
            if ($request->ajax()) {
                $result = array();
                $result['error'] = 0;
                $result['confirm_type'] = '1';
                $result['content'] = 6;
                $result['type'] = $type;
                $result['message'] = '商品已成功加入购物车！';
                return $result;
            }
        }
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

    /*
     *商品数量改变
     */
    public function addNum(Request $request)
    {
        $goods_id = $request->input('goods_id');
        $rec_id = $request->input('rec_id');
        $number = $request->input('num');
        $orderstr = $request->input('orderstr');
        $user = Auth::user()->is_new_user();
        $orderstrs = rtrim($orderstr, '_');
        $orderarrs = explode('_', $orderstrs);//购物车商品id集合
        $num = $request->input('change_num', 1);//增加的数量
        $result = array();
        $result['error'] = 0;
        $result['rec_id'] = $rec_id;
        /**
         * 处理预售商品
         */
        $miaosha = new MiaoShaController();
        if ($rec_id < 0) {
            $tags = $miaosha->get_ms_tags();
            $ms_goods = $miaosha->get_cart_goods();
            $goods_info = collect();
            $goods_number = 0;
            $ms_total = 0;
            foreach ($ms_goods as $k => $v) {
                if ($v->goods_id == -$rec_id) {
                    $ys_goods = $miaosha->get_goods_info($v->goods_id);
                    if ($v->is_can_change == 1) {
                        if (in_array($num, [1, -1])) {
                            $v->goods_number += $ys_goods->cart_number * $num;
                        } else {
                            $v->goods_number = ceil($num / $ys_goods->cart_number) * $ys_goods->cart_number;
                        }
                        $xg_number = 0;
                        if ($ys_goods->xg_number > 0) {
                            $xg_number = DB::table('order_goods as og')->leftJoin('order_info as oi', 'oi.order_id', '=', 'og.order_id')
                                ->where('oi.order_status', 1)->where('og.goods_id', $v->goods_id)
                                ->where('og.tsbz', '预')->where('oi.user_id', $user->user_id)
                                ->sum('og.goods_number');
                            if ($ys_goods->xg_number < $v->goods_number + $xg_number) {
                                $v->goods_number = $ys_goods->xg_number - $xg_number;
                            }
                        }
                        if ($num == 1 || $num == -1) {
                            $final_num = final_num($ys_goods->xg_number - $xg_number, $ys_goods->jzl, $ys_goods->cart_number, $ys_goods->goods_number, $number, $num);
                        } else {
                            $final_num = final_num($ys_goods->xg_number - $xg_number, $ys_goods->jzl, $ys_goods->cart_number, $ys_goods->goods_number, $num);
                        }
                        $v->goods_number = $final_num['goods_number'];
                    }
                    $goods_info = $v;
                    $goods_number = $v->goods_number;
                    $result['child'] = response()->view('layout.zp_goods', ['v' => $goods_info])->getContent();
                }
                $ms_total += $v->goods_number * $v->goods_price;
            }
            Cache::store('miaosha')->tags(['miaosha', 'cart', $tags, $user->user_id])->forever('ms_goods', $ms_goods);
            $total = Cart::where('user_id', $user->user_id)->where('goods_id', '!=', 0)->where(function ($where) use ($orderarrs) {
                $where->whereIn('rec_id', $orderarrs)->orwhereIn('parent_id', $orderarrs);
            })->sum(DB::raw('goods_price*goods_number'));
            $jp_total = DB::table('cart as c')->leftjoin('goods as g', 'c.goods_id', '=', 'g.goods_id')->whereIn('rec_id', $orderarrs)
                ->where('c.goods_id', '!=', 0)->where('c.user_id', $user->user_id)->where('g.show_area', 'like', "%2%")
                ->sum(DB::raw('' . env('PREFIX') . 'c.goods_price*' . env('PREFIX') . 'c.goods_number'));
            //Cache::tags('cart_'.$user->user_id)->forever($rec_id,$goods_info);
            //print_r($goods_info);die;
            $result['num'] = $goods_number;
            $result['jp_total_amount'] = $jp_total;
            $result['total'] = $total + $ms_total;
            $result['subtotal'] = formated_price($goods_info->goods_price * $goods_number);
            $result['jp_total_amount'] = formated_price($result['jp_total_amount']);
            $result['total'] = formated_price($result['total']);
            return $result;
        }

        //$goods_info = cartGoods($user,[$rec_id],true);
        Cart::where('user_id', $user->user_id)->where('parent_id', $rec_id)->delete();
        $goods_info = Cart::get_cart_goods($user, array($rec_id), 1);

        if(!isset($goods_info->goods->zbz)||$goods_info->goods->zbz==0){
            $zbz=1;
        }else $zbz=$goods_info->goods->zbz; //中包装

        // $zbz = isset($goods_info->goods->zbz) ? $goods_info->goods->zbz : 1;
        $jzl = isset($goods_info->goods->jzl) ? intval($goods_info->goods->jzl) : 0;//件装量

        if ($num == 1 || $num == -1) {
            $final_num = final_num($goods_info->goods->xg_num, $jzl, $zbz, $goods_info->goods->goods_number, $number, $num);
            $goods_number = $final_num['goods_number'];
            if (!empty($final_num['message'])) {
                $result['message'] = $final_num['message'];
            }
        } else {
            $final_num = final_num($goods_info->goods->xg_num, $jzl, $zbz, $goods_info->goods->goods_number, $num);
            $goods_number = $final_num['goods_number'];
        }
        
        //$goods_number = Cart::cyn_num($goods_info->goods, $user, $goods_number);
        $total = 0;
        //$price  = Cart::diff_price($goods_info, $goods_number, $goods_info->goods->real_price, $user);
        $up_arr = ['goods_number' => $goods_number];
//        if ($price != $goods_info->goods_price) {
//            $up_arr['goods_price'] = $price;
//            $goods_info->goods_price = $price;
//        }
        if (Cart::where('rec_id', $rec_id)->where('user_id', $user->user_id)->update($up_arr)) {
            $goods_info->goods_number = $goods_number;
            if (count($goods_info->goods->zp_goods) > 0) {
                $check_type = -1;
                $ids = Cart::where('user_id', $user->user_id)->lists('goods_id')->toArray();
                $goods_info = Cart::check_zp_goods($user, $goods_info, $check_type, $ids);
            }
            $result['child'] = response()->view('layout.zp_goods', ['v' => $goods_info])->getContent();
            //$cacheTotal = Cache::tags('cart_'.$user->user_id)->get('total');
            $total = Cart::where('user_id', $user->user_id)->where('goods_id', '!=', 0)->where(function ($where) use ($orderarrs) {
                $where->whereIn('rec_id', $orderarrs)->orwhereIn('parent_id', $orderarrs);
            })->sum(DB::raw('goods_price*goods_number'));
            $jp_total = DB::table('cart as c')->leftjoin('goods as g', 'c.goods_id', '=', 'g.goods_id')->whereIn('rec_id', $orderarrs)
                ->where('c.goods_id', '!=', 0)->where('c.user_id', $user->user_id)->where('g.show_area', 'like', "%2%")
                ->sum(DB::raw('' . env('PREFIX') . 'c.goods_price*' . env('PREFIX') . 'c.goods_number'));
            //Cache::tags('cart_'.$user->user_id)->forever($rec_id,$goods_info);
            //print_r($goods_info);die;
            $result['num'] = $goods_number;
            $result['jp_total_amount'] = $jp_total;
            $result['total'] = $total;
            $result['subtotal'] = formated_price($goods_info->goods_price * $goods_number);
            $result['jp_total_amount'] = formated_price($result['jp_total_amount']);
            $result['total'] = formated_price($result['total']);
        } else {
            $result['num'] = $goods_number;
            $result['error'] = 1;
        }
        $ms_goods = $miaosha->get_cart_goods($orderarrs, false);
        if (!empty($ms_goods)) {
            $result['total'] = formated_price($total + $ms_goods->goods_amount);
        }

        $msAmount = $this->miaoshaService->getCacheCartGoodsAmount($orderarrs);
        $result['total'] = formated_price($total + $msAmount);

        return $result;
    }

    /*
         *商品选择
         */
    public function goodsChoose(Request $request)
    {
        $orderstr = $request->input('orderstr');
        if (empty($orderstr)) {
            $result['error'] = 0;
            $result['jp_total_amount'] = formated_price(0);;
            $result['total'] = formated_price(0);
            return $result;
        }
        $user = Auth::user();
        $orderstrs = rtrim($orderstr, '_');
        $orderarrs = explode('_', $orderstrs);//购物车商品id集合
        Cache::tags([$user->user_id, 'cart'])->put('cart_list', $orderarrs, 8 * 60);

        //return $orderarrs;
        $total = Cart::where('user_id', $user->user_id)->where('goods_id', '!=', 0)->where(function ($where) use ($orderarrs) {
            $where->whereIn('rec_id', $orderarrs)->orwhereIn('parent_id', $orderarrs);
        })->sum(DB::raw('goods_price*goods_number'));
        $jp_total = DB::table('cart as c')->leftjoin('goods as g', 'c.goods_id', '=', 'g.goods_id')
            ->where('c.goods_id', '!=', 0)->where('c.user_id', $user->user_id)->where('g.show_area', 'like', "%2%")->whereIn('c.rec_id', $orderarrs)
            ->sum(DB::raw('' . env('PREFIX') . 'c.goods_price*' . env('PREFIX') . 'c.goods_number'));
        $miaosha = new MiaoShaController();
        $ms_goods = $miaosha->get_cart_goods($orderarrs, false);
        if (!empty($ms_goods)) {
            $total = $total + $ms_goods->goods_amount;
        }

        $msAmount = $this->miaoshaService->getCacheCartGoodsAmount($orderarrs);
        $total = $total + $msAmount;

        $result['error'] = 0;
        $result['jp_total_amount'] = 0;
        $result['total'] = 0;
        $result['jp_total_amount'] = formated_price($jp_total);
        $result['total'] = formated_price($total);
        return $result;
    }

    /*
     * 搜索框
     */
    public function searchKey(Request $request)
    {
        $key = $request->input('keyword');
        $goods = Goods::where(function ($query) use ($key) {
            $query->where('goods_name', 'like', "%$key%")->orwhere('ZJMID', 'like', "%$key%")
                ->orwhere('ZJMID1', 'like', "%$key%")->orwhere('goods_name1', 'like', "%$key%");
        })->where('is_on_sale', 1)->where('is_alone_sale', 1)->where('is_delete', 0)->select('goods_name')
            ->take(10)
            ->groupBy('goods_name')
            ->get();
        $result = array();
        foreach ($goods as $k=>$v) {
            $result[$k] = [
                'id'=>$k,
                'value'=>$v->goods_name
            ];
        }
        return json_encode($result);
    }

    /*
     * 商品判断
     */
    private function goodsCheck($goods, $request)
    {
        //$goods = $request->input('goods','');
        $goods = json_decode($goods);
        $goods_info = Goods::goods_info($goods->goods_id);
        if ($goods_info->shop_price <= 0) {
            if ($request->ajax()) {
                $result['error'] = 1;
                $result['message'] = "价格正在制定中!";
                return $result;
            } else {
                return view('message')->with(messageSys('价格正在制定中!', route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => '返回购物车',
                    ],
                ]));
            }
        }
        $user = Auth::user();
        $user_rank_o = $user->user_rank;
        if ($user_rank_o == 6 || $user_rank_o == 7) $user_rank_o = 1;
        if (strpos($goods_info->show_area, '4') !== false && $user->ls_mzy == 1) {
            if ($request->ajax()) {
                $result['error'] = 1;
                $result['message'] = "你没有购买中药饮片的权限，如须购买请联系客服人员";
                return $result;
            } else {
                return view('message')->with(messageSys('你没有购买中药饮片的权限，如须购买请联系客服人员', route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => '返回购物车',
                    ],
                ]));
            }
        }
        if (strpos($goods_info->cat_ids, '180') !== false && $user->mhj_number == 0) {
            if ($request->ajax()) {
                $result['error'] = 1;
                $result['message'] = "你没有购买麻黄碱的权限，如须购买请联系客服人员";
                return $result;
            } else {
                return view('message')->with(messageSys('你没有购买麻黄碱的权限，如须购买请联系客服人员', route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => '返回购物车',
                    ],
                ]));
            }
        }


        // 2015-5-12 诊所不能购买食品
        if (strpos($goods_info->cat_ids, '398') !== false && $user_rank_o == 5) {
            if ($request->ajax()) {
                $result['error'] = 1;
                $result['message'] = "你没有购买食品的权限，如须购买请联系客服人员";
                return $result;
            } else {
                return view('message')->with(messageSys('你没有购买食品的权限，如须购买请联系客服人员', route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => '返回购物车',
                    ],
                ]));
            }
        }
        //判断限购
        if (strpos($goods_info->ls_buy_user_id, '.' . $user->user_id . '.') === false) {

            //判断该商品是否对会员等级限购
            $ls_ranks = explode(',', $goods_info->ls_ranks);
            if (!empty($goods_info->ls_ranks) && in_array($user->user_rank, $ls_ranks) !== false) {
                if ($request->ajax()) {
                    $result['error'] = 1;
                    $result['message'] = "你没有购买该商品的权限，如须购买请联系客服人员";
                    return $result;
                } else {
                    return view('message')->with(messageSys('你没有购买该商品的权限，如须购买请联系客服人员', route('cart.index'), [
                        [
                            'url' => route('cart.index'),
                            'info' => '返回购物车',
                        ],
                    ]));
                }
            }
            //判断该商品是否对地区限购
            if (!empty($goods_info->ls_regions)) {
                $ls_country = strpos($goods_info->ls_regions, '.' . $user->country . '.');
                $ls_province = strpos($goods_info->ls_regions, '.' . $user->province . '.');
                $ls_city = strpos($goods_info->ls_regions, '.' . $user->city . '.');
                $ls_district = strpos($goods_info->ls_regions, '.' . $user->district . '.');
                if ($ls_country !== false || $ls_province !== false || $ls_city !== false || $ls_district !== false) {
                    if ($request->ajax()) {
                        $result['error'] = 1;
                        $result['message'] = "你没有购买该商品的权限，如须购买请联系客服人员";
                        return $result;
                    } else {
                        return view('message')->with(messageSys('你没有购买该商品的权限，如须购买请联系客服人员', route('cart.index'), [
                            [
                                'url' => route('cart.index'),
                                'info' => '返回购物车',
                            ],
                        ]));
                    }
                }
            }
            //判断商品是否对医药公司限购
            if ((!empty($goods_info->yy_regions) || !empty($goods_info->yy_user_ids)) && $user_rank_o == 1) {
                $ls_country = strpos($goods_info->yy_regions, '.' . $user->country . '.');
                $ls_province = strpos($goods_info->yy_regions, '.' . $user->province . '.');
                $ls_city = strpos($goods_info->yy_regions, '.' . $user->city . '.');
                $ls_district = strpos($goods_info->yy_regions, '.' . $user->district . '.');
                $ls_user = strpos($goods_info->yy_user_ids, '.' . $user->user_id . '.');
                if ($ls_country !== false || $ls_province !== false || $ls_city !== false || $ls_district !== false || $ls_user !== false) {
                    if ($request->ajax()) {
                        $result['error'] = 1;
                        $result['message'] = "你没有购买该商品的权限，如须购买请联系客服人员";
                        return $result;
                    } else {
                        return view('message')->with(messageSys('你没有购买该商品的权限，如须购买请联系客服人员', route('cart.index'), [
                            [
                                'url' => route('cart.index'),
                                'info' => '返回购物车',
                            ],
                        ]));
                    }
                }
            }
            //判断商品是否对终端限购
            if ((!empty($goods_info->zs_regions) || !empty($goods_info->zs_user_ids)) && $user_rank_o != 1) {
                $ls_country = strpos($goods_info->zs_regions, '.' . $user->country . '.');
                $ls_province = strpos($goods_info->zs_regions, '.' . $user->province . '.');
                $ls_city = strpos($goods_info->zs_regions, '.' . $user->city . '.');
                $ls_district = strpos($goods_info->zs_regions, '.' . $user->district . '.');
                $ls_user = strpos($goods_info->zs_user_ids, '.' . $user->user_id . '.');
                if ($ls_country !== false || $ls_province !== false || $ls_city !== false || $ls_district !== false || $ls_user !== false) {
                    if ($request->ajax()) {
                        $result['error'] = 1;
                        $result['message'] = "你没有购买该商品的权限，如须购买请联系客服人员";
                        return $result;
                    } else {
                        return view('message')->with(messageSys('你没有购买该商品的权限，如须购买请联系客服人员', route('cart.index'), [
                            [
                                'url' => route('cart.index'),
                                'info' => '返回购物车',
                            ],
                        ]));
                    }
                }
            }
//        //判断商品库存
//        $zbz = $goods_info->goods_attr->where('attr_id',211)->first();
//        $num = $this->goodsNum($goods_info->ls_gg,$zbz);
//        if($num>$goods_info->goods_number){
//            if ($request->ajax()) {
//                $result['error'] = 1;
//                $result['message'] = "库存不足";
//                return $result;
//            } else {
//                return view('message')->with(messageSys('库存不足', route('cart.index'), [
//                    [
//                        'url' => route('cart.index'),
//                        'info' => '返回购物车',
//                    ],
//                ]));
//            }
//        }
//        $goods_info->goods_number = $num;
            //Cache::tags([$user->user_id,'cart'])->put($goods->goods_id,$goods_info,1);
            //Cache::tags(['people', 'artists'])->put('John', 1);
            //llPrint($num);
        }
        return $goods_info;
    }


    public function relations($request)
    {
        $arr = [23838, 23781];
        $goods = json_decode($request->input('goods', ''));
        if (in_array($goods->goods_id, $arr)) {
            foreach ($arr as $v) {
                if ($v != $goods->goods_id) {
                    $goods->goods_id = $v;
                    $goods = response()->json($goods)->getContent();
                    $request->offsetSet('goods', $goods);
                    $request->offsetSet('action', 'relations');
                    $goods = json_decode($request->input('goods', ''));
                    $this->store($request);
                }
            }
        }
    }

    public function relations1($request)
    {
        $arr = [23838, 23781];
        $goods_id = intval($request->input('goods_id'));
        $user = auth()->user();
        if (in_array($goods_id, $arr)) {
            foreach ($arr as $v) {
                if ($v != $goods_id) {
                    $rec_id = Cart::where('user_id', $user->user_id)->where('goods_id', $v)->pluck('rec_id');
                    if ($rec_id) {
                        $request->offsetSet('rec_id', $rec_id);
                        $request->offsetSet('action', 'relations');
                        return $this->addNum($request);
                    }
                }
            }
        }
    }
}
