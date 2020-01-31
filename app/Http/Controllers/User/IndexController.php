<?php

namespace App\Http\Controllers\User;

use App\AccountLog;
use App\Buy;
use App\Goods;
use App\Http\Controllers\AliyunOssController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TiXianController;
use App\JnmjLog;
use App\Models\CzMoney;
use App\Models\CzMoneyLog;
use App\Models\FanKui;
use App\Models\HongbaoMoney;
use App\Models\HongbaoMoneyLog;
use App\Models\JfMoney;
use App\Models\JfMoneyLog;
use App\Models\MobileLogin;
use App\Models\UserBumen;
use App\Models\UserLevel;
use App\Models\UserLogin;
use App\Models\UserTjm;
use App\OrderAction;
use App\OrderInfo;
use App\Shipping;
use App\UserAddress;
use App\UserJnmj;
use App\YouHuiQ;
use App\ZqYwy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{

    use UserTrait;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->now = time();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sn = collect();
        $sn = $this->check_date1('yyzz_time', $this->user->yyzz_time, $sn);
        $sn = $this->check_date1('xkz_time', $this->user->xkz_time, $sn);
        $sn = $this->check_date1('zs_time', $this->user->zs_time, $sn);
        $sn = $this->check_date1('yljg_time', $this->user->yljg_time, $sn);
        $sn = $this->check_date1('cgwts_time', $this->user->cgwts_time, $sn);
        $sn = $this->check_date1('org_cert_validity', $this->user->org_cert_validity, $sn);
        if (count($sn) > 0) {
            $key = 'gqts' . date('Ymd');
            $gqts = Cache::tags(['user', $this->user->user_id])->get($key, 0);
            $sn = $sn->implode('，');
            $this->assign['sn'] = '您的' . $sn . '，为了不影响您正常采购药品请尽快联系客服将新资料邮寄过来。';
            $this->assign['gqts'] = $gqts;
            if ($gqts == 0) {
                Cache::tags(['user', $this->user->user_id])->put($key, 1, 60 * 24);
            }
        }
        $yyzz_time = $this->check_date($this->user->yyzz_time);
        $xkz_time = $this->check_date($this->user->xkz_time);
        $zs_time = $this->check_date($this->user->zs_time);
        $yljg_time = $this->check_date($this->user->yljg_time);
        $cgwts_time = $this->check_date($this->user->cgwts_time);
        $org_cert_validity = $this->check_date($this->user->org_cert_validity);
        $near_order = OrderInfo::near_order($this->user, 4);//最近的订单
        $con = new CollectionController();
        $collection = $con->near_collection();
        $yhq_count = YouHuiQ::where('user_id', $this->user->user_id)
            ->where(function ($where) {
                $where->where('end', '>', $this->now);
            })->where('enabled', 1)
            ->where('order_id', 0)->where(function ($where) {
                $where->where('user_rank', '')->orwhere('user_rank', 'like', '%' . $this->user->user_rank . '%');
            })->count();
        //为您推荐
        $wntj = Goods::rqdp('is_wntj', 10, -4);
        $zq_amount = intval(ZqYwy::where('user_id', $this->user->user_id)->pluck('zq_amount'));
        $user_jnmj = UserJnmj::where('user_id', $this->user->user_id)->first();
        $cz_money = CzMoney::where('user_id', $this->user->user_id)->first();
        if ($this->user->is_zq == 2) {
            $zq_ywy = ZqYwy::where('user_id', $this->user->user_id)->first();
            if ($zq_ywy) {
                $zq_info = collect();
                $zq_info->zq_amount = $zq_ywy->zq_amount;
                $zq_info->zq_je = $zq_ywy->zq_je;
                $zq_info->zq_rq = $zq_ywy->zq_rq;
                $zq_info->zq_has = $zq_ywy->zq_has;
                $this->set_assign('zq_info', $zq_info);
            }
        } else {
            $zq_info = collect();
            $zq_info->zq_amount = $this->user->zq_amount;
            $zq_info->zq_je = $this->user->zq_je;
            $zq_info->zq_rq = $this->user->zq_rq;
            $zq_info->zq_has = $this->user->zq_has;
            $this->set_assign('zq_info', $zq_info);
        }
        $ids = $near_order->lists('order_id')->toArray();
        $order_acton = OrderAction::whereIn('order_id', $ids)->orderBy('log_time', 'desc')->get();
        foreach ($near_order as $v) {
            $actions = $order_acton->where('order_id', $v->order_id);
            $v->order_action = $actions;
            $ddgz = $this->ddgz($v);
            $pay_xz = pay_xz($v);
            $v->setRelation('ddgz', $ddgz);
            $v->setRelation('pay_xz', $pay_xz);
        }
        $rank_name = rank_name($this->user->user_rank);
        $mobile_phone = MobileLogin::where('user_ids', 'like', '%.' . $this->user->user_id . '.%')->pluck('mobile_phone');
        $bm_id = intval(UserBumen::where('user_id', $this->user->user_id)->pluck('bm_id'));
        if ($this->user->ls_zpgly != 'admin') {
            if ($bm_id > 0 && $bm_id != 2 && $bm_id != 7 && !empty($this->user->ls_zpgly)) {
                $gly_name = $this->user->ls_zpgly;
            } elseif (($bm_id == 2 || $bm_id == 7) && !empty($this->user->question)) {
                $gly_name = $this->user->ls_zpgly;
            }
            if (isset($gly_name)) {
                $gly = DB::table('admin_users')->where('name', $gly_name)->first();
                if ($gly) {
                    $gly_html = response()->view('user.gly', ['gly' => $gly])->getContent();
                    $this->set_assign('gly_html', $gly_html);
                }
            }
        }
        $this->set_assign('mobile_phone', $mobile_phone);
        $this->set_assign('rank_name', $rank_name);
        $this->set_assign('cz_money', $cz_money);
        $this->set_assign('user_jnmj', $user_jnmj);
        $this->set_assign('zq_amount', $zq_amount);
        $this->set_assign('yhq_count', $yhq_count);
        $this->set_assign('dfk', $this->dfk());
        $this->set_assign('dsh', $this->dsh());
        $this->set_assign('yyzz_time', $yyzz_time);
        $this->set_assign('xkz_time', $xkz_time);
        $this->set_assign('zs_time', $zs_time);
        $this->set_assign('yljg_time', $yljg_time);
        $this->set_assign('cgwts_time', $cgwts_time);
        $this->set_assign('org_cert_validity', $org_cert_validity);
        $this->set_assign('near_order', $near_order);
        $this->set_assign('collection', $collection);
        $this->set_assign('wntj', $wntj);
        $this->set_assign('user_level', UserLevel::find($this->user->user_id));
        $this->set_assign('user_tjm', UserTjm::where('user_id', $this->user->user_id)->first());
        $this->set_assign('can_see_tjm', $this->checkUserTjm());
        $this->common_value();
        return view($this->view . 'user.index', $this->assign);
    }

    protected function check_date($date)
    {
        if (empty(($date))) {
            return 2;
        }
        $time1 = date('Y-m-d');
        $time2 = date('Y-m-d', strtotime('+10 day'));

        if ($date >= $time2) {
            return 2;
        } elseif ($date < $time2 && $date >= $time1) {
            return 1;
        }
        return 0;
    }

    protected function check_date1($key, $date, $sn)
    {
        $arr = [
            'cgwts_time' => '采购委托书',
            'yyzz_time' => '营业执照',
            'yljg_time' => '医疗机构执业许可证',
            'xkz_time' => '药品经营许可证',
            'zs_time' => 'GSP证书',
            'org_cert_validity' => '年度公示',
        ];
        $type = 0;
        if (empty(($date))) {
            $type = 2;
        }
        $time1 = date('Y-m-d');
        $time2 = date('Y-m-d', strtotime('+30 day'));

        if ($date >= $time2) {
            $type = 2;
        } elseif ($date < $time2 && $date >= $time1) {
            $type = 1;
        }
        if ($type == 1) {
            $sn->push('<span style="color: red;">' . $arr[$key] . '即将过期</span>');
        } elseif ($type == 0) {
            $sn->push($arr[$key] . '已经过期');
        }
        return $sn;
    }


    public function zncg(Request $request)
    {
        $this->action = 'zncg';
        $sort = trim($request->input('sort', 'desc'));
        $query = DB::table('order_info as oi')
            ->leftJoin('order_goods as og', 'oi.order_id', '=', 'og.order_id')
            ->leftJoin('goods as g', 'g.goods_id', '=', 'og.goods_id')
            ->where('oi.user_id', $this->user->user_id)->where('og.is_gift', 0)->where('oi.order_status', 1)
            ->where('oi.pay_status', 2)->where('og.parent_id', 0)->where('g.goods_id', '>', 0)
            ->select(DB::raw('count(*) as num'), 'g.goods_id', 'g.goods_name')
            ->groupBy('og.goods_id');
        $query1 = DB::table('old_order_info as oi')
            ->leftJoin('old_order_goods as og', 'oi.order_id', '=', 'og.order_id')
            ->leftJoin('goods as g', 'g.goods_id', '=', 'og.goods_id')
            ->where('oi.user_id', $this->user->user_id)->where('og.is_gift', 0)->where('oi.order_status', 1)
            ->where('oi.pay_status', 2)->where('og.parent_id', 0)->where('g.goods_id', '>', 0)
            ->select(DB::raw('count(*) as num'), 'g.goods_id', 'g.goods_name')
            ->groupBy('og.goods_id');
        $union = $query->unionAll($query1);
        $sql = DB::table(DB::raw("({$union->toSql()}) as ecs_og"))
            ->mergeBindings($union);
        $result = $sql->orderBy('num', $sort)->groupBy('og.goods_id')
            ->Paginate(20);
        $ids = $result->lists('goods_id')->toArray();
        //dd($ids);
        $real_price = $this->real_price($ids);
        //dd($real_price);
        foreach ($result as $k => $v) {
            $jh = new Goods();
            $arr = isset($real_price[$v->goods_id]) ? $real_price[$v->goods_id] : [];
            foreach ($arr as $key => $val) {
                $v->$key = $val;
            }
            $jh->forceFill(collect($v)->toArray());
            $result[$k] = $jh;
        }
        $this->set_assign('result', $result);
        $this->set_assign('sort', $sort);
        $this->common_value();
        //dd($this->assign);
        return view($this->view . 'user.zncg', $this->assign);
    }

    public function youhuiq()
    {
        $this->action = 'youhuiq';
        $query = YouHuiQ::with([
            'yhq_cate' => function ($query) {
                $query->select('cat_id', 'name', 'title', 'msg');
            }
        ])->where('user_id', $this->user->user_id)
            ->where(function ($where) {
                $where->where('end', '>', $this->now);
            })->where('enabled', 1)
            ->where('order_id', 0)->where('status', 0)->where(function ($where) {
                $where->where('user_rank', '')->orwhere('user_rank', 'like', '%' . $this->user->user_rank . '%');
            });
        $result = $query->select('cat_id', 'je', 'start', 'end', 'min_je')->orderBy('union_type')
            ->orderBy('end')->orderBy('start')->orderBy('je')
            ->get();
        foreach ($result as $v) {
            $v->img_id = 1;
        }
        $this->set_assign('result', $result);
        $this->common_value();
        return view($this->view . 'user.youhuiq', $this->assign);
    }

    public function money(Request $request)
    {
        $this->action = 'money';
        $type = intval($request->input('type'));
        $user_jnmj = UserJnmj::where('user_id', $this->user->user_id)->first();
        $cz_money = CzMoney::where('user_id', $this->user->user_id)->first();
        $this->set_assign('user_jnmj', $user_jnmj);
        $this->set_assign('cz_money', $cz_money);
        if ($request->ajax()) {
            $html = $this->money_log($request);
            ajax_return('', 0, ['html' => $html]);
        }
        $tixian = new TiXianController($request);
        $tixian = $tixian->log($request);
        $this->set_assign('tixian', $tixian);
        $this->common_value();
        $this->set_assign('type', $type);
        $this->set_assign('page', intval($request->input('page')));
        return view($this->view . 'user.money', $this->assign);
    }

    protected function money_log(Request $request)
    {
        $page = intval($request->input('page', 1));
        $perPage = 10;
        $type = intval($request->input('type'));
        switch ($type) {
            case 1:
                $result = JnmjLog::where('user_id', $this->user->user_id)->where('jnmj_money', '!=', 0)
                    ->select('change_time', 'jnmj_money', 'change_desc')
                    ->orderBy('log_id', 'desc')->Paginate($perPage);
                $jnmj = UserJnmj::where('user_id', $this->user->user_id)->first();
                $now_money = $jnmj->jnmj_amount;
                if ($page > 1) {
                    $query = DB::table('jnmj_log')->where('user_id', $this->user->user_id)->where('jnmj_money', '!=', 0)
                        ->select('change_time', 'jnmj_money', 'change_desc')
                        ->orderBy('log_id', 'desc')->take(($page - 1) * $perPage)->select('jnmj_money');
                    $total = DB::table(DB::raw("({$query->toSql()}) as ecs_al"))
                        ->mergeBindings($query)->sum('jnmj_money');
                    $now_money -= $total;
                }
                foreach ($result as $v) {
                    if ($now_money - 0 < 0.00001) {
                        $now_money = 0.00;
                    }
                    $v->now_money = $now_money;
                    $v->money = $v->jnmj_money;
                    $now_money += $v->money * (-1);
                }
                break;
            case 2:
                $result = CzMoneyLog::where('user_id', $this->user->user_id)->where('money', '!=', 0)
                    ->select('change_time', 'money', 'change_desc')
                    ->orderBy('log_id', 'desc')->Paginate($perPage);
                $cz_money = CzMoney::where('user_id', $this->user->user_id)->first();
                $now_money = $cz_money->money;
                if ($page > 1) {
                    $query = DB::table('cz_money_log')->where('user_id', $this->user->user_id)->where('money', '!=', 0)
                        ->select('change_time', 'money', 'change_desc')
                        ->orderBy('log_id', 'desc')->take(($page - 1) * $perPage)->select('user_money');
                    $total = DB::table(DB::raw("({$query->toSql()}) as ecs_al"))
                        ->mergeBindings($query)->sum('money');
                    $now_money -= $total;
                }
                foreach ($result as $v) {
                    if ($now_money - 0 < 0.00001) {
                        $now_money = 0.00;
                    }
                    $v->change_desc = str_replace('119充值余额', '充值余额', $v->change_desc);
                    $v->now_money = $now_money;
                    $now_money += $v->money * (-1);
                }
                break;
            default:
                $result = AccountLog::where('user_id', $this->user->user_id)->where('user_money', '!=', 0)
                    ->select('change_time', 'user_money', 'change_desc')
                    ->orderBy('log_id', 'desc')->Paginate($perPage);
                $now_money = $this->user->user_money;
                if ($page > 1) {
                    $query = DB::table('account_log')->where('user_id', $this->user->user_id)->where('user_money', '!=', 0)
                        ->select('change_time', 'user_money', 'change_desc')
                        ->orderBy('log_id', 'desc')->take(($page - 1) * $perPage)->select('user_money');
                    $total = DB::table(DB::raw("({$query->toSql()}) as ecs_al"))
                        ->mergeBindings($query)->sum('user_money');
                    $now_money -= $total;
                }
                foreach ($result as $v) {
                    if (abs($now_money) < 0.00001) {
                        $now_money = 0.00;
                    }
                    $v->now_money = $now_money;
                    $v->money = $v->user_money;
                    $now_money += $v->money * (-1);
                }
                break;
        }
        $result->addQuery('type', $type);
        $this->set_assign('result', $result);
        $this->set_assign('type', $type);
        $html = response()->view('user.log', $this->assign)->getContent();
        return $html;
    }

    public function info()
    {
        $this->action = 'profile';
        $this->common_value();
        return view($this->view . 'user.info', $this->assign);
    }

    public function update(Request $request)
    {
        $act = trim($request->input('act', 'base'));
        if (method_exists($this, $act)) {
            $this->$act($request);
        }

    }

    protected function base($request)
    {
        $birthday = trim($request->input('birthday'));
        $sex = intval($request->input('sex'));
        $email = trim($request->input('email'));
        $qq = trim($request->input('qq'));
        $mobile_phone = trim($request->input('mobile_phone'));
//        $this->user->birthday     = $birthday;
//        $this->user->sex          = $sex;
        $this->user->email = $email;
        $this->user->qq = $qq;
        $this->user->mobile_phone = $mobile_phone;
        if ($request->hasFile('ls_file')) {
            $file = $request->file('ls_file');
            if ($file->isValid()) {
                $size = $file->getClientSize();
                if ($size >= 200 * 1024) {
                    tips1('上传图片大小超过200KB', ['返回基本信息' => route('member.info')]);
                }
                $extension = $file->getClientOriginalExtension();
                if (!in_array(strtolower($extension), ['jpg', 'gif', 'png'])) {
                    tips1('只能上传JPG、GIF或PNG图片');
                }
                $newName = md5(date('ymdhis') . rand(0, 9)) . "." . $extension;

                $oss = new AliyunOssController();
                $oss_response = $oss->up_img('data/feedbackimg/' . date('Ym') . '/' . $newName, $file);
                $path = $oss->get_path($oss_response);
                $oss->del_img('data/feedbackimg/' . $this->user->ls_file);
                $this->user->ls_file = $path;
            }
        }
        if ($this->user->save()) {
            tips1('您的个人资料已经成功修改', ['返回基本信息' => route('member.info')]);
        }
    }

    protected function pwd($request)
    {
        $old_password = trim($request->input('old_password'));
        $password = trim($request->input('password'));
        $confirm_password = trim($request->input('confirm_password'));
        $md5_pwd = md5($old_password);
        $new_pwd = md5($password);
        if (!empty($this->user->ec_salt)) {
            $md5_pwd = md5($md5_pwd . $this->user->ec_salt);
            $new_pwd = md5($new_pwd . $this->user->ec_salt);
        }
        if ($md5_pwd != $this->user->password) {
            tips1('原密码错误', ['返回基本信息' => route('member.info')]);
        }
        if ($password !== $confirm_password) {
            tips1('两次输入密码不一致', ['返回基本信息' => route('member.info')]);
        }
        $this->user->password = $new_pwd;
        if ($this->user->save()) {
            $mobile_login = MobileLogin::where('user_ids', 'like', '%.' . $this->user->user_id . '.%')->first();
            if ($mobile_login) {
                $mobile_login->password = Hash::make($password);
                $mobile_login->save();
            }
            UserLogin::where('user_id', $this->user->user_id)->update([
                'session_id' => '',
            ]);
            UserLogin::where('user_id', $this->user->user_id)->where('session_id', $request->session()->getId())->where('is_app', 0)->delete();
            auth()->logout();
            tips1('修改密码成功', ['前往登录' => '/auth/login']);
        }
    }

    public function buy()
    {
        $this->action = 'buy';
        $result = Buy::where('user_id', $this->user->user_id)
            ->orwhere('buy_username', 'like', '%' . $this->user->user_name . '%')
            ->orderBy('buy_id', 'desc')
            ->Paginate(10);
        $this->set_assign('result', $result);
        $this->common_value();
        return view($this->view . 'user.buy', $this->assign);
    }

    public function fankui()
    {
        $this->action = 'fankui';
        $result = FanKui::where('user_id', $this->user->user_id)
            ->orderBy('rec_id', 'desc')
            ->Paginate(10);
        $arr = [
            1 => '药品咨询',
            2 => '首页意见建议',
            3 => '服务投诉',
            4 => '服务表扬',
            5 => '问题报告',
        ];
        foreach ($result as $v) {
            $v->fk_type = isset($arr[$v->type]) ? $arr[$v->type] : '问题报告';
        }
        $this->set_assign('result', $result);
        $this->common_value();
        return view($this->view . 'user.fankui', $this->assign);
    }

    public function pswl()
    {
        $this->action = 'pswl';
        $user_address = UserAddress::where('user_id', $this->user->user_id)->where('address_id', $this->user->address_id)->first();
        if ($user_address && $this->user->shipping_id == 0) {
            $shipping = Shipping::shipping_list([1, $user_address->province, $user_address->city, $user_address->district]);
            $this->set_assign('shipping', $shipping);
        }
        $this->common_value();
        return view($this->view . 'user.wuliu', $this->assign);
    }

    public function set_wl(Request $request)
    {
        if ($request->ajax()) {
            $this->ajax_set_wl($request);
        }
        if ($this->user->shipping_id != 0) {
            tips1('已选择物流', ['返回查看物流' => route('member.pswl')]);
        }
        $shipping_id = intval($request->input('shipping_id'));
        if ($shipping_id == 0) {
            tips1('未选择物流', ['返回选择物流' => route('member.pswl')]);
        }
        $shipping_name = Shipping::where('shipping_id', $shipping_id)->pluck('shipping_name');
        if ($shipping_id == 9) {
            $area_name = trim($request->input('area_name'));
            if (empty($area_name)) {
                tips1('未选择直配区域', ['返回选择物流' => route('member.pswl')]);
            }
            $shipping_name .= $area_name;
        }
        if ($shipping_id == 13) {
            $kf_name = trim($request->input('kf_name'));
            if (empty($kf_name)) {
                tips1('未选择自提库房', ['返回选择物流' => route('member.pswl')]);
            }
            $shipping_name .= $kf_name;
        }
        if ($shipping_id == -1) {
            $shipping_name = trim($request->input('shipping_name'));
            $wl_dh = trim($request->input('wl_dh'));
            if (empty($shipping_name)) {
                tips1('未填写物流名称', ['返回选择物流' => route('member.pswl')]);
            }
            $this->user->wl_dh = $wl_dh;
        }
        $this->user->shipping_id = $shipping_id;
        $this->user->shipping_name = $shipping_name;
        $this->user->save();
        tips0('物流设置成功', ['返回查看物流' => route('member.pswl')]);
    }

    protected function ajax_set_wl($request)
    {
        $shipping_id = intval($request->input('shipping_id'));
        if ($this->user->shipping_id != 0) {
            ajax_return('已选择物流', 2, ['shipping_id' => $this->user->shipping_id, 'shipping_name' => $this->user->shipping_name]);
        }
        if ($shipping_id == 0) {
            ajax_return('未选择物流', 1);
        }
        $shipping_name = Shipping::where('shipping_id', $shipping_id)->pluck('shipping_name');
        if ($shipping_id == 9) {
            $area_name = trim($request->input('area_name'));
            if (empty($area_name)) {
                ajax_return('未选择直配区域', 1);
            }
            $shipping_name .= $area_name;
        }
        if ($shipping_id == 13) {
            $kf_name = trim($request->input('kf_name'));
            if (empty($kf_name)) {
                ajax_return('未选择自提库房', 1);
            }
            $shipping_name .= $kf_name;
        }
        if ($shipping_id == -1) {
            $shipping_name = trim($request->input('shipping_name'));
            $wl_dh = trim($request->input('wl_dh'));
            if (empty($shipping_name)) {
                ajax_return('未填写物流名称', 1);
            }
            $this->user->wl_dh = $wl_dh;
        }
        $this->user->shipping_id = $shipping_id;
        $this->user->shipping_name = $shipping_name;
        $this->user->save();
        ajax_return('物流设置成功', 0, ['shipping_id' => $this->user->shipping_id, 'shipping_name' => $this->user->shipping_name]);
    }


    public function jf_money_log()
    {
        $this->action = 'jf_money';
        $jf_money = JfMoney::find($this->user->user_id);
        $result = JfMoneyLog::where('user_id', $this->user->user_id)->where('log_id', '>', 7434)
            ->orderBy('log_id', 'desc')->Paginate();
        $this->set_assign('result', $result);
        $this->set_assign('jf_money', $jf_money);
        $this->common_value();
        return view('jf_money.log', $this->assign);
    }

    public function hongbao_money_log()
    {
        $this->action = 'hongbao_money';
        $hongbao_money = HongbaoMoney::find($this->user->user_id);
        $result = HongbaoMoneyLog::where('user_id', $this->user->user_id)
            ->orderBy('log_id', 'desc')->Paginate();
        $this->set_assign('result', $result);
        $this->set_assign('hongbao_money', $hongbao_money);
        $this->common_value();
        return view('hongbao_money.log', $this->assign);
    }

    public function checkUserTjm()
    {
        $this->user = $this->user->is_new_user();
        if (!$this->user->is_zhongduan) {
            return false;
        }
        $orderNum = $this->user->orderNum;
        if ($orderNum == 0) {
            $orderNum = DB::table('user_status')->where('user_id', $this->user->user_id)->count();
        }
        if ($orderNum == 0) {
            return false;
        }
        return true;
    }

    public function generateTjm()
    {
        $this->user = $this->user->is_new_user();
        if (!$this->user->is_zhongduan) {
            ajax_return('此活动只针对终端用户！', 1);
        }
        $orderNum = $this->user->orderNum;
        if ($orderNum == 0) {
            $orderNum = DB::table('user_status')->where('user_id', $this->user->user_id)->count();
        }
        if ($orderNum == 0) {
            ajax_return('请先购买订单再生成邀请码！', 1);
        }
        $user_tjm = UserTjm::where('user_id', $this->user->user_id)->first();
        if ($user_tjm) {
            $view = response()->view('user.tjm', compact('user_tjm'))->getContent();
            ajax_return('邀请码生成成功', 0, ['html' => $view, 'tjm' => $user_tjm->tjm]);
        }
        $tjm = rand(100, 999) . str_pad($this->user->user_id, 5, 0, STR_PAD_LEFT);
        $user_tjm = new UserTjm();
        $user_tjm->user_id = $this->user->user_id;
        $user_tjm->tjm = $tjm;
        $user_tjm->save();
        $view = response()->view('user.tjm', compact('user_tjm'))->getContent();
        ajax_return('邀请码生成成功', 0, ['html' => $view, 'tjm' => $user_tjm->tjm]);
    }
}
