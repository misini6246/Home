@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <style type="text/css">
        .img_box {
            text-align: center;
            padding: 40px 0;
        }

        .lc_content_title {
            height: 46px;
            line-height: 46px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }

        .lc_content p {
            line-height: 24px;
            font-size: 16px;
        }

        .lc_tishi {
            margin-top: 20px;
            padding-bottom: 50px;
        }

        .lc_tishi a {
            color: #3285fa;
            font-size: 16px;
            margin-left: 10px;
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
            <div class="help_title">验收流程</div>
            <div class="content_step">
                验收流程：
            </div>
            <div class="lc_content">
                <div class="img_box">
                    <img src="{{get_img_path('images/help/help_yslc.jpg')}}" />
                </div>
                <div class="lc_content_title">
                    如何验货
                </div>
                <p>药易购商城在售商品均由正规药品，质量保证。商品配送服务由合纵直配、签约物流公司承担。</p>
                <p>请您收到药品时，签字确认前一定要对药品进行开箱检验，检验商品信息是否一致、商品数量、外包装是否破损。如其中一项不符合要求，您有权拒绝签字。</p>
                <div class="lc_content_title">
                    温馨提示
                </div>
                <p>如果您未当场对商品进行验收，一旦商品数量缺少、破损等问题出现，事后将会有较为繁琐复杂的调查流程进行责任调查。同时，也会延长您的订购周期，责任无法确定的将无法补偿您的损失。因此您在签收包裹时务必认真清点商品！
                </p>
                <p class="lc_tishi">
                    其他药易购商城未提及的内容均参照国家相关政策。
                    <a href="#">附《快递服务》国家标准</a>
                </p>
            </div>
        </div>
    </div>
    @include('article.footer')
@endsection
