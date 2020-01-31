<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/4/12
 * Time: 13:43
 */

namespace App\Http\Controllers;

use App\Category;
use App\GoodsCids;
use App\Goods;
use App\User;
use App\Article;
use App\GoodsCat;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\AccountLog;

class GoodsCategoryController extends Controller
{

    private $k=0 ;
    private $y=0 ;
    public function tongbu_category()
    {

        set_time_limit(600);
        $result = GoodsCids::where('sync', 0)->get();
        //GoodsCids::where('sync',0)->chunk(200,function($result){
        foreach ($result as $v) {
            $cat1_id = Category::
            //where('cat_name','like','%'.$v->cat1.'%')->
            where('cat_name', $v->cat1)->
            where('parent_id', 0)->select('cat_id', 'cat_name')->first();
            if ($cat1_id) {
                $cid = $cat1_id->cat_id;
                $cat_name = $cat1_id->cat_name . ',';
                $cat2_id = Category::
                //where('cat_name', 'like', '%' . $v->cat2 . '%')->
                where('cat_name', $v->cat2)->
                where('parent_id', $cid)->select('cat_id', 'cat_name')->first();

                if ($cat2_id) {
                    $cid = $cat2_id->cat_id;
                    $cat_name .= $cat2_id->cat_name . ',';
                    $cat3_id = Category::
                    //where('cat_name','like','%'.$v->cat3.'%')->
                    where('cat_name', $v->cat3)->
                    where('parent_id', $cid)->select('cat_id', 'cat_name')->first();

                    if ($cat3_id) {
                        $cid = $cat3_id->cat_id;
                        $cat_name .= $cat3_id->cat_name . ',';
                    }
                }
                $goods_info = Goods::where('goods_sn', $v->goods_sn)->select('goods_id', 'cat_ids')->first();
                $cids_str = isset($goods_info->cat_ids) ? trim($goods_info->cat_ids) : '';

                if ($goods_info) {
                    if (!empty($cids_str)) {
                        $cids_arr = explode(',', $cids_str);
                        if (!in_array($cid, $cids_arr)) {
                            $cids_arr[] = $cid;
                        }
                        foreach ($cids_arr as $b => $c) {
                            if (empty($c)) {
                                unset($cids_arr[$b]);
                            }
                        }
                        $cids_str = implode(',', $cids_arr);
                        $goods_info->cat_ids = $cids_str;
                        $goods_info->save();
                    } else {
                        $goods_info->cat_ids = $cid;
                        $goods_info->save();
                    }
                    $cat_name = rtrim($cat_name, ',');
                    GoodsCids::where('rec_id', $v->rec_id)->update(['sync' => 1, 'cat_ids' => $goods_info->cat_ids, 'cat_str' => $cat_name, 'cids' => $cid]);
                } else {
                    echo "<h1>商品为空！<h1/>";
                }
                //dd($v->rec_id,GoodsCids::find($v->rec_id),GoodsCids::where('rec_id',$v->rec_id)->first());
            }
            //dd($cat1_id,$cid);
        }
        //});


    }

    public function qingkong(){

        DB::table('goods')
            ->update([
                'show_area'=>'','cat_ids'=>''
            ]);
    }

    public function yuanjian()
    {
        set_time_limit(600);
        $file = public_path('yuanwenjian.xls');
        $data = Excel::load($file, function ($reader) {
        })->get();
        foreach ($data as $k => $v) {
            $goods = Goods::where('goods_sn', $v->goods_sn)->get();
            if ($goods) {
                $arr = explode(',', $v->show_area);
                if ($arr[0] == 4) {
                    Goods::where('goods_sn', $v->goods_sn)->update(
                        ['show_area' => $v->show_area,
                            'cat_ids' => $v->cat_ids
                        ]
                    );
                }
            }
        }
    }

