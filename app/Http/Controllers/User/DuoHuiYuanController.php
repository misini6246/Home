<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MobileCode;
use App\Models\MobileLogin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DuoHuiYuanController extends Controller
{
    use UserTrait;

    public function __construct()
    {
        $this->action = 'qhhy';
        $this->user = auth()->user()->is_zhongduan();
        $this->now = time();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(MobileLogin $mobileLogin)
    {
        $mobile_login = $mobileLogin->where('user_ids', 'like', '%.' . $this->user->user_id . '.%')
            ->where('password', '!=', '')->first();
        if ($mobile_login) {
            $users = User::whereIn('user_id', $mobile_login->user_ids)
                ->select('user_id', 'user_name', 'msn')->get();
            $type = 0;
            foreach ($users as $k => $v) {
                if ($v->user_id == $this->user->user_id) {
                    unset($users[$k]);
                    $type = 1;
                }
            }
            if ($type == 1) {
                $users->prepend($this->user);
            }
        } else {
            $users = [];
        }
        $this->set_assign('result', $users);
        $this->set_assign('mobile_login', $mobile_login);
        $this->common_value();
        return view($this->view . 'user.duohuiyuan', $this->assign);
    }

    public function change_login_user(Request $request)
    {
        $user_id = intval($request->input('user_id'));
        $mobile_login = MobileLogin::where('user_ids', 'like', '%.' . $this->user->user_id . '.%')
            ->where('user_ids', 'like', '%.' . $user_id . '.%')->first();
        if (!$mobile_login) {
            show_msg('该会员不存在');
        }
        Auth::loginUsingId($user_id);
        tips1('切换成功', ['前往首页' => route('index')]);
    }

    public function check_yzm(Request $request)
    {
        $mobile_phone = trim($request->input('mobile_phone'));
        $code = trim($request->input('code'));
        $mobile_code = MobileCode::where('mobile_phone', $mobile_phone)->where('type', 1)
            ->orderBy('add_time', 'desc')->first();
        $life_time = $mobile_code->life_time;
        $start = $mobile_code->add_time;
        $end = $start + $life_time;
        $time = time();
        if ($time > $end) {
            ajax_return('验证码失效,请重新获取', 1);
        }
        if ($mobile_code->code != $code || $code < 1000 || $code > 9999) {
            ajax_return('验证码错误', 1);
        }
        $mobile_login = MobileLogin::where('mobile_phone', $mobile_phone)->first();
        $has = 0;
        if (!$mobile_login) {
            $mobile_login = new  MobileLogin();
            $mobile_login->mobile_phone = $mobile_phone;
            $mobile_login->user_id = $this->user->user_id;
            $mobile_login->user_ids = [$this->user->user_id];
            $mobile_login->password = '';
        } else {
            if (!in_array($this->user->user_id, $mobile_login->user_ids)) {
                $user_ids = $mobile_login->user_ids;
                $user_ids[] = $this->user->user_id;
                $mobile_login->user_ids = $user_ids;
            }
            if (!empty($mobile_login->password)) {
                $has = 1;
            }
        }
        $mobile_login->save();
        ajax_return('验证码正确', 0, ['has' => $has]);
    }

    public function set_pwd(Request $request)
    {
        $mobile_login = MobileLogin::where('user_ids', 'like', '%.' . $this->user->user_id . '.%')->first();
        $password = trim($request->input('password'));
        $confirm_password = trim($request->input('confirm_password'));
        if ($password != $confirm_password) {
            tips1('两次密码输入不一致', ['返回上一页' => route('member.duohuiyuan.index')]);
        }
        if ($mobile_login) {
            $password = Hash::make($password);
            $mobile_login->password = $password;
            $mobile_login->user_id = $this->user->user_id;
            $mobile_login->save();
        }
        tips0('绑定成功', ['返回上一页' => route('member.duohuiyuan.index')]);
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
