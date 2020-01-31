<?php

namespace App;

use App\Models\ZpGoods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'cart';
    protected $primaryKey = 'rec_id';

    static $zp_ids = [];
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    protected $fillable = ['user_id', 'goods_id', 'goods_sn',
        'goods_name', 'goods_price', 'is_real', 'extension_code', 'is_gift', 'is_shipping',
        'ls_gg', 'ls_bz', 'suppliers_id', 'goods_number'
    ];

    public function child()
    {
        return $this->hasMany(Cart::class, 'parent_id', 'rec_id');
    }

    public function zp()
    {
        return $this->belongsTo(ZpGoods::class, 'goods_id');
    }

    //关联goods
    public function goods()
    {
        return $this->belongsTo('App\Goods', 'goods_id');
    }

    //关联查询goods goods_attr
    public function goods_attr()
    {
        return $this->hasMany('App\GoodsAttr', 'goods_id', 'goods_id');
    }

    //关联查询goods member_price
    public function member_price()
    {
        return $this->hasMany('App\MemberPrice', 'goods_id', 'goods_id');
    }

    /**
     * @param $user
     * @param string $str
     * @param int $type
     * @return mixed
     */
    public static function get_cart_goods($user, $str = '', $type = 0)
    {
        $query = self::with(
            [
                'goods' => function ($query) use ($user) {
                    $query->with(['goods_attr', 'member_price', 'goods_attribute',
                        'zp_goods' => function ($query) use ($user) {
                            $query->wherePivot('zx_ranks', 'not like', '%' . $user->user_rank . '%');
                        },
                        'zp_goods1' => function ($query) use ($user) {
                            $query->wherePivot('zx_ranks', 'not like', '%' . $user->user_rank . '%');
                        },
                    ]);
                },
                'child' => function ($query) use ($user) {
                    $query->with('zp')->where('user_id', $user->user_id)->select('goods_id', 'rec_id', 'goods_number', 'goods_price', 'parent_id');
                }
            ]
        )->where('user_id', $user->user_id)->orderBy('rec_id', 'desc');
        if (!empty($str)) {
            $query->whereIn('rec_id', $str);
        }
        $query->select('goods_id', 'rec_id', 'goods_number', 'goods_price', 'parent_id', 'product_id');
        if ($type == 1) {
            $cart = $query->first();
            $cart->goods = Goods::attr($cart->goods, $user, 1, $cart->product_id);
        } else {
            $cart = $query->get();
            foreach ($cart as $k => $v) {
                if ($v->goods) {
                    $v->goods = Goods::attr($v->goods, $user, 1, $v->product_id);
                } else {
                    unset($cart[$k]);
                }
            }
        }

        return $cart;
    }

    public static function get_cart_goods_l($user, $str = '', $type = 0)
    {
        self::where('parent_id', '>', 0)->where('user_id', $user->user_id)->delete();
        $query = self::with(
            [
                'goods' => function ($query) use ($user) {
                    $query->with(['goods_attr', 'member_price', 'goods_attribute',
                        'zp_goods' => function ($query) use ($user) {
                            $query->wherePivot('zx_ranks', 'not like', '%' . $user->user_rank . '%');
                        },
                        'zp_goods1' => function ($query) use ($user) {
                            $query->wherePivot('zx_ranks', 'not like', '%' . $user->user_rank . '%');
                        },
                    ]);
                },
                'child' => function ($query) use ($user) {
                    $query->with('zp')->where('user_id', $user->user_id)->select('goods_id', 'rec_id', 'goods_number', 'goods_price', 'parent_id');
                }
            ]
        )->where('user_id', $user->user_id)->orderBy('rec_id', 'desc');
        if (!empty($str)) {
            $query->whereIn('rec_id', $str);
        }
        $query->where('parent_id', 0)->select('goods_id', 'rec_id', 'goods_number', 'goods_price', 'parent_id', 'product_id');
        if ($type == 1) {
            $cart = $query->first();
        } else {
            $cart = $query->get();
        }
        $delId = [];
        foreach ($cart as $k => $v) {
            if ($v->goods && $v->goods_number > 0) {
                $v->goods = Goods::attr($v->goods, $user, 1, $v->product_id);
                if (!$v->goods) {
                    $delId[] = $v->rec_id;
                    unset($cart[$k]);
                } else {
                    if (count($v->goods->zp_goods) > 0) {
                        $check_type = -1;
                        $v = Cart::check_zp_goods($user, $v, $check_type);
                    }
                    //$v->goods = self::cyn($v->goods,$user);
                }
            } else {
                $delId[] = $v->rec_id;
                unset($cart[$k]);
            }
        }
        $zp_ids = self::$zp_ids;
        if (count($zp_ids) > 0) {
            foreach ($cart as $k => $v) {
                if (in_array($v->goods_id, $zp_ids)) {
                    //unset($cart[$k]);
                }
            }
        }
        if (!empty($delId)) {
            self::destroy($delId);
            Cache::tags([$user->user_id, 'cart'])->decrement('num', count($delId));
        }
        return $cart;
    }

    public static function diff_price($v, $num, $price, $user)
    {
        $cs_arr = [18810, 13960, 12567];
        $start = strtotime('2017-10-10 00:00:00');
        $end = strtotime('2017-10-23 00:00:00');
        if (in_array($user->user_id, $cs_arr)) {
            $start = $start - 3600 * 24;
        }
        $now = time();
        if ($now >= $start && $now < $end && $user->province == 26) {
            if ($v->goods_id == 9838) {
                if ($num >= 720) {
                    $price = 6;
                }
            }
        }
        return $price;
    }

    public static function cyn($v, $user)
    {
        $cs_arr = [18810, 13960, 12567];
        $start = strtotime('2017-05-22 00:00:00');
        $end = strtotime('2017-06-01 00:00:00');
        if (in_array($user->user_id, $cs_arr)) {
            $start = $start - 3600 * 24;
        }
        $now = time();
        $cyn = DB::table('cyn')->lists('user_id');
        if ($v->goods_id == 20762 && $now >= $start && $now < $end && in_array($user->user_id, $cyn)) {
            $v->ls_gg = 100;
            $v->real_price = 14.9;
        }
        return $v;
    }

    public static function cyn_num($v, $user, $goods_number = 0)
    {
        $cs_arr = [18810, 13960, 12567];
        $start = strtotime('2017-05-22 00:00:00');
        $end = strtotime('2017-06-01 00:00:00');
        if (in_array($user->user_id, $cs_arr)) {
            $start = $start - 3600 * 24;
        }
        $now = time();
        $cyn = DB::table('cyn')->lists('user_id');
        if ($v->goods_id == 20762 && $now >= $start && $now < $end && in_array($user->user_id, $cyn)) {
            if ($goods_number > 0) {
                if ($goods_number < 50) {
                    $goods_number = 50;
                }
            }
        }
        return $goods_number;
    }

    public static function check_zp_goods($user, $v, $check_type)
    {
        foreach ($v->goods->zp_goods as $zp_goods) {
            $zp_id = $zp_goods->pivot->zp_id;
            $type = $zp_goods->pivot->type;
            $goods_number = $zp_goods->pivot->goods_number;
            $is_erp = $zp_goods->pivot->is_erp;
            if ($is_erp == 0) {//线上开赠品
                if ($type == 0 && ($check_type == -1)) {//满足条件只送一次
                    $num1 = $zp_goods->goods_number;
                    if ($v->goods_number >= $goods_number && $zp_goods->pivot->zp_number <= $num1) {
                        $check_type = $type;
                        $v = Cart::create_zp_cart($user, $zp_goods, $v, $zp_goods->pivot->zp_number);
                        break;
                    }
                } elseif ($type == 1 && $check_type == -1) {//满足条件累计赠送
                    $num1 = $zp_goods->goods_number;
                    if ($v->goods_number >= $goods_number && $zp_goods->pivot->zp_number <= $num1) {
                        $check_type = $type;
                        $bili = floor($v->goods_number / $goods_number);
                        $v = Cart::create_zp_cart($user, $zp_goods, $v, $zp_goods->pivot->zp_number * $bili);
                        break;
                    }
                } elseif ($type == 2 && $check_type == -1) {//不同条件赠送不同
                    $num1 = $zp_goods->goods_number;
                    if ($v->goods_number >= $goods_number && $zp_goods->pivot->zp_number <= $num1) {
                        $check_type = $type;
                        $v = Cart::create_zp_cart($user, $zp_goods, $v, $zp_goods->pivot->zp_number);
                        break;
                    }
                } elseif ($type == 4 && $check_type == -1) {//不同条件赠送不同
                    $num1 = $zp_goods->goods_number;
                    if ($v->goods_number >= $goods_number && $zp_goods->pivot->zp_number <= $num1) {
                        $check_type = $type;
                        $v = Cart::create_zp_cart($user, $zp_goods, $v, $v->goods_number);
                        break;
                    }
                } elseif ($type == 3 && $check_type == -1) {//只显示促销信息
                    if ($zp_goods->goods_id == $v->goods_id) {//赠送本品
                        $num1 = $zp_goods->goods_number - $goods_number;
                    } else {
                        $num1 = $zp_goods->goods_number;
                    }
                    if ($zp_goods->pivot->zp_number > $num1) {
                        $v->goods->is_zx = 0;
                        $v->goods->tsbz = str_replace('z', '', $v->goods->tsbz);
                    }
                }
            } else {//erp开赠品
                if ($zp_goods->goods_id == $v->goods_id) {//赠送本品
                    $num1 = $zp_goods->goods_number - $goods_number;
                } else {
                    $num1 = $zp_goods->goods_number;
                }
                if ($v->goods_number < $goods_number) {
                    $v->goods->tsbz = str_replace('z', '', $v->goods->tsbz);
                }
                if ($zp_goods->pivot->zp_number > $num1) {//库存不足活动结束
                    $v->goods->is_zx = 0;
                    $v->goods->tsbz = str_replace('z', '', $v->goods->tsbz);
                }
            }
        }
        return $v;
    }

    public static function create_zp_cart($user, $zp_goods, $v, $zp_number)
    {
        if ($zp_goods->goods_number < $zp_number) {
            $zp_number = $zp_goods->goods_number;
        }
        $insert = new Cart();
        $insert->user_id = $user->user_id;
        $insert->goods_id = $zp_goods->goods_id;
        $insert->parent_id = $v->rec_id;
        $insert->goods_sn = $zp_goods->goods_sn;
        $insert->goods_name = $zp_goods->goods_name;
        $insert->goods_price = 0.01;
        $insert->is_real = $zp_goods->is_real;
        $insert->extension_code = time();
        $insert->is_gift = 1;
        $insert->goods_attr = '';
        $insert->is_shipping = $zp_goods->is_shipping;
        $insert->ls_gg = $zp_goods->ls_gg;
        $insert->ls_bz = $zp_goods->ls_bz;
        $insert->goods_number = $zp_number;
        //$insert->save();
        $insert->zp_goods = $zp_goods;
        $v->child[] = $insert;
        self::$zp_ids[] = $insert->goods_id;
        return $v;
    }
}
