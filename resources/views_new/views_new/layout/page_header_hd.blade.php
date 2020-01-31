@include('layout.topad')
<div class="header" style="position: relative;z-index:9997;">
    <div class="top_box">
        <div class="top">
            <div class="top_left">
                @if($user)
                    <div class="login_after">
                        <span class="username" alt="{{$user->msn}}" title="{{$user->msn}}">{{str_limit($user->msn,10)}}</span>
                        <span>,欢迎来到合纵医药网！</span>
                        [<a href="/auth/logout" class="out">退出</a>]
                        <span class="separate2">|</span>
                        <a href="{{route('user.index')}}" class="my_name">我的药易购</a>
                    </div>
                @else
                    <div class="login_before">
                        <span>您好，欢迎来到合纵医药网！</span><span class="separate">|</span>
                        <a href="/auth/login" class="login">登录</a> <span class="separate2"></span><a href="/auth/register" class="reg">注册</a>
                    </div>
                @endif
                @if(isset($show_area_url))
                    <div class="select_box">
                        <div class="select">
                            <div class="select_choose"><span>@if($show_area==26)四川@else新疆@endif</span><i></i></div>
                            @if(!auth()->check())
                                <ul class="select_options">
                                    {!! $show_area_url !!}
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            <div class="top_right">
                <a target="_blank" href="{{route('dzfp')}}"><span style="font-weight:bold;color:#329900;">电子发票查询</span></a>|
                <a target="_blank" href="{{route('zhijian')}}">质检报告查询</a>|<a target="_blank" href="{{route('requirement.index')}}">求购专区</a>
                |<a href="javascript:;" class="phone-app" >
                    <span class="appico" style="position: absolute;width: 12px;height: 18px;left: 8px;top:5px;*top:2px">
                        <img src="{{get_img_path('images/app-ico.png')}}" alt="">
                    </span>手机药易购
                    <span class="ico" style="position: absolute;left: 95px;top: 11px;"></span>
                    <span class="app-ewm" >
                        <img style="padding-left: 3px;" src="{{get_img_path('images/erweima1.jpg')}}" alt=""></span></a>|
                <a href="{{route('cart.index')}}" class="cart_a"><span class="cart_ico"></span> 购物车(<span class="num">{{$cart_num}}</span>)</a>|<a target="_blank" href="{{route('user.collectList')}}" class="common collect_a"><span class="collect_ico"></span> 我的收藏 </a>
                <a href="javascript:;" class="attention" id="attention">关注
                    <span class="pic"><img src="{{get_img_path('images/code_pic.png')}}" alt=""></span><span class="ico"></span>
                </a>
                <a target="_blank" href="{{route('article.index',['id'=>3])}}">帮助中心 </a>
                <a target="_blank" id="toushu" class="attention">投诉<span class="pic" style="text-align: center;height: auto;background-color: #fff;left: -58px;color: #2c8313;font-size: 14px;">15208485587</span><span class="ico"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="mid" style="margin-top:12px;">
        @if(time()<strtotime('20161214'))
            @include('shuang11.log11')
        @else
            <div class="logo"><a href="/"><img src="{{get_img_path('images/logo.png')}}" alt="logo"></a></div>
            @if(time()>strtotime('2016-10-12 00:00:00'))
                <div><img src="{{get_img_path('images/gif-word.gif')}}" alt="" style="float:left;margin:25px 30px 0 0;"></div>
            @else
                <div><a target="_blank" href="@if(time()>strtotime('2016-10-10 00:00:00')) {{route('category.index',['step'=>'promotion'])}} @else {{route('category.index',['step'=>'nextpro'])}} @endif"> <img src="{{get_img_path('images/1010.gif')}}" alt="" style="float:left;margin:25px 30px 0 0;"/></a></div>
            @endif
        @endif
        <div class="search">
            <div class="search_box fn_clear">
                <input id="suggest" name="userSearch" type="text" value="@if(!isset($keywords)||empty($keywords))药品名称(拼音缩写)或厂家名称@else{{$keywords}}@endif"  class="search_input suggest"/>
                <a href="javascript:void(0)" class="btn search_btn">搜 索</a>

                <div id="suggestions_wrap" class="search_show list_box suggestions_wrap" style="display: none;">
                    <ul class="search_list suggestions" id="suggestions">

                    </ul>
                </div>
            </div>
            <div class="search-hot">
                <span>热门搜索：</span>
                @if($search_keywords)
                    {{--@if(time()>strtotime('20161009')&&time()<strtotime('20161012'))--}}
                    {{--<a target="_blank" href="@if(time()>strtotime('20161026')) {{route('category.index',['step'=>'promotion'])}} @else {{route('category.index',['step'=>'nextpro'])}} @endif" style="color: red;">周年庆特价</a>--}}
                    {{--<a target="_blank" href="http://www.hezongyy.com/cj" style="color: red;">10周年庆红包派送</a>--}}
                    @if(time()<strtotime('20170113'))
                        <a target="_blank" href="@if(time()>strtotime('20170111')) {{route('category.index',['step'=>'promotion'])}} @else {{route('category.index',['step'=>'nextpro'])}} @endif" style="color: red;">开年大促</a>
                        <a target="_blank" href="http://www.hezongyy.com/cj" style="color: red;">积分抽大奖</a>
                        <a target="_blank" href="http://www.hezongyy.com/chunjie.html" style="color: red;">迎春节送惊喜</a>

                        <a target="_blank" href="http://www.hezongyy.com/cxzq" style="color: red;">促销专区</a>
                        <a target="_blank" href="http://www.hezongyy.com/category?dis=7" style="color: red;">效期品种</a>
                    @else
                        {{--<a target="_blank" href="http://www.hezongyy.com/hd/shuang12" style="color: red;">领取双12感恩券</a>--}}
                        {{--<a target="_blank" href="@if(time()>strtotime('20161212')) {{route('category.index',['step'=>'promotion'])}} @else {{route('category.index',['step'=>'nextpro'])}} @endif" style="color: red;">双12特价</a>--}}
                        {{--<a target="_blank" href="@if(time()>strtotime('20161212')) http://www.hezongyy.com/miaosha.html @else http://www.hezongyy.com @endif" style="color: red;">大牌秒杀</a>--}}
                        {{--<a target="_blank" href="http://www.hezongyy.com/category?step=trt&showi=0" style="color: red;">药易购独家销售</a>--}}
                        {{--<a target="_blank" href="http://www.hezongyy.com/category?step=tj&showi=0" style="color: red;">太极厂家活动</a>--}}
                        <a target="_blank" href="http://www.hezongyy.com/chunjie.html" style="color: red;">迎春节送惊喜</a>

                        <a target="_blank" href="http://www.hezongyy.com/cxzq" style="color: red;">促销专区</a>
                        <a target="_blank" href="http://www.hezongyy.com/category?dis=7" style="color: red;">效期品种</a>
                    @endif
                    {{--@else--}}
                    {{--@foreach($search_keywords as $k=>$val)--}}
                    {{--@if($k<7&&!empty($val))--}}
                    {{--<a href="{{route('category.index',['keywords'=>$val,'showi'=>0])}}">{{$val}}</a>--}}
                    {{--@endif--}}
                    {{--@endforeach--}}
                    {{--@endif--}}
                @endif
            </div>
        </div>
        <div class="tel">
            <img src="{{get_img_path('images/tel_pic.png')}}" alt="联系电话">
            <p><a href="http://www.hezongyy.com/images/zgz1.jpg" target="_blank" class="text">互联网药品交易服务资格证</a></p>
            <p><a href="http://www.hezongyy.com/images/zgz2.jpg" target="_blank" class="text">互联网药品信息服务资格证</a></p>
        </div>
    </div>
</div>