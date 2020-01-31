<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2016/8/5
 * Time: 16:26
 */

namespace App\Http\Controllers\Huodong;


use App\Goods;

trait QiXi {

    private $dls = [21477,21476,23755];

    private $jhc = 21565;

    private $xztj;

    private $hg_price=0.01;

    /**
     * 中药换购
     */
    private function zy_hg(){
        $arr = collect();
        $arr->num = 0;
        $arr->amount = 0;
        $arr->type = 0;
        if($this->xztj==1) {
            if ($this->zy_amount >= 1520) {
                $arr->num = 3;
                $arr->amount = 1520;
                $arr->type = 2;
            } elseif ($this->zy_amount >= 520) {
                $arr->num = 1;
                $arr->amount = 520;
                $arr->type = 1;
            }
        }

        return ($arr);
    }

    /**
     * 非中药换购
     */
    private function fzy_hg(){
        $arr = collect();
        $arr->num = 0;
        $arr->amount = 0;
        $arr->type = 0;
        if($this->xztj==1) {
            if ($this->fzy_amount >= 5169) {
                $arr->num = 5;
                $arr->amount = 5169;
                $arr->type = 2;
                $this->is_can_zq = false;
            } elseif ($this->fzy_amount >= 2690) {
                $arr->num = 2;
                $arr->amount = 2690;
                $arr->type = 1;
                $this->is_can_zq = false;
            }
        }
        return ($arr);
    }

    /**
     * 将换购商品添加进商品数组中
     */
    private function add_hg($goods,$type,$level){
        $hg = [];
        if($this->xztj==1) {
            if ($level == 2) {//非中药
                $spxx = Goods::whereIn('goods_id', $this->dls)
                    ->select('goods_id', 'goods_name', 'goods_sn', 'goods_number',
                        'market_price', 'xq', 'zyzk',
                        'suppliers_id', 'ckid', 'tsbz', 'extension_code')
                    ->orderBy('goods_number','desc')
                    ->get();
                if ($type == 2) {
                    $num = 5;
                } elseif($type==1 ) {
                    $num = 2;
                }else{
                    $num = 0;
                }
                foreach ($spxx as $v) {
                    if ($v->goods_number > $num && $num>0) {
                        $hg = collect(['goods_number' => $num]);
                        $hg->goods = $v;
                        $hg->rec_id = 0;
                        $hg->goods_number = $num;
                        $hg->goods_id = $v->goods_id;
                        $hg->is_can_zk = 0;
                        $hg->tsbz_a = 0;
                        $this->is_can_zq = false;
                        $hg->goods->tsbz = '换';
                        $hg->goods->real_price = $this->hg_price;
                        $hg->goods->is_zyyp = 0;
                        $hg->subtotal = $hg->goods->real_price*$hg->goods_number;
                        break;
                    }
                }
            } else {//中药
                $spxx = Goods::where('goods_id', $this->jhc)
                    ->select('goods_id', 'goods_name', 'goods_sn', 'goods_number',
                        'market_price', 'xq', 'zyzk',
                        'suppliers_id', 'ckid', 'tsbz', 'extension_code')
                    ->first();
                if ($type == 2) {
                    $num = 3;
                } elseif($type==1) {
                    $num = 1;
                }else{
                    $num = 0;
                }
                if ($spxx->goods_number > $num&&$num>0) {
                    $hg = collect();
                    $hg->goods = $spxx;
                    $hg->goods_number = $num;
                    $hg->rec_id = 0;
                    $hg->goods_id = $spxx->goods_id;
                    $hg->is_can_zk = 0;
                    $hg->tsbz_a = 0;
                    $this->is_can_zq = false;
                    $hg->goods->tsbz = '换';
                    $hg->goods->real_price = $this->hg_price;
                    $hg->subtotal = $hg->goods->real_price*$hg->goods_number;
                    $hg->goods->is_zyyp = 0;
                }
            }
            if (!empty($hg)) {
                $quchong = [];
                foreach($goods as $k=>$v){
                    if(isset($quchong[$hg->goods_id])){
                        unset($goods[$k]);
                    }else{
                        $quchong[$v->goods_id] = $v;
                    }
                }
                $goods[] = $hg;
                $this->is_can_zq = false;
            }
        }
        return $goods;
    }

    /**
     * 中药折扣活动
     */
    public function zy_discount(){
        if($this->xztj==1) {
            $this->discount = round($this->zy_amount * (1 - 0.97), 2);
            $this->extension_code = 0.97;
            $this->is_can_zq = false;
        }else{
            $this->discount = 0;
            $this->extension_code = 1;
        }
    }

//    /**
//     * 商品打折活动
//     */
//    public function tsbz_a_discount(){
//        $this->discount = round($this->tsbz_a_amount * (1 - 0.85), 2);
//        if($this->discount>0) {
//            $this->extension_code = 0.85;
//        }else{
//            $this->extension_code = 1;
//        }
//    }



    /**
     * 商品打折活动
     */
    public function tsbz_a_discount(){
        $this->discount = round($this->tsbz_a_amount * (1 - 0.95), 2);
        if($this->discount>0) {
            $this->extension_code = 0.95;
        }else{
            $this->extension_code = 1;
        }
    }
    /**
     * 限制条件
     */
    private function xztj(){
        $start = strtotime('20160809');
        $end = strtotime('20160810');
        $now = time();
        if($now>=$start&&$now<=$end&&$this->user->is_zhongduan&&$this->user->zq_amount==0&&(!$this->user_jnmj||($this->user_jnmj&&$this->user_jnmj->jnmj_amount==0))){//终端,账期结清
            $this->xztj = 1;
        }else{
            $this->xztj = 0;
        }
    }

    private function add_goods($goods){
        $spxx = Goods::whereIn('goods_id',[16348,3294])
            ->select('goods_id', 'goods_name', 'goods_sn', 'goods_number',
                'market_price', 'xq', 'zyzk',
                'suppliers_id', 'ckid', 'tsbz', 'extension_code')
            ->orderBy('goods_number','desc')
            ->get();
        $num = 10;
        foreach ($spxx as $v) {
            if ($v->goods_number > $num && $num>0) {
                $hg = collect(['goods_number' => $num]);
                $hg->goods = $v;
                $hg->rec_id = 0;
                $hg->goods_number = $num;
                $hg->goods_id = $v->goods_id;
                $hg->is_can_zk = 0;
                $hg->tsbz_a = 0;
                $this->is_can_zq = false;
                $hg->goods->tsbz = '换';
                $hg->goods->real_price = 0.01;
                $hg->goods->is_zyyp = 0;
                $hg->subtotal = $hg->goods->real_price*$hg->goods_number;
                $goods[] = $hg;
            }
        }
        return $goods;
    }

}