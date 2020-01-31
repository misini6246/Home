<?php

namespace App\Http\Controllers;

use App\AccountLog;
use App\Category;
use App\DaoRu;
use App\DeliveryOrder;
use App\Goods;
use App\GoodsCids;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TongJiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ms = $request->input('key');
        $date = $request->input('date',date('Ymd'));
        $show_area = $request->input('show_area');
        $key = md5('lilong70133'.$date.$show_area);
        if($ms!=$key){
            return redirect()->to('/');
        }
        $kong_count = Cache::tags(['show_area', 'tongji',$date])->get('kong');//空搜索
        $a =  Cache::tags(['show_area', 'tongji',$date])->get($date.'_search');//统计版块点击
        $b =  Cache::tags(['ss_to_cart', 'tongji',$date])->get($date.'_'.'cart');
        $c =  Cache::tags(['goods', 'tongji',$date])->get($date.'_'.'ids');
        $d = [];
        if(!empty($c)) {
            foreach ($c as $v) {
                $data = Cache::tags(['goods', 'tongji', $date])->get($date . '_' . $v);
                $d[$v] = $data;
            }
        }
        $show_area_arr = [];
        $show_area_arr[11] =  Cache::tags(['show_area', 'tongji',$date])->get($date.'_11');//统计版块点击
        $show_area_arr[2] =  Cache::tags(['show_area', 'tongji',$date])->get($date.'_2');//统计版块点击
        $show_area_arr[3] =  Cache::tags(['show_area', 'tongji',$date])->get($date.'_3');//统计版块点击
        $show_area_arr['zy'] =  Cache::tags(['show_area', 'tongji',$date])->get($date.'_zy');//统计版块点击
        Cache::tags($date)->flush();
        return [$kong_count,$a,$b,$d,$show_area_arr];
    }


    public function daoru(){
        set_time_limit(600);
        $file = storage_path('app/daoru/daoru.xlsx');
        $data = Excel::load($file,function($reader){
        })->get();
        foreach($data as $k=>$val){
            if($k==0){
                foreach($val as $key=>$v){
                    $goods_sn = $v->_1;
                    $d_cat = trim($v->_13);//大分类
                    $z_cat = trim($v->_14);//中分类
                    $x_cat = trim($v->_15);//小分类

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
        //dd($data);
    }

    public function daoru1(){
        set_time_limit(600);
        $file = storage_path('app/daoru/daoru1.xls');
        $data = Excel::load($file,function($reader){
        })->get();
        foreach($data as $k=>$val){
            if($k==0){
                foreach($val as $key=>$v){
                    $goods_sn = $v[0];
                    $d_cat = trim($v[1],',');//大分类
                    $z_cat = trim($v[2],',');//中分类
                    $x_cat = trim($v[3],',');//小分类
                    if(strpos($d_cat,'健康食品')!==false){
                        $d_cat = '健康食品（QS）';
                    }
                    if(strpos($d_cat,'美妆护理类')!==false){
                        $d_cat = '美妆护理';
                    }
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
        //dd($data);
    }

    public function tongbu(){
        set_time_limit(600);
        $result = GoodsCids::where('sync',0)->get();
        //GoodsCids::where('sync',0)->chunk(200,function($result){
            foreach($result as $v){
                $cat1_id = Category::
                //where('cat_name','like','%'.$v->cat1.'%')->
                where('cat_name',$v->cat1)->
                where('parent_id',0)->select('cat_id','cat_name')->first();
                if($cat1_id) {
                    $cid = $cat1_id->cat_id;
                    $cat_name = $cat1_id->cat_name.',';
                    $cat2_id = Category::
                    //where('cat_name', 'like', '%' . $v->cat2 . '%')->
                    where('cat_name',$v->cat2)->
                    where('parent_id',$cid)->select('cat_id','cat_name')->first();
                    if($cat2_id){
                        $cid = $cat2_id->cat_id;
                        $cat_name .= $cat2_id->cat_name.',';
                        $cat3_id = Category::
                        //where('cat_name','like','%'.$v->cat3.'%')->
                        where('cat_name',$v->cat3)->
                        where('parent_id',$cid)->select('cat_id','cat_name')->first();
                        if($cat3_id){
                            $cid = $cat3_id->cat_id;
                            $cat_name .= $cat3_id->cat_name.',';
                        }
                    }
                    $goods_info = Goods::where('goods_sn',$v->goods_sn)->select('goods_id','cat_ids')->first();
                    $cids_str = isset($goods_info->cat_ids)?trim($goods_info->cat_ids):'';
                    if($goods_info) {
                        if (!empty($cids_str)) {
                            $cids_arr = explode(',', $cids_str);
                            if (!in_array($cid, $cids_arr)) {
                                $cids_arr[] = $cid;
                            }
                            foreach($cids_arr as $b=>$c){
                                if(empty($c)){
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
                        $cat_name = rtrim($cat_name,',');
                        //dd($goods_info,$cat_name);
                        GoodsCids::where('rec_id', $v->rec_id)->update(['sync' => 1,'cat_ids'=>$goods_info->cat_ids,'cat_str'=>$cat_name,'cids'=>$cid]);
                    }
                    //dd($v->rec_id,GoodsCids::find($v->rec_id),GoodsCids::where('rec_id',$v->rec_id)->first());
                }
                //dd($cat1_id,$cid);
            }
        //});
    }

    public function bijiao(){
        set_time_limit(600);
        $result = GoodsCids::where('sync',1)->get();
        $arr = [];
        foreach($result as $v){
            $cat_arr = explode(',',$v->cat_str);
            $a = [];
            if(!in_array($v->cat1,$cat_arr)){
                $a[] = $v->cat1.$v->goods_sn;
            }
            if(!in_array($v->cat2,$cat_arr)){
                $a[] = $v->cat1.','.$v->cat2.$v->goods_sn;
            }
            if(!in_array($v->cat3,$cat_arr)&&!empty($v->cat3)){
                $a[] = $v->cat1.','.$v->cat2.','.$v->cat3.$v->goods_sn;
            }
            if(!empty($a)&&strpos($v->cat1,'中药饮片')===false) {
                $arr[] = $a;
            }
        }
        $arr = array_dot($arr);
        dd($arr);
    }

    public function duibi(){
        set_time_limit(600);
        $goods = Goods::where('is_on_sale',1)
            ->select('goods_id','goods_sn','goods_name','show_area','cat_ids')
            //->take(100)
            ->get();
        $export = [];
        $export[] = ['货号','品名','显示区域','1级分类','2级分类','3级分类'];
        foreach($goods as $v){
            $info = [];
            $info[] = $v->goods_sn;
            $info[] = $v->goods_name;
            $show_area = explode(',',$v->show_area);
            $show_area_str = '';
            if(!empty($show_area)){
                foreach ($show_area as $area) {
                    $show_area_str .= trans('category.show_area.'.$area).',';
                }
            }
            $show_area_str = rtrim($show_area_str,',');
            $info[] = $show_area_str;
            $cat_ids = $v->cat_ids;
            $cat1 = '';
            $cat2 = '';
            $cat3 = '';
            if(!empty($cat_ids)){
                $cat_ids_arr = explode(',',$cat_ids);
                $cat_name = Category::with([
                    'cate1'=>function($query){
                        $query->with('cate1');
                    }
                ])->whereIn('cat_id',$cat_ids_arr)->get();
                foreach($cat_name as $name){
                    if($name->cat_id>=450) {
                        if ($name->cate1) {//存在父级
                            if ($name->cate1->cate1) {//存在父级
                                $name->cat1 = $name->cate1->cate1->cat_name;
                                $name->cat2 = $name->cate1->cat_name;
                                $name->cat3 = $name->cat_name;
                                $cat1 .= $name->cat1 . ',';
                                $cat2 .= $name->cat2 . ',';
                                $cat3 .= $name->cat3 . ',';
                            } else {
                                $name->cat1 = $name->cate1->cat_name;
                                $name->cat2 = $name->cat_name;
                                $cat1 .= $name->cat1 . ',';
                                $cat2 .= $name->cat2 . ',';
                            }
                        } else {
                            $name->cat1 = $name->cat_name;
                            $cat1 .= $name->cat1 . ',';
                        }
                    }
                }
            }
            $info[] = $cat1;
            $info[] = $cat2;
            $info[] = $cat3;
            $export[] = $info;
        }
        Excel::create('商品分类',function($excel) use ($export){
            $excel->sheet('goods', function($sheet) use ($export){
                $sheet->rows($export);
            });
        })->export('xls');
    }


    /**
     * 积分重复发放
     */
    public function jfcf(){
        set_time_limit(600);
        $fhd = DeliveryOrder::with('order_action')->where('add_time','>',strtotime('2016-05-01'))->where('add_time','<=',strtotime('2016-06-01'))
            ->orderBy('add_time','desc')

            ->get();
        $export = [];
        $export[] = ['企业名称','订单编号'];
        $arr = [];
        $qc = [];
        foreach($fhd as $v){
            $info = [];
            if(count($v->order_action)>1){//重复操作
                $log1 = AccountLog::where('change_desc','like','订单 '.$v->order_sn.' 赠送的积分%')->get();
                $log2 = AccountLog::where('change_desc','like','由于退货或未发货操作，退回订单 '.$v->order_sn.' 赠送的积分%')->get();
                $num1 = count($log1);
                $num2 = count($log2);
                if($num1-$num2>1){
                    $user_info = User::where('user_id',$log1[0]->user_id)->select('msn')->first();
                    if(!isset($qc[$user_info->msn.$v->order_sn])) {
                        $info = [$user_info->msn, $v->order_sn];
                        $arr[] = $v;
                        $export[] = $info;
                        $qc[$user_info->msn.$v->order_sn] = 1;
                    }
                }
            }
        }
        //dd($arr);
        Excel::create('积分',function($excel) use ($export){
            $excel->sheet('jf', function($sheet) use ($export){
                $sheet->rows($export);
            });
        })->export('xls');
    }

    public function zygly(){
        $file = storage_path('app/daoru/zygly.xlsx');
        $data = Excel::load($file,function($reader){
        })->skip(100)
            ->take(100)
            ->get();
        $now = time();
        $data = $data[0];
        foreach($data as $k=>$val){
            $msn = $val[0];
            $val->_1 = trim($val->_1,'.');
            $up_arr = [
                'former_admins' => $val->_1,
                'ls_zpgly' => $val->_3,
                'divide_time' => $now,
                'sex' => 3,
            ];
            //dd($up_arr,$msn,$val);
            User::where('msn',$msn)->update($up_arr);
            echo $msn.'<br/>';
        }
    }
}
