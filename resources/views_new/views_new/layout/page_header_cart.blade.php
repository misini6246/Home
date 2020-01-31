<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<div class="header">
    <div class="top_box">
        <div class="top">
            <div class="top_left">{!! member_info() !!}</div>
            <div class="top_right">
                <a target="_blank" href="{{route('user.collectList')}}" >我的收藏</a>|<a href="javascript:history.back()">返回页面</a>
            </div>

        </div>
    </div>
    <div class="banner_box">
        <div class="banner">
            <a href="{{route('index')}}"><img src="{{path('images/login_03.png')}}" alt=""/></a>
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
