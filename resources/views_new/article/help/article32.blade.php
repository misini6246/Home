@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <style type="text/css">
        #content p{
            font-size: 16px;
            line-height: 30px;
        }
        #content p.red{
            color: #ff1919;
        }
        #content .img_box{
            padding: 20px 0 60px 0;
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
            <div class="help_title">转账汇款</div>
            <p>银行汇款（非直联，对公转账汇款）</p>
            <p>1、只需持本人身份证到最近的银行去办理异地(或同城)汇款业务。 （汇款本人可持现金办理无卡存款， 也可同行卡转账汇款。）</p>
            <p>2、如果拥有银行账号并且开通了网上汇款功能，就可以直接进行网上操作。（网上转账要比银行柜台快 ）</p>
            <p>3、如果您是首次汇款请详细咨询银行工作人员，以保证能够汇款成功。</p>
            <p>4、药易购接受下列线下付款账号：</p>
            <p class="red">电话告知：请您银行汇款后及时电话通知药易购客服告知其汇款人姓名及金额，这样才能够保证在规定的时间里及时处理您的订单。</p>
            <div class="img_box">
                <img src="{{get_img_path('images/help/help_zf_3.jpg')}}"/>
            </div>
        </div>
    </div>
    @include('article.footer')
@endsection
