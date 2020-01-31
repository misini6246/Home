<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/22
 * Time: 10:53
 */
use App\ArticleCat;
use App\ZqLog;
use App\ZqLogYwy;
use App\ZqOrder;
use App\ZqYwy;
use App\UserJnmj;
use App\Cart;
use App\Nav;
use App\Category;
use App\FriendLink;
use App\ShopConfig;
use App\Goods;
use App\User;
use App\OrderInfo;
use App\OrderGoods;
use App\Brand;
use App\GoodsGallery;
use App\GoodsAttr;
use App\JnmjLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\UserAddress;
use App\Region;
use App\AccountLog;
use Illuminate\Support\Facades\Cache;
use App\OrderAction;
use App\Attribute;
use App\Ad;
use Illuminate\Support\Facades\Redis;
use App\ZqAction;
use App\ZqActionYwy;

//获取广告
function ads($position_id,$type=false){

    $tags = date("Y-m-d",time());

    $ads = Cache::tags(['shop', 'ad',$tags])->remember($position_id, 60, function () use ($position_id, $type) {
        return Ad::get_ads($position_id, $type);
    });


    if($ads){
        if(!$type){
            foreach($ads as $v){
                $v->ad_code = get_img_path('data/afficheimg/'.$v->ad_code);
            }
        }else{
            $ads->ad_code = get_img_path('data/afficheimg/'.$ads->ad_code);
        }
    }

    return $ads;
}
//获取广告
function ads_yl($time,$position_id,$type=false){
    $query = Ad::where('start_time','<',$time)->where('end_time','>',$time)->where('position_id',$position_id)
        ->select('position_id','ad_id','ad_name','ad_code','start_time','ad_link','end_time','ad_bgc')
        ->orderBy('sort_order','desc')->orderBy('ad_id','desc');
    if($type){
        $ads = $query->first();
    }else{
        $ads = $query->get();
    }
    if($ads){
        if(!$type){
            foreach($ads as $v){
                $v->ad_code = get_img_path('data/afficheimg/'.$v->ad_code);
            }
        }else{
            $ads->ad_code = get_img_path('data/afficheimg/'.$ads->ad_code);
        }
    }

    return $ads;
}
//获取文章列表
/*
 * @take 获取的数量
 */
function articles($cat_id,$take=8){
    $article = Cache::tags(['shop','articles'])->remember($cat_id.$take,60,function()use($cat_id,$take){
        return ArticleCat::with(['article'=>function($query)use($take){
            $query->where('is_open',1)->orderBy('article_type','desc')->orderBy('article_id','desc')
                ->select('cat_id','title','article_id','file_url','open_type','add_time','keywords')
                ->take($take);
        }])->where('cat_id',$cat_id)
            ->select('cat_id','cat_name','sort_order')
            ->first();
    });
    return $article;
}
//member_info
function member_info(){
    $user_info = auth()->user();
    return view('layout.member_info')->with('user_info',$user_info);
}
//cart_info
function cart_info($type=1){
    $cart_info = 0;
    if(Auth::check()) {
        $user = Auth::user();
        $cart_info = Cart::where('user_id', $user->user_id)->where('goods_id','!=',0)->count('rec_id');
        if($type==1) {
            $ms = new \App\Http\Controllers\MiaoShaController();
            $ms_goods = $ms->get_cart_goods();
            $cart_info += count($ms_goods);
        }
        Cache::tags([$user->user_id,'cart'])->forever('num',$cart_info);
    }
    return $cart_info;
}
//nav
function nav_list($type,$dis=0){
    $nav_list = Cache::tags(['shop','navList'])->rememberForever($type,function()use($type){
        return Nav::where('ifshow',1)->where('type',$type)
            ->select('name','url','opennew','id')
            ->orderBy('type')->orderBy('vieworder')
            ->get();
    });
    foreach ($nav_list as $v){
        if($dis==-1&&$v->id==29){
            $v->is_checked = 1;
        }
        if($dis==1&&$v->id==26){
            $v->is_checked = 1;
        }
        if($dis==2&&$v->id==18){
            $v->is_checked = 1;
        }
        if($dis==3&&$v->id==44){
            $v->is_checked = 1;
        }
        if($dis==11&&$v->id==28){
            $v->is_checked = 1;
        }
        if($dis==='a'&&$v->id==47){
            $v->is_checked = 1;
        }
        if($dis==12&&$v->id==48){
            $v->is_checked = 1;
        }
        if(18==$v->id){
            $v->is_hot = 1;
        }
    }
    //dd($nav_list);
    return $nav_list;
}
//导航栏check
function navChecked($dis,$py=0){
    $arr = [
        1=>'中西成药',
        2=>'精品专区',
        3=>'品牌专区',
        4=>'中药饮片',
        5=>'保健食品',
        6=>'器械.计生',
        7=>'厂家直供',
        8=>'国/川.基药',
        9=>'进口.合资',
        10=>'促销专区',
        'a'=>'控销专区',
    ];
    if(!isset($arr[$dis])){
        return '商品搜索';
    }
    if($py==1){
        return '普药';
    }
    //print_r($dis);die;
    return $arr[$dis];
}

//分类树
function cate_tree($cat_id){
    $cate_tree = Cache::tags(['shop','cate_tree'])->rememberForever($cat_id,function()use($cat_id){
        return Category::where('parent_id',$cat_id)->where('is_show',1)
            ->select('cat_id','cat_name','parent_id','is_show')
            ->orderBy('sort_order','desc')->orderBy('cat_id','desc')
            ->get();
    });
    return $cate_tree;
}
//友情链接
function friend_link($type){
    $friend_link = Cache::tags(['shop','friendLink'])->rememberForever($type,function(){
        return FriendLink::select('link_logo','link_name','link_url')
            ->orderBy('show_order')
            ->get();
    });
    $arr = array();
    foreach($friend_link as $k=>$v){
        if(!empty($v->link_logo)){
            $v->link_logo = get_img_path($v->link_logo);
            $arr['img'][] = $v;
        }else{
            $arr['txt'] = $v;
        }
    }
    if($type=='img'){
        return $arr['img'];
    }else {
        return $arr['txt'];
    }
}
//商店帮助
function shop_help(){
    $shop_help = Cache::tags(['shop','shopHelp'])->rememberForever('shopHelp',function(){
        return ArticleCat::with(['article'=>function($query){
            $query->where('is_open',1)->orderBy('article_id')
                ->select('cat_id','title','article_id','file_url','open_type')
                ->take(16);
        }])->where('cat_type',5)
            ->select('cat_id','cat_name','sort_order')
            ->orderBy('sort_order')
            ->get();
    });
    return $shop_help;
}


