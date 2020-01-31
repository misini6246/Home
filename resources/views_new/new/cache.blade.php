@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}1"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/index/index.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/index/lunbo.css')}}"/>
    <script src="{{path('js/index/remaintime.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('js/zs/lazyload.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('js/index/lb.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('js/index/navigation.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('js/index/index.js')}}" type="text/javascript" charset="utf-8"></script>
    <!--IE兼容-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="{{path('css/index/iehack.css')}}"/>
    <![endif]-->
    <!--IE兼容-->
    <!--[if lte IE 7]>
    <script src="{{path('js/index/IEhack.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    @if(isset($user_dfqr)&&$user_dfqr)
        @include('layouts.dfqr')
    @elseif($ad27)
        <!-- 弹出层开始 -->
        <div class="zzsc" style="display: block;z-index: 999999;">
            <div class="content_tj"><a href="{{$ad27->ad_link}}" target="_blank"><img
                            src="{{$ad27->ad_code}}" class="ad"></a>
                <span class="close"><img src="{{path('/images/close.png')}}" alt=""></span>
            </div>
        </div>
        <div class="content_mark" style="display: block;z-index: 999990"></div>
    @endif
    <div id="banner" class="container">
        <div class="slide_box">
            <div class="banner2">
                <ul class="banner-ctrl">
                    @foreach($ad121 as $k=>$ad)
                        <li @if($k==0) class="current" @endif>
                            <span class="bg"></span>
                            <div class="ctrl-dot">
                                <i @if($k==0) class="on" @endif></i>
                            </div>
                            <div class="title-item">
                                <span class="title-bg"></span>
                                <div class="title-list">
                                    <p><i></i></p>
                                </div>
                            </div>
                            <h4 style="font-weight: normal;">{{str_replace('2017','',$ad->ad_name)}}</h4>
                        </li>
                    @endforeach
                </ul>
                <a class="banner-btn banner-prev" href="javascript:void(0);">
                    <i class="myicon banner_left_icon"></i>
                </a>
                <a class="banner-btn banner-next" href="javascript:void(0);">
                    <i class="myicon banner_right_icon"></i>
                </a>
                <div class="banner-pic">
                    @foreach($ad121 as $k=>$ad)
                        <ul>
                            <li style="background:#{{$ad->ad_bgc}}; @if($k==0) display:list-item; @endif">
                                <a href="{{$ad->ad_link}}"
                                   title="" target="_blank">
                                    <img data-src="{{$ad->ad_code}}"
                                         src="{{$ad->ad_code}}"/>
                                </a>
                            </li>
                        </ul>
                    @endforeach
                </div>

            </div>
        </div>
        <div class="slide_right">
            <ul class="guanggao">
                @foreach($ad123 as $ad)
                    <li>
                        <a target="_blank" href="{{$ad->ad_link}}">
                            <img src="{{$ad->ad_code}}"/>
                        </a>
                    </li>
                @endforeach
            </ul>
            <ul class="slide_right_title">
                <li class="active">动态</li>
                <li>行业</li>
                <a class="tgd" href="/article?id=4">更多</a>
                <a class="tgd" href="/article?id=12" style="display: none;">更多</a>
            </ul>
            <ul class="slide_right_list active">
                @foreach($art1->article as $k=>$v)
                    @if($k<4)
                        <li @if($k==0) class="hot" @endif>
                            <a target="_blank"
                               href="{{route('articleInfo',['id'=>$v->article_id])}}">{{str_limit($v->title,28)}}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <ul class="slide_right_list">
                @foreach($art2->article as $k=>$v)
                    @if($k<4)
                        <li @if($k==0) class="hot" @endif>
                            <a target="_blank"
                               href="{{route('articleInfo',['id'=>$v->article_id])}}">{{str_limit($v->title,28)}}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="huodong-tishi">
                <a target="_blank" href="/cxhd/cxzq"><img src="{{get_img_path('images/qiantai_04.png')}}"></a>
                <div class="huodong-tishi-box">
                    <ul>
                        @foreach($ad155 as $v)
                            <li>
                                <a target="_blank" href="/cxhd/cxzq#{{$v->ad_link}}" class="zy-{{$v->ad_link}}">
                                    <img src="{{$v->ad_code}}"/>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @if(isset($cx_goods[5]))
        <div id="center_banner" class="container">
            <div id="ban2" class="ban">
                <div class="banner">
                    <ul class="img">
                        @if(count($cx_goods[5])>0)
                            <li>
                                @foreach($cx_goods[5] as $k=>$v)
                                    @if($k<3)
                                        <div class="wntj-cp">
                                            <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                                <div class="text">
                                                    <p class="name">{{$v->goods_name}}</p>
                                                    <p class="gg">{{$v->ypgg}}</p>
                                                    <p class="money">{{$v->format_price}}</p>
                                                </div>
                                                <div class="img_box">
                                                    <img src="{{$v->goods_thumb}}"/>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </li>
                        @endif
                        @if(count($cx_goods[5])>3)
                            <li>
                                @foreach($cx_goods[5] as $k=>$v)
                                    @if($k>=3&&$k<6)
                                        <div class="wntj-cp">
                                            <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                                <div class="text">
                                                    <p class="name">{{$v->goods_name}}</p>
                                                    <p class="gg">{{$v->ypgg}}</p>
                                                    <p class="money">{{$v->format_price}}</p>
                                                </div>
                                                <div class="img_box">
                                                    <img src="{{$v->goods_thumb}}"/>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </li>
                        @endif
                    </ul>
                    <div class="btn btn_l">
                        <i class="myicon banner_left_icon"></i>
                    </div>
                    <div class="btn btn_r">
                        <i class="myicon banner_right_icon"></i>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <input type="hidden" id="daojs" value="{{collect($ad124->first())->get('end_time')-time()}}"/>
    <div id="mzjx" class="container">
        <div class="container_box">
            <div class="section_title">
                <i class="myicon mzjx_icon"></i>
                <span class="biaoti">每周精选</span>
                <div class="remaintime">
                    本期剩余时间：<span class="day"></span>天<span class="hourse"></span>时<span class="minute"></span>分<span
                            class="second"></span>秒
                </div>
            </div>
            <ul class="mzjx_content">
                @foreach($ad124 as $k=>$ad)
                    @if($k<6)
                        <li>
                            <a target="_blank" href="{{$ad->ad_link}}">
                                {{--<div class="sale">75折</div>--}}
                                <div class="img_box" style="height: 280px;">
                                    <img src="{{$ad->ad_code}}"/>
                                </div>
                                {{--<p class="name">复方甘草片</p>--}}
                                {{--<p class="gg">50片/瓶</p>--}}
                                {{--<p class="money">--}}
                                {{--￥24.36<span class="yuanjia">￥24.36</span>--}}
                                {{--</p>--}}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    @if(isset($cx_goods[6]))
        <div id="wntj" class="container">
            <div class="container_box">
                <div id="ban3" class="ban">
                    <div class="section_title">
                        <i class="myicon wntj_icon"></i>
                        <span class="biaoti">为您推荐</span>
                    </div>
                    <div class="banner">
                        <ul class="img">
                            @if(count($cx_goods[6])>0)
                                <li>
                                    @foreach($cx_goods[6] as $k=>$v)
                                        @if($k<5)
                                            <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                                <div class="wntj-cp">
                                                    <div class="img_box">
                                                        <img src="{{$v->goods_thumb}}"/>
                                                    </div>
                                                    <p class="name">{{$v->goods_name}}</p>
                                                    <p class="gg">{{$v->ypgg}}</p>
                                                    <p class="money login">{{$v->format_price}}</p>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </li>
                            @endif
                            @if(count($cx_goods[6])>5)
                                <li>
                                    @foreach($cx_goods[6] as $k=>$v)
                                        @if($k>=5&$k<10)
                                            <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                                <div class="wntj-cp">
                                                    <div class="img_box">
                                                        <img src="{{$v->goods_thumb}}"/>
                                                    </div>
                                                    <p class="name">{{$v->goods_name}}</p>
                                                    <p class="gg">{{$v->ypgg}}</p>
                                                    <p class="money login">{{$v->format_price}}</p>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </li>
                            @endif
                        </ul>
                        <div class="btn btn_l">
                            <i class="myicon lb_left_icon"></i>
                        </div>
                        <div class="btn btn_r">
                            <i class="myicon lb_right_icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="xpsj" class="container">
        <div class="container_box">
            <div class="section_left">
                <div class="section_title">
                    <i class="myicon xpsj_icon"></i>
                    <span class="biaoti">新品上架</span>
                </div>
                <div class="section_left_content">
                    <div class="img_box">
                        <div id="ban4" class="ban common_ban">
                            <div class="banner">
                                <ul class="img">
                                    @foreach($ad126 as $k=>$v)
                                        <li>
                                            <a href="{{$v->ad_link}}" target="_blank">
                                                <img style="width: 100%;height: 100%;" class="lazy"
                                                     data-original="{{$v->ad_code}}"/>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <ul class="num"></ul>
                        </div>
                    </div>
                    @if(isset($cx_goods[7]))
                        <ul class="section_left_content_bottom">
                            @foreach($cx_goods[7] as $k=>$v)
                                @if($k<3)
                                    <li>
                                        <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                            <div class="img_box">
                                                <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                            </div>
                                            <p class="name">{{$v->goods_name}}</p>
                                            <p class="money login">{{$v->format_price}}</p>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            @if(isset($zp[8]))
                <div class="section_right">
                    <div class="section_title">
                        <div class="fr">
                            <a target="_blank" href="/cxhd/czhg">
                                查看全部
                                <i class="myicon readmore_icon"></i>
                            </a>
                        </div>
                        <i class="myicon czhg_icon"></i>
                        <span class="biaoti">超值换购</span>
                    </div>
                    <ul class="section_right_content">
                        @foreach($zp[8] as $k=>$v)
                            @if($k<4)
                                <li>
                                    <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                        <p class="name">{{$v->goods_name}}</p>
                                        <p class="gg">{{$v->ypgg}}</p>
                                        <p class="text">
									        <span class="tishi">
										        换购信息
										        <span class="tishi_xx">
											    {{$v->cxxx}}
                                                    <img src="{{get_img_path('images/index/index_sanjiao.png')}}"
                                                         class="index_sanjiao"/>
										        </span>
									        </span>
                                        </p>
                                        <div class="img_box">
                                            <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    @if(count($ad128)>0)
        <div class="container section_guanggao">
            <div class="container_box">
                @foreach($ad128 as $k=>$ad)
                    @if($k<3)
                        <a href="{{$ad->ad_link}}" target="_blank">
                            <img class="lazy" data-original="{{$ad->ad_code}}"/>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    <div id="cptj" class="container">
        <div class="container_box">
            <div class="section_left">
                <div class="section_title">
                    <i class="myicon cptj_icon"></i>
                    <span class="biaoti">产品推荐</span>
                </div>
                <div class="section_left_content">
                    <div class="img_box">
                        <div id="ban5" class="ban common_ban">
                            <div class="banner">
                                <ul class="img">
                                    @foreach($ad129 as $k=>$v)
                                        <li>
                                            <a href="{{$v->ad_link}}" target="_blank">
                                                <img style="width: 100%;height: 100%;" class="lazy"
                                                     data-original="{{$v->ad_code}}"/>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <ul class="num"></ul>
                        </div>
                    </div>
                    @if(isset($cx_goods[9]))
                        <ul class="section_left_content_bottom">
                            @foreach($cx_goods[9] as $k=>$v)
                                @if($k<3)
                                    <li>
                                        <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                            <div class="img_box">
                                                <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                            </div>
                                            <p class="name">{{$v->goods_name}}</p>
                                            <p class="money login">{{$v->format_price}}</p>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            @if(isset($zp[10]))
                <div class="section_right">
                    <div class="section_title">
                        <div class="fr">
                            <a target="_blank" href="/cxhd/jpmz">
                                查看全部
                                <i class="myicon readmore_icon"></i>
                            </a>
                        </div>
                        <i class="myicon jpmz_icon"></i>
                        <span class="biaoti">精品买赠</span>
                    </div>
                    <ul class="section_right_content">
                        @foreach($zp[10] as $k=>$v)
                            @if($k<4)
                                <li>
                                    <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                        <p class="name">{{$v->goods_name}}</p>
                                        <p class="gg">{{$v->ypgg}}</p>
                                        <p class="text">
									        <span class="tishi">
										        买赠信息
										        <span class="tishi_xx">
											    {{$v->cxxx}}
                                                    <img src="{{get_img_path('images/index/index_sanjiao.png')}}"
                                                         class="index_sanjiao"/>
										        </span>
									        </span>
                                        </p>
                                        <div class="img_box">
                                            <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    @if(count($ad131)>0)
        <div class="container section_guanggao">
            <div class="container_box">
                @foreach($ad131 as $k=>$ad)
                    @if($k<3)
                        <a href="{{$ad->ad_link}}" target="_blank">
                            <img class="lazy" data-original="{{$ad->ad_code}}"/>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    <div id="djrx" class="container">
        <div class="container_box">
            <div class="section_title">
                <i class="myicon djrx_icon"></i>
                <span class="biaoti">当季热销</span>
            </div>
            <div class="dj_common">
                <div class="left_img">
                    @foreach($ad133 as $k=>$v)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img style="width: 100%;height: 100%;" class="lazy" data-original="{{$v->ad_code}}"/>
                        </a>
                    @endforeach
                </div>
                @if(isset($cx_goods[11]))
                    <ul class="right_content">
                        @foreach($cx_goods[11] as $v)
                            @if($k<4)
                                <li>
                                    <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                        <div class="img_box">
                                            <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                        </div>
                                        <div class="text">
                                            <p class="name">{{$v->goods_name}}</p>
                                            <p class="gg">{{$v->ypgg}}</p>
                                            <p class="money">{{$v->format_price}}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <div id="jybj" class="container">
        <div class="container_box">
            <div class="section_title">
                <i class="myicon jtbj_icon"></i>
                <span class="biaoti">家庭保健</span>
            </div>
            <div class="dj_common">
                <div class="left_img">
                    @foreach($ad137 as $k=>$v)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img style="width: 100%;height: 100%;" class="lazy" data-original="{{$v->ad_code}}"/>
                        </a>
                    @endforeach
                </div>
                @if(isset($cx_goods[12]))
                    <ul class="right_content">
                        @foreach($cx_goods[12] as $v)
                            @if($k<4)
                                <li>
                                    <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                        <div class="img_box">
                                            <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                        </div>
                                        <div class="text">
                                            <p class="name">{{$v->goods_name}}</p>
                                            <p class="gg">{{$v->ypgg}}</p>
                                            <p class="money">{{$v->format_price}}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <div id="zyyp" class="container">
        <div class="container_box">
            <div class="section_title">
                <i class="myicon zyyp_icon"></i>
                <span class="biaoti">中药饮片</span>
            </div>
            <div class="dj_common">
                <div class="left_img">
                    @foreach($ad140 as $k=>$v)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img style="width: 100%;height: 100%;" class="lazy" data-original="{{$v->ad_code}}"/>
                        </a>
                    @endforeach
                </div>
                @if(isset($cx_goods[13]))
                    <ul class="right_content">
                        @foreach($cx_goods[13] as $v)
                            @if($k<4)
                                <li>
                                    <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                        <div class="img_box">
                                            <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                        </div>
                                        <div class="text">
                                            <p class="name">{{$v->goods_name}}</p>
                                            <p class="gg">{{$v->ypgg}}</p>
                                            <p class="money">{{$v->format_price}}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <div id="cjtj" class="container">
        <div class="container_box">
            <div class="cjtj_title">
                <p class="biaoti">厂家推荐</p>
                <p class="text">
                    品牌厂家，优质推荐
                    <span class="left"></span>
                    <span class="right"></span>
                </p>
            </div>
            <ul class="cj_content">
                <li>
                    <div class="cj_content_title">
                        <img src="{{get_img_path('images/index/company_1_03.jpg')}}"/>
                        <a target="_blank" href="{{route('category.index',['keywords'=>'山西振东开元制药有限公司','showi'=>0])}}">查看全部</a>
                    </div>
                    @if(isset($cx_goods[14]))
                        <ul class="cj_content_list">
                            @foreach($cx_goods[14] as $k=>$v)
                                @if($k<4)
                                    <li>
                                        <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                            <div class="img_box">
                                                <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                            </div>
                                            <p class="name">{{$v->goods_name}}</p>
                                            <p class="money">{{$v->format_price}}</p>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
                <li>
                    <div class="cj_content_title">
                        <img src="{{get_img_path('images/index/company_2_03.jpg')}}"/>
                        <a target="_blank" href="{{route('category.index',['keywords'=>'同仁堂','showi'=>0])}}">查看全部</a>
                    </div>
                    @if(isset($cx_goods[15]))
                        <ul class="cj_content_list">
                            @foreach($cx_goods[15] as $k=>$v)
                                @if($k<4)
                                    <li>
                                        <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                            <div class="img_box">
                                                <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                            </div>
                                            <p class="name">{{$v->goods_name}}</p>
                                            <p class="money">{{$v->format_price}}</p>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
                <li>
                    <div class="cj_content_title">
                        <img src="{{get_img_path('images/index/company_3_03.jpg')}}"/>
                        <a target="_blank" href="{{route('category.index',['keywords'=>'和治','showi'=>0])}}">查看全部</a>
                    </div>
                    @if(isset($cx_goods[16]))
                        <ul class="cj_content_list">
                            @foreach($cx_goods[16] as $k=>$v)
                                @if($k<4)
                                    <li>
                                        <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                            <div class="img_box">
                                                <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                            </div>
                                            <p class="name">{{$v->goods_name}}</p>
                                            <p class="money">{{$v->format_price}}</p>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    {{--<div id="tishi" class="container">--}}
    {{--<div class="container_box">--}}
    {{--<img src="{{get_img_path('images/index/daodi.jpg')}}"/>--}}
    {{--</div>--}}
    {{--</div>--}}

    @include('layouts.old_footer')
    @include('layouts.fixed_search')
    <!--电梯导航-->
    <div id="fixedNavBar" class="container">
        <div class="container_box">
            <div class="fixedNavBar_title">
                导航
            </div>
            <ul>
                <li>
                    <a href="#mzjx">每周精选</a>
                </li>
                <li>
                    <a href="#wntj">为您推荐</a>
                </li>
                <li>
                    <a href="#xpsj">新品上架</a>
                </li>
                <li>
                    <a href="#cptj">产品推荐</a>
                </li>
                <li>
                    <a href="#djrx">当季热销</a>
                </li>
                <li>
                    <a href="#jybj">家用保健</a>
                </li>
                <li>
                    <a href="#zyyp">中药饮片</a>
                </li>
                <li>
                    <a href="#cjtj">厂家推荐</a>
                </li>
            </ul>
        </div>
    </div>
    <!--电梯导航-->
    <script src="{{path('js/index/lunbo.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection