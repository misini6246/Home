@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/gsdt_xq.css')}}"/>
    <script src="{{path('js/new/baidu.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('cart.header')
    @include('article.nav')
    <div id="gsdt_title" class="container">
        <div class="container_box">
            <div class="xiangqing_title">
                <i class="myicon address"></i>当前位置：
                <a href="{{route('index')}}">首页</a><i class="myicon xq_right"></i>{{$info->cat_name}}
            </div>
        </div>
    </div>
    <div id="gsdt" class="container">
        <div class="container_box">
            <div class="content">
                <p class="title">{{$article->title}}</p>
                <div class="date">
                    发布日期：{{date('Y-m-d H:i',$article->add_time)}}
                    <div class="bdsharebuttonbox">
                        <a href="#" class="bds_more" data-cmd="more">分享到：</a>
                        <a href="#" class="bds_qzone" data-cmd="qzone"></a>
                        <a href="#" class="bds_tsina" data-cmd="tsina"></a>
                        <a href="#" class="bds_tqq" data-cmd="tqq"></a>
                        <a href="#" class="bds_renren" data-cmd="renren"></a>
                        <a href="#" class="bds_weixin" data-cmd="weixin"></a>
                    </div>
                </div>
                <div class="text">
                    {!! $article->content !!}
                </div>
                <ul class="page">
                    @if($prev)
                        <li class="prev fl">
                            <i class="myicon new_prev_icon"></i>
                            <a href="{{route('xin.article.show',['id'=>$prev->article_id])}}">{{$prev->title or ''}}</a>
                        </li>
                    @endif
                    @if($next)
                        <li class="next fr">
                            <a href="{{route('xin.article.show',['id'=>$next->article_id])}}">{{$next->title}}</a>
                            <i class="myicon new_next_icon"></i>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    @include('article.footer')
@endsection