/*
 * 判断商品是否在促销期
 * @shop_price
 * @promote_price
 */
function is_promote($shop_price,$promote_price,$start,$end,$flag){
    $time = time();
    if(!$flag) {
        if ($time >= $start && $time <= $end) {
            return $promote_price;
        } else {
            return $shop_price;
        }
    }else{
        return $shop_price;
    }
}
/*
 * 判断限购
 */
function goodsXg(){

}
/*
 * ajax返回值处理
 */
function ajaxReturn($error,$message){
    $result = array();
    $result['error'] = $error;
    $result['message'] = $message;
    return $result;
}
/*
 * 格式化价格
 * @price 价格
 */
function formated_price($price){
    return '￥'.sprintf('%.2f',$price);
}
/*
 * 分页参数处理
 * @page 页码
 * @params 参数
 */
function pageParams($page,$params=[]){
    $params['page'] = $page;
    $url = $params['url'];
    unset($params['url']);
    return route($url,$params);
}
/*
 * 系统提示
 * @content 提示内容
 * @backUrl 自动返回路径
 * @messageInfo 额外信息
 */
function messageSys($content,$backUrl='',$messageInfo=''){
    return [
        'page_title'=>'系统提示',
        'messageInfo'=>$messageInfo,
        'content'=>$content,
        'backUrl'=>$backUrl,
        'middle_nav'=>nav_list('middle'),
    ];
}
/*
 * 上传图片
 * @file 图片信息
 * @path 保存路径
 */
function uploadImg($file,$path){
    if($file->isValid()){

        $extension = $file->getClientOriginalExtension();

        //$mimeTye = $file->getMimeType();//文件格式

        $newName = md5(date('ymdhis').rand(0,9)).".".$extension;

        $result = $file->move($path,$newName); //图片存放的地址
//                if(!$user->save()){
//                    return '图片保存失败';
//                }
        //print_r($path->getPath());
        return $result;
    }
    return 0;
}
/*
 * 打印print
 */
function llPrint($result,$style=1){
    if($style==1){
        print_r($result);
        print_r('</br>');
    }else{
        print_r($result->toArray());
        print_r('</br>');
    }
    die;
}
/*
 * 一周销量排行榜
 */
function weekSales($num=10){
    $goods = Goods::orderBy('sales_volume','desc')
        ->where('is_on_sale','=',1)->where('is_alone_sale',1)->where('is_delete',0)
        ->select('goods_id')
        ->take($num)->get();
    return $goods;
}
/*
 * 为您推荐
 */
function wntj($num=10){
    $ids = Cache::tags(['shop','wntj'])->rememberForever($num,function()use($num){
        return Goods::wntj($num);
    });
    $wntj = [];
    $user = auth()->user();
    foreach($ids as $k=>$v) {
        $val = Redis::ZRANGEBYSCORE('goods_list', $v, $v);
        if (empty($val)) {
            $goods = Goods::goods_info($v);
            Redis::zadd('goods_list', $v, serialize($goods));
        } else {
            $goods = unserialize($val[0]);
        }
        $goods = Goods::attr($goods,$user);
        $wntj[$k] = $goods;
    }
    return $wntj;
}
/*
 * 截取html内容
 */
function cutstr_html($string, $sublen)
{
    $string = strip_tags($string);
    $string = preg_replace ('/\n/is', '', $string);
    $string = preg_replace ('/ |　/is', '', $string);
    $string = preg_replace ('/&nbsp;/is', '', $string);

    preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $t_string);
    if(count($t_string[0]) - 0 > $sublen) $string = join('', array_slice($t_string[0], 0, $sublen))."…";
    else $string = join('', array_slice($t_string[0], 0, $sublen));

    return $string;
}

/*
 * 收货地址(单个)
 * @user 用户
 * @addressId 地址id
 */
function address($user,$addressId=0){
    $address = UserAddress::with([
        'regionCountry'=>function($query){
            $query->select('region_id','region_name');
        },
        'regionProvince'=>function($query){
            $query->select('region_id','region_name');
        },
        'regionCity'=>function($query){
            $query->select('region_id','region_name');
        },
        'regionDistrict'=>function($query){
            $query->select('region_id','region_name');
        }
    ])->where(function($query)use($user,$addressId){
        $query->where('user_id',$user->user_id);
        if($addressId!=0){
            $query->where('address_id',$addressId);
        }
    })->select('country','province','city','district','address','tel',
        'email','consignee','address_id','zipcode','mobile','best_time')->first();
    $address->full_address = '';
    if($address->regionCountry){
        $address->full_address .= $address->regionCountry->region_name.' ';
    }else{
        $address->full_address .= '中国 ';
    }
    if($address->regionProvince){
        $address->full_address .= $address->regionProvince->region_name.' ';
    }
    if($address->regionCity){
        $address->full_address .= $address->regionCity->region_name.' ';
    }
    if($address->regionDistrict){
        $address->full_address .= $address->regionDistrict->region_name.' ';
    }
    return $address;
}
/*
 * 收货地址(所有)
 */
function addressAll($user,$addressId=0){
    $address = UserAddress::with([
        'regionCountry'=>function($query){
            $query->select('region_id','region_name');
        },
        'regionProvince'=>function($query){
            $query->select('region_id','region_name');
        },
        'regionCity'=>function($query){
            $query->select('region_id','region_name');
        },
        'regionDistrict'=>function($query){
            $query->select('region_id','region_name');
        }
    ])->where(function($query)use($user,$addressId){
        $query->where('user_id',$user->user_id);
        if($addressId!=0){
            $query->where('address_id','!=',$addressId);
        }
    })->select('country','province','city','district','address','tel',
        'email','consignee','address_id','zipcode','mobile','best_time')->get();
    return $address;
}
/*
 * 获取省/市/县
 * @type 1省,2市,3县
 */
function getRegion($type=1){
    $region = Cache::tags(['shop','regions'])->rememberForever($type,function()use($type){
        return Region::where('parent_id',$type)->where('region_type',$type)->get();
    });
    return $region;
}
/**
 * 得到新订单号
 * @return  string
 */
function getOrderSn()
{
    /*
     * 获取订单号，确保订单号唯一
     */
    $is_order_exist = true ; //标识，默认订单号已经存在
    $order_sn = '' ;
    do {
        $order_sn = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $count = OrderInfo::where('order_sn',$order_sn)->where('order_id','>',205864)->count();
        if(empty($count)) {
            //如果计数为0
            $is_order_exist = false ;
        }
    } while($is_order_exist) ;
    /* 选择一个随机的方案 */
    //mt_srand((double) microtime() * 1000000);
    //return date('YmdHis', time()).mt_rand(10, 99) ;
    return $order_sn ;
}
/**
 * 记录帐户变动
 * @param   int     $user_id        用户id
 * @param   float   $user_money     可用余额变动
 * @param   float   $frozen_money   冻结余额变动
 * @param   int     $rank_points    等级积分变动
 * @param   int     $pay_points     消费积分变动
 * @param   string  $change_desc    变动说明
 * @param   int     $change_type    变动类型：参见常量文件
 * @return  void
 */
