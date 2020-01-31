<?php

namespace App\Http\Controllers;

use App\Goods;
use App\Models\CkPrice;
use App\Models\GoodsZp;
use App\MzGoods;
use Illuminate\Http\Request;

class HdController extends Controller
{
    private $assign;

    public function __construct()
    {
        $this->assign = [
            'page_title' => '活动促销-',
            'dh_check' => 28,
        ];
    }

    public function getTegong()
    {
        $this->assign['page_title'] = '特供专区-';
        return view('hd.tegong', $this->assign);
    }


    public function getCzhg()
    {
        $mz = MzGoods::where('is_show', 1)->where('start_date', '<=', time())->where('end_date', '>=', time())
            ->where('sell_point', '换购')
            ->orderBy('sort', 'desc')->orderBy('mz_id', 'desc')->get();
        //dd($mz);
        $this->assign['daohang'] = 1;
        if (time() >= strtotime(20180912)) {
            $this->assign['daohang'] = 0;
        }
        $this->assign['page_title'] = '超值换购-';
        $this->assign['mz'] = $mz;
        $this->assign['show_li'] = 1;
        if (time() > strtotime(20170716)) {
            $this->assign['show_li'] = 0;
        }
        $this->assign['img_url'] = '/images/换购专区_01.jpg';
        $ad = ads(40)->where('ad_bgc', 'czhg')->first();
        if ($ad) {
            $this->assign['img_url'] = $ad->ad_code;
            $this->assign['link'] = $ad->ad_link;
        }
        $this->assign['dh_check'] = 53;
        return view('hd.mzhg', $this->assign);
    }

    public function getJpmz()
    {
        $mz = MzGoods::where('is_show', 1)->where('start_date', '<=', time())->where('end_date', '>=', time())
            ->where('sell_point', '买赠')
            ->orderBy('sort', 'desc')->orderBy('mz_id', 'desc')->get();
        $this->assign['daohang'] = 1;
        if (time() >= strtotime(20180912)) {
            $this->assign['daohang'] = 0;
        }
        // 获取买赠商品属性
        foreach ($mz as $key => $v) {
            $goods=Goods::where('goods_id',$v->goods_id)->first();
            $v['goods']=$goods;
        }
        $this->assign['page_title'] = '精品买赠-';
        $this->assign['mz'] = $mz;
        $this->assign['show_li'] = 0;
        $this->assign['img_url'] = '/images/jpmz.jpg';
        $ad = ads(40)->where('ad_bgc', 'jpmz')->first();
        if ($ad) {
            $this->assign['img_url'] = $ad->ad_code;
            $this->assign['link'] = $ad->ad_link;
        }
        $this->assign['user'] = auth()->user();
       // dd($this->assign);
        $this->assign['dh_check'] = 56;
        return view('hd.mzhg', $this->assign);
    }

    //特价专区（促销商品）
    public function getTejia(Request $request,Goods $goods)
    {
        $user = auth()->user();
        if ($user) {
            $user = $user->is_zhongduan();
        }
        $page=$request->page;
        // $page=1;
        if(!intval($page)){
            $page=1;
        }
        $now=time();
        $where = function ($where) use ($user, $goods, $now) {
            $where->where('is_promote', 1)->where('promote_price', '>', 0)
                ->where('promote_start_date', '<=', $now)->where('promote_end_date', '>=', $now)->where('is_xkh_tj', '!=', 1)
                ->where('is_on_sale',1);
            if ($user) {
                $kx_ids = $goods->kx_goods_new($user);
                if (count($kx_ids) > 0) {
                    $where->whereNotIn('goods_id', $kx_ids);
                }
            }
        };
        $result = $goods->goods_list_new($request, $user, $where)
            ->offset(($page-1)*20)
            ->limit(20)->get();
        $count=$goods->goods_list_new($request, $user, $where)->count();
        foreach ($result as $k => $v) {
            $result[$k] = $v->attr_new($v, $user);
        }
        $this->assign['tejia']=$result;
        $this->assign['img_url'] = '/images/换购专区_01.jpg';
        $this->assign['user'] = $user;
        $this->assign['count']=$count;
        $this->assign['curr']=$page;
        return view('hd.tejia',$this->assign);
    }

