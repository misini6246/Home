<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YdCart extends Model
{
    protected $table = 'yd_cart';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;

    //关联goods
    public function goods(){
        return $this->belongsTo('App\Goods','goods_id');
    }
    //关联查询goods goods_attr
    public function goods_attr(){
        return $this->hasMany('App\GoodsAttr','goods_id','goods_id');
    }
    //关联查询goods member_price
    public function member_price(){
        return $this->hasMany('App\MemberPrice','goods_id','goods_id');
    }

    public static function get_cart_goods($user,$str='',$type=0){
        $query = self::with(
            [
                'xiangqing'=>function($query){
                    $query->with('goods_attr','member_price');
                }
            ]
        )->where('user_id',$user->user_id)->orderBy('rec_id','desc');
        if(!empty($str)){
            $query->whereIn('rec_id',$str);
        }
        $query->select('goods_id','rec_id','goods_number','goods_price');
        if($type==1){
            $cart = $query->first();
        }else{
            $cart = $query->get();
        }
        if(!empty($delId)) {
            self::destroy($delId);
        }
        foreach($cart as $k=>$v){
            if($v->goods) {
                $v->goods = Goods::attr($v->goods, $user);
            }else{
                $delId[] = $v->rec_id;
                unset($cart[$k]);
            }
        }
        return $cart;
    }
}