function log_account_change($user_id, $user_money = 0, $frozen_money = 0, $rank_points = 0, $pay_points = 0, $change_desc = '', $change_type = 99)
{
    $account_log = new AccountLog();
    $account_log->user_id = $user_id;
    $account_log->user_money = $user_money;
    $account_log->frozen_money = $frozen_money;
    $account_log->rank_points = $rank_points;
    $account_log->pay_points = $pay_points;
    $account_log->change_time = time();
    $account_log->change_desc = $change_desc;
    $account_log->change_type = $change_type;
    DB::transaction(function()use($account_log,$user_id){
        /* 插入帐户变动记录 */
        $account_log->save();
        /* 更新用户信息 */
        $user = User::find($user_id);
        $user->user_money = $user->user_money + $account_log->user_money;
        $user->frozen_money = $user->frozen_money + $account_log->frozen_money;
        $user->rank_points = $user->rank_points + $account_log->rank_points;
        $user->pay_points = $user->pay_points + $account_log->pay_points;
        $user->save();
    });
}

function log_account_change_type($user_id, $user_money = 0, $frozen_money = 0, $rank_points = 0, $pay_points = 0, $change_desc = '', $change_type = 99,$money_type=0,$order_id=0)
{
    $account_log = new AccountLog();
    $account_log->user_id = $user_id;
    $account_log->user_money = $user_money;
    $account_log->frozen_money = $frozen_money;
    $account_log->rank_points = $rank_points;
    $account_log->pay_points = $pay_points;
    $account_log->change_time = time();
    $account_log->change_desc = $change_desc;
    $account_log->change_type = $change_type;
    $account_log->money_type = $money_type;
    $account_log->order_id = $order_id;
    DB::transaction(function()use($account_log,$user_id){
        /* 插入帐户变动记录 */
        $account_log->save();
        /* 更新用户信息 */
        $user = User::find($user_id);
        $user->user_money = $user->user_money + $account_log->user_money;
        $user->frozen_money = $user->frozen_money + $account_log->frozen_money;
        $user->rank_points = $user->rank_points + $account_log->rank_points;
        $user->pay_points = $user->pay_points + $account_log->pay_points;
        $user->save();
    });
}

/*
 * 格式化小数
 * @type 0 四舍五入 1 向上取整 2向下取整
 */
function numFormat($num,$type=0){
    if($type==0){
        return round($num,2);
    }
}
/**
 * 记录订单操作记录
 *
 * @access  public
 * @param   string  $order_sn           订单编号
 * @param   integer $order_status       订单状态
 * @param   integer $shipping_status    配送状态
 * @param   integer $pay_status         付款状态
 * @param   string  $note               备注
 * @param   string  $username           用户名，用户自己的操作则为 buyer
 * @return  void
 */
function order_action($order, $note = '', $user_name, $place = 0)
{
    $orderAction = new OrderAction();
    $orderAction->order_id = $order->order_id;
    $orderAction->action_user = $user_name;
    $orderAction->order_status = $order->order_status;
    $orderAction->shipping_status = $order->shipping_status;
    $orderAction->pay_status = $order->pay_status;
    $orderAction->action_place = $place;
    $orderAction->action_note = $note;
    $orderAction->log_time = time();
    return $orderAction->save();
}

/**
 * 记录订单操作记录
 *
 * @access  public
 * @param   string  $order_sn           订单编号
 * @param   integer $order_status       订单状态
 * @param   integer $shipping_status    配送状态
 * @param   integer $pay_status         付款状态
 * @param   string  $note               备注
 * @param   string  $username           用户名，用户自己的操作则为 buyer
 * @return  void
 */
function order_action_zq($order, $note = '', $user_name, $place = 0)
{
    $orderAction = new ZqAction();
    $orderAction->order_id = $order->zq_id;
    $orderAction->action_user = $user_name;
    $orderAction->order_status = $order->order_status;
    $orderAction->pay_status = $order->pay_status;
    $orderAction->action_note = $note;
    $orderAction->action_place = $place;
    $orderAction->log_time = time();
    return $orderAction->save();
}
function order_action_zq_ywy($order, $note = '', $user_name, $place = 0)
{
    $orderAction = new ZqActionYwy();
    $orderAction->order_id = $order->zq_id;
    $orderAction->action_user = $user_name;
    $orderAction->order_status = $order->order_status;
    $orderAction->pay_status = $order->pay_status;
    $orderAction->action_note = $note;
    $orderAction->action_place = $place;
    $orderAction->log_time = time();
    return $orderAction->save();
}
function order_action_zq_sy($order, $note = '', $user_name, $place = 0)
{
    $orderAction = new \App\ZqActionSy();
    $orderAction->order_id = $order->zq_id;
    $orderAction->action_user = $user_name;
    $orderAction->order_status = $order->order_status;
    $orderAction->pay_status = $order->pay_status;
    $orderAction->action_note = $note;
    $orderAction->action_place = $place;
    $orderAction->log_time = time();
    return $orderAction->save();
}
/**
 * 运费

 */
function shippingFee($goods_amount,$shipping_id)
{
    $user = auth()->user();
    $shipping_fee = 0;
//    $shipping_id = $user->shipping_id;
//    if(strpos($user->shipping_name,'宅急送')!==false&&$user->shipping_id==-1){
//        $shipping_id = 17;
//    }
    $shipping_area = DB::table('shipping as s')
        ->join('shipping_area as sa','s.shipping_id','=','sa.shipping_id')
        ->join('area_region as ar','sa.shipping_area_id','=','ar.shipping_area_id')
        ->whereIn('ar.region_id',[$user->country,$user->province,$user->city,$user->district])
        ->where('s.shipping_id',$shipping_id)
        ->first();
    //dd($shipping_area);
    if(!empty($shipping_area)) {
        $configure = unserialize($shipping_area->configure);
        if($goods_amount<$configure[1]['value']){
            $shipping_fee = $configure[0]['value'];
        }
    }
    return $shipping_fee;
}
/**
 * 处理序列化的支付、配送的配置参数
 * 返回一个以name为索引的数组
 *
 * @access  public
 * @param   string       $cfg
 * @return  void
 */
function unserialize_config($cfg)
{
    if (is_string($cfg) && ($arr = unserialize($cfg)) !== false)
    {
        $config = array();

        foreach ($arr AS $key => $val)
        {
            $config[$val['name']] = $val['value'];
        }

        return $config;
    }
    else
    {
        return false;
    }
}
/*
 * 分页视图
 */
function pagesView($currentPage,$lastPage,$num1,$num2,$params){
    if(!empty($params)) {
        foreach ($params as $k=>$v) {
            if($v==''){
                unset($params[$k]);
            }
        }
    }
    $pagesForm = pagesForm($currentPage,$lastPage,$params);//当前页面后面所显示的页码数
    $pages = pages($currentPage,$lastPage,$num1,$num2,$params);
    $pages = '
    <div class="listPageDiv">
        <div class="pageList">
            '.$pages.'
        </div>
        '.$pagesForm.'
    </div>
    ';
    return $pages;
}
/*
 * 分页-跳转页面form
 */
function pagesForm($currentPage,$lastPage,$params){
    $input = '';
    if($lastPage>1) {
        foreach ($params as $k => $v) {
            if ($k !== 'url') {
                $input .= '<input value="' . $v . '" name="' . $k . '" type="hidden">';
            }
        }
        $input = '<form action="' . pagesUrl(0, $params) . '" type="get" class="submit_input" onsubmit="return lastPage()">
        <span>共' . $lastPage . '页</span>
        <span>到第<input name="page" class="page_inout" value="' . $currentPage . '" type="text" id="currentPage">页</span>
        <input value="确定" class="submit" type="submit">
        <input value="'.$lastPage.'" type="hidden" id="lastPage">
        ' . $input . '
    </form>';
    }else{
        $input = '<span>共' . $lastPage . '页</span>';
    }
    return $input;
}
/*
 * 分页-主体
 */
function pages($currentPage,$lastPage,$num1,$num2,$params){
    $pages = '';
    if($lastPage>1) {
        if ($currentPage - $num1 > 1) {//不能看到第一页 显示第一页
            $pages .= '<span class="p1"><a href="' . pagesUrl(1, $params) . '">第一页</a></span>';
        }
        if ($currentPage > 1) {//当前不是第一页 显示上一页
            $pages .= '<span class="p1"><a href="' . pagesUrl($currentPage - 1, $params) . '">上一页</a></span>';
        }
        if ($currentPage > $lastPage - $num2) {
            for ($i = $currentPage - $num1 - ($currentPage - $lastPage + $num2); $i < $currentPage; $i++) {
                if ($i > 0) {
                    $pages .= '<span class="p1"><a href="' . pagesUrl($i, $params) . '">' . $i . '</a></span>';
                }
            }
        } else {
            for ($i = $currentPage - $num1; $i < $currentPage; $i++) {
                if ($i > 0) {
                    $pages .= '<span class="p1"><a href="' . pagesUrl($i, $params) . '">' . $i . '</a></span>';
                }
            }
        }
        $pages .= '<span class="p1 p_ok">' . $currentPage . '</span>';
        if ($currentPage < $num2 + 1) {
            for ($i = $currentPage + 1; $i < $num1 + $num2 + 2; $i++) {
                if ($i <= $lastPage) {
                    $pages .= ' <span class="p1"><a href="' . pagesUrl($i, $params) . '">' . $i . '</a></span>';
                }
            }
        } else {
            for ($i = $currentPage + 1; $i < $currentPage + $num2 + 1; $i++) {
                if ($i <= $lastPage) {
                    $pages .= '<span class="p1"><a href="' . pagesUrl($i, $params) . '">' . $i . '</a></span>';
                }
            }
        }
        if ($currentPage < $lastPage) {//当前不是最末页 显示下一页
            $pages .= '<span class="p1"><a href="' . pagesUrl($currentPage + 1, $params) . '">下一页</a></span>';
        }
        if ($currentPage + $num2 < $lastPage) {//不能看到最末页 显示最末页
            $pages .= '<span class="p1"><a href="' . pagesUrl($lastPage, $params) . '">最末页</a></span>';
        }
    }
    return $pages;
}
/*
 * 分页-链接
 */
function pagesUrl($currentPage,$params=[]){
    if($currentPage!=0) {
        $params['page'] = $currentPage;
    }
    $url = $params['url'];
    unset($params['url']);
    return route($url,$params);
}
/*
 * 商店配置
 */
function shopConfig($code){
    Cache::tags(['shop', 'config'])->flush();
    dd(1);
    return Cache::tags(['shop','config'])->rememberForever($code,function()use($code){
        return ShopConfig::where('code',$code)->pluck('value');
    });
}
/*
 * attribute
 */
function attribute(){
    return Cache::tags(['shop','attribute'])->rememberForever('all',function(){
        $attribute =  Attribute::select('attr_id','attr_name')->get();
        $arr = [];
        foreach($attribute as $v){
            $arr[$v->attr_id] = $v->attr_name;
        }
        return $arr;
    });
}
/*
 * redis缓存数据
 * @type=true 将传入的数据一并返回
 */
function get_goods($ids,$type=false){
    $user = auth()->user();
    foreach($ids as $k=>$v) {
        $val = Redis::ZRANGEBYSCORE('goods_list', $v->goods_id, $v->goods_id);
        if (empty($val)) {
            $goods = Goods::goods_info($v->goods_id);
            Redis::zadd('goods_list', $v->goods_id, serialize($goods));
        } else {
            $goods = unserialize($val[0]);
        }
        $goods = Goods::attr($goods,$user);
        if($type==true) {
            $v->goods = $goods;
        }else{
            $ids[$k] = $goods;
        }
    }
    return $ids;
}

/**
 * 取出redis缓存商品
 */
function goods_list($user,$ids,$row=0,$name='goods_list',$type=false){
    if($row==0) {
        foreach ($ids as $k => $v) {
            $val = Redis::ZRANGEBYSCORE($name, $v->goods_id, $v->goods_id);
            if (empty($val)) {
                $goods = Goods::goods_info($v->goods_id);
                if($goods) {
                    Redis::zadd($name, $v->goods_id, serialize($goods));
                }
            } else {
                $goods = unserialize($val[0]);
            }
            $goods = Goods::attr($goods,$user);
            if ($type == true) {
                $v->goods = $goods;
            } else {
                $ids[$k] = $goods;
            }
        }
    }else{
        $val = Redis::ZRANGEBYSCORE($name, $ids, $ids);
        if (empty($val)) {
            $goods = Goods::goods_info($ids);
            Redis::zadd($name, $ids, serialize($goods));
        } else {
            $goods = unserialize($val[0]);
        }
        $goods = Goods::attr($goods,$user);
        $ids = $goods;
    }
    return $ids;
}