    public function getYouhui(Request $request,Goods $goods)
    {

        $user = auth()->user();
        if ($user) {
            $user = $user->is_zhongduan();
        }
        $page=$request->page;
        // $page=1;
        if(!intval($page)){
            $page=1;
        }
        $now=time();
        $where = function ($where) use ($user, $goods, $now) {
            $where->where('is_promote', 0)
                    ->where('preferential_start_date', '<=', $now)->where('preferential_end_date', '>=', $now)->where('zyzk', '>', 0)
                 ->where('is_on_sale',1);
            if ($user) {
                $kx_ids = $goods->kx_goods_new($user);
                if (count($kx_ids) > 0) {
                    $where->whereNotIn('goods_id', $kx_ids);
                }
            }
        };
        $result = $goods->goods_list_new($request, $user, $where)
            ->offset(($page-1)*20)
            ->limit(20)->get();
        $count=$goods->goods_list_new($request, $user, $where)->count();
        foreach ($result as $k => $v) {
            $round = round(($v->shop_price -$v->zyzk) / $v->shop_price ,2) *10;
            $v->round = $round;
            $result[$k] = $v->attr_new($v, $user);
        }
        $this->assign['youhui']=$result;
        $this->assign['img_url'] = '/images/换购专区_01.jpg';
        $this->assign['user'] = $user;
        $this->assign['count']=$count;
        $this->assign['curr']=$page;
        return view('hd.youhui',$this->assign);
      
    }
   
    //促销专区
    public function getCxzq(Request $request, Goods $goods)
    {
        $user = auth()->user();
        if ($user) {
            $user = $user->is_zhongduan();
        }
        $this->assign['mzjx'] = [];
        $this->assign['xstj'] = [];
        $this->assign['bpms'] = [];
        $this->assign['xfmj'] = [];
        $this->assign['czhg'] = [];
        $this->assign['jpmz'] = [];
        $this->assign['cjcx'] = [];
        $this->assign['xqpz'] = [];
        $this->assign['tejia']=[];//特价专区商品
        $this->assign['youhui']=[];//优惠专区商品

        $menu = ads(174);
        $ad155 = ads(155);
        //menu代表获取广告商品
        foreach ($menu as $v) {
            if ($v->ad_id == 1565) {
                $this->assign['mzjx'] = $this->mzjx($request, $user, $goods);
            }
            if (!$user) {
                if ($v->ad_id == 1566) {
                    $this->assign['xstj'] = $this->xstj_1($request, $user, $goods);
                } elseif ($v->ad_id == 1573) {
                    $this->assign['xstj'] = $this->xstj_2($request, $user, $goods);
                }
            } else {
                if ($user->is_zhongduan == 1) {
                    if ($v->ad_id == 1566) {
                        $this->assign['xstj'] = $this->xstj_1($request, $user, $goods);
                    } elseif ($v->ad_id == 1573) {
                        $this->assign['xstj'] = $this->xstj_2($request, $user, $goods);
                    }
                }
            }
            if ($v->ad_id == 1567) {
                $this->assign['bpms'] = $this->bpms($request, $user, $goods);
            }
            if ($v->ad_id == 1568) {
                $this->assign['xfmj'] = $this->xfmj($request, $user, $goods);
            }
            if ($v->ad_id == 1569) {
                $this->assign['czhg'] = $this->hg_mz($request, $user, $goods, '换购');
            }
            
            //精品买赠
            $this->assign['jpmz'] = $this->hg_mz($request, $user, $goods, '买赠');
        
            if ($v->ad_id == 1571) {
                $this->assign['cjcx'] = $this->cjcx($request, $user, $goods);
            }
            if ($v->ad_id == 1572) {
                $this->assign['xqpz'] = $this->xqpz($request, $user, $goods);
            }
            $goods = Goods::where('goods_id',$v->ad_bgc)->first();
            // var_dump($v);
            if ($goods->is_promote == 1 && $goods->promote_start_date <= time() && $goods->promote_end_date >= time()) {
                $v['promote_price'] = $goods->promote_price;
            }else{
                $v['promote_price'] = $goods->shop_price;
            }
            $v['goods_thumb'] = $goods->goods_thumb;
            // dd($goods);
            $v['goods_name'] = $goods->goods_name;
            $v['spgg'] = $goods->ypgg;
            $v['sccj'] = $goods->product_name;
            $v['shop_price'] = $goods->shop_price;
//            $v['promote_price'] = $goods->promote_price;
        }
        //dd($menu);

        //特价专区商品
        $this->assign['tejia']=$this->tejia($request,$user,$goods);
        //优惠专区
        $this->assign['youhui']=$this->youhui($request,$user,$goods);

        $this->assign['page_title'] = '促销专区-';
        $this->assign['menu'] = $menu;
        $this->assign['ad155'] = $ad155;
        $this->assign['user'] = $user;
        $this->assign['dh_check'] = 56;

        // dd($this->assign['tejia']);
        return view('hd.cxzq1', $this->assign);
    }

