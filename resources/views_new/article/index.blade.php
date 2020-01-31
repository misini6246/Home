<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title></title>
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
                <a href="/"><img src="/index/img/logo.jpg"></a>
                <div class="line"></div>
                帮助中心
            </div>
            <div class="option">
                @foreach($help_nav as $n)
                    <div @if($n->cat_name == $title)class="option-item cur" @else class="option-item" @endif><a href="http://47.107.103.86/article?id=".{{ $n->cat_id }}>{{ $n->cat_name }}</a></div>
                @endforeach
            </div>
        </div>
    </div>
    <!--/顶部-->

    <!--主体内容-->
    <div class="news-box">
        <div class="box-container">
            <div class="breadcrumb">
                <ul>
                    @foreach($next_nav as $art)
                        <li class="breadcrumb-cur">
                            <a href="http://47.107.103.86/rticleinfo?id={{$art->cat_id}}">{{ $art->cat_name }} &emsp;&emsp;&emsp;&emsp;</a>
                    @endforeach
                </ul>
            </div>
            <div class="info">
                <ul class="grids-2">
                    <li class="grids-item">
                    @foreach($result as $v)
                            <div class="img-box">
                                <img src="/index/img/logo.jpg"/>
                            </div>
                            <div class="text-box">
                                <p class="day">{{date('d',$v->add_time)}}</p>
                                <p class="year">{{date('Y-m',$v->add_time)}}</p>
                                <p>{!! $v->content !!}</p>
                                <a href="{{route('xin.article.show',['id'=>$v->article_id])}}" class="fl">阅读全文</a>
                            </div>
                                    {{--<a href="{{route('xin.article.show',['id'=>$v->article_id])}}">{{$v->title}}</a>--}}
                    @endforeach
                    </li>
                </ul>
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