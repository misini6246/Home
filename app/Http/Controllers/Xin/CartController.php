<?php

namespace App\Http\Controllers\Xin;

use App\Cart;
use App\Common\NewCommon;
use App\Goods;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{

    use NewCommon;

    public $user;

    public function __construct()
    {
        $this->check_auth();
        $this->user = auth()->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, Goods $goods)
    {
        $this->user = $this->user->is_new_user();
        $id = intval($request->input('id', 0));
        $product_id = intval($request->input('product_id', 0));
//        $goods_number = intval($request->input('num', 1));
        $goods_number = $request->input('num', 1);
        $goods_info = $goods->where('is_delete', 0)->where('is_alone_sale', 1)->find($id);
        if ($goods_info) {
            $goods_info = $goods->attr($goods_info, $this->user, 1, $product_id);
            if (!$goods_info) {
                ajax_return('商品已下架', 1);
            }
            $goods_info = Goods::area_xg($goods_info, $this->user);
            if ($goods_info['is_can_buy'] == 0) {
                ajax_return('商品限购', 1);
            }
            if ($goods_info->is_on_sale == 0) {
                ajax_return('商品已下架', 1);
            }
        } else {
            ajax_return('商品已下架', 1);
        }
        $message = $goods->check_cart($goods_info, $this->user);
        if ($message['error'] == 1) {
            ajax_return($message['message'], 1);
        }

        $cart = Cart::where('goods_id', $id)->where('product_id', $product_id)->where('user_id', $this->user->user_id)->first();
        $type = 0;
        if (!$cart) {
            $cart_num = Cache::tags([$this->user->user_id, 'cart'])->get('num');
            if ($cart_num > 220) {
                ajax_return('为保证提交成功，购物车单次提交品种只能220个，请分开提交，你也可将本次不提交的品种加入收藏夹或删除。', 1);
            }
            $cart = new Cart();
            $type = 1;
        }
        $cart->user_id = $this->user->user_id;
        $cart->goods_id = $goods_info->goods_id;
        $cart->goods_sn = $goods_info->goods_sn;
        $cart->goods_name = $goods_info->goods_name;
        $cart->goods_price = $goods_info->real_price;
        $cart->is_real = $goods_info->is_real;
        $cart->product_id = $goods_info->product_id;
        $cart->is_gift = 0;
        $cart->goods_attr = '';
        $cart->is_shipping = $goods_info->is_shipping;
        $cart->ls_gg = $goods_info->ls_gg;
        $cart->ls_bz = $goods_info->ls_bz;
        $cart->extension_code = time();
        $num = cart_info();
        if ($type == 0) {
            $cart->goods_number = $cart->goods_number + $goods_number;
			
        } else {
            $num = $num + 1;
            $cart->goods_number = $goods_number;
        }
        if ($cart->goods_number > $goods_info->goods_number) {
            ajax_return('库存不足', 1);
        }
		
        if ($cart->save()) {
            if ($type == 1) {
                Cache::tags([$this->user->user_id, 'cart'])->increment('num');
            }
            ajax_return('商品已成功加入购物车！', 0, ['num' => $num, 'type' => $type]);
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
}
