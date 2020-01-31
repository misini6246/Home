<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;

    public function select1()
    {
        return ['rec_id', 'user_id', 'goods_id', 'goods_number', 'goods_price'];
    }

    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id');
    }

    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function get_cart($user)
    {
        $query  = $this->with([
            'goods' => function ($query) {
                $goods = new Goods();
                $query->with([
                    'goods_attr' => function ($query) {
                        $query->select('goods_id', 'attr_id', 'attr_value');
                    },
                    'goods_attribute'=>function($query){
                        $query->select('goods_id','sccj','ypgg','bzdw','');
                    }

                ])->select($goods->select1());
            }
        ]);
        $result = $query->ofUser($user->user_id)->select($this->select1())->get();
        return $result;
    }
}
