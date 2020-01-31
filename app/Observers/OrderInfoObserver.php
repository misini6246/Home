<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-10-11
 * Time: 10:34
 */

namespace App\Observers;


use App\Models\CzMoney;
use App\Models\HongbaoMoney;
use App\Models\JfMoney;
use App\OrderInfo;

class OrderInfoObserver
{

    public function created(OrderInfo $orderInfo)
    {
        $dirty = $orderInfo->getDirty();
        if ($orderInfo->order_id > 0) {
            foreach ($dirty as $k => $v) {
                if ($k == 'hongbao_money') {
                    $hongbao_money = HongbaoMoney::where('user_id', $orderInfo->user_id)->lockForUpdate()->first();
                    $change_desc = '订单' . $orderInfo->order_sn . '使用红包';
                    if ($orderInfo->order_status == 2) {
                        $change_desc = '取消订单' . $orderInfo->order_sn;
                    }
                    $change_money = $orderInfo->getOriginal('hongbao_money') - $v;
                    if ($change_money != 0) {
                        $hongbao_money->log_hongbao_money_change($hongbao_money, $orderInfo->getOriginal('hongbao_money') - $v, $change_desc);
                    }
                }
                if ($k == 'jf_money') {
                    $jf_money = JfMoney::where('user_id', $orderInfo->user_id)->lockForUpdate()->first();
                    $change_desc = '订单' . $orderInfo->order_sn . '使用积分金币';
                    if ($orderInfo->order_status == 2) {
                        $change_desc = '取消订单' . $orderInfo->order_sn;
                    }
                    $change_money = $orderInfo->getOriginal('jf_money') - $v;
                    if ($change_money != 0) {
                        $jf_money->log_jf_money_change($jf_money, $orderInfo->getOriginal('jf_money') - $v, $change_desc);
                    }
                }
                if ($k == 'cz_money') {
                    $cz_money = CzMoney::where('user_id', $orderInfo->user_id)->lockForUpdate()->first();
                    $change_desc = '订单' . $orderInfo->order_sn . '使用' . trans('common.cz_money');;
                    if ($orderInfo->order_status == 2) {
                        $change_desc = '取消订单' . $orderInfo->order_sn;
                    }
                    $change_money = $orderInfo->getOriginal('cz_money') - $v;
                    if ($change_money != 0) {
                        $cz_money->log_cz_money_change($cz_money, $orderInfo->getOriginal('cz_money') - $v, $change_desc);
                    }
                }
            }
        }
    }

    public function updated(OrderInfo $orderInfo)
    {
        $dirty = $orderInfo->getDirty();
        foreach ($dirty as $k => $v) {
            if ($k == 'pay_status' && $v == 2 && $orderInfo->mobile_pay == -2) {//已支付
                $cz_money = CzMoney::where('user_id', $orderInfo->user_id)->first();
                if (!$cz_money) {
                    $cz_money = new CzMoney();
                    $cz_money->user_id = $orderInfo->user_id;
                    $cz_money->money = 0;
                    $cz_money->zk = 0;
                }
                $yhje = $cz_money->money * $cz_money->zk + $orderInfo->goods_amount * 0.03;
                $old_money = $cz_money->money + $orderInfo->goods_amount * (1 + 0.03);
                $cz_money->zk = $yhje / $old_money;
                $change_desc = '充值包' . $orderInfo->order_sn . '转充值金额';
                $cz_money->log_cz_money_change($cz_money, $orderInfo->goods_amount * (1 + 0.03), $change_desc, $orderInfo->order_id);
            }
        }
    }
}