<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-09-27
 * Time: 17:08
 */

namespace App\Yhq;


class Rule1 extends Rules
{

    public function chooseYhq()
    {
        $this->yhq_amount = $this->order->order_goods->sum(function ($item) {
            if (strpos($item->tsbz, '秒') === false && $this->order->is_mhj == 0) {
                return $item->goods_price * $item->goods_number;
            }
        });
        $where            = function ($where) {
            $where->where('cat_id', 44);
        };
        $this->choose_yhq($where);
    }

    public function useYhq()
    {
        // TODO: Implement useYhq() method.
    }

    protected function yhq_amount()
    {
        $this->yhq_amount = $this->order->order_goods->sum(function ($item) {
            if (strpos($item->tsbz, '秒') === false && $item->is_zyyp == 0) {
                return $item->goods_price * $item->goods_number;
            }
        });
        return $this;
    }

}