<?php

namespace App;

use App\Models\CkPrice;
use App\Models\GoodsZp;
use App\Models\YzyC;
use App\Models\ZpGoods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Request;

class Goods extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'goods';
    protected $primaryKey = 'goods_id';

    public $sycx;
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var
     */


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function getProductIdAttribute($value)
    {
        if (is_null($value)) {
            $value = 0;
        }
        return intval($value);
    }

    public function getIsCxAttribute($value)
    {
        $this->sycx = $value;
        return $value;
    }

    //关联查询goods goods_attr
    public function goods_attr()
    {
        return $this->hasMany('App\GoodsAttr', 'goods_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function goods_attribute()
    {
        return $this->hasOne('App\GoodsAttribute', 'goods_id');
    }

    //关联查询goods member_price
    public function member_price()
    {
        return $this->hasMany('App\MemberPrice', 'goods_id');
    }

    //关联查询goods sales_volume
    public function sales_volume()
    {
        return $this->hasOne('App\SalesVolume', 'goods_id');
    }

    //关联查询goods goods_cat
    public function goods_cat()
    {
        return $this->hasMany('App\GoodsCat', 'goods_id');
    }

    //关联查询goods brand
    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brand_id');
    }

    //关联查询group_goods
    public function group_goods()
    {
        return $this->hasMany('App\GroupGoods', 'goods_id');
    }

    //关联查询group_goods
    public function cart()
    {
        return $this->hasMany('App\Cart', 'goods_id');
    }

    //关联查询goods goods_gallery
    public function goods_gallery()
    {
        return $this->hasMany('App\GoodsGallery', 'goods_id');
    }

    //关联查询goods goods_type
    public function goods_type()
    {
        return $this->belongsTo('App\GoodsType', 'goods_type', 'cat_id');
    }

    //关联查询users kxpz_price
    public function kxpz_price_user_id()
    {
        return $this->belongsTo('App\kxpzPrice', 'user_id');
    }

    //关联查询users kxpz_price
    public function kxpz_price_district()
    {
        return $this->belongsTo('App\kxpzPrice', 'district');
    }

    //关联 collect_goods
    public function collectGoods()
    {
        return $this->hasMany('App\CollectGoods', 'goods_id');
    }

    //关联 order_goods
    public function orderGoods()
    {
        return $this->hasMany('App\OrderGoods', 'goods_id');
    }

    //关联erp spzl
    public function erpSpzl()
    {
        return $this->hasOne('App\erp\Spzl', 'ERPID', 'spid');
    }

    //关联erp dwbm
    public function erpDwbm()
    {
        return $this->hasOne('App\erp\Dwbm', 'ERPID', 'ypbm');
    }

    //关联hg_goods
    public function hg_goods()
    {
        return $this->hasMany('App\HgGoods', 'goods_id');
    }


    public function user()
    {
        return $this->belongsToMany('App\User');
    }

    public function goods_zp()
    {
        return $this->hasMany(GoodsZp::class, 'goods_id', 'goods_id');
    }

    public function zp_goods()
    {
        $now = time();
        return $this->belongsToMany(ZpGoods::class, 'goods_zp', 'goods_id', 'zp_id')
            ->wherePivot('start', '<=', $now)->wherePivot('end', '>', $now)->wherePivot('is_goods', 0)
            ->wherePivot('zp_number', '<=', DB::raw('ecs_zp_goods.goods_number'))
            ->wherePivot('enabled', 1)->wherePivot('is_delete', 0)->withPivot('goods_number', 'zp_number', 'message', 'type', 'is_erp', 'is_goods')
            ->where('zp_goods.goods_number', '>', 0)->orderBy('goods_zp.goods_number', 'desc');
    }

    public function zp_goods1()
    {
        $now = time();
        return $this->belongsToMany(Goods::class, 'goods_zp', 'goods_id', 'zp_id')
            ->wherePivot('start', '<=', $now)->wherePivot('end', '>', $now)->wherePivot('is_goods', 1)
            ->wherePivot('zp_number', '<=', DB::raw('ecs_goods.goods_number'))
            ->wherePivot('enabled', 1)->wherePivot('is_delete', 0)->withPivot('goods_number', 'zp_number', 'message', 'type', 'is_erp', 'is_goods')
            ->where('goods.goods_number', '>', 0)->orderBy('goods_zp.goods_number', 'desc');
    }


    /**
     * @param $user
     * @param $sort
     * @param $order
     * @param $goods_name
     * @param $product_name
     * @param $jx
     * @param $zm
     * @param $cat_id
     * @param $phaid
     * @param $keywords
     * @param $step
     * @return mixed
     */


//    public function __construct(){
//        $now = time();
//        $this->xg_num = 0;
//        $this->real_price = $this->shop_price;
//        $this->is_can_see = 0;
//        if($this->is_promote==1&&$this->promote_start_date<=$now&&$this->promote_end_date>=$now) {
//            $this->is_cx = 1;
//            $this->real_price = $this->promote_price;
//        }
//        if($this->xg_type=3) {
//            $this->xg_type = 2;
//            $this->xg_start_date = strtotime(date("Ymd"));
//            $this->xg_end_date = strtotime(date("Ymd")) + 3600*24;
//        }
//        if($this->xg_type=4) {
//            $this->xg_type = 2;
//            $this->xg_start_date = strtotime('last monday');
//            $this->xg_end_date = strtotime('next monday');
//        }
//        $this->is_xg = $this->is_xg($this->xg_type,$this->xg_start_date,$this->xg_end_date);
//        if(auth()->check()){//会员已登录
//            $user = auth()->user()->is_new_user();
//            if($user->ls_review){//已审核
//                $this->is_can_see = 1;
//                if($this->is_cx&&$user->is_zhongduan&&$this->is_xkh_tj==0){//促销 终端 未参与新客户特价
//                    $this->is_cx = 1;
//                    $this->real_price = $this->promote_price;
//                }
//                elseif($this->is_cx&&$this->is_xkh_tj==1&&$user->is_new_user){
//                    $this->is_cx = 1;
//                    $this->real_price = $this->promote_price;
//                }else{
//                    $this->is_cx = 0;
//                    $this->real_price = $this->shop_price;
//                }
//                if($this->is_xg==1&&$user->is_zhongduan){//单张订单限购 终端
//                    $this->is_xg = 1;
//                }
//                elseif($this->is_xg==2&&$user->is_zhongduan){//时间段内限购 终端
//                    $num = OrderGoods::xg_num($this->goods_id,$user->user_id,[$this->xg_start_date,$this->xg_end_date]);//已购买的数量
//                    $this->xg_num = $this->ls_ggg - $num;
//                    if($this->xg_num<=0){//没有余量 限购结束 特价结束
//                        $this->is_xg = 0;
//                        $this->is_cx = 0;
//                        $this->real_price = $this->shop_price;
//                    }
//                }
//            }
//        }
//    }

    /*
     * 商品列表
     */
    public static function goods_list($user, $sort, $order, $goods_name, $product_name, $jx, $zm, $cat_id, $phaid, $keywords, $step)
    {
        return self::where(function ($query) use ($user, $sort, $order, $goods_name, $product_name, $jx, $zm, $cat_id, $phaid, $keywords, $step) {
            $query
                ->where('is_on_sale', 1)//上架
                ->where('is_alone_sale', 1)//作为普通商品销售
                ->where('is_delete', 0)//没有删除
            ;
            switch ($step) {
                case 'nextpro':
                    $query->where('is_promote', 1)->where('promote_price', '>', 0)
                        ->where('promote_start_date', '>', time())->where('is_xkh_tj', '!=', 1);//不查新客户特价
                    break;
                case 'promotion':
                    $query->where('is_promote', 1)->where('promote_price', '>', 0)
                        ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
                    break;
                    case 'cj';
                    $query->whereIn('goods_id',['763','13595']);
                    break;
                case 'zy':
                    $query->where('show_area', 'like', '%4%');
                    break;
            }
            if (auth()->check()) {
                $user_rank = $user->user_rank;
                //2015-1-6
                if ($user->user_rank == 1) {
                    $query->where('ls_ranks', '!=', 1);
                }
                if ($user_rank == 6 || $user_rank == 7) $user_rank = 1;
                $query->where(function ($query) use ($user, $user_rank) {
                    //如果已经登陆，获取地区、会员id
                    $country = $user->country;
                    $province = $user->province;
                    $city = $user->city;
                    $district = $user->district;
                    $user_id = $user->user_id;
                    if ($user_rank == 1) {
                        $query
                            ->where('yy_regions', 'not like', '%.' . $country . '.%')//没有医院限制1,6,7
                            ->where('yy_regions', 'not like', '%.' . $province . '.%')
                            ->where('yy_regions', 'not like', '%.' . $city . '.%')
                            ->where('yy_regions', 'not like', '%.' . $district . '.%')
                            ->where('yy_user_ids', 'not like', '%.' . $user_id . '.%')
                            ->where('ls_ranks', 'not like', '%' . $user->user_rank . '%');//没有等级限制;

                    } else {
                        $query
                            ->where('zs_regions', 'not like', '%.' . $country . '.%')//没有诊所限制
                            ->where('zs_regions', 'not like', '%.' . $province . '.%')
                            ->where('zs_regions', 'not like', '%.' . $city . '.%')
                            ->where('zs_regions', 'not like', '%.' . $district . '.%')
                            ->where('zs_user_ids', 'not like', '%.' . $user_id . '.%')
                            ->where('ls_ranks', 'not like', '%' . $user_rank . '%');//没有等级限制;
                    }
                    $query->where('ls_regions', 'not like', '%.' . $country . '.%')//没有区域限制
                    ->where('ls_regions', 'not like', '%.' . $province . '.%')
                        ->where('ls_regions', 'not like', '%.' . $city . '.%')
                        ->where('ls_regions', 'not like', '%.' . $district . '.%')
                        ->where('ls_user_ids', 'not like', '%.' . $user_id . '.%')
                        ->orwhere('xzgm', 1)
                        ->orwhere('ls_buy_user_id', 'like', '%.' . $user_id . '.%');//允许购买的用户
                });
//                if($user->hymsy==0){
//                    $query->where('hy_price',0);
//                }
            }
//            else{
//                $query->where('hy_price',0);
//            }
//            if ($brand > 0) {
//                $query->where('brand_id',$brand);
//            }
            if (!empty($keywords)) {
                $query->where(function ($query) use ($keywords) {
                    $query->where('ZJMID', 'like', "%$keywords%")->orwhere('goods_name', 'like', "%$keywords%")
                        ->orwhere('product_name', 'like', "%$keywords%");
                });
            }
            //2014-8-19
            if ($cat_id > 0 || $cat_id == 'a') {
                $query->where('show_area', 'like', '%' . $cat_id . '%');//显示区域
            }

            if ($phaid > 0) {
                $query->where('cat_ids', 'like', '%' . $phaid . '%');//药理分类
            }

            /* 2014-6-3 */
            if ($jx) {
                $query->where('jx', '=', $jx);//剂型
            }

            if ($zm) {
                $query->where('ZJMID', 'like', '%' . $zm . '%');//助记码
            }

//            if ($min > 0) {
//                $query->where('shop_price','>=',$min);
//            }
//
//            if ($max > 0) {
//                $query->where('shop_price','<=',$max);
//            }

            if ($goods_name) {//商品名称或助记码
                $query->where(function ($query) use ($goods_name) {
                    $query->where('goods_name', 'like', '%' . $goods_name . '%')
                        ->orwhere('ZJMID', 'like', '%' . $goods_name . '%');
                });
            }

            if ($product_name) {//生产厂家
                $query->where('product_name', 'like', '%' . $product_name . '%');
            }
        })
            ->orderBy($sort, $order)->orderBy('goods_thumb', 'desc')
            ->select('goods_id')
            ->Paginate(40);
    }

    public static function goods_list_ls($user, $sort, $order, $goods_name, $product_name, $jx, $zm, $cat_id, $phaid, $keywords, $step)
    {
        if ($step == 'zyzk') {
            $sort = 'zyzk';
        }
        if ($step == 'zk') {
            $sort = 'PYID';
            $order = 'asc';
        }
        return self::with([
            'member_price' => function ($query) {
                $query->select('goods_id', 'user_price', 'user_rank');
            },
            'goods_attr' => function ($query) {
                $query->select('goods_id', 'attr_id', 'attr_value');
            },
            'goods_attribute' => function ($query) {
                $query->select('goods_id', 'sccj', 'bzdw', 'ypgg', 'jzl', 'zf','zbz');
            },
            'zp_goods' => function ($query) use ($user) {
                if (auth()->check()) {
                    $query->wherePivot('zx_ranks', 'not like', '%' . $user->user_rank . '%');
                }
            },
            'zp_goods1' => function ($query) use ($user) {
                if (auth()->check()) {
                    $query->wherePivot('zx_ranks', 'not like', '%' . $user->user_rank . '%');
                }
            }
        ])->where(function ($query) use ($user, $sort, $order, $goods_name, $product_name, $jx, $zm, $cat_id, $phaid, $keywords, $step) {
            $query
                ->where('is_on_sale', 1)//上架
                ->where('is_alone_sale', 1)//作为普通商品销售
                ->where('is_delete', 0)//没有删除
            ;
            switch ($step) {
                case 'nextpro':
                    $query->where('is_promote', 1)->where('promote_price', '>', 0)
                        ->where('promote_start_date', '>', time())->where('is_xkh_tj', '!=', 1);//不查新客户特价
                    if (auth()->check()) {
                        $kx_ids = self::kx_goods();
                        if (count($kx_ids) > 0) {
                            $query->whereNotIn('goods_id', $kx_ids);
                        }
                    }
                    break;
                case 'promotion':
                    $query->where('is_promote', 1)->where('promote_price', '>', 0)
                        ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
                    if (auth()->check()) {
                        $kx_ids = self::kx_goods();
                        if (count($kx_ids) > 0) {
                            $query->whereNotIn('goods_id', $kx_ids);
                        }
                    }
                    break;
                case 'gzbl_nextpro':
                    $query->where('is_promote', 1)->where('promote_price', '>', 0)
                        ->whereIn('goods_sn', ['01012570', '01020715', '01020748', '01040522', '01041143', '01042072', '01042314',
                            '01042451', '01042707', '01042944', '01042947', '01043986', '01043987', '01045353', '01060599'])
                        ->where('promote_start_date', '>', time())->where('is_xkh_tj', '!=', 1);//不查新客户特价
                    break;
                case 'gzbl_promotion':
                    $query->where('is_promote', 1)->where('promote_price', '>', 0)
                        ->whereIn('goods_sn', ['01012570', '01020715', '01020748', '01040522', '01041143', '01042072', '01042314',
                            '01042451', '01042707', '01042944', '01042947', '01043986', '01043987', '01045353', '01060599'])
                        ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
                    break;
                case 'jzqb':
                    $query->where('tsbz', 'like', '%y%');
                    break;
                case 'mjy':
                    $query->where('product_name', 'like', '%成都岷江源药业股份有限公司%');
                    break;
                case 'drt':
                    $query->where('product_name', 'like', '%四川德仁堂中药%');
                    break;
                case 'zy':
                    $query->where('show_area', 'like', '%4%');
                    break;
                case 'zyhd':
                    $query->where(function ($query) {
                        $query
                            ->where('product_name', 'like', '%湖北金贵中药饮片有限公司%')
                            ->orwhere('product_name', 'like', '%四川天然生中药饮片有限公司%')
                            ->orwhere('product_name', 'like', '%成都岷江源药业股份有限公司%')
                            ->orwhere('product_name', 'like', '%广东正韩药业股份有限公司%');
                    });
                    break;
                case 'zk':
                    $query->where('goods_weight', '>', 0);
                    break;
                case 'hg':
                    $query->where('tsbz', 'like', '%h%');
                    break;
                case 'wjtj':
                    $query->where('tsbz', 'like', '%a%');
                    break;
                case 'id':
                    $query->whereIn('goods_id', [18046, 9758]);
                    break;
                case 'trt':
                    $query->whereIn('goods_sn', ['01031633', '01012257', '01012258', '01031921', '01044781', '01012259', '01031630', '01031631']);
                    break;
                case 'tj':
                    $query->whereIn('goods_sn', ['01060652', '01060413', '01061238', '01042625', '01061239', '01060585']);
                    break;
                case 'tjhz':
                    $query->whereIn('goods_sn', ['0600448', '01012832', '01021335', '01032154', '01045851', '01032155', '01021332', '01021334', '01046122',
                        '01021337', '01021374', '01012834', '03030703', '03030704', '01045821', '01032275', '03030719', '01045636', '01044561', '01012833', '01044559']);
                    break;
                case 'tjhzhd':
                    $query->whereIn('goods_sn', ['01012834', '01021332', '01012832', '01045851', '01032154', '01021374', '01021337', '01021334', '01021335'
                        , '03030704', '01032275', '01045821', '03030703']);
                    break;
                case 'tmh':
                    $query->whereIn('goods_sn', ['03030775', '03030774', '03030772', '03030773', '06000496', '06000498', '0600493', '0600492',
                        '0600458', '06000458', '06000340', '0600456', '0600459', '0600457', '0600393', '03030797', '0600391', '03030771',
                        '03030787', '03030783', '03030603', '03030642', '03030769', '03030776', '03030770', '03030782', '03030777', '03030648',
                        '03030646', '03030647', '03030643', '03030644', '03030557', '03030563', '03030561', '03030559', '03030566', '03030565',
                        '03030564', '03030560']);
                    break;
                case 'cjzc':
                    $query->whereIn('goods_sn', ['01044486', '01031750', '01021069', '01021067', '01031477',
                        '01046597', '01044983', '01044448', '01060987', '01061102', '01021068', '01045958',
                        '01060989', '01060988', '01031787', '01012426', '01046199', '01060986', '01012376',
                        '01044980', '01044485', '01012371', '01046601', '01044985', '01045029', '01045541',
                        '01044979', '01012087', '01045094', '02010546', '02010617', '03040329', '06000288',
                        '03030625', '03030441', '06000428', '03030443', '06000426', '03040328', '03030442',
                        '03030447', '0600426', '03040327', '0600287', '03030445', '03030446', '02010616',
                        '0600427', '06000427', '03030444', '03030440'
                    ]);
                    break;
                case 'disainuo':
                    $query->where('goods_id', '!=', 872);
                    break;
                case 'tbkw':
                    $query->whereIn('goods_sn', ['01046311', '01046309']);
                    break;
                case 'nj12':
                    $query->whereIn('goods_sn', ['01040240', '01011345']);
                    break;
                case 'nmcx':
                    $query->whereIn('goods_sn', ['01070765', '01070505']);
                    break;
                case 'qianjiang':
                    $query->where('goods_id', '!=', 25443);
                    break;
                case 'bxt':
                    $query->whereIn('goods_sn', ['02020208', '02020203', '02020318', '02020322', '02020315', '02020106', '02020110', '02020116',
                        '02020184', '02020192', '02020194', '02020210']);
                    break;
                case 'ydyy':
                    $query->whereIn('goods_sn', ['01070317', '01071624', '01070540', '01071666', '01070935']);
                    break;
                case 'hdlj':
                    $query->whereIn('goods_sn', ['01071020', '01031258', '01071023', '01071027', '01070122']);
                    break;
                case 'njzd':
                    $query->whereIn('goods_sn', ['01040453', '01046206', '01021186', '01045762', '01046207', '01045453']);
                    break;
                case 'yygdj':
                    $query->whereIn('goods_sn', ['03040515', '01013096']);
                    break;
                case 'jrzz':
                    $query->where('tsbz', 'like', '%j%');
                    break;
                case 'jwxsp':
                    $query->whereIn('goods_sn', ['01043977', '01042502', '01042226', '01042227']);
                    break;
                case 'gdzy':
                    $query->whereIn('goods_sn', ['01031793', '01031795']);
                    break;
                case 'cfsl':
                    $query->whereIn('goods_sn', ['01046284', '01046120']);
                    break;
                case 'hpyy':
                    $query->whereIn('goods_sn', ['01050056', '01031233', '01050050']);
                    break;
                case 'ysp':
                    $query->whereIn('goods_sn', ['01045260', '01040271']);
                    break;
                case 'xstp':
                    $query->whereIn('goods_sn', ['01041287', '01043084']);
                    break;
                case 'cjhd':
                    $query->whereIn('goods_sn', ['01042444', '01070198']);
                    break;
                case 'wtgk':
                    $query->whereIn('goods_sn', ['01043628', '01043988']);
                    break;
                case 'fys':
                    $query->whereIn('goods_sn', ['03020086', '03020167', '03040329', '03040328', '03040327', '02010547',
                        '02010546', '02010495', '02010497', '03030309', '03030304', '03030305', '03030307', '03030308',
                        '06000288', '0600287', '06000428', '03030626', '0600427', '06000427', '06000426', '0600426',
                        '03030625', '03030440', '03030441', '03030442', '03030443', '03030444', '03030445', '03030446', '03030447']);
                    break;
                //慢严舒柠
                case 'mysn':
                    $query->whereIn('goods_sn', ['01031260', '03030019', '03030020', '03030215', '03030022']);
                    break;
                //丽珠医药
                case 'lzyy':
                    $query->whereIn('goods_sn', ['01010149', '01030090', '01030092']);
                    break;
                //韩金靓
                case 'hjl':
                    $query->whereIn('goods_sn', ['03010085', '03010055', '03010056', '03010054', '03010086']);
                    break;
                case 'sht':
                    $query->whereIn('goods_sn', ['06000385', '06000384', '0600386', '0600387', '0600384',
                        '0600389', '0600390', '0600383', '0600380', '06000389', '0600388', '0600381', '0600385', '06000390', '06000391', '06000395', '0600382']);
                    break;
                case 'mz':
                    $query->where('tsbz', 'like', '%m%');
                    break;
                case 'zyzk':
                    $query->where(function ($where) {
                        $where->where('zyzk', '>', 0)->orwhere('is_zx', 1);
                    });
                    break;
                default:
                    if ($step != '' && $step > 0) {
                        $query->where('brand_id', intval($step));
                    }
            }
            if (auth()->check()) {
                $user_rank = $user->user_rank;
                //2015-1-6
                if ($user_rank == 6 || $user_rank == 7) $user_rank = 1;
                $query->where(function ($query) use ($user, $user_rank) {
                    //如果已经登陆，获取地区、会员id
                    $country = $user->country;
                    $province = $user->province;
                    $city = $user->city;
                    $district = $user->district;
                    $user_id = $user->user_id;
                    if ($user_rank == 1) {
                        $query
                            ->where('yy_regions', 'not like', '%.' . $country . '.%')//没有医院限制1,6,7
                            ->where('yy_regions', 'not like', '%.' . $province . '.%')
                            ->where('yy_regions', 'not like', '%.' . $city . '.%')
                            ->where('yy_regions', 'not like', '%.' . $district . '.%')
                            ->where('yy_user_ids', 'not like', '%.' . $user_id . '.%')
                            ->where(function ($query) use ($user) {
                                $query->where('ls_ranks', 'not like', '%' . $user->user_rank . '%')->orwhereNull('ls_ranks');
                            });//没有等级限制;

                    } else {
                        $query
                            ->where('zs_regions', 'not like', '%.' . $country . '.%')//没有诊所限制
                            ->where('zs_regions', 'not like', '%.' . $province . '.%')
                            ->where('zs_regions', 'not like', '%.' . $city . '.%')
                            ->where('zs_regions', 'not like', '%.' . $district . '.%')
                            ->where('zs_user_ids', 'not like', '%.' . $user_id . '.%')
                            ->where(function ($query) use ($user_rank) {
                                $query->where('ls_ranks', 'not like', '%' . $user_rank . '%')->orwhereNull('ls_ranks');
                            });//没有等级限制;
                    }
                    $query->where('ls_regions', 'not like', '%.' . $country . '.%')//没有区域限制
                    ->where('ls_regions', 'not like', '%.' . $province . '.%')
                        ->where('ls_regions', 'not like', '%.' . $city . '.%')
                        ->where('ls_regions', 'not like', '%.' . $district . '.%')
                        ->where('ls_user_ids', 'not like', '%.' . $user_id . '.%')
                        ->orwhere('xzgm', 1)
                        ->orwhere('ls_buy_user_id', 'like', '%.' . $user_id . '.%');//允许购买的用户
                });
//                if($user->hymsy==0){
//                    $query->where('hy_price',0);
//                }
            } else {
                $xz_gids = [];
                $query->whereNotIn('goods_id', $xz_gids);
            }
//            else{
//                $query->where('hy_price',0);
//            }
//            if ($brand > 0) {
//                $query->where('brand_id',$brand);
//            }
            if (!empty($keywords)) {
                if (strpos($keywords, ',') !== false) {
                    $keywords = explode(',', $keywords);
                    $query->where(function ($query) use ($keywords) {
                        foreach ($keywords as $key) {
                            $query->orwhere('ZJMID', 'like', "%$key%")->orwhere('goods_name', 'like', "%$key%")
                                ->orwhere('product_name', 'like', "%$key%");
                        }
                    });
                } else {
                    $query->where(function ($query) use ($keywords) {
                        $query->where('ZJMID', 'like', "%$keywords%")->orwhere('goods_name', 'like', "%$keywords%")
                            ->orwhere('product_name', 'like', "%$keywords%");
                    });
                }
            }
            //2014-8-19
            if (in_array($cat_id, trans('category.limit_arr'))) {
                if ($cat_id == 1) {
                    $query->where('show_area', 'not like', '%4%');//显示区域
                } else {
                    $query->where('show_area', 'like', '%' . $cat_id . '%');//显示区域
                }
            }

            if ($phaid > 0) {
                $query->where('cat_ids', 'like', '%' . $phaid . '%');//药理分类
            }

            if (in_array($phaid, ['a', 'f'])) {
                $query->where('tsbz', 'like', '%' . $phaid . '%');//药理分类
            }

            /* 2014-6-3 */
            if ($jx) {
                $query->where('jx', '=', $jx);//剂型
            }

            if ($zm) {
                $query->where('ZJMID', 'like', '%' . $zm . '%');//助记码
            }

//            if ($min > 0) {
//                $query->where('shop_price','>=',$min);
//            }
//
//            if ($max > 0) {
//                $query->where('shop_price','<=',$max);
//            }

            if ($goods_name) {//商品名称或助记码
                $query->where(function ($query) use ($goods_name) {
                    $query->where('goods_name', 'like', '%' . $goods_name . '%')
                        ->orwhere('ZJMID', 'like', '%' . $goods_name . '%');
                });
            }

            if ($product_name) {//生产厂家
                $query->where('product_name', 'like', '%' . $product_name . '%');
            }
        })
            ->orderBy($sort, $order)->orderBy('goods_thumb', 'desc')
//            ->select('goods_id','goods_name','product_name','goods_img','goods_thumb','show_area','cat_ids','ls_gg',
//                'ls_ggg','shop_price','is_xkh_tj','is_kxpz','hy_price','ls_buy_user_id','ls_regions','zs_regions',
//                'is_promote','promote_price','promote_start_date','promote_end_date','xg_type','yy_regions',
//                'zs_user_ids','yy_user_ids','ls_ranks',
//                'xg_start_date','xg_end_date','goods_number','xq','is_zx','sales_volume','market_price')
            ->Paginate(40);
    }

    /*
     * 商品信息
     */
    public static function goods_info($id)
    {
        if (auth()->check()) {
            $user = auth()->user();
            return self::with(['member_price', 'goods_attr', 'goods_attr',
                'zp_goods' => function ($query) use ($user) {
                    $query->wherePivot('zx_ranks', 'not like', '%' . $user->user_rank . '%');
                },
                'zp_goods1' => function ($query) use ($user) {
                    $query->wherePivot('zx_ranks', 'not like', '%' . $user->user_rank . '%');
                },
            ])->where('goods_id', $id)->first();
        }
        return self::with('member_price', 'goods_attr', 'goods_attr', 'zp_goods', 'zp_goods1')
            ->where('goods_id', $id)->first();
    }

    /*
     * 剂型
     */
    public static function jixing($show_area)
    {
        return self::with('goods_cat')
            ->where(function ($query) use ($show_area) {
                if ($show_area == 1) {
                    $query->where('show_area', 'not like', '%4%')
                        ->where('jx', '!=', '')
                        ->where('is_on_sale', 1)
                        ->where('is_alone_sale', 1)
                        ->where('is_delete', 0);
                } else {
                    $query->where('show_area', 'like', '%' . $show_area . '%')
                        ->where('jx', '!=', '')
                        ->where('is_on_sale', 1)
                        ->where('is_alone_sale', 1)
                        ->where('is_delete', 0);
                }
            })
            ->groupBy('jx')
            ->having('goods_num', '>', 0)
            ->select('jx', DB::raw('count(*) as goods_num'))
            ->orderBy('goods_num', 'desc')
            ->get();
    }

    /*
     * 商品价格状态属性等
     */
    public static function attr($v, $user = '', $zp = 1, $product_id = 0)
    {
        //优惠金额限制
        if($v->zyzk > 0){
            if(!(time() > $v->preferential_start_date && time() < $v->preferential_end_date)){
                $v->zyzk = 0;
            }
        }
        if ($zp == 1) {
            if (count($v->zp_goods) == 0 && count($v->zp_goods1) > 0) {
                $v->setRelation('zp_goods', $v->zp_goods1);
            }
        }
        //$v->sycx = isset($v->is_cx)?$v->is_cx:0;


        /**
         * 判断效期是否标红
         */
        $v->is_xq_red = 0;
        if (!empty($v->xq)) {
            $xq_end_time = strtotime('+8 month');
            if ($xq_end_time > strtotime($v->xq)) {//效期在8个月内 标红
                $v->is_xq_red = 1;
            }
        }

        $v->goods_sms = str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $v->goods_sms);
        $v->goods_desc = str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $v->goods_desc);
        if (empty($v)) {
            return false;
        };
        $v->is_cx = 0;
        $v->goods_img = !empty($v->getOriginal('goods_img')) ? $v->getOriginal('goods_img') : 'images/no_picture.gif';
        $v->goods_thumb = !empty($v->getOriginal('goods_thumb')) ? $v->getOriginal('goods_thumb') : 'images/no_picture.gif';
        $v->goods_img = get_img_path($v->goods_img);
        $v->goods_thumb = get_img_path($v->goods_thumb);
        if (strpos($v->show_area, '2') !== false) {//精品专区
            $v->is_jp = 1;
        } else {
            $v->is_jp = 0;
        }

        if (strpos($v->cat_ids, '180') !== false) {//麻黄碱
            $v->is_mhj = 1;
        } else {
            $v->is_mhj = 0;
        }
        if (strpos($v->cat_ids, '398') !== false) {//食品
            $v->is_shiping = 1;
        } else {
            $v->is_shiping = 0;
        }
        if (strpos($v->cat_ids, '425') !== false) {//生物制品
            $v->is_swzp = 1;
        } else {
            $v->is_swzp = 0;
        }
        if ($v->goods_attr->where('attr_id', 1)->first()) {//生产厂家存在
            $v->sccj = $v->goods_attr->where('attr_id', 1)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 2)->first()) {//单位存在
            $v->dw = $v->goods_attr->where('attr_id', 2)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 3)->first()) {//规格存在
            $v->spgg = $v->goods_attr->where('attr_id', 3)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 4)->first()) {//国药准字存在
            $v->gyzz = $v->goods_attr->where('attr_id', 4)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 5)->first()) {//件装量存在
            $v->jzl = trim($v->goods_attr->where('attr_id', 5)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 211)->first()) {//中包装存在
            $v->zbz = trim($v->goods_attr->where('attr_id', 211)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 213)->first()) {//促销信息
            $v->bzxx2 = trim($v->goods_attr->where('attr_id', 213)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 212)->first()) {//促销信息
            if ($user && $user->province == 29) {
                $v->bzxx = trim($v->goods_attr->where('attr_id', 212)->first()->attr_value);
            } else {
                $v->bzxx = '';
            }
        }
        //dd($v->show_area);

        if (strpos($v->show_area, '4') !== false) {//中药饮片
            $v->goods_url = route('goods.zyyp', ['id' => $v->goods_id]);
            $v->is_zyyp = 1;
            //dd($v,$v->goods_attribute);
            if (isset($v->goods_attribute)) {
                $v->spgg = $v->goods_attribute->ypgg;
                $v->jzl = $v->goods_attribute->jzl;
                $v->dw = $v->goods_attribute->bzdw;
                $v->cxxx = $v->goods_attribute->cxxx;
                $v->sccj = $v->goods_attribute->sccj;
                $v->gyzz = $v->goods_attribute->pzwh;
                $v->zbz = $v->goods_attribute->zbz;
            } else {
                $v->goods_attribute = $v->goods_attribute()->first();
                if ($v->goods_attribute) {
                    $v->spgg = $v->goods_attribute->ypgg;
                    $v->jzl = $v->goods_attribute->jzl;
                    $v->dw = $v->goods_attribute->bzdw;
                    $v->cxxx = $v->goods_attribute->cxxx;
                    $v->sccj = $v->goods_attribute->sccj;
                    $v->gyzz = $v->goods_attribute->pzwh;
                    $v->zbz = $v->goods_attribute->zbz;
                }
            }

        }
