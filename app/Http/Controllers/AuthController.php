<?php

namespace App\Http\Controllers;

use App\Models\MobileCode;
use App\Models\MobileLogin;
use App\Models\PasswordReset;
use App\Models\UserLogin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    protected $sms;

    public function __construct(SmsController $smsController)
    {
        $this->middleware('auth', ['only' => ['change_login_user']]);
        $this->sms = $smsController;
    }

    public function login_code(Request $request)
    {
        $mobile = trim($request->input('mobile'));
        $now = time();
        $mobile_login = MobileLogin::with([
            'mobile_code' => function ($query) {
                $query->where('life_time', '>', 0)->where('type', 0)->orderBy('add_time', 'desc');
            }
        ])->where('mobile_phone', $mobile)->first();
        if (!$mobile_login) {
            ajax_return('该手机号未绑定登录', 1);
        }
        if ($now - $mobile_login->mobile_code->add_time < 60) {
            $s = 60 - ($now - $mobile_login->mobile_code->add_time);
            ajax_return('验证码已发送', 2, ['s' => $s]);
        }
        $content = '【今瑜e药网】尊敬的用户：验证码%s用于登录个人账号，工作人员不会索取，请勿泄漏。';
        $this->send_code($mobile, $content, 1);
        ajax_return('验证码已发送');
    }

    public function mobile_login(Request $request)
    {
        $mobile_phone = trim($request->input('mobile_phone'));
        $code = intval($request->input('code'));
        $time = time();
        $mobile_login = MobileLogin::with([
            'mobile_code' => function ($query) {
                $query->where('type', 0)->orderBy('add_time', 'desc');
            }
        ])->where('mobile_phone', $mobile_phone)->first();
        if (!$mobile_login) {
            ajax_return('该手机号未绑定登录', 1);
        }
        if (!$mobile_login->mobile_code) {
            ajax_return('验证码不存在,请重新获取', 0);
        }
        $life_time = $mobile_login->mobile_code->life_time;
        $start = $mobile_login->mobile_code->add_time;
        $end = $start + $life_time;
        if ($time > $end) {
            ajax_return('验证码失效,请重新获取', 2);
        }
        if ($mobile_login->mobile_code->code != $code || $code < 1000 || $code > 9999) {
            ajax_return('验证码错误', 2);
        }
        Auth::loginUsingId($mobile_login->user_id);
        User::where('user_id', $mobile_login->user_id)->update([
            'last_login' => time(),
            'last_ip' => $request->server('HTTP_X_FORWARDED_FOR'),
        ]);
        $cookie = Cookie::get('laravel_session_17');
        $back = $request->session()->pull('login_back' . $cookie, route('index'));
        return [
            'back' => $back,
            'error' => 0,
        ];
    }

    public function change_login_user(Request $request)
    {
        $user_id = intval($request->input('user_id'));
        $user = auth()->user();
        $mobile_login = MobileLogin::where('user_ids', 'like', '%.' . $user->user_id . '.%')
            ->where('user_ids', 'like', '%.' . $user_id . '.%')->first();
        if (!$mobile_login) {
            show_msg('该会员不存在');
        }
        UserLogin::where('user_id', $user->user_id)->where('session_id', $request->session()->getId())->where('is_app', 0)->delete();
        Auth::loginUsingId($user_id);
        $auth = new \App\Http\Controllers\Auth\AuthController();
        $auth->user_login($request);
        $link_str = get_links(route('index'), '前往首页');
        return view("errors.msg", ['msg' => '切换成功', 'link' => route('index'), 'link_str' => $link_str]);
    }

    public function bind_code(Request $request)
    {
        $mobile = trim($request->input('mobile'));
        $now = time();
        $mobile_login = MobileLogin::where('mobile_phone', $mobile)->first();
        if ($mobile_login) {
            $has = 1;
        } else {
            $has = 0;
        }
        $mobile_code = MobileCode::where('mobile_phone', $mobile)->where('life_time', '>', 0)->where('type', 1)
            ->orderBy('add_time', 'desc')->first();
        if ($mobile_code) {
            if ($now - $mobile_code->add_time < 60) {
                $s = 60 - ($now - $mobile_code->add_time);
                ajax_return('验证码已发送', 2, ['s' => $s, 'has' => $has]);
            }
        }
        $content = '【今瑜e药网】尊敬的用户：验证码%s用于绑定手机，请勿泄漏。';
        $this->send_code($mobile, $content, 1);
        ajax_return('验证码已发送', 0, ['has' => $has]);
    }

    public function reg_code(Request $request)
    {
        $mobile = trim($request->input('mobile'));
        $now = time();
        $mobile_login = MobileLogin::where('mobile_phone', $mobile)->first();
        if ($mobile_login) {
            $has = 1;
        } else {
            $has = 0;
        }
        $mobile_code = MobileCode::where('mobile_phone', $mobile)->where('life_time', '>', 0)->where('type', 3)
            ->orderBy('add_time', 'desc')->first();
        if ($mobile_code) {
            if ($now - $mobile_code->add_time < 60) {
                $s = 60 - ($now - $mobile_code->add_time);
                ajax_return('验证码已发送', 2, ['s' => $s, 'has' => $has]);
            }
        }
        $content = '【今瑜e药网】尊敬的用户：验证码%s用于注册账号，请勿泄漏。';
        $this->send_code($mobile, $content, 3);
        ajax_return('验证码已发送', 0, ['has' => $has]);
    }

    public function check_code(Request $request)
    {
        $mobile = trim($request->input('mobile'));
        $code = trim($request->input('code'));
        $mobile_code = MobileCode::where('mobile_phone', $mobile)->where('type', 3)
            ->where('code', $code)
            ->orderBy('add_time', 'desc')->first();
        if (!$mobile_code) {
            ajax_return('请获取验证码', 1);
        }
        $life_time = $mobile_code->life_time;
        $start = $mobile_code->add_time;
        $end = $start + $life_time;
        $time = time();
        if ($time > $end) {
            ajax_return('验证码失效,请重新获取', 1);
        }
        $mobile_login = MobileLogin::where('mobile_phone', $mobile)->first();
        if (!$mobile_login) {
            $mobile_login = new MobileLogin();
            $mobile_login->mobile_phone = $mobile;
            $mobile_login->user_id = 0;
            $mobile_login->user_ids = [];
            $mobile_login->password = '';
            $mobile_login->save();
        }
        ajax_return('验证通过', 0, ['mobile' => $mobile]);
    }

    public function bind_mobile(Request $request)
    {
        $user = auth()->user();
        $mobile = trim($request->input('mobile'));
        $code = trim($request->input('code'));
        $mobile_code = MobileCode::where('mobile_phone', $mobile)->where('type', 1)
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
        $mobile_login = MobileLogin::where('mobile_phone', $mobile)->first();
        if (!$mobile_login) {
            $password = trim($request->input('password'));
            $confirm_password = trim($request->input('confirm_password'));
//            if (empty($password)) {
//                ajax_return('首次绑定手机需输入密码', 2);
//            }
            if ($password != $confirm_password) {
                ajax_return('两次密码输入不一致', 2);
            }
            $password = Hash::make($password);
            $mobile_login = new  MobileLogin();
            $mobile_login->mobile_phone = $mobile;
            $mobile_login->user_id = $user->user_id;
            $mobile_login->user_ids = [$user->user_id];
            $mobile_login->password = $password;
        } else {
            if (!in_array($user->user_id, $mobile_login->user_ids)) {
                $user_ids = $mobile_login->user_ids;
                $user_ids[] = $user->user_id;
                $mobile_login->user_ids = $user_ids;
            }
        }
        $mobile_login->save();
        ajax_return('绑定成功');
    }

    private function send_code($mobile, $content, $type = 0)
    {
        $sjs = $this->sjs();
        $content = sprintf($content, $sjs);
        $response = json_decode($this->sms->sendSms($mobile, $content));
        if ($response->code != 0) {
            ajax_return('发送短信失败', 1);
        }
        $mobile_code = new MobileCode();
        $mobile_code->mobile_phone = $mobile;
        $mobile_code->code = $sjs;
        $mobile_code->type = $type;
        $mobile_code->add_time = time();
        $mobile_code->life_time = 600;
        $mobile_code->save();
    }

    protected function sjs()
    {
        $sjs = random_int(1000, 9999);
        if (substr_count($sjs, '4') >= 3 || strpos($sjs, '444') !== false) {
            $sjs = $this->sjs();
        }
        return $sjs;
    }

    public function reset_code(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('index');
        }
        $mobile_phone = trim($request->input('mobile_phone'));
        $mobile_login = MobileLogin::where('mobile_phone', $mobile_phone)->first();
        if (!$mobile_login) {
            ajax_return('该手机号码未绑定,请联系客服', 1);
        }
        $now = time();
        $mobile_code = MobileCode::where('mobile_phone', $mobile_phone)->where('life_time', '>', 0)->where('type', 2)
            ->orderBy('add_time', 'desc')->first();
        if ($mobile_code) {
            if ($now - $mobile_code->add_time < 60) {
                $s = 60 - ($now - $mobile_code->add_time);
                ajax_return('验证码已发送', 2, ['s' => $s]);
            }
        }
        $content = '【今瑜e药网】尊敬的用户：验证码%s用于修改密码，请勿泄漏。';
        $this->send_code($mobile_phone, $content, 2);
        ajax_return('验证码已发送');
    }

    public function check_reset_code(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('index');
        }
        $mobile_phone = trim($request->input('mobile_phone'));
        $reset_code = intval($request->input('reset_code'));
        $mobile_login = MobileLogin::where('mobile_phone', $mobile_phone)->first();
        if (!$mobile_login) {
            ajax_return('该手机号码未绑定', 1);
        }
        $mobile_code = MobileCode::where('mobile_phone', $mobile_phone)->where('type', 2)
            ->orderBy('add_time', 'desc')->first();
        $life_time = $mobile_code->life_time;
        $start = $mobile_code->add_time;
        $end = $start + $life_time;
        $time = time();
        if ($time > $end) {
            ajax_return('验证码失效,请重新获取', 1);
        }
        if ($mobile_code->code != $reset_code || $reset_code < 1000 || $reset_code > 9999) {
            ajax_return('验证码错误', 1);
        }
        $password_resets = PasswordReset::findOrNew($mobile_phone);
        $password_resets->email = $mobile_phone;
        $password_resets->token = Hash::make($mobile_phone . $reset_code);
        $password_resets->save();
        ajax_return('验证码正确', 0);
    }

    public function reset_pwd(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('index');
        }
        $mobile_phone = trim($request->input('mobile_phone'));
        $code = trim($request->input('code'));
        return view('auth.reset', ['title' => '找回密码', 'mobile_phone' => $mobile_phone, 'code' => $code]);
    }

    public function pwd_reset(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('index');
        }
        $rules = [
            'password.required' => '密码不能为空',
            'password.confirmed' => '两次输入密码不一致',
            'password.min' => '密码长度为6到24位',
            'password.max' => '密码长度为6到24位',
        ];
        $mobile_phone = trim($request->input('mobile_phone'));
        $code = trim($request->input('code'));
        $password = trim($request->input('password'));
        $this->validate($request, [
            'password' => 'required|confirmed|min:6|max:24',
        ], $rules);
        $mobile_login = MobileLogin::where('mobile_phone', $mobile_phone)->first();
        if (!$mobile_login) {
            tips1('该手机号码未绑定', ['前往登录' => '/auth/login']);
        }
        $mobile_code = MobileCode::where('mobile_phone', $mobile_phone)->where('type', 2)
            ->orderBy('add_time', 'desc')->first();
        $life_time = $mobile_code->life_time;
        $start = $mobile_code->add_time;
        $end = $start + $life_time;
        $time = time();
        if ($time > $end) {
            tips1('操作已超时', ['前往登录' => '/auth/login']);
        }
        $pwd_reset = PasswordReset::orderBy('created_at', 'desc')->find($mobile_phone);
        if (Hash::check($mobile_phone . $code, $pwd_reset->token)) {
            $mobile_login->password = Hash::make($password);
            if ($mobile_login->save()) {
                $user = User::whereIn('user_id', $mobile_login->user_ids)->select('user_id', 'ec_salt')->get();
                foreach ($user as $v) {
                    if (!empty($v->ec_salt)) {
                        $user_password = md5(md5($password) . $v->ec_salt);
                    } else {
                        $user_password = md5($password);
                    }
                    User::where('user_id', $v->user_id)->update([
                        'password' => $user_password
                    ]);
                }
            }
        }
        tips0('密码重置完成', ['前往登录' => '/auth/login']);
    }

}
