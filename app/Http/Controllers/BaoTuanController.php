<?php

namespace App\Http\Controllers;

use App\Models\baotuan\Groups;
use App\Models\baotuan\GroupUsers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BaoTuanController extends Controller
{
    protected $now;

    protected $user;

    protected $assign;

    public function __construct()
    {
        $this->now    = time();
        $this->user   = auth()->user()->is_zhongduan();
        $this->assign = [
            'user' => $this->user
        ];

    }

    public function getIndex()
    {
        if ($this->user->is_zhongduan == 0) {
            show_msg('只有终端会员可以参与');
        }

        $groups = Groups::with([
            'group_users' => function ($query) {
                $query->select('gid', 'user_id');
            }
        ])
            ->where('enable', 1)
//            ->where('start', '<=', $this->now)
//            ->where('end', '>=', $this->now)
            ->orderBy('sort')->orderBy('gid')
            ->get();
        $is_bt  = 0;
        foreach ($groups as $k => $v) {
            $v->count = count($v->group_users) + $v->base_num;
//            if($v->count>$v->num){//超过限购人数 显示为限购人数
//                $v->count = $v->num;
//            }
            if ($v->count > 0) {
                $v->je = round($v->total / $v->count, 2);
            } else {
                $v->je = intval($v->total);
            }
            $user = $v->group_users->whereLoose('user_id', $this->user->user_id)->first();
            if (!empty($user)) {
                $is_bt = $v->gid;
            }
            if ($v->consume == 2000) {
                $v->img    = get_img_path('images/baotuan05.jpg');
                $v->class  = 'left0';
                $v->class1 = 'left2';
            } elseif ($v->consume == 3000) {
                $v->img    = get_img_path('images/baotuan06.jpg');
                $v->class  = 'left1';
                $v->class1 = 'left3';
            } elseif ($v->consume == 5000) {
                $v->img    = get_img_path('images/baotuan07.jpg');
                $v->class  = 'left0';
                $v->class1 = 'left2';
            } else {
                $v->img    = '';
                $v->class  = 'left0';
                $v->class1 = 'left2';
            }
        }
        if($is_bt==0){
            show_msg('活动已结束');
        }
        $this->assign['is_bt']  = $is_bt;
        $this->assign['groups'] = $groups;
        return view('baotuan.index', $this->assign);
    }

    public function postBt(Request $request)
    {
        $gid  = intval($request->input('gid', 0));
        $info = Groups::find($gid);
        if (count($info) == 0) {
            $msg                   = '活动不存在';
            $this->assign['show']  = 1;
            $this->assign['show1'] = 1;
            $this->assign['error'] = 1;
            $this->assign['text']  = $msg;
            $content               = response()->view('common.tanchuc', $this->assign)->getContent();
            $result['error']       = 1;
            $result['msg']         = $content;
        } else {
            if ($this->now < $info->start) {
                $msg                   = '活动未开始';
                $this->assign['show']  = 1;
                $this->assign['show1'] = 1;
                $this->assign['error'] = 1;
                $this->assign['text']  = $msg;
                $content               = response()->view('common.tanchuc', $this->assign)->getContent();
                $result['error']       = 1;
                $result['msg']         = $content;
            } elseif ($this->now > $info->end) {
                $msg                   = '活动已结束';
                $this->assign['show']  = 1;
                $this->assign['show1'] = 1;
                $this->assign['error'] = 1;
                $this->assign['text']  = $msg;
                $content               = response()->view('common.tanchuc', $this->assign)->getContent();
                $result['error']       = 1;
                $result['msg']         = $content;
            } else {
                $group_user = GroupUsers::where('user_id', $this->user->user_id)->first();
                if (count($group_user) == 0) {
                    $group_user           = new GroupUsers();
                    $group_user->gid      = $gid;
                    $group_user->user_id  = $this->user->user_id;
                    $group_user->add_time = $this->now;
                    $group_user->save();
                    $msg                   = '抱团成功';
                    $result['error']       = 0;
                    $this->assign['error'] = 0;
                } else {
                    $msg                   = '已经参与活动';
                    $result['error']       = 1;
                    $this->assign['error'] = 1;
                }

                $this->assign['show']  = 1;
                $this->assign['show1'] = 1;
                $this->assign['text']  = $msg;
                $content               = response()->view('common.tanchuc', $this->assign)->getContent();

                $result['msg'] = $content;
            }
        }
        return $result;
    }
}