/**
 * @param $user
 * @return bool
 */

function jpzq($user){
    $start_time = "2016-04-01 00:00:00";
    $end_time   = "2016-10-01 00:00:00";
    $is_jpzq_activity = false;
    $active_start = strtotime($start_time);
    $active_end = strtotime($end_time);

    $new_time = time() ;
    if($new_time >= $active_start && $new_time < $active_end && in_array($user->user_rank, array('1', '2', '5', '7'))){
        $is_jpzq_activity = true;
    }
    return $is_jpzq_activity;
}

/**
 * @param $fine_total_amount
 * @return int
 */
function check_jpzq($fine_total_amount)
{
    $cat_id = 0;
    if($fine_total_amount >= 600 && $fine_total_amount < 1200){
        $cat_id = 1;
    }
    if($fine_total_amount >= 1200 && $fine_total_amount < 1800){
        $cat_id = 2;
    }
    if($fine_total_amount >= 1800 && $fine_total_amount < 2400){
        $cat_id = 3;
    }
    if($fine_total_amount >= 2400 && $fine_total_amount < 3000){
        $cat_id = 4;
    }
    if($fine_total_amount >= 3000){
        $cat_id = 5;
    }
    return $cat_id;
}

/**
 * @param $user_id
 * @param int $order_amount
 * @return array
 */
function check_zq_l($user,$order_amount=0){
    $result = array(
        'error'=>0,
        'message'=>''
    );
    if($user->is_zq==0&&($user->zq_has==1||$user->zq_amount>0)){
        $result['error'] = 1;
        $result['message'] = '合纵线下账期款项未结清,请结清后再购买';
    }
    elseif(($user->zq_start_date>time()||$user->zq_end_date<time())&&$user->is_zq==1){//账期合同生效范围外
        $user->is_zq = 0;
        $user->save();
        log_zq_change($user,0,0,"账期合同未生效");
        $result['error'] = 2;
    }
    else {
        if ($user->is_zq == 1) {//账期用户
            if (isset($user->hz_zq) && $user->hz_zq == 1) {//合纵线下账期未结算
                $result['error'] = 1;
                $result['message'] = '合纵线下账期款项未结清,请结清后再购买';
            }
            elseif ($user->zq_rq <= date('d') && $user->zq_has == 1) {//超过账期结算日期,而且没有结算上月款项

                $zq_rq = strtotime(date("Y-m-").$user->zq_rq) + 3600*24*10;//这个月的账期还款截止日期
                $time = strtotime(date("Y-m-").$user->zq_rq);
                $now = time();
                if($now>$zq_rq) {//这个月还款日期超过了
                    $count = OrderInfo::where('is_zq',1)->where('pay_status',0)->where('order_status',1)->where('user_id',$user->user_id)->where('add_time','<',$time)->count();
                }else{
                    $prev = strtotime(date("Y-m-",strtotime("-1 month")).$user['zq_rq']);//上个月结账日期
                    $count = OrderInfo::where('is_zq',1)->where('pay_status',0)->where('order_status',1)->where('user_id',$user->user_id)->where('add_time','<',$prev)->count();
                }
                if ($count == 0) {//上月已结清
                    $user->zq_has = 0;
                    $user->save();
                }else {

                    $result['error'] = 1;
                    $result['message'] = '上月款项未结清,请结清后再购买';

                }
            }
            elseif (($order_amount + $user->zq_amount) > $user->zq_je) {//超出额度
                $result['error'] = 1;
                $result['message'] = '已超出账期额度,请提升额度后再购买';

            }
        }
    }
    return $result;
}
function check_zq($user,$order_amount=0){
    $result = array(
        'error'=>0,
        'message'=>''
    );
    if($user->is_zq==0&&($user->zq_has==1||$user->zq_amount>0)){
        $result['error'] = 1;
        $result['message'] = '合纵线上账期款项未结清,请结清后再购买';
    }
    if(($user->zq_start_date>time()||$user->zq_end_date<time())&&$user->is_zq==1){//账期合同生效范围外
        $user->is_zq = 0;
        $user->save();
        log_zq_change($user,0,0,"账期合同未生效");
        $result['error'] = 2;
    }else {
        if ($user->is_zq == 1) {//账期用户
            if (isset($user->hz_zq) && $user->hz_zq == 1) {//合纵线下账期未结算
                $result['error'] = 1;
                $result['message'] = '合纵线下账期款项未结清,请结清后再购买';
            }
            if ($user->zq_has == 1) {//超过账期结算日期,而且没有结算上月款项
                if($user->user_id==13960) {
                    $zq_rq = strtotime(date("Y-m-") . $user->zq_rq) + 3600 * 24 * 10;//这个月的账期还款截止日期
                    $time = strtotime(date("Y-m-") . $user->zq_rq);
                    $now = time();
                    $count = 1;
                    if ($now > $zq_rq) {//这个月还款日期超过了
                        $count = OrderInfo::where('user_id',$user->user_id)->where('is_zq',1)->where('order_status',1)->where('pay_status',0)->where('add_time','<',$time)->count();
                    } else {
                        $month = date('m') - 1;
                        $month_old = date('m') - 2;
                        $year = date("Y");
                        $prev = $year . "-" . $month . "-" . $user->zq_rq;
                        $prev_old = $year . "-" . $month_old . "-" . $user->zq_rq;
                        $prev = strtotime($prev) + 3600 * 24 * 11;//上个月的账期还款截止日期
                        $prev_old = strtotime($prev_old) + 3600 * 24 * 11;//上上个月的账期还款截止日期
                        if ($now > $prev) {
                            $prev = $prev - 3600 * 24 * 10;
                            $count = OrderInfo::where('user_id',$user->user_id)->where('is_zq',1)->where('order_status',1)->where('pay_status',0)->where('add_time','<',$prev)->count();
                        } elseif ($now > $prev_old) {
                            $prev_old = $prev_old - 3600 * 24 * 10;
                            $count = OrderInfo::where('user_id',$user->user_id)->where('is_zq',1)->where('order_status',1)->where('pay_status',0)->where('add_time','<',$prev_old)->count();
                        }
                    }
                    if ($count == 0) {
                        $user->zq_has = 0;
                        $user->save();
                    } else {

                        $result['error'] = 1;
                        $result['message'] = '上月款项未结清,请结清后再购买1';
                    }
                }else {
                    $result['error'] = 1;
                    $result['message'] = '上月款项未结清,请结清后再购买';
                }
            }
            if (($order_amount + $user->zq_amount) > $user->zq_je) {//超出额度
                $result['error'] = 2;
                $result['message'] = '已超出账期额度,请提升额度后再购买';

            }
        }
    }
    return $result;
}

