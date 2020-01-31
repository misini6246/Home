<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class orderCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        Cache::tags('cart_' . $user->user_id)->flush();
        Cache::tags('order_' . $user->user_id)->flush();
        //$orderstr = Cache::tags('orderstr')->get($user->user_id);
        $orderstr = $request->session()->get('orderstr' . $user->user_id);
        if (empty($orderstr)) {
            return view('message')->with(messageSys('没有选中商品', route('cart.index'), [
                [
                    'url' => route('cart.index'),
                    'info' => '返回购物车',
                ],
            ]));
        }
        $orderstr = rtrim($orderstr, '_');
        $orderstr = explode('_', $orderstr);
        $goods = cartGoods($user, $orderstr);
        $user_rank_o = $user->user_rank;
        if ($user_rank_o == 6 || $user_rank_o == 7) $user_rank_o = 1;
        foreach ($goods as $goods_info) {
            if ($goods_info->shop_price <= 0) {
                if ($request->ajax()) {
                    $result['error'] = 1;
                    $result['message'] = $goods_info->goods_name . "价格正在制定中!";
                    return $result;
                } else {
                    return view('message')->with(messageSys($goods_info->goods_name . "价格正在制定中!", route('cart.index'), [
                        [
                            'url' => route('cart.index'),
                            'info' => '返回购物车',
                        ],
                    ]));
                }
            }
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
            //判断该商品是否对会员等级限购
            $ls_ranks = explode(',', $goods_info->ls_ranks);
            if (!empty($goods_info->ls_ranks) && in_array($user->user_rank, $ls_ranks) !== false) {
                if ($request->ajax()) {
                    $result['error'] = 1;
                    $result['message'] = "你没有购买该商品的权限，如须购买请联系客服人员";
                    return $result;
                } else {
                    return view('message')->with(messageSys('你没有购买' . $goods_info->goods_name . '该商品的权限，如须购买请联系客服人员', route('cart.index'), [
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
                        return view('message')->with(messageSys('你没有购买' . $goods_info->goods_name . '该商品的权限，如须购买请联系客服人员', route('cart.index'), [
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
                        return view('message')->with(messageSys('你没有购买' . $goods_info->goods_name . '该商品的权限，如须购买请联系客服人员', route('cart.index'), [
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
                        return view('message')->with(messageSys('你没有购买' . $goods_info->goods_name . '该商品的权限，如须购买请联系客服人员', route('cart.index'), [
                            [
                                'url' => route('cart.index'),
                                'info' => '返回购物车',
                            ],
                        ]));
                    }
                }
            }
            //判断商品库存
            if ($goods_info->goods_number > $goods_info->goods->goods_number) {
                if ($request->ajax()) {
                    $result['error'] = 1;
                    $result['message'] = "库存不足";
                    return $result;
                } else {
                    return view('message')->with(messageSys('库存不足', route('cart.index'), [
                        [
                            'url' => route('cart.index'),
                            'info' => '返回购物车',
                        ],
                    ]));
                }
            }
            if ((!empty($goods_info->yl) && $goods_info->goods_number > $goods_info->yl) && $goods_info->isYl !== false) {
                return view('message')->with(messageSys($goods_info->goods->goods_name . '每人限购' . $goods_info->goods->ls_ggg . '盒', route('cart.index'), [
                    [
                        'url' => route('cart.index'),
                        'info' => '返回购物车',
                    ],
                ]));
            }
        }
        Cache::tags('order_' . $user->user_id)->put('order', $goods, 8 * 60);
        //Cache::tags(['people', 'artists'])->put('John', 1);
        //llPrint($num);
        return $next($request);
    }
}
