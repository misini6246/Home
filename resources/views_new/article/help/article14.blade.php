@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
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
            <div class="help_title">积分说明</div>
            <div class="step">
                <div class="content_step">
                    商城有哪些积分种类？
                </div>
                <div class="gy_content">
                    <p style="font-size: 16px;line-height: 30px;">药易购商城有2种积分：<span
                                style="font-size: 16px;font-weight: 600;">“可兑换积分”</span>,<span
                                style="font-size: 16px;font-weight: 600;">“精品专区积分”</span>。</p>
                </div>
            </div>
            <div class="step">
                <div class="content_step">
                    什么是“可兑换积分”？
                </div>
                <div class="gy_content">
                    <p style="font-size: 16px;line-height: 20px;">
                        “可兑换积分”是指在药易购商城购买除“精品专区”以外的商品时所产生的积分；积分获得比例是消费1元获得1积分，只计算超过1元的部分；没有期限限制，不归零；积分达到一定程度可在“积分商城”里选择合适的礼品进行兑换，兑换成功的礼品会在15天内送达！</p>
                </div>
            </div>
            <div class="step">
                <div class="content_step">
                    什么是“精品专区积分”？
                </div>
                <div class="gy_content">
                    <p style="font-size: 16px;line-height: 20px;padding-bottom: 10px;">
                        “精品专区积分”是指在药易购商城下“精品专区”购买商品时所产生的积分，积分获得比例是消费1元获得1积分，只计算超过1元的部分。有时间限制，每个活动时间内，可进行积分累计，过期自动清零。单次订单中精品专区积分数达到相应礼品积分段时，可以直接兑换相应礼品；单次积分不兑换，选择累计的，需累计满3000积分才能兑换礼品。兑换成功的礼品会在15天内送达！</p>
                    <p style="font-size: 14px; font-weight: 600; color: red;">
                        特别提醒：活动结束，积分自动清零！敬请随时关注您的积分情况，以方便您挑选到您满意的礼品。</p>
                </div>
            </div>
        </div>
    </div>
    @include('article.footer')
@endsection
