<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-12-04
 * Time: 11:01
 */

namespace App\Http\Controllers\User;


use App\Models\Goods;
use App\OrderAction;
use App\OrderInfo;
use App\ZqOrder;
use App\ZqOrderYwy;

trait UserTrait
{

    protected $user;

    protected $now;

    protected $assign;

    protected $action;

    protected $view = 'new.';

    protected function set_assign($key, $value)
    {
        $this->assign[$key] = $value;
    }

    protected function common_value()
    {
        $zq_order = ZqOrder::where('user_id', $this->user->user_id)->where('order_status', 1)->count();
        $zq_order += ZqOrderYwy::where('user_id', $this->user->user_id)->where('order_status', 1)->count();
        $this->set_assign('zq_order', $zq_order);
        $this->set_assign('user', $this->user);
        $this->set_assign('now', $this->now);
        $this->set_assign('page_title', '用户中心-');
        $this->set_assign('action', $this->action);
    }

    protected function ddgz($order)
    {
        $actions = $order->order_action;
        $result = collect();
        $content = '请尽快完成付款。';
        if ($order->is_zq > 0 || $order->is_separate == 1) {
            $content = '等待系统审核。';
        }
        $result->put('start', [
            'action_id' => 0,
            'step' => 1,
            'title' => '已提交',
            'content' => '您的订单已提交，' . $content,
            'time' => date('Y-m-d H:i:s', $order->add_time),
        ]);
        $old = [
            'order_status' => 1,
            'pay_status' => 0,
            'shipping_status' => 0,
        ];
        $order_info = new OrderAction();
        $old = $order_info->forceFill($old);
        foreach ($actions as $row) {
            if ($row->order_status == 2 && $old->order_status == 1) {
                $result->push([
                    'action_id' => $row->action_id,
                    'step' => 2,
                    'title' => '已取消',
                    'content' => '您的订单已取消。',
                    'time' => date('Y-m-d H:i:s', $row->log_time),
                ]);
            } elseif ($row->order_status == 1 && $old->order_status == 2) {
                $result->push([
                    'action_id' => $row->action_id,
                    'step' => 2,
                    'title' => '已确认',
                    'content' => '您的订单已确认，' . $content,
                    'time' => date('Y-m-d H:i:s', $row->log_time),
                ]);
            } elseif ($row->pay_status == 2 && $old->pay_status == 0 && $row->shipping_status == 0) {
                $result->push([
                    'action_id' => $row->action_id,
                    'step' => 3,
                    'title' => '已付款',
                    'content' => '您的订单商家正在积极备货中。',
                    'time' => date('Y-m-d H:i:s', $row->log_time),
                ]);
            } elseif ($row->pay_status == 2 && $old->pay_status == 0 && $row->shipping_status > 0) {
                $result->push([
                    'action_id' => $row->action_id,
                    'step' => 3,
                    'title' => '已付款',
                    'content' => '您的订单已付款。',
                    'time' => date('Y-m-d H:i:s', $row->log_time),
                ]);
            }
            if ($row->shipping_status == 1 && $old->shipping_status == 0) {
                $result->push([
                    'action_id' => $row->action_id,
                    'step' => 4,
                    'title' => '已开票',
                    'content' => '您的订单商家已开票。',
                    'time' => date('Y-m-d H:i:s', $row->log_time),
                ]);
            } elseif ($row->shipping_status == 2 && $old->shipping_status == 1) {
                $result->push([
                    'action_id' => $row->action_id,
                    'step' => 5,
                    'title' => '已拣货',
                    'content' => '您的订单已拣货，请您耐心等待。',
                    'time' => date('Y-m-d H:i:s', $row->log_time),
                ]);
            } elseif ($row->shipping_status == 3 && $old->shipping_status == 2) {
                $result->push([
                    'action_id' => $row->action_id,
                    'step' => 6,
                    'title' => '已出库',
                    'content' => '您的订单现已出库。',
                    'time' => date('Y-m-d H:i:s', $row->log_time),
                ]);
            } elseif ($row->shipping_status == 4 && $old->shipping_status == 3) {
                $result->push([
                    'action_id' => $row->action_id,
                    'step' => 7,
                    'title' => '已发货',
                    'content' => '您的订单已发货。',
                    'time' => date('Y-m-d H:i:s', $row->log_time),
                ]);
            } elseif ($row->shipping_status == 5 && $old->shipping_status == 4) {
                $result->push([
                    'action_id' => $row->action_id,
                    'step' => 8,
                    'title' => '已完成',
                    'content' => '您的订单已送达成功！已完成。',
                    'time' => date('Y-m-d H:i:s', $row->log_time),
                ]);
            }
            $old = $row;
        }
        $result = $result->sortByDesc('action_id');
        $result->put('end', $result->shift());
        return $result;
    }

