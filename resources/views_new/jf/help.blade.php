@extends('layout.jf_body')
@section('links')
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/help.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('jfen/js/jquery-1.7.2.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/help.js')}}"></script>

@endsection
@section('content')
@include('layout.jf_header')
<div class="help">
    <p class="road_nav">您当前的位置： <span>首页</span> >> <span class="goods_name">{{$news->name}}</span></p>
    <div class="help_main clear_float">
        <div class="help_list">
            <!--手风琴-->
            <div class="accordion_list">
                {{--{foreach from=$allcates item=info}--}}
                <div class="accordion_list_out">
                    <p>帮助中心<i></i></p>
                    <ul>
                        @foreach(jf_helpList() as $v)
                        <li><span>·</span><a href="{{route('jf.help',['id'=>$v->id])}}">{{str_limit($v->name,20)}}</a></li>
                        @endforeach
                    </ul>
                </div>
                {{--{/foreach}--}}
            </div>
            <!--end-->
        </div>
        <div class="help_content">
            <div class="help_content_head"><p>{{$news->name}}</p></div>
            <div class="help_content_content">
                {!! $news->content !!}
            </div>
        </div>
    </div>
</div>
</div>
@include('layout.jf_footer')
@endsection
