<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
    .top_box {
        background-color: #f1f1f1;
        height: 34px;
        border-bottom: 1px solid #e5e5e5;
        border-top: 1px solid #e5e5e5;
        color: #6c6c6c;
        line-height: 34px;
        position: relative;
        z-index: 997;
    }

    .top_box a {
        color: #6c6c6c;
        padding: 0 10px;
    }

    .top_box a.login {
        padding: 4px 10px;
        color: #fff;
        text-align: center;
        background-color: #3ebb2b;
        border-radius: 5px;
    }

    .top_box a.login:hover {
        background-color: #46d23c
    }

    .top_box a.reg {
        padding: 4px 5px;
        color: #6d6f6d;
        text-align: center;
    }

    .top_box a.reg:hover {
        color: #e70000
    }

    .top_box .separate {
        padding: 0 10px;
    }

    .top_box .separate2 {
        padding: 0 5px;
    }

    .top_box .username {
        color: #f08300;
        padding-right: 0;
    }

    .top_box .out {
        color: #717170;
        padding: 0 1px 0 3px;
    }

    .top_left .my_name {
        padding: 4px 10px;
        color: #fff;
        text-align: center;
        background-color: #3ebb2b;
        border-radius: 5px;
    }

    .top_box a.my_name:hover {
        background-color: #46d23c
    }

    .top {
        width: 1200px;
        margin: 0 auto;
    }

    .top_left {
        float: left;
        color: #aeaeae;
    }

    .top_left span {
        color: #4c4b4b;
    }

    .top_left a {
        color: #e70000;
        padding: 0 10px;
    }

    .top_right {
        float: right;
        color: #aeaeae;
        position: relative;
        z-index: 9999;
    }

    .top_right a {
        padding: 0 10px;
        position: relative;
    }

    .top_right a:hover {
        color: #e70000;
    }

    .top_right .pic img {
        width: 113px;
        height: 121px;
    }

</style>
<div id="header" class="header">
    <div class="top_box">
        <div class="top">
            <div class="top_left">{!! member_info() !!}</div>
            <div class="top_right">
                <a target="_blank" href="{{route('user.collectList')}}">我的收藏</a>|<a href="javascript:history.back()">返回页面</a>
            </div>

        </div>
    </div>
    <div class="banner_box">
        <div class="banner">
            <a href="{{route('index')}}"><img src="{{asset('images/logo-new.png')}}"  alt=""/></a>
            <h1>购物流程</h1>
            <ul>
                {{--<li><!-- {if $step eq "cart" || $step eq "checkout" || $step eq "done"} --><img src="./images/cart_03.png"/><!-- {else} --><img src="./images/confirm1.png"/><!-- {/if} --></li>--}}
                {{--<li><!-- {if $step eq "checkout" || $step eq "done"} --><img src="./images/confirm2.png" alt=""/><!-- {else} --><img src="./images/cart_04.png"/><!-- {/if} --></li>--}}
                {{--<li><!-- {if $step eq "done"} --><img src="./images/order22.png"/><!-- {else} --><img src="./images/cart_05.png"/><!-- {/if} --></li>--}}

                @if(isset($cartStep))
                    {!! $cartStep or '' !!}
                @else
                    <li><img src='{{path('images/confirm1.png')}}'/></li>
                    <li><img src='{{path('images/cart_04.png')}}'/></li>
                    <li><img src='{{path('images/cart_05.png')}}'/></li>
                @endif
            </ul>
        </div>
    </div>

</div>
