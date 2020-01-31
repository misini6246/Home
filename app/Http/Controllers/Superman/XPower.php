<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/19
 * Time: 13:07
 */

namespace App\Http\Controllers\Superman;


use App\User;

class XPower implements SuperModuleInterface{
    public function activate(array $target)
    {
        $user = $target['user'];
        $goods = $target['goods'];
        $country = $user->country;
        $province = $user->province;
        $city = $user->city;
        $district = $user->district;
        $user_rank = $user->user_rank;
        $user_id = $user->user_id;
        $goods->is_can_buy = 1;
        if($user->hymsy==0&&$goods->hy_price>0){//非码上有用户不能购买哈药
            $goods->is_can_buy = 0;
            return $goods;
        }
        $arr = explode('.',$goods->ls_buy_user_id);
        $arr1 = explode('.',$goods->ls_regions);//区域限制
        $arr2 = explode('.',$goods->zs_regions);//诊所限制
        $arr3 = explode('.',$goods->yy_regions);//医院限制
        $arr4 = explode('.',$goods->zs_user_ids);//诊所会员限制
        $arr5 = explode('.',$goods->yy_user_ids);//医院会员限制
        $arr6 = explode(',',$goods->ls_ranks);//等级限制
        if(!in_array($user_id,$arr)){
            if(in_array($user_rank,$arr6)){
                $goods->is_can_buy = 0;
                return $goods;
            }
            if(in_array($country,$arr1)||in_array($province,$arr1)||in_array($city,$arr1)||in_array($district,$arr1)){
                $goods->is_can_buy = 0;
                return $goods;
            }
            if(!$user->is_zhongduan&&
                (in_array($country,$arr3)||in_array($province,$arr3)||in_array($city,$arr3)||in_array($district,$arr3)||in_array($user_id,$arr5))
            ){
                $goods->is_can_buy = 0;
                return $goods;
            }
            if($user->is_zhongduan&&
                (in_array($country,$arr2)||in_array($province,$arr2)||in_array($city,$arr2)||in_array($district,$arr2)||in_array($user_id,$arr4))
            ){
                $goods->is_can_buy = 0;
                return $goods;
            }
        }
        return $goods;
    }
}