<?php

namespace App\Http\Controllers\Xin;

use App\CollectGoods;
use App\Common\NewCommon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CollectController extends Controller
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
    public function store(Request $request, CollectGoods $collectGoods)
    {
        //dd(1);
        $id         = intval($request->input('id'));
        $collection = $collectGoods->where('user_id', $this->user->user_id)->where('goods_id', $id)->first();
        $num        = $collectGoods->where('user_id', $this->user->user_id)->count();//总共收藏的商品数量
        if (!$collection) {//未收藏该商品
            $collection           = new $collectGoods;
            $collection->goods_id = $id;
            $collection->user_id  = $this->user->user_id;
            $collection->add_time = time();
            if ($collection->save()) {
                ajax_return('该商品已经成功地加入了您的收藏夹。', 0, ['num' => $num + 1]);
            }
        } else {
            ajax_return('该商品已经存在于您的收藏夹中。', 1);
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
