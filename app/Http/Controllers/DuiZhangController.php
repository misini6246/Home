<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class DuiZhangController extends Controller
{
    public function union(Request $request){
        $trans_date	= $request->input('date',date("Ymd",strtotime('-1 day')));		//交易日期，格式：yyyyMMdd
        $skip       = $request->input('skip',0);
        $take       = $request->input('take',15);
        $file = storage_path('app/uniondz/'.$trans_date.'.csv');
        $data = Excel::load($file,function($reader)use($skip,$take){
        });
        $result = $data->get();
        $amount = 0;
        foreach($result as $k=>$v){
            $amount += $v->_5;
            if(is_null($v[0]) ){
                unset($result[$k]);
                unset($result[$k+1]);
                break;
            }
        }
        return array('ls_zje'=>$amount,'data'=>$result);

    }
}
