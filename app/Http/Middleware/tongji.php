<?php

namespace App\Http\Middleware;

use App\Ad;
use App\Models\Message;
use App\Models\MessageUsers;
use App\Models\UserLogin;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class tongji
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $route = $request->route();
        if (auth()->check()) {
            $user = auth()->user();
            $error = $this->user_login($request, $user);
            if ($error == 1) {
                return redirect()->to('auth/login');
            }
            $start = strtotime(date('Ymd'));
            if ($user->last_login < $start) {
                $user->last_login = time();
                $user->save();
            }
            if ($user->ls_review == 1 || ($user->ls_review_7day == 1 && $user->day7_time > time())
) {
                $time = time();
                $message = Message::with([
                    'msg_users' => function ($query) use ($user) {
                        $query->where('user_id', $user->user_id);
                    }
                ])->where(function ($query) use ($user) {
                    $query->where('ls_user_ids', '')->orwhere('ls_user_ids', 'like', '%.' . $user->user_id . '.%');
                })->where(function ($query) use ($user) {
                    $query->where('ls_ranks', '')->orwhere('ls_ranks', 'like', '%' . $user->user_rank . '%');
                })->where(function ($query) use ($user) {
                    $query->where('ls_regions', '')
                        ->orwhere('ls_regions', 'like', '%.' . $user->province . '.%')
                        ->orwhere('ls_regions', 'like', '%.' . $user->city . '.%')
                        ->orwhere('ls_regions', 'like', '%.' . $user->district . '.%');
                })->where('type', 0)->where('start', '<=', $time)
                    ->where('end', '>', $time)->where('enabled', 0)
                    ->select('msg_id', 'enabled')->get();
                $insert = [];
                $msg_count = 0;
                foreach ($message as $v) {
                    if (count($v->msg_users) == 0) {
                        if ($v->enabled == 0) {
                            $insert[] = [
                                'msg_id' => $v->msg_id,
                                'user_id' => $user->user_id,
                                'status' => 0,
                                'add_time' => $time,
                                'update_time' => $time,
                            ];
                        }
                    } else {
                        foreach ($v->msg_users as $msg_user) {
                            if ($msg_user->status == 0) {
                                $msg_count++;
                            }
                        }
                    }
                }
                if (count($insert) > 0) {
                    MessageUsers::insert($insert);
                    $msg_count += count($insert);
                }
            } else {
                $msg_count = 0;
            }
            $msg_count = MessageUsers::where('user_id', $user->user_id)->where('status', 0)->count();
            Cache::tags($user->user_id)->put('msg_count', $msg_count, 8 * 60);
        }
        if ($route) {
            $route = $request->route()->getAction();
            $date = date('Ymd');
            $time = time();
            $adtj = intval($request->input('adtj'));
            if ($adtj > 0) {
                $ad = Ad::where('ad_tongji', 1)->where('start_time', '<=', $time)
                    ->where('end_time', '>', $time)->where('enabled', 1)
                    ->where('ad_id', $adtj)
                    ->select('ad_id', 'ad_link', 'ad_name')
                    ->first();
                if ($ad) {
                    $full_url = $request->fullUrl();
                    if (strpos($full_url, $ad->ad_link) !== false) {
                        $insert = [
                            'ad_id' => $ad->ad_id,
                            'ad_name' => $ad->ad_name,
                            'ip' => $request->server('HTTP_X_FORWARDED_FOR'),
                            'create_time' => $time,
                        ];
                        if (is_null($insert['ip'])) {
                            $insert['ip'] = $request->ip();
                        }
                        DB::table('ad_tongji')->insert($insert);
                    } else {
                        if (strpos($ad->ad_link, '&') !== false) {
                            $url1 = $request->query();
                            $url2 = explode('?', $ad->ad_link);
                            if (isset($url2[1])) {
                                $url2 = explode('&', $url2[1]);
                                $diff = array_diff($url1, $url2);
                                if (count($diff) == 0) {
                                    $insert = [
                                        'ad_id' => $ad->ad_id,
                                        'ad_name' => $ad->ad_name,
                                        'ip' => $request->server('HTTP_X_FORWARDED_FOR'),
                                        'create_time' => $time,
                                    ];
                                    if (is_null($insert['ip'])) {
                                        $insert['ip'] = $request->ip();
                                    }
                                    DB::table('ad_tongji')->insert($insert);
                                }
                            }
                        }
                    }
                }
            } else {
                $ads = Ad::where('ad_tongji', 1)
                    ->where('start_time', '<=', $time)
                    ->where('end_time', '>', $time)
                    ->where('enabled', 1)
                    ->select('ad_id', 'ad_link', 'ad_name')
                    ->get();
                if (count($ads) > 0) {
                    foreach ($ads as $v) {
                        $ad_link = trim($v->ad_link);
                        if (!empty($ad_link)) {
                            $full_url = $request->fullUrl();
                            if ($request->fullUrl() == $ad_link) {
                                $insert = [
                                    'ad_id' => $v->ad_id,
                                    'ad_name' => $v->ad_name,
                                    'ip' => $request->server('HTTP_X_FORWARDED_FOR'),
                                    'create_time' => $time,
                                ];
                            } else {
                                if (strpos($full_url, '&') !== false && strpos($ad_link, '&') !== false) {
                                    $url1 = explode('?', $full_url);
                                    $url2 = explode('?', $ad_link);
                                    if (isset($url1[1]) && isset($url2[1])) {
                                        $url1 = explode('&', $url1[1]);
                                        $url2 = explode('&', $url2[1]);
                                        $diff = array_diff($url1, $url2);
                                        if (count($diff) == 0) {
                                            $insert = [
                                                'ad_id' => $v->ad_id,
                                                'ad_name' => $v->ad_name,
                                                'ip' => $request->server('HTTP_X_FORWARDED_FOR'),
                                                'create_time' => $time,
                                            ];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if (auth()->check()) {
                    $user = auth()->user();
                    if (isset($insert['ad_id'])) {
                        $insert['user_id'] = $user->user_id;
                    }
                    if ($user->is_special == 1 && (isset($route['as']) && $route['as'] != 'error') && $request->ajax() == false) {//账号已作废
                        return redirect()->route('error', ['msg' => '该账号已停用,如有疑问请咨询客服!', 'm' => 0]);
                    }
                }
                if (isset($insert['ad_id'])) {
                    if (is_null($insert['ip'])) {
                        $insert['ip'] = $request->ip();
                    }
                    DB::table('ad_tongji')->insert($insert);
                }
            }
        }
        return $response;
    }

    protected function user_login($request, $user)
    {
        if (!$request->ajax()) {
            $user_login = UserLogin::where('user_id', $user->user_id)->where('is_app', 0)->get();
            $lifetime = config('session.lifetime');
            $time = time();
            UserLogin::where('change_time', '<=', $time - $lifetime * 60 - 120)->where('is_app', 0)->delete();
            if (count($user_login) > 0) {
                $session_id = $request->session()->getId();
                $has = 0;
                foreach ($user_login as $v) {
                    if ($v->session_id == $session_id) {
                        UserLogin::where('user_id', $user->user_id)->where('session_id', $session_id)->where('is_app', 0)->update([
                            'change_time' => time(),
                        ]);
                        $has = 1;
                        break;
                    }
                }
                if ($has == 0) {
                    auth()->logout();
                    return 1;
                }
            }
        }
        return 0;
    }
}
