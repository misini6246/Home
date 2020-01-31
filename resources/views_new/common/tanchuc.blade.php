<style>
    .tanchuc {
        position: fixed;
        top: 50%;
        left: 50%;
        margin: -75px 0 0 -210px;
        background: url("{{get_img_path('images/tip_kuang.png')}}") no-repeat;
        width: 400px;
        height: 120px;
        z-index: 9999;
        padding: 10px;
    }

    .error_img {
        width: 58px;
        height: 58px;
        background: url("{{get_img_path('images/tipsBg_03.png')}}") 0 -61px no-repeat;
        float: left;
        margin: 12px 15px 0 12px;
    }

    .success_img {
        width: 58px;
        height: 58px;
        background: url("{{get_img_path('images/tipsBg_03.png')}}") 0 0 no-repeat;
        float: left;
        margin: 12px 15px 0 12px;
    }
</style>
<div class="tanchuc" @if($show==0)style="display:none;" @endif id="shopping_box">
    <div class="content_buy"><a href="javascript:;" @if($error==0)class="success_img"
                                @else class="error_img" @endif></a>
        <h4 class="tip_text">{{$text or '错误'}}</h4>
        <p class="tip_txt" alt="" title="">{{$content or ''}}</p>
        @if(strpos($text,'血液制品采购委托书')!==false||strpos($text,'冷藏药品采购委托书')!==false)
            <p class="login_p tab_p1">
                <a href="{{$show1_url1 or 'javascript:;'}}" class="login_a again" style="margin-top: 16px;">确定</a>
                <a href="/uploads/血液制品、冷藏药品采购委托书（二合一）.doc" style="margin-top: 16px;">下载</a>
            </p>
        @else
            @if($show1==0)
                <p class="login_p tab_p1">
                    <a href="{{$show1_url1 or 'javascript:;'}}" class="login_a again">{{$show1_btn1 or '继续购物'}}</a> <a
                            href="{{$show1_url2 or route('cart.index')}}">{{$show1_btn2 or '去结算'}}</a>
                </p>
            @else
                <p class="login_p tab_p4">
                    <a href="{{$show1_url3 or 'javascript:;'}}"
                       class="login_a confirm again">{{$show1_text3 or '确认'}}</a>
                </p>
            @endif
        @endif
        <span class="close2"></span>
    </div>
</div>
<script>
    $(function () {
        $('.close2').click(function () {
            $('.tanchuc').hide();
        });
        $('.login_a').click(function () {
            $('.tanchuc').hide();
        });
    });

</script>