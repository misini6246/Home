<?php
header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Headers:x-requested-with, content-type,Authorization');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
if (request()->url() == "http://47.107.103.86" ){
    header("Location:http://www.jyeyw.com");
}
Route::get('test', 'TestController@index');
Route::get('sjtj', 'SjtjController@index');
Route::get('kfdh', 'CommonController@kfdh');
Route::get('get_order_status/{order_sn}', 'CommonController@getOrderStatus');
Route::get('test/yz', 'TestController@yz');
Route::get('yc/user_info', 'CommonController@user_info');
Route::get('yc/collect_list', 'CommonController@collect_list');
Route::get('yc/gwc', 'CommonController@gwc');
Route::get('yc/zncgsp', 'CommonController@zncgsp');
Route::get('yc/delete_gwc', 'CommonController@delete_gwc');
Route::get('yc/delete_collect', 'CommonController@delete_collect');

Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
Route::get('show_yindao', ['as' => 'show_yindao', 'uses' => 'HomeController@show_yindao']);
Route::get('/home', ['as' => 'home', 'uses' => 'IndexController@index_new']);
Route::get('index_new', ['as' => 'index_new', 'uses' => 'IndexController@index_new']);
Route::get('index_yl', ['as' => 'index_yl', 'uses' => 'HomeController@index_yl']);
Route::get('cacheF', ['as' => 'cacheF', 'uses' => 'IndexController@cacheFlush']);
Route::get('articleInfo', ['as' => 'articleInfo', 'uses' => 'ArticleController@articleInfo']);
Route::get('article', ['as' => 'article.index', 'uses' => 'ArticleController@index']);
Route::get('feedback', ['as' => 'feedback', 'uses' => 'ArticleController@feedback']);

/**
 * 中药
 */
Route::get('zy', ['as' => 'zy.index', 'uses' => 'zyzq\\IndexController@index']);
Route::get('zy_category', ['as' => 'category.zyyp', 'uses' => 'zyzq\\IndexController@category']);
Route::get('zy_goods', ['as' => 'goods.zyyp', 'uses' => 'zyzq\\IndexController@goods']);
Route::get('zdtjp', ['as' => 'goods.zdtjp', 'uses' => 'ZyController@zdtjp']);
/*
 * 活动
 */
Route::controller('cxhd', 'HdController');
Route::get('cxzq', 'HdController@getCxzq');
//Route::get('cxzq', 'HuodongController@cxzq');
Route::get('gzbl', 'HuodongController@gzbl');
//Route::get('zhengqing', 'HuodongController@zhengqing');
Route::get('mz', 'HuodongController@mz');
Route::get('ppzq', ['as' => 'ppzq.index', 'uses' => 'PpzqController@index']);
Route::get('ppzq_new', ['as' => 'ppzq.new', 'uses' => 'PpzqController@new_index']);
Route::get('ppzq_list', ['as' => 'ppzq.list', 'uses' => 'PpzqController@ppzq_list']);
Route::get('ppzq_key', ['as' => 'ppzq.key', 'uses' => 'PpzqController@key']);
// 品牌专区，暂用
Route::get('ppzq/tmp', ['as' => 'ppzq.tmp', 'uses' => 'PpzqController@tmp']);
Route::get('hymsy', function () {
    return view('huodong.hymsy');
});
Route::get('mianmo', function () {
    return view('hd.mianmo');
});
Route::get('dyy', function () {
    return view('hd.dyy');
});
Route::get('bjy', function () {
    return view('hd.bjy');
});
Route::get('zd', function () {
    return view('hd.zd');
});
Route::get('tg/{view}', function ($view) {
    if ($view == 'rs') {
        if (!auth()->check()) {
            return redirect()->to('/auth/login');
        }
    }
    if ($view == 'dpmx1' || $view == 'dpmx' || $view == 'lhb' || $view == 'dpm' || $view == 'dpm1') {
        return redirect()->to('/');
    }
    if ($view == 'liaoyuan') {
        $page_title = '燎原行动-';
    }
    return view('hd.' . $view, compact('page_title'));
});
Route::get('bys', function () {
    return view('hd.bys');
});
Route::get('xdb', function () {
    return view('hd.xdb');
});
Route::get('nj', function () {
    return view('hd.nj');
});
Route::get('fkhg', function () {
    return view('hd.hdhg');
});
Route::get('jpzq', function () {
    return view('huodong.jpzq');
});
Route::get('kxpz', function () {
    return view('huodong.kxpz', ['page_title' => '控销专区-']);
});
Route::get('fanli', function () {
    return view('huodong.fanli');
});
Route::get('huangou', function () {
    return view('huodong.huangou');
});
Route::get('gsjj', function () {
    return view('huodong.gsjj');
});
Route::get('xrs', function () {
    return view('huodong.xrs');
});
Route::get('zhaoshang', function () {
    return view('huodong.zhaoshang');
});
Route::get('dzfptip', function () {
    return view('huodong.dzfp');
});
Route::get('lhb', 'DpmController@lhb')->name('lhb');
Route::post('search_info', ['as' => 'search_info', 'uses' => 'CommonController@search_info']);
Route::get('xkh', ['as' => 'category.xkh', 'uses' => 'CategoryController@xkh']);
Route::get('xrtj', ['as' => 'category.xrtj', 'uses' => 'Xin\GoodsController@xkh']);
Route::get('xkh_yl', ['as' => 'category.xkh_yl', 'uses' => 'CategoryController@xkh_yl']);
Route::get('xkh_xj', ['as' => 'category.xkh_xj', 'uses' => 'CategoryController@xkh_xj']);
Route::get('xkh_xj_yl', ['as' => 'category.xkh_xj_yl', 'uses' => 'CategoryController@xkh_xj_yl']);
Route::resource('category', 'Xin\GoodsController');
Route::resource('goods', 'GoodsController');

