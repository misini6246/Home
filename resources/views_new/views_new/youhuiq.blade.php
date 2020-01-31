@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/my_order2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/my_order.js')}}"></script>
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')

    <div class="main fn_clear">

        <div class="main fn_clear">
            <div class="top">
                <span class="title">我的太星医药网</span> <a>>　<span>优惠券管理</span> </a> <a href="{{route('user.orderList')}}" class="end">>　<span>{{$pages_top}}</span></a> </div>
            @include('layout.user_menu')
            <div style="width:930px;margin:0px auto 0 auto;overflow:hidden">
                <div class="top_title">
                    <h3>优惠券管理</h3>
                    <span class="ico"></span>
                </div>
                @if(isset($pages[1]))
                <div class="flq-box fn_clear" style="*margin-bottom:50px;">
                    <div class="title" style="height:38px;width:100%;border-bottom:1px solid #69054d;position:relative;margin-bottom:30px;">
                        <span><img src="{{get_img_path('images/ganenquan03.jpg')}}" alt=""  /></span>
                    </div>
                    <ul style="width:1000px;margin-left:40px;">
                        @foreach($pages[1] as $v)
                            <a href="{{route('category.index',['dis'=>1,'py'=>1])}}">
                                <li style="width:240px;height:260px;position:relative;float:left;margin:0 68px 50px 0;cursor: pointer;">
                                    <img src="{{get_img_path('images/ganenquan04.jpg')}}" alt="" />
                                    <p style="color:#fff;position:absolute;left:0px;top:24px;font-weight:bold;font-size:60px;width:100%;text-align:center;">
                                        <span style="color:#fff;font-size:20px;font-weight:bold;">￥</span>{{intval($v->je)}}
                                    </p>

                                    <p style="color:#fffee3;position:absolute;left:0px;top:91px;width:100%;text-align:center;"> <span style="color:#fff;font-size:14px">【满{{intval($v->min_je)}}可用】</span></p>
                                    <p style="color:#fffee3;position:absolute;left:0px;top:113px;font-size:14px;color:#91064b;width:100%;text-align:center;">@if($v->end-$v->start>3600*24)限{{date('Y.m.d',$v->start)}}-{{date('Y.m.d',$v->end - 1)}}@else 仅限{{date('Y.m.d',$v->start)}}@endif使用</p>

                                    <p style="color:#a2a1a1;position:absolute;left:20px;top:150px;padding-right:15px;">
                                        <span style="color:#575656;font-size: 14px;">条件：</span><span style="font-size: 14px;color: #777">{{$v->tip or ''}}</span>
                                    </p>

                                </li>
                            </a>
                        @endforeach

                    </ul>

                </div>
                @endif
                @if(isset($pages[2]))
                <div class="jfq-box fn_clear" style="*margin-bottom:50px;" >
                    <div class="title" style="height:38px;width:100%;border-bottom:1px solid #703b03;position:relative;margin-bottom:30px;">
                        <span><img src="{{get_img_path('images/zhongyaoquan03.jpg')}}" alt=""  /></span>
                    </div>
                    <ul style="width:1000px;margin-left:40px;" class="fn_clear">
                        @foreach($pages[2] as $v)
                            <a href="{{route('category.index',['dis'=>1,'py'=>1])}}">
                                <li style="width:240px;height:260px;position:relative;float:left;margin:0 68px 50px 0;">
                                    <img src="{{get_img_path('images/zhongyaoquan04.jpg')}}" alt="" />
                                    <p style="color:#fff;position:absolute;left:0px;top:24px;font-weight:bold;font-size:60px;width:100%;text-align:center;">
                                        <span style="color:#fff;font-size:20px;font-weight:bold;">￥</span>{{intval($v->je)}}
                                    </p>

                                    <p style="color:#fffee3;position:absolute;left:0px;top:91px;width:100%;text-align:center;"> <span style="color:#fff;font-size:14px">【满{{intval($v->min_je)}}可用】</span></p>
                                    <p style="color:#fffee3;position:absolute;left:0px;top:113px;font-size:14px;color:#894a07;width:100%;text-align:center;">@if($v->end-$v->start>3600*24)限{{date('Y.m.d',$v->start)}}-{{date('Y.m.d',$v->end - 1)}}@else 仅限{{date('Y.m.d',$v->start)}}@endif使用</p>

                                    <p style="color:#a2a1a1;position:absolute;left:20px;top:150px;padding-right:15px;">
                                        <span style="color:#575656">条件：</span><span style="font-size: 14px;color: #777">{{$v->tip or ''}}</span>
                                    </p>
                                </li>
                            </a>
                        @endforeach
                    </ul>

                </div>
                @endif
                @if(isset($pages[4]))
                    <div class="flq-box fn_clear" style="*margin-bottom:50px;">
                        <div class="title" style="height:38px;width:100%;border-bottom:1px solid #69054d;position:relative;margin-bottom:30px;">
                            <span><img src="{{get_img_path('images/znq3.jpg')}}" alt=""  /></span>
                        </div>
                        <ul style="width:1000px;margin-left:40px;">
                            @foreach($pages[4] as $v)
                                <a href="{{route('category.index',['dis'=>1,'py'=>1])}}">
                                    <li style="width:240px;height:260px;position:relative;float:left;margin:0 68px 50px 0;cursor: pointer;">
                                        <img src="{{get_img_path('images/znq4.jpg')}}" alt="" />
                                        <p style="color:#fff;position:absolute;left:0px;top:24px;font-weight:bold;font-size:60px;width:100%;text-align:center;">
                                            <span style="color:#fff;font-size:20px;font-weight:bold;">￥</span>{{intval($v->je)}}
                                        </p>

                                        <p style="color:#fffee3;position:absolute;left:0px;top:91px;width:100%;text-align:center;"> <span style="color:#fff;font-size:14px">【满{{intval($v->min_je)}}可用】</span></p>
                                        <p style="color:#fffee3;position:absolute;left:0px;top:113px;font-size:14px;color:#91064b;width:100%;text-align:center;">限2017年03.08、03.15、03.29使用</p>

                                        <p style="color:#a2a1a1;position:absolute;left:20px;top:150px;padding-right:15px;">
                                            <span style="color:#575656;font-size: 14px;">条件：</span><span style="font-size: 14px;color: #777">{{$v->tip or ''}}</span>
                                        </p>

                                    </li>
                                </a>
                            @endforeach

                        </ul>

                    </div>
                @endif
                @if(isset($pages[0]))
                <div class="xyq-box fn_clear"  style="*margin-bottom:50px;">
                    <div class="title" style="height:38px;width:100%;border-bottom:1px solid #7d0693;position:relative;margin-bottom:30px;">
                        <span><img src="{{get_img_path('images/pc-dkq-03.jpg')}}" alt=""  /></span>
                    </div>
                    <ul style="width:1000px;margin-left:40px;">
                        @foreach($pages[0] as $v)
                            <a href="{{route('category.index',['dis'=>1,'py'=>1])}}">
                                <li style="width:240px;height:260px;position:relative;float:left;margin:0 68px 50px 0;">
                                    <img src="{{get_img_path('images/pc-dkq-06.jpg')}}" alt="" />
                                    <p style="color:#fff;position:absolute;left:0px;top:24px;font-weight:bold;font-size:60px;width:100%;text-align:center;">
                                        <span style="color:#fff;font-size:20px;font-weight:bold;">￥</span>{{intval($v->je)}}
                                    </p>

                                    <p style="color:#fffee3;position:absolute;left:0px;top:91px;width:100%;text-align:center;"> <span style="color:#fff;font-size:14px">【满{{intval($v->min_je)}}可用】</span></p>
                                    <p style="color:#fffee3;position:absolute;left:0px;top:113px;font-size:14px;color:#471277;width:100%;text-align:center;">@if($v->end-$v->start>3600*24)限{{date('Y.m.d',$v->start)}}-{{date('Y.m.d',$v->end - 1)}}@else 仅限{{date('Y.m.d',$v->start)}}@endif使用</p>

                                    <p style="color:#a2a1a1;position:absolute;left:20px;top:150px;padding-right:15px;">
                                        <span style="color:#575656">条件：</span><span style="font-size: 14px;color: #777">{{$v->tip or ''}}</span>
                                    </p>
                                </li>
                            </a>
                        @endforeach
                    </ul>

                </div>
                @endif


            </div>


        </div>

        </div>

    </div>
    @include('layout.page_footer')
@endsection