/**
 * @param $user
 * @param $change_je
 * @param $change_amount
 * @param $change_desc
 * @param int $change_type
 */
function log_zq_change($user,$change_je,$change_amount,$change_desc,$change_type = 0)
{
    /* 插入帐户变动记录 */
    $zq_log = new ZqLog();
    $zq_log->user_id = $user->user_id;
    $zq_log->change_amount = $change_amount;
    $zq_log->change_je = $change_je;
    $zq_log->change_time = time();
    $zq_log->change_desc = $change_desc;
    $zq_log->change_type = $change_type;
    $zq_log->save();


    $user->zq_je = $user->zq_je + $change_je;
    $user->zq_amount = $user->zq_amount + $change_amount;
    if($user->zq_amount==0&&$user->zq_has==1){//账期结清
        $user->zq_has = 0;
    }
    $user->save();
}
function log_zq_change_ywy($user,$change_je,$change_amount,$change_desc,$change_type = 0)
{
    /* 插入帐户变动记录 */
    $zq_log = new ZqLogYwy();
    $zq_log->user_id = $user->user_id;
    $zq_log->change_amount = $change_amount;
    $zq_log->change_je = $change_je;
    $zq_log->change_time = time();
    $zq_log->change_desc = $change_desc;
    $zq_log->change_type = $change_type;
    $zq_log->save();

    $zq_ywy = ZqYwy::where('user_id',$user->user_id)->first();
    $zq_ywy->zq_je = $zq_ywy->zq_je + $change_je;
    $zq_ywy->zq_amount = $zq_ywy->zq_amount + $change_amount;
    $zq_ywy->save();
}
function log_zq_change_sy($user,$change_je,$change_amount,$change_desc,$change_type = 0)
{
    /* 插入帐户变动记录 */
    $zq_log = new \App\ZqLogSy();
    $zq_log->user_id = $user->user_id;
    $zq_log->change_amount = $change_amount;
    $zq_log->change_je = $change_je;
    $zq_log->change_time = time();
    $zq_log->change_desc = $change_desc;
    $zq_log->change_type = $change_type;
    $zq_log->save();

    $zq_ywy = \App\ZqSy::where('user_id',$user->user_id)->first();
    $zq_ywy->zq_je = $zq_ywy->zq_je + $change_je;
    $zq_ywy->zq_amount = $zq_ywy->zq_amount + $change_amount;
    $zq_ywy->save();
}
/**
 * @param $user_jnmj
 * @param int $jnmj_money
 * @param string $change_desc
 * @param int $jnmj_zk
 */
function log_jnmj_change($user_jnmj, $jnmj_money = 0,$change_desc='',$jnmj_zk=0)
{
    $jnmj_log = new JnmjLog();
    $jnmj_log->user_id = $user_jnmj->user_id;
    $jnmj_log->jnmj_money = $jnmj_money;
    $jnmj_log->change_time = time();
    $jnmj_log->change_desc = $change_desc;
    $jnmj_log->save();

    /* 更新用户信息 */
    if($jnmj_zk>0){
        $user_jnmj->jnmj_amount = $user_jnmj->jnmj_amount + $jnmj_money;
        $user_jnmj->jnmj_zk = $jnmj_zk;
    }else {
        $user_jnmj->jnmj_amount = $user_jnmj->jnmj_amount + $jnmj_money;
    }
    $user_jnmj->save();
    $user = auth()->user();
    if($user->is_zq==1) {
        $user->is_zq = 0;
        $user->save();
        $zq_log = new ZqLog();
        $zq_log->user_id = $user_jnmj->user_id;
        $zq_log->change_desc = '参加充值返利活动关闭账期';
        $zq_log->save();
    }
}

function check_czfl($user_info,$is_no_tj,$is_no_hy,$is_no_zyzk=true){
    $result = [
        'type'=>0,
        'message'=>"",
        'jnmj'=>''
    ];
    $start = strtotime('2016-05-25 00:00:00');
    $end = strtotime('2016-10-25 00:00:00');
    $now = time();
    if($now>$end||$now<$start){//不在活动范围内
        $result['type'] = 2;
        return $result;
    }
    if(!($user_info->is_zhongduan==1&&$user_info->province==26)){//不是四川终端用户
        $result['type'] = 2;
        return $result;
    }
    if($result['type']==0){
        $count = OrderInfo::where('order_status',1)->where('pay_status',0)->where('is_zq',1)->where('user_id',$user_info->user_id)->count();
//        $a = OrderInfo::where('order_status',1)->where('pay_status',0)->where('is_zq',1)->where('user_id',$user_info->user_id)->get();
//        dd($a);
        if($count>0){//账期未结清
            $result['type'] = 1;
            $result['message'] .= "账期未结清 ";
            return $result;
        }
    }
    $jnmj = UserJnmj::where('user_id',$user_info->user_id)->first();//查询是否参加活动
    if($jnmj) {//参加了充值返利
        $result['user_jnmj'] = $jnmj;
        if($is_no_tj==false){//含有特价商品
            $result['type'] = 1;
            $result['message'] .= "订单中含有特价商品 ";
        }
        if($is_no_hy==false){//含有哈药商品
            $result['type'] = 1;
            $result['message'] .= "订单中含有哈药商品 ";
        }
        if($is_no_zyzk==false){//含有优惠商品
            $result['type'] = 1;
            $result['message'] .= "订单中含有优惠商品 ";
        }
    }else{
        $result['type'] = 3;//没有参加充值返利
        if($user_info->is_zq==1&&$user_info->is_hd==0){//账期会员且选择了不参与折扣不动
            $result['type'] = 2;
        }
        $end1 = strtotime('2016-06-12 00:00:00');
        if($now>$end1){
            $result['type'] = 2;
        }
    }


    return $result;
}


/**
 * @param $order_info
 * @return mixed
 */
function mycat_bc($order_info){
    $order_info->agency_id = 0;
    $order_info->inv_type = 0;
    $order_info->tax = 0;
    $order_info->discount = 0;
    $order_info->o_paid = 0;
    $order_info->mobile_pay = 0;
    return $order_info;
}


function ad_template($id,$type=1){
    $ads = ads($id);
    if($type==1){
        $view = 'layout.guanggao_one';
    }else{
        $view = 'layout.guanggao_two';
    }
    return view($view)->withAd($ads);
}

/**
 * 支付限制
 */
function pay_xz($order){
    $flag = 1;//可以在线支付
    $cs_arr = [61,3498,3499];
    if(in_array($order->user_id,$cs_arr)||$order->is_zq>0||$order->jnmj>0||($order->mobile_pay>=6&&!in_array($order->mobile_pay,[9,10,11]))
        ||$order->order_amount==0||$order->is_separate==1||$order->money_paid!=0
        ||$order->user_id==61||($order->mobile_pay==2&&$order->order_id<394321)||$order->is_mhj==2){
        $flag = 0;
    }

    return $flag;
}

