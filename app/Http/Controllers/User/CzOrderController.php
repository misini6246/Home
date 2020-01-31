<?php

namespace App\Http\Controllers\User;

use App\Common\Payfun;
use App\Http\Controllers\Controller;
use App\Models\CzOrder;
use Illuminate\Http\Request;

class CzOrderController extends Controller
{
    use UserTrait, Payfun;

    public function __construct()
    {
        $this->action = 'cz_order';
        $this->user   = auth()->user()->is_zhongduan();
        $this->now    = time();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = CzOrder::where('user_id', $this->user->user_id)->where('order_status', 1)->Paginate();
        $this->set_assign('result', $result);
        $this->common_value();
        return view($this->view . 'user.cz_order_list', $this->assign);
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
        $info = CzOrder::where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            tips1('订单不存在请咨询客服', ['返回列表' => route('member.cz_order.index')]);
        }
        $this->set_assign('info', $info);
        $this->common_value();
        return view($this->view . 'user.cz_order_info', $this->assign);
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
