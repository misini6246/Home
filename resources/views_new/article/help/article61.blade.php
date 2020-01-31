@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <style type="text/css">
        #content p{
            line-height: 30px;
            font-size: 16px;
        }
    </style>
@endsection
@section('content')
    @include('article.header')
    @include('article.help_nav')
    <div id="help_title" class="container">
        <div class="container_box">
            <ul class="help_title_list">
                @foreach($articles as $k=>$v)
                    <li @if($k==$article_id)class="active"@endif><a
                                href="{{route('xin.help',['cat_id'=>$cat_id,'article_id'=>$k])}}">{{$v}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div id="content" class="container">
        <div class="container_box">
            <div class="help_title">广告合作</div>
            <p>为了共享平台价值，药易购特推出针对医药生产厂家、经销商的广告宣传服务；</p>
            <p>医药广告需符合国家药监局医药医疗类广告相关规定。</p>
            <p>具体详情请咨询广告事业部</p>
            <p>联系QQ：6573911</p>
        </div>
    </div>
    @include('article.footer')
@endsection
