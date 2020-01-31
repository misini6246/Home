@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_problem.css')}}"/>
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
            <div class="help_title">常见问题</div>
            <div id="content">
                <div class="list">
                    <div class="problem_q">
                        <span>Q</span>
                        <p>药易购网上销售的药品是正品吗？我如何验证？</p>
                    </div>
                    <div class="problem_a">
                        <span>A</span>
                        <p>
                            药易购是四川合纵医药的官方网上商城，是经国家批准的正规、合法的网上商城（互联网药品交易资格证书编号:川B20130002）。药易购上销售的商品与合纵医药线下销售的药品来源一致，都是来自于合纵医药物流中心，正品保真。如果顾客想验证药品真伪，可以根据商品页面的“药品的批准文号或产品名”，通过国家药监局
                            <a href="http://www.sfda.gov.cn/" style="font-size: 14px;color: blue;">http://www.sfda.gov.cn/</a>的网站上，并通过输入药品的批准文号/产品名称进行查询。
                        </p>
                    </div>
                </div>
                <div class="list">
                    <div class="problem_q">
                        <span>Q</span>
                        <p>忘记会员名或者密码怎么办？</p>
                    </div>
                    <div class="problem_a">
                        <span>A</span>
                        <p>会员注册成功以后会分配一位专属客服，如果忘记会员名，可联系您的专属客服进行查询；如果忘记密码，可以通过“帮助中心”--“新人指南”--“找回密码”进行自助操作。</p>
                    </div>
                </div>
                <div class="list">
                    <div class="problem_q">
                        <span>Q</span>
                        <p>如何取消订单？</p>
                    </div>
                    <div class="problem_a">
                        <span>A</span>
                        <p>由于为了预防一些误操作，我们并没有放开客户自助取消订单的权限；如需操作，请联系您的专属客服。</p>
                    </div>
                </div>
                <div class="list">
                    <div class="problem_q">
                        <span>Q</span>
                        <p>如何对订单进行支付？</p>
                    </div>
                    <div class="problem_a">
                        <span>A</span>
                        <p>
                            为了保障您的权益，我们在您进行购物车下单后的“填写核对订单信息”页面，默认使用药易购官方发出的如优惠券、积分金币等等优惠政策；优惠后的金额，优先使用您的余额（如果有余额）进行支付，如余额能完全支付货款，则不用选择其他支付方式；在不能完全支付时，可以选择支付宝、微信、银联等在线支付方式（根据实际情况我们会调整支付方式）以及银行转账汇款等线下支付方式在订单提交采购成功后进行支付。需注意，对于订单中有麻黄碱品种时，根据GSP规定，系统会单独分单，且需要您单独对齐进行支付（不能使用余额支付）。</p>
                    </div>
                </div>
                <div class="list">
                    <div class="problem_q">
                        <span>Q</span>
                        <p>药易购支持哪些在线支付方式？</p>
                    </div>
                    <div class="problem_a">
                        <span>A</span>
                        <p>支持但不仅限于：微信支付、支付宝支付、银联支付、兴业银行快捷支付；药易购有权根据实际情况增减支付方式，且不另行通知。</p>
                    </div>
                </div>
                <div class="list">
                    <div class="problem_q">
                        <span>Q</span>
                        <p>药易购支持哪些线下支付方式？</p>
                    </div>
                    <div class="problem_a">
                        <span>A</span>
                        <p>
                            为了您的货款安全，对于线下支付，药易购仅支持银行转账汇款一种方式（请尽量不选择ATM转账汇款，有24小时延迟），打款后请及时联系客服确认，具体支持的银行请通过“帮助中心”--“支付方式”--“转账汇款处查看”</p>
                    </div>
                </div>
                <div class="list">
                    <div class="problem_q">
                        <span>Q</span>
                        <p>支付成功后什么时候发货？</p>
                    </div>
                    <div class="problem_a">
                        <span>A</span>
                        <p>
                            线上支付的订单，支付成功后会显示已付款，非活动日，一般是24小时内发出；活动日，订单较多，根据订单顺序可能3-5天内发出。可在“我的药易购”--“我的订单”里面选择具体订单的“订单跟踪”查看实时的订单状态。</p>
                    </div>
                </div>
                <div class="list">
                    <div class="problem_q">
                        <span>Q</span>
                        <p>支付成功后什么时候发货？</p>
                    </div>
                    <div class="problem_a">
                        <span>A</span>
                        <p>
                            线上支付的订单，支付成功后会显示已付款，非活动日，一般是24小时内发出；活动日，订单较多，根据订单顺序可能3-5天内发出。可在“我的药易购”--“我的订单”里面选择具体订单的“订单跟踪”查看实时的订单状态。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('article.footer')
@endsection
