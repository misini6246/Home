<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ErrorController extends Controller
{

    public function index(Request $request){
        $m = intval($request->input('m',3));
        $msg = $request->input('msg','您请求的页面不存在');
        if(empty($msg)){
            $msg = "您请求的页面不存在";
        }
        return view('errors.index',['msg'=>$msg,'page_title'=>'系统提示','middle_nav'=>nav_list('middle'),'m'=>$m]);
    }
}
