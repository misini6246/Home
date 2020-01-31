<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/9/10
 * Time: 13:29
 */

namespace App\Services;


use App\Repositories\YhqRepository;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $user;

    protected $order;

    protected $now;

    protected $yhqRepository;

    public function __construct(YhqRepository $yhqRepository)
    {
        $this->now = time();
        $this->yhqRepository = $yhqRepository;
    }

    /**
     * @param $user
     * @param $max
     * @return array
     * 处理优惠券使用
     */
    public function useYhq($user, $max,$goods)
    {
        $this->user = $user;

        //获取可用优惠券列表
        $list = $this->yhqRepository->getUserYhq();
        $types = $this->getTypes($list);
        //将排列组合以优惠券金额排倒序，满足的第一个amount即为最优组合，将key放入selected，将最优组合前的组合放入next
        // $selected = null;
        // $next = collect();
        // foreach ($types->sortByDesc(function ($item) {
            // return $item['je'];
        // }) as $k => $v) {
            // if ($v['amount'] <= $max) {
                // $selected = $k;
                // break;
            // }
            // if (is_null($selected)) {
                // $next[$k] = $v;
            // }
        // }
        // //将next以amount排正序,跳过与当前优惠金额相同的项,取第一个key即为下一最优组合
        // $next_selected = null;
        // foreach ($next->sortBy(function ($item) {
            // return $item['amount'];
        // }) as $k => $v) {
            // if (is_null($selected)) {
                // $next_selected = $k;
                // break;
            // }
            // if ($v['je'] == $types[$selected]['je']) {
                // continue;
            // }
            // $next_selected = $k;
            // break;
        // }
        // //计算下一最优组合需购买的差额
        // $chae = null;
        // if ($next_selected) {
            // $chae = $types[$next_selected]['amount'] - $max;
        // }
        // //selected 能使用的优惠券id,next_selected 下一等级能使用的优惠券id,pack_fee 优惠金额,next_pack_fee 下一等级优惠金额
        // $selected = is_null($selected) ? [] : explode('_', trim($selected, '_'));
        // $next_selected = is_null($next_selected) ? [] : explode('_', trim($next_selected, '_'));
        // $pack_fee = 0;
        // $next_pack_fee = 0;
        // foreach ($list as $v) {
            // if (in_array($v->yhq_id, $selected)) {
                // $v->setRelation('is_used', 1);
                // $pack_fee += $v->je;
            // }
            // if (in_array($v->yhq_id, $next_selected)) {
                // $next_pack_fee += $v->je;
            // }
        // }
		
		//以下为选一使用
        $selected = null;
        $pack_fee = 0;
        $next_pack_fee = 0;
        foreach ($list->sortByDesc(function ($value){
            return $value['min_je'];
        }) as $v ){
            if ($v['min_je'] <= $max) {
                $selected = $v['yhq_id'];
                break;
            }
        }

        $selected = is_null($selected) ? [] : explode('_', trim($selected, '_'));

//        var_dump($selected);
//        exit;
        $c = false;
        foreach ($goods as $v){
            if($v->goods->is_yhq_status !=2 &&  $v->goods->is_mhj !=1){
                $c = true;
                break;
            }
        }
        //修改优惠券的新人优惠券优先使用
       $first_order = DB::table('order_info')->where('user_id', $this->user->user_id)->where('order_status', 1)->count();

        if($this->user->is_new_user == 1){
            foreach ($list as $v) {
                if ($v->cat_id == 1 &&  $first_order == 0) {
                    if($c == true){
                        $v->setRelation('is_used', 1);
                        $selected[0] = $v->yhq_id;
                        $pack_fee += $v->je;
                        break;
                    }
                }else{

                        if (in_array($v->yhq_id, $selected)) {
                            $v->setRelation('is_used', 1);
                            $pack_fee += $v->je;
                        }

                }
            }
        }else{
            foreach ($list as $k=>$v) {
                    if ($v->cat_id != 1){
                        if (in_array($v->yhq_id, $selected)) {
                            $v->setRelation('is_used', 1);
                            $pack_fee += $v->je;
                        }
                    }

            }
        }
		
        return [
            'pack_fee' => $pack_fee,//优惠金额
            'selected' => $selected,//能使用的优惠券id
            'next_pack_fee' => $next_pack_fee,//下一等级优惠金额
            'list' => $list,//能使用的优惠券列表
            'yhq_count' => count($selected),//使用的优惠券数量
        //    'next_tip' => $this->tips($next_pack_fee, $max, $chae)//下一等级提示
            'next_tip' => $this->tips($next_pack_fee, $max, null)//下一等级提示
        ];
    }

    /**
     * @param $next_pack_fee :下一等级优惠金额
     * @param $max :
     * @param $chae
     * @return string
     */
    protected function tips($next_pack_fee, $max, $chae)
    {
        if ($next_pack_fee == 0) {
            return '';
        }
        return '当前可参与使用优惠券金额：' . $max . '；再购买' . $chae . ' 商品，可以享受'
            . $next_pack_fee . ' 优惠券';
    }

    /**
     * @param $collect
     * @return \Illuminate\Support\Collection
     * 获取所有优惠券使用排列组合
     */
    protected function getTypes($collect)
    {
        $types = collect();
        $collect->each(function ($item, $key) use ($types, $collect) {
            $keys = collect($item->yhq_id);
            $amount = collect($item->min_je);
            $je = collect($item->je);
            $types['_' . $item->yhq_id] = [
                'amount' => $item->min_je,
                'je' => $item->je,
            ];
            for ($i = $key + 1; $i < count($collect); $i++) {
                $keys->push($collect[$i]->yhq_id);
                $amount->push($collect[$i]->min_je);
                $je->push($collect[$i]->je);
                $types['_' . $keys->implode('_')] = [
                    'amount' => $amount->sum(),
                    'je' => $je->sum(),
                ];
                $types['_' . $item->yhq_id . '_' . $collect[$i]->yhq_id] = [
                    'amount' => $item->min_je + $collect[$i]->min_je,
                    'je' => $item->je + $collect[$i]->je,
                ];
            }
        });
        return $types;
    }
}