Route::resource('activity', 'ActivityController');
Route::get('check_has_yhq', 'YhqController@check_has_yhq');

Route::resource('requirement', 'RequirementController');
Route::group(['namespace' => 'Xin'], function () {
    Route::resource('product', 'GoodsController');
    Route::resource('gwc', 'CartController');
    Route::resource('collect', 'CollectController');
});

// =================== 单独页面
// 2019 8.07活动
Route::get('/yfhg','Xin\GoodsController@hd_1908');
Route::get('/zhuchang','Xin\GoodsController@zhuchang');
/*// 2019 8.07活动
Route::get('/hd_1908','Xin\GoodsController@hd_1908');*/
// 2019.8.21 中药活动
Route::get('hd_821zy','Xin\GoodsController@hd_821zy');
// 2019.8.21 普药活动
// Route::get('hd_821py','Xin\GoodsController@hd_821py');
// 2019 秋分
Route::get('/qiufen','GoodsController@qiufen');
// 2019 国庆
// Route::get('/guoqing','GoodsController@guoqing');
// 111活动秒杀
Route::get('/11.1/miaosha','MiaoShaController@index')->name('miaosha111');
// 111签到
Route::get('/11.1/qiandao','Jifen\QianDaoController@index')->name("qiandao111");
// 111 抽奖
Route::get('/11.1/choujiang',function(){
    return view('hd.111.raffle');
});
// 111特价
Route::get('/11.1/tejia','GoodsController@tejia111');
// ==============================

