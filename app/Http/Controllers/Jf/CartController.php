<?php

namespace App\Http\Controllers\Jf;

use App\Http\Controllers\Controller;
use App\jf\Cart;
use App\jf\Goods;
use App\jf\UserAddress;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use JfTrait;

    public function __construct(Request $request)
    {
        $this->user = auth()->user();
        $this->now  = time();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result  = Cart::with(['goods' => function ($query) {
            $query->where('is_verify', 1)->select('id', 'goods_stock', 'jf');
        }])->where('user_id', $this->user->user_id)
            ->select('goods_id', 'goods_num', 'goods_name', 'jf', 'goods_image', 'id')
            ->get();
        $del_ids = [];
        foreach ($result as $k => $v) {
            if (!$v->goods) {
                $del_ids[] = $v->id;
                unset($result[$k]);
                continue;
            }
            if ($v->goods->goods_stock == 0) {
                $del_ids[] = $v->id;
                unset($result[$k]);
                continue;
            }
            if ($v->goods->goods_stock < $v->goods_num) {
                $v->goods_num = $v->goods->goods_stock;
                Cart::where('id', $v->id)->where('user_id', $this->user->user_id)->update(['goods_num' => $v->goods->goods_stock]);
            } else {
                if ($v->goods->jf != $v->jf) {
                    $v->jf = $v->goods->jf;
                    Cart::where('id', $v->id)->where('user_id', $this->user->user_id)->update(['jf' => $v->goods->jf]);
                }
            }
        }
        if (!empty($del_ids)) {
            Cart::destroy($del_ids);
        }
        $this->set_assign('result', $result);
        $this->common_value();
        return view('jf/cart', $this->assign);
    }

    public function jiesuan(Request $request)
    {
        $ids      = $request->input('ids', []);
        $result   = Cart::with(['goods' => function ($query) {
            $query->where('is_verify', 1)->select('id', 'goods_stock', 'jf');
        }])->where('user_id', $this->user->user_id)->whereIn('id', $ids)
            ->select('goods_id', 'goods_num', 'goods_name', 'jf', 'goods_image', 'id')
            ->get();
        $del_ids  = [];
        $jf_total = 0;
        foreach ($result as $k => $v) {
            if (!$v->goods) {
                $del_ids[] = $v->id;
                unset($result[$k]);
                continue;
            }
            if ($v->goods->goods_stock == 0) {
                $del_ids[] = $v->id;
                unset($result[$k]);
                continue;
            }
            if ($v->goods->goods_stock < $v->goods_num) {
                $v->goods_num = $v->goods->goods_stock;
                Cart::where('id', $v->id)->where('user_id', $this->user->user_id)->update(['goods_num' => $v->goods->goods_stock]);
            } else {
                if ($v->goods->jf != $v->jf) {
                    $v->jf = $v->goods->jf;
                    Cart::where('id', $v->id)->where('user_id', $this->user->user_id)->update(['jf' => $v->goods->jf]);
                }
            }
            $jf_total += $v->jf;
        }
        if ($jf_total > $this->user->pay_points) {
            tips1('积分不足', ['返回购物车' => route('jf.cart.index')]);
        }
        if (count($result) == 0) {
            tips1('请选择要购买的商品', ['返回购物车' => route('jf.cart.index')]);
        }
        if (!empty($del_ids)) {
            Cart::destroy($del_ids);
        }
        $address = UserAddress::where('user_id', $this->user->user_id)->orderBy('is_default', 'desc')->get();
        $this->set_assign('result', $result);
        $this->set_assign('address', $address);
        $this->set_assign('jf_total', $jf_total);
        $this->common_value();
        return view('jf/jiesuan', $this->assign);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id     = intval($request->input('id'));
        $num    = intval($request->input('num', 1));
        $gd_num = intval($request->input('gd_num'));
        if ($gd_num > 0) {
            $num = $gd_num;
        }
        if (in_array($this->user->user_id, [1497, 2404])) {
            return [
                'error' => 1,
                'msg'   => '加入购物车失败'
            ];
        }
        $info = Goods::where('id', $id)->where('is_verify', 1)
            ->select('id', 'goods_stock', 'name', 'jf', 'goods_image')
            ->first();
        if (!$info) {
            return [
                'error' => 1,
                'msg'   => '商品不存在'
            ];
        }
        if ($info->goods_stock < $num) {
            return [
                'error' => 1,
                'msg'   => '库存不足'
            ];
        }
        $cart = Cart::where('goods_id', $id)->where('user_id', $this->user->user_id)
            ->first();
        if ($cart) {//购物车存在该商品
            if ($gd_num > 0) {
                $cart->goods_num = $num;
            } else {
                $cart->goods_num += $num;
            }
            $cart->jf = $info->jf;
            $cart->save();
        } else {
            $cart              = new Cart();
            $cart->user_id     = $this->user->user_id;
            $cart->goods_id    = $info->id;
            $cart->goods_name  = $info->name;
            $cart->goods_num   = $num;
            $cart->jf          = $info->jf;
            $cart->goods_image = $info->goods_image;
            $cart->save();
        }
        return [
            'error' => 0,
            'id'    => $cart->id,
            'msg'   => '加入购物车成功'
        ];
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
        $num  = intval($request->input('num'));
        $info = Cart::with(['goods' => function ($query) {
            $query->where('is_verify', 1)->select('id', 'goods_stock', 'jf');
        }])->where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            return [
                'error' => 1,
                'msg'   => '商品不存在'
            ];
        }
        if (!$info->goods) {
            $info->delete();
            return [
                'error' => 1,
                'msg'   => '商品不存在'
            ];
        }
        if ($info->goods->goods_stock < $num) {
            $num = $info->goods->goods_stock;
        }
        $info->goods_num = $num;
        $info->save();
        return [
            'error' => 0,
            'msg'   => '成功',
            'num'   => $num
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = intval($id);
        if (Cart::where('id', $id)->where('user_id', $this->user->user_id)->delete()) {
            return [
                'error' => 0,
                'msg'   => '删除成功'
            ];
        }
        return [
            'error' => 1,
            'msg'   => '删除失败'
        ];
    }
}
