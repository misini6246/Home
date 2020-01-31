<?php

namespace App\Http\Controllers;

use App\AdminUser;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class QiTanController extends Controller
{


    public function gly(){
        $admin = AdminUser::whereIn('role_id',[31,22,4,26,14])->lists('user_name');
        $users_arr = [];
        $chongfu = [
            ['用户名','企业名称','管理员']
        ];
        foreach($admin as $v){
            $users = User::where('ls_zpgly','like','%'.$v.'%')->where('ls_zpgly','like','%.%')->select('user_id','user_name','msn','ls_zpgly')->get();
            if($users){
                foreach($users as $user){
                    if(isset($users_arr[$user->user_id])) {
                        $row = [$user->user_name,$user->msn,$user->ls_zpgly];
                        $chongfu[] = $row;
                    }else{
                        $users_arr[$user->user_id] = $user->msn;
                    }
                }
            }
        }
        Excel::create('管理员重复',function($excel) use ($chongfu){
            $excel->sheet('gly', function($sheet) use ($chongfu){
                $sheet->rows($chongfu);
            });
        })->export('xls');
        dd($chongfu);
    }

    public function xj_gly(){
        $admin = AdminUser::whereIn('role_id',[26,14])->lists('user_name');
        $users_arr = [];
        $chongfu = [
            ['用户名','企业名称','管理员']
        ];
        foreach($admin as $v){
            $users = User::where('ls_zpgly','like','%'.$v.'%')->where('ls_zpgly','like','%.%')->select('user_id','user_name','msn','ls_zpgly')->get();
            if($users){
                foreach($users as $user){
                    if(isset($users_arr[$user->user_id])) {
                        $row = [$user->user_name,$user->msn,$user->ls_zpgly];
                        $chongfu[] = $row;
                    }else{
                        $users_arr[$user->user_id] = $user->msn;
                    }
                }
            }
        }
//        Excel::create('管理员重复',function($excel) use ($chongfu){
//            $excel->sheet('gly', function($sheet) use ($chongfu){
//                $sheet->rows($chongfu);
//            });
//        })->export('xls');
        dd($chongfu);
    }

    public function gly_new(){
        $admin = AdminUser::whereIn('role_id',[32,28,24])->lists('user_name');
        $chongfu = [
            ['用户名','企业名称','管理员','市场部管理员']
        ];
        foreach($admin as $v){
            $users = User::where('ls_zpgly','not like','%'.$v.'%')->where('question',$v)->select('user_id','user_name','msn','ls_zpgly','question')->get();
            if($users){
                foreach($users as $user){
                    $info = [$user->user_name,$user->msn,$user->ls_zpgly,$user->question];
                    $chongfu[] = $info;
                }
            }
        }
        Excel::create('管理员重复',function($excel) use ($chongfu){
            $excel->sheet('gly', function($sheet) use ($chongfu){
                $sheet->rows($chongfu);
            });
        })->export('xls');
    }

    public function gly_dc(){
        $admin = AdminUser::whereIn('role_id',[32,28,24])->lists('user_name');
        $chongfu = [
            ['用户名','企业名称','管理员','市场部管理员','联系电话','联系人']
        ];
        $time = strtotime('2016-06-09');
        foreach($admin as $v){
            $users = User::with([
                'order_info' => function($query)use($time){
                    $query->where('order_status',1)->where('add_time','>',$time)->select('user_id');
                }
            ])->where('ls_zpgly','like','%'.$v.'%')
                ->select('user_id','user_name','msn','ls_zpgly','question','mobile_phone','ls_name','rank_points')->get();
            if($users){
                foreach($users as $user){
                    if(count($user->order_info)==0&&$user->rank_points>0){//最近三个月未购买过
                        $info = [$user->user_name,$user->msn,$user->ls_zpgly,$user->question,$user->mobile_phone,$user->ls_name];
                        $chongfu[] = $info;
                    }

                }
            }
        }
        Excel::create('3个月未购买会员',function($excel) use ($chongfu){
            $excel->sheet('users', function($sheet) use ($chongfu){
                $sheet->rows($chongfu);
            });
        })->export('xls');
    }


    public function users_wgm(){
        set_time_limit(600);
        $time = strtotime('2016-06-08');
        $users = User::with([
            'order_info' => function($query)use($time){
                $query->where('order_status',1)->where('add_time','>',$time)->select('user_id');
            }
        ])
            ->select('user_id','user_name','msn','ls_zpgly','mobile_phone','ls_name','rank_points')->get();
        $chongfu = [
            ['企业名称','管理员','电话','联系人']
        ];
        foreach($users as $user){
            if(count($user->order_info)==0&&$user->rank_points>0) {
                $info = [$user->msn, $user->ls_zpgly, $user->mobile_phone, $user->ls_name];
                $chongfu[] = $info;
            }
        }
        Excel::create('3个月未购买会员',function($excel) use ($chongfu){
            $excel->sheet('users', function($sheet) use ($chongfu){
                $sheet->rows($chongfu);
            });
        })->export('xls');
    }
}