    public function daoru()
    {

        set_time_limit(600);
        $this->qingkong();
        $file = public_path('wenjian3.xls');
        $data = Excel::load($file, function ($reader) {
        })->get();
        foreach ($data as $k => $v) {
            $show_area = trim($v->show_area) == "#N/A" ? '' : trim($v->show_area);
            $cat_ids = trim($v->cat_ids) == "#N/A" ? '' : trim($v->cat_ids);
            //  $zuijia = trim($v->zuijia) == "#N/A" ? '' : trim($v->zuijia);
            // $a = $cat_ids.$zuijia;
            $erp_shangplx= '';
            $goods = Goods::where('goods_sn', intval($v->goodsid))->get();
            if ($goods) {
                foreach ($goods as $val) {
                    if($val->erp_shangplx == '含特殊药品复方制剂'){
                        $erp_shangplx = '180,427,';
                    }
                    if ($val->goods_sn == intval($v->goodsid)) {
                        Goods::where('goods_sn', $val->goods_sn)->update(
                            ['show_area' => $show_area,
                                'cat_ids' => $erp_shangplx.$cat_ids
                            ]
                        );
                    }
                }
                echo  intval($v->goodsid).'---->'.$v->_10.'----->执行完成<br/>';
            }else{
                echo "导入失败";
            }
        }

        exit();
        foreach ($data as $k => $val) {
            if ($k == 0) {
                foreach ($val as $key => $v) {
//                     var_dump($v);exit();
                    $goods_sn = $v->goodsid;
                    $d_cat = trim($v->_1);//大分类
                    $z_cat = trim($v->_2);//中分类
                    $x_cat = trim($v->_3);//小分类

                    $goods = new GoodsCids();
                    $goods->goods_sn = $goods_sn;
                    $goods->cat1 = $d_cat;
                    $goods->cat2 = $z_cat;
                    $goods->cat3 = $x_cat;
                    //dd($goods);
                    $goods->save();
//                    if($key==6348){
//                        dd($v,$goods);
//                    }
                }
            }
        }

    }

    public function zuijia(){
        set_time_limit(600);
        $file = public_path('zuijia.xls');
        $data = Excel::load($file, function ($reader) {
        })->get();
        foreach ($data as $k => $v) {
            $zuijia = trim($v->_8) == "#N/A" ? '' : trim($v->_8);
            // $a = $cat_ids.$zuijia; 
            //$erp_shangplx= '';
            $goods = Goods::where('goods_sn', intval($v->goodsid))->get();
            if ($goods) {
                foreach ($goods as $val) {
                    if ($val->goods_sn ==  intval($v->goodsid)) {
                        Goods::where('goods_sn', $val->goods_sn)->update(
                            [
                                'cat_ids' => $val->cat_ids.$zuijia
                            ]
                        );
                    }
                }
                echo  intval($v->goodsid).'---->'.$v->_8.'---->追加完成<br/>';
            }else{
                echo "追加失败";
            }
        }
    }


