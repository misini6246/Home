<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-10-24
 * Time: 13:07
 */

namespace App\Http\Controllers;


use App\Models\CzMoney;
use App\Models\CzMoneyLog;
use App\ZqSy;
use App\ZqYwy;
use Illuminate\Http\Request;

class CzMoneyController extends Controller
{
    public $user;

    public $model;

    public $start;

    public $end;

    public $assign = [];

    public function __construct(CzMoney $model)
    {
        $this->middleware('auth', ['only' => ['index', 'log']]);
        $this->model = $model;
        $this->user  = auth()->user();
        $this->start = strtotime(20171023);
        if ($this->user) {
            $this->user = $this->user->is_zhongduan();
            if (in_array($this->user->user_id, cs_arr())) {
                $this->start = strtotime(20171008);
            }
        }
        $this->end    = strtotime(20171028);
        $this->assign = [
            'page_title' => '用户中心-',
            'user'       => $this->user,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $time = time();
        if ($this->user->is_zhongduan == 0) {
            show_msg('只有终端会员能够参与!');
        }
        if ($time < $this->start) {
            show_msg('活动未开始');
        }
        if ($time >= $this->end) {
            show_msg('活动已结束');
        }
        $this->assign['page_title'] = '充值金额';
        return view('cz_money.index', $this->assign);
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
        if (!$this->user) {
            ajax_return('请登录后在操作!', 2);
        }
        if ($this->user->is_zhongduan == 0) {
            ajax_return('只有终端会员能够参与!', 1);
        }
        ajax_return('活动未开始！', 1);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

    public function log()
    {
        $cz_money = $this->model->find($this->user->user_id);
//        if (!$cz_money) {
//            show_msg('您请求的页面不存在');
//        }
        $result      = CzMoneyLog::where('user_id', $this->user->user_id)
            ->orderBy('log_id', 'desc')->Paginate();
        $sy_zq_type  = ZqSy::where('user_id', $this->user->user_id)->pluck('is_zq');
        $ywy_zq_type = ZqYwy::where('user_id', $this->user->user_id)->pluck('zq_amount');
        if ($ywy_zq_type > 0 || $this->user->zq_amount > 0) {
            $show_zq = 1;
        } else {
            $show_zq = 0;
        }
        $this->assign['page_title'] = '用户中心-';
        $this->assign['show_zq']    = $show_zq;
        $this->assign['sy_zq_type'] = $sy_zq_type;
        $this->assign['full_page']  = 1;
        $this->assign['result']     = $result;
        $this->assign['action']     = 'cz_money';
        $this->assign['cz_money']   = $cz_money;
        return view('cz_money.log', $this->assign);
    }
}