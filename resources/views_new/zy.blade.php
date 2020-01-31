@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/goods_list.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/zhongyyp.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/zhongyyp-detail.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/wntj-zy.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/slideshow.js')}}"></script>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="site-content-box ">
        <div class="zhongyyp-box fn_clear">
            @include('layout.zy_zs')
            <div class="zhongyyp-right ">
                <div class="zhy-r-top fn_clear">
                    <div class="lunbo-box">
                        <div class="comiis_wrapad" style="width: 820px" id="slideContainer">
                            <div id="frameHlicAe" class="frame cl">
                                <div class="temp"></div>
                                <div class="block">
                                    <div class="cl">
                                        <ul class="slides_container container" id="slidesImgs">
                                            @if(count($ad59)>0)
                                            @foreach($ad59 as $v)
                                            <li style="width: 820px;"><a href="{{$v->ad_link}}" target="_blank"><img style="width:820px;height:360px;" src="{{$v->ad_code}}" class="imgVis" /></a></li>
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="slidebar" id="slideBar" style="position: absolute;right: 20px;top: 335px;">
                                        <ul class="pagination">
                                            @if(count($ad59)>0)
                                            @foreach($ad59 as $k=>$v)
                                            @if($k==0)
                                            <li class="on"> {{$k+1}}</li>
                                            @else
                                            <li> {{$k+1}}</li>
                                            @endif
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="ad-right">
                        {!! ad_template(60) !!}
                    </div>

                </div>

                <div class="zhongyyp-ad01">
                    <ul>
                        {!! ad_template(61,2) !!}
                    </ul>
                </div>


                <div class="putongyp fn_clear">
                    <div class="title">
                        <img src="./images/zyyp/zhyp048.jpg" alt=""/>
                        <a href="{{route('category.zyyp',['pid'=>448])}}">查看更多>></a>
                    </div>
                    <div class="putongyp-left">
                        <ul class="leibie-list">
                            <li><a href="zy_category?keywords=甘草">甘草  </a></li>
                            <li><a href="zy_category?keywords=丹参">丹参  </a></li>
                            <li><a href="zy_category?keywords=白芷">白芷   </a></li>
                            <li><a href="zy_category?keywords=连翘">连翘  </a></li>
                            <li><a href="zy_category?keywords=川芎">川芎  </a></li>
                            <li><a href="zy_category?keywords=白术">白术  </a></li>
                        </ul>
                        {!! ad_template(62) !!}
                    </div>

                    <div class="putongyp-mid">
                        <div class="mid01">
                            {!! ad_template(63) !!}
                        </div>
                        <div class="mid02">
                            {!! ad_template(64) !!}
                        </div>

                    </div>
                    <div class="putongyp-mid">
                        <div class="mid01">
                            {!! ad_template(65) !!}
                        </div>
                        <div class="mid02">
                            {!! ad_template(66) !!}
                        </div>
                    </div>


                </div>


                <div class="zhongyyp-ad01">
                    <ul>
                        {!! ad_template(67,2) !!}
                    </ul>
                </div>



                <div class="guixibpyp fn_clear">
                    <div class="title">
                        <img src="./images/zyyp/zhyp049.jpg" alt=""/>
                        <a href="{{route('category.zyyp',['pid'=>449])}}">查看更多>></a>
                    </div>
                    <div class="guixibpyp-box">
                        <div class="guixibpyp-left">
                            <ul class="leibie-list">
                                <li><a href="zy_category?keywords=灵芝">灵芝  </a></li>
                                <li><a href="zy_category?keywords=三七">三七  </a></li>
                                <li><a href="zy_category?keywords=冬虫夏草">冬虫夏草   </a></li>
                                <li><a href="zy_category?keywords=鹿茸">鹿茸  </a></li>
                                <li><a href="zy_category?keywords=燕窝">燕窝  </a></li>
                                <li><a href="zy_category?keywords=当归">当归  </a></li>
                            </ul>

                            {!! ad_template(68) !!}
                        </div>

                        <div class="guixibpyp-mid">
                            {!! ad_template(69) !!}
                        </div>
                        <div class="guixibpyp-right">
                            @if(count($ad70)>0)
                                @foreach($ad70 as $k=>$v)
                                <div class="right0{{$k+1}}">

                                    <a href="{{$v->ad_link}}" target='_blank'><img src="{{$v->ad_code}}" alt=""/></a>

                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>


                <div class="zhongyyp-ad01">
                    <ul>
                        {!! ad_template(71,2) !!}
                    </ul>
                </div>



                <div class="dingxingbzyp fn_clear">
                    <div class="title">
                        <img src="./images/zyyp/zhyp050.jpg" alt=""/>
                        <a href="{{route('category.zyyp',['pid'=>474])}}">查看更多>></a>
                    </div>
                    <div class="dingxingbzyp-left">
                        <ul class="leibie-list">
                            <li><a href="zy_category?keywords=蜂蜜">蜂蜜  </a></li>
                            <li><a href="zy_category?keywords=菊花">菊花  </a></li>
                            <li><a href="zy_category?keywords=灵芝孢子粉">灵芝孢子粉   </a></li>
                            <li><a href="zy_category?keywords=龙眼肉">龙眼肉  </a></li>
                            <li><a href="zy_category?keywords=莲子">莲子  </a></li>
                            <li><a href="zy_category?keywords=荷叶">荷叶  </a></li>
                        </ul>

                        {!! ad_template(72) !!}
                    </div>

                    <ul class="dingxingbzyp-list">
                        {!! ad_template(73,2) !!}

                    </ul>


                </div>



                <div class="zhongyyp-ad01">
                    <ul>
                        {!! ad_template(74,2) !!}
                    </ul>
                </div>

                <div class="jingzhilhyp fn_clear">
                    <div class="title">
                        <img src="./images/zyyp/zhyp051.jpg" alt=""/>
                        <a href="{{route('category.zyyp',['pid'=>486])}}">查看更多>></a>
                    </div>
                    <div class="jingzhilhyp-left">
                        <ul class="leibie-list">
                            <li><a href="zy_category?keywords=灵芝">灵芝  </a></li>
                            <li><a href="zy_category?keywords=石斛">石斛  </a></li>
                            <li><a href="zy_category?keywords=冬虫夏草">冬虫夏草   </a></li>
                            <li><a href="zy_category?keywords=鹿茸">鹿茸  </a></li>
                            <li><a href="zy_category?keywords=燕窝">燕窝  </a></li>
                            <li><a href="zy_category?keywords=当归">当归  </a></li>
                        </ul>
                        {!! ad_template(75) !!}
                    </div>

                    <ul class="jingzhilhyp-list">
                        {!! ad_template(76,2) !!}
                    </ul>


                </div>




                <div class="zhongyyp-ad01">
                    <ul>
                        {!! ad_template(77,2) !!}
                    </ul>
                </div>

                <div class="zhongyfjxl fn_clear">
                    <div class="title">
                        <img src="./images/zyyp/zhyp052.jpg" alt=""/>
                        <a href="{{route('category.zyyp',['pid'=>484])}}">查看更多>></a>
                    </div>
                    <div class="zhongyfjxl-left">
                        <!--
                        <ul class="leibie-list">
                            <li><a href="zy_category?keywords=三七粉">三七粉  </a></li>
                            <li><a href="zy_category?keywords=珍珠粉">珍珠粉  </a></li>
                            <li><a href="zy_category?keywords=薏苡仁粉"> 薏苡仁粉  </a></li>
                            <li><a href="zy_category?keywords=丹参粉">丹参粉  </a></li>
                            <li><a href="zy_category?keywords=山药粉">山药粉  </a></li>
                            <li><a href="zy_category?keywords=陈皮粉">陈皮粉  </a></li>
                        </ul>
                        -->
                        {!! ad_template(78) !!}
                    </div>

                    <ul class="zhongyfjxl-list01">
                        <li class="li01">
                            {!! ad_template(79) !!}
                        </li>
                        <li class="li02" >
                            {!! ad_template(80) !!}
                        </li>

                    </ul>

                    <ul class="zhongyfjxl-list02">
                        <li class="li01">
                            {!! ad_template(81) !!}
                        </li>
                        <li class="li02" >
                            {!! ad_template(82) !!}
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>
    @include('common.footer')
    <script>
        SlideShow(5000);
    </script>
@endsection

