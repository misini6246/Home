<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/28
 * Time: 12:57
 */
Route::group(['middleware'=>'auth'],function() {
    Route::get('vue/index',function(){
        return view('contact::vue');
    });
});
