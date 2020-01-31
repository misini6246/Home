<link href="{{path('/css/attach_left.css')}}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{path('/js/kf_top.js')}}"></script>
<style type="text/css">

    li {list-style-type:none; *list-style-type:none; }
    /* quick_links 右侧导航和浮动导航样式*/
    /* quick_links 右侧导航和浮动导航样式*/
    .quick_links_wrap,.mui-mbar-tabs{height:100%;width:40px;right:0;position:fixed;right:0;bottom:0;z-index:9;height:100%;-webkit-transition:width linear .4s;-moz-transition:width linear .4s;-ms-transition:width linear .4s;transition:width linear .4s;_position:fixed;_bottom:auto;_top:expression(documentElement.scrollTop+documentElement.clientHeight-this.offsetHeight-10);z-index: 9999999;}
    .quick_links_wraper.quick_links_dockright{margin-left:0;left:auto;right:4px;}
    .mui-mbar-tabs i,.ibar_closebtn,.login_order,.login_favorite{display:inline-block;background:url('{{path('images/ibar_sprites.png')}}')  no-repeat;cursor:pointer;height:34px;width:30px;position:absolute;}
    .quick_links_panel{width:35px;height:100%;position:absolute;background:#3a274d;z-index:2;top:0;right:0;font-family:'microsoft yahei',arial;}
    .quick_links_panel a{display:block;line-height:200px;width:35px;height:35px;text-decoration:none;color:#d8d8d8;font-size:12px;overflow:hidden;background-color:#3a274d;position:relative;overflow:hidden;top:0;left:0px;*left:-16px;z-index:1;margin:0;padding:0;}
    .quick_links_panel .tip_txt{width: 90px;height: 35px;position: absolute;left: 0 ;top:0;}

    .quick_links_panel a.my_qlinks{width:40px;height:120px;}

    .quick_links_panel .quick_toggle{position:absolute;bottom:0;left:0;width:40px;background:#3a274d;z-index:1;}
    .quick_links_panel .mp_tooltip{height:35px;line-height:35px;width:92px;position:absolute;z-index:2;left:-121px;top:0;background:#3a274d;color:#d8d8d8;text-align:center;display:block;visibility:hidden;}

    .quick_links_panel .mp_qrcode{padding:10px;width:148px;height:175px;top:-157px;background:#fff;box-shadow:0 0 5px rgba(0,0,0,.4);border-radius:5px 0 0 5px;border-left:1px solid #ccc\0;border-top:1px solid #ccc\0;border-bottom:1px solid #ccc\0;z-index:3;position:absolute;left:-168px;left:-169px\0;display:none;}
    .quick_links_panel .icon_arrow_white{position:absolute;right:-5px;top:172px;width:5px;height:9px;background-position:0 -253px;}
    .quick_links_panel .icon_arrow_right_black{position:absolute;right:-5px;top:13px;width:7px;height:14px;background-position: -37px 0; overflow:hidden;}
    .quick_toggle .return_top{display:none;}
    .quick_links_allow_gotop .return_top{display:block;}
    .quick_links{position:absolute;top:40%;left:0;margin-top:-190px;*margin-top:-220px;	background:#3a274d;z-index:2;width:40px;}
    .quick_links a.message_list{background:url('{{path('images/ibar_sprites.png')}}') no-repeat;line-height:16px;height:130px;background-position:-23px -225px;color:#fff;margin:20px 0 10px;}
    .quick_links_min .quick_links_panel{right:280px;}
    .quick_links li,.quick_toggle li{position:relative;display:block;left:0;top:0px;}
    .history_list,.leave_message,.mpbtn_wdsc{margin-bottom:6px;}
    .quick_links a.current,.quick_toggle a:hover{background:#f9a104;text-decoration:none;}
    .quick_links a.message_list .span{width:16px;display:block;height:48px;margin:38px 0 30px 12px;cursor:pointer;font-size: 12px;color: #fafecc;line-height: 16px;font-weight: bold;}
    .quick_links a.message_list .cart_num{width:22px;height:22px;display:block;border-radius:50%;background:#ffffff;text-align:center;line-height:22px;margin:-18px 0 0 7px;cursor:pointer;color:#f9a104;font-weight: bold;font-size: 12px;}
    .quick_links i.setting{background-position:0 0;width:18px;height:19px;top:10px;left:11px;}
    .quick_links .current i.setting{background-position:-33px 0;}
    .quick_links i.message{background-position:0px -26px;width:32px;height:22px;top:11px;left:5px;}
    .quick_links .current i.message{background-position:-33px -29px;}
    .quick_links i.cart{background-position:0px -29px;}
    .quick_links i.view{width:18px;height:18px;background-position:0 -57px;top:10px;left:11px;}
    .quick_links a:hover i.view,.quick_links .current i.view{background-position:-33px -57px;}
    .quick_links .qa{width:18px;height:15px;background-position:0 -85px;top:11px;left:11px;}
    .quick_links a:hover i.qa,.quick_links .current i.qa{background-position:-33px -85px;}
    .quick_links .zuji{width:11px;height:24px;background-position:-4px -110px;top:8px;left:14px;}
    .quick_links a:hover i.zuji,.quick_links .current i.zuji{background-position:-36px -110px;}
    .quick_links .chongzhi{background:url('{{path('images/chongzhi.png')}}') no-repeat;width:35px;height:35px;top:2px;left:3px;}
    .quick_links .wdsc{background:url('{{path('images/wdsc.png')}}')  no-repeat;width:35px;height:35px;top:7px;left:7px;}

    .quick_links .wdsc2{background:url('{{path('images/ibar_sprites.png')}}') 0 0 no-repeat;width:35px;height:25px;top:5px;left:6px;}
    .quick_toggle .mpbtn_qrcode{width:18px;height:18px;top:11px;left:11px;background-position:0 -302px;}
    .quick_toggle .top{background-position:0 -201px;width:17px;height:14px;top:12px;left:12px;}
    .quick_toggle a:hover .top, .quick_links a.current .top{background-position:-33px -201px;}
    .quick_toggle i.kfzx{width:30px;height:30px;top:6px;left:7px;background-position:0 -70px;}


    .mui-mbar-tabs i.setting2{background:url('{{path('images/index_bar.png')}}') no-repeat;width:32px;height:120px;top:10px;left:6px;}
    /* quick_links_pop */
    .quick_links_pop{position:absolute;top:0;right:0;display:none;box-shadow:0 0 5px #999; border-radius:5px 0 0 5px;border:1px solid #999;}
    .quick_links_pop .arrow, .quick_links_pop .arrow i{display:none;border-color:transparent #ddd;border-style:dashed solid;border-width:12px 0 12px 12px;font-size:0;height:0;width:0;position:absolute;left:100%;top:12px;}
    .quick_links_pop .arrow i{border-color:transparent #f9fafc;margin:-12px 0 0 -13px;left:0;top:0;}
    .quick_links_pop .fix_bg{display:none;border-top-width:0;border-radius:0 0 3px 3px;margin:0 0 -4px -250px;height:2px;width:500px;overflow:hidden;position:absolute;bottom:0;left:50%;}
    .quick_links_pop .pop_panel{font-size:12px;width:100%;height:628px;position:relative;}
    .quick_cart_list, .quick_history_list, .quick_links_pop .links, .quick_my_qlinks, .quick_message_list,.quick_leave_message,.quick_mpbtn_wdsc{position:absolute;width:280px;left:0;top:0;background:#fff;height:100%;display:block;}
    .quick_cart_list .user_cart_inner, .quick_history_list .history_slider{display:block;border:0;margin:0;position:static;}
    .quick_cart_list .user_cart_inner .del{display:none;}
    .quick_history_list .title i{background-position:-170px -34px;}
    .quick_leave_message .title i{background-position:-160px 0;}
    .quick_leave_message .types{font-size:0;position:absolute;left:148px;top:18px;white-space:nowrap;}
    .quick_leave_message .types input, .quick_leave_message .types label{font-size:12px;margin-right:20px;vertical-align:middle;white-space:nowrap;}
    .quick_leave_message .types input{margin:-2px 3px 0 0;height:13px;width:13px;*margin-top:0;}
    .quick_leave_message .txt{padding:15px 0;}
    .quick_leave_message .txt textarea{display:block;background:#fff;border:1px solid #e8e8e8;border-radius:3px;box-shadow:0 1px 0 #fff, inset 0 1px 4px rgba(0,0,0,.1);margin:0 auto;padding:8px;height:68px;width:90%;}
    .quick_leave_message .token{padding:0 0 14px 16px;height:26px;}
    .quick_leave_message .token input{background:#fff;border:1px solid #ddd;padding:3px 4px;width:76px;vertical-align:middle;}
    .quick_leave_message .token img{margin-left:5px;vertical-align:middle;}
    .quick_leave_message .btns{float:right;margin-top:-42px;padding-right:16px;}
    .quick_leave_message .btn{background-position:0 -356px;cursor:pointer;font-size:0;padding-left:20px;text-shadow:0 1px 0 #355ba9;overflow:visible;}
    .quick_leave_message .btn:hover{background-position:0 -386px;}
    .quick_leave_message .btn span{background-position:100% -356px;font-size:12px;padding-right:20px;*height:29px;}
    .quick_leave_message .btn:hover span{background-position:100% -386px;}
    .quick_links_pop .no_data{color:#333;font-size:14px;padding:35px 10px;text-align:center;}
    .quick_links_pop .no_data i{display:inline-block;background:url('{{path('images/cart_new.png')}}') no-repeat 0 -188px;margin:0 10px 0 0;height:36px;width:60px;vertical-align:middle;}
    .quick_links_pop .links li{border-top:1px solid #f1f1f1;vertical-align:top;}
    .quick_links_pop .links a{display:block;background:#FCFCFC;color:#333;font-size:14px;padding:12px 15px;}
    .quick_links_pop .links a:hover{background-color:#F2F3F4;color:#4467a7;}
    .quick_links_pop .links .tips{float:right;color:#61c2ed;font-size:12px;}
    .quick_my_qlinks .title i{background-position:-200px 0;height:22px;width:22px;}
    .quick_message_list .title i{background-position:-200px -34px;height:22px;width:22px;}
    .quick_message_list .no_data i{background-image:url('{{path('images/quick_links_no_msg.png')}}');background-position:0 0;height:45px;width:62px;}
    /*修改*/
    .ibar_plugin_title{height:38px;line-height:38px;border-bottom:1px solid #dedede;color:#333;font-size:14px;font-weight:700;width:267px;margin:0 auto;}
    .ibar_closebtn{width:20px;height:20px;background-position:5px -267px;padding:5px;overflow:hidden;position:absolute;top:4px;right:4px;}
    .ibar_plugin_content{position:absolute;width:100%;top:0;bottom:0;_height:expression((document.documentElement.clientHeight-100-40)+"px");overflow:hidden;}
    .ibar_cart_group{width:250px;padding:0 20px 0 10px;background:#fff;}
    .ibar_cart_group_header{height:34px;line-height:34px;border-bottom:1px solid #dedede;}
    .ibar_cart_group_title{float:left;font-size:14px;}
    .ibar_cart_group_header a{float:right;color:#ed145b}
    .ibar_cart_group_header a:hover{text-decoration:underline;}
    .cart_item{padding:15px 0;border-bottom:1px dotted #ddd;}
    .cart_item_pic{position:relative;float:left;width:87px;height:87px;}
    .cart_item_pic img{width:85px;height:85px;border:1px solid #f4f4f4;}
    .cart_item_desc{float:left;width:150px;padding:3px 0 0 10px;}
    .cart_item_name{display:inline-block;width:100%;height:36px;overflow:hidden;line-height:18px;color:#5c5c5c;}
    .cart_item_sku{width:160px;height:24px;line-height:24px;color:#999;	}
    .cart_price{color:#ed145b;font-weight:700;font-family:Arial,Helvetica;}
    .cart_handler{position:absolute;height:100px;bottom:0;width:100%;background:#fff;}
    .cart_handler_header{width:260px;margin:8px 10px;float:left;}
    .cart_handler_left{float:left;}
    .cart_handler_right{float:right;font-weight:700;font-size:16px;font-family:Arial;color:#ed145b;}
    .cart_go_btn{display:block;height:33px;line-height:33px;font-size:19px;font-family:SimHei;color:#fff;text-align:center;text-decoration:none;background:#ed145b;width:260px;margin:0 10px;float:left;}
    .cart_go_btn:hover{color:#fff;}
    .ia-head-list{height:66px;width:244px;margin-left:15px;background:#f3f3f3;overflow:hidden;zoom:1;margin-top:15px;color:#4a4a4a;}
    .ia-head-list a{color:inherit;}
    .ia-head-list .pl{width:80px;border-right:dashed 1px #ccc;height:47px;margin-top:10px;text-align:center;float:left;}
    .ia-head-list .num{font-size:16px;height:26px;font-family:arial;}
    .ia-head-list .money{border-right:0;}
    .ga-expiredsoon{width:244px;margin-left:15px;margin-top:20px;}
    .ga-expiredsoon .es-head{color:#5c5c5c;height:13px;border-left:3px solid #5c5c5c;padding-left:13px;}
    .ia-none{background:url('{{path('images/null_icon.png')}}') no-repeat center 50px;text-align:center;padding-top:150px;padding-bottom:30px;font-family:"微软雅黑";font-size:16px;color:#797979;}
    .jiaru{margin-top:40px;}
    .ibar-history-head{position:relative;font-size:14px;border-bottom:solid 1px #dedede;height:37px;line-height:37px;width:255px;margin-left:10px;}
    .ibar-history-head a{float:right;color:#ed145b;}
    .ibar-history-head a:hover{text-decoration:underline;}
    .imp_item{width:255px;padding-top:10px;border-bottom:dashed 1px #d5d5d5;overflow:hidden;padding-bottom:15px;margin-bottom:-1px;margin-left:10px;}
    .imp_item .pic{float:left;display:inline;margin-right:10px;}
    .imp_item .tit{height:40px;overflow:hidden;width:140px;word-break:break-all;}
    .imp_item .tit a{color:#5c5c5c;line-height:18px;}
    .imp_item .tit a:hover{color:#ed145b;line-height:18px;}
    .imp_item .price{color:#ed145b;font-weight:700;margin-bottom:10px;}
    .imp_item .price em{font-family:arial;font-size:14px;}
    .imp_item .imp-addCart{background:#f32166;background:-webkit-linear-gradient(top,#fb2f72,#ed145b);color:#fff;width:90px;height:28px;float:left;display:inline;line-height:28px;text-align:center;}
    .sc{float:right;line-height:22px;margin-right:7px;}
    .ibar_recharge_form{width:220px;margin:0 auto;padding:15px 0;}
    .ibar_recharge-field{border:1px solid #ddd;height:30px;margin-bottom:10px;}
    .ibar_recharge-field label{width:40px;text-align:center;color:#fff;background:#737373;line-height:30px;float:left;}
    .ibar_recharge-fl{position:relative;float:left;width:170px;padding-left:5px;}
    .ibar_recharge-iwrapper{padding-top:7px;}
    .ibar_recharge-iwrapper input{border:0;outline:0 none;}
    i.ibar_recharge-contact{width:13px;height:14px;background:url('{{path('images/contact.png')}}');top:8px;right:5px;cursor:pointer;}
    .ibar_recharge-mod{line-height:30px;color:#737373;font-weight:700;cursor:pointer;-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none;}
    i.ibar_recharge-arrow{width:6px;height:3px;background:url('{{path('images/arrow-down.png')}}');top:14px;right:8px;cursor:pointer;}
    .ibar_recharge-vbox{border:1px solid #ddd;background:#fff;position:absolute;left:0;top:30px;width:177px;}
    .ibar_recharge-vbox li{float:left;width:68px;border-right:1px solid #ddd;padding:7px 10px;line-height:1;cursor:pointer;}
    .ibar_recharge-vbox li.sanwe{border:0;}
    .ibar_recharge-vbox .selected, .ibar_recharge-vbox li:hover{background:#ececec;}
    .ibar_recharge-btn{text-align:center;padding-top:3px;}
    .ibar_recharge-btn input{border:0;color:#fff;display:inline-block;width:115px;height:31px;font-size:16px;background:#f32166;background:-webkit-linear-gradient(top,#fb2f72,#ed145b);cursor:pointer;}
    .ibar_recharge-btn input:hover{background:-webkit-linear-gradient(top,#fa578c,#f73776);}
    .ibar_login_box{width:137px;height:227px;z-index:3;position:absolute;top:0px;left:-133px;display:none;}
    .ibar_login_box .avatar_box{width:142px;overflow:hidden;height:200px;}
    .status_login .avatar_imgbox{float:left;margin:6px 20px 0 5px;display:inline;}
    .ibar_login_box .avatar_imgbox{width:100px;height:100px;border-radius:50%;overflow:hidden;}
    .online_service{background: url('{{path('images/kefu.png')}}') no-repeat;height: 227px;position:relative;}
    .online_service a{background-color: transparent;}
    .online_service a:hover{background-color: transparent;}
    .online_service .services1 a{position: absolute;width: 99px;height: 28px;left: 16px;top: 10px;cursor: pointer;background: url('{{path('images/kefu_03.png')}}') no-repeat;}
    .online_service .services1 a:hover{background: url('{{path('images/kefu_030.png')}}') no-repeat;}
    .online_service .services2 a{position: absolute;width: 99px;height: 28px;left: 16px;top: 43px;cursor: pointer;background: url('{{path('images/kefu_06.png')}}') no-repeat;}
    .online_service .services2 a:hover{background: url('{{path('images/kefu_031.png')}}') no-repeat;}
    .online_service .services3 a{position: absolute;width: 99px;height: 28px;left: 16px;top: 76px;cursor: pointer;background: url('{{path('images/kefu_08.png')}}') no-repeat;}
    .online_service .services3 a:hover{background: url('{{path('images/kefu_032.png')}}') no-repeat;}

    .subMenu {display: none;position: absolute;top: 462px;height: 40px;z-index: 1000;width: 100%;left: 0}
    .subMenu-box{width: 1200px;margin:0 auto; height: 40px;z-index: 99999;position: relative;}
    .subMenu-box .sub-logo{width: 148px;height: 35px;position: absolute;left: 30px;top:3px;*top:-36px;}
    .subMenu-box .sub-search{width:680px;float: left;height: 40px;}
    .subMenu .bg{background: #61c240;width: 100%;opacity: 0.9;height: 40px;position: absolute;*position: relative;}
    .search_box_top {margin-top: 3px;position: absolute;left: 365px;top: 1px;*top:-38px;}
    .sub-search  input{width: 542px;height: 14px;border: 2px solid #fbb925;color: #333;text-indent: 10px;line-height: 14px;float: left;padding: 7px 0 ;}
    .sub-search  a.btn{display: block;width: 90px;height: 32px;background-color: #fbb925;color: #fff;font-size: 14px;text-align: center;line-height: 32px;float: left;font-weight: bold;}
    .sub-search  .list_box{width: 375px;border: 1px solid #fbb925;border-top: 0;position: absolute;top:32px;left: 0;display: none;background-color: #fff;z-index: 9999;}
    .sub-search .text{color: #2c8313;text-align: right;padding-top: 10px;}
    .sub-search .search_show2{display:block;width:537px; padding:2px 3px; border:1px solid #fbb925; position:absolute; z-index:10000; left:0; top:32px; background:#FFF;}
    .sub-search .search_list{width:536px; font-size:14px; border-top:1px solid #F3F3F3; }
    .sub-search .search_list li{color:#333;height:30px; line-height:30px; border-bottom:1px solid #F3F3F3; padding:0 5px 0 5px;}
    .sub-search .search_list li.active{background:#fbd887;}
    .sub-search .search_list li a{float:left; color:#8F8F8F;text-decoration:none;width:100%;}
    .sub-search .search_list li span{float:right; font-size:12px; color:#8F8F8F;}
    .sub-search .search_title{height: 36px;line-height: 36px;color: #5e5e5e;}
    .sub-search .search_title a{color: #5e5e5e;padding-right: 12px;}
    .sub-search .search_title a:hover{color:#e70000;}
    .hover-color{background-color: #f9a104 !important;}
    .quick_links_panel .tip_txt{width: 90px;height: 35px;}



    .services1, .services2, .services3 {
        height: 29px;
        width: 122px;
        margin: 5px auto 0px;
        text-align: center;
        background: transparent url("{{path('images/online_bg.png')}}") no-repeat scroll -38px -125px;
    }


    #shares .shares4 { position:absolute; bottom:200px;
        background-image: url({{get_img_path('/images/44.jpg')}});}
</style>
@include('layout.xinend')
<!--底部开始-->
<div class="footer fn_clear">
    <div class="collaboration_unit">
        <div class="more"><!--<a href="article_cat.php?id=1">更多 >></a>--></div>
        <div class="title_box"><h3><img src="{{path('images/title4.png')}}" alt="合作媒体" title="合作媒体" /></h3></div>
        <ul class="unit fn_clear">
            @foreach(friend_link('img') as $k=>$v)

                <li @if($k==5) class="end" @endif><a href="{{$v->link_url}}" target="_blank" title="{{$v->link_name}}"><img src="{{$v->link_logo}}" alt="{{$v->link_name}}"/></a></li>

            @endforeach
        </ul>
    </div>
    <div class="footer_box fn_clear">
        <div class="footer_list">
            <ul class="ul_title">
                <li><a href="{{route('article.index',['id'=>5])}}"><img src="{{path('images/about1.png')}}" alt=""/></a></li>
                <li><a href="{{route('article.index',['id'=>7])}}"><img src="{{path('images/about2.png')}}" alt=""/></a></li>
                <li><a href="{{route('article.index',['id'=>8])}}"><img src="{{path('images/about3.png')}}" alt=""/></a></li>
                <li><a href="{{route('article.index',['id'=>9])}}"><img src="{{path('images/about4.png')}}" alt=""/></a></li>
            </ul>
            <ul class="ul_list_2">
                @foreach(shop_help() as $v)
                    <li class="children">
                        @foreach($v->article as $val)
                            <p><a href="{{route('articleInfo',['id'=>$val->article_id])}}" title="{{$val->title}}">{{$val->title}}</a></p>
                        @endforeach
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <ul class="wechat fn_clear">
        <li class="li_first">
            <a><img src="{{path('images/bottom1.png')}}" alt="二维码"/></a>
            <div class="wechat_box">
                <h4>药易购官方微博</h4>
                <p>促销新品、新闻资讯早知道</p>
            </div>
        </li>
        <li>
            <a><img src="{{path('images/bottom2.png')}}" alt="二维码"/></a>
            <div class="wechat_box">
                <h4>药易购官方微信</h4>
                <p>万千优惠资讯抢先收到</p>
            </div>
        </li>

    </ul>
    <div class="footer_bottom">
        <div class="title">
            @foreach(nav_list('bottom') as $v)
                <a href="{{$v->url}}" @if($v->opennew==1) target="_blank" @endif>{{$v->name}}</a>
            @endforeach
        </div>
        <div class="title">
            <a href="{{path('images/zgz1.jpg')}}" target='_blank'>互联网药品交易服务资格证：川B20130002 </a>|<a href="{{path('images/zgz2.jpg')}}" target='_blank'>互联网药品信息服务资格证：川20150030</a>
        </div>
        <div class="title"><a href="http://www.hezongyy.com/" target="_blank">版权所有 {{date('Y')}} 合纵医药网—药易购 www.hezongyy.com </a>ICP备案证书号:蜀ICP备14007234号-1</div>
        <div class="title">
            <a>本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</a>
        </div>

        <ul class="papers fn_clear">
            <!--<li><img src="./themes/yiyao/images/bottom4.png"/></li>
            <li><img src="./themes/yiyao/images/bottom5.png"/></li>
            <li><img src="./themes/yiyao/images/bottom6.png"/></li>-->
            <li><a key="55b87665efbfb03c90330bde" logo_size="124x47" logo_type="business" href="http://www.anquan.org">
                    <script src="http://static.anquan.org/static/outer/js/aq_auth.js"></script>
                </a></li>
            <li><a href="javascript:;"><img border="0" src="http://img.webscan.360.cn/status/pai/hash/73cfbd5da0efa9f632172da914817fed"/></a></li>
            <li><a href="javascript:;"><img src="{{path('images/bottom3.png')}}"/></a></li>
            <li><a href="https://search.szfw.org/cert/l/CX20150626010878010620" target="_blank"><img src="{{path('images/bottom8.png')}}" width="127" height="47"/></a></li>
        </ul>
    </div>

</div>

<!--底部结束-->

<!--<div id="zhebi_1" class="zhebi"></div>
<div id="detail_1" class="detail">
    <div class="success-b">
        <h3>商品已成功加入购物车！</h3>
    </div>
    <div style="float: left;margin-left: 55px;margin-top: 30px;">
        <a class="btn-pay" href="flow.php" id="GotoShoppingCart">去结算</a>
        <a class="btn-continue" onclick="yincang_1()">继续购物</a>
    </div>
</div>-->


<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1252987830'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s19.cnzz.com/stat.php%3Fid%3D1252987830%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>

{{--<!-- WPA Button Begin -->--}}
{{--<script charset="utf-8" type="text/javascript" src="http://wpa.b.qq.com/cgi/wpa.php?key=XzkzODE2NjI1Ml80MDk2MDhfNDAwNjAyODI2Ml8"></script>--}}
{{--<!-- WPA Button END -->--}}


<!-- 收藏弹出层部分begin -->
<div class="comfirm_buy" style="display:none;" id="collect_box">
    <div class="content_buy" ><a href="#" class="success"></a>
        <h4>&nbsp;</h4>
        <p class="collect_p">
            <span class="collect_text"> 共收藏 <span class="num">0</span>  件商品</span>
            <a href="{{route('user.collectList')}}" class="click_me">查看我的收藏 &gt;</a>
        </p>

        <p class="login_p login_p2" style="display:none;">
            <a href="/auth/login" class="login_a" >登陆</a> <a href="/auth/register">注册</a>
        </p>
        <span class="close2"></span>
    </div>
</div>
<!-- 弹出层部分end -->

<!-- 加入购物车弹出层begin -->
<div class="comfirm_buy" style="display:none;" id="shopping_box">
    <div class="content_buy" ><a href="#" class="success"></a>
        <h4>&nbsp;</h4>
        <p class="tip_txt" alt="" title="">&nbsp;</p>

        <p class="login_p tab_p1" style="display: none;">
            <a class="login_a again" >继续购物</a> <a href="/cart">去结算 ></a>
        </p>

        <p class="login_p tab_p2" style="display: none;">
            <a href="/auth/login" class="login_a" >登陆</a> <a href="/auth/register">注册</a>
        </p>

        <p class="login_p tab_p3" style="display: none;">
            <a href="requirement.php" class="login_a" >去登记</a> <a class="login_a again">取消</a>
        </p>

        <p class="login_p tab_p4" style="display: none;">
            <a class="login_a confirm again">确认</a>
        </p>

        <p class="login_p tab_p5" style="display: none;">
            <a href="#" class="login_a confirm">确认</a>
        </p>

        <span class="close2"></span>
    </div>
</div>
<!-- 加入购物车弹出层end -->


<!-- 购物删除弹出层begin -->
<div class="comfirm_buy" id="shopping_box4">
    <div class="content_buy" ><a href="#" class="question"></a>

        <h3>删除商品？</h3>
        <p class="txt_tip">您可以选择移到收藏，或删除商品。</p>


        <p class="del_p">
            <a href="" class="del2">删 除</a>
            <a href="" class="remove_col">移到我的收藏</a>
        </p>

        <span class="close2"></span>
    </div>
</div>
<!-- 购物删除弹出层end -->

<!-- 购物移到收藏弹出层begin -->
<div class="comfirm_buy" id="shopping_box5">
    <div class="content_buy" ><a href="#" class="question"></a>
        <h3>移到收藏？</h3>
        <p class="txt_tip">移动后该商品将不在购物车中显示。</p>
        <p class="del_p">
            <a href="" class="confirm_cc">确定</a>
            <a href="javascript:void(0); " class="cancel">取消</a>
        </p>
        <span class="close2"></span>
    </div>
</div>
<!-- 购物移到收藏弹出层end -->
<div class="alert_mark" style="display:none;">
    <div class="content_l" >
        <div class="mark_box">
            <span class="close"> </span>
            <p class="feed_back">支付反馈</p>
            <div class="info_m">
                <p>请您在新打开的网上银行页面进行支付，支付完成后选择：</p>
                <p class="text"> <span class="suc_ico ico"></span> 支付成功： <a href="{{route('user.orderList')}}">查看订单</a> <a href="{{route('index')}}">继续购物</a> </p>
                <p class="text"> <span class="fail_ico ico"></span> 支付失败： <a href="{{route('articleInfo',['id'=>49])}}">查看支付帮助</a>  </p>
            </div>


        </div>
    </div>
</div>
<div class="content_mark_div"></div>
{{--右侧导航--}}
{{--<div class="mui-mbar-tabs">--}}
    {{--<div class="quick_link_mian">--}}
        {{--<div class="quick_links_panel">--}}
            {{--<div id="quick_links" class="quick_links">--}}
                {{--<li>--}}
                    {{--<a href="#" class="my_qlinks"><i class="setting2"></i></a>--}}
                    {{--<div class="ibar_login_box status_login">--}}
                        {{--<div class="online_service">--}}
                            {{--<div class="services1"><a href="http://wpa.qq.com/msgrd?v=1&amp;uin=2504509347&amp;site=qq&amp;menu=yes" target="_blank" title="2504509347">业务咨询</a></div>--}}
                            {{--<div class="services2"><a href="http://wpa.qq.com/msgrd?v=1&amp;uin=3170342955&amp;site=qq&amp;menu=yes" target="_blank" title="3170342955">售后处理</a></div>--}}
                            {{--<div class="services3"><a href="http://wpa.qq.com/msgrd?v=1&amp;uin=1518530909&amp;site=qq&amp;menu=yes" target="_blank" title="1518530909">新疆办事处</a></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</li>--}}

                {{--<li style="margin-top:30px;">--}}
                    {{--<a href="{{route('user.index')}}" class="mpbtn_wdsc"><i class="wdsc2"></i></a>--}}
                    {{--<div class="mp_tooltip"><a href="{{route('user.index')}}" class="tip_txt"><img src="{{path('images/bar_1.jpg')}}"></a><i class="icon_arrow_right_black"></i></div>--}}
                {{--</li>--}}

                {{--<li id="shopCart">--}}
                    {{--<a href="{{route('cart.index')}}" class="message_list" ><i class="message"></i><div class="span">购物车</div><span class="cart_num">{{cart_info()}}</span></a>--}}
                {{--</li>--}}


                {{--<li>--}}
                    {{--<a href="{{route('user.collectList')}}" class="mpbtn_wdsc"><i class="wdsc"></i></a>--}}
                    {{--<div class="mp_tooltip"><a href="{{route('user.collectList')}}" class="tip_txt"><img src="{{path('images/bar_2.jpg')}}"></a><i class="icon_arrow_right_black"></i></div>--}}
                {{--</li>--}}

            {{--</div>--}}
            {{--<div class="quick_toggle">--}}
                {{--<li>--}}
                    {{--<a href="#" id="totop"><i class="kfzx"></i></a>--}}
                    {{--<div class="mp_tooltip"><a href="#" class="tip_txt"><img src="{{path('images/bar_3.jpg')}}"></a><i class="icon_arrow_right_black"></i></div>--}}
                {{--</li>--}}


            {{--</div>--}}
        {{--</div>--}}
        {{--<div id="quick_links_pop" class="quick_links_pop hide"></div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--头部浮动导航--}}
{{--<!-- 浮动导航 -->--}}
{{--<div class="subMenu" style="position: fixed; top: 0px;">--}}
    {{--<div class="bg"></div>--}}
    {{--<div class="subMenu-box">--}}
        {{--<div class="sub-logo"><img src="{{path('images/sub_logo.png')}}"></div>--}}
        {{--<div class="sub-search">--}}
            {{--<div class="search_box_top fn_clear">--}}
                {{--<input name="userSearch" type="text" value="药品名称(拼音缩写)" class="search_input suggest" id="top_suggest">--}}
                {{--<a href="javascript:void(0)" class="btn search_btn">搜 索</a>--}}
                {{--<div class="search_show2 list_box suggestions_wrap" style="display: none;" id="top_suggestions_wrap">--}}
                    {{--<ul class="search_list suggestions" id="top_suggestions">--}}

                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}


        {{--</div>--}}

    {{--</div>--}}

{{--</div>--}}
<!-- 浮动导航 -->
<div class="services fn_clear" id="services">
    <div class="services_left">
    </div>
    <div class="services_right">

        <a href="tencent://message/?Menu=yes&amp;amp;uin=938166252&amp;amp;Service=58&amp;amp;SigT=A7F6FEA02730C988FE226797C0B95D7AFCA959D28B4E77979C6D04C0AAEB62D25A9FF4950D78F6C1E478EB2F8EFC784BC3FFC6F5B686951524A61AB71669EA02584A645691C3CC4B4EB9CF6248585DEBB2D22E2654E14EAEF984ABEEF3175E50F9800CB112AA3A6A0D9941CAF1E0077A815937C9FB9856D2&amp;amp;SigU=30E5D5233A443AB23FA5C0A1BBC798514FB096DD40DF6F6A43F9D9FDC1F748A945AF974A1161BF3B4D57E4D21CEE925439530987AC96F6A712FB096C22E5A759456CF8D46A328790" target="_blank" title="2504509347"></a>


    </div>
</div>
<div id="shares">
    {{--<a href="http://www.jsform.com/web/formview/576b40930cf2a6c7ca295bfd" target="_blank" class="shares4" title="问卷调查"></a>--}}
    <a href="{{route('cart.index')}}" target="_blank" class="shares1" title="购物车"></a>
    <a href="{{route('user.index')}}"  target="_blank" class="shares2" title="个人中心"></a>
    <a href="{{route('user.collectList')}}"  target="_blank" class="shares3" title="我的收藏"></a>
    <a id="totop" title="返回顶部">返回顶部</a>
</div>
<script type="text/javascript">
    // 右侧导航
    $(".quick_links_panel li").mouseenter(function(){
        $(this).children(".mp_tooltip").animate({left:-92,queue:true});
        $(this).children(".mp_tooltip").css("visibility","visible");
        $(this).children(".ibar_login_box").css("display","block");
        $(this).find("a").addClass("hover-color");
    });
    $(".quick_links_panel li").mouseleave(function(){
        $(this).children(".mp_tooltip").css("visibility","hidden");
        $(this).children(".mp_tooltip").animate({left:-121,queue:true});
        $(this).children(".ibar_login_box").css("display","none");
        $(this).find("a").removeClass("hover-color");
    });
    $(".quick_toggle li").mouseover(function(){
        $(this).children(".mp_qrcode").show();
    });
    $(".quick_toggle li").mouseleave(function(){
        $(this).children(".mp_qrcode").hide();
    });

    $(window).scroll(function () {

        if (( $(window).scrollTop()) >=  400) {
            $(".subMenu").show()
        }else{
            $(".subMenu").hide()

        }
    });



</script>
<script>
    $(".phone-app").hover(function () {

        $(this).addClass("a_tab2");

        $(".app-ewm").show();

        $(this).css({

            "color":"#6c6c6c"

        });

    }, function () {

        $(".app-ewm").hide();

        $(this).removeClass("a_tab2");

    });

</script>

<script type="text/javascript">
    $(function () {
        $(".saoma-box span").click(function () {
            $(".saoma").hide();
        })
    })

</script>