//Route::group(['namespace' => 'CheckLogin'], function(){
// 需要验证登陆的组别
Route::group(['namespace' => 'Pay'], function () {
    Route::any('alipay/notify', 'AlipayController@notify')->name('alipay.notify');
    Route::any('alipay_pc/notify', 'AlipayPcController@notify')->name('alipay_pc.notify');
    Route::any('wechat/notify', 'WeChatController@notify')->name('wechat.notify');
});
Route::get('jf_money/log', 'JfMoneyController@log')->name('jf_money.log');
Route::resource('jf_money', 'JfMoneyController');
Route::get('cz_money/log', 'CzMoneyController@log')->name('cz_money.log');
Route::resource('cz_money', 'CzMoneyController');
Route::controller('sync', 'SyncController');
Route::post('yhq/dfqr', ['as' => 'yhq.dfqr', 'uses' => 'YhqController@dfqr']);
Route::resource('yhq', 'YhqController');
Route::post('reset_code', ['as' => 'reset_code', 'uses' => 'AuthController@reset_code']);
Route::post('check_reset_code', ['as' => 'check_reset_code', 'uses' => 'AuthController@check_reset_code']);
Route::get('reset_pwd', ['as' => 'reset_pwd', 'uses' => 'AuthController@reset_pwd']);
Route::post('pwd_reset', ['as' => 'pwd_reset', 'uses' => 'AuthController@pwd_reset']);
Route::post('reg_code', ['as' => 'reg_code', 'uses' => 'AuthController@reg_code']);
Route::post('check_code', ['as' => 'check_code', 'uses' => 'AuthController@check_code']);
Route::get('choujiang', 'JpController@choujiang');
Route::resource('cj', 'JpController');
Route::group(['middleware' => 'check_login'], function () {
    Route::post('jp/check_log_count', 'JpController@check_log_count');

 
    Route::group(['namespace' => 'Pay'], function () {
        Route::get('alipay', 'AlipayController@index')->name('alipay.index');
        Route::get('alipay_pc', 'AlipayPcController@index')->name('alipay_pc.index');
        Route::get('wechat', 'WeChatController@index')->name('wechat.index');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('znx_list', ['as' => 'znx_list', 'uses' => 'User\WoDeXiaoXiController@index']);
        Route::get('znx_info', ['as' => 'znx_info', 'uses' => 'UserController@znx_info']);
        Route::get('wd_znx', ['as' => 'wd_znx', 'uses' => 'UserController@wd_znx']);
        Route::get('yd_znx', ['as' => 'yd_znx', 'uses' => 'UserController@yd_znx']);
        Route::get('shanchu_znx', ['as' => 'shanchu_znx', 'uses' => 'UserController@shanchu_znx']);
    });
    Route::resource('user/tixian', 'TiXianController', ['only' => ['index', 'store', 'update']]);

    //注册成功跳转页面
    Route::get('user/regMsg', ['as' => 'user.regMsg', 'uses' => 'UserController@regMsg']);
    Route::get('user/reg_success', ['as' => 'user.reg_success', 'uses' => 'UserController@reg_success']);

    Route::get('address/region', 'AddressController@region');
    Route::get('address/edit', ['as' => 'address.edit', 'uses' => 'AddressController@edit']);

    /**
     * 充值金额
     */
    Route::get('user/czjl', ['as' => 'user.czjl', 'uses' => 'UserController@czjl']);
    Route::get('user/order_search', ['as' => 'user.order_search', 'uses' => 'UserController@order_search']);
    /**
     * 账期
     */
    Route::get('user/zq_log', ['as' => 'user.zq_log', 'uses' => 'UserController@zq_log']);
    Route::get('user/zq_order', ['as' => 'user.zq_order', 'uses' => 'User\ZqOrderController@index']);
    Route::get('user/zq_order_info', ['as' => 'user.zq_order_info', 'uses' => 'UserController@zq_order_info']);
    Route::get('user/zq_order_sy', ['as' => 'user.zq_order_sy', 'uses' => 'UserController@zq_order_sy']);
    Route::get('user/zq_order_info_sy', ['as' => 'user.zq_order_info_sy', 'uses' => 'UserController@zq_order_info_sy']);


    Route::get('user/orderList', ['as' => 'user.orderList', 'uses' => 'User\OrderController@index']);
    Route::get('user/cz_order', ['as' => 'user.cz_order', 'uses' => 'UserController@cz_order']);
    Route::get('user/cz_order_info', ['as' => 'user.cz_order_info', 'uses' => 'UserController@cz_order_info']);
    Route::get('user/ddgz', ['as' => 'user.ddgz', 'uses' => 'UserController@ddgz']);
    Route::get('user/orderInfo', ['as' => 'user.orderInfo', 'uses' => 'User\OrderController@orderInfo']);
    Route::get('user/rebate', ['as' => 'user.rebate', 'uses' => 'User\OrderController@rebate']);
    Route::post('user/sureShipping', ['as' => 'user.sureShipping', 'uses' => 'UserController@sureShipping']);
    Route::post('user/useSurplus', ['as' => 'user.useSurplus', 'uses' => 'UserController@useSurplus']);
    Route::get('user/orderBuy', ['as' => 'user.orderBuy', 'uses' => 'UserController@orderBuy']);
    Route::get('user/collectList', ['as' => 'user.collectList', 'uses' => 'User\CollectionController@index']);
    Route::get('user/deleteCollect', ['as' => 'user.deleteCollect', 'uses' => 'UserController@deleteCollect']);
    Route::get('user/deleteCollectPl', ['as' => 'user.deleteCollectPl', 'uses' => 'UserController@deleteCollectPl']);
    Route::get('user/zncg', ['as' => 'user.zncg', 'uses' => 'User\IndexController@zncg']);
    Route::get('user/plBuy', ['as' => 'user.plBuy', 'uses' => 'UserController@plBuy']);
    Route::get('user/profile', ['as' => 'user.profile', 'uses' => 'User\IndexController@info']);
    Route::post('user/infoUpdate', ['as' => 'user.infoUpdate', 'uses' => 'UserController@infoUpdate']);
    Route::post('user/setPwd', ['as' => 'user.setPwd', 'uses' => 'UserController@setPwd']);
    Route::get('user/account', ['as' => 'user.account', 'uses' => 'UserController@account']);
    Route::get('user/accountInfo', ['as' => 'user.accountInfo', 'uses' => 'User\IndexController@money']);
    Route::get('user/addressList', ['as' => 'user.addressList', 'uses' => 'User\UserAddressController@index']);
    Route::post('user/addressCreate', ['as' => 'user.addressCreate', 'uses' => 'UserController@addressCreate']);
    Route::post('user/addressUpdate', ['as' => 'user.addressUpdate', 'uses' => 'UserController@addressUpdate']);
    Route::get('user/addressDelete', ['as' => 'user.addressDelete', 'uses' => 'UserController@addressDelete']);
    Route::get('user/pswl', ['as' => 'user.pswl', 'uses' => 'User\IndexController@pswl']);
    Route::get('user/messageList', ['as' => 'user.messageList', 'uses' => 'UserController@messageList']);
    Route::get('user/messageOrder', ['as' => 'user.messageOrder', 'uses' => 'UserController@messageOrder']);
    Route::post('user/msgCreate', ['as' => 'user.msgCreate', 'uses' => 'UserController@msgCreate']);
    Route::get('user/msgDelete', ['as' => 'user.msgDelete', 'uses' => 'UserController@msgDelete']);
    Route::get('user/buyList', ['as' => 'user.buyList', 'uses' => 'User\IndexController@buy']);
    Route::get('user/buyNew', ['as' => 'user.buyNew', 'uses' => 'UserController@buyNew']);
    Route::post('user/buyCreate', ['as' => 'user.buyCreate', 'uses' => 'UserController@buyCreate']);
    Route::get('user/buyUpdate', ['as' => 'user.buyUpdate', 'uses' => 'UserController@buyUpdate']);
    Route::get('user/payOk', ['as' => 'user.payOk', 'uses' => 'UserController@payOk']);
    Route::get('user/youhuiq', ['as' => 'user.youhuiq', 'uses' => 'User\IndexController@youhuiq']);
    Route::get('zhijian', ['as' => 'zhijian', 'uses' => 'UserController@zhijian']);
    Route::get('dzfp', ['as' => 'dzfp', 'uses' => 'UserController@dzfp']);
    Route::get('zjs', ['as' => 'zjs', 'uses' => 'UserController@zjs']);
    Route::get('user/sjtj', ['as' => 'user.sjtj', 'uses' => 'UserController@sjtj']);
    Route::post('user/feedback', ['as' => 'user.feedback', 'uses' => 'UserController@feedback']);
    Route::get('user/mobile_login', ['as' => 'user.mobile_login', 'uses' => 'User\DuoHuiYuanController@index']);
    Route::post('bind_code', ['as' => 'bind_code', 'uses' => 'AuthController@bind_code']);
    Route::post('bind_mobile', ['as' => 'bind_mobile', 'uses' => 'AuthController@bind_mobile']);
    Route::get('change_login_user', 'AuthController@change_login_user');
    Route::resource('user', 'UserController');
    Route::get('user', 'User\IndexController@index')->name('user.index');

    Route::get('cart/checkout', ['as' => 'cart.checkout', 'uses' => 'CartController@checkout']);
    Route::get('cart/jiesuan', ['as' => 'cart.jiesuan', 'uses' => 'CartController@jiesuan']);
    Route::get('cart/dropCart', ['as' => 'cart.dropCart', 'uses' => 'CartController@dropCart']);
    Route::get('cart/dropCartMany', ['as' => 'cart.dropCartMany', 'uses' => 'CartController@dropCartMany']);
    Route::get('cart/dropToCollect', ['as' => 'cart.dropToCollect', 'uses' => 'CartController@dropToCollect']);
    Route::any('cart/del_no_num', ['as' => 'cart.del_no_num', 'uses' => 'CartController@del_no_num']);
    Route::any('cart/order', ['as' => 'cart/order', 'uses' => 'CartController@order']);
    Route::resource('cart', 'CartController');
    // 控制器在 "App\Http\Controllers\Ajax" 命名空间下
    Route::group(['middleware' => 'ajax'], function () {
        Route::group(['namespace' => 'Ajax'], function () {
            // 控制器在 "App\Http\Controllers\LaravelAcademy\DOCS" 命名空间下
            Route::group(['prefix' => 'ajax'], function () {
                Route::post('cart/addNum', 'CartController@addNum');
                Route::get('cart/goodsChoose', 'CartController@goodsChoose');
                Route::get('common/addToCollect', 'CommonController@addToCollect');
                Route::any('cart', ['as' => 'CartController.store', 'uses' => 'CartController@store']);
            });
        });
    });
});
Route::group(['middleware' => 'ajax'], function () {
    Route::group(['namespace' => 'Ajax'], function () {
        // 控制器在 "App\Http\Controllers\LaravelAcademy\DOCS" 命名空间下
        Route::group(['prefix' => 'ajax'], function () {
            Route::get('cart/searchKey', 'CartController@searchKey');
        });
    });
});
Route::group(['middleware' => 'auth'], function () {
    /**
     * 需要登录才能参加的活动
     */
    Route::controller('hd', 'HdLoginController');
    Route::group(['middleware' => 'is_zhongduan'], function () {
//        Route::controller('bt', 'BaoTuanController');
        Route::controller('jfdh', 'JfdhController');
        Route::controller('cz', 'CzOrderController');
    });
});
//-------------------------一直注释-0------------------------------------
//});
//Route::group(['namespace' => 'Jf'], function () {
//    // 需要验证登陆的组别
//    Route::get('jf', ['as' => 'jf.index', 'uses' => 'JfController@index']);
//    Route::get('jf/help', ['as' => 'jf.help', 'uses' => 'JfController@help']);
//    Route::get('jf/goods', ['as' => 'jf.goods', 'uses' => 'JfController@goods']);
//    Route::get('jf/search', ['as' => 'jf.search', 'uses' => 'JfController@search']);
//    Route::group(['middleware' => 'auth'], function () {
//        Route::get('jf/member', ['as' => 'jf.member', 'uses' => 'JfController@member']);
//        Route::get('jf/cart', ['as' => 'jf.cart', 'uses' => 'JfController@cart']);
//        Route::get('jf/order', ['as' => 'jf.order', 'uses' => 'JfController@order']);
//        Route::get('jf/address', ['as' => 'jf.address', 'uses' => 'JfController@address']);
//        Route::get('jf/deleteCart', ['as' => 'jf.deleteCart', 'uses' => 'JfController@deleteCart']);
//        Route::get('jf/make', ['as' => 'jf.make', 'uses' => 'JfController@make']);
//        Route::post('jf/newAddress', ['as' => 'jf.newAddress', 'uses' => 'JfController@newAddress']);
//        Route::post('jf/done', ['as' => 'jf.done', 'uses' => 'JfController@done']);
//        Route::get('jf/sure', ['as' => 'jf.sure', 'uses' => 'JfController@sure']);
//        Route::get('jf/orderInfo', ['as' => 'jf.orderInfo', 'uses' => 'JfController@orderInfo']);
//        Route::get('jf/payPoints', ['as' => 'jf.payPoints', 'uses' => 'JfController@payPoints']);
//    });
//    Route::group(['middleware' => 'ajax'], function () {
//        Route::post('jf/addCart', ['as' => 'jf.addCart', 'uses' => 'JfController@addCart']);
//        Route::post('jf/checkNum', ['as' => 'jf.checkNum', 'uses' => 'JfController@checkNum']);
//        Route::post('jf/check', ['as' => 'jf.check', 'uses' => 'JfController@check']);
//    });
//
//});

