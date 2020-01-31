@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link href="{{path('css/new/puyao.css')}}1" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/new/pages.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('js/new/puyao.js')}}"></script>
    <script type="text/javascript" src="{{path('js/new/change_num.js')}}"></script>
    <script type="text/javascript" src="{{path('js/new/AAS.js')}}"></script>
    <script type="text/javascript" src="{{path('js/zs/lazyload.js')}}"></script>
    <script type="text/javascript" src="{{path('js/index/lb.js')}}"></script>
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
    {{--@include('tejia.gg1',['page'=>$result->currentPage()])--}}
    @if(isset($ad160))
        @if(!empty($ad160->ad_link))
            <a target="_blank" href="{{$ad160->ad_link}}">
                <div class="pingpaizq"
                     style="background: url('{{$ad160->ad_code or ''}}') no-repeat scroll center top;height: 420px;min-width: 1200px;overflow: hidden;width: 100%;background-color:#{{$ad160->ad_bgc or 'ffffff'}}; ">

                </div>
            </a>
        @else
            <div class="pingpaizq"
                 style="background: url('{{$ad160->ad_code or ''}}') no-repeat scroll center top;height: 420px;min-width: 1200px;overflow: hidden;width: 100%;background-color:#{{$ad160->ad_bgc or 'ffffff'}}; ">

            </div>
        @endif
    @else
        <div class="pingpaizq"
             style="background: url('{{$ad_img_url}}') no-repeat scroll center top;height: 420px;min-width: 1200px;overflow: hidden;width: 100%;background-color:#{{$bg_color or 'ec1556'}}; ">

        </div>
    @endif
    <div>
        <div class="goods-box">
            <div class="content">
                @if(count($result)==0)
                    <div id="none" class="container">
                        <div class="container_box">
                            <div class="none">
                                <div class="img_box">
                                    <img src="{{get_img_path('images/goods/puyao_search_none.png')}}"/>
                                </div>
                                <div class="text">
                                    <p>抱歉！没有找到@if(!empty($keywords))与“<span>{{$keywords}}</span>”@endif相关的药品</p>
                                    <p>你可以发布求购意向，{{config('services.web.name')}}网会尽快补货！</p>
                                    <a target="_blank" href="/requirement" class="link">发布求购</a>
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
                                                                    <a target="_blank"
                                                                       href="{{route('goods.index',['id'=>$v->goods_id])}}">
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
                                                                    <a target="_blank"
                                                                       href="{{route('goods.index',['id'=>$v->goods_id])}}">
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
                        </div>
                    </div>
                @else
                    <div id="datu" class="container">
                        <div class="container_box">
                            <ul class="datu">
                                @foreach($result as $v)
                                    <li>
                                        <div class="datu-chanpin-img">
                                            @if($v->is_cx==1&&$step=='yzj')
                                                @include('goods.zkbz')
                                            @endif
                                            <a target="_blank" href="{{$v->goods_url}}">
                                                <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                            </a>
                                            <img title="加入收藏夹" onclick="tocollect('{{$v->goods_id}}')"
                                                 src="{{get_img_path('images/goods/datu-shoucang.png')}}"
                                                 class="datu-shoucang"/>
                                            <div class="datu_bs">
                                                <div class="tj layer_tips" id="1dt_tj{{$v->goods_id}}"
                                                     data-msg="{{trans('goods.tmpz')}}">
                                                    特卖<i class="jiantou xia_i"></i>
                                                </div>
                                                @if($v->is_xqpz==1)
                                                    <div class="tj layer_tips" id="1dt_xq{{$v->goods_id}}"
                                                         data-msg="此品种为效期品种">
                                                        效期<i class="jiantou xia_i"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        @if($v->is_can_see==0)
                                            <div class="datu-jiage-none">
                                                会员可见
                                            </div>
                                        @else
                                            <div class="datu-jiage">
                                                {{formated_price($v->real_price)}}
                                            </div>
                                        @endif
                                        <div class="datu-mingzi">
                                            {{$v->goods_name}}
                                        </div>
                                        <div class="datu-compamy">
                                            {{$v->sccj}}
                                        </div>
                                        <div class="datu-guige">
                                            规格：<span>{{$v->spgg}}</span>
                                        </div>
                                        <div class="datu-xiaoqi">
                                            效期：<span
                                                    @if($v->is_xq_red==1) class="daoqi" @endif>{{$v->xq}}</span>
                                            @if($v->is_zyyp==0)
                                                件装量：
                                                <span class="jianzhuang">{{$v->jzl}}</span>
                                            @endif
                                        </div>
                                        <div class="datu-jianzhuang">
                                            库存：<span>@if($v->goods_number>=800)充裕@elseif($v->goods_number==0)
                                                    缺货@else{{$v->goods_number}}@endif</span> 中包装：
                                            <span>{{$v->zbz}}</span>
                                        </div>
                                        <div class="btn_box">
                                            <div class="datu-jrgwc fly_to_cart{{$v->goods_id}}"
                                                 style="background-color: #ef2c2f"
                                                 data-img="{{$v->goods_thumb}}"
                                                 onclick="tocart('{{$v->goods_id}}',1)">
                                                <img src="{{get_img_path('xiangqing')}}"/> 加入购物车
                                            </div>
                                            <div class="jiajian">
                                                <div class="jian min">
                                                    -
                                                </div>
                                                <input id="J_dgoods_num1_{{$v->goods_id}}" type="text"
                                                       value="{{$v->zbz}}" class="input_val"
                                                       data-zbz="{{$v->zbz}}"
                                                       data-kc="{{$v->goods_number}}"
                                                       data-jzl="{{$v->jzl}}" data-xl="{{$v->xg_num}}"
                                                       data-isxl="{{$v->is_xg}}"/>
                                                <div class="jia">
                                                    +
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            @if($result->hasPages())
                                {!! $pages_view !!}
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if(isset($daohang)&&$daohang==1)
        @include('miaosha.daohang')
    @endif
    @include('layouts.old_footer')
    <script type="text/javascript">
        $('.cpmc').hover(function () {
            $(this).find('.lazy_show').attr('src', $(this).find('.lazy_show').data('original'))
        });
        $("img.lazy").lazyload({
            effect: "fadeIn",
            threshold: 300,
            placeholder: "http://app.hezongyy.com/images/small.gif"
        });
        $('.layer_tips').hover(function () {
            var msg = $(this).data('msg');
            var id = $(this).attr('id');
            layer.tips(msg, '#' + id, {
                tips: [3, '#fff'],
                time: 0,
                id: 'layer_tips'
            });
        }, function () {
            layer.closeAll();
        });

        function last_page(url, lastPage) {
            var currentPage = $('#currentPage').val();
            if (parseInt(currentPage) > parseInt(lastPage)) {
                alert('你要访问的页码不存在!');
                $('#currentPage').val(lastPage);
                return false;
            }
        }
    </script>
@endsection