//        elseif(strpos($v->show_area,'n')!==false||strpos($v->show_area,'o')!==false||strpos($v->show_area,'p')!==false||strpos($v->show_area,'q')!==false){
//            $v->goods_url = route('goods.index',['id'=>$v->goods_id]);
//            $v->is_zyyp = 2;
//        }
        else {

            $v->goods_url = route('goods.index', ['id' => $v->goods_id]);
            $v->is_zyyp = 0;
        }

        if ($v->erp_shangplx == '血液制品' || $v->erp_shangplx == '冷藏药品') {
            $v->is_zyyp = 2;
        }
        if (!$v->zbz) {
            $v->zbz = 1;
        }
        $v->ls_gg = trim($v->ls_gg);
        if ($v->ls_gg > 0) {//最低购买量转中包装
            $v->zbz = $v->ls_gg;
        }
        if ($v->goods_number < $v->zbz && $v->goods_number > 0) {
            $v->zbz = $v->goods_number;
        }
        $now = time();
        $v->xg_num = 0;
        $v->real_price = $v->shop_price;
        $v->is_can_see = 0;
        if ($v->is_promote == 1 && $v->promote_start_date <= $now && $v->promote_end_date >= $now) {
            $v->is_cx = 1;
            $v->real_price = $v->promote_price;
        }

        if ($v->xg_type == 3) {
            $v->xg_type = 2;
            $v->xg_start_date = strtotime(date("Ymd"));
            $v->xg_end_date = strtotime(date("Ymd")) + 3600 * 24;
        }
        if ($v->xg_type == 4) {
            $v->xg_type = 2;
            $v->xg_start_date = strtotime("this week Monday", time());
            $v->xg_end_date = strtotime("next week Monday", time());
        }
        if ($v->xg_type == 1) {
            $v->is_xg = 1;
        } else {
            $v->is_xg = self::is_xg($v->xg_type, $v->xg_start_date, $v->xg_end_date);
        }
        $v->real_price_format = "会员可见";
        if (auth()->check()) {//会员已登录
            /**
             * 处理区域新人特价
             */
            //$v = area_xrtj_new($v, $user);
            //$v = area_xrtj($v, $user);
            //$v = qytj($v, $user);
            //$user = auth()->user()->is_new_user();
            if ( $user->ls_review || ($user->ls_review_7day ==1 && $user->day7_time > time())) {//已审核
                $v->is_can_see = 1;
                if (!$user->is_zhongduan) {//非终端用户
                    if ($v->is_cx == 1 && $v->is_xg == 2) {//商品在进行促销限购

                        $v->is_xg = 0;

                    }
                    $v->is_cx = 0;
                    $v->zyzk = 0;
                    $rank_price = $v->member_price->where('user_rank', 1)->first();
                    if (!empty($rank_price)) {
                        $v->shop_price = $rank_price->user_price;
                        $v->real_price = $rank_price->user_price;
                    } else {
                        $v->real_price = $v->shop_price;
                    }
                } else {//终端用户
                    /**
                     * 促销
                     */
                    if ($v->is_cx == 1 && $user->is_zhongduan && $v->is_xkh_tj == 0) {//促销 终端 未参与新客户特价
                        $v->is_cx = 1;
                        $v->real_price = $v->promote_price;
                    } elseif ($v->is_cx == 1 && $v->is_xkh_tj == 1 && $user->is_new_user) {
                        $v->is_cx = 1;
                        $v->real_price = $v->promote_price;
                    } else {
                        $v->is_cx = 0;
                        $v->real_price = $v->shop_price;
                    }
                }

                /**
                 * 限购
                 */

                if ($v->is_cx == 1 && $v->is_xkh_tj == 1 && $user->is_new_user == 1) {//新人特价 新人 设成单张限购
                    $v->xg_num = $v->xrtj_xg_num;
                    $v->ls_ggg = $v->xg_num;
                    if ($v->xg_num > 0) {
                        $v->is_xg = 1;
                    } else {
                        $v->is_xg = 0;
                    }
                } else {

                    if ($v->is_xg == 1) {//单张订单限购 终端
                        $v->is_xg = 1;
                        $v->xg_num = $v->ls_ggg;
                    } elseif ($v->is_xg == 2) {//时间段内限购 终端
                        $num = OrderGoods::xg_num($v->goods_id, $user->user_id, [$v->xg_start_date, $v->xg_end_date]);//已购买的数量
                        $v->xg_num = $v->ls_ggg - $num;
                        if ($v->xg_num <= 0) {//没有余量 限购结束 特价结束
                            if ($v->is_cx == 1) {//原来在促销中
                                $v->is_xg = 0;
                                $v->is_cx = 0;
                            }
                            $v->xg_num = 0;
                            $v->real_price = $v->shop_price;
                        }
                    }
                }

                /**
                 * 控销
                 */
                $v->qyhy_sp = 0;
//                if($v->hy_price>0){//哈药
//                    $v->real_price = $v->hy_price;
//                    $v->is_cx = 0;
//                }else
                if ($v->qyhy_price > 0 && $user->qyhy == 1) {//签约会员价
                    $v->real_price = $v->qyhy_price;
                    $v->qyhy_sp = 1;
                    $v->tsbz .= '签';
                    $v->is_cx = 0;
                }
                if ($v->is_kxpz == 1) {
                    $kxpz = kxpzPrice::where('goods_id', $v->goods_id)->where(function ($query) use ($user) {
                        $query->where('ls_regions', 'like', '%.' . $user->country . '.%')//区域限制
                        ->orwhere('ls_regions', 'like', '%.' . $user->province . '.%')
                            ->orwhere('ls_regions', 'like', '%.' . $user->city . '.%')
                            ->orwhere('ls_regions', 'like', '%.' . $user->district . '.%')
                            ->orwhere('user_id', $user->user_id)
//                            ->orwhere(function($query)use($user){
//                                $query->where('user_id',$user->user_id)->where('user_name',$user->user_name)
//                                    ->where('country',$user->country)->where('province',$user->province)
//                                    ->where('city',$user->city)->where('district',$user->district)
//                                    ->where('user_rank',$user->user_rank);
//                            })
                        ;//会员限制
                    })->select('area_price', 'company_price')
                        ->orderBy('price_id', 'desc')->first();
                    if ($kxpz) {//有控销价
                        if ($user->is_zhongduan && $kxpz->area_price > 0) {//终端客户
                            $v->real_price = $kxpz->area_price;
                            $v->is_cx = 0;
                        } elseif (!$user->is_zhongduan && $kxpz->company_price > 0) {
                            $v->real_price = $kxpz->company_price;
                            $v->is_cx = 0;
                        }
                    }
                }
                $v->real_price_format = formated_price($v->real_price);
            }
            $v = self::area_xg($v, $user);
        }
        $v->market_price_format = formated_price($v->market_price);
        if ($zp == 1) {
            if (count($v->zp_goods) > 0 && $v->is_zx == 0) {
                $v->is_zx = 1;
                $cxxx = collect();
                foreach ($v->zp_goods as $k => $zp_goods) {
                    $arr = explode('；', $zp_goods->pivot->message);
                    $cxxx->prepend($arr[0]);
                    if (isset($arr[1])) {
                        $cxxx->push($arr[1]);
                    }
                    if ($zp_goods->pivot->is_erp == 1) {
                        $v->tsbz .= 'z';
                    }
                }
                $v->cxxx = $cxxx->implode('；');
            }
        }
        if ($product_id == 1) {
            $v = self::ck_goods_attr($v);
            if (!$v) {
                return false;
            };
        }
        return $v;
    }

    public static function attr_yl($now, $v, $user = '')
    {
        //$v->sycx = isset($v->is_cx)?$v->is_cx:0;

        /**
         * 判断效期是否标红
         */
        $v->is_xq_red = 0;
        if (!empty($v->xq)) {
            $xq_end_time = strtotime('+8 month');
            if ($xq_end_time > strtotime($v->xq)) {//效期在8个月内 标红
                $v->is_xq_red = 1;
            }
        }

        $v->goods_sms = str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $v->goods_sms);
        $v->goods_desc = str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $v->goods_desc);
        if (empty($v)) {
            return false;
        };
        $v->is_cx = 0;
        $v->goods_img = !empty($v->goods_img) ? $v->goods_img : 'images/no_picture.gif';
        $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
        $v->goods_img = get_img_path($v->goods_img);
        $v->goods_thumb = get_img_path($v->goods_thumb);
        if (strpos($v->show_area, '2') !== false) {//精品专区
            $v->is_jp = 1;
        } else {
            $v->is_jp = 0;
        }

        if (strpos($v->cat_ids, '180') !== false) {//麻黄碱
            $v->is_mhj = 1;
        } else {
            $v->is_mhj = 0;
        }
        if (strpos($v->cat_ids, '398') !== false) {//食品
            $v->is_shiping = 1;
        } else {
            $v->is_shiping = 0;
        }
        if (strpos($v->cat_ids, '425') !== false) {//生物制品
            $v->is_swzp = 1;
        } else {
            $v->is_swzp = 0;
        }
        if ($v->goods_attr->where('attr_id', 1)->first()) {//生产厂家存在
            $v->sccj = $v->goods_attr->where('attr_id', 1)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 2)->first()) {//单位存在
            $v->dw = $v->goods_attr->where('attr_id', 2)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 3)->first()) {//规格存在
            $v->spgg = $v->goods_attr->where('attr_id', 3)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 4)->first()) {//国药准字存在
            $v->gyzz = $v->goods_attr->where('attr_id', 4)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 5)->first()) {//件装量存在
            $v->jzl = trim($v->goods_attr->where('attr_id', 5)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 211)->first()) {//中包装存在
            $v->zbz = trim($v->goods_attr->where('attr_id', 211)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 213)->first()) {//促销信息
            $v->bzxx2 = trim($v->goods_attr->where('attr_id', 213)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 212)->first()) {//促销信息
            if ($user && $user->province == 29) {
                $v->bzxx = trim($v->goods_attr->where('attr_id', 212)->first()->attr_value);
            } else {
                $v->bzxx = '';
            }
        }
        if (strpos($v->show_area, '4') !== false) {//中药饮片
            $v->goods_url = route('goods.zyyp', ['id' => $v->goods_id]);
            $v->is_zyyp = 1;
            if (isset($v->goods_attribute)) {
                $v->spgg = $v->goods_attribute->ypgg;
                $v->jzl = $v->goods_attribute->jzl;
                $v->dw = $v->goods_attribute->bzdw;
                $v->cxxx = $v->goods_attribute->cxxx;
                $v->sccj = $v->goods_attribute->sccj;
                $v->gyzz = $v->goods_attribute->pzwh;
            } else {
                $v->goods_attribute = $v->goods_attribute()->first();
                if ($v->goods_attribute) {
                    $v->spgg = $v->goods_attribute->ypgg;
                    $v->jzl = $v->goods_attribute->jzl;
                    $v->dw = $v->goods_attribute->bzdw;
                    $v->cxxx = $v->goods_attribute->cxxx;
                    $v->sccj = $v->goods_attribute->sccj;
                    $v->gyzz = $v->goods_attribute->pzwh;
                }
            }
        }
