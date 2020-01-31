<div class="mui-mbar-tabs">

    <div class="quick_link_mian">

        <div class="quick_links_panel">
            <div id="quick_links" class="quick_links" style="top: 30%;*top: 40%;">
                <li style="z-index: 10;position: relative;">
                    <a href="javascript:;" class="my_qlinks">
                        <img src="{{path('new/images/right-tousu.png')}}"/>
                    </a>
                    <div class="ibar_login_box status_login">
                        <div class="online_service">
                            <a target="_blank"
                               href="http://wpa.b.qq.com/cgi/wpa.php?ln=2&uin=4006028262&site=qq&menu=yes"></a>
                            <img src="{{path('new/images/kefu01.png')}}"/>
                        </div>
                    </div>
                </li>
                <li style="text-align: center;color: white;margin-top: 10px;cursor: pointer;">
                    <a href="{{route('user.znx_list')}}" style="padding: 10px 0;">
                        <img src="{{get_img_path('images/xiaoxi.png')}}" style="*margin-left: -16px;"/>
                        <p style="width: 20px;margin-left: 8px;*margin-left:0;font-size: 12px;color: white;">消息</p>
                        <span class="msg_count" id="msg_count"
                              style="display: inline-block;font-family: '宋体';padding: 2px 5px;background: #eb3235;border-radius:15px;margin-top: 5px;color: white;">{{msg_count()}}</span>
                    </a>
                    @if(msg_count()>0)
                        <a id="msg_count_tishi" href="{{route('user.znx_list')}}" style="color: #ffffff">
                            <div class="tishi">
                                您有<span class="msg_count">{{msg_count()}}</span>条未读消息
                                <div></div>
                            </div>
                        </a>
                    @endif
                </li>
                <li id="shopCart">
                    <a href="javascript:;" class="mpbtn_wdsc2" style="text-align: center">
                        <img src="{{get_img_path('new_gwc')}}" alt=""/>
                        <span id="gwc_count" class="cart_number"
                              style="display: inline-block;font-family: '宋体';padding: 2px 5px;background: #eb3235;border-radius:15px;margin-top: 5px;color: white;">{{cart_info()}}</span>
                    </a>
                </li>
                <li>
                    <i class="i-sidebarcom-cart"></i>
                    <a href="javascript:;" class="mpbtn_wdsc3"><i class="wdsc3"></i></a>
                    <i class="i-sidebarcom-cart"></i>

                </li>
                <li>
                    <a href="javascript:;" class="fixed-sc mpbtn_wdsc">
                        <img src="{{get_img_path('images/new/fix-sc.png')}}"/>
                    </a>
                    <div class="mp_tooltip" style="top:4px;*top: 0;">
                        <a href="#header" class="tip_txt">
                            <img src="{{get_img_path('images/new/sc.png')}}"/>
                        </a>
                    </div>
                </li>
                <li>
                    <a href="javascript:;" class="fixed-zncg mpbtn_wdsc">
                        <img src="{{get_img_path('images/new/fix-zncg.png')}}"/>
                    </a>
                    <div class="mp_tooltip" style="top:4px;*top: 0;">
                        <a href="#header" class="tip_txt">
                            <img src="{{get_img_path('images/new/cg.png')}}"/>
                        </a>
                    </div>

                </li>
            </div>
            <div class="quick_toggle1">

                <li>
                    <a href="/feedback" target="_blank" class="mpbtn_wdsc"><i class="wdsc4"></i></a>
                    <div class="mp_tooltip">
                        <a href="/feedback" target="_blank" class="tip_txt">
                            <img src="{{get_img_path('images/new/fankui.png')}}"/>
                        </a>

                    </div>
                </li>
                <li class="qudingbu">
                    <a href="#header" class="mpbtn_wdsc"><i class="wdsc5"></i></a>
                    <div class="mp_tooltip" style="position: absolute;top:46px;">
                        <a href="#header" class="tip_txt" style="top: -5px;*top: 0;">
                            <img src="{{get_img_path('images/new/Totop-1.png')}}">
                        </a>
                    </div>
                </li>

            </div>
        </div>
        <div id="quick_links_pop" class="quick_links_pop hide"></div>
    </div>
</div>
<div class="fix-box-show">
    <div id="fix-gwc">

    </div>
    <div id="myyaoyigou">

    </div>
    <div id="wdsc">

    </div>
    <div id="zncg">

    </div>
</div>
<div id="right-bgcolor">

</div>
<input id="check_auth" type="hidden" value="{{auth()->check()}}">
<script type="text/javascript" src="{{path('new/js/youce.js')}}"></script>
<script>
    $('.qudingbu').singlePageNav({
        offset: 0
    });
    $(".quick_links_panel li").mouseenter(function () {
        $(this).children(".mp_tooltip").animate({left: -75, queue: true});
        $(this).children(".mp_tooltip").css("visibility", "visible");
        $(this).children(".ibar_login_box").css("display", "block");
        $(this).find("a").addClass("hover-color");
    });
    $(".quick_links_panel li").mouseleave(function () {
        $(this).children(".mp_tooltip").css("visibility", "hidden");
        $(this).children(".mp_tooltip").animate({left: -150, queue: true});
        $(this).children(".ibar_login_box").css("display", "none");
        $(this).find("a").removeClass("hover-color");
    });
    $(".quick_toggle li").mouseover(function () {
        $(this).children(".mp_qrcode").show();
    });
    $(".quick_toggle li").mouseleave(function () {
        $(this).children(".mp_qrcode").hide();
    });
</script>