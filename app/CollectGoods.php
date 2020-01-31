<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectGoods extends Model
{
    protected $table = 'collect_goods';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;

    //关联 goods
    public function goods()
    {
        return $this->belongsTo('App\Goods', 'goods_id');
    }

    //关联查询 goods_attr
    public function goods_attr()
    {
        return $this->hasMany('App\GoodsAttr', 'goods_id', 'goods_id');
    }

    /*
     * 我的收藏 最新
     */
    public static function collect_near($num, $user)
    {//最新收藏的商品
        $result = static::with([
            'goods' => function ($query) {
                $query->with('goods_attr', 'goods_attribute', 'member_price');
            }
        ])->where('user_id', $user->user_id)->where('goods_id', '>', 0)
            ->select('goods_id', 'rec_id')->orderBy('add_time', 'desc')->take(3)->get();
        foreach ($result as $v) {
            $v->goods = $v->goods->attr($v->goods, $user, 0);
        }
        return $result;
    }

    /*
     * 我的收藏列表
     */
    public static function collect_list($num, $user)
    {

    }
}
