<?php

namespace App\Http\Controllers\Jifen;

use App\AccountLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use JfTrait;

    public function __construct()
    {
        $this->user   = auth()->user();
        $this->action = 'user';
        $this->set_assign('wntj', $this->getTj8());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page       = intval($request->input('page', 1));
        $perPage    = 10;
        $result     = AccountLog::where('user_id', $this->user->user_id)->where('pay_points', '!=', 0)
            ->orderBy('log_id', 'desc')->Paginate($perPage);
        $now_points = $this->user->pay_points;
        if ($page > 1) {
            $query      = DB::table('account_log')->where('user_id', $this->user->user_id)->where('pay_points', '!=', 0)
                ->select('change_time', 'pay_points', 'change_desc')
                ->orderBy('log_id', 'desc')->take(($page - 1) * $perPage)->select('pay_points');
            $total      = DB::table(DB::raw("({$query->toSql()}) as ecs_al"))
                ->mergeBindings($query)->sum('pay_points');
            $now_points -= $total;
        }
        foreach ($result as $v) {
            if ($now_points - 0 < 0.00001) {
                $now_points = 0.00;
            }
            $v->now_points = $now_points;
            $now_points    += $v->pay_points * (-1);
        }
        $use_points = AccountLog::where('user_id', $this->user->user_id)->where('pay_points', '<', 0)->sum('pay_points');
        $this->set_assign('use_points', $use_points);
        $this->set_assign('user_menu', 'index');
        $this->set_assign('result', $result);
        $this->common_value();
        return view('jifen.account', $this->assign);
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
