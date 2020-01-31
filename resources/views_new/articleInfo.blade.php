<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>新闻中心-详情</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/help/bzzx.css"/>
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

                <div @if($cat_id==17) class="option-item cur" @else class="option-item" @endif>
                    <a href="/article?id=17">公司动态</a>
                </div>

                <div @if($cat_id==20) class="option-item cur" @else class="option-item" @endif>
                    <a href="/article?id=20">行业资讯</a>
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
                    <li>
                        <a href="#">公司动态</a>
                    </li>
                    <li class="breadcrumb-divider">&gt;</li>
                    <li class="breadcrumb-cur">正文</li>
                </ul>
            </div>
            <div class="info">
                <h1>{{$article->title}}</h1>
                <p class="date">发布日期：<span>{{date('Y-m-d H:i:s',$article->add_time)}}</span> </p>
                <div class="content">
                    @if($article->content!='')
                        {!! $article->content !!}
                    @endif
                </div>
            </div>
            <div class="bottom">
                <div class="btn-box" style="margin-top: 26px;">
                    <span class="btn">上一篇</span>
                    @if($preArticle)
                        <a href="/articleInfo?id={{$preArticle->article_id}}" style="color: #999">{{$preArticle->title}}</a>
                    @else
                        <a href="javascript:;" style="color: #999">无</a>
                    @endif
                </div>
                <div class="btn-box">
                    <span class="btn">下一篇</span>
                    @if($nextArticle)
                        <a href="/articleInfo?id={{$nextArticle->article_id}}" style="color: #999">{{$nextArticle->title}}</a>
                    @else
                        <a href="javascript:;" style="color: #999">无</a>
                    @endif
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