    public function dfk($where = '')
    {
        $query = OrderInfo::where('user_id', $this->user->user_id)->where('order_type', 0)->where('order_status', 1)->where('pay_status', 0);
        if ($where instanceof \Closure) {
            $query->where($where);
        }
        return $query->count();
    }

    public function dfk_money()
    {
        return OrderInfo::where('user_id', $this->user->user_id)->where('order_type', 0)->where('order_status', 1)->where('pay_status', 0)->sum('order_amount');
    }

    public function dsh($where = '')
    {
        $query = OrderInfo::where('user_id', $this->user->user_id)->where('order_type', 0)->where('order_status', 1)->where('shipping_status', 4);
        if ($where instanceof \Closure) {
            $query->where($where);
        }
        return $query->count();
    }

    protected function real_price($ids)
    {
        $result = Goods::with([
            'goods_attr' => function ($query) {
                $query->whereIn('attr_id', [1, 2, 3])->select('goods_id', 'attr_id', 'attr_value');
            },
            'goods_attribute'
        ])->whereIn('goods_id', $ids)->select('goods_id', 'shop_price', 'is_kxpz', 'show_area', 'is_kxpz', 'goods_thumb', 'is_xkh_tj',
            'promote_price', 'is_promote', 'promote_start_date', 'promote_end_date', 'xg_type', 'xg_start_date', 'xg_end_date', 'goods_number', 'ls_gg','zyzk','preferential_start_date','preferential_end_date')->get();
        if ($this->user->is_zhongduan == 0) {
            $result->load([
                'member_price' => function ($query) {
                    $query->where('user_rank', 1)->select('goods_id', 'user_price');
                }
            ]);
        }
        $arr = [];
        foreach ($result as $v) {
            $v->setRelation('user', $this->user);
            $v->attr()->real_price();
            $arr[$v->goods_id]['real_price'] = $v->real_price;
            $arr[$v->goods_id]['sccj'] = $v->sccj;
            $arr[$v->goods_id]['ypgg'] = $v->ypgg;
            $arr[$v->goods_id]['dw'] = $v->dw;
            $arr[$v->goods_id]['goods_thumb'] = $v->goods_thumb;
            $arr[$v->goods_id]['goods_url'] = $v->goods_url;
            $arr[$v->goods_id]['zbz'] = $v->zbz;
            $arr[$v->goods_id]['zyzk'] = $v->zyzk;
            $arr[$v->goods_id]['preferential_start_date'] = $v->preferential_start_date;
            $arr[$v->goods_id]['preferential_end_date'] = $v->preferential_end_date;
            $arr[$v->goods_id]['is_xkh_tj'] = $v->is_xkh_tj;
            $arr[$v->goods_id]['is_promote'] = $v->is_promote;
            $arr[$v->goods_id]['promote_start_date'] = $v->promote_start_date;
            $arr[$v->goods_id]['promote_end_date'] = $v->promote_end_date;
        }
        return $arr;
    }

}