@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_wl.css')}}"/>
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
            <div class="help_title">物流配送</div>
            <div class="content_step">
                商城有哪些积分种类？
            </div>
            <table>
                <tr>
                    <th class="pswl">配送物流</th>
                    <th class="fhsj">发货时间</th>
                    <th class="sfbz">收费标准</th>
                    <th class="psqy">配送区域</th>
                </tr>
                <tr>
                    <td>合纵直配</td>
                    <td>以合纵实际发货时间为准，详情请咨询客服。</td>
                    <td>
                        <p>订单满800元免运费；</p>
                        <p>未满800元按10元/件收取运费</p>
                    </td>
                    <td>大成都范围</td>
                </tr>
                <tr>
                    <td>
                        <p>普通货运 </p>
                        <p>（合作、指定）</p>
                    </td>
                    <td>每日下午3时前支付的订单，当天发货到货运公司</td>
                    <td>
                        <p>订单满800元免运费；</p>
                        <p>未满800元按10元/件收取运费</p>
                    </td>
                    <td>全川</td>
                </tr>
            </table>
            <div class="wl_tishi">
                <p class="wl_tishi_title">
                    温馨提示：
                </p>
                <p>
                    成都地区我们将用自己的物流提供“送货上门”服务，成都以外的地区我们将客户指定的物流送到客户所在地区。
                    每日15：00前支付成功的订单一般当天即可发货，15：00之后的订单一般将于24小时内发货（发货时间可能变动，恕不另行通知，具体可咨询客服）。
                    配送时间一般不超过3-6天，如遇特殊情况（天气等不可抗拒因素）而造成延迟的敬请谅解。
                </p>
            </div>
        </div>
    </div>
    @include('article.footer')
@endsection
