<?php

namespace App\Http\Controllers;

use App\Article;
use App\Cart;
use App\Goods;
use App\GoodsAttr;
use App\JnmjLog;
use App\OrderAction;
use App\OrderGoods;
use App\OrderInfo;
use App\Shipping;
use App\Payment;
use App\UserAddress;
use App\UserJnmj;
use App\ZqLog;
use App\ZqOrder;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use App\Region;
use Illuminate\Support\Facades\Auth;
use App\CollectGoods;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\UserAccount;
use App\AccountLog;
use App\FeedBack;
use App\Buy;
use Jai\Contact\Http\Controllers\pay\quickpay_service;
use Jai\Contact\Http\Controllers\pay\upop;
use Jai\Contact\Http\Controllers\pay\quickpay_conf;
require_once app_path() . '/Common/user.php';
require_once app_path() . '/Common/goods.php';

class UserController extends Controller
{
    /*
 * 中间件
 */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $nav_list;

    private $arr;

    public function __construct(){
        $this->nav_list = nav_list('middle');
        $this->arr = [
            'page_title'=>'用户中心-',
            'action'=>'',
            'user'=>auth()->user(),
            'middle_nav'=>$this->nav_list,
        ];
        //dd($this->nav_list);
    }

    public function index(Request $request)
    {
        $user = Auth::user()->is_new_user();
        $user_jnmj = UserJnmj::where('user_id',$user->user_id)->first();
        //dd($user_jnmj);
        $pay_amount = OrderInfo::pay_amount($user);// 消费总额
        $wait_amount = OrderInfo::wait_amount($user);//待付款金额
        $pay_order = OrderInfo::pay_order($user);//待发货数量
        $wait_order = OrderInfo::wait_order($user);//待付款数量
        $yyzz_time = ($user->yyzz_time>time() or empty($user->yyzz_time))?1:0;
        $xkz_time = ($user->xkz_time>time() or empty($user->xkz_time))?1:0;
        $zs_time = ($user->zs_time>time() or empty($user->zs_time))?1:0;
        $yljg_time = ($user->yljg_time>time() or empty($user->yljg_time))?1:0;
        $near_order = OrderInfo::near_order($user,3);//最近的订单
        //print_r($near_order->toArray());
        $collection = CollectGoods::collect_near(3,$user);//我的收藏
        //dd($collection);
        //为您推荐
        $wntj = Goods::rqdp('is_wntj',10,-4);
        $wntj = goods_list($user,$wntj);
        $this->arr['user_jnmj'] = $user_jnmj;
        $this->arr['pay_amount'] = formated_price($pay_amount);
        $this->arr['wait_amount'] = formated_price($wait_amount);
        $this->arr['yyzz_time'] = $yyzz_time;
        $this->arr['xkz_time'] = $xkz_time;
        $this->arr['zs_time'] = $zs_time;
        $this->arr['yljg_time'] = $yljg_time;
        $this->arr['pay_order'] = $pay_order;
        $this->arr['wait_order'] = $wait_order;
        $this->arr['near_order'] = $near_order;
        $this->arr['collection'] = $collection;
        $this->arr['wntj'] = $wntj;
        return view('userCenter')->with($this->arr);
    }
    /*
     * 我的订单列表
     */
    public function orderList(Request $request){
        $dates = $request->input('dates',0);//日期
        $keys = $request->input('keys','');//订单编号
        $status = $request->input('status',0);//100待付款,101待发货
        $user = Auth::user();
        $orderList = OrderInfo::where(function($query)use($dates,$keys,$user,$status){
            if($dates==1){
                $times = strtotime('-3 month');
                $query->where('add_time','>',$times);
            }elseif($dates==2){
                $times = strtotime(date('Y').'-01-01');
                $query->where('add_time','>',$times);
            }elseif($dates==date('Y',strtotime('-1 year'))){
                $times = strtotime($dates.'-01-01');
                $times_end = strtotime(date('Y').'-01-01');
                $query->whereBetween('add_time',[$times,$times_end]);
            }elseif($keys!=''){
                $query->where('order_sn',$keys);
            }
            if($status==100){
                $query->where('order_status',1)->where('pay_status',0)->where('shipping_status',0);
            }elseif($status==101){
                $query->where('order_status',1)->where(function($query){
                    $query->where('pay_status',1)->orwhere('pay_status',2);
                });
            }
            $query->where('user_id',$user->user_id);
        })
            ->select('order_id','add_time','order_status','pay_status','shipping_status','order_sn','goods_amount','consignee')
            ->orderby('add_time','desc')
            ->Paginate(10);

        $this->arr['action'] = 'orderList';
        $this->arr['pages'] = $orderList;
        $this->arr['dates'] = $dates;
        $this->arr['keys'] = $keys;
        return view('orderList')->with($this->arr);
    }

