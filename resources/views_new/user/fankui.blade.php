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
                        href="{{route('member.index')}}">我的太星医药网</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>我的反馈</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <a target="_blank" href="/feedback">
                        <div class="add_liuyan">我要反馈</div>
                    </a>
                    <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                    <span>我的反馈</span>
                </div>
                @if(count($result)>0)
                    <table>
                        <tr>
                            <th class="hf">反馈类型</th>
                            <th class="hf">反馈内容</th>
                            <th class="xq">反馈时间</th>
                            <th class="hf">回复</th>
                            <th class="xq">回复时间</th>
                        </tr>
                        @foreach($result as $v)
                            <tr>
                                <td>
                                    <div class="hf">
                                        {{$v->fk_type}}
                                    </div>
                                </td>
                                <td>
                                    <div style="display: inline-block;width: auto;max-width: 150px;" class="hf neirong"
                                         id="hf{{$v->rec_id}}" data-id="{{$v->rec_id}}"
                                         data-msg="{{$v->msg_content}}">
                                        {{$v->msg_content}}
                                    </div>
                                </td>
                                <td>
                                    <div class="xq">
                                        {{date('Y-m-d H:i:s',$v->add_time)}}
                                    </div>
                                </td>
                                <td>
                                    <div style="display: inline-block;width: auto;max-width: 150px;" class="hf neirong"
                                         id="hf{{$v->rec_id}}replay" data-id="{{$v->rec_id}}replay"
                                         data-msg="{{$v->replay}}">
                                        {{$v->replay}}
                                    </div>
                                </td>
                                <td>
                                    <div class="xq">
                                        @if(!empty($v->replay))
                                            {{date('Y-m-d H:i:s',$v->replay_time)}}
                                        @endif
                                    </div>
                                </td>
                                {{--<td>--}}
                                {{--<div class="hf neirong" id="hf{{$v->buy_id}}" data-id="{{$v->buy_id}}"--}}
                                {{--data-msg="{{$v->replay}}">--}}
                                {{--@if(!empty($v->replay))--}}
                                {{--{{str_limit($v->replay,30)}}--}}
                                {{--@endif--}}
                                {{--</div>--}}
                                {{--</td>--}}
                            </tr>
                        @endforeach
                    </table>
                    @include('user.pages',['pages'=>$result])
                @else
                    @include('user.empty',['type'=>4,'emsg'=>'您还没有发布过反馈信息'])
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
                tips: [4, '#3dbb2b'],
                time: 0
            });
        }, function () {
            layer.closeAll()
        });
    </script>
    @include('common.footer')
@endsection