//        elseif(strpos($v->show_area,'n')!==false||strpos($v->show_area,'o')!==false||strpos($v->show_area,'p')!==false||strpos($v->show_area,'q')!==false){
//            $v->goods_url = route('goods.index',['id'=>$v->goods_id]);
//            $v->is_zyyp = 2;
//        }
        else {
            $v->goods_url = route('goods.index', ['id' => $v->goods_id]);
            $v->is_zyyp = 0;
        }

        $v->ls_gg = trim($v->ls_gg);
        if ($v->ls_gg > 0) {//最低购买量转中包装
            $v->zbz = $v->ls_gg;
            $v->ls_gg = 0;
        }
        if ($v->goods_number < $v->zbz && $v->goods_number > 0) {
            $v->zbz = $v->goods_number;
        }
        $v->xg_num = 0;
        $v->real_price = $v->shop_price;
        $v->is_can_see = 0;
        if ($v->is_promote == 1 && $v->promote_start_date <= $now && $v->promote_end_date >= $now) {
            $v->is_cx = 1;
            $v->real_price = $v->promote_price;
        }

        if ($v->xg_type == 3) {
            $v->xg_type = 2;
            $v->xg_start_date = strtotime(date("Ymd"));
            $v->xg_end_date = strtotime(date("Ymd")) + 3600 * 24;
        }
        if ($v->xg_type == 4) {
            $v->xg_type = 2;
            $v->xg_start_date = strtotime('last monday');
            $v->xg_end_date = strtotime('next monday');
        }
        if ($v->xg_type == 1) {
            $v->is_xg = 1;
        } else {
            $v->is_xg = self::is_xg($v->xg_type, $v->xg_start_date, $v->xg_end_date);
        }
        $v->real_price_format = "会员可见";
        if (auth()->check()) {//会员已登录
            /**
             * 处理区域新人特价
             */
            $v = area_xrtj_yl($now, $v, $user->city, $user->district);
            //$user = auth()->user()->is_new_user();
            if ($user->ls_review || ($user->ls_review_7day ==1 && $user->day7_time > time())) {//已审核
                $v->is_can_see = 1;
                if (!$user->is_zhongduan) {//非终端用户
                    if ($v->is_cx == 1 && $v->is_xg == 2) {//商品在进行促销限购

                        $v->is_xg = 0;

                    }
                    $v->is_cx = 0;
                    $v->zyzk = 0;
                    $rank_price = $v->member_price->where('user_rank', 1)->first();
                    if (!empty($rank_price)) {
                        $v->shop_price = $rank_price->user_price;
                        $v->real_price = $rank_price->user_price;
                    } else {
                        $v->real_price = $v->shop_price;
                    }
                } else {//终端用户
                    /**
                     * 促销
                     */
                    if ($v->is_cx == 1 && $user->is_zhongduan && $v->is_xkh_tj == 0) {//促销 终端 未参与新客户特价
                        $v->is_cx = 1;
                        $v->real_price = $v->promote_price;
                    } elseif ($v->is_cx == 1 && $v->is_xkh_tj == 1 && $user->is_new_user) {
                        $v->is_cx = 1;
                        $v->real_price = $v->promote_price;
                    } else {
                        $v->is_cx = 0;
                        $v->real_price = $v->shop_price;
                    }
                }

                /**
                 * 限购
                 */

                if ($v->is_cx == 1 && $v->is_xkh_tj == 1 && $user->is_new_user == 1) {//新人特价 新人 设成单张限购
                    $v->xg_num = $v->xrtj_xg_num;
                    $v->ls_ggg = $v->xg_num;
                    if ($v->xg_num > 0) {
                        $v->is_xg = 1;
                    } else {
                        $v->is_xg = 0;
                    }
                } else {

                    if ($v->is_xg == 1) {//单张订单限购 终端
                        $v->is_xg = 1;
                        $v->xg_num = $v->ls_ggg;
                    } elseif ($v->is_xg == 2) {//时间段内限购 终端
                        $num = OrderGoods::xg_num($v->goods_id, $user->user_id, [$v->xg_start_date, $v->xg_end_date]);//已购买的数量
                        $v->xg_num = $v->ls_ggg - $num;
                        if ($v->xg_num <= 0) {//没有余量 限购结束 特价结束
                            if ($v->is_cx == 1) {//原来在促销中
                                $v->is_xg = 0;
                                $v->is_cx = 0;
                            }
                            $v->real_price = $v->shop_price;
                        }
                    }
                }

                /**
                 * 控销
                 */
                $v->qyhy_sp = 0;
//                if($v->hy_price>0){//哈药
//                    $v->real_price = $v->hy_price;
//                    $v->is_cx = 0;
//                }else
                if ($v->qyhy_price > 0 && $user->qyhy == 1) {//签约会员价
                    $v->real_price = $v->qyhy_price;
                    $v->qyhy_sp = 1;
                    $v->tsbz .= '签';
                    $v->is_cx = 0;
                }
                if ($v->is_kxpz == 1) {
                    $kxpz = kxpzPrice::where('goods_id', $v->goods_id)->where(function ($query) use ($user) {
                        $query->where('ls_regions', 'like', '%.' . $user->country . '.%')//区域限制
                        ->orwhere('ls_regions', 'like', '%.' . $user->province . '.%')
                            ->orwhere('ls_regions', 'like', '%.' . $user->city . '.%')
                            ->orwhere('ls_regions', 'like', '%.' . $user->district . '.%')
                            ->orwhere('user_id', $user->user_id)
//                            ->orwhere(function($query)use($user){
//                                $query->where('user_id',$user->user_id)->where('user_name',$user->user_name)
//                                    ->where('country',$user->country)->where('province',$user->province)
//                                    ->where('city',$user->city)->where('district',$user->district)
//                                    ->where('user_rank',$user->user_rank);
//                            })
                        ;//会员限制
                    })->select('area_price', 'company_price')
                        ->orderBy('price_id', 'desc')->first();
                    if ($kxpz) {//有控销价
                        if ($user->is_zhongduan && $kxpz->area_price > 0) {//终端客户
                            $v->real_price = $kxpz->area_price;
                            $v->is_cx = 0;
                        } elseif (!$user->is_zhongduan && $kxpz->company_price > 0) {
                            $v->real_price = $kxpz->company_price;
                            $v->is_cx = 0;
                        }
                    }
                }
                $v->real_price_format = formated_price($v->real_price);
            }
            $v = self::area_xg($v, $user);
        }
        $v->market_price_format = formated_price($v->market_price);
        return $v;
    }

    /*
     * 商品说明书
     */
    public function getSms()
    {
        return $this->goods_sms;
    }

    /*
     * 为您推荐
     */
    public static function wntj($num)
    {
        return self::where('is_on_sale', '=', 1)->where('is_alone_sale', 1)->where('is_delete', 0)->where('is_wntj', 1)
            ->take($num)->lists('goods_id');
    }

    /**
     * 判断商品是否促销
     */