    public function xiugai(){
        set_time_limit(600);
        $file = public_path('xiugai.xls');
        $data = Excel::load($file, function ($reader) {
        })->get();
        foreach ($data as $k => $v) {

            //   $zuijia = trim($v->_8) == "#N/A" ? '' : trim($v->_8);
            // $a = $cat_ids.$zuijia;
            //$erp_shangplx= '';
            $goods = Goods::where('goods_sn', intval($v->id))->get();
            if ($goods) {
                foreach ($goods as $val) {
                    if ($val->goods_sn ==  $v->id) {
                        Goods::where('goods_sn', $val->goods_sn)->update(
                            [
                                'show_area' => $val->show_area.',2'
                            ]
                        );
                    }
                }
                echo  $val->goods_name.'---->'.$v->id.'---->修改完成<br/>';
            }else{
                echo "追加失败";
            }
        }
    }
    public function xiugai2()
    {
        set_time_limit(600);
        $file = public_path('xiugai2.xls');
        $data = Excel::load($file, function ($reader) {
        })->get();
        foreach ($data[0] as $k => $v) {
            $goods = Goods::where('goods_sn', intval($v->goods_sn))->get();
            if ($goods) {
                foreach ($goods as $val) {
                    if ($val->goods_sn == $v->goods_sn) {
                        if (empty($val->show_area)) {
                            Goods::where('goods_sn', $val->goods_sn)->update(
                                [
                                    'show_area' => $v->show_area
                                ]
                            );
                            echo $val->goods_name . '---->' . $v->goods_sn . '---->修改完成<br/>';
                        }else{
                            echo $val->goods_name . '---->' . $v->goods_sn.'有默认值';
                        }
                    }
                }
            } else {
                echo "追加失败";
            }
        }
    }
    /*
     * 测试
     * */
    public function demo()
    {
        /*     $cellDate = Category::where('is_show',1)->select('cat_id','cat_name','parent_id')->get();
             $arr = '';
             $arr2='';
             $arr3='';
             foreach ($cellDate as $k=>$v){
                 if($v->parent_id == 0){
                     $arr[$k]['id']= $v->cat_id;
                     $arr[$k]['name']=$v->cat_name;
                     $cat_id =  Category::where('is_show',1)-> where('parent_id',$v->cat_id)->select('cat_id','cat_name','parent_id')->get();
                     if($cat_id){
                        foreach ($cat_id as $ke=>$va){
                            $arr2[$ke]['id']= $va->cat_id;
                            $arr2[$ke]['name']=$va->cat_name;
                            $arr[$k]['category']= $arr2 ;
                             $cat_id2 =  Category::where('is_show',1)-> where('parent_id',$va->cat_id)->select('cat_id','cat_name','parent_id')->get();

                            if($cat_id2){
                                 foreach ($cat_id2 as $key=>$val){
                                     $arr3[$key]['id']= $val->cat_id;
                                     $arr3[$key]['name']=$val->cat_name;
                                     $arr[$k]['category'][$key]['category']= $arr3 ;
                                 }
                             }
                         }
                     }
                 }

             }*/
        /*foreach ($cellDate as $k=>$v){
        if($v->parent_id == 0){
            $arr[$k]= [$v->cat_id=>$v->cat_name];
            $cat_id =  Category::where('is_show',1)-> where('parent_id',$v->cat_id)->select('cat_id','cat_name','parent_id')->get();
            if($cat_id){

                foreach ($cat_id as $ke=>$va){
                    $arr[$k][$ke]= [$va->cat_id=>$va->cat_name] ;
                    $cat_id2 =  Category::where('is_show',1)-> where('parent_id',$va->cat_id)->select('cat_id','cat_name','parent_id')->get();

                    if($cat_id2){
                        foreach ($cat_id2 as $key=>$val){
                            // dd($arr[$k][$ke]);
                            $arr[$k][$ke][$key]= [$val->cat_id=>$val->cat_name] ;
                        }
                    }
                }
            }
        }

    }*/


        //导出文件
        /*        Excel::create('分类导出', function ($excel) use ($arr) {
                    $excel->sheet('score', function ($sheet) use ($arr) {
                        $sheet->rows($arr);
                    });
                })->export('xls');*/
    }

    public function paiwei($arr)
    {
        print_r($arr);
        // dd($arr[0]);
        $paiwei = '';
        foreach ($arr as $k => $v) {
            foreach ($v as $k2 => $v2) {
                for ($i = 0; $i < count($v2); $i++) {
                    if (is_array($v2)) {
                        echo $k2 . '<br/>';
                    } else {
                        echo $k2 . '<br/>';
                    }

                }
            }
        }


       // dd($paiwei);

    }

