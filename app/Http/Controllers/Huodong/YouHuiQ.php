<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/26
 * Time: 13:37
 */

namespace App\Http\Controllers\Huodong;


use App\Http\Controllers\YouHuiController;

trait YouHuiQ {

    private $youhuiq_amount=0;//能够参与使用优惠券的金额

    private $youhuiq_zy_amount=0;//能够参与使用优惠券的金额(中药)

    private $youhuiq_fzy_amount=0;//能够参与使用优惠券的金额(非中药)

    private $pack_fee=0;//优惠券金额

    /**
     * @param $goods_list
     * 使用优惠券
     */
    public function use_youhuiq($goods_list){
        foreach($goods_list as $v){
            if($v->goods->is_mhj==0){//非麻黄碱
                $this->youhuiq_amount += $v->subtotal;
                if($v->goods->is_zyyp==1){//中药
                    $this->youhuiq_zy_amount += $v->subtotal;
                }else{//非中药
                    $this->youhuiq_fzy_amount += $v->subtotal;
                }
            }
        }

        /**
         * 判断能否使用优惠券
         */
        if($this->is_can_use_jnmj==false&&$this->is_can_zq==false) {//非账期非充值余额订单
            $youhuiq = new YouHuiController([],$this->user);
            $youhuiq_list = $youhuiq->check_use_youhuiq($this->youhuiq_amount,$this->youhuiq_zy_amount,$this->youhuiq_fzy_amount);
            if (!empty($youhuiq_list)) {
                foreach ($youhuiq_list as $k => $v) {
                    if ($k == 0) {
                        $this->pack_fee = $v->je;
                        $this->yhq_id = $v->yhq_id;
                    }
                }
            }
        }



    }
}