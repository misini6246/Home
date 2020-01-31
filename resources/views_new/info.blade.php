<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>新闻中心</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/help/bzzx.css"/>
    <link rel="stylesheet" type="text/css" href="/help/pages_other.css"/>

</head>

<body>
<div class="big-container">
    <!--头部-->
@include('layouts.header')
<!--/头部-->

    <!--顶部-->
    <div class="top-box">
        <div class="box-container">
            <div class="left">
                <a href="{{'/'}}"><img src="/index/img/logo.jpg"></a>
                <div class="line"></div>
                新闻中心
            </div>
            <div class="option">
                <div class="box-container">
                    <div class="left">
                        <a href="{{'/'}}"><img src="/images/yunnan/logo.jpg"></a>
                        <div class="line"></div>
                        新闻中心
                    </div>
                    <div class="option">
                        <div class="option">
                            <div  @if($id==17) class="option-item cur" @else class="option-item" @endif><a href="/article?id=17">公司动态</a></div>
                            <div  @if($id==20) class="option-item cur" @else class="option-item" @endif>
                                <a href="/article?id=20">行业资讯</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/顶部-->

    <!--主体内容-->
    <div class="news-box">
        <div class="box-container">
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-cur"> @if($id==17)公司动态 @else 行业信息 @endif</li>
                </ul>
            </div>
            <div class="info">
                <ul class="grids-2">
                    @foreach($pages as $v)
                        <li class="grids-item">
                            {{--<div class="img-box">--}}
                            {{--<img src="/images/yunnan/logo.jpg"/>--}}
                            {{--</div>--}}
                            <div class="text-box">
                                <p class="title">
                                    {{$v->title,20}}
                                </p>
                                <p class="intro">{{$v->content}}</p>
                                <a href="{{route('articleInfo',['id'=>$v->article_id])}}">详情查看>></a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="listPageDiv" style="float: none">
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
    </div>
    <!--/主体内容-->

    <!--footer-->
@include('layouts.new_footer')
<!--/footer-->
</div>
</body>

</html>
