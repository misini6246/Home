<?php

namespace App\Http\Controllers\sync;

use App\erp\Dwbm;
use App\erp\Spkc;
use App\erp\Spzl;
use App\erp\SpzlJg;
use App\erp\Wldwjyfw;
use App\erp\Wldwzl;
use App\erp\Xschmx;
use App\Goods;
use App\GoodsAttr;
use App\KeyRed;
use App\kxpzPrice;
use App\MemberPrice;
use App\OrderAction;
use App\OrderGoods;
use App\OrderInfo;
use App\User;
use App\Wulzl;
use Illuminate\Http\Request;
use App\erp\Wulzl as WulzlErp;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonController;

class SyncController extends Controller
{
    public function __construct(){
        set_time_limit(300);
    }
    /*
     *需查询的字段：内码spid、包装规格bzgg、产地shpchd
     */
    public function tongbuchandi(){
        $arr = Spzl::select('spid','bzgg','shpchd')->get();
        foreach($arr as $v){
            $row = Goods::where('ERPID',$v->spid)->where('show_area',4)->pluck('goods_id');
            if($row) {
                $goods_id = $row;
                //echo $goods_id . '<br />' ;
                $goods_attr = GoodsAttr::where('goods_id',$goods_id)->where('attr_id',5)->first();
                if(!empty($goods_attr)){
                    if($goods_attr->attr_value!=$v->shpchd) {
                        $goods_attr->attr_value = $v->shpchd;
                        $goods_attr->save();
                    }
                }
            }
        }
    }
    /*
     * 同步冲红
     */
    public function tongbuchonghong(){
        $result = Xschmx::where('is_sync',0)
            ->select('djbh','dj_sn','rq','wldwid','wldwid1','spid','pihaoxs','baozhiqi','sxrq','shl','hshj','hsje')
            ->get();
        foreach($result as $k=>$v){
            $keyRed = new KeyRed();
            $keyRed->dibh = $v->djbh;
            $keyRed->di_sn = $v->dj_sn;
            $keyRed->rq = $v->rq;
            $keyRed->wldwid = $v->wldwid;
            $keyRed->wldwid1 = $v->wldwid1;
            $keyRed->spid = $v->spid;
            $keyRed->pihaoxs = $v->pihaoxs;
            $keyRed->baozhiqi = $v->baozhiqi;
            $keyRed->sxrq = $v->sxrq;
            $keyRed->shl = $v->shl;
            $keyRed->hshi = $v->hshj;
            $keyRed->hsie = $v->hsje;
            DB::transaction(function()use($keyRed,$result){
                $keyRed->save();
                $result->is_sync = 1;
                $result->save();
            });
            //echo $k;
            //echo ",";
        }
    }
    /*
     * 同步货号
     * 需查询的字段：内码spid、库存kcshl、网上售价huiytj、最低售价1 wlshj1
     */
    public function tongbuhuohao(){
        $goods = Spzl::select('spid','spbh')->get();
        foreach ($goods as $k=>$v) {
            if(Goods::where('ERPID',$v->spid)->update(['goods_sn'=>$v->spbh])){
                //echo $k;
                //echo ",";
            }
        }
    }
    /*
     * 同步价格
     * 需查询的字段：内码spid、仓库ckid、网上售价huiytj、最低售价1huiytj1、网上售价2huiytj2
     * @param  integer $ERPID 内码
     * @param  integer $shop_price 本店售价，对应ERP中网上售价
     * @param  integer $user_price 医药公司售价，对应ERP中最低售价1
     * @param  integer $user_price 新疆售价，对应ERP中最低售价2
     * @param  integer $zdgm 最低购买数量
     */
    public function tongbujiage()
    {
        $sql = "select spid,huiytj,huiytj1,zdxsshl,huiytj2,ckid from spzl_jg";

        $res = mssql_query($sql);

        $count_number = mssql_num_rows($res);
        $spjg = SpzlJg::select('spid', 'huiytj', 'huiytj1', 'zdxsshl', 'huiytj2', 'ckid')->get();
        foreach ($spjg as $k => $v) {
            DB::transaction(function () use ($v) {
                $goods = Goods::where('ERPID', $v->spid)->where(function ($query) use ($v) {
                    //$query->where('shop_price','!=',$v->huiytj)->orwhere('ckid','!=',$v->ckid);
                })->select('goods_id', 'old_shop_price', 'shop_price', 'ls_gg', 'log_old_price_time', 'ckid', 'is_read_zdgml')
                    ->first();
                if (!empty($goods)) {
                    if ($goods->shop_price != $v->huiytj || $goods->ckid != $v->ckid) {
                        $goods->old_shop_price = $goods->shop_price;
                        $goods->shop_price = $v->huiytj;
                        $goods->ls_gg = $v->zdxsshl;
                        $goods->log_old_price_time = time();
                        $goods->ckid = $v->ckid;
                    }
                    if ($goods->ls_gg != $v->zdxsshl && $goods->is_read_zdgml == 1) {
                        $goods->ls_gg = $v->zdxsshl;
                    }
                    $goods->save();
                    $member_price = $goods->member_price->where('user_rank', 1);
                    if (!empty($member_price)) {
                        $member_price->old_user_price = $member_price->user_price;
                        $member_price->user_price = $member_price->huiytj1;
                        $member_price->log_old_price_time = time();
                        $member_price->save();
                    } else {
                        $member_price = new MemberPrice();
                        $member_price->user_price = $member_price->huiytj1;
                        $goods->member_price()->save($member_price);
                    }
                    $kxpz = kxpzPrice::where('ERPID', $v->spid)->where('ls_regions', 'like', '%29%')->first();
                    if (!empty($kxpz)) {
                        $kxpz->area_price = $v->huiytj2;
                        $kxpz->save();
                    }
                }
            });
        }
    }
    /*
     * 同步库存
     */
    public function tongbukucun(){
        $spck = Spkc::where('is_sync',0)->select('spid','shl','ckid')->get();
        foreach($spck as $k=>$v){
            Goods::where('ERPID',$v->spid)->where('ckid',$v->ckid)->where('goods_number','!=',$v->shl)->update([
                'goods_number'=>$v->shl,
            ]);
            $v->is_sync = 1;
            $v->save();
        }
        $query2 = "select * from (select a.spid,min(a.sxrq) as xq,a.ckid from (select ckid,spid,sxrq,SUM(rkshl-chkshl) as total
from ywlsb group by ckid,spid,sxrq
having SUM(rkshl-chkshl) > 0) as a group by a.ckid,a.spid having min(a.sxrq) != '' ) as b
where b.spid not in
(select spid
from ywlsb group by ckid,spid,sxrq
having SUM(rkshl-chkshl) < 0) order by xq asc" ;
        $result2 = mssql_query($query2) ;

        $num2 = mssql_num_rows($result2) ;

        for($i=0;$i<$num2;$i++){
            $row2 = mssql_fetch_array($result2);
            sync_xiaoqi($row2[0],$row2[1],$row2[2]);
            //echo $i;
            //echo ",";
        }

        sleep(30) ;

        /**
         * ���ͬ��
         *
         * @param  varchar $spid ��Ʒ����
         * @param  varchar $rkshl
         * @param  varchar $chkshl
         *
         * @return boolean
         */
        function sync_kucun($spid,$goods_number,$ckid){
            if($goods_number < 0) $goods_number = 0 ;
            $sql = "UPDATE ecs_goods SET goods_number = '{$goods_number}' WHERE ERPID = '{$spid}' and ckid = '{$ckid}' and goods_number != '{$goods_number}'" ;
            $GLOBALS['db']->query($sql) ;
            $sql = "UPDATE spkc SET is_sync = 1 WHERE spid = '{$spid}' and ckid = '{$ckid}'" ;
            mssql_query($sql) ;
        }

        function sync_xiaoqi($spid,$xq,$ckid){
            $sql = "UPDATE ecs_goods SET xq = '{$xq}' WHERE ERPID = '{$spid}' and ckid = '{$ckid}' and xq != '{$xq}'" ;
            $GLOBALS['db']->query($sql) ;
        }
    }
    /*
     * 同步商品
     */
    public function tongbushangping(){
        $goods = Spzl::select('spid','spbh','spmch','pym','shengccj','dw','shpgg','pizhwh','jlgg')->paginate(20);
        foreach($goods as $k=>$v){
            $info = $v->goods;
            dd($v,$info);
            if(empty($info)) {
                //没有才插入
                $insertGoods = new Goods();
                $insertGoods->goods_sn = $v->spbh;
                $insertGoods->ERPID = $v->spid;
                $insertGoods->goods_name = $v->spmch;
                $insertGoods->ZJMID = $v->pym;
                $insertGoods->save();
                $insertAttr = [];
                if(!empty($v->shengccj)){
                    $attr = new GoodsAttr();
                    $attr->attr_id = 1;
                    $attr->attr_value = $v->shengccj;
                    $insertAttr[] = $attr;
                }
                if(!empty($v->dw)){
                    $attr = new GoodsAttr();
                    $attr->attr_id = 2;
                    $attr->attr_value = $v->dw;
                    $insertAttr[] = $attr;
                }
                if(!empty($v->shpgg)){
                    $attr = new GoodsAttr();
                    $attr->attr_id = 3;
                    $attr->attr_value = $v->shpgg;
                    $insertAttr[] = $attr;
                }
                if(!empty($v->pizhwh)){
                    $attr = new GoodsAttr();
                    $attr->attr_id = 4;
                    $attr->attr_value = $v->pizhwh;
                    $insertAttr[] = $attr;
                }
                if(!empty($v->jlgg)){
                    $attr = new GoodsAttr();
                    $attr->attr_id = 5;
                    $attr->attr_value = $v->jlgg;
                    $insertAttr[] = $attr;
                }
                if(!empty($insertAttr)){
                    $insertGoods->goods_attr()->saveMany($insertAttr);
                }
            }
        }
    }
    /*
     * 同步商品2
     */
    public function tongbushangping2(){
        $goods = Spzl::where('lasttime','>','2015-09-01 00:00:00')->where('spbh','not like','05%')
            ->select('spid','spbh','spmch','pym','shengccj','dw','shpgg','pizhwh','jlgg')->get();
        foreach($goods as $k=>$v){
            $info = $v->goods;
            if(!empty($info)) {
                if($info->goods_sn!=$v->spbh){
                    $info->goods_sn = $v->spbh;
                    $info->save();
                }
                $updateAttr = [];
                if(!empty($v->shengccj)){
                    $attr = $info->goods_attr->where('attr_id',1);
                    $attr->attr_value = $v->shengccj;
                    $updateAttr[] = $attr;
                }
                if(!empty($v->dw)){
                    $attr = $info->goods_attr->where('attr_id',2);
                    $attr->attr_value = $v->dw;
                    $updateAttr[] = $attr;
                }
                if(!empty($v->shpgg)){
                    $attr = $info->goods_attr->where('attr_id',3);
                    $attr->attr_value = $v->shpgg;
                    $updateAttr[] = $attr;
                }
                if(!empty($v->pizhwh)){
                    $attr = $info->goods_attr->where('attr_id',4);
                    $attr->attr_value = $v->pizhwh;
                    $updateAttr[] = $attr;
                }
                if(!empty($v->jlgg)){
                    $attr = $info->goods_attr->where('attr_id',5);
                    $attr->attr_value = $v->jlgg;
                    $updateAttr[] = $attr;
                }
                if(!empty($insertAttr)){
                    $info->goods_attr()->saveMany($updateAttr);
                }
            }
        }
    }
    /*
     * 同步属性 西药
     */
    public function tongbushuxingxiyao(){
        $newtime = time() - 60 * 60 * 24 ;
        $now_time = date('Y-m-d H:i:s', $newtime) ;
        $goods = Spzl::where('lasttime','>',$now_time)->where('spbh','not like','05%')
            ->select('spid','spbh','spmch','pym','shengccj','dw','shpgg','pizhwh','jlgg')->get();
        foreach($goods as $k=>$v){
            $info = $v->goods;
            if(!empty($info)) {
//                if($info->goods_sn!=$v->spbh){
//                    $info->goods_sn = $v->spbh;
//                    $info->save();
//                }
                $updateAttr = [];
                if(!empty($v->shengccj)){
                    $attr = $info->goods_attr->where('attr_id',1);
                    $attr->attr_value = $v->shengccj;
                    $updateAttr[] = $attr;
                }
                if(!empty($v->dw)){
                    $attr = $info->goods_attr->where('attr_id',2);
                    $attr->attr_value = $v->dw;
                    $updateAttr[] = $attr;
                }
                if(!empty($v->shpgg)){
                    $attr = $info->goods_attr->where('attr_id',3);
                    $attr->attr_value = $v->shpgg;
                    $updateAttr[] = $attr;
                }
                if(!empty($v->pizhwh)){
                    $attr = $info->goods_attr->where('attr_id',4);
                    $attr->attr_value = $v->pizhwh;
                    $updateAttr[] = $attr;
                }
                if(!empty($v->jlgg)){
                    $attr = $info->goods_attr->where('attr_id',5);
                    $attr->attr_value = $v->jlgg;
                    $updateAttr[] = $attr;
                }
                if(!empty($insertAttr)){
                    $info->goods_attr()->saveMany($updateAttr);
                }
            }
        }
    }
    /*
     * 同步物流
     */
    public function tongbuwuliu(){
        DB::table('wulzl')->truncate();
        $wulzl = WulzlErp::where('beactive','是')->select('wulid','wulbh','wulname','pym','beactive')->get();
        $insertWl = [];
        foreach ($wulzl as $k=>$v) {
            $insertWl[] = [
                'wulid'=>$v->wulid,
                'wulbh'=>$v->wulbh,
                'wulname'=>$v->wulname,
                'pym'=>$v->pym,
                'beactive'=>$v->beactive,
            ];
        }
        if(!empty($insertWl)){
            Wulzl::insert($insertWl);
        }
    }
    /*
     * 同步中药规格
     */
    public function tongbuzhongyaoguige(){
        $spzl = Spzl::where(function($query){
            $query->where('shengccj','四川博仁药业有限责任公司')
                ->orwhere('shengccj','四川皓博药业有限公司')
                ->orwhere('shengccj','四川原上草中药饮片有限公司')
                ->orwhere('shengccj','四川固康中药饮片有限责任公司')
                ->orwhere('shengccj','四川众仁药业有限公司')
                ->orwhere('shengccj','四川中庸药业有限公司')
                ->orwhere('shengccj','成都市都江堰春盛中药饮片股份有限公司')
                ->orwhere('shengccj','四川辅正药业有限责任公司')
                ->orwhere('shengccj','四川省天府神龙中药饮片有限公司')
                ->orwhere('shengccj','石家庄华鹏药业有限公司')
                ->orwhere('shengccj','四川泰康药业有限公司')
            ;
        })->where('bzgg','!=','')->where('shpgg','not like','%g%')
            ->where('shpgg','not like','%个%')->where('shpgg','not like','%袋%')
            ->where('shpgg','not like','%0%')->where('lasttime','>','2015-03-13 09:06:39')
            ->select('spid','shpchd',DB::raw('shpgg+bzgg as bsgg'))
            ->get();
        foreach($spzl as $k=>$v){
            $goods = $v->goods;
            if(!empty($goods)){
                if(!empty($v->bsgg)){
                    $goods->goods_attr->where('attr_id',3)->update([
                        'attr_value'=>$v->bsgg,
                    ]);
                }
                if(!empty($v->shpchd)){
                    $goods->goods_attr->where('attr_id',5)->update([
                        'attr_value'=>$v->shpchd,
                    ]);
                }
            }
        }
    }
    /*
     * 同步状态
     */
    public function tongbuzhuangtai(){
        //获取网站已确认，已付款，已开票的所有商品，更新订单出库中信息
        $resone = OrderInfo::where('order_status',1)->where('pay_status',2)->where('shipping_status',1)->select('order_sn','order_id')->get();
        foreach($resone as $k => $v) {
            $row = $v->order()->select('jh_ok','jianhrq')->first();
            //如果显示出库中
            if($row->jh_ok == '是') {
                //更新订单状态为出库中
                $v->shipping_status = 2;
                $v->save();
                $this->order_action_zt($v->order_id,1,2,2,'ERP状态回读：出库中','系统',0,strtotime($v->jianhrq));
            }
        }

        //获取网站已确认，已付款，出库中的所有商品，更新订单已出库信息
        $resone = OrderInfo::where('order_status',1)->where('pay_status',2)->where('shipping_status',2)->select('order_sn','order_id')->get();
        foreach($resone as $k => $v) {
            $row = $v->order()->select('chk_ok','chkrq')->first();
            //如果显示出库中
            if($row->chk_ok == '是') {
                //更新订单状态为出库中
                $v->shipping_status = 3;
                $v->save();
                $this->order_action_zt($v->order_id,1,3,2,'ERP状态回读：已出库','系统',0,strtotime($v->jianhrq));
            }
        }
    }
    /*
     * 记录日志
     */
    public function order_action_zt($order_id,$order_status,$shipping_status,$pay_status,$note='',$username=null,$place=0,$log_time){
        $orderAction = new OrderAction();
        $orderAction->order_id = $order_id;
        $orderAction->action_user = $username;
        $orderAction->order_status = $order_status;
        $orderAction->shipping_status = $shipping_status;
        $orderAction->pay_status = $pay_status;
        $orderAction->action_place = $place;
        $orderAction->action_note = $note;
        $orderAction->log_time = $log_time;
        $orderAction->save();
    }
    /*
     * 资质时效
     */
    public function zizhishixiao(){

        $zl = Wldwzl::select('yyzz_yxq','yljg_yxq','ypjy_yxq','GspSxrq','wldwid')->get();
        $result = [];
        foreach($zl as $k=>$v){
            if($k<3000) {
                $arr[] = [
                    'wldwid1' => trim($v->wldwid),
                    'yyzz_time' => trim($v->yyzz_yxq),
                    'yljg_time' => trim($v->yljg_yxq),
                    'xkz_time' => trim($v->ypjy_yxq),
                    'zs_time' => trim($v->GspSxrq),
                ];
                $result['arr'] = $arr;
            }elseif($k<6000){
                $arr1[] = [
                    'wldwid1' => trim($v->wldwid),
                    'yyzz_time' => trim($v->yyzz_yxq),
                    'yljg_time' => trim($v->yljg_yxq),
                    'xkz_time' => trim($v->ypjy_yxq),
                    'zs_time' => trim($v->GspSxrq),
                ];
                $result['arr1'] = $arr1;
            }elseif($k<9000){
                $arr2[] = [
                    'wldwid1' => trim($v->wldwid),
                    'yyzz_time' => trim($v->yyzz_yxq),
                    'yljg_time' => trim($v->yljg_yxq),
                    'xkz_time' => trim($v->ypjy_yxq),
                    'zs_time' => trim($v->GspSxrq),
                ];
                $result['arr2'] = $arr2;
            }elseif($k<12000){
                $arr3[] = [
                    'wldwid1' => trim($v->wldwid),
                    'yyzz_time' => trim($v->yyzz_yxq),
                    'yljg_time' => trim($v->yljg_yxq),
                    'xkz_time' => trim($v->ypjy_yxq),
                    'zs_time' => trim($v->GspSxrq),
                ];
                $result['arr3'] = $arr3;
            }elseif($k<15000){
                $arr4[] = [
                    'wldwid1' => trim($v->wldwid),
                    'yyzz_time' => trim($v->yyzz_yxq),
                    'yljg_time' => trim($v->yljg_yxq),
                    'xkz_time' => trim($v->ypjy_yxq),
                    'zs_time' => trim($v->GspSxrq),
                ];
                $result['arr4'] = $arr4;
            }
        }
        $this->fenupdate($result,'ecs_users');
        //return view('sync');
    }
    /*
     * 同步销量
     */
    public function sales_volume(){
        set_time_limit(600);
//        //$sales = OrderGoods::select(DB::raw('sum(goods_number) as num'))->groupBy('goods_id')->take(5)->get();
//        $sales = OrderGoods::select(DB::raw('sum(goods_number) as num'),'goods_id')->where('goods_id','>',0)->groupBy('goods_id')->orderBy('goods_id','desc')->chunk(5,function($result){
//            foreach($result as $v){
//                $goods = $v->goods()->select('goods_id')->first();
//                if(!empty($goods)){
//                    $goods->sales_volume = $v->num;
//                    $goods->save();
//                }
//            }
//        });
//        DB::table('sales_volume')->chunk(100,function($sales_volume){
//            foreach($sales_volume as $v){
//                $goods = Goods::where('goods_id',$v->goods_id)->select('goods_id','sales_volume')->first();
//                if(!empty($goods)){
//                    $goods->sales_volume = $v->sales_volume;
//                    $goods->save();
//                }
//            }
//        });

        //dd($sales);
    }

    /*
     * 同步经营范围
     */
    public function jingyinfanwei(){
        $jyfw = Wldwzl::select('wldwid','ypjy_fw','yljg_fw')->get();
        $result = [];
        foreach($jyfw as $v){
            $user_rank = User::where('wldwid1',$v->wldwid)->pluck('user_rank');
            if($user_rank == 2) {
                //药店
                if(strpos($v->ypjy_fw, '中药饮片') === false) {
                    $arr[] = [
                        'wldwid1'=>$v->wldwid,
                        'ls_mzy'=>1,
                    ];
                    $result['arr'] = $arr;
                }
            }elseif($user_rank == 5) {
                //诊所
                if(strpos($v->ypjy_fw, '中药饮片') === false && strpos($v->yljg_fw, '中医') === false && strpos($v->yljg_fw, '中西医') === false && strpos($v->yljg_fw, '全科') === false && !(strpos($v->yljg_fw, '内科') !== false && strpos($v->yljg_fw, '西医内科') === false) && strpos($v->ypjy_fw, '中医') === false && !(strpos($v->ypjy_fw, '内科') !== false && strpos($v->ypjy_fw, '西医内科') === false) && strpos($v->ypjy_fw, '中西医') === false && strpos($v->ypjy_fw, '全科') === false) {
                    //if($yljg_fw == '西医内科') {
                    $arr[] = [
                        'wldwid1'=>$v->wldwid,
                        'ls_mzy'=>1,
                    ];
                    $result['arr'] = $arr;
                }
            }
        }
        $wldwid = Wldwjyfw::where('shangplx','中药饮片')->lists('wldwid');
        foreach($wldwid as $v){
            $arr1[] = [
                'wldwid1'=>$v->wldwid,
                'ls_mzy'=>0,
            ];
            $result['arr1'] = $arr1;
        }
        $this->fenupdate($result,'ecs_users');
    }

    /*
     * 订单商品回读无优惠
     */
    public function dingdanshangpinhxwyh(){
        //无藿香正气水和甘草片优惠商品回写
        //order_status = 1 pay_status = 2 shipping_status = 1 is_sync = 0 时才进行回读
        //获取网站已确认，已付款，shipping_status >= 3 已出库，订单没有回读 的所有商品，更新订单开票信息
        $sql = "SELECT order_sn,order_id FROM ecs_order_info WHERE order_id >= 44500 and order_status = 1 AND pay_status = 2 AND shipping_status > 2 AND is_sync = 0 AND zyzk = 0 limit 30" ;
        $order = OrderInfo::where('order_id','>',44500)->where('order_status',1)->where('pay_status',2)
            ->where('shipping_status','>',2)->where('is_sync',0)->where('zyzk',0)->take(30)->get();
        foreach($order as $v){
            $total = \App\erp\OrderGoods::where('order_sn',$v->order_sn)->sum('yiwchsl');
            //如果回写数量不为0
//            if($total>0) {
//                $orderGoods = \App\erp\OrderGoods::where('order_sn', $v->order_sn)->select('rec_id', 'yiwchsl')->first();
//                if(!empty($orderGoods)){
//                    $goods_number_ls = OrderGoods::where('rec_id',$orderGoods->rec_id)->select('goods_name','goods_number','rec_id')->first();
//                    $goods_number = $goods_number_ls->goods_number;
//                    $goods_number_ls->goods_number = $orderGoods->yiwchsl;
//                    $goods_number_ls->save();
//                    if($goods_number!=$orderGoods->yiwchsl){
//                        $note = $orderGoods->order_sn.'中的'.$goods_number_ls->goods_name.'商品数量由'.$goods_number.'变成'.$orderGoods->yiwchsl.',';
//                        $sql = 'INSERT INTO ' . $GLOBALS['ecs']->table('admin_log') . ' (log_time, user_id, log_info, ip_address) ' .
//                            " VALUES ('" . gmtime() . "',1, '" . stripslashes($log_info) . "', '" . real_ip() . "')";
//                        $GLOBALS['db']->query($sql);
//
//                    }
//                }
//            }

//            for($i=0;$i<$Num;$i++) {
//                $rowtwo = mssql_fetch_array($tempres2);
//                if (!empty($rowtwo['rec_id'])) {
//                    //李龙
//                    $ls_sql = "SELECT goods_name,goods_number
//                      FROM " . $GLOBALS['ecs']->table('order_goods') .
//                        " WHERE rec_id = '{$rowtwo['rec_id']}'";
//                    $goods_number_ls = $db->getRow($ls_sql);
//
//                    $sqlthr = "UPDATE ecs_order_goods SET goods_number = {$rowtwo['yiwchsl']}, is_gsync = 1 WHERE rec_id = {$rowtwo['rec_id']}";
//                    $GLOBALS['db']->query($sqlthr);
//
//                    if ($goods_number_ls['goods_number'] != $rowtwo['yiwchsl']) {
//                        $ls_sl = $v['order_sn'] . '中的' . $goods_number_ls['goods_name'] . "商品数量由" . $goods_number_ls['goods_number'] . "变成" . $rowtwo['yiwchsl'] . ",";
//                        admin_log($ls_sl, '编辑', '会员');
//                        if ($rowtwo['yiwchsl'] == 0) {
//                            $ls_ll = '此商品缺货，如果已付款多余款项已退回此账户余额。';
//                        } elseif ($goods_number_ls['goods_number'] > $rowtwo['yiwchsl']) {
//                            $ls_ll = "此商品库存不足，数量由" . $goods_number_ls['goods_number'] . "变成" . $rowtwo['yiwchsl'] . "，如果已付款多余款项已退回此账户余额。";
//                        } else {
//                            $ls_ll = '';
//                        }
//                        $sql_bz = "UPDATE " . $GLOBALS['ecs']->table('order_goods') . " SET `user_bz` = '" . $ls_ll . "' WHERE `ecs_order_goods`.`rec_id` ='{$rowtwo['rec_id']}';";
//                        $db->query($sql_bz);
//                    }
//                    //李龙
//                }
//            }
        }

    }

    /*
     * 分段更新
     */
    private function fenupdate($result,$table){
        if(isset($result['arr'])){
            CommonController::updateBatch($table,$result['arr']);
        }
        if(isset($result['arr1'])){
            CommonController::updateBatch($table,$result['arr1']);
        }
        if(isset($result['arr2'])){
            CommonController::updateBatch($table,$result['arr2']);
        }
        if(isset($result['arr3'])){
            CommonController::updateBatch($table,$result['arr3']);
        }
        if(isset($result['arr4'])){
            CommonController::updateBatch($table,$result['arr4']);
        }
    }
}