//    public function is_cx($status,$start,$end,$is_xkh_tj,$is_zhongduan=1,$is_new_user=0){
//        if($status==1&&time()>=$start&&time()<=$end&&$is_xkh_tj==0&&$is_zhongduan==1){//商品促销中 非新客户特价
//            return 1;
//        }
//        elseif($status==1&&time()>=$start&&time()<=$end&&$is_xkh_tj==1&&$is_new_user==1){
//            return 1;
//        }
//        else{
//            return 0;
//        }
//    }

    /**
     * 判断商品是否限购
     */
    public static function is_xg($status, $start, $end)
    {
        if ($status != 0 && time() >= $start && time() <= $end) {//商品限购
            return $status;
        } else {
            return 0;
        }
    }

    /**
     * @param $goods
     * @param $user
     */
    public static function area_xg($goods, $user)
    {
        $country = $user->country;
        $province = $user->province;
        $city = $user->city;
        $district = $user->district;
        $user_rank = $user->user_rank;
        $user_id = $user->user_id;
        $goods->is_can_buy = 1;
//        if($user->hymsy==0&&$goods->hy_price>0){//非码上有用户不能购买哈药
//            $goods->is_can_buy = 0;
//            return $goods;
//        }
        $arr = explode('.', $goods->ls_buy_user_id);
        $arr1 = explode('.', $goods->ls_regions);//区域限制
        $arr2 = explode('.', $goods->zs_regions);//诊所限制
        $arr3 = explode('.', $goods->yy_regions);//医院限制
        $arr4 = explode('.', $goods->zs_user_ids);//诊所会员限制
        $arr5 = explode('.', $goods->yy_user_ids);//医院会员限制
        $arr6 = explode(',', $goods->ls_ranks);//等级限制
        if (!in_array($user_id, $arr)) {
            if (in_array($user_rank, $arr6)) {
                $goods->is_can_buy = 0;
                if (in_array($user->city, [339, 336, 332, 328, 324]) && in_array($user->user_rank, [1, 2, 5]) && $goods->goods_id == 25257) {
                    $goods->is_can_buy = 1;
                }
                if (in_array($user->city, [322, 342, 327, 331]) && in_array($user->user_rank, [2]) && in_array($goods->goods_id, [14203, 14288, 7579])) {
                    $goods->is_can_buy = 1;
                }
                if (in_array($user->city, [322]) && in_array($user->user_rank, [2]) && in_array($goods->goods_id, [14063])) {
                    $goods->is_can_buy = 1;
                }
                return $goods;
            }
            if (in_array($country, $arr1) || in_array($province, $arr1) || in_array($city, $arr1) || in_array($district, $arr1)) {
                $goods->is_can_buy = 0;
                if (in_array($user->city, [322, 342, 327, 331]) && in_array($user->user_rank, [2]) && in_array($goods->goods_id, [14203])) {
                    $goods->is_can_buy = 1;
                }
                return $goods;
            }
            if (!$user->is_zhongduan &&
                (in_array($country, $arr3) || in_array($province, $arr3) || in_array($city, $arr3) || in_array($district, $arr3) || in_array($user_id, $arr5))
            ) {
                $goods->is_can_buy = 0;
                return $goods;
            }
            if ($user->is_zhongduan &&
                (in_array($country, $arr2) || in_array($province, $arr2) || in_array($city, $arr2) || in_array($district, $arr2) || in_array($user_id, $arr4))
            ) {
                $goods->is_can_buy = 0;
                return $goods;
            }
        }
        return $goods;
    }

    /**
     * @param $goods
     * @param $user
     * @return array
     */
    public static function check_cart($goods, $user)
    {
        $result = [
            'error' => 0,
            'message' => $goods->goods_name,
        ];
        if (!auth()->check()) {

            $result['error'] = 1;
            $result['message'] = "请登陆后操作";
            return $result;

        }

//        if (($goods->goods_id == 22207 || $goods->goods_id == 12270)) {
//            $zq_count = OrderInfo::where('user_id', $user->user_id)->where('is_zq', 1)->where('order_status', 1)->where('pay_status', 0)->count();
//            if ($zq_count > 0) {
//                $result['error']   = 1;
//                $result['message'] = "账期未结清不能购买充值礼包";
//                return $result;
//            }
//        }

        //采购、提货、收货委托书及身份证复印件  user_rank  weitsh_yxq
        $yyzz_time = strtotime(trim($user->yyzz_time));
        $xkz_time = strtotime(trim($user->xkz_time));
        $zs_time = strtotime(trim($user->zs_time));
        $yljg_time = strtotime(trim($user->yljg_time));
        $cgwts_time = strtotime(trim($user->cgwts_time));
        $org_cert_validity = strtotime(trim($user->org_cert_validity));

        // 2014-11-26 采购、提货、收货委托书及身份证复印件
        $user->user_rank = intval($user->user_rank);
        $user->ls_mzy = intval($user->ls_mzy);
        $user->ls_swzp = intval($user->ls_swzp);
        $user->mhj_number = intval($user->mhj_number);
        $time = time();
        if ($user->ls_review==0 &&( $user->ls_review_7day == 0 || ($user->ls_review_7day == 1 && $user->day7_time < time()))) {
            $result['error'] = 1;
            $result['message'] = "未审核不能购买商品";
            return $result;
        }
        //dd($user,$user->yyzz_time , $time);
        //if($user->user_rank != 1){
        if ($yyzz_time && $yyzz_time < $time) {
            $result['error'] = 1;
            $result['message'] = "您的二类器械备案已过期，请尽快重新邮寄";
            return $result;
        }
        if ($xkz_time && $xkz_time < $time) {
            $result['error'] = 1;
            $result['message'] = "您的药品经营许可证已过期，请尽快重新邮寄";
            return $result;
        }
        if ($zs_time && $zs_time < $time) {

            $result['error'] = 1;
            $result['message'] = "您的GSP证书已过期，请尽快重新邮寄";
            return $result;

        }
        if ($yljg_time && $yljg_time < $time) {

            $result['error'] = 1;
            $result['message'] = "您的医疗机构执业许可证已过期，请尽快重新邮寄";
            return $result;

        }
        if ($cgwts_time && $cgwts_time < $time) {

            $result['error'] = 1;
            $result['message'] = "您的采购委托书已过期，请尽快重新邮寄";
            return $result;

        }
        if ($org_cert_validity && $org_cert_validity < $time) {

            $result['error'] = 1;
            $result['message'] = "您的食品流通证已过期，请尽快重新邮寄";
            return $result;

        }
        //}

        if ($goods->is_can_buy == 0) {//限购商品
            $result['error'] = 1;
            $result['message'] .= "商品限购,如需购买请联系客服!";
            return $result;
        }

        if ($goods->is_on_sale == 0) {//没上架
            $result['error'] = 1;
            $result['message'] .= "商品已下架!";
            return $result;
        }

//        if($goods->is_delete!=0){//已删除
//            $result['error'] = 1;
//            $result['message'] = "商品已下架!";
//            return $result;
//        }
//
//        if($goods->is_alone_sale!=1){//已删除
//            $result['error'] = 1;
//            $result['message'] = "商品已下架!";
//            return $result;
//        }

		if(in_array($goods->jx,['大输液','针剂'])){
            if($user->user_rank != '5'){
                $result['error'] = 1;
                $result['message'] .= "本商品只能诊所购买";
                return $result;
            }
        }

        if ($goods->real_price <= 0) {

            $result['error'] = 1;
            $result['message'] .= "价格正在制定中!";
            return $result;

        }
		
		
		$chufang = $user->get_chufang();
        if(!empty($goods->OTC) && !in_array($goods->OTC,$chufang)){
            $result['error'] = 1;
            $result['message'] = "你不能购买".$goods->OTC.'的权限';
            return $result;
        }
		
        $user = $user->get_jyfw();
        //dd($goods->erp_shangplx, $user->jyfw);
        if (!empty($goods->erp_shangplx) && !in_array($goods->erp_shangplx, $user->jyfw)) {
            $result['error'] = 1;
            if (Request::ajax()) {
                $result['message'] = "您提供的资质不具备购买" . $goods->erp_shangplx . "的权限，详情请咨询客服人员！";
                if ($goods->erp_shangplx == '血液制品') {
                    $result['message'] = "您未邮寄血液制品采购委托书，暂时不能购买，可直接下载血液制品采购委托书或咨询客服人员";
                } elseif ($goods->erp_shangplx == '冷藏药品') {
                    $result['message'] = "您未邮寄冷藏药品采购委托书，暂时不能购买，可直接下载冷藏药品采购委托书或咨询客服人员";
                }
            } else {
                $result['message'] = "您提供的资质不具备购买" . $goods->erp_shangplx . "的权限(" . $goods->goods_name . ")，详情请咨询客服人员！";
            }
            return $result;
        }
        if (empty($goods->erp_shangplx) && $user->is_only_buy == 1 && !in_array($goods->goods_id, [22207, 12270])) {
            $result['error'] = 1;
            if (Request::ajax()) {
                $result['message'] = "您提供的资质不具备购买" . $goods->goods_name . "的权限，详情请咨询客服人员！";
                if ($goods->erp_shangplx == '血液制品') {
                    $result['message'] = "您未邮寄血液制品采购委托书，暂时不能购买，可直接下载血液制品采购委托书或咨询客服人员";
                } elseif ($goods->erp_shangplx == '冷藏药品') {
                    $result['message'] = "您未邮寄冷藏药品采购委托书，暂时不能购买，可直接下载冷藏药品采购委托书或咨询客服人员";
                }
            } else {
                $result['message'] = "您提供的资质不具备购买" . $goods->goods_name . "的权限，详情请咨询客服人员！";
            }
            return $result;
        }
//        if($goods->is_zyyp==1 && $user->ls_mzy == 1) {
//            $result['error'] = 1;
//            $result['message'] .= "您没有购买中药饮片的权限，详情请咨询客服人员！";
//            return $result;
//        }
//        if($goods->is_swzp==1 && $user->ls_swzp == 1) {
//            $result['error'] = 1;
//            $result['message'] .= "您没有购买生物制品的权限，详情请咨询客服人员！";
//            return $result;
//        }
        if ($goods->is_mhj == 1 && $user->mhj_number == 0) {
            $result['error'] = 1;
            $result['message'] .= "您没有购买麻黄碱的权限，详情请咨询客服人员！";
            return $result;

        }

        if ($goods->is_mhj == 1 && $user->is_mhj_hz == 0) {
            $result['error'] = 1;
            $result['message'] = "有麻黄碱订单未收到回执，应GSP要求请将回执盖章拍照发给您的专属客服，补交回执后即可购买，如有疑问请联系客服或拨打电话4006028262！";
            return $result;

        }
		

//        if ($goods->is_mhj && $user->mhj_hz == 1) {
//
//            $result['error'] = 1;
//            $result['message'] .= "由于没有收到麻黄碱药品回执，不能购买麻黄碱类药品，如有疑问请联系客服！";
//            return $result;
//
//        }

        // 2015-5-12 诊所不能购买食品
//        if($goods->is_shiping==1 && $user->user_rank == 5) {
//            $result['error'] = 1;
//            $result['message'] .= "您没有购买食品的权限，详情请咨询客服人员！";
//            return $result;
//        }

        // 2015-5-12 诊所不能购买食品
//        if($goods->hy_price>0 && $user->hymsy == 0) {
//            $result['error'] = 1;
//            $result['message'] .= "未加入码上有不能购买哈药商品，详情请咨询客服人员！";
//            return $result;
//        }
        $yzy = self::yzy_czb($goods, $user);
        if (isset($yzy['error']) && $yzy['error'] == 1) {
            return $yzy;
        }
        return $result;


    }


    /**
     * @param $goods
     * @param $user
     * @return mixed
     */
    public static function check_zyzk($goods, $user)
    {//
        $user_rank = $user->user_rank;
        $province = $user->province;
        $check_arr = ['10869', '17803', '17761'];//此三种药品的zyzk只针对诊所
        if (in_array($goods->goods_id, $check_arr)) {//限制范围内的药品
            if (!($user_rank == 5 && $province == 26)) {//购买会员属于四川范围内的诊所才享有优惠
                $goods->zyzk = 0;
            }
        }
        return $goods->zyzk;
    }

    public static function updateBatch($tableName = "", $multipleData = array())
    {

        if ($tableName && !empty($multipleData)) {

            // column or fields to update
            $updateColumn = array_keys($multipleData[0]);
            $referenceColumn = $updateColumn[0]; //e.g id
            unset($updateColumn[0]);
            $whereIn = "";

            $q = "UPDATE " . $tableName . " SET ";
            foreach ($updateColumn as $uColumn) {
                $q .= $uColumn . " = CASE ";

                foreach ($multipleData as $data) {
                    $q .= "WHEN " . $referenceColumn . " = '" . $data[$referenceColumn] . "' THEN '" . $data[$uColumn] . "' ";
                }
                $q .= "ELSE " . $uColumn . " END, ";
            }
            foreach ($multipleData as $data) {
                $whereIn .= "'" . $data[$referenceColumn] . "', ";
            }
            $q = rtrim($q, ", ") . " WHERE " . $referenceColumn . " IN (" . rtrim($whereIn, ', ') . ")";

            // Update
            return DB::update(DB::raw($q));

        } else {
            return false;
        }
    }

    /**
     * @param $type
     * @param int $show_area
     * @return mixed
     */
    public static function rqdp($type, $num, $show_area = 0)
    {
        $query = self::with('goods_attr', 'goods_attribute', 'member_price')
            ->where('is_on_sale', 1)->where('is_alone_sale', 1)->where('is_delete', 0)
            ->where($type, 1);
        if ($show_area > 0) {
            $query->where('show_area', 'like', '%' . $show_area . '%');
        } elseif ($show_area < 0) {
            $query->where('show_area', 'not like', '%' . abs($show_area) . '%');
        }
        $result = $query->orderBy('sort_order', 'desc')->take($num)->get();
        $user = auth()->user();
        foreach ($result as $v) {
            $v = $v->attr($v, $user, 0);
        }
        return $result;
    }

    public static function cjsp($where, $name, $num = 8)
    {
        $query = self::with('goods_attr', 'goods_attribute')->where('is_on_sale', 1)->where('is_alone_sale', 1)->where('is_delete', 0);
        if ($where instanceof \Closure) {
            $query->where($where);
        }
        $query->orderBy('is_cx', 'desc')->orderBy('sort_order', 'desc')->select('goods_id', 'goods_name', 'goods_thumb')->take($num);
        $tags = date("Y-m-d", time());

        $goods_list = Cache::tags(['shop', 'ad', $tags])->remember($name, 60, function () use ($query) {
            return $query->get();
        });
        foreach ($goods_list as $v) {
            $v->goods_img = !empty($v->goods_img) ? $v->goods_img : 'images/no_picture.gif';
            $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
            $v->goods_img = get_img_path($v->goods_img);
            $v->goods_thumb = get_img_path($v->goods_thumb);
            if ($v->goods_attr->where('attr_id', 1)->first()) {//生产厂家存在
                $v->sccj = $v->goods_attr->where('attr_id', 1)->first()->attr_value;
            }
            if ($v->goods_attr->where('attr_id', 2)->first()) {//单位存在
                $v->dw = $v->goods_attr->where('attr_id', 2)->first()->attr_value;
            }
            if ($v->goods_attr->where('attr_id', 3)->first()) {//规格存在
                $v->spgg = $v->goods_attr->where('attr_id', 3)->first()->attr_value;
            }
            if ($v->goods_attr->where('attr_id', 4)->first()) {//国药准字存在
                $v->gyzz = $v->goods_attr->where('attr_id', 4)->first()->attr_value;
            }
            if ($v->goods_attr->where('attr_id', 5)->first()) {//件装量存在
                $v->jzl = trim($v->goods_attr->where('attr_id', 5)->first()->attr_value);
            }
            if ($v->goods_attr->where('attr_id', 211)->first()) {//中包装存在
                $v->zbz = trim($v->goods_attr->where('attr_id', 211)->first()->attr_value);
            }
        }
        return $goods_list;
    }


    public static function get_sccj()
    {
        $sccj = self::where('is_on_sale', 1)->where('is_alone_sale', 1)->where('is_delete', 0)
            ->where('product_name', '!=', '')
            ->where('show_area', 'like', '%4%')->groupBy('product_name')->lists('product_name');
        return $sccj;
    }

    public static function cache_goods_list($user, $sort, $order, $goods_name, $product_name, $jx, $zm, $cat_id, $phaid, $keywords, $step)
    {
        $query = self::where('is_on_sale', 1)//上架
        ->where('is_alone_sale', 1)//作为普通商品销售
        ->where('is_delete', 0)//没有删除
        ;
        switch ($step) {
            case 'nextpro':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->where('promote_start_date', '>', time())->where('is_xkh_tj', '!=', 1);//不查新客户特价
                break;
            case 'promotion':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
                break;
            case 'zy':
                $query->where('show_area', 'like', '%4%');
                break;
            case 'zyzk':
                $query->where(function ($where) {
                    $where->where('zyzk', '>', 0)->orwhere('is_zx', 1);
                });
                break;
            default:
                if ($step != '' && $step > 0) {
                    $query->where('brand_id', intval($step));
                }
        }
        if (auth()->check()) {
            $user_rank = $user->user_rank;
            //2015-1-6
            if ($user->user_rank == 1) {
                $query->where('ls_ranks', '!=', 1);
            }
            if ($user_rank == 6 || $user_rank == 7) $user_rank = 1;
            $query->where(function ($query) use ($user, $user_rank) {
                //如果已经登陆，获取地区、会员id
                $country = $user->country;
                $province = $user->province;
                $city = $user->city;
                $district = $user->district;
                $user_id = $user->user_id;
                if ($user_rank == 1) {
                    $query
                        ->where('yy_regions', 'not like', '%.' . $country . '.%')//没有医院限制1,6,7
                        ->where('yy_regions', 'not like', '%.' . $province . '.%')
                        ->where('yy_regions', 'not like', '%.' . $city . '.%')
                        ->where('yy_regions', 'not like', '%.' . $district . '.%')
                        ->where('yy_user_ids', 'not like', '%.' . $user_id . '.%')
                        ->where('ls_ranks', 'not like', '%' . $user->user_rank . '%');//没有等级限制;

                } else {
                    $query
                        ->where('zs_regions', 'not like', '%.' . $country . '.%')//没有诊所限制
                        ->where('zs_regions', 'not like', '%.' . $province . '.%')
                        ->where('zs_regions', 'not like', '%.' . $city . '.%')
                        ->where('zs_regions', 'not like', '%.' . $district . '.%')
                        ->where('zs_user_ids', 'not like', '%.' . $user_id . '.%')
                        ->where('ls_ranks', 'not like', '%' . $user_rank . '%');//没有等级限制;
                }
                $query->where('ls_regions', 'not like', '%.' . $country . '.%')//没有区域限制
                ->where('ls_regions', 'not like', '%.' . $province . '.%')
                    ->where('ls_regions', 'not like', '%.' . $city . '.%')
                    ->where('ls_regions', 'not like', '%.' . $district . '.%')
                    ->where('ls_user_ids', 'not like', '%.' . $user_id . '.%')
                    ->orwhere('xzgm', 1)
                    ->orwhere('ls_buy_user_id', 'like', '%.' . $user_id . '.%');//允许购买的用户
            });
//            if($user->hymsy==0){
//                $query->where('hy_price',0);
//            }
        }
//        else{
//            $query->where('hy_price',0);
//        }
//            if ($brand > 0) {
//                $query->where('brand_id',$brand);
//            }
        if (!empty($keywords)) {
            $query->where(function ($query) use ($keywords) {
                $query->where('ZJMID', 'like', "%$keywords%")->orwhere('goods_name', 'like', "%$keywords%")
                    ->orwhere('ZJMID1', 'like', "%$keywords%")->orwhere('goods_name1', 'like', "%$keywords%")
                    ->orwhere('product_name', 'like', "%$keywords%");
            });
        }
        //2014-8-19
        if (in_array($cat_id, trans('category.limit_arr'))) {
            $query->where('show_area', 'like', '%' . $cat_id . '%');//显示区域
        }

        if ($phaid > 0) {
            $query->where('cat_ids', 'like', '%' . $phaid . '%');//药理分类
        }

        if ($phaid == 'a' || $phaid == 'b') {
            $query->where('tsbz', 'like', '%' . $phaid . '%');//药理分类
        }

        /* 2014-6-3 */
        if ($jx) {
            $query->where('jx', '=', $jx);//剂型
        }

        if ($zm) {
            $query->where('ZJMID', 'like', '%' . $zm . '%');//助记码
        }

//            if ($min > 0) {
//                $query->where('shop_price','>=',$min);
//            }
//
//            if ($max > 0) {
//                $query->where('shop_price','<=',$max);
//            }

        if ($goods_name) {//商品名称或助记码
            $query->where(function ($query) use ($goods_name) {
                $query->where('goods_name', 'like', '%' . $goods_name . '%')
                    ->orwhere('ZJMID', 'like', '%' . $goods_name . '%');
            });
        }

        if ($product_name) {//生产厂家
            $query->where('product_name', 'like', '%' . $product_name . '%');
        }
        $goods_list = $query->orderBy($sort, $order)->orderBy('goods_thumb', 'desc')
            ->select('goods_id', 'goods_number')
            ->Paginate(40);
        if (count($goods_list) > 0) {
            foreach ($goods_list as $k => $v) {
                $goods_number = $v->goods_number;
                $goods_info = Cache::tags(['goods_list'])->remember($v->goods_id, 60 * 48, function () use ($v) {
                    return self::with([
                        'member_price' => function ($query) {
                            $query->select('goods_id', 'user_price', 'user_rank');
                        },
                        'goods_attr' => function ($query) {
                            $query->select('goods_id', 'attr_id', 'attr_value');
                        },
                        'goods_attribute' => function ($query) {
                            $query->select('goods_id', 'sccj', 'bzdw', 'ypgg', 'jzl', 'zf','zbz');
                        }
                    ])->where('goods_id', $v->goods_id)->first();
                });
                $goods_info = self::attr($goods_info, $user);
                $goods_info->goods_number = $goods_number;
                $goods_list[$k] = $goods_info;

            }
        }

        return $goods_list;
    }

    public function getErpShangplxAttribute($value)
    {
        return trim($value);
    }

    public function getZxRanksAttribute($value)
    {

        if (!empty($value)) {
            $value = explode(',', $value);
            foreach ($value as $k => $v) {
                if (empty($v)) {
                    unset($value[$k]);
                }
            }
        } else {
            $value = [];
        }
        return $value;
    }

    public static function kx_goods()
    {
        $ids = [];
        if (auth()->check()) {
            $user = auth()->user()->is_zhongduan();
            $kxpz = kxpzPrice::where(function ($query) use ($user) {
                $query->where('ls_regions', 'like', '%.' . $user->country . '.%')//区域限制
                ->orwhere('ls_regions', 'like', '%.' . $user->province . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $user->city . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $user->district . '.%')
                    ->orwhere('user_id', $user->user_id);//会员限制
            })->select('area_price', 'company_price', 'goods_id')->get();
            if (count($kxpz) > 0) {
                foreach ($kxpz as $v) {
                    if ($user->is_zhongduan && $v->area_price > 0) {//终端客户
                        $ids[] = $v->goods_id;
                    } elseif (!$user->is_zhongduan && $v->company_price > 0) {
                        $ids[] = $v->goods_id;
                    }
                }
            }
        }
        return $ids;

    }


    public function goods_list_new($request, $user, $where = [], $check_type = 1)
    {
        $step = trim($request->input('step'));
        $keywords = trim($request->input('keywords'));
        $jx = trim($request->input('jx'));
        $zm = trim($request->input('zm'));
        $goods_name = trim($request->input('goods_name'));
        $product_name = trim($request->input('product_name'));
        $cat_id = trim($request->input('cat_id'));
        $phaid = intval($request->input('phaid'));
        $sort = trim($request->input('sort', 'sort_order'));
        $order = trim($request->input('order'));
        if ($step == 'zyzk') {
            $sort = 'zyzk';
        } elseif ($step == 'zk') {
            $sort = 'PYID';
            $order = 'asc';
        }
        $query = self::with([
            'member_price' => function ($query) {
                $query->select('goods_id', 'user_price', 'user_rank');
            },
            'goods_attr' => function ($query) {
                $query->select('goods_id', 'attr_id', 'attr_value');
            },
            'goods_attribute' => function ($query) {
                $query->select('goods_id', 'sccj', 'bzdw', 'ypgg', 'jzl', 'zf','zbz');
            },
            'ck_price'
        ]);
        if ($where instanceof \Closure) {
            $query->where($where);
        }
        switch ($step) {
            case 'nextpro':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->where('promote_start_date', '>', time())->where('is_xkh_tj', '!=', 1);//不查新客户特价
                if (auth()->check()) {
                    $kx_ids = self::kx_goods();
                    if (count($kx_ids) > 0) {
                        $query->whereNotIn('goods_id', $kx_ids);
                    }
                }
                break;
            case 'promotion':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
                if (auth()->check()) {
                    $kx_ids = self::kx_goods();
                    if (count($kx_ids) > 0) {
                        $query->whereNotIn('goods_id', $kx_ids);
                    }
                }
                break;
            case 'gzbl_nextpro':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->whereIn('goods_sn', ['01012570', '01020715', '01020748', '01040522', '01041143', '01042072', '01042314',
                        '01042451', '01042707', '01042944', '01042947', '01043986', '01043987', '01045353', '01060599'])
                    ->where('promote_start_date', '>', time())->where('is_xkh_tj', '!=', 1);//不查新客户特价
                break;
            case 'gzbl_promotion':
                $query->where('is_promote', 1)->where('promote_price', '>', 0)
                    ->whereIn('goods_sn', ['01012570', '01020715', '01020748', '01040522', '01041143', '01042072', '01042314',
                        '01042451', '01042707', '01042944', '01042947', '01043986', '01043987', '01045353', '01060599'])
                    ->where('promote_start_date', '<=', time())->where('promote_end_date', '>=', time())->where('is_xkh_tj', '!=', 1);
                break;
            case 'jzqb':
                $query->where('tsbz', 'like', '%y%');
                break;
            case 'mjy':
                $query->where('product_name', 'like', '%成都岷江源药业股份有限公司%');
                break;
            case 'drt':
                $query->where('product_name', 'like', '%四川德仁堂中药%');
                break;
            case 'zy':
                $query->where('show_area', 'like', '%4%');
                break;
            case 'zyhd':
                $query->where(function ($query) {
                    $query
                        ->where('product_name', 'like', '%湖北金贵中药饮片有限公司%')
                        ->orwhere('product_name', 'like', '%四川天然生中药饮片有限公司%')
                        ->orwhere('product_name', 'like', '%成都岷江源药业股份有限公司%')
                        ->orwhere('product_name', 'like', '%广东正韩药业股份有限公司%');
                });
                break;
            case 'zk':
                $query->where('goods_weight', '>', 0);
                break;
            case 'hg':
                $query->where('tsbz', 'like', '%h%');
                break;
            case 'id':
                $query->whereIn('goods_id', [18046, 9758]);
                break;
            case 'trt':
                $query->whereIn('goods_sn', ['01031633', '01012257', '01012258', '01031921', '01044781', '01012259', '01031630', '01031631']);
                break;
            case 'tj':
                $query->whereIn('goods_sn', ['01060652', '01060413', '01061238', '01042625', '01061239', '01060585']);
                break;
            case 'tjhz':
                $query->whereIn('goods_sn', ['0600448', '01012832', '01021335', '01032154', '01045851', '01032155', '01021332', '01021334',
                    '01021337', '01021374', '01012834', '03030703', '03030704', '01045821']);
                break;
            //慢严舒柠
            case 'mysn':
                $query->whereIn('goods_sn', ['01031260', '03030019', '03030020', '03030215', '03030022']);
                break;
            //丽珠医药
            case 'lzyy':
                $query->whereIn('goods_sn', ['01010149', '01030090', '01030092']);
                break;
            //韩金靓
            case 'hjl':
                $query->whereIn('goods_sn', ['03010085', '03010055', '03010056', '03010054', '03010086']);
                break;
            case 'sht':
                $query->whereIn('goods_sn', ['06000385', '06000384', '0600386', '0600387', '0600384',
                    '0600389', '0600390', '0600383', '0600380', '06000389', '0600388', '0600381', '0600385', '06000390', '06000391', '06000395', '0600382']);
                break;
            case 'mz':
                $query->where('tsbz', 'like', '%m%');
                break;
            case 'zyzk':
                $query->where(function ($where) {
                    $where->where('zyzk', '>', 0)->orwhere('is_zx', 1);
                });
                break;
            default:
                if ($step != '' && $step > 0) {
                    $query->where('brand_id', intval($step));
                }
        }
        if ($check_type == 1) {
            if ($user) {
                $user_rank = $user->user_rank;
                //2015-1-6
                if ($user->user_rank == 1) {
                    $query->where('ls_ranks', '!=', 1);
                }
                if ($user_rank == 6 || $user_rank == 7) $user_rank = 1;
                $query->where(function ($query) use ($user, $user_rank) {
                    //如果已经登陆，获取地区、会员id
                    $country = $user->country;
                    $province = $user->province;
                    $city = $user->city;
                    $district = $user->district;
                    $user_id = $user->user_id;
                    if ($user_rank == 1) {
                        $query
                            ->where('yy_regions', 'not like', '%.' . $country . '.%')//没有医院限制1,6,7
                            ->where('yy_regions', 'not like', '%.' . $province . '.%')
                            ->where('yy_regions', 'not like', '%.' . $city . '.%')
                            ->where('yy_regions', 'not like', '%.' . $district . '.%')
                            ->where('yy_user_ids', 'not like', '%.' . $user_id . '.%')
                            ->where('ls_ranks', 'not like', '%' . $user->user_rank . '%');//没有等级限制;

                    } else {
                        $query
                            ->where('zs_regions', 'not like', '%.' . $country . '.%')//没有诊所限制
                            ->where('zs_regions', 'not like', '%.' . $province . '.%')
                            ->where('zs_regions', 'not like', '%.' . $city . '.%')
                            ->where('zs_regions', 'not like', '%.' . $district . '.%')
                            ->where('zs_user_ids', 'not like', '%.' . $user_id . '.%')
                            ->where('ls_ranks', 'not like', '%' . $user_rank . '%');//没有等级限制;
                    }
                    $query->where('ls_regions', 'not like', '%.' . $country . '.%')//没有区域限制
                    ->where('ls_regions', 'not like', '%.' . $province . '.%')
                        ->where('ls_regions', 'not like', '%.' . $city . '.%')
                        ->where('ls_regions', 'not like', '%.' . $district . '.%')
                        ->where('ls_user_ids', 'not like', '%.' . $user_id . '.%')
                        ->orwhere('xzgm', 1)
                        ->orwhere('ls_buy_user_id', 'like', '%.' . $user_id . '.%');//允许购买的用户
                });
//                if ($user->hymsy == 0) {
//                    $query->where('hy_price', 0);
//                }
            }
//            else {
//                $query->where('hy_price', 0);
//            }
        }
        if (!empty($keywords)) {
            if (strpos($keywords, ',') !== false) {
                $keywords = explode(',', $keywords);
                $query->where(function ($query) use ($keywords) {
                    foreach ($keywords as $key) {
                        $query->orwhere('ZJMID', 'like', "%$key%")->orwhere('goods_name', 'like', "%$key%")
                            ->orwhere('product_name', 'like', "%$key%");
                    }
                });
            } else {
                $query->where(function ($query) use ($keywords) {
                    $query->where('ZJMID', 'like', "%$keywords%")->orwhere('goods_name', 'like', "%$keywords%")
                        ->orwhere('product_name', 'like', "%$keywords%");
                });
            }
        }
        //2014-8-19
        if (in_array($cat_id, trans('category.limit_arr'))) {
            if ($cat_id == 1) {
                $query->where('show_area', 'not like', '%4%');//显示区域
            } else {
                $query->where('show_area', 'like', '%' . $cat_id . '%');//显示区域
            }
        }

        if ($phaid > 0) {
            $query->where('cat_ids', 'like', '%' . $phaid . '%');//药理分类
        }

        /* 2014-6-3 */
        if (!empty($jx)) {
            $query->where('jx', '=', $jx);//剂型
        }

        if (!empty($zm)) {
            $query->where('ZJMID', 'like', '%' . $zm . '%');//助记码
        }

        if (!empty($goods_name)) {//商品名称或助记码
            $query->where(function ($query) use ($goods_name) {
                $query->where('goods_name', 'like', '%' . $goods_name . '%')
                    ->orwhere('ZJMID', 'like', '%' . $goods_name . '%');
            });
        }

        if (!empty($product_name)) {//生产厂家
            $query->where('product_name', 'like', '%' . $product_name . '%');
        }
        $query->orderBy($sort, $order);
        return $query;
    }

    public static function attr_new($v, $user, $product_id = 0)
    {

        /**
         * 判断效期是否标红
         */
        $v->is_xq_red = 0;
        if (!empty($v->xq)) {
            $xq_end_time = strtotime('+8 month');
            if ($xq_end_time > strtotime($v->xq)) {//效期在8个月内 标红
                $v->is_xq_red = 1;
            }
        }

        $v->goods_sms = str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $v->goods_sms);
        $v->goods_desc = str_replace('/images/upload/Image/', get_img_path('images/upload/Image/'), $v->goods_desc);
        if (empty($v)) {
            return false;
        };
        $v->is_cx = 0;
        $v->goods_img = !empty($v->goods_img) ? $v->goods_img : 'images/no_picture.gif';
        $v->goods_thumb = !empty($v->goods_thumb) ? $v->goods_thumb : 'images/no_picture.gif';
        $v->goods_img = get_img_path($v->goods_img);
        $v->goods_thumb = get_img_path($v->goods_thumb);
        if (strpos($v->show_area, '2') !== false) {//精品专区
            $v->is_jp = 1;
        } else {
            $v->is_jp = 0;
        }

        if (strpos($v->cat_ids, '180') !== false) {//麻黄碱
            $v->is_mhj = 1;
        } else {
            $v->is_mhj = 0;
        }
        if (strpos($v->cat_ids, '398') !== false) {//食品
            $v->is_shiping = 1;
        } else {
            $v->is_shiping = 0;
        }
        if (strpos($v->cat_ids, '425') !== false) {//生物制品
            $v->is_swzp = 1;
        } else {
            $v->is_swzp = 0;
        }
        if ($v->goods_attr->where('attr_id', 1)->first()) {//生产厂家存在
            $v->sccj = $v->goods_attr->where('attr_id', 1)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 2)->first()) {//单位存在
            $v->dw = $v->goods_attr->where('attr_id', 2)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 3)->first()) {//规格存在
            $v->spgg = $v->goods_attr->where('attr_id', 3)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 4)->first()) {//国药准字存在
            $v->gyzz = $v->goods_attr->where('attr_id', 4)->first()->attr_value;
        }
        if ($v->goods_attr->where('attr_id', 5)->first()) {//件装量存在
            $v->jzl = trim($v->goods_attr->where('attr_id', 5)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 211)->first()) {//中包装存在
            $v->zbz = trim($v->goods_attr->where('attr_id', 211)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 213)->first()) {//促销信息
            $v->bzxx2 = trim($v->goods_attr->where('attr_id', 213)->first()->attr_value);
        }
        if ($v->goods_attr->where('attr_id', 212)->first()) {//促销信息
            if ($user && $user->province == 29) {
                $v->bzxx = trim($v->goods_attr->where('attr_id', 212)->first()->attr_value);
            } else {
                $v->bzxx = '';
            }
        }
        if (strpos($v->show_area, '4') !== false) {//中药饮片
            $v->goods_url = route('goods.zyyp', ['id' => $v->goods_id]);
            $v->is_zyyp = 1;
            if (isset($v->goods_attribute)) {
                $v->spgg = $v->goods_attribute->ypgg;
                $v->jzl = $v->goods_attribute->jzl;
                $v->dw = $v->goods_attribute->bzdw;
                $v->cxxx = $v->goods_attribute->cxxx;
                $v->sccj = $v->goods_attribute->sccj;
                $v->gyzz = $v->goods_attribute->pzwh;
            } else {
                $v->goods_attribute = $v->goods_attribute()->first();
                if ($v->goods_attribute) {
                    $v->spgg = $v->goods_attribute->ypgg;
                    $v->jzl = $v->goods_attribute->jzl;
                    $v->dw = $v->goods_attribute->bzdw;
                    $v->cxxx = $v->goods_attribute->cxxx;
                    $v->sccj = $v->goods_attribute->sccj;
                    $v->gyzz = $v->goods_attribute->pzwh;
                }
            }
        }
