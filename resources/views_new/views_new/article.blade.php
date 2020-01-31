@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/attach_left.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/help.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.lazyload.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jump.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.boxy.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/slides.jquery.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.cookie.js')}}"></script>
@endsection
@section('content')
@include('layout.page_header_help')

<div class="help_container fn_clear">
    <div class="main_left">
        @include('layout.articleTree')
    </div>
    <div class="main_right">
        <h2>{{$page_title}}</h2>
        @foreach($pages as $v)
            <div class="news_box">
                <h3>{{str_limit($v->title,20)}}</h3>
                <p>{{$v->content}}</p>
                <a href="{{route('articleInfo',['id'=>$v->article_id])}}">查看详情</a>

            </div>
        @endforeach
        <div class="listPageDiv">
            <div class="pageList">
                @if($pages->lastPage()>1)
                    @if($pages->currentPage()-4>1)
                        <span class="p1"><a href="{{pageParams(1,$params)}}">第一页</a></span>
                    @endif
                    @if($pages->currentPage()>1)
                        <span class="p1"><a href="{{pageParams($pages->currentPage()-1,$params)}}">上一页</a></span>
                    @endif
                    @if($pages->currentPage()>$pages->lastPage()-3)
                        @for($i=$pages->currentPage()-4-($pages->currentPage()-$pages->lastPage()+3);$i<$pages->currentPage();$i++)
                            @if($i>0)
                                <span class="p1"><a href="{{pageParams($i,$params)}}">{{$i}}</a></span>
                            @endif
                        @endfor
                    @else
                        @for($i=$pages->currentPage()-4;$i<$pages->currentPage();$i++)
                            @if($i>0)
                                <span class="p1"><a href="{{pageParams($i,$params)}}">{{$i}}</a></span>
                            @endif
                        @endfor
                    @endif
                    <span class="p1 p_ok">{{$pages->currentPage()}}</span>
                    @if($pages->currentPage()<5)
                        @for($i=$pages->currentPage()+1;$i<$pages->currentPage()+4+5-$pages->currentPage();$i++)
                            @if($i<=$pages->lastPage())
                                <span class="p1"><a href="{{pageParams($i,$params)}}">{{$i}}</a></span>
                            @endif
                        @endfor
                    @else
                        @for($i=$pages->currentPage()+1;$i<$pages->currentPage()+4;$i++)
                            @if($i<=$pages->lastPage())
                                <span class="p1"><a href="{{pageParams($i,$params)}}">{{$i}}</a></span>
                            @endif
                        @endfor
                    @endif
                    @if($pages->currentPage()<$pages->lastPage())
                        <span class="p1"><a href="{{pageParams($pages->currentPage()+1,$params)}}">下一页</a></span>
                    @endif
                    @if($pages->currentPage()+3<$pages->lastPage())
                        <span class="p1"><a href="{{pageParams($pages->lastPage(),$params)}}">最末页</a></span>
                    @endif
                @endif
            </div>
            <form action="{{route('article.index')}}" type="get" class="submit_input">
                <span>共{{$pages->lastPage()}}页</span>
                <span>到第<input name="page" class="page_inout" value="{{$pages->currentPage()}}" type="text">页</span>
                <input value="确定" class="submit" type="submit">
                <input name="id" value="{{$id}}" type="hidden">
            </form>
        </div>
    </div>
</div>



@include('layout.page_footer_help')
@endsection