    /*
     * 订单跟踪
     */
    public function ddgz(Request $request){
        if($request->ajax()) {
            $order_id = $request->input('order_ids');
            $rows = OrderAction::where('order_id', $order_id)->orderBy('log_time','desc')->get();
            $status = [];  //订单操作记录
            //llPrint($status);
            if ($rows->isEmpty()) {
                $rs = OrderInfo::where('order_id', $order_id)
                    ->select('add_time')
                    ->first();
                $status[] = [
                    'status' => 0,
                    'con' => '您的订单已提交，等待系统审核。',
                    'times' => date('Y-m-d H:i:s', $rs['add_time']),
                ];
            } else {
                foreach ($rows as $row) {
                    if ($row->order_status == 1 && $row->pay_status == 0 && $row->shipping_status == 0) {
                        $status[] = [
                            'status' => 1,
                            'con' => '请您尽快完成付款，订单为未付款。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 0) {
                        $status[] = [
                            'status' => 2,
                            'con' => '您的订单商家正在积极备货中，未发货。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 1) {
                        $status[] = [
                            'status' => 3,
                            'con' => '您的订单商家已开票。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 2) {
                        $status[] = [
                            'status' => 4,
                            'con' => '您的订单正在出库中，请您耐心等待。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 3) {
                        $status[] = [
                            'status' => 5,
                            'con' => '您的订单现已出库。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 4) {
                        $status[] = [
                            'status' => 6,
                            'con' => '您的订单已发货。',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 5) {
                        $status[] = [
                            'status' => 7,
                            'con' => '<font color="red">您的订单已送达成功！已完成。</font>',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 2 && $row->pay_status == 0) {
                        $status[] = [
                            'status' => 8,
                            'con' => '<font color="red">您的订单已取消。</font>',
                            'times' => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                }
            }
//            $str = '<ul>';
//            foreach ($status as $k => $v) {
//                $str .= '<li class="fn_clear @if($k==0) on_hover @endif">
//                    <span class="date_txt">' . $v['times'] . '</span> <span class="data_txt">' . $v['con'] . '</span>
//                    </li>';
//            }
//            $str .= '</ul>';
            //llPrint($status);
            return view('layout.ddgz')->with(['status'=>$status]);
            //return $str;
        }else{
            exit;
        }
    }

    /*
     * 确认收货
     */
    public function sureShipping(Request $request){
        $user = auth()->user();
        $id = $request->input('id');
        /* 查询订单信息，检查状态 */
        $order = OrderInfo::select('order_sn','order_status','shipping_status','pay_status','order_id','user_id')->findOrfail($id);
        $this->authorize('update-post',$order);
        // 如果用户ID大于 0 。检查订单是否属于该用户
        if (empty($order))
        {
            return view('message')->with(messageSys('订单不存在请咨询客服',route('user.orderList'),[
                [
                    'url'=>route('user.orderList'),
                    'info'=>'返回订单列表',
                ],
            ]));
        }
        /* 检查订单 */
        elseif ($order->shipping_status == 5)
        {
            return view('message')->with(messageSys('订单已完成',route('user.orderInfo',['id'=>$id]),[
                [
                    'url'=>route('user.orderList'),
                    'info'=>'返回订单列表',
                ],
            ]));
        }
        elseif ($order['shipping_status'] != 4)
        {
            return view('message')->with(messageSys('订单状态有误',route('user.orderInfo',['id'=>$id]),[
                [
                    'url'=>route('user.orderList'),
                    'info'=>'返回订单列表',
                ],
            ]));
        }
        /* 修改订单发货状态为“确认收货” */
        else
        {
            $order->shipping_status = 5;
            DB::transaction(function()use($order,$user){
                $order->save();
                order_action($order,'',$user->user_name);
            });
            return view('message')->with(messageSys('订单确认收货成功',route('user.orderInfo',['id'=>$id]),[
                [
                    'url'=>route('user.orderList'),
                    'info'=>'返回订单列表',
                ],
            ]));
        }
    }

    /*
     * 我的订单详情
     */
    public function orderInfo(Request $request){
        $id = intval($request->input('id'));//订单编号
        $user = Auth::user();
        $order = OrderInfo::with([
            'order_goods'=>function($query){
            $query->select('order_id','goods_id','goods_name','goods_price','goods_number');
        }])->where('user_id',$user->user_id)->where('order_id',$id)->first();
        //llPrint($order,2);
        if(!$order){
            return view('message')->with(messageSys('订单不存在请咨询客服',route('user.orderList'),[
                [
                    'url'=>route('user.orderList'),
                    'info'=>'返回订单列表',
                ],
            ]));
        }
        $this->arr['order'] = $order;
        $this->arr['action'] = 'orderList';
        if($order->pay_status!=2&&$order->order_status==1&&$order->order_amount>0){
            /**
             * 支付限制
             */
            $status = pay_xz($order);
            if($status==true) {
                //银联支付
                $user = auth()->user();
                $payment_info = Payment::where('pay_id', 4)->where('enabled', 1)->first();
                $payment = unserialize_config($payment_info->pay_config);
                //dd($payment);
                $order['user_name'] = $user->user_name;
                $order['pay_desc'] = $payment_info->pay_desc;
                $pay_obj = new upop();
                $unionpay = $pay_obj->get_code($order, $payment);
                //dd($order);
//            $unionpay = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="'.route('union.pay').'" method="get" target="_blank">
//                <input class="J_payonline" value="银联支付" type="submit">
//                <input value="'.$order->order_id.'" name="id" type="hidden">
//                <input value="'.route('union.search',['id'=>$order->order_id]).'" type="hidden" id="searchUrlUnion">
//                </form>';
                $abcpay = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="' . route('abc.pay') . '" method="get" target="_blank">
                <input class="J_payonline" style="left: 250px;;" value="农行支付" type="submit">
                <input value="' . $order->order_id . '" name="id" type="hidden">
                <input value="' . route('abc.search', ['id' => $order->order_id]) . '" type="hidden" id="searchUrl">
                </form>';
                $this->arr['unionpay'] = $unionpay;
                $this->arr['abcpay'] = $abcpay;
            }
        }
        return view('orderInfo')->with($this->arr);
    }
    /*
     * 追加使用余额
     */
    public function useSurplus(Request $request){
        $surplus = floatval($request->input('surplus'));
        if($surplus<=0){
            return redirect()->back();
        }else{
            $user = Auth::user();
            $orderId = $request->input('orderId');
            $orderInfo = OrderInfo::where('is_mhj',0)
                ->select('order_id','order_sn','order_amount','order_status','pay_status','surplus','user_id','is_zq')
                ->findOrfail($orderId);
            $this->authorize('update-post',$orderInfo);
            if($orderInfo){
                if($orderInfo->order_status!=1||$orderInfo->pay_status==2){
                    return view('message')->with(messageSys('该订单不用付款',route('user.orderList'),[
                        [
                            'url'=>route('user.orderList'),
                            'info'=>'返回订单列表',
                        ],
                    ]));
                }else{
                    if($orderInfo->is_zq==1){
                        return view('message')->with(messageSys('账期订单不能直接支付',route('user.orderList'),[
                            [
                                'url'=>route('user.orderList'),
                                'info'=>'返回订单列表',
                            ],
                        ]));
                    }
                    $surplus = min([$orderInfo->order_amount,$surplus,$user->user_money]);
                    if($surplus>0){//记录余额变动
                        //dd($order_info->surplus);
                        $orderInfo->surplus = $orderInfo->surplus + $surplus;
                        if($orderInfo->order_amount==$surplus){
                            $orderInfo->pay_status = 2;
                        }
                        $orderInfo->order_amount = $orderInfo->order_amount - $surplus;
                        //dd($orderInfo);
                        DB::transaction(function()use($orderInfo,$user,$surplus){//数据库事务
                            $orderInfo->save();
                            log_account_change($user->user_id, $surplus*(-1), 0, 0, 0, '支付订单'.$orderInfo->order_sn);  //2015-7-27
                        });
                        return redirect()->route('user.orderInfo',['id'=>$orderId]);
                    }else{
                        return redirect()->back();
                    }
                }
            }else{
                return redirect()->back();
            }
        }
    }
    /*
     * 再次购买
     */
    public function orderBuy(Request $request){
        $user = Auth::user();
        $orderId = $request->input('id');
        $ids = OrderGoods::where('order_id',$orderId)->lists('goods_id');
        $result = orderBuy($ids,$user);
        if(!empty($result['insert_cart'])){
            //dd($result);
            Cart::insert($result['insert_cart']);
            Cache::tags([$user->user_id,'cart'])->increment('num',count($result['insert_cart']));
        }
        return view('message')->with(messageSys($result['messages'],route('user.orderList'),[
            [
                'url'=>route('cart.index'),
                'info'=>'前往购物车结算',
            ],
        ]));
    }
    /*
     * 我的收藏
     */
    public function collectList(Request $request){
        $type = $request->input('type',0);
        $user = Auth::user()->is_new_user();
        //DB::table('collect_goods')->where('goods_id',0)->delete();
        $collection = CollectGoods::where('user_id',$user->user_id)->where('goods_id','>',0)
            ->where(function($query)use($type){
                if($type!=0){
                    $query->where('show_area','like',"%{$type}%");
                }
            })->select('goods_id','rec_id')
            ->orderBy('add_time','desc')
            ->Paginate(20);
        $collection = goods_list($user,$collection,0,'goods_list',true);
        foreach($collection as $v){
            $v->goods = Goods::area_xg($v->goods,$user);
            $v->cgcs = DB::table('order_goods as og')->leftjoin('order_info as oi','og.order_id','=','oi.order_id')
                ->where('og.goods_id',$v->goods_id)->where('oi.user_id',$user->user_id)
                ->pluck(DB::raw('count(*) as cgcs'));
        }
        $this->arr['action'] = 'collectList';
        $this->arr['pages'] = $collection;
        $this->arr['type'] = $type;
        return view('collectList')->with($this->arr);
    }
    /*
     * 取消收藏
     */
    public function deleteCollect(Request $request){
        $id = $request->input('id');
        $collection = new CollectGoods();
        $collection->destroy($id);
        return redirect()->back();
    }
    /*
     * 批量取消收藏
     */
    public function deleteCollectPl(Request $request){
        $id = $request->input('ids');
        $user = Auth::user();
        CollectGoods::whereIn('goods_id',$id)->where('user_id',$user->user_id)->delete();
            return redirect()->back();

    }
    /*
     * 智能采购
     */
    public function zncg(){
        $user =Auth::user()->is_new_user();
        $zncg = DB::table('order_info as oi')->leftJoin('order_goods as og','oi.order_id','=','og.order_id')
            ->where('oi.user_id',$user->user_id)->where('oi.pay_status',2)->where('oi.parent_id',0)->where('og.goods_id','>',0)
            ->select(DB::raw('count(*) as goods_number'),'goods_id')
            ->groupBy('og.goods_id')
            //->lists('goods_id');
            ->Paginate();
        $zncg = goods_list($user,$zncg,0,'goods_list',true);
        //dd($zncg);
        $assign = [
            'page_title' =>  '用户中心-',
            'user' =>  $user,
            'action'=>'zncg',
            'pages'=>$zncg,

        ];
        $this->arr['action'] = 'zncg';
        $this->arr['pages'] = $zncg;
        return view('zncg')->with($this->arr);
    }
    /*
     * 批量购买
     */
    public function plBuy(Request $request){
        $user = Auth::user()->is_new_user();
        $ids = $request->input('ids');
        $result = orderBuy($ids,$user);
        if(!empty($result['insert_cart'])){

            Cart::insert($result['insert_cart']);
            Cache::tags([$user->user_id,'cart'])->increment('num',count($result['insert_cart']));
        }
        return view('message')->with(messageSys($result['messages'],$request->server('HTTP_REFERER'),[
            [
                'url'=>route('cart.index'),
                'info'=>'前往购物车结算',
            ],
        ]));
    }
    /*
     * 基本信息
     */
    public function profile(){
        $user = Auth::user();
        $birth = explode('-',$user->birthday);
        $year = "";
        for($i=2010;$i>1949;$i--){
            if($birth[0]==$i){
                $year .= "<option value='$i' selected >$i</option>";
            }else{
                $year .= "<option value='$i'>$i</option>";
            }
        }
        $month = "";
        for($i=1;$i<13;$i++){
            if($birth[1]==$i){
                $month .= "<option value='".sprintf('%02d',$i)."' selected >".sprintf('%02d',$i)."</option>";
            }else{
                $month .= "<option value='".sprintf('%02d',$i)."'>".sprintf('%02d',$i)."</option>";
            }
        }
        $day = "";
        for($i=1;$i<32;$i++){
            if($birth[2]==$i){
                $day .= "<option value='".sprintf('%02d',$i)."' selected >".sprintf('%02d',$i)."</option>";
            }else{
                $day .= "<option value='".sprintf('%02d',$i)."'>".sprintf('%02d',$i)."</option>";
            }
        }
        $this->arr['action'] = 'profile';
        $this->arr['year'] = $year;
        $this->arr['month'] = $month;
        $this->arr['day'] = $day;
        return view('profile')->with($this->arr);
    }
    /*
     * 基本信息更新
     */
    public function infoUpdate(Request $request){
        $user = Auth::user();
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');
        $sex = $request->input('sex');
        $email = $request->input('email');
        $qq = $request->input('qq');
        $mobile_phone = $request->input('mobile_phone');
        $birth = $year."-".$month."-".$day;
        $user->birthday = $birth;
        $user->sex = $sex;
        $user->email = $email;
        $user->qq = $qq;
        $user->mobile_phone = $mobile_phone;
        if($request->hasFile('ls_file')){
            $file = $request->file('ls_file');
            if($file->isValid()){

                $extension = $file->getClientOriginalExtension();

                //$mimeTye = $file->getMimeType();//文件格式

                $newName = md5(date('ymdhis').rand(0,9)).".".$extension;

                $path = $file->move('data/feedbackimg',$newName); //图片存放的地址
                $user->ls_file = $path->getFilename();
//                if(!$user->save()){
//                    return '图片保存失败';
//                }
                //print_r($path->getPath());
            }
        }
        if($user->save()){
            return view('message')->with(messageSys('您的个人资料已经成功修改',route('user.profile'),[
                [
                    'url'=>route('user.profile'),
                    'info'=>'查看我的个人资料',
                ],
            ]));
        }
    }
    /*
     * 重置密码
     */
    public function setPwd(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ],[
            'old_password.required'=>'原密码不能为空',
            'old_password.min'=>'原密码长度至少为6位',
            'password.required'=>'新密码不能为空',
            'password.confirmed'=>'新密码确认密码不符',
            'password.min'=>'新密码长度至少为6位',
        ]);
        //$messages = $validator->errors();
        //print_r($messages->get('password'));die;
        if ($validator->fails()) {
            //print_r($validator->fails());die;
            return redirect('user/profile')
                ->withErrors($validator)
                ->withInput();
        }else{
            $oldPwd = $request->input('old_password');
            $newPwd = $request->input('password');
            $salt = $user->ec_salt;
            if($salt){
                $oldPwd_md5 = md5(md5($oldPwd).$salt);
                $newPwd_md5 = md5(md5($newPwd).$salt);
                //dd($oldPwd_md5,$user->password);
            }else{
                $oldPwd_md5 = md5($oldPwd);
                $newPwd_md5 = md5($newPwd);
            }
            if($oldPwd_md5==$user->password){
                $user->password = $newPwd_md5;
                if($user->save()){
                    return view('message')->with(messageSys('密码重置成功',route('user.profile'),[
                        [
                            'url'=>route('user.profile'),
                            'info'=>'查看我的个人资料',
                        ],
                    ]));
                }
            }else{
                return view('message')->with(messageSys('原密码错误',route('user.profile'),[
                    [
                        'url'=>route('user.profile'),
                        'info'=>'查看我的个人资料',
                    ],
                ]));
            }
        }
    }
    /*
     * 余额管理
     */
    public function account(){
        $user = Auth::user();
        $userAccount = UserAccount::where('user_id',$user->user_id)
            ->select('amount','add_time','admin_note','user_note','process_type','is_paid')
            ->Paginate(10);
        $user_money = AccountLog::where('user_id',$user->user_id)->sum('user_money');
        $assign = [
            'page_title' =>  '用户中心-',
            'user' =>  $user,
            'action'=>'account',
            'pages'=>$userAccount,
            'pagesForm'=> '<form action="'.route('user.zncg').'" type="get" class="submit_input">
        <span>共'.$userAccount->lastPage().'页</span>
        <span>到第<input name="page" class="page_inout" value="'.$userAccount->currentPage().'" type="text">页</span>
        <input value="确定" class="submit" type="submit">
    </form>',
            'params'=>[
                'url'=>'user.account',
            ],
            'user_money'=>$user_money,
        ];
        $this->arr['action'] = 'account';
        $this->arr['pages'] = $userAccount;
        $this->arr['user_money'] = $user_money;
        return view('account')->with($this->arr);
    }
    /*
     * 查看账户明细
     */
    public function accountInfo(){
        $user = Auth::user();
        $accountInfo = AccountLog::where('user_id',$user->user_id)->where('user_money','!=',0)
            ->select('change_time','user_money','change_desc')
            ->orderBy('change_time','desc')
            ->Paginate(10);
        $user_money = AccountLog::where('user_id',$user->user_id)->sum('user_money');

        $this->arr['action'] = 'account';
        $this->arr['pages'] = $accountInfo;
        $this->arr['user_money'] = $user_money;
        return view('accountInfo')->with($this->arr);
    }
    /*
     * 收货地址
     */
    public function addressList(){
        $user = Auth::user();
        $addressList = UserAddress::where('user_id',$user->user_id)->get();
        //$province = Region::where('parent_id',1)->where('region_type',1)->get();
        $province = Cache::tags(['shop','region'])->rememberForever(1,function(){
            return Region::where('parent_id', 1)->get();
        });
        foreach($addressList as $v){
            //$v->cityList = Region::where('parent_id',$v->province)->where('region_type',2)->get();
            $v->cityList = Cache::tags(['shop','region'])->rememberForever($v->province,function()use($v){
                return Region::where('parent_id', $v->province)->get();
            });
            //$v->districtList = Region::where('parent_id',$v->city)->where('region_type',3)->get();
            $v->districtList = Cache::tags(['shop','region'])->rememberForever($v->city,function()use($v){
                return Region::where('parent_id', $v->city)->get();
            });
            //print_r($v->cityList->toArray());
        }
        $this->arr['action'] = 'addressList';
        $this->arr['addressList'] = $addressList;
        $this->arr['province'] = $province;
        return view('addressList')->with($this->arr);
    }
    /*
     * 收货地址更新
     */
    public function addressUpdate(Request $request){
        $rules = [
            'required'=>'不能为空',
            'email'=>'邮件格式错误',
        ];
        $validator = Validator::make($request->all(), [
            'consignee' => 'required',
            'email' => 'required',
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'address' => 'required',
            'tel' => 'required',
        ],$rules);
        if ($validator->fails()) {
            //print_r($validator->fails());die;
            return redirect('user/messageList')
                ->withErrors($validator)
                ->withInput();
        }else {
            $user = Auth::user();
            $id = $request->input('addressId');
            $address = UserAddress::findOrNew($id);
            if($address->address_id) {
                $this->authorize('update-post',$address);
            }
            $address->consignee = $request->input('consignee');
            $address->user_id = $user->user_id;
            $address->email = $request->input('email');
            $address->country = $request->input('country');
            $address->province = $request->input('province');
            $address->city = $request->input('city');
            $address->district = $request->input('district');
            $address->address = $request->input('address');
            $address->tel = $request->input('tel');
            $address->mobile = $request->input('mobile');
            $address->sign_building = $request->input('sign_building');
            $address->best_time = $request->input('best_time');
            $address->zipcode = $request->input('zipcode');
            $act = $request->input('act', 'user');
            if ($address->save()) {
                if ($id == 0) {
                    $user->address_id = $address->address_id;
                } else {
                    $user->address_id = $id;
                }
                $user->save();
                if ($act != 'user') {
                    return redirect()->route('cart.jiesuan');
                } else {
                    if ($id == 0) {
                        $messsage = '您的收货地址信息添加成功';
                    } else {
                        $messsage = '您的收货地址信息已成功更新';
                    }
                    return view('message')->with(messageSys($messsage, route('user.addressList'), [
                        [
                            'url' => route('user.addressList'),
                            'info' => '返回地址列表',
                        ],
                    ]));
                }
            }
        }
    }
    /*
     * 删除收货地址
     */
    public function addressDelete(Request $request){
        $user = Auth::user();
        $id = $request->input('id');
        $act = $request->input('act','user');
        $userAddress = UserAddress::findOrfail($id);
        $this->authorize('update-post',$userAddress);
        if($userAddress->delete()){
            if($user->address_id==$id){
                $user->address_id = 0;
                $user->save();
            }
            if($act!='user'){
                return redirect()->back();
            }else {
                return view('message')->with(messageSys('收货地址删除成功！', route('user.addressList'), [
                    [
                        'url' => route('user.addressList'),
                        'info' => '返回地址列表',
                    ],
                ]));
            }
        }
    }
    /*
     * 物流配送
     */
    public function pswl(){
        $user = Auth::user();
        if($user->shipping_id!=-1&&$user->shipping_id!=0) {//不是其他物流
            $pswl = Shipping::where('shipping_id', $user->shipping_id)->pluck('shipping_name');
        }else{
            $pswl = $user->shipping_name;
        }
        $this->arr['action'] = 'pswl';
        $this->arr['pswl'] = $pswl;
        return view('pswl')->with($this->arr);
    }
    /*
     * 我的留言
     */
    public function messageList(){
        $user = Auth::user();
        $msg_type = [
            0=>'留言',
            1=>'投诉',
            2=>'询问',
            3=>'售后',
            4=>'求购',
        ];
        $messageList = FeedBack::where('user_id',$user->user_id)->where('parent_id',0)->where('order_id',0)
            ->select('msg_id','msg_title','msg_time','msg_content','msg_type','message_img')
            ->Paginate(10);
        $this->arr['action'] = 'messageList';
        $this->arr['msg_type'] = $msg_type;
        $this->arr['pages'] = $messageList;
        return view('messageList')->with($this->arr);
    }
    /*
     * 订单留言
     */
    public function messageOrder(Request $request){
        $user = Auth::user();
        $orderId = $request->input('id');
        $messageList = FeedBack::where('user_id',$user->user_id)->where('parent_id',0)->where('order_id',$orderId)
            ->select('msg_id','msg_title','msg_time','msg_content','msg_type','message_img','user_name')
            ->Paginate(10);
        $this->arr['action'] = 'orderList';
        $this->arr['orderId'] = $orderId;
        $this->arr['pages'] = $messageList;
        return view('messageOrder')->with($this->arr);
    }
    /*
     * 添加留言
     */
    public function msgCreate(Request $request){
        $rules = [
            'required'=>'不能为空',
            'numeric'=>'请输入正确的价格',
            'date_format'=>'日期格式不对',
            'integer'=>'请输入整数',
        ];
        $validator = Validator::make($request->all(), [
            'msg_type' => 'required',
            'msg_title' => 'required',
            'msg_content' => 'required',
        ],$rules);
        if ($validator->fails()) {
            //print_r($validator->fails());die;
            return redirect('user/messageList')
                ->withErrors($validator)
                ->withInput();
        }else {
            $user = Auth::user();
            $feedback = new FeedBack();
            $feedback->user_id = $user->user_id;
            $feedback->user_name = $user->user_name;
            $feedback->user_email = $user->email;
            $feedback->msg_type = $request->input('msg_type');
            $feedback->msg_title = $request->input('msg_title');
            $feedback->order_id = $request->input('order_id', 0);
            $feedback->msg_time = time();
            $feedback->msg_content = $request->input('msg_content');
            if ($request->hasFile('message_img')) {
                $file = $request->file('message_img');
                if ($file->isValid()) {

                    $extension = $file->getClientOriginalExtension();

                    //$mimeTye = $file->getMimeType();//文件格式

                    $newName = md5(date('ymdhis') . rand(0, 9)) . "." . $extension;

                    $path = $file->move('uploads/feedback', $newName); //图片存放的地址
                    $feedback->message_img = $path->getFilename();
//                if(!$user->save()){
//                    return '图片保存失败';
//                }
                    //print_r($path->getPath());
                }
            }
            if ($feedback->save()) {
                $url = $request->server('HTTP_REFERER');
                return view('message')->with(messageSys('发布留言成功！', $url, [
                    [
                        'url' => $url,
                        'info' => '返回留言列表',
                    ],
                ]));
            }
        }
    }
    /*
     * 删除留言
     */
    public function msgDelete(Request $request){
        $user = Auth::user();
        $id = $request->input('id');
        $feedback = FeedBack::select('user_id','message_img','msg_id')->findOrfail($id);
        $this->authorize('update-post',$feedback);
        if($feedback->delete()){
            @unlink(public_path() . '/uploads/feedback/' . $feedback->message_img);
            $url = $request->server('HTTP_REFERER');
            return view('message')->with(messageSys('删除留言成功！',$url,[
                [
                    'url'=>$url,
                    'info'=>'返回留言列表',
                ],
            ]));
        }
    }
    /*
     * 我的求购
     */
    public function buyList(){
        $user = Auth::user();
        $buyList = Buy::where('buy_username',$user->user_name)
            ->Paginate(10);
        $this->arr['action'] = 'buyList';
        $this->arr['pages'] = $buyList;
        $this->arr['pages'] = $buyList;
        return view('buyList')->with($this->arr);
    }
    /*
     * 增加求购页面
     */
    public function buyNew(){
        $user = Auth::user();
        $this->arr['action'] = 'buyList';
        $this->arr['submitText'] = '增加求购';
        return view('buyNew')->with($this->arr);
    }
    /*
     * 修改求购页面
     */
    public function buyUpdate(Request $request){
        $user = Auth::user();
        $id = $request->input('id');
        $buy = Buy::where('buy_username',$user->user_name)->where('buy_id',$id)->first();
        $this->arr['action'] = 'buyList';
        $this->arr['submitText'] = '修改求购';
        $this->arr['buy'] = $buy;
        return view('buyNew')->with($this->arr);
    }
    /*
     * 增加求购到数据库
     */
    public function buyCreate(Request $request){
        $rules = [
            'required'=>'不能为空',
            'numeric'=>'请输入正确的价格',
            'date_format'=>'日期格式不对',
            'integer'=>'请输入整数',
        ];
        $validator = Validator::make($request->all(), [
            'buy_name' => 'required',
            'buy_tel' => 'required',
            'buy_goods' => 'required',
            'product_name' => 'required',
            'buy_spec' => 'required',
            'buy_number' => 'required|integer',
            'buy_price' => 'required|numeric',
            'buy_time' => 'required|date_format:Y.m.d',
        ],$rules);
        //$messages = $validator->errors();
        //print_r($messages->get('password'));die;
        if ($validator->fails()) {
            //print_r($validator->fails());die;
            return redirect('user/buyNew')
                ->withErrors($validator)
                ->withInput();
        }else{
            $buy_id = $request->input('buy_id');
            $user = Auth::user();
            $buy = Buy::findOrNew($buy_id);
            if($buy->buy_id) {
                $this->authorize('update-post',$buy);
            }
            $buy->buy_username = $user->user_name;
            $buy->buy_name = $request->input('buy_name');
            $buy->buy_tel = $request->input('buy_tel');
            $buy->buy_goods = $request->input('buy_goods');
            $buy->product_name = $request->input('product_name');
            $buy->buy_spec = $request->input('buy_spec');
            $buy->buy_number = $request->input('buy_number');
            $buy->buy_price = $request->input('buy_price');
            $buy->buy_time = $request->input('buy_time');
            $buy->message = $request->input('message');
            $buy->buy_addtime = time();
            if($buy->save()){
                if($buy_id==0){
                    $message = "增加求购信息成功!";
                }else{
                    $message = "修改求购信息成功!";
                }
                return view('message')->with(messageSys($message,route('user.buyList'),[
                    [
                        'url'=>route('user.buyList'),
                        'info'=>'返回求购列表',
                    ],
                ]));
            }
        }
    }
    /*
     * 注册成功跳转页面
     */
    public function regMsg(){
        $assign = [
            'title'=>'系统提示',
            'user'=>auth()->user(),
        ];
        return view('auth.message')->with($assign);
    }

    /**
     * 充值余额使用记录
     */
    public function czjl(){
        $arr = $this->arr;
        $user = auth()->user();
        $user_jnmj = UserJnmj::where('user_id',$user->user_id)->first();
        if(!$user_jnmj){
            return view('message')->with(messageSys('您所请求的页面不存在',route('user.buyList'),[
                [
                    'url'=>route('user.buyList'),
                    'info'=>'返回求购列表',
                ],
            ]));
        }
        $jnmj_log = JnmjLog::where('user_id',$user->user_id)
            ->select(DB::raw('*,jnmj_money as change_amount'))
            ->orderBy('log_id','desc')->Paginate(10);
        //dd($jnmj_log);
        $arr['pages'] = $jnmj_log;
        $arr['action'] = '';
        $arr['pages_top'] = '充值余额变动记录';
        $arr['user_jnmj'] = $user_jnmj;
        $arr['page_title'] = '用户中心-';
        $arr['pages_url'] = 'user.czjl';
        $arr['pages_text'] = '<tr><td colspan="4" class="al_right"><p class="balance">您当前的可用充值余额为:'.formated_price($user_jnmj->jnmj_amount).'</p></td></tr>';
        return view('czjl')->with($arr);
    }

    /**
     * 账期额度变动记录
     */
    public function zq_log(){
        $arr = $this->arr;
        $user = auth()->user();
        if($user->is_zq==0){//未开通账期
            return view('message')->with(messageSys('您所请求的页面不存在',route('user.buyList'),[
                [
                    'url'=>route('user.buyList'),
                    'info'=>'返回求购列表',
                ],
            ]));
        }
        $zq_log = ZqLog::where('user_id',$user->user_id)->where('change_amount','>',0)
            ->orderBy('log_id','desc')->Paginate(10);
        $arr['pages'] = $zq_log;
        $arr['action'] = 'zq_log';
        $arr['pages_top'] = '账期变动记录';
        $arr['page_title'] = '用户中心-';
        $arr['pages_url'] = 'user.zq_log';
        $arr['pages_text'] = '<tr><td colspan="4" class="al_right"><p class="balance">您当前的账期剩余额度为:'.formated_price($user->zq_je-$user->zq_amount).'</p></td></tr>';
        return view('czjl')->with($arr);
    }

    /**
     * 账期汇总订单
     */
    public function zq_order(){
        $arr = $this->arr;
        $user = auth()->user();
        if($user->is_zq==0){//未开通账期
            return view('message')->with(messageSys('您所请求的页面不存在',route('user.buyList'),[
                [
                    'url'=>route('user.buyList'),
                    'info'=>'返回求购列表',
                ],
            ]));
        }
        $zq_order = ZqOrder::where('user_id',$user->user_id)->where('order_status','!=',2)->orderBy('zq_id','desc')->Paginate(10);
        $arr['pages'] = $zq_order;
        $arr['action'] = 'zq_order';
        $arr['pages_top'] = '账期汇总订单列表';
        $arr['page_title'] = '用户中心-';
        $arr['pages_url'] = 'user.zq_order';
        $arr['pages_text'] = '<tr><td colspan="4" class="al_right"><p class="balance">您当前的账期剩余额度为:'.formated_price($user->zq_je-$user->zq_amount).'</p></td></tr>';
        return view('zq_order')->with($arr);

    }

    /**
     * 账期汇总订单详情
     */
    public function zq_order_info(Request $request){
        $arr = $this->arr;
        $user = auth()->user();
        $id = intval($request->input('id',0));
        if($user->is_zq==0){//未开通账期
            return view('message')->with(messageSys('您所请求的页面不存在',route('user.buyList'),[
                [
                    'url'=>route('user.buyList'),
                    'info'=>'返回求购列表',
                ],
            ]));
        }
        $zq_order = ZqOrder::with([
            'order_info'=>function($query){
                $query->select('zq_id','order_amount','order_id','goods_amount','order_sn','add_time','order_status','pay_status','shipping_status');
            }
        ])->where('user_id',$user->user_id)->where('zq_id',$id)->first();
        if(!$zq_order){
            return view('message')->with(messageSys('您所请求的页面不存在',route('user.buyList'),[
                [
                    'url'=>route('user.buyList'),
                    'info'=>'返回求购列表',
                ],
            ]));
        }
        if($zq_order->pay_status!=2&&$zq_order->order_status==1&&$zq_order->order_amount>0){
            //银联支付
            $user = auth()->user();
            $payment_info = Payment::where('pay_id',4)->where('enabled',1)->first();
            $payment = unserialize_config($payment_info->pay_config);
            //dd($payment);
            $order['user_name'] = $user->user_name;
            $order['pay_desc'] = $payment_info->pay_desc;
            $order['order_amount'] = $zq_order->order_amount;
            $order['order_id'] = $zq_order->zq_id;
            $order['order_sn'] = $zq_order->order_sn;
            $pay_obj = new upop();
            $unionpay = $pay_obj->get_code($order, $payment);
            $abcpay = '<form style="text-align:center;width:50px;display:inline-block;" name="pay_form" action="'.route('abc.pay').'" method="get" target="_blank">
                <input class="J_payonline" style="left: 250px;;" value="农行支付" type="submit">
                <input value="'.$zq_order->zq_id.'" name="id" type="hidden">
                <input value="'.route('abc.search',['id'=>$zq_order->zq_id]).'" type="hidden" id="searchUrl">
                </form>';
            $arr['unionpay'] = $unionpay;
            $arr['abcpay'] = $abcpay;
        }
        $arr['order'] = $zq_order;
        $arr['action'] = 'zq_order';
        $arr['pages_top'] = '账期汇总订单详情';
        $arr['page_title'] = '用户中心-';
        //dd($arr);
        return view('zq_order_info')->with($arr);

    }
}