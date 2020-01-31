<?php

namespace App\Http\Controllers;


use App\Ad;
use App\Buy;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $nav_list;

    private $arr;

    public function __construct(){
        $this->nav_list = nav_list('middle',-1);
        $this->arr = [
            'page_title'=>'',
            'middle_nav'=>$this->nav_list,
        ];
        //dd($this->nav_list);
    }

    public function index(Request $request)
    {
        $arr = $this->arr;
        $user = auth()->user();
        $is_new_user = 0;
        //Cache::tags('shop')->flush();
        if($user){
            $show_area = auth()->user()->province;
        }else{
            $show_area = intval($request->input('show_area',26));
        }





        /**
         * 求购信息
         */
        $buy = Cache::tags(['shop','buy'])->remember('buy',60,function(){
            return Buy::buy(20);//求购信息
        });
        $arr['buy'] = $buy;

        /**
         * 广告
         */
        //$arr['ad26'] = ads(26,1);//顶部
        if($user){
            $user = $user->is_new_user();
            $is_new_user = $user->is_new_user;
        }
        if($is_new_user==1) {
            $ad27 = Ad::where('start_time', '<', time())->where('end_time', '>', time())->where('position_id', 27)->where('ad_id', 1133)
                ->select('position_id', 'ad_id', 'ad_name', 'ad_code', 'start_time', 'ad_link', 'end_time', 'ad_bgc')->first();
            $arr['ad27'] = $ad27;//弹窗
            $ad1 = Ad::where('start_time', '<', time())->where('end_time', '>', time())->where('position_id', 1)
                ->select('position_id', 'ad_id', 'ad_name', 'ad_code', 'start_time', 'ad_link', 'end_time', 'ad_bgc')
                ->orderBy('sort_order','desc')->orderBy('ad_id','desc')->get();
            foreach($ad1 as $v){
                $v->ad_code = get_img_path('data/afficheimg/'.$v->ad_code);
            }
        }else {
            $ad27 = Ad::where('start_time', '<', time())->where('end_time', '>', time())->where('position_id', 27)->where('ad_id','!=', 1133)
                ->select('position_id', 'ad_id', 'ad_name', 'ad_code', 'start_time', 'ad_link', 'end_time', 'ad_bgc')->first();
            $ad1 = Ad::where('start_time', '<', time())->where('end_time', '>', time())->where('position_id', 1)->where('ad_id','!=', 1123)
                ->select('position_id', 'ad_id', 'ad_name', 'ad_code', 'start_time', 'ad_link', 'end_time', 'ad_bgc')
                ->orderBy('sort_order','desc')->orderBy('ad_id','desc')->get();
            foreach($ad1 as $v){
                $v->ad_code = get_img_path('data/afficheimg/'.$v->ad_code);
            }
        }
        $arr['ad27'] = $ad27;//弹窗
        $arr['ad1'] = $ad1;//轮播
        if($show_area!=26){//争分夺秒
            $arr['zfdm'] = ads(24);
        }else{
            $arr['zfdm'] = ads(8);
        }

        //新品
        $arr['ad28'] = ads(28);
        $arr['ad29'] = ads(29);
        $arr['ad37'] = ads(37);
        //推荐
        $arr['ad30'] = ads(30);
        $arr['ad31'] = ads(31);
        $arr['ad32'] = ads(32);
        $arr['ad38'] = ads(38);
        //当季
        $arr['ad33'] = ads(33);
        $arr['ad39'] = ads(39);
        //家用
        $arr['ad35'] = ads(35);
        $arr['ad36'] = ads(36);
        $arr['ad41'] = ads(41);
        //中药
        $arr['ad42'] = ads(42);

        /**
         * 新闻
         */
        $arr['art1'] = articles(4);//公司动态
        $arr['art2'] = articles(12);//行业新闻
        $arr['show_area'] = $show_area;
        if($show_area==26){
            $url = '<li data-url="'.route('index',['show_area'=>29]).'">新疆</li>';
        }else{
            $url = '<li data-url="'.route('index',['show_area'=>26]).'">四川</li>';
        }
        $arr['show_area_url'] = $url;
        return view('index')->with($arr);
    }





    /*
     * 清除cache
     */
    public function cacheFlush(Request $request){
        $name = $request->input('name');
        if(!empty($name)){
            Cache::tags(['shop',$name])->flush();
        }else {
            Cache::tags('shop')->flush();
        }
        return redirect()->route('index');
    }


}
