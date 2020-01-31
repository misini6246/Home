@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/wodeqiugou.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/huiyuancommon.js')}}"></script>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')

    <div class="container" id="user_center">
        <form id="search_form" name="search_form" action="{{route('member.collection.index')}}">
        </form>
        <div class="container_box">
            <div class="top_title">
                <img src="{{get_img_path('images/user/weizhi.png')}}"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="{{get_img_path('images/user/right_1_03.png')}}"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的药易购</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>我的求购</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <a target="_blank" href="/requirement#contactForm">
                        <div class="add_liuyan">添加求购</div>
                    </a>
                    <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                    <span>我的求购</span>
                </div>
                @if(count($result)>0)
                    <table>
                        <tr>
                            <th class="spmc">商品名称</th>
                            <th class="gg">规格</th>
                            <th class="sl">数量</th>
                            <th class="qgjg">求购价格</th>
                            <th class="xq">求购有效期</th>
                            <th>回复</th>
                        </tr>
                        @foreach($result as $v)
                            <tr>
                                <td>
                                    <div class="spmc">
                                        {{$v->buy_goods}}
                                    </div>
                                </td>
                                <td>
                                    <div class="gg">
                                        {{$v->buy_spec}}
                                    </div>
                                </td>
                                <td>
                                    <div class="sl">
                                        {{$v->buy_number}}
                                    </div>
                                </td>
                                <td>
                                    <div class="qgjg">
                                        {{formated_price($v->buy_price)}}
                                    </div>
                                </td>
                                <td>
                                    <div class="xq">
                                        {{$v->buy_time}}
                                    </div>
                                </td>
                                <td>
                                    <div style="max-width: 150px;display: inline-block;width: auto;" class="hf neirong"
                                         id="hf{{$v->buy_id}}" data-id="{{$v->buy_id}}"
                                         data-msg="{{$v->replay}}">
                                        @if(!empty($v->replay))
                                            {{str_limit($v->replay,30)}}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    @include('user.pages',['pages'=>$result])
                @else
                    @include('user.empty',['type'=>4,'emsg'=>'您还没有发布过求购'])
                @endif
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    <script>
        $('.neirong').hover(function () {
            var msg = $(this).data('msg');
            var id = $(this).data('id');
            layer.tips(msg, '#hf' + id, {
                tips: [4, '#3dbb2b']
            });
        }, function () {
            layer.closeAll()
        });
    </script>
    @include('common.footer')
@endsection
