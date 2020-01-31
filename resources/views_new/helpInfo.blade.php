<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>帮助中心</title>
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
                帮助中心
            </div>

            <div class="option">
                <div  class="option-item @if($cat_id==2) cur @endif"><a href="/articleInfo?id=27">新人指南</a></div>
                <div  class="option-item @if($cat_id==6) cur @endif"><a href="/articleInfo?id=14">配送方式</a></div>
                <div  class="option-item @if($cat_id==22) cur @endif"><a href="/articleInfo?id=13">支付方式</a></div>
                <div  class="option-item @if($cat_id==11) cur @endif"><a href="/articleInfo?id=16">售后服务</a></div>
                <div  class="option-item @if($cat_id==15) cur @endif"><a href="/articleInfo?id=18">关于我们</a></div>
                <div  class="option-item @if($cat_id==21) cur @endif"><a href="/articleInfo?id=20">商务合作</a></div>
            </div>
        </div>
    </div>
    <!--/顶部-->

    <!--主体内容-->
    <div class="main-box">
        <div class="box-container">
            <ul class="nav">
                @foreach($help as $s)
                    <li class="nav-item @if($s->article_id == $id) cur @endif"><a href="/articleInfo?id={{$s->article_id}}">{{$s->title}}</a></li>
                @endforeach
            </ul>
            <div class="img-box">
                {!!$article!!}
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