/**
 * @param $index
 * @param $arr
 * @return string
 */
function build_url($index,$arr){
    foreach($arr as $k=>$v){
        if(empty($v)){
            unset($arr[$k]);
        }
    }

    return route($index,$arr);

}

function get_img_path($img){
    $http = "http://112.74.176.233/";
    return $http.$img;
}

function zmsx(){/* 字母筛选 */
    return $zms = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
}

/**
 * 最大购买量
 */
function final_num($xg_num,$jzl,$zbz,$goods_number,$buy_number,$type=0){
    $result = [
        'goods_number'=>$buy_number,
        'message'=>'',
    ];
    if($goods_number<$zbz){
        $goods_number = 0;
    }
    if($xg_num>0) {
        $most_num = min([$xg_num, $goods_number]);//取库存和限购余量中较小的
    }else{
        $most_num = $goods_number;
    }
    if($most_num>0&&$most_num%$zbz!=0){//限购数量不是中包装整数倍
        $most_num = floor($most_num/$zbz)*$zbz;
    }
    $buy_number += $zbz*$type;
    $jzl_line = ceil(($jzl*0.8)/$zbz)*$zbz;
    if($jzl>0&&$jzl%$zbz!=0){//件装量不是中包装整数倍
        $jzl = ceil($jzl/$zbz)*$zbz;
        $jzl_line = ceil(($jzl*0.8)/$zbz)*$zbz;
    }
    if($jzl>0){//件装量存在 且件装量不是购买数量的整数倍
        if($buy_number%$jzl>=$jzl_line) {//超过件装量80%
            if($type>=0) {
                $buy_number = ceil($buy_number / $jzl) * $jzl;
                $result['message'] = '温馨提示：您所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。';
            }
            if($type<0){
                $buy_number = floor($buy_number / $jzl) * $jzl + ($jzl_line-$zbz);
            }
        }
    }
    $buy_number = min([$buy_number,$most_num]);
    if($buy_number>0&&$buy_number%$zbz!=0){
        $buy_number = ceil($buy_number/$zbz)*$zbz;
    }
    if($buy_number<=0) {
        $buy_number = min([$goods_number, $zbz]);
    }
    $result['goods_number'] = $buy_number;
    return $result;
}

if (! function_exists('path')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    function path($path, $secure = null)
    {
        return app('url')->asset($path, $secure).'?20170502';
        //return app('url')->asset($path, $secure);

    }
}

function cate_tree_new(){
    $cate_tree = Cache::tags(['shop','category',date('Ymd')])->remember('cate_tree',60*12,function (){
        $cate_tree = Category::with([
            'cate'=>function($query){
                $query->with([
                    'cate'=>function($query){
                        $query->where('is_show',1)
                            ->select('cat_id','cat_name','parent_id','is_show');
                    }
                ])->where('is_show',1)
                    ->select('cat_id','cat_name','parent_id','is_show');
            }
        ])->where('is_show',1)->where('parent_id',0)
            ->select('cat_id','cat_name','parent_id','is_show')
            ->orderBy('sort_order','desc')->orderBy('cat_id','desc')->get();
        return $cate_tree;
    });
    return $cate_tree;
}

function get_links($url,$text){
    $str =  "<p><a href='%s'>%s</a></p>";
    $str = sprintf($str,$url,$text);
    return $str;
}

function show_errors($msg='您请求的页面不存在',$links=''){
    $a = response()->view("errors.show", ['exception' => $msg,'links1'=>$links]);
    $a = $a->getContent();
    abort(1111,$a);
}
function show_msg($msg='您请求的页面不存在',$link='',$text='前往首页'){
    if(empty($link)){
        $link = route('index');
    }
    $link_str = get_links($link,$text);
    $a = response()->view("errors.msg", ['msg' => $msg,'link'=>$link,'link_str'=>$link_str]);
    exit($a->getContent());
}

