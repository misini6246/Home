<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SsoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $user;

    public function index(Request $request)
    {

        if(auth()->check()){
            $this->user = auth()->user();
            $result = $this->curl_yyg('http://211.149.207.235:8080/ssologin');
            dd($result);
        }
    }

    protected function curl_yyg($url){

        if(!empty($this->user->ec_salt)){
            $md5_pwd = md5(md5($this->user->password).$this->user->ec_salt);
        }else{
            $md5_pwd = md5($this->user->password);
        }
        // 1. 初始化
        $ch = curl_init();
        // 2. 设置选项，包括URL
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,['user_id'=>$this->user->user_id,'password'=>$md5_pwd]);
        // 3. 执行并获取HTML文档内容
        $output = curl_exec($ch);
//    if($output === FALSE ){

//        echo "CURL Error:".curl_error($ch);
//    }
        // 4. 释放curl句柄
        curl_close($ch);

        return $output;
    }
}