    private function mzjx($request, $user, $goods)
    {
        $show_area = 26;
        if ($show_area != 26) {//争分夺秒
            $ad1 = ads(175);
            $ad2 = ads(174);
        } else {
            $ad1 = ads(175);
            $ad2 = ads(174);
        }
        //dd($ad1);
        $ids = [];
        foreach ($ad1 as $v) {
            $ids[] = $v->ad_bgc;
        }
        foreach ($ad2 as $v) {
            $ids[] = $v->ad_bgc;
        }
        $where = function ($where) use ($ids) {
            $where->whereIn('goods_id', $ids);
        };
        $query = $goods->goods_list_new($request, $user, $where, 0);
        $result = $query->take(6)->get();
        foreach ($result as $v) {
            $v = $v->attr_new($v, $user);
        }
        //dd($ad1);
        $result->time = collect($ad1->first())->get('end_time') - time();
        return $result;
    }

    private function xstj_1($request, $user, $goods)
    {
        $now = time();
        $where = function ($where) use ($user, $goods, $now) {
            $where->where('is_promote', 1)->where('promote_price', '>', 0)
                ->where('promote_start_date', '>', $now)->where('is_xkh_tj', '!=', 1);//不查新客户特价
            if ($user) {
                $kx_ids = $goods->kx_goods_new($user);
                if (count($kx_ids) > 0) {
                    $where->whereNotIn('goods_id', $kx_ids);
                }
            }
        };
        $query = $goods->goods_list_new($request, $user, $where);
        $result = $query->take(8)->get();
        foreach ($result as $v) {
            $v = $v->attr_new($v, $user);
        }
        return $result;
    }

    private function xstj_2($request, $user, $goods)
    {
        $now = time();
        $where = function ($where) use ($user, $goods, $now) {
            $where->where('is_promote', 1)->where('promote_price', '>', 0)
                ->where('promote_start_date', '<=', $now)->where('promote_end_date', '>=', $now)->where('is_xkh_tj', '!=', 1);
            if ($user) {
                $kx_ids = $goods->kx_goods_new($user);
                if (count($kx_ids) > 0) {
                    $where->whereNotIn('goods_id', $kx_ids);
                }
            }
        };
        $query = $goods->goods_list_new($request, $user, $where);
        $result = $query->take(8)->get();
        foreach ($result as $v) {
            $v = $v->attr_new($v, $user);
        }
        return $result;
    }

    private function hg_mz($request, $user, $goods, $name = '买赠')
    {
        $ids = MzGoods::where('is_show', 1)->where('start_date', '<=', time())->where('end_date', '>=', time())
            ->where('sell_point', $name)->orderBy('sort', 'desc')->lists('goods_id');
        $where = function ($where) use ($ids) {
            $where->whereIn('goods_id', $ids);
        };
        $query = $goods->goods_list_new($request, $user, $where);
        $result = $query->take(8)->get();
        $time = time();
        if ($name == '买赠') {
            $other = $goods->goods_list_new($request, $user, function ($where) use ($ids) {
                $where->whereIn('goods_sn', ['01040271', '01045260', '0600538', '0600257'])->whereIn('goods_id', $ids);
            })->get();
            foreach ($other as $v) {
                $result->prepend($v);
            }
            $num = '100';
        } else {
            $num = '100';
        }
        foreach ($result as $k => $v) {
            $v = $v->attr_new($v, $user);
            $cxxx = GoodsZp::where('start', '<=', $time)->where('end', '>', $time)
                ->where('is_delete', 0)->where('enabled', 1)
                ->where('goods_id', $v->goods_id)->orderBy('goods_number')->pluck('message');
            //$v->cxxx = str_limit($cxxx, $num, '');
            $v->cxxx = $cxxx;
            if ($k >= 8) {
                unset($result[$k]);
            }
        }
        return $result;
    }

