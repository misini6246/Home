<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Services\GoodsService;

class GoodsController extends Controller
{
    protected $goodsService;

    public function __construct(GoodsService $goodsService)
    {
        $this->goodsService = $goodsService;
    }

    public function index()
    {
        $this->goodsService->getGoodsList();
        return view('goods.index',['result'=>$this->goodsService]);
    }
}