//        elseif(strpos($v->show_area,'n')!==false||strpos($v->show_area,'o')!==false||strpos($v->show_area,'p')!==false||strpos($v->show_area,'q')!==false){
//            $v->goods_url = route('goods.index',['id'=>$v->goods_id]);
//            $v->is_zyyp = 2;
//        }
        else {
            $v->goods_url = route('goods.index', ['id' => $v->goods_id]);
            $v->is_zyyp = 0;
        }

        $v->ls_gg = trim($v->ls_gg);
        if ($v->ls_gg > 0) {//最低购买量转中包装
            $v->zbz = $v->ls_gg;
            $v->ls_gg = 0;
        }
        if ($v->goods_number < $v->zbz && $v->goods_number > 0) {
            $v->zbz = $v->goods_number;
        }
        $now = time();
        $v->xg_num = 0;
        $v->real_price = $v->shop_price;
        $v->is_can_see = 0;
        if ($v->is_promote == 1 && $v->promote_start_date <= $now && $v->promote_end_date >= $now) {
            $v->is_cx = 1;
            $v->real_price = $v->promote_price;
        }

        if ($v->xg_type == 3) {
            $v->xg_type = 2;
            $v->xg_start_date = strtotime(date("Ymd"));
            $v->xg_end_date = strtotime(date("Ymd")) + 3600 * 24;
        }
        if ($v->xg_type == 4) {
            $v->xg_type = 2;
            $v->xg_start_date = strtotime('last monday');
            $v->xg_end_date = strtotime('next monday');
        }
        if ($v->xg_type == 1) {
            $v->is_xg = 1;
        } else {
            $v->is_xg = self::is_xg($v->xg_type, $v->xg_start_date, $v->xg_end_date);
        }
        $v->real_price_format = "会员可见";
        if (auth()->check()) {//会员已登录
            /**
             * 处理区域新人特价
             */
            $v = area_xrtj_new($v, $user);
            //$user = auth()->user()->is_new_user();
            if ($user->ls_review == 1 || ($user->ls_review_7day == 1 && $user->day7_time > time())) {//已审核
                $v->is_can_see = 1;
                if (!$user->is_zhongduan) {//非终端用户
                    if ($v->is_cx == 1 && $v->is_xg == 2) {//商品在进行促销限购

                        $v->is_xg = 0;

                    }
                    $v->is_cx = 0;
                    $v->zyzk = 0;
                    $rank_price = $v->member_price->where('user_rank', 1)->first();
                    if (!empty($rank_price)) {
                        $v->shop_price = $rank_price->user_price;
                        $v->real_price = $rank_price->user_price;
                    } else {
                        $v->real_price = $v->shop_price;
                    }
                } else {//终端用户
                    /**
                     * 促销
                     */
                    if ($v->is_cx == 1 && $user->is_zhongduan && $v->is_xkh_tj == 0) {//促销 终端 未参与新客户特价
                        $v->is_cx = 1;
                        $v->real_price = $v->promote_price;
                    } elseif ($v->is_cx == 1 && $v->is_xkh_tj == 1 && $user->is_new_user) {
                        $v->is_cx = 1;
                        $v->real_price = $v->promote_price;
                    } else {
                        $v->is_cx = 0;
                        $v->real_price = $v->shop_price;
                    }
                }

                /**
                 * 限购
                 */

                if ($v->is_cx == 1 && $v->is_xkh_tj == 1 && $user->is_new_user == 1) {//新人特价 新人 设成单张限购
                    $v->xg_num = $v->xrtj_xg_num;
                    $v->ls_ggg = $v->xg_num;
                    if ($v->xg_num > 0) {
                        $v->is_xg = 1;
                    } else {
                        $v->is_xg = 0;
                    }
                } else {

                    if ($v->is_xg == 1) {//单张订单限购 终端
                        $v->is_xg = 1;
                        $v->xg_num = $v->ls_ggg;
                    } elseif ($v->is_xg == 2) {//时间段内限购 终端
                        $num = OrderGoods::xg_num($v->goods_id, $user->user_id, [$v->xg_start_date, $v->xg_end_date]);//已购买的数量
                        $v->xg_num = $v->ls_ggg - $num;
                        if ($v->xg_num <= 0) {//没有余量 限购结束 特价结束
                            if ($v->is_cx == 1) {//原来在促销中
                                $v->is_xg = 0;
                                $v->is_cx = 0;
                            }
                            $v->real_price = $v->shop_price;
                        }
                    }
                }

                /**
                 * 控销
                 */
                $v->qyhy_sp = 0;
//                if ($v->hy_price > 0) {//哈药
//                    $v->real_price = $v->hy_price;
//                    $v->is_cx      = 0;
//                } else
                if ($v->qyhy_price > 0 && $user->qyhy == 1) {//签约会员价
                    $v->real_price = $v->qyhy_price;
                    $v->qyhy_sp = 1;
                    $v->tsbz .= '签';
                    $v->is_cx = 0;
                }
                if ($v->is_kxpz == 1) {
                    $kxpz = kxpzPrice::where('goods_id', $v->goods_id)->where(function ($query) use ($user) {
                        $query->where('ls_regions', 'like', '%.' . $user->country . '.%')//区域限制
                        ->orwhere('ls_regions', 'like', '%.' . $user->province . '.%')
                            ->orwhere('ls_regions', 'like', '%.' . $user->city . '.%')
                            ->orwhere('ls_regions', 'like', '%.' . $user->district . '.%')
                            ->orwhere('user_id', $user->user_id)
//                            ->orwhere(function($query)use($user){
//                                $query->where('user_id',$user->user_id)->where('user_name',$user->user_name)
//                                    ->where('country',$user->country)->where('province',$user->province)
//                                    ->where('city',$user->city)->where('district',$user->district)
//                                    ->where('user_rank',$user->user_rank);
//                            })
                        ;//会员限制
                    })->select('area_price', 'company_price')
                        ->orderBy('price_id', 'desc')->first();
                    if ($kxpz) {//有控销价
                        if ($user->is_zhongduan && $kxpz->area_price > 0) {//终端客户
                            $v->real_price = $kxpz->area_price;
                            $v->is_cx = 0;
                        } elseif (!$user->is_zhongduan && $kxpz->company_price > 0) {
                            $v->real_price = $kxpz->company_price;
                            $v->is_cx = 0;
                        }
                    }
                }
                $v->real_price_format = formated_price($v->real_price);
            }
            $v = self::area_xg($v, $user);
        }
        $v->market_price_format = formated_price($v->market_price);
        if ($product_id == 1) {
            $v = self::ck_goods_attr($v);
            if (!$v) {
                return false;
            };
        }
        return $v;
    }

    public static function kx_goods_new($user)
    {
        $ids = [];
        if ($user) {
            $kxpz = kxpzPrice::where(function ($query) use ($user) {
                $query->where('ls_regions', 'like', '%.' . $user->country . '.%')//区域限制
                ->orwhere('ls_regions', 'like', '%.' . $user->province . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $user->city . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $user->district . '.%')
                    ->orwhere('user_id', $user->user_id);//会员限制
            })->select('area_price', 'company_price', 'goods_id')->get();
            if (count($kxpz) > 0) {
                foreach ($kxpz as $v) {
                    if ($user->is_zhongduan && $v->area_price > 0) {//终端客户
                        $ids[] = $v->goods_id;
                    } elseif (!$user->is_zhongduan && $v->company_price > 0) {
                        $ids[] = $v->goods_id;
                    }
                }
            }
        }
        return $ids;

    }

    public function getSuppliersIdAttribute($value)
    {
        if (is_null($value)) {
            $value = 0;
        }
        return $value;
    }

    protected static function yzy_czb($goods, $user)
    {
        $result = [
            'error' => 0,
            'message' => $goods->goods_name,
        ];
        $id = $goods->goods_id;
        $yzy1 = [];//单独购买
        $yzy2 = [];//升级
        if (in_array($id, $yzy2) || in_array($id, $yzy1)) {
            $yzy_c = YzyC::find($user->user_id);
            if ($yzy_c) {//满足c级
                if ($yzy_c->type == 0) {//未领取
                    if (in_array($id, $yzy1)) {
                        $result['error'] = 1;
                        $result['message'] = '您已满足C级帮扶条件,可前往领取';
                    } elseif (in_array($id, $yzy2)) {
                        $result['error'] = 1;
                        $result['message'] = '您已满足C级帮扶条件,但未领取,可前往领取';
                    }
                } else {
                    if (in_array($id, $yzy1)) {
                        $result['error'] = 1;
                        $result['message'] = '您已满足C级帮扶条件,可购买升级包';
                    }
                }
            } else {
                if (in_array($id, $yzy2)) {
                    $result['error'] = 1;
                    $result['message'] = '您不属于C级帮扶对象,不能购买升级包';
                }
            }
        }
        return $result;
    }

    public function ck_price()
    {
        return $this->hasOne(CkPrice::class, 'ERPID', 'ERPID')
            ->where('is_on_sale', 1)->where('goods_price', '>', 0)->where('goods_number', '>', 0);
    }

    public static function ck_goods_attr($goods)
    {
        //return $goods;
        if (!$goods->ck_price) {
            return null;
        }
        $user = auth()->user();
        $info = clone $goods;
        $info->is_xg = 0;
        $info->zyzk = 0;
        $info->is_zx = 0;
        $info->xg_num = 0;
        $info->is_cx = 0;
        $info->is_xkh_tj = 0;
        $info->real_price = $goods->ck_price->goods_price;
        $info->real_price_format = '会员可见';
        if ($user && ($user->ls_review == 1 || ($user->ls_review_7day == 1 && $user->day7_time > time())) ) {
            $info->real_price_format = formated_price($goods->ck_price->goods_price);
        }
        $info->goods_number = $goods->ck_price->goods_number;
        $info->is_on_sale = $goods->ck_price->is_on_sale;
        $info->ckid = $goods->ck_price->ckid;
        $info->xq = $goods->ck_price->xq;
        $info->is_xqpz = $goods->ck_price->is_xqpz;
        $info->product_id = 1;
        $info->zbz = 1;
        $info->goods_url = route('goods.index', ['id' => $info->goods_id, 'product_id' => $info->product_id]);
        $info->zq_goods = null;
        $info->zq_goods1 = null;
        $info->cxxx = '';
        $info->bzxx = '';
        $info->bzxx2 = trans('goods.tmpz');
        return $info;
    }
}