    private function xqpz($request, $user, $goods)
    {
        $erpids = CkPrice::where('goods_number', '>', 0)->where('goods_price', '>', 0)->where('is_on_sale', 1)->lists('ERPID');
        $where = function ($where) use ($erpids) {
            $where->whereIn('ERPID', $erpids);
        };
        $query = $goods->goods_list_new($request, $user, $where);
        $result = $query->take(4)->get();
        foreach ($result as $k => $v) {
            $result[$k] = $v->attr_new($v, $user, 1);
        }
        return $result;
    }
    //获取特价商品（促销商品）
    public function tejia($request, $user, $goods)
    {
        $now=time();
        $where = function ($where) use ($user, $goods, $now) {
            $where->where('is_promote', 1)->where('promote_price', '>', 0)
                ->where('promote_start_date', '<=', $now)->where('promote_end_date', '>=', $now)->where('is_xkh_tj', '!=', 1)
                ->where('is_on_sale',1);
            if ($user) {
                $kx_ids = $goods->kx_goods_new($user);
                if (count($kx_ids) > 0) {
                    $where->whereNotIn('goods_id', $kx_ids);
                }
            }
        };
        $result = $goods->goods_list_new($request, $user, $where)->limit(8)->get();
        foreach ($result as $k => $v) {
            $result[$k] = $v->attr_new($v, $user);
        }
        return $result;
    }
    private function bpms($request, $user, $goods)
    {
        return [];
    }

    private function xfmj($request, $user, $goods)
    {
        return [];
    }

    private function cjcx($request, $user, $goods)
    {
        return [];
    }

    public function youhui( $request,$user,$goods)
    {

        $now=time();
        $where = function ($where) use ($user, $goods, $now) {
            $where->where('is_promote', 0)->where('preferential_start_date', '<=', $now)
                ->where('preferential_end_date', '>=', $now)->where('zyzk', '>', 0)
                    ->where('is_on_sale',1);
            if ($user) {
                $kx_ids = $goods->kx_goods_new($user);
                if (count($kx_ids) > 0) {
                    $where->whereNotIn('goods_id', $kx_ids);
                }
            }
        };
        $result = $goods->goods_list_new($request, $user, $where)->limit(8)->get();
        foreach ($result as $k => $v) {
            $round = round(($v->shop_price -$v->zyzk) / $v->shop_price ,2) *10;
            $v->round = $round;
            $result[$k] = $v->attr_new($v, $user);
        }
        return $result;
    }


//    public function getHdhg()
//    {
//        $time   = strtotime(20171109);
//        $result = GoodsZp::with([
//            'goods' => function ($query) {
//                $query->select('goods_id', 'goods_name', 'goods_number', 'goods_thumb', 'ypgg', 'product_name');
//            }
//        ])->where('start', '>=', $time)
//            ->whereNotIn('goods_id', [29956, 29958, 29954, 29955, 29953, 29960, 29957, 31333, 25837, 25658, 25661])
//            ->where('is_delete', 0)->where('enabled', 1)->get();
//        foreach ($result as $k => $v) {
//            if (!$v->goods) {
//                unset($result[$k]);
//            } elseif (strpos($v->message, '买赠') !== false) {
//                unset($result[$k]);
//            } else {
//                if ($v->goods->goods_number == 0 || $v->goods->is_on_sale = 0) {
//                    unset($result[$k]);
//                }
//                $v->goods_thumb = get_img_path($v->goods->goods_thumb);
//            }
//        }
//        $this->assign['result'] = $result;
//        return view('hd.hdmzhg', $this->assign);
//    }
//
//    public function getZyhg()
//    {
//        $time   = strtotime(20171109);
//        $result = GoodsZp::with([
//            'goods' => function ($query) {
//                $query->select('goods_id', 'goods_name', 'goods_number', 'goods_thumb', 'ypgg', 'product_name');
//            }
//        ])->where('start', '>=', $time)
//            ->whereIn('goods_id', [29956, 29958, 29954, 29955, 29953, 29960, 29957, 31333, 25837, 25658, 25661])
//            ->where('is_delete', 0)->where('enabled', 1)->get();
//        foreach ($result as $k => $v) {
//            if (!$v->goods) {
//                unset($result[$k]);
//            } else {
//                if ($v->goods->goods_number == 0 || $v->goods->is_on_sale = 0) {
//                    unset($result[$k]);
//                }
//                $v->goods_thumb = get_img_path($v->goods->goods_thumb);
//            }
//        }
//        $this->assign['result'] = $result;
//        return view('hd.zymzhg', $this->assign);
//    }
}