    public function getSubTree($data, $id = 0, $lev = 0)
    {
        static $son = array();

        foreach ($data as $key => $value) {
            if ($value['parent_id'] == $id) {
                $value['lev'] = $lev;
                $son[] = $value;
                $this->getSubTree($data, $value['id'], $lev + 1);
            }
        }

        return $son;
    }
    public function addUser()
    {

        $file = public_path('user2.xls');
        $data = Excel::load(
            $file,
            function ($reader) {
            }
        )->get();

        $k = 0;
        $j = 0;
        foreach ($data[0] as $v) {
            $user = User::where('wldwid', $v->wldwid)->first();
            if (!$user) {
                $user_name = User::where('user_name',$v->user_name)->count();
                if ($user_name > 0) {

                    $users = $v->user_name.$user_name;

                } else {
                    $users = $v->user_name;
                }

                $salt = rand(1000, 9999);
          /*   DB::table('users')->insert(
                    [
                        'user_name' => $users,
                        'password' => md5(md5('123456').$salt),
                        'user_rank' => 2,
                        'ls_review' => 1,
                        'ls_name' => $v->ls_name,
                        'msn' => $v->msn,
                        'zs_time' => $v->xkz_time,
                        'msn_zjm' => $v->msn_zjm,
                        'yyzz_time' => $v->yyzz_time,
                        'yljg_time' => $v->yljg_time,
                        'xkz_time' => $v->xkz_time,
                        'cgwts_time' => $v->cgwts_time,
                        'org_cert_validity' => $v->org_cert_validity,
                        'shipping_name' => $v->shipping_name,
                        'mobile_phone' => !empty($v->tel) ? $v->tel : '123456789',
                        'country' => 1,
                        'province' => 32,
                        'city' => 394,
                        'district' => 3329,
                        'reg_time' => strtotime($v->reg_time->today()->toDateTimeString()),
                        'last_login' => time(),
                        'last_ip' => $_SERVER["REMOTE_ADDR"],
                        'visit_count' => 1,
                        'wldwid' => $v->wldwid,
                        'wldwid1' => $v->wldwid,
                        'update_time' => time(),
                        'ec_salt' => $salt,
                    ]
                );*/

               // echo $j++.',';
            }else{
                echo $k++,',';
            }
        }
    }



    public function chufang()
    {

        $file = public_path('tmp001.xls');
        $data = Excel::load($file, function ($reader) {})->get()[0];
        $a=$data->chunk(500);
    
        for ($i=0;$i<count($a);$i++){
            foreach ($a[$i] as $item){
                $chufang = DB::table('user_chufang')->where('wldwid', $item->customid)->where('shangplx', $item->rx)->get();
                if(!$chufang){
                   DB::table('user_chufang')->insert(['wldwid' => $item->customid, 'shangplx' => $item->rx]);
                    $this->k = $this->k+1;
                }else{
                   if(count($chufang)>1){
                       DB::table('user_chufang')->where('wldwid', $item->customid)->where('shangplx', $item->rx)->delete();
                       DB::table('user_chufang')->insert(['wldwid' => $item->customid, 'shangplx' => $item->rx]);
                        $this->y = $this->y+1;
                    }
                 //$this->y = $this->y+1;
                }
            }
        }
        echo '修改'.$this->y .'已有记录/n';
        echo '添加'.$this->k .'条记录';
    }


    //11.1活动会员余额
    public function user_jine()
    {
        dd(1);
        $file = public_path('qiandao1.xls');
        $data = Excel::load($file, function ($reader) {})->get();
        $data->map(function ($itme){
            $user = User::where('user_id',$itme->user_id)->first();
            if($user){
                log_account_change($itme->user_id,  $itme->je, 0, 0, 0, '11.1签到送现金',99);
                echo 1;
            }else{
               echo $itme->user_name;
            }

       });
    }
    public function user_jian_jine()
    {
dd(1);
        $file = public_path('jine.xls');
        $data = Excel::load($file, function ($reader) {})->get();
        $data->map(function ($itme){
            $user = User::where('user_id',$itme->user_id)->first();
            if($user){
                $account_log = new AccountLog();
                $account_log->user_id = $itme->user_id;
                $account_log->user_money = -$itme->jine;
                $account_log->frozen_money = 0;
                $account_log->rank_points = 0;
                $account_log->pay_points = 0;
                $account_log->change_time = time();
                $account_log->change_desc = '过期扣除(11.1签到送现金)';
                $account_log->change_type = 99;
                DB::transaction(function () use ($account_log,$itme) {
                    /* 插入帐户变动记录 */
                    $account_log->save();
                    /* 更新用户信息 */
                    $user = User::find($itme->user_id);
                    $user->user_money = $user->user_money - $itme->jine;
                    $user->frozen_money = $user->frozen_money - $account_log->frozen_money;
                    $user->rank_points = $user->rank_points - $account_log->rank_points;
                    $user->pay_points = $user->pay_points - $account_log->pay_points;

                    $user->save();
                });
            }

        });
    }

}