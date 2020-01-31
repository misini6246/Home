@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <style type="text/css">
        #content p {
            font-size: 16px;
            line-height: 30px;
            margin-top: 5px;
        }

        .content_title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .content_step {
            margin-top: 35px;
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
            <div class="help_title">退换货政策</div>
            <p class="content_title">
                因药品是特殊商品，依据中华人民共和国《药品经营质量管理规范》及其实施细则（GSP）、《互联网药品交易服务审批暂行规定》等法律、法规的相关规定：一经售出，无质量问题，不退不换。
            </p>
            <p>
                药易购网上商城承诺自客户收到商品之日起7日内，如商品下列情况的质量问题，且包装保持药易购出售时原状、配件齐全，药易购将提供全款退货或换货的服务。退 换货前请先联系客服确认，收到退换货商品后，药易购将及时安排第二次发货或将款项退回到您的账户余额。
            </p>
            <p>（1）由于产品本身存在质量原因，经药易购质量管理部门检验，确属质量问题的；</p>
            <p>（2）经国家权威管理部门或生产厂家发布公告的产品（如停售、收回等）。</p>
            <div class="content_step">
                有下列情况的，药易购将不予退换货
            </div>
            <p>（1）在退换货之前客户未与药易购客服服务中心取得联系；</p>
            <p>（2）药易购网上商城销售的商品包装已经拆封将不予退换货；</p>
            <p>（3）客户采购的商品因非正常使用或储藏而出现质量问题的；</p>
            <p>（4）退回商品外包装或其他商品附属物不完整或有损毁的；</p>
            <p>（5）超出质量保质期的商品；</p>
            <p>（6）退换货商品的批号、型号与售出时不符的；</p>
            <p>（7）配送到达时已开箱验货的商品。</p>
        </div>
    </div>
    @include('article.footer')
@endsection
