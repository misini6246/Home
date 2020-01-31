@extends('layout.jf_body')
@section('links')
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/my_page_common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/my_account.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/pagination.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('jfen/js/jquery-1.7.2.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/my_page.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/wait.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/table_click.js')}}"></script>

@endsection
@section('content')
@include('layout.jf_header')
<div class="content_main">
    <p class="road_nav">您当前的位置： <span>首页</span> >> <span class="goods_name">我的账户</span></p>
    <div class="content_main_all clear_float">
        <p><span class="vip_center">会员中心</span><span class="address_manage">积分查询</span></p>
        @include('layout.jfMenu')
        <div class="manage_all_address">
            <div id="J_my_order" class="all_address clear_float">
                <table>
                    <thead>
                    <tr>
                        <td>操作时间</td>
                        <td>积分</td>
                        <td>备注</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $v)
                        <tr>
                            <td class="orderid">{{date('Y-m-d H:i:s',$v->change_time)}}</td>
                            <td class="color_f9">{{0-$v->pay_points}}</td>
                            <td class="status">{{$v->change_desc}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan=4 style="text-align:right;">您当前的可用积分为：{{$user->pay_points}} 分&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
                @if($pages->lastPage()>1)
                    <div class='order_pagination'>
                        <div class='pagination'>
                            @include('layout.jfPages')
                        </div>
                    </div>
                @endif
            </div>
            @include('layout.tj8')
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(function(){//已兑换变蓝色
        $(".status").each(function(n,e){
            if($(e).text()=="已兑换"){
                $(e).css({"color": "#089aca"});
            }
        });
    })
</script>
@include('layout.jf_footer')
@endsection
