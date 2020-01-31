@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <style type="text/css">
        #content .container_box{
            padding-bottom: 120px;
        }
        #content p{
            font-size: 16px;
            line-height: 30px;
        }
        #content p a{
            font-size: 16px;
            color: #247be6;
            margin: 0 5px;
        }
        #content .img_box{
            padding: 20px 0 40px 0;
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
            <div class="help_title">在线支付</div>
            <p>1，订单提交前，支付选择中，如有账户余额会优先使用余额支付（必用），对于余额不足部分或没有余额时，可选择的在线支付方式有银联支付、微信支付、兴业
                银行快捷支付。（支付方式以实际页面展示为准）</p>
            <div class="img_box">
                <img src="{{get_img_path('images/help/help_zf_1.jpg')}}"/>
            </div>
            <p>2，当你选择微信支付，并成功提交订单后，在支付页选择立即支付，会弹出微信二维码，客户进行扫描二维码进行支付；支付时请确认收款方为”四川合纵医药股份
                有限公司”、和支付金额是否与订单应付金额一致。</p>
            <div class="img_box">
                <img src="{{get_img_path('images/help/help_zf_2.jpg')}}"/>
            </div>
            <p>3，当你选择快捷支付或银联支付时，并成功提交订单后，在支付页选择立即支付，会跳转到兴业银行快捷支付页面或银联在线支付页面进行支付；支付时请确认收款
                方为”四川合纵医药股份有限公司”、和支付金额是否与订单应付金额一致。具体使用帮助请点击<a href="#">“兴业银行”</a>、<a href="#">“银联在线”</a>进行查看</p>
        </div>
    </div>
    @include('article.footer')
@endsection
