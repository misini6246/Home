<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/28
 * Time: 12:57
 */
Route::get('weixin/wx_xiugai', ['as'=>'weixin.wx_xiugai','uses'=>'WeixinController@wx_xiugai']);
Route::group(['middleware'=>'auth'],function() {
    Route::get('contact', 'ContactController@index');
    //支付宝支付处理
    Route::get('alipay/pay',['as'=>'alipay.pay','uses'=>'AlipayController@pay']);
    //银联支付处理
    Route::get('union/pay', ['as'=>'union.pay','uses'=>'UnionPayController@pay']);
    Route::get('union/pay_zq', ['as'=>'union.pay_zq','uses'=>'UnionPayController@pay_zq']);
    Route::get('union/pay_zq_ywy', ['as'=>'union.pay_zq_ywy','uses'=>'UnionPayController@pay_zq_ywy']);
    Route::get('union/pay_zq_sy', ['as'=>'union.pay_zq_sy','uses'=>'UnionPayController@pay_zq_sy']);
    Route::get('union/search', ['as'=>'union.search','uses'=>'UnionPayController@toSearch']);
    Route::get('union/search_zq', ['as'=>'union.search_zq','uses'=>'UnionPayController@toSearch_zq']);
    Route::get('union/search_zq_ywy', ['as'=>'union.search_zq_ywy','uses'=>'UnionPayController@toSearch_zq_ywy']);
    Route::get('union/search_zq_sy', ['as'=>'union.search_zq_sy','uses'=>'UnionPayController@toSearch_zq_sy']);
    Route::get('contact/pay', ['as'=>'contact.pay','uses'=>'ContactController@pay']);
    //农行支付处理
    Route::get('abc/pay', ['as'=>'abc.pay','uses'=>'AbcPayController@pay']);
    Route::get('abc/pay_zq', ['as'=>'abc.pay_zq','uses'=>'AbcPayController@pay_zq']);
    Route::get('abc/search', ['as'=>'abc.search','uses'=>'AbcPayController@toSearch']);
    Route::get('abc/search_zq', ['as'=>'abc.search_zq','uses'=>'AbcPayController@toSearch_zq']);

//    /**
//     * 兴业银行支付
//     */
//    Route::get('xyyh/pay', ['as'=>'xyyh.pay','uses'=>'XyyhController@pay']);
//    Route::get('xyyh/search', ['as'=>'xyyh.search','uses'=>'XyyhController@toSearch']);



    /**
     * 微信扫码
     */
    Route::get('weixin/pay', ['as'=>'weixin.pay','uses'=>'WeixinController@pay']);
    Route::get('weixin/search', ['as'=>'weixin.search','uses'=>'WeixinController@toSearch']);




    /**
     * 建设银行支付
     */
    Route::get('jsyh/pay', ['as'=>'jsyh.pay','uses'=>'JsyhController@pay']);

    //支付后跳转页面
    Route::post('alipay/return', ['as'=>'alipay.result','uses'=>'AlipayController@result']);
    Route::any('abc/return', ['as'=>'abc.result','uses'=>'XyyhController@response_abc']);
    Route::post('abc/return_zq', ['as'=>'abc.result_zq','uses'=>'AbcPayController@result_zq']);
});
Route::any('abc/return_sj', ['as'=>'abc.result_sj','uses'=>'AbcPayController@result']);
Route::any('xyyh/response', ['as'=>'xyyh.response','uses'=>'XyyhController@response']);
Route::any('weixin/response', ['as'=>'weixin.response','uses'=>'WeixinController@response']);
Route::any('weixin/new_response', ['as'=>'weixin.new_response','uses'=>'WeixinController@new_response']);
Route::any('ht_search', 'XyyhController@ht_search');
Route::any('xyyh/duizhang', ['as'=>'XyyhController.duizhang','uses'=>'XyyhController@duizhang']);
Route::any('abc/duizhang', ['as'=>'abc.duizhang','uses'=>'AbcPayController@duizhang']);
Route::any('wx_search','WeixinController@wx_search');
Route::any('weixin/get_data',['as'=>'WeixinController.data','uses'=>'WeixinController@get_data']);
Route::post('union/return', ['as'=>'union.result','uses'=>'UnionPayController@result']);
Route::post('union/return_zq', ['as'=>'union.result_zq','uses'=>'UnionPayController@result_zq']);
Route::post('union/return_zq_ywy', ['as'=>'union.result_zq_ywy','uses'=>'UnionPayController@result_zq_ywy']);
Route::post('union/return_zq_sy', ['as'=>'union.result_zq_sy','uses'=>'UnionPayController@result_zq_sy']);
Route::post('union/return_new', ['as'=>'union.return_new','uses'=>'UnionPayController@return_new']);