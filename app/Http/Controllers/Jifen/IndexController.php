<?php

namespace App\Http\Controllers\Jifen;

use App\Http\Controllers\Controller;
use App\jf\News;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    use JfTrait;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->now = time();
        $this->action = 'index';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $focus = $this->getFocus(1);
        $top5 = $this->getTop5();
        $this->set_assign('focus', $focus);
        $this->set_assign('top5', $top5);
        $this->set_assign('cat1', $this->catGoods(1));
        $this->set_assign('cat2', $this->catGoods(2));
        $this->set_assign('cat3', $this->catGoods(3));
        $this->set_assign('cat4', $this->catGoods(4));
        $this->set_assign('cat5', $this->catGoods(5));
        $this->set_assign('cat6', $this->catGoods(6));
        $this->common_value();
		//dd($this->assign);
        return view('jifen.index', $this->assign);
    }

    public function help(Request $request)
    {
        $this->action = '';
        $id = intval($request->input('id', 153));
        $info = News::where('id', $id)->first();
        $result = $this->news();
        $this->set_assign('id', $id);
        $this->set_assign('info', $info);
        $this->set_assign('result', $result);
        $this->set_assign('wntj', $this->getTj8());
        $this->common_value();
        return view('jifen.help', $this->assign);
    }
}
