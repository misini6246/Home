@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>我的订单</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuancommon.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuanzhongxin.css" />
    <!--layer-->
    <link rel="stylesheet" type="text/css" href="/user/layer/layer.css" />

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <!--layer-->
    <script src="/user/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
    <style type="text/css">
        .ts_page {
            height: 240px;
            border: 1px solid #b2cdff;
            width: 1200px;
            margin: 10px auto 40px auto;
            box-shadow: 0 8px 16px rgba(61, 121, 254, 0.2);
            text-align: center;
        }

        .ts_page p {
            color: #ff1919;
            font-size: 20px;
            margin-top: 65px;
        }

        .ts_page a {
            font-size: 16px;
            color: #fff;
            display: inline-block;
            width: 120px;
            height: 40px;
            line-height: 40px;
            border-radius: 5px;
            background: #3dbb2b;
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    @include('layouts.youce')
    <div class="ts_page">
        <p style="margin-top: 65px;">{{$msg or '抱歉，您请求的页面已不存在！'}}</p>
        {!! $link_str !!}
    </div>
    @include('layouts.new_footer')
@endsection
