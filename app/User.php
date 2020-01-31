<?php

namespace App;

use App\Models\CzMoney;
use App\Models\HongbaoMoney;
use App\Models\JfMoney;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_name', 'email', 'password',
        'user_rank', 'ls_name', 'msn', 'qq', 'mobile_phone', 'country',
        'province', 'city', 'district', 'reg_time', 'last_login',
        'last_ip', 'visit_count', 'ec_salt'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];
    public $timestamps = false;

    /**
     * is_zhongduan
     */
    public $is_zhongduan;

    public $orderNum;

    public $jyfw = [];

    /**
     * is_new_user
     */
    public $is_new_user;
    public $is_new_user_xj;
    protected $start;
    protected $end;
    protected $check_province;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */


    //关联kxpzprice user_id
    public function kxpzPrice()
    {
        return $this->hasMany('App\User', 'district');
    }

    //关联kxpzprice district
    public function kxpzPriceId()
    {
        return $this->hasMany('App\User', 'user_id');
    }

    //获取ec_salt
    public function getAuthSalt()
    {
        return $this->ec_salt;
    }

    public function goods()
    {
        return $this->belongsToMany('App\Goods', 'collect_goods')->withPivot('rec_id');
    }

    public function order_goods()
    {
        return $this->hasManyThrough('App\OrderGoods', 'App\OrderInfo', 'user_id', 'order_id');
    }

    public function collect_goods()
    {
        return $this->hasMany('App\CollectGoods');
    }

    public function user_jyfw()
    {
        return $this->hasMany('App\Models\UserJyfw', 'wldwid', 'wldwid1');
    }
	
	public function user_chufang()
    {
        return $this->hasMany('App\Models\Userchufang', 'wldwid', 'wldwid1');
    }


    public function cz_money()
    {
        return $this->hasOne(CzMoney::class, 'user_id');
    }


    public function jf_money()
    {
        return $this->hasOne(JfMoney::class, 'user_id');
    }

    public function hongbao_money()
    {
        return $this->hasOne(HongbaoMoney::class, 'user_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function UserJnmj()
    {

        return $this->hasOne('App\UserJnmj', 'user_id');

    }

    /**
     * 是否终端客户
     *
     */
    public function is_zhongduan()
    {
        $this->is_zhongduan = $this->user_rank == 2 || $this->user_rank == 5;
        return $this;
    }

    public function get_jyfw()
    {
        // Cache::tags('jyfw')->flush();
        $this->jyfw = Cache::tags('jyfw')->remember($this->user_id . date("Ymd"), 60 * 5, function () {
            return $this->user_jyfw()->lists('shangplx')->toArray();
        });
        //dd($this->jyfw);
        return $this;
    }
	
	public function get_chufang()
    {
        Cache::tags('chufang')->flush();
        $chufang= Cache::tags('chufang')->remember($this->user_id . date("Ymd"), 60 * 5, function () {
            return $this->user_chufang()->lists('shangplx')->toArray();
        });
        //dd($this->jyfw);
        return $chufang;
    }

    /**
     * 是否新客户
     * province 判断条件 例如 26=26;24=26
     */
    public function is_new_user()
    {
        $this->is_zhongduan();
        $this->is_new_user = 0;
        if ($this->user_id == 22790) {
            return $this;
        }
        $this->start = strtotime("2016-05-05 00:00:00");
        $this->end = strtotime("2020-01-01 00:00:00");
        $this->check_province = 32;
        $now = time();
        $bm_id = intval(DB::table('user_bumen')->where('user_id', $this->user_id)->pluck('bm_id'));
        $time = $now - 90 * 3600 * 24;// 
        $num = OrderInfo::where('order_status', '!=', 2)->whereIn('mobile_pay', [0, 1, -1])
            ->where('user_id', $this->user_id)->count();
        if ($num == 0 && $this->is_zhongduan && $now >= $this->start && $now <= $this->end && $this->province == $this->check_province && !in_array($bm_id, [4, 10])) {
            $this->is_new_user = 1;
        }
        $this->orderNum = $num;
        return $this;
    }

    public function is_new_user_yl($now)
    {
        $this->is_zhongduan();
        $this->is_new_user = 0;
        $this->start = strtotime("2016-05-05 00:00:00");
        $this->end = strtotime("2020-01-01 00:00:00");
        $this->check_province = 26;
        $lj_time = strtotime('20170901');
        $bm_id = intval(DB::table('user_bumen')->where('user_id', $this->user_id)->pluck('bm_id'));
        if ($now < $lj_time) {
            if ($this->is_zhongduan && $now >= $this->start && $now <= $this->end && $this->province == $this->check_province && !in_array($bm_id, [4, 10])) {
                $mianyang = strtotime('2017-04-01 00:00:00');
                if (($this->city == 327 || $this->city == 323 || $this->district == 2734 || $this->district == 2729 || $this->district == 2788 || $this->district == 2896) && $now < $mianyang) {//绵阳地区(3月1号前)3个月未购买即为新客户
                    $time = $now - 90 * 3600 * 24;
                    $num = OrderInfo::where('order_status', '!=', 2)->where('mobile_pay', '<', 2)->where('mobile_pay', '!=', -2)->where('add_time', '>=', $time)->where('user_id', $this->user_id)->count();
                } else {
                    $num = OrderInfo::where('order_status', '!=', 2)->where('mobile_pay', '<', 2)->where('mobile_pay', '!=', -2)->where('user_id', $this->user_id)->count();
                    $num1 = OldOrderInfo::where('order_status', '!=', 2)->where('mobile_pay', '<', 2)->where('mobile_pay', '!=', -2)->where('user_id', $this->user_id)->count();
                    $num = $num1 + $num;
                }
                if ($num == 0) {
                    $this->is_new_user = 1;
                }
            }
        } else {
            if ($this->is_zhongduan && $now >= $this->start && $now <= $this->end && $this->province == $this->check_province && !in_array($bm_id, [4, 10])) {
                $mianyang = strtotime('2017-10-01 00:00:00');
                $district_arr = [2733, 2848];
                if (in_array($this->district, $district_arr) && $now < $mianyang) {//仁寿县地区(10月1号前)3个月未购买即为新客户
                    $time = $now - 90 * 3600 * 24;
                    $num = OrderInfo::where('order_status', '!=', 2)->where('mobile_pay', '<', 2)->where('mobile_pay', '!=', -2)->where('add_time', '>=', $time)->where('user_id', $this->user_id)->count();
                } else {
                    $time = $now - 90 * 3600 * 24;
                    $num = OrderInfo::where('order_status', '!=', 2)->where('mobile_pay', '<', 2)->where('mobile_pay', '!=', -2)
                        ->where('user_id', $this->user_id)->where('add_time', '>=', $time)->count();
                    $num1 = OldOrderInfo::where('order_status', '!=', 2)->where('mobile_pay', '<', 2)->where('mobile_pay', '!=', -2)
                        ->where('user_id', $this->user_id)->where('add_time', '>=', $time)->count();
                    $num = $num1 + $num;
                }
                if ($num == 0) {
                    $this->is_new_user = 1;
                }
            }
        }
        //$this->is_new_user = 0;
        return $this;
    }


    /**
     * @return $this
     * 新疆新人
     */
    public function is_new_user_xj()
    {
        $this->is_zhongduan();
        $this->is_new_user_xj = 0;
        $this->start = strtotime("2017-04-05 00:00:00");
        $this->end = strtotime("2018-06-01 00:00:00");
        $this->check_province = 29;
        $now = time();
        $bm_id = intval(DB::table('user_bumen')->where('user_id', $this->user_id)->pluck('bm_id'));
        if ($this->is_zhongduan && $now >= $this->start && $now <= $this->end && $this->province == $this->check_province && !in_array($bm_id, [4, 10])) {
            $num = OldOrderInfo::where('order_status', '!=', 2)->where('mobile_pay', '<', 2)->where('mobile_pay', '!=', -2)->where('user_id', $this->user_id)->count();
            if ($num == 0) {
                $num1 = OrderInfo::where('order_status', '!=', 2)->where('mobile_pay', '<', 2)->where('mobile_pay', '!=', -2)->where('user_id', $this->user_id)->count();
                $num = $num1 + $num;
            }
            if ($num == 0) {
                $this->is_new_user_xj = 1;
            }
        }
        return $this;
    }

    public function is_new_user_xj_yl($now)
    {
        $this->is_zhongduan();
        $this->is_new_user_xj = 0;
        $this->start = strtotime("2017-04-05 00:00:00");
        $this->end = strtotime("2018-06-01 00:00:00");
        $this->check_province = 29;
        $bm_id = intval(DB::table('user_bumen')->where('user_id', $this->user_id)->pluck('bm_id'));
        if ($this->is_zhongduan && $now >= $this->start && $now <= $this->end && $this->province == $this->check_province && !in_array($bm_id, [4, 10])) {
            $num = OrderInfo::where('order_status', '!=', 2)->where('mobile_pay', '<', 2)->where('mobile_pay', '!=', -2)->where('user_id', $this->user_id)->count();
            $num1 = OldOrderInfo::where('order_status', '!=', 2)->where('mobile_pay', '<', 2)->where('mobile_pay', '!=', -2)->where('user_id', $this->user_id)->count();
            $num = $num1 + $num;
            if ($num == 0) {
                $this->is_new_user_xj = 1;
            }
        }
        return $this;
    }

    /**
     * 获取用户信息
     */
    public static function new_user()
    {
        $user = auth()->user();
//        $user->is_new_user = self::is_new_user($user->user_id,$user->user_rank,strtotime("20160505"),strtotime("20160506"),$user->province==26);
//        $user->is_zhongduan = self::is_zhongduan($user->user_rank);
        return $user;
    }

    /**
     * @param $value
     * @return int
     */
    public function getUserRankAttribute($value)
    {
        if (empty($value)) {
            $value = 1;
        }
        if ($value == 6) {
            $value = 2;
        }
        return intval($value);
    }

    public function getLsZpglyAttribute($value)
    {
        $value = is_null($value) ? '' : $value;
        return $value;
    }

    public function getLsFileAttribute($value)
    {
        $value = is_null($value) ? '' : $value;
        return $value;
    }

    public function getPasswdAnswerAttribute($value)
    {
        $value = is_null($value) ? '' : $value;
        return $value;
    }

    public function setShippingNameAttribute($value)
    {
        $value = is_null($value) ? '' : $value;
        $this->attributes['shipping_name'] = $value;
    }

    public function setWlDhAttribute($value)
    {
        $value = is_null($value) ? '' : $value;
        $this->attributes['wl_dh'] = $value;
    }
}
