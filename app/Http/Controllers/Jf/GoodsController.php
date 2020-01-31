<?php

namespace App\Http\Controllers\Jf;

use App\Http\Controllers\Controller;
use App\jf\Goods;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    use JfTrait;

    public function __construct()
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
        $id   = intval($id);
        $info = Goods::with('goodsImg')->where('id', $id)->where('is_verify', 1)
            ->select('id', 'goods_stock', 'name', 'jf', 'goods_image', 'market_price')
            ->first();
        if (!$info) {
            return redirect()->to('jf');
        }
        $this->set_assign('info', $info);
        $this->set_assign('top5', $this->getTop5());
        $this->common_value();
        return view('jf.goods', $this->assign);
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
