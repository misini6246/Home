<?php

namespace App\Http\Controllers\Xin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPostRequest;
use App\Models\MobileCode;
use App\Models\MobileLogin;
use App\Region;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth', ['only' => 'step3']);
    }

    public function old()
    {
        if (auth()->check()) {
            return redirect()->route('index');
        }
        $page_title = '注册-';
        $title = '注册';
        return view('auth.register', compact('page_title', 'title'));
    }

    public function step1()
    {
        if (auth()->check()) {
            return redirect()->route('index');
        }
        $page_title = '验证手机号-注册-';
        return view('auth.register1', compact('page_title'));
    }

    public function step2(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('index');
        }
        $mobile = $request->input('phone');
        $mobile_login = MobileLogin::where('mobile_phone', $mobile)->first();
        if ($mobile_login) {
            $user_ids = $mobile_login->user_ids;
            $users = User::whereIn('user_id', $user_ids)->select('user_id', 'user_name', 'msn')->get();
        }
        $province = Region::with([
            'child' => function ($query) {
                $query->with([
                    'child' => function ($query) {
                        $query->select('region_id', 'region_name', 'parent_id');
                    }
                ])->select('region_id', 'region_name', 'parent_id');
            }
        ])->where('region_type', 1)->where('parent_id', 1)->select('region_id', 'region_name')
            ->orderBy('agency_id', 'desc')->get();
        $page_title = '填写账户信息-注册-';
        return view('auth.register2', compact('mobile', 'users', 'province', 'page_title'));
    }

    public function step3()
    {
        $user = auth()->user();
        $page_title = '注册成功-注册-';
        return view('auth.register3', compact('user', 'page_title'));
    }

    public function store(RegisterPostRequest $request)
    {
        if ($request->ajax()) {
            return [
                'error' => 0,
            ];
        }
        $salt = rand(1000, 9999);
        $md5_pwd = md5(md5($request->password) . $salt);
        $user = new User();
        $user->user_rank = $request->user_rank;
        $user->user_name = $request->user_name;
        $user->password = $md5_pwd;
        $user->ec_salt = $salt;
        $user->ls_name = $request->ls_name;
        $user->msn = $request->msn;
        $user->country = 1;
        $user->province = $request->province;
        $user->city = $request->city;
        $user->district = $request->district;
        $user->reg_time = time();
        $user->last_login = time();
        $user->update_time = time();
        $user->last_ip = $request->server('REMOTE_ADDR');
        $user->visit_count = 1;
        $user->email = '';
        $user->qq = '';
        $user->mobile_phone = $request->mobile;
        DB::transaction(function () use ($user, $request) {
            $user->save();
            $mobile_login = MobileLogin::where('mobile_phone', $user->mobile_phone)->lockForUpdate()->first();
            if (!$mobile_login) {
                $mobile_login = new MobileLogin();
                $mobile_login->mobile_phone = $user->mobile_phone;
                $mobile_login->user_id = $user->user_id;
                $mobile_login->user_ids = [];
            }
            if ($mobile_login->user_id == 0) {
                $mobile_login->user_id = $user->user_id;
            }
            $mobile_login->password = Hash::make($request->password);
            $user_ids = $mobile_login->user_ids;
            $user_ids[] = $user->user_id;
            $mobile_login->user_ids = $user_ids;
            $mobile_login->save();
        });
        Auth::loginUsingId($user->user_id);
        MobileCode::where('mobile_phone', $request->mobile)->where('type', 3)->update([
            'life_time' => 0
        ]);
        return redirect()->route('xin.register.step3');
    }

    public function check_code(Request $request)
    {
        if (auth()->check()) {
            return [
                'error' => 2,
            ];
        }
        $mobile_code = MobileCode::where('mobile_phone', $request->mobile)->where('life_time', '>', 0)->where('type', 3)
            ->orderBy('add_time', 'desc')->first();
        if (!$mobile_code) {
            return [
                'error' => 1,
            ];
        }
//        $life_time = $mobile_code->life_time;
//        $start = $mobile_code->add_time;
//        $end = $start + $life_time;
//        $time = time();
//        if ($time > $end) {
//            return redirect()->route('xin.register.step1');
//        }
    }
}
