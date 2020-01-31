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
            margin-top: 20px!important;
        }

        .content_step {
            margin-top: 35px;
        }

        #content .container_box {
            padding-bottom: 40px;
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
            <div class="help_title">退款说明</div>
            <p>
                关于 退款操作的说明如下：
            </p>
            <p>（1）因商品质量问题或其它药易购原因造成的退货，顾客可以整单退货，配送费用及邮寄费将连同货款一并退还。</p>
            <p>（2）无论客户采用余额、充值余额或线上线下等何种方式支付的货款，在退货成功后，退款均退回账户余额（客户可自行申请提现）。</p>
        </div>
    </div>
    @include('article.footer')
@endsection
