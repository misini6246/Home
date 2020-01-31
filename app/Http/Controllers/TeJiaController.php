<?php

namespace App\Http\Controllers;

use App\kxpzPrice;
use App\Models\TejiaGoods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TeJiaController extends Controller
{
    public $assign;

    public $user;

    public function __construct()
    {
        $this->user = auth()->user();
        if ($this->user) {
            $this->user = $this->user->is_zhongduan();
        }
    }


    public function index(Request $request)
    {
        if (time() > strtotime(20171110)) {
            return redirect()->route('index');
        }
        if ($this->user) {
            if ($this->user->is_zhongduan == 0) {
                show_msg('活动仅限终端客户参与');
            }
        }
        $now = time();
        $step = trim($request->input('step', 'nextpro'));
        $type = trim($request->input('type', 'all'));
        if ($now > strtotime(20171109)) {
            switch ($step) {
                case 'nextpro':
                    $where = function ($where) use ($now) {
                        $where->where('is_promote', 1)->where('promote_price', '>', 0)
                            ->where('promote_start_date', '<=', $now)->where('promote_end_date', '>', $now);
                    };
                    break;
                case 'promotion':
                    $where = function ($where) use ($now) {
                        $where->where('is_promote', 1)->where('promote_price', '>', 0)
                            ->where('promote_start_date', '<=', $now)->where('promote_end_date', '>', $now);
                    };
                    break;
                default:
                    $where = function ($where) use ($now) {
                        $where->where('is_promote', 1)->where('promote_price', '>', 0)
                            ->where('promote_start_date', '<=', $now)->where('promote_end_date', '>', $now);
                    };
                    break;
            }
            $step = 'promotion';
        } else {
            switch ($step) {
                case 'nextpro':
                    $where = function ($where) use ($now) {
                        $where->where('is_promote', 1)->where('promote_price', '>', 0)
                            ->where('promote_start_date', '>', $now);
                    };
                    break;
                case 'promotion':
                    $where = function ($where) use ($now) {
                        $where->where('is_promote', 1)->where('promote_price', '>', 0)
                            ->where('promote_start_date', '<=', $now)->where('promote_end_date', '>', $now);
                    };
                    break;
                default:
                    $where = function ($where) use ($now) {
                        $where->where('is_promote', 1)->where('promote_price', '>', 0)
                            ->where('promote_start_date', '>', $now);
                    };
                    break;
            }
        }
        $query = $this->goods_list($request, $where);
        $product_name = Cache::tags(['shop', 'tejia'])->remember('product_name', 8 * 60, function () {
            return TejiaGoods::where('is_on_sale', 1)->groupBy('product_name')->lists('product_name');
        });
        switch ($type) {
            case 'zyyp':
                $query->where('is_zyyp', 1);
                $product_name = TejiaGoods::where('is_on_sale', 1)->groupBy('product_name')->where('is_zyyp', 1)->lists('product_name');
                break;
            case 'zk':
                $query->where('119zk', '>', 0);
                $product_name = TejiaGoods::where('is_on_sale', 1)->groupBy('product_name')->where('119zk', '>', 0)->lists('product_name');
                break;
            case 'yygdj':
                $query->whereIn('goods_id', [30189, 30574]);
                $product_name = ['辅仁药业集团有限公司', '武汉祥顺生物药业有限公司'];
                break;
            default:
                $query->where('119zk', 0)->where('is_zyyp', 0);
                break;
        }
        $result = $query->Paginate(40);
        $sccj = [];
        for ($i = 65; $i < 91; $i++) {
            $sccj[chr($i)] = [];
        }
        foreach ($product_name as $v) {
            $v = trim($v);
            $py = $this->shoupin($v);
            if (!empty($py)) {
                $sccj[$py][] = $v;
            }
        }
        foreach ($result as $v) {
            $v->sccj = $v->product_name;
            $v->spgg = $v->ypgg;
            $v->goods_thumb = get_img_path($v->goods_thumb);
            if ($v->zbz == 0) {
                $v->zbz = 1;
            }
            if ($v->ls_gg > 0) {
                $v->zbz = $v->ls_gg;
            }
            if ($v->is_zyyp == 1) {
                $v->goods_url = route('goods.zyyp', ['id' => $v->goods_id]);
            } else {
                $v->goods_url = route('goods.index', ['id' => $v->goods_id]);
            }
            if ($this->user) {
                $v->is_can_see = 1;
            } else {
                $v->is_can_see = 0;
            }
        }
        $ad160 = ads(165);
        $ad = [];
        foreach ($ad160 as $v) {
            if ($v->ad_bgc == $type) {
                $ad = $v;
                break;
            }
        }
        if (!$ad) {
            $ad_img = get_img_path('images/hd/1109/tejia_bg.jpg');
        } else {
            $ad_img = $ad->ad_code;
        }
        $this->assign['result'] = $result;
        $this->assign['sccj'] = $sccj;
        $this->assign['page_title'] = '119特价专场-';
        $this->assign['step'] = $step;
        $this->assign['page'] = intval($request->input('page', 1));
        $this->assign['daohang'] = 1;
        $this->assign['type'] = $type;
        $this->assign['ad_img'] = $ad_img;
        $view = 'tejia.hdtejia';
        $cs = $request->input('cs');
        $this->assign['cs'] = $cs;
        if ($type == 'zk') {
            $view = 'tejia.hdtejiazk';
            $this->assign['page_title'] = '119折扣专场-';
            if ($cs == 'cs') {
                $view = 'tejia.hdtejiazk';
            }
        } elseif ($type == 'zyyp') {
            $view = 'tejia.hdtejiazy';
            $this->assign['page_title'] = '119中药特价-';
            if ($cs == 'cs') {
                $view = 'tejia.hdtejiazy';
            }
        } else {
            if ($cs == 'cs') {
                $view = 'tejia.hdtejia';
            }
        }
        return view($view, $this->assign);
    }

    protected function kx_goods()
    {
        $ids = [];
        if ($this->user) {
            $kxpz = kxpzPrice::where(function ($query) {
                $query->where('ls_regions', 'like', '%.' . $this->user->country . '.%')//区域限制
                ->orwhere('ls_regions', 'like', '%.' . $this->user->province . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $this->user->city . '.%')
                    ->orwhere('ls_regions', 'like', '%.' . $this->user->district . '.%')
                    ->orwhere('user_id', $this->user->user_id);//会员限制
            })->select('area_price', 'company_price', 'goods_id')->get();
            if (count($kxpz) > 0) {
                foreach ($kxpz as $v) {
                    if ($this->user->is_zhongduan && $v->area_price > 0) {//终端客户
                        $ids[] = $v->goods_id;
                    } elseif (!$this->user->is_zhongduan && $v->company_price > 0) {
                        $ids[] = $v->goods_id;
                    }
                }
            }
        }
        return $ids;

    }

    protected function goods_list($request, $where = '')
    {
        $keywords = trim($request->input('keywords'));
        $this->assign['keywords'] = $keywords;
        $query = TejiaGoods::where('is_on_sale', 1)->where('is_promote', 1)->where('goods_number', '>', 0);
        if ($where instanceof \Closure) {
            $query->where($where);
        }
        if (!empty($keywords)) {
            $query->where('product_name', 'like', '%' . $keywords . '%');
        }
        if ($this->user) {
            $kx_ids = $this->kx_goods();
            if (count($kx_ids) > 0) {
                $query->whereNotIn('goods_id', $kx_ids);
            }
            $user_rank = $this->user->user_rank;
            if ($user_rank == 6 || $user_rank == 7) $user_rank = 1;
            $query->where(function ($query) use ($user_rank) {
                //如果已经登陆，获取地区、会员id
                $country = $this->user->country;
                $province = $this->user->province;
                $city = $this->user->city;
                $district = $this->user->district;
                $user_id = $this->user->user_id;
                if ($user_rank == 1) {
                    $query
                        ->where('yy_regions', 'not like', '%.' . $country . '.%')//没有医院限制1,6,7
                        ->where('yy_regions', 'not like', '%.' . $province . '.%')
                        ->where('yy_regions', 'not like', '%.' . $city . '.%')
                        ->where('yy_regions', 'not like', '%.' . $district . '.%')
                        ->where('yy_user_ids', 'not like', '%.' . $user_id . '.%')
                        ->where(function ($query) {
                            $query->where('ls_ranks', 'not like', '%' . $this->user->user_rank . '%')->orwhereNull('ls_ranks');
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
                    ->orwhere('ls_buy_user_id', 'like', '%.' . $user_id . '.%');//允许购买的用户
            });
        }

        return $query->orderBy('sort_order', 'desc')->orderBy('goods_id', 'desc');
    }

    private function shoupin($str)
    {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'GBK', $str);
        $s2 = iconv('GBK', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) return 'A';
        if ($asc >= -20283 && $asc <= -19776) return 'B';
        if ($asc >= -19775 && $asc <= -19219) return 'C';
        if ($asc >= -19218 && $asc <= -18711) return 'D';
        if ($asc >= -18710 && $asc <= -18527) return 'E';
        if ($asc >= -18526 && $asc <= -18240) return 'F';
        if ($asc >= -18239 && $asc <= -17923) return 'G';
        if ($asc >= -17922 && $asc <= -17418) return 'H';
        if ($asc >= -17417 && $asc <= -16475) return 'J';
        if ($asc >= -16474 && $asc <= -16213) return 'K';
        if ($asc >= -16212 && $asc <= -15641) return 'L';
        if ($asc >= -15640 && $asc <= -15166) return 'M';
        if ($asc >= -15165 && $asc <= -14923) return 'N';
        if ($asc >= -14922 && $asc <= -14915) return 'O';
        if ($asc >= -14914 && $asc <= -14631) return 'P';
        if ($asc >= -14630 && $asc <= -14150) return 'Q';
        if ($asc >= -14149 && $asc <= -14091) return 'R';
        if ($asc >= -14090 && $asc <= -13319) return 'S';
        if ($asc >= -13318 && $asc <= -12839) return 'T';
        if ($asc >= -12838 && $asc <= -12557) return 'W';
        if ($asc >= -12556 && $asc <= -11848) return 'X';
        if ($asc >= -11847 && $asc <= -11056) return 'Y';
        if ($asc >= -11055 && $asc <= -10247) return 'Z';
        return null;
    }
}