function ddzt($order){
    $os = $order->order_status;
    $ps = $order->pay_status;
    $ss = $order->shipping_status;
    $zq = 0;
    if($order->is_zq>0||$order->is_separate>0){
        $zq = 1;
    }
    $id = $order->order_id;
    $result = [
        'status' => 0,
        'content' => '',
        'tip' => '',
        'handle' => '',
    ];
    if($zq==0){//非账期
        if($os==1&&$ps==0){
            $result = [
                'status' => 1,//订单已确认，未付款，未发货
                'handle' => "<a href='".route('user.orderInfo',['id'=>$id])."'>付款</a>",
            ];
        }
        if($os==1&&$ps==2&&$ss==0){
            $result = [
                'status' => 2,//订单已确认，未付款，未发货
                'handle' => "<span>待发货</span>",
            ];
        }
        if($os==1&&$ps==2&&$ss==1){
            $result = [
                'status' => 3,//订单已确认，未付款，未发货
                'handle' => "<span>已开票</span>",
            ];
        }
        if($os==1&&$ps==2&&$ss==2){
            $result = [
                'status' => 4,//订单已确认，未付款，未发货
                'handle' => "<span>出库中</span>",
            ];
        }
        if($os==1&&$ps==2&&$ss==3){
            $result = [
                'status' => 5,//订单已确认，未付款，未发货
                'handle' => "<span>已出库</span>",
            ];
        }
        if($os==1&&$ps==2&&$ss==4){
            $result = [
                'status' => 6,//订单已确认，未付款，未发货
                'handle' => "<a href='".route('user.orderInfo',['id'=>$id])."'>确认收货</a>",
            ];
        }
        if($os==1&&$ps==2&&$ss==5){
            $result = [
                'status' => 7,//订单已确认，未付款，未发货
                'handle' => "<span>已完成</span>",
            ];
        }
        if($os==2){
            $result = [
                'status' => 8,//订单已确认，未付款，未发货
                'handle' => "<span style='color:red'>已取消</span>",
            ];
        }
    }else{
        if($os==1&&$ss==0){
            $result = [
                'status' => 2,//订单已确认，未付款，未发货
                'handle' => "<span>待发货</span>",
            ];
        }
        if($os==1&&$ss==1){
            $result = [
                'status' => 3,//订单已确认，未付款，未发货
                'handle' => "<span>已开票</span>",
            ];
        }
        if($os==1&&$ss==2){
            $result = [
                'status' => 4,//订单已确认，未付款，未发货
                'handle' => "<span>出库中</span>",
            ];
        }
        if($os==1&&$ss==3){
            $result = [
                'status' => 5,//订单已确认，未付款，未发货
                'handle' => "<span>已出库</span>",
            ];
        }
        if($os==1&&$ss==4){
            $result = [
                'status' => 6,//订单已确认，未付款，未发货
                'handle' => "<a href='".route('user.orderInfo',['id'=>$id])."'>确认收货</a>",
            ];
        }
        if($os==1&&$ss==5){
            $result = [
                'status' => 7,//订单已确认，未付款，未发货
                'handle' => "<span>已完成</span>",
            ];
        }
        if($os==2){
            $result = [
                'status' => 8,//订单已确认，未付款，未发货
                'handle' => "<span style='color:red'>已取消</span>",
            ];
        }
    }
    return $result['handle'];
}
function area_xrtj($goods,$area_id,$area_id1=0){
    $id = intval($goods->goods_id);
    $area_id = intval($area_id);
    $area_id1 = intval($area_id1);
    $lj_time = strtotime('20170401');
    $now = time();
    if($now<$lj_time){
        $goods_arr = [986,1200,18070,957,1113,18041,18018];
        $area = [323,327];
        $area1 = [2788,2729,2734,2896];
        if($goods->is_xkh_tj==1&&(in_array($id,$goods_arr))){//新人特价商品且是限制的几个品种
            if((!in_array($area_id,$area)||$area_id==0)&&(!in_array($area_id1,$area1)||$area_id1==0)){//会员不在可享受新人特价范围内
                $goods->is_xkh_tj = 0;
                $goods->is_promote = 0;
                $goods->is_cx = 0;
            }
        }
    }else{
        $goods_arr = [18070,957,1113,18041,18018,814,14417,15998,7163,21887];
        $area = [327];
        if($goods->is_xkh_tj==1&&(in_array($id,$goods_arr))){//新人特价商品且是限制的几个品种
            if((!in_array($area_id,$area))){//会员不在可享受新人特价范围内
                $goods->is_xkh_tj = 0;
                $goods->is_promote = 0;
                $goods->is_cx = 0;
            }
        }
    }

    return $goods;
}
function area_xrtj_yl($now,$goods,$area_id,$area_id1=0){
    $id = intval($goods->goods_id);
    $area_id = intval($area_id);
    $area_id1 = intval($area_id1);
    $lj_time = strtotime('20170401');
    if($now<$lj_time){
        $goods_arr = [986,1200,18070,957,1113,18041,18018];
        $area = [323,327];
        $area1 = [2788,2729,2734,2896];
        if($goods->is_xkh_tj==1&&(in_array($id,$goods_arr))){//新人特价商品且是限制的几个品种
            if((!in_array($area_id,$area)||$area_id==0)&&(!in_array($area_id1,$area1)||$area_id1==0)){//会员不在可享受新人特价范围内
                $goods->is_xkh_tj = 0;
                $goods->is_promote = 0;
                $goods->is_cx = 0;
            }
        }
    }else{
        $goods_arr = [18070,957,1113,18041,18018,814,14417,15998,7163,21887];
        $area = [327];
        if($goods->is_xkh_tj==1&&(in_array($id,$goods_arr))){//新人特价商品且是限制的几个品种
            if((!in_array($area_id,$area))){//会员不在可享受新人特价范围内
                $goods->is_xkh_tj = 0;
                $goods->is_promote = 0;
                $goods->is_cx = 0;
            }
        }
    }

    return $goods;
}

function check_hdfk($user_id){
    $time = time() - 15*3600*24;
    $order = OrderInfo::where('is_separate',1)->where('order_status',1)
        ->where('pay_status',0)->where('add_time','<=',$time)
        ->where('user_id',$user_id)
        ->where('mobile_pay','!=',2)
        ->count()
    ;
    if($order>0){
        show_msg('你有一笔货到付款订单超过15天未支付，请支付后再下单。',route('user.orderList'),'前往订单列表');
    }
}

if (!function_exists('get_region_name')) {

    function get_region_name($region_ids, $fuhao = '')
    {
        $name        = '';
        $region_name = DB::table('region')->select('region_name')->whereIn('region_id', $region_ids)->get();
        foreach ($region_name as $v) {
            $name .= $v->region_name . $fuhao;
        }
        return $name;
    }
}

if (!function_exists('rank_name')) {
    function rank_name($id)
    {
        $rank_name = DB::table('user_rank')->where('rank_id',$id)->pluck('rank_name');
        if(empty($rank_name)){
            $rank_name = '非特殊等级';
        }
        return $rank_name;
    }
}

if (!function_exists('week_sale')) {
    function week_sale($num = 10)
    {
        $goods = Goods::orderBy('sales_volume', 'desc')
            ->where('is_on_sale', '=', 1)->where('is_alone_sale', 1)->where('is_delete', 0)
            ->select('goods_id', 'sales_volume', 'goods_name', 'ypgg', 'goods_thumb')
            ->take($num)->get();
        foreach ($goods as $v) {
            $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
            $v->goods_thumb = get_img_path($v->goods_thumb);
        }
        return $goods;
    }
}

if (!function_exists('ajax_return')) {
    function ajax_return($msg, $error = 0, $params = [])
    {
        $result = [
            'error' => $error,
            'msg'   => $msg,
        ];
        $result = array_merge($result, $params);
        exit(response()->json($result)->getContent());
    }
}

if (!function_exists('xl_top')) {
    function xl_top($time, $tag = 'week', $num = 10)
    {
        $result = Cache::tags('shop', 'xy', $tag)->remember(date('Y-m-d'), 60 * 12, function () use ($time, $num) {
            $order_id = OrderInfo::where('add_time', '>', $time)
                ->orderBy('order_id', 'asc')->pluck('order_id');
            $result   = DB::table('order_goods as og')
                ->leftJoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
                ->leftJoin('goods_attr as ga', function ($join) {
                    $join->on('og.goods_id', '=', 'ga.goods_id')->where('ga.attr_id', '=', 3);
                })
                ->leftJoin('goods as g', 'g.goods_id', '=', 'og.goods_id')
                ->where('og.order_id', '>=', $order_id)->where('oi.order_status', 1)
                ->where('og.goods_sn', 'not like', '05%')
                ->orderBy('num', 'desc')->groupBy('og.goods_id')->take($num)
                ->select('g.goods_name', 'g.goods_id', 'g.goods_thumb', 'ga.attr_value as spgg',
                    DB::raw('sum(ecs_og.goods_number) as num'))
                ->get();
            foreach ($result as $v) {
                $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
                $v->goods_thumb = get_img_path($v->goods_thumb);
                $v->goods_url   = route('goods.index', ['id' => $v->goods_id]);
            }
            return $result;
        });
        return $result;
    }
}