//---------------------------------------------------注释结束---------------------------
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::post('login_code', 'AuthController@login_code');
Route::post('mobile_login', 'AuthController@mobile_login');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
// 注册路由...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::post('reg/reg_check', 'RegController@reg_check');
// 密码重置链接请求路由...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
// 密码重置路由...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
//jobs
Route::get('mail/sendReminderEmail', 'MailController@sendReminderEmail');

//统计
Route::get('tongji', ['as' => 'tongji', 'uses' => 'TongJiController@index']);
Route::get('error', ['as' => 'error', 'uses' => 'ErrorController@index']);
Route::get('tejia', ['as' => 'tejia', 'uses' => 'TeJiaController@index']);
Route::any('union/duizhang', ['as' => 'union.duizhang', 'uses' => 'DuiZhangController@union']);
//秒杀减库存
Route::get('miaosha_num', 'MiaoShaController@miaosha_num');
Route::any('miaosha', ['as' => 'miaosha', 'uses' => 'MiaoShaController@index']);
Route::any('yushou', ['as' => 'yushou', 'uses' => 'MiaoShaController@yushou']);
Route::any('zhongyao', ['as' => 'zhongyao', 'uses' => 'MiaoShaController@zhongyao']);
Route::resource('ms', 'MsController');
//Route::any('tehui', ['as' => 'miaosha', 'uses' => 'MiaoShaController@index']);
Route::any('buy_ms', ['as' => 'buy_ms', 'uses' => 'MiaoShaController@buy']);
Route::any('up_kc', ['as' => 'up_kc', 'uses' => 'MiaoShaController@up_kc']);
Route::any('into_db', ['as' => 'into_db', 'uses' => 'MiaoShaController@into_db']);
//Route::any('set_xml',['as'=>'set_xml','uses'=>'MiaoShaController@set_xml']);
Route::any('ms_goods', ['as' => 'ms_goods', 'uses' => 'MiaoShaController@ms_goods']);
Route::any('qchc', ['as' => 'qchc', 'uses' => 'MiaoShaController@qchc']);
//Route::get('dpm',['as'=>'dpm','uses'=>'HuodongController@dpm']);
Route::get('get_user_info', ['as' => 'get_user_info', 'uses' => 'HuodongController@get_user_info']);
Route::get('get_kc', ['as' => 'get_kc', 'uses' => 'MiaoShaController@get_kc']);

