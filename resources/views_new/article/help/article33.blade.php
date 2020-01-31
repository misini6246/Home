@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <style type="text/css">
        #content p{
            font-size: 16px;
            line-height: 30px;
        }
        #content p a{
            display: inline-block;
            width: 76px;
            height: 24px;
            line-height: 24px;
            text-align: center;
            color: #fff;
            background: #3dbb2b;
            border-radius: 3px;
            margin-left: 10px;
        }
        #content .img_box{
            padding: 20px 0 100px 0;
            text-align: center;
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
            <div class="help_title">开具发票</div>
            <div class="content_step">
                开具发票说明
            </div>
            <p>◆ 开具方：所有商品发票由合纵医药负责开具，且所有开具的发票均为合法有效的电子发票。</p>
            <p>◆ 开具权益：客户在结算过程中可以选择开具发票类型：增值税专用发票或者增值税普通发票，药易购会按照顾客的选择为顾客开具发票。</p>
            <p>◆ 开具范围：所有商品仅按顾客实际支付金额开具发票，不包括返利金额、优惠券等金额部分。</p>
            <p>◆ 开具内容：发票开具内容与销售订单内容保持一致，为客户订购的商品全称和型号，且不支持发票内容修改。发票金额与实际付款金额一致，不可多开或者少开。</p>
            <p>◆ 发票说明：选择增值税专用发票，请先下载开增值税专票需要信息，填好信息后打印盖上公章截图。<a href="#">下载表单</a></p>
            <p>◆ 查看说明：发票开具后可在网站首页顶部的“电子发票查询”里进行操作。如有疑问请致电药易购客服热线400-602-8262。</p>
            <div class="img_box">
                <img src="{{get_img_path('images/help/help_zf_4.jpg')}}"/>
            </div>
        </div>
    </div>
    @include('article.footer')
@endsection
