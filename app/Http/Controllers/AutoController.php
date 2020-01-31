<?php
/**
 * Created by PhpStorm.
 * User: 72788
 * Date: 2018/12/4
 * Time: 9:55
 */

namespace App\Http\Controllers;


use App\MemberPrice;
use App\Models\Goods;
use App\Models\GoodsAttr;
use App\Models\GoodsZp;
use App\Models\UserJyfw;
use App\Models\ZpGoods;
use App\OrderGoods;
use App\OrderInfo;
use App\User;
use App\UserAddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AutoController extends Controller
{

    //同步商品资料
    public function spzl(){
        header("content-type:text/html;charset=gbk");
        $tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 183.230.3.128)(PORT = 9001))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = jy12g)
    )
  )
       ";
        $db_username = "HZJK";
        $db_password = "hzjk";
        $conn = new \PDO('oci:dbname='.$tns,$db_username,$db_password);
        //连接Oracle
       // $query = "SELECT * FROM SPZL where SPID = '161762'";

      //  (select empno,ename from emp where rownum<m) minus (select empno,ename from emp where rownum<n);
        $query = "(SELECT * FROM SPZL where rownum < 19000) minus (SELECT * FROM SPZL where rownum < 18000)";
        $result = $conn->query($query);
        $res = $result->fetchAll(\PDO::FETCH_ASSOC);
        dd($res);
        foreach ($res as $key=>$v) {
            $v['LASTTIME'] = Carbon::parse($v['LASTTIME'])->getTimestamp();
           // dd($v);
            $this->TB_goods($v['SPID'], $v['SPMCH'], $v['SHPGG'], $v['SHENGCCJ'], $v['DW'], $v['PIZHWH'], $v['SHANGPLX'], $v['SPID'], $v['LASTTIME'], $v['PYM'] , $v['IS_NOT_SALE'] , $v['IS_ZP'] , $v['JLGG'] , $v['IS_ZBZ'] , $v['ZBZ'] , $v['BIEMING'] , $v['ZF'] , $v['SCZXBZ'] ,$v['SHPCHD']);
            echo $key+1;
            echo ",";
        };

        $conn = null;
    }
    //同步商品资料方法
    public function TB_goods($goods_sn, $goods_name, $ypgg, $product_name, $dw, $pzwh, $erp_shangplx, $ERPID, $last_update,  $ZJMID='' , $is_on_sale , $is_zx , $jlgg , $is_zbz , $zbz , $beiming , $scbz , $spcd)
    {

        $goods_sn = iconv('GBK', 'UTF-8//IGNORE', $goods_sn) ;
        $ypgg = iconv('GBK', 'UTF-8//IGNORE', $ypgg) ;
        $goods_name = iconv('GBK', 'UTF-8//IGNORE', $goods_name) ;
        $dw = iconv('GBK', 'UTF-8//IGNORE', $dw) ;
        $product_name = iconv('GBK', 'UTF-8//IGNORE', $product_name) ;
        $spcd = iconv('GBK', 'UTF-8//IGNORE', $spcd) ;
        $erp_shangplx = iconv('GBK', 'UTF-8//IGNORE', $erp_shangplx) ;
        $ERPID = iconv('GBK', 'UTF-8//IGNORE', $ERPID) ;
        $ZJMID = iconv('GBK', 'UTF-8//IGNORE', $ZJMID) ;
        $is_on_sale = iconv('GBK', 'UTF-8//IGNORE', $is_on_sale) ;
        $is_zx = iconv('GBK', 'UTF-8//IGNORE', $is_zx) ;
        $jlgg = iconv('GBK', 'UTF-8//IGNORE', $jlgg) ;
        $is_zbz = iconv('GBK', 'UTF-8//IGNORE', $is_zbz) ;
        $zbz = iconv('GBK', 'UTF-8//IGNORE', $zbz) ;
        $beiming = iconv('GBK', 'UTF-8//IGNORE', $beiming) ;
        $scbz = iconv('GBK', 'UTF-8//IGNORE', $scbz) ;
        $pzwh = iconv('GBK', 'UTF-8//IGNORE', $pzwh) ;
        $spcd = iconv('GBK', 'UTF-8//IGNORE', $spcd) ;

       // dd($goods_sn, $goods_name, $ypgg, $product_name, $dw, $pzwh, $erp_shangplx, $ERPID, $last_update,  $ZJMID , $is_on_sale , $is_zx , $jlgg , $is_zbz , $zbz , $beiming , $scbz , $spcd);

            $goods = Goods::where('ERPID', $ERPID)->where('ERPID','!=','')->first();
        //dd($goods);
        if (!$goods) {
            //没有选择插入
            $goods = New Goods();
            //使用

            $goods->goods_sn = $goods_sn;
            $goods->goods_name = $goods_name;
            $goods->ypgg = $ypgg;
            $goods->product_name = $product_name;
            $goods->erp_shangplx = $erp_shangplx;
            $goods->ERPID = $ERPID;
            $goods->add_time = $last_update;
            $goods->ZJMID = $ZJMID;
            $goods->ypbh = $goods_sn;
            $goods->is_on_sale = $is_on_sale;
            $goods->is_zx = $is_zx;

            $result = $goods->save();

            $goods_id = $goods->id;

            if($is_zx == 1 ){
                $zp_goods = New ZpGoods();
                $zp_goods->goods_id = $goods_id;
                $zp_goods->goods_sn = $goods_sn;
                $zp_goods->ERPID = $ERPID;
                $zp_goods->ZJMID = $ZJMID;
                $zp_goods->goods_name = $goods_name;
                $zp_goods->product_name = $product_name;
                $zp_goods->ypgg = $ypgg;

                $zp_goods->save();
                $zp_id = $zp_goods->id;

                $goods_zp = New GoodsZp();
                $goods_zp->goods_id = $goods_id;
                $goods_zp->zp_id = $zp_id;
                $goods_zp->save();
            }
            //dd($product_name.'111');
            if ($product_name != '') {
                $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},1,'{$product_name}')";
                DB::insert($sql);
            }

            if ($dw != '') {
                $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},2,'{$dw}')";
                DB::insert($sql);
            }

            if ($ypgg != '') {
                $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},3,'{$ypgg}')";
                DB::insert($sql);
            }

            if ($pzwh != '') {
                $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},4,'{$pzwh}')";
                DB::insert($sql);
            }

            if($jlgg != '') {
                $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},5,'{$jlgg}')" ;
                DB::insert($sql);
                }

            if($zbz != '' && $is_zbz == 1) {
                $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},211,'{$zbz}')" ;
                DB::insert($sql);
            }

        } else {
            $goods->goods_sn = $goods_sn;
            $goods->goods_name = $goods_name;
            $goods->ypgg = $ypgg;
            $goods->product_name = $product_name;
            $goods->erp_shangplx = $erp_shangplx;
            $goods->ERPID = $ERPID;
            $goods->add_time = $last_update;
            $goods->ZJMID = $ZJMID;
            $goods->ypbh = $goods_sn;
            $goods->is_on_sale = $is_on_sale;
            $goods->is_zx = $is_zx;

                $goods->save();
            //dd($product_name.'222');

           $goods_attr =  GoodsAttr::where('goods_id',$goods->goods_id)->get();
           //dd($goods_attr);
           if ($goods_attr->count() > 0 ){
               if ($product_name != '') {

                   $sql = "update ecs_goods_attr set attr_value = '{$product_name}' WHERE goods_id = $goods->goods_id AND attr_id = 1";
                   DB::update($sql);
               }

               if ($dw != '') {
                   $sql = "update ecs_goods_attr set attr_value = '{$dw}' WHERE goods_id = $goods->goods_id AND attr_id = 2";
                   DB::update($sql);
               }

               if ($ypgg != '') {
                   $sql = "update ecs_goods_attr set attr_value = '{$ypgg}' WHERE goods_id = $goods->goods_id AND attr_id = 3";
                   DB::update($sql);
               }

               if ($pzwh != '') {
                   $sql = "update ecs_goods_attr set attr_value = '{$pzwh}' WHERE goods_id = $goods->goods_id AND attr_id = 4";
                   DB::update($sql);
               }


               if($jlgg != '') {
                   $sql = "update ecs_goods_attr set attr_value = '{$jlgg}' WHERE goods_id = $goods->goods_id AND attr_id = 5";
                   DB::update($sql);
               }

               if($zbz != '' && $is_zbz == 1) {
                   $sql = "update ecs_goods_attr set attr_value = '{$zbz}' WHERE goods_id = $goods->goods_id AND attr_id = 211";
                   DB::update($sql);
               }
           }else{
               //dd(111);
               if ($product_name != '') {
                   $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},1,'{$product_name}')";
                   DB::insert($sql);
               }

               if ($dw != '') {
                   $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},2,'{$dw}')";
                   DB::insert($sql);
               }

               if ($ypgg != '') {
                   $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},3,'{$ypgg}')";
                   DB::insert($sql);
               }

               if ($pzwh != '') {
                   $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},4,'{$pzwh}')";
                   DB::insert($sql);
               }

               if($jlgg != '') {
                   $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},5,'{$jlgg}')" ;
                   DB::insert($sql);
               }

               if($zbz != '' && $is_zbz == 1) {
                   $sql = "INSERT INTO ecs_goods_attr(goods_attr_id,goods_id,attr_id,attr_value) VALUES (null,{$goods->goods_id},211,'{$zbz}')" ;
                   DB::insert($sql);
               }
           }
           // dd("SUCCESS");
        }

    }


    //同步商品库存
    public function spkc(){
        header("content-type:text/html;charset=gbk");
        $tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 183.230.3.128)(PORT = 9001))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = jy12g)
    )
  )
       ";
        $db_username = "HZJK";
        $db_password = "hzjk";
        $conn = new \PDO('oci:dbname='.$tns,$db_username,$db_password);

        $sql = "(select * from SPKC where ROWNUM < 6000) minus (select * from SPKC where ROWNUM < 5000)";
        //$sql = "select * from SPKC where ROWNUM < 1000";
        $result = $conn->query($sql);
        $res = $result->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($res as $key=>$v){
            $this->TB_kucun($v['SXRQ'],$v['SHL'],$v['SPID'],$v['LASTTIME'],$v['CGY'],$v['CKID']);
            echo $key+1;
            echo ",";
        }


    }

    //库存同步执行方法
    public function TB_kucun($yxq='',$sl,$spid,$xgrq,$cgy,$ckid){
        $yxq = iconv('GBK', 'UTF-8//IGNORE', $yxq) ;
        $sl = iconv('GBK', 'UTF-8//IGNORE', $sl) ;
        $spid = iconv('GBK', 'UTF-8//IGNORE', $spid) ;
        $cgy = iconv('GBK', 'UTF-8//IGNORE', $cgy) ;
        $ckid = iconv('GBK', 'UTF-8//IGNORE', $ckid) ;

        $xgrq = Carbon::parse($xgrq)->getTimestamp();

            $goods = Goods::where('ERPID',$spid)->first();
            if ($goods){
                $goods->xq = $yxq;
                $goods->goods_number = $sl;
                $goods->last_update = $xgrq;
                $goods->purchaser = $cgy;
                $goods->ckid = $ckid;
                $goods->save();
            }
    }


    //同步商品价格
    public function spjg(){
        header("content-type:text/html;charset=gbk");
        $tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 183.230.3.128)(PORT = 9001))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = jy12g)
    )
  )
       ";
        $db_username = "HZJK";
        $db_password = "hzjk";
        $conn = new \PDO('oci:dbname='.$tns,$db_username,$db_password);

        $sql = "(select * from SPJG where ROWNUM < 14000) minus (select * from SPJG where ROWNUM < 13000)";
        $result = $conn->query($sql);
        $res = $result->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($res as $key=>$v){
            $this->TB_jiage($v['PRICE'] , $v['SPID'] , $v['CKID'] , $v['PRICE1'] , $v['LASTTIME']);
            echo $key+1;
            echo ",";
        }


    }

    //价格同步执行方法
    public function TB_jiage( $price, $spid, $ckid, $price1, $lasttime)
    {
        $price = iconv('GBK', 'UTF-8//IGNORE', $price) ;
        $spid = iconv('GBK', 'UTF-8//IGNORE', $spid) ;
        $ckid = iconv('GBK', 'UTF-8//IGNORE', $ckid) ;
        $price1 = iconv('GBK', 'UTF-8//IGNORE', $price1) ;

        $lasttime = Carbon::parse($lasttime)->getTimestamp();

            //查询商品是否存在
            //$sql = "select goods_id from ecs_goods where ERPID = '$spid' limit 1";
            $goods = Goods::where('ERPID',$spid)->first();

            //如果存在,进行修改
            if ($goods) {
                $goods->shop_price = $price;
                $goods->last_update = $lasttime;
                $goods->save();

                //查看公司价格,同步
                $price_ids = MemberPrice::where('goods_id',$goods->goods_id)->where('user_rank',1)->first();


                if (!empty($price_ids)) {
                    if ($price1 != $price_ids->user_price) {
                        //如果公司价格和现在不同
                        $price_ids->user_price = $price1;
                        $price_ids->save();
                    }
                } else {
                    $sql = "INSERT INTO ecs_member_price(goods_id, user_rank, user_price) VALUES ($goods->goods_id, 1, '$price1')";
                    $result = DB::insert($sql);
                }
            }
    }


    //同步单位资料
    public function dwzl(){
        header("content-type:text/html;charset=gbk");
        $tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 183.230.3.128)(PORT = 9001))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = jy12g)
    )
  )
       ";
        $db_username = "HZJK";
        $db_password = "hzjk";
        $conn = new \PDO('oci:dbname='.$tns,$db_username,$db_password);

        $sql = "select * from WLDWZL";
        $result = $conn->query($sql);
        $res = $result->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($res as $key=>$v){
            $this->TB_dwzl($v['WLDWID'] , $v['WLDWNAME'] , $v['PYM'] , $v['FRDB'] , $v['YYZZ_YXQ'], $v['YLJG_YXQ'], $v['YPJY_YXQ'], $v['GSPSXRQ'], $v['CGWEITSH_YXQ'], $v['ZZJGDMZYXQ'], $v['SHHDZ'], $v['LASTTIME']);
            echo $key+1;
            echo ",";
        }

    }

    //单位资料执行方法
    public function TB_dwzl($wldwid,$wldwname,$pym,$frdb,$yyzzyxq,$yljgyxq,$ypjyyxq,$gspsxrq,$cgweitshyxq,$zzjgdmzyxq,$shdz,$lasttime){
            $users = User::where('wldwid1',$wldwid)->first();

            if (!$users){
                $user = New User();
                $user->msn = $wldwname;
                $user->MSN_ZJM = $pym;
                $user->ls_name = $frdb;
                $user->yyzz_time = $yyzzyxq;
                $user->yljg_time = $yljgyxq;
                $user->xkz_time = $ypjyyxq;
                $user->zs_time = $gspsxrq;
                $user->cgwts_time = $cgweitshyxq;
                $user->org_cert_validity = $zzjgdmzyxq;
                $user->reg_time = $lasttime;
                $user->wldwid1 = $wldwid;

                $user->save();

                if ($shdz != ''){
                    $user_id = $user->user_id;
                    $address = UserAddress::where('user_id',$user_id)->first();
                    if ($address){
                        if ($address->address != $shdz){
                            $address->address = $shdz;
                            $address->save();
                        }
                    }else{
                        $adrs = new UserAddress();
                        $adrs->user_id = $user_id;
                        $adrs->address = $shdz;
                        $adrs->save();
                        $u = User::where('user_id',$user_id)->first();
                        $u->address_id = $adrs->address_id;
                        $u->save();
                    }
                }
            }else{
                $users->msn = $wldwname;
                $users->MSN_ZJM = $pym;
                $users->ls_name = $frdb;
                $users->yyzz_time = $yyzzyxq;
                $users->yljg_time = $yljgyxq;
                $users->xkz_time = $ypjyyxq;
                $users->zs_time = $gspsxrq;
                $users->cgwts_time = $cgweitshyxq;
                $users->org_cert_validity = $zzjgdmzyxq;
                $users->reg_time = $lasttime;
                $users->save();

                $address = UserAddress::where('address_id',$users->address_id)->first();
                if ($address->address != $shdz){
                    $address->address = $shdz;
                    $address->save();
                }
            }
    }

    //同步单位经验范围
    public function jyfw(){
        header("content-type:text/html;charset=gbk");
        $tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 183.230.3.128)(PORT = 9001))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = jy12g)
    )
  )
       ";
        $db_username = "HZJK";
        $db_password = "hzjk";
        $conn = new \PDO('oci:dbname='.$tns,$db_username,$db_password);

        $sql = "select * from WLDWJYFW";
        $result = $conn->query($sql);
        $res = $result->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($res as $key=>$v){
            $user_jyfw = DB::table('user_erp_jyfwkzlb')->where('wldwid',$v['wldwid'])->get();
            $jyfw = explode(',',$v['shangplx']);
            //dd($user_jyfw);
            if (!empty($user_jyfw)){
                foreach ($user_jyfw as $value){
                    //dd($v);
                    $re = DB::delete("delete from ecs_user_erp_jyfwkzlb WHERE wldwid= ? AND shangplx = ?",[$value->wldwid,$value->shangplx]);
                }
            }
            if (!empty($jyfw)){
                foreach ($jyfw as $values){
                    $res = DB::table('user_erp_jyfwkzlb')->insert(['wldwid'=>$v['wldwid'],'shangplx'=>$values]);

                }
            }
            curl_yyg('http://www.tiedsun.cn/cacheF?name=jyfw');
        }

    }

    //退货冲红
    public function thch(){
        header("content-type:text/html;charset=gbk");
        $tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 183.230.3.128)(PORT = 9001))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = jy12g)
    )
  )
       ";
        $db_username = "HZJK";
        $db_password = "hzjk";
        $conn = new \PDO('oci:dbname='.$tns,$db_username,$db_password);

        $sql = "select * from THCH";
        $result = $conn->query($sql);
        $res = $result->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($res as $v){
            //获取订单号
            $order_info = OrderInfo::where('order_sn',$v['order_id'])->first();
            //验证单位内码与商品内码
            $user_info = User::where('wldwid1',$v['wldwid'])->first();
            if ($user_info->user_id == $order_info->user_id){
                $order_goods = OrderGoods::where('order_id',$order_info->order_id)->get();
                    if ($order_goods->count() > 0 ){
                        foreach ($order_goods as $va){
                            $goods = Goods::where('goods_id',$va['goods_id'])->first();
                            if ($goods->ERPID == $v['spid']){
                                //判断退货数量是否大于购买数量
                                if ($order_goods->goods_number < $v['shl']){
                                    return '退货数量大于销售数量,请核实订单号:'.$v['order_id'];
                                }else{
                                    $back_money = $v['shl'] * $v['hshj'];
                                    if ($back_money == $v['hsje']){
                                        $user_id = $user_info->user_id;
                                        log_account_change($user_id,$back_money,0,0,0,'退货冲红'.$v['order_id'],99);
                                        $query = "update THCH set is_sync = 1 where order_id = {$v['order_id']}";
                                        $result = $conn->query($query);
                                    }
                                }
                            }
                        }
                    }
            }
        }
    }

    //销售退补价对接
    public function xstbj(){
        header("content-type:text/html;charset=gbk");
        $tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 183.230.3.128)(PORT = 9001))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = jy12g)
    )
  )
       ";
        $db_username = "HZJK";
        $db_password = "hzjk";
        $conn = new \PDO('oci:dbname='.$tns,$db_username,$db_password);

        $sql = "select * from TBCJ";
        $result = $conn->query($sql);
        $res = $result->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($res as $v){
            //获取订单号
            $order_info = OrderInfo::where('order_sn',$v['order_id'])->first();
            //验证单位内码与商品内码
            $user_info = User::where('wldwid1',$v['wldwid'])->first();
            if ($user_info->user_id == $order_info->user_id){
                $order_goods = OrderGoods::where('order_id',$order_info->order_id)->get();
                if ($order_goods->count() > 0 ){
                    foreach ($order_goods as $va){
                        $goods = Goods::where('goods_id',$va['goods_id'])->first();
                        if ($goods->ERPID == $v['spid']){
                            //判断退货数量是否大于购买数量
                            if ($order_goods->goods_number < $v['shl']){
                                return '退货数量大于销售数量,请核实订单号:'.$v['order_id'];
                            }else{
                                $back_money = $v['shl'] * $v['hshj'];
                                if ($back_money == $v['hsje']){
                                    $user_id = $user_info->user_id;
                                    log_account_change($user_id,$back_money,0,0,0,'销售退补价'.$v['order_id'],99);
                                    $query = "update TBCJ set is_sync = 1 where order_id = {$v['order_id']}";
                                    $result = $conn->query($query);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    //自动上下架
    public function goods_status(){
        $sql1 = "UPDATE ecs_goods SET is_on_sale = 0 WHERE is_auto_onoff = 1 and (goods_number = 0 or shop_price = 0) AND is_on_sale = 1 AND goods_img = ''";
        $sql2 = "UPDATE ecs_goods SET is_on_sale = 1 WHERE is_auto_onoff = 1 and goods_number > 0 AND shop_price > 0 AND is_on_sale = 0 AND goods_img != ''";
        $result = DB::update($sql1);
        $result1 = DB::update($sql2);
        //var_dump($result,$result1);
        //exit;
    }

   






}