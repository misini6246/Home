<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MobileLogin;
use App\Models\UserLogin;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $redirectPath = '/user/regMsg';
    protected $loginPath = '/auth/login';
    protected $username = 'user_name';

    public function getLogin(Request $request)
    {
        $cookie = Cookie::get('laravel_session_17');
        $back_url = $request->session()->get('login_back' . $cookie, $request->server('HTTP_REFERER'));
        if (!empty($back_url) && strpos($back_url, 'pwd') === false) {
            $request->session()->put('login_back' . $cookie, $back_url);
        }
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }
        return view('auth.login')->withTitle('会员登录');
    }

    public function getRegister()
    {
        if (auth()->check()) {
            return redirect()->route('index');
        }
        $page_title = '验证手机号-注册-';
        return view('auth.register1', compact('page_title'));
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);
        $user = User::where('user_name', $credentials['user_name'])->select('user_id', 'user_name', 'password', 'ec_salt')->first();
        if ($user) {
            if (!empty($user->ec_salt)) {
                $password = md5(md5($credentials['password']) . $user->ec_salt);
            } else {
                $password = md5($credentials['password']);
            }
            if ($password == $user->password) {
                Auth::loginUsingId($user->user_id);
                $this->user_login($request);
                $cookie = Cookie::get('laravel_session_17');
                return [
                    'error' => 0,
                    'back' => $request->session()->get('login_back' . $cookie, route('index'))
                ];
            }
        }

        $mobile_login = MobileLogin::where('mobile_phone', $credentials['user_name'])->first();
        if ($mobile_login) {
            if (!empty($mobile_login['password']) && Hash::check($credentials['password'], $mobile_login['password'])) {
                Auth::loginUsingId($mobile_login->user_id);
                $this->user_login($request);
                $cookie = Cookie::get('laravel_session_17');
                return [
                    'error' => 0,
                    'back' => $request->session()->get('login_back' . $cookie, route('index'))
                ];
            }
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        if ($request->ajax()) {
            return [
                'error' => 1,
                'message' => $this->getFailedLoginMessage(),
            ];
        }
        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //print_r(Auth::user());die;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'required' => '不能为空',
            // 'email.unique'=>'该邮箱已注册',
            'user_name.unique' => '该用户名已注册',
//            'msn.unique'=>'企业名称已存在',
//            'mobile_phone.unique'=>'该电话已注册',
//            'qq.unique'=>'该qq已注册',
        ];
        return Validator::make($data, [
            'user_name' => 'required|max:255|unique:users',
            //'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6|max:24',
//            'msn' => 'required|msn|max:255|unique:users',
//            'qq' => 'required|msn|max:255|unique:users',
//            'mobile_phone' => 'required|msn|max:255|unique:users',
//            'ls_name' => 'required|string',
//            'msn' => 'required|accepted|1',
            'msn' => 'required|min:2|unique:users',
            'province' => 'required|exists:region,region_id',
            'city' => 'required|exists:region,region_id',
            'district' => 'required|exists:region,region_id',
        ], $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $salt = rand(1000, 9999);
        return User::create([
            'user_name' => $data['user_name'],
            'email' => isset($data['email']) ? $data['email'] : '',
            'password' => md5(md5($data['password']) . $salt),
            'ec_salt' => $salt,
            'user_rank' => $data['ls_lx'],
            'ls_name' => $data['ls_name'],
            'msn' => $data['msn'],
            'qq' => isset($data['qq']) ? $data['qq'] : '',
            'mobile_phone' => $data['mobile_phone'],
            'country' => 1,
            'province' => $data['province'],
            'city' => $data['city'],
            'district' => $data['district'],
            'reg_time' => time(),
            'last_login' => time(),
            'last_ip' => $_SERVER["REMOTE_ADDR"],
            'visit_count' => 1,
            'update_time' => time(),
        ]);
    }

    public function getLogout(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            Cache::tags($user->user_id)->forget('xkh_ids');
            Cache::tags(['miaosha', '20160824', 'users'])->forget($user->user_id);
            Cache::tags(['miaosha', '20160824', 'ywy_zq'])->forget($user->user_id);
            UserLogin::where('user_id', $user->user_id)->where('session_id', $request->session()->getId())->where('is_app', 0)->delete();
        }
        Auth::logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }


    public function user_login($request)
    {
        $user = auth()->user();
        $session_id = $request->session()->getId();
        $user_login = UserLogin::where('user_id', $user->user_id)->where('session_id', $session_id)->where('is_app', 0)->first();
        if (!$user_login) {
            $user_login = new UserLogin();
            $user_login->user_id = $user->user_id;
            $user_login->session_id = $session_id;
        }
        $user_login->change_time = time();
        $user_login->save();
    }
}