/**
 * erp
 */
Route::get('erp_users', 'ErpController@wldwzl');
Route::get('log_by_id', 'IndexController@log_by_id');

/**
 * 每日秒杀
 */
Route::get('mrms', 'Xin\MiaoshaController@meiri');

/**
 * 控销专区--提示信息
 */
Route::get('kxzq','CategoryController@kxzq');
Route::get('mid-autumn','GoodsController@Festival_goods');


//测试
Route::get('/spzl','AutoController@spzl');  //同步商品资料
Route::get('/spkc','AutoController@spkc');  //同步商品库存
Route::get('/spjg','AutoController@spjg');  //同步商品价格
Route::get('/dwzl','AutoController@dwzl');  //同步单位资料
Route::get('/jyfw','AutoController@jyfw');  //同步单位经验范围
Route::get('/goods_status','AutoController@goods_status');  //自动上下架


Route::get('/s','Xin\GoodsController@demo');
Route::get('/tongbu_category','GoodsCategoryController@tongbu_category');//商品更新分类
Route::get('/daoru','GoodsCategoryController@daoru');//商品更新分类
Route::get('/zuijia','GoodsCategoryController@zuijia');//商品更新分类
Route::get('/yuanjian','GoodsCategoryController@yuanjian');//商品更新分类
Route::get('/xiugai','GoodsCategoryController@xiugai');//商品更新分类
Route::get('/xiugai2','GoodsCategoryController@xiugai2');//商品更新分类
Route::get('/adduser','GoodsCategoryController@addUser');//用户导入
Route::get('/chufang','GoodsCategoryController@chufang');//用户处方导入

Route::get('/user_jine','GoodsCategoryController@user_jine');//11.1会员加
Route::get('/user_jian_jine','GoodsCategoryController@user_jian_jine');//11.1会员减
