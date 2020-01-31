@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <style type="text/css">
        .lc_content p,
        .lc_content p span {
            line-height: 30px;
            font-size: 16px;
            padding-left: 20px;
        }

        .lc_content p span {
            display: block;
        }

        .img_box {
            text-align: center;
            padding: 40px 0;
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
            <div class="help_title">包装流程</div>
            <div class="content_step">
                药易购网上商城的包装流程完全按照专业的电子商务运营标准来制定：
            </div>
            <div class="lc_content">
                <p>1. 备货：由专业的工作人员进行备货。</p>
                <p>2. 配货：核对电子订单进行药品集中配货。</p>
                <p>3. 复检：根据订单，再次审核药品、数量、送货地址，检查商品批号并开具发票。</p>
                <p>
                    4. 包装：使用防震防压材料+防压气垫，确保商品不会在运输的过程中被损坏。
                    <span>随货单据：出库单＋发票（类型可选）</span>
                </p>
                <p>5. 发货：整理完毕后，由物流公司负责将商品送到顾客手上。</p>
                <div class="img_box">
                    <img src="{{get_img_path('images/help/help_lc.jpg')}}" />
                </div>
            </div>
        </div>
    </div>
    @include('article.footer')
@endsection
