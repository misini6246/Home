<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CollectGoods;
use Illuminate\Support\Facades\Auth;

class CommonController extends Controller
{
    /*
     * 添加到收藏
     */
    public function addToCollect(Request $request){
        $user = Auth::user();
        if($user) {
            $id = $request->input('id');
            $collection = CollectGoods::where('user_id', $user->user_id)->where('goods_id', $id)->first();
            $num = CollectGoods::where('user_id', $user->user_id)->count();//总共收藏的商品数量
            if (!$collection) {//未收藏该商品
                $collection = new CollectGoods();
                $collection->goods_id = $id;
                $collection->user_id = $user->user_id;
                $collection->add_time = time();
                if ($collection->save()) {
                    $result = [
                        'error' => 0,
                        'message' => '该商品已经成功地加入了您的收藏夹。',
                        'num' => $num + 1
                    ];
                    return $result;
                }
            } else {
                $result = [
                    'error' => 1,
                    'message' => '该商品已经存在于您的收藏夹中。',
                    'num' => $num
                ];
                return $result;
            }
        }else{
            $result = [
                'error' => 2,
                'message' => '由于您还没有登录，因此您还不能使用该功能。。',
                'num' => 0
            ];
            return $result;
        }
    }
}
