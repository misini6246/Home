<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MessageUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WoDeXiaoXiController extends Controller
{
    use UserTrait;

    public function __construct()
    {
        $this->action = 'znx';
        $this->user   = auth()->user()->is_zhongduan();
        $this->now    = time();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $this->action = 'znx';
        $type         = intval($request->input('type'));
        $query        = DB::table('message_users as mu')->leftJoin('message as m', 'mu.msg_id', '=', 'm.msg_id')
            ->where('mu.user_id', $this->user->user_id)->whereNotNull('m.msg_id')
            ->where('mu.status', '!=', 2);
        switch ($type) {
            case 0:
                $query->where('m.title', 'not like', '您求购的商品%')->where('m.title', 'not like', '您反馈的信息%');
                break;
            case 1:
                $query->where('m.title', 'like', '您求购的商品%');
                break;
            case 2:
                $query->where('m.title', 'like', '您反馈的信息%');
                break;
            default:
                $query->where('m.title', 'not like', '您求购的商品%')->where('m.title', 'not like', '您反馈的信息%');
                break;
        }
        $xttz   = DB::table('message_users as mu')->leftJoin('message as m', 'mu.msg_id', '=', 'm.msg_id')
            ->where('mu.user_id', $this->user->user_id)->whereNotNull('m.msg_id')
            ->where('mu.status', 0)->where('m.title', 'not like', '您求购的商品%')->where('m.title', 'not like', '您反馈的信息%')
            ->count();
        $qgxx   = DB::table('message_users as mu')->leftJoin('message as m', 'mu.msg_id', '=', 'm.msg_id')
            ->where('mu.user_id', $this->user->user_id)->whereNotNull('m.msg_id')
            ->where('mu.status', 0)->where('m.title', 'like', '您求购的商品%')->count();
        $fkxx   = DB::table('message_users as mu')->leftJoin('message as m', 'mu.msg_id', '=', 'm.msg_id')
            ->where('mu.user_id', $this->user->user_id)->whereNotNull('m.msg_id')
            ->where('mu.status', 0)->where('m.title', 'like', '您反馈的信息%')->count();
        $result = $query->orderBy('mu.rec_id', 'desc')->Paginate(10);
        $result->addQuery('type', $type);
        $this->set_assign('result', $result);
        $this->set_assign('xttz', $xttz);
        $this->set_assign('qgxx', $qgxx);
        $this->set_assign('fkxx', $fkxx);
        $this->set_assign('type', $type);
        $this->common_value();
        $box = trim($request->input('box'));
        if ($box == 'xxbox') {
            return response()->view('user.' . $box, $this->assign)->getContent();
        }
        return view($this->view . 'user.wodexiaoxi', $this->assign);
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
//        $xttz      = DB::table('message_users as mu')->leftJoin('message as m', 'mu.msg_id', '=', 'm.msg_id')
//            ->where('mu.user_id', $this->user->user_id)->whereNotNull('m.msg_id')
//            ->where('mu.status', 0)->where('m.title', 'not like', '您求购的商品%')->count();
//        $qgxx      = DB::table('message_users as mu')->leftJoin('message as m', 'mu.msg_id', '=', 'm.msg_id')
//            ->where('mu.user_id', $this->user->user_id)->whereNotNull('m.msg_id')
//            ->where('mu.status', 0)->where('m.title', 'like', '您求购的商品%')->count();
        $info = DB::table('message_users as mu')->leftJoin('message as m', 'mu.msg_id', '=', 'm.msg_id')
            ->where('mu.user_id', $this->user->user_id)->whereNotNull('m.msg_id')
            ->where('mu.status', '!=', 2)->where('mu.msg_id', $id)->first();
        MessageUsers::where('user_id', $this->user->user_id)->where('msg_id', $id)->where('status', 0)->update([
            'status' => 1
        ]);
        $this->set_assign('v', $info);
        $html = response()->view('user.wdxxyd', $this->assign)->getContent();
        Cache::tags($this->user->user_id)->decrement('msg_count');
        ajax_return('', 0, ['html' => $html]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = trim($id, ',');
        $id = explode(',', $id);
        MessageUsers::where('user_id', $this->user->user_id)->whereIn('msg_id', $id)->update([
            'status' => 2
        ]);
        $html = $this->index($request);
        ajax_return('删除成功', 0, ['html' => $html]);
    }
}
