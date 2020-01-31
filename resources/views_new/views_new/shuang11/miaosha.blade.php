<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <title>合纵医药电子商务采购平台-药易购</title>
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{path('js/daojishi.js')}}"></script>
    <style type="text/css">

        .nav-box{width: 1200px;height:82px;margin: 200px auto 0 auto;position: relative;}
        .nav-box .nav{width: 1000px;height: 80px;margin: 0 auto;}
        .nav-box .nav ul li{width: 500px;height: 80px;float: left;background-color: #7e1178;position: relative;cursor: pointer;line-height: 80px;opacity: 0.9;filter: alpha(opacity=90)}
        .nav-box .nav ul li a{font-size: 26px;color: #fff;padding-left: 30px;}
        .nav-box .nav ul li span{font-size: 24px;color: #ffde01;border: 2px dashed #ffde01;border-radius: 30px;position: absolute;top:15px;width: 170px;height: 48px;line-height: 48px;text-align: center;}
        .nav-box .nav ul li.nav-01 span{left: 210px;}
        .nav-box .nav ul li.nav-02 span{left: 120px;}
        .nav-box .nav ul li.nav-02 a{padding-left: 330px;}
        .nav-box .nav ul li .jx{display: none;}
        .nav-box .nav ul li .yjs{display: none;}


        .border-red {border:red;}
        .ms-right{width: 1200px;height: 80px;margin: 90px auto 0 auto;position: relative;}

        .time-item{position: absolute;left: 440px;top: 0px;}
        .time-item span{font-size: 18px;color: #f9ac06;display: block;float: left;width: 132px;margin-top:5px;text-align: right;}
        .time-item strong{font-size: 24px;color: #fff;font-weight: normal;width: 38px;height: 36px;display: block;float: left;margin: 0 28px 0 0;
            line-height: 36px;text-align: center;}


        .main-box{width: 1200px;margin: 0px auto;background-color: #e71f59;overflow: hidden;padding-bottom: 20px;}
        .main-box ul {width: 1300px;}
        .main-box ul li{width: 576px;height: 245px;background-color: #fff;border-radius: 10px;float: left;margin: 15px 0 0 15px;position: relative;}
        .main-box ul li .tp{width: 215px;height: 215px;border: 1px solid #f2f2f2;float: left;margin: 15px 15px 0 15px;}
        .main-box ul li .tp img{width: 215px;height: 215px;}
        .main-box ul li .ms{position: absolute;width: 54px;height: 54px;top:0;right: 25px;}

        .main-box .text-box{width: 290px;height: 220px;float: left;margin: 15px 20px 0 0;}
        .main-box .text-box h3{width: 230px;height: 30px;line-height: 30px;font-size: 20px;font-weight: normal;color: #996027;overflow: hidden;border-bottom: 1px solid #ebdfd4;}
        .main-box .text-box .guige{color: #996027}
        .main-box .text-box p{line-height: 24px;font-size: 14px;width: 280px;overflow: hidden;height: 24px;color: #6f6e6e;}
        .main-box .text-box p span{color: #eb294e;font-size: 20px;font-weight: bold;}
        .main-box .text-box .anniu{margin-top: 10px;}

        .nav-box .nav ul li.miaoshao-yjs{background-color: #fff6cc;}
        .nav-box .nav ul li.miaoshao-wks{background-color: #fff6cc;}
        /*.nav-box .nav ul li.miaoshao-yjs span{color: #000000;border: 2px dashed #000;}*/
        /*.nav-box .nav ul li.miaoshao-yjs a{color: #000000}*/

        .nav-box .nav ul li.miaoshao-yjs .yjs{display: block;}
        .nav-box .nav ul li.miaoshao-yjs .wks{display: none;}
        .nav-box .nav ul li.miaoshao-yjs .jx{display: none;}

        .nav-box .nav ul li.miaoshao-jx .yjs{display: none;}
        .nav-box .nav ul li.miaoshao-jx .wks{display: none;}
        .nav-box .nav ul li.miaoshao-jx .jx{display: block;}

        .nav-box .nav ul li.miaoshao-wks .yjs{display: none;}
        .nav-box .nav ul li.miaoshao-wks .wks{display: block;}
        .nav-box .nav ul li.miaoshao-wks .jx{display: none;}

    </style>

</head>
<body style="padding: 0;margin: 0;background-color:#f65382;">

<div style='background: url("{{get_img_path('images/shang12-miaosha01.jpg')}}") no-repeat scroll center top;height: 445px;min-width: 1200px;overflow: hidden;width: 100%;'>

    <div class="nav-box">
        <div class="bg-box" style="width:200px;height:120px;position:absolute;left:500px;top:-20px;z-index:9999;">
            <img src="{{get_img_path('images/shang12-miaosha02.png')}}" alt="" />
        </div>

        {{--<div class="nav">--}}

            {{--<ul>--}}
                {{--<li id="team1" class="nav-01 "><a href="javascript:;">2016-12-12</a> <span class="wks">即将开始</span><span class="jx" >在进行</span> <span class="yjs">已结束</span></li>--}}
                {{--<li id="team2" class="nav-02 miaoshao-yjs"><a href="javascript:;">2016-12-13</a> <span class="wks">敬请期待</span><span class="jx" >在进行</span> <span class="yjs">已结束</span></li>--}}

            {{--</ul>--}}

        {{--</div>--}}

        <div class="nav">
            <ul>
                @foreach($team as $k=>$v)
                    {{--<li id="team{{$k}}" class="nav-0{{$k}} @if($now_check1==2) miaoshao-yjs @elseif($now_check1==0&&$now_check==$k)  @elseif($now_check1==0&&$now_check>$k) miaoshao-yjs @elseif($now_check1==1) miaoshao-yjs @endif"><a href="javascript:;">{{$v['start']}}</a> <span class="wks">未开始</span><span class="jx" >在进行</span> <span class="yjs">已结束</span></li>--}}
                    <li id="team{{$k}}" class="nav-0{{$k}} @if($now_check1==0&&$now_check==$k) miaoshao-jx @elseif($now_check1==1||$now_check1==0&&$k>$now_check) miaoshao-wks  @else miaoshao-yjs @endif"><a href="javascript:;">{{$v['start']}}</a> <span class="wks">未开始</span><span class="jx" >在进行</span> <span class="yjs">已结束</span></li>
                @endforeach
            </ul>

        </div>

    </div>
    @foreach($team as $k=>$v)
        <div class="ms-right" id="time-item{{$k}}"  data-id="{{$v['time']}}" @if($now_check==$k) style="display: block;" @else style="display:none;" @endif>
            <div class="time-item" >
                <span class="text_wks{{$k}}" @if(($now_check<$k)||$now_check1==1) style="display: block" @else style="display: none" @endif>距离开抢还剩：</span>
                <span class="text_yks{{$k}}" @if(($now_check==$k)) style="display: block" @else style="display: none" @endif>距离结束还剩：</span>
                {{--<span>已经结束：</span>--}}
                <strong id="hour_show{{$k}}"></strong>
                <strong id="minute_show{{$k}}"></strong>
                <strong id="second_show{{$k}}"></strong>
            </div>

        </div>
    @endforeach

</div>


<div style='background: url("{{get_img_path('images/shang12-miaosha03.jpg')}}") no-repeat scroll center top;height: 1100px;min-width: 1200px;width: 100%;background-color: #f65382;padding-top: 20px;'>
    <div class="main-box">
        @foreach($team as $k=>$val)
            <ul class="list-0{{$k}}" @if($now_check==$k) style="display: block;" @else style="display:none;" @endif>
                @foreach($goods[$k] as $v)
                    <li>
                        <span class="ms"><img src="{{get_img_path('images/shuang11-miaosha05.jpg')}}" alt="" /></span>
                        <p class="tp"><img src="{{$v->goods_thumb}}" alt="" /></p>
                        <div class="text-box">
                            <h3>{{$v->goods_name}}</h3>
                            <p class="guige">{{$v->spgg}}</p>
                            <p>{{$v->product_name}}</p>
                            @if($v->goods_id!=4088)
                                <p id="kc{{$v->goods_id}}">库存：{{$v->goods_number}}</p>
                            @endif
                            <p>数量：{{$v->cart_number}}
                                @if($v->area_xg==29)
                                    <span style="float:right;margin-right: 25px;font-size: 16px;">限购四川终端</span>
                                @endif
                            </p>
                            <p style="color:#eb294e">
                                秒杀价：￥ <span>{{sprintf('%.2f',$v->real_price)}}</span>
                                <strike style="color: #666;font-size: 14px;font-weight: normal;float: right;margin-right: 25px;">原价：￥ {{sprintf('%.2f',$v->shop_price)}}</strike>
                            </p>
                            <div class="anniu">
                                <a class="btn_yks{{$k}}" type="1" id="{{$v->goods_id}}" onclick="add_to_redis({{$v->goods_id}})" href="javascript:;"  @if($now_check1==0&&$now_check>=$k) style="display:block" @else style="display:none" @endif><img src="{{get_img_path('images/shuang11-miaosha07.jpg')}}" alt="" /></a>
                                <a href="javascript:;" style="display:none"><img src="{{get_img_path('images/shuang11-miaosha08.jpg')}}" alt="" /></a>
                                <a class="btn_wks{{$k}}" href="javascript:;" @if($now_check1==0&&$now_check>=$k) style="display:none" @else style="display:block" @endif><img src="{{get_img_path('images/shuang11-miaosha09.jpg')}}" alt="" /></a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endforeach
    </div>


</div>
<input type="hidden" id="end_time" value="{{$end_time}}" now_check="{{$now_check}}" now_check1="{{$now_check1}}"/>
@include('layout.tancc')
@include('shuang11.daohang')
</body>
</html>

<script type="text/javascript">
    $(function(){
        var now_check = "{{$now_check}}";
        var now_check1 = "{{$now_check1}}";
        $(".nav-01").hover(function(){


            $(".list-01").show();
//            $(".nav ul li").css('border','2px solid #777777');
//            $(this).css('border','2px solid red');
            $(".ms-right").hide();
            $("#time-item1").show();
            $(".list-02").hide();
            $(".list-03").hide();
            $(".list-04").hide();
            $(".list-05").hide();
//            if(now_check!=1||now_check1==1) {
//                $(this).css('background-color','#f60');
//            }

        },function(){
//            if(now_check!=1||now_check1==1) {
//                $(this).css('background-color','#fff6cc');
//            }
        });

        $(".nav-02").hover(function(){


            $(".list-02").show();
//            $(".nav ul li").css('border','2px solid #777777');
//            $(this).css('border','2px solid red');
            $(".ms-right").hide();
            $("#time-item2").show();
            $(".list-01").hide();
            $(".list-03").hide();
            $(".list-04").hide();
            $(".list-05").hide();
//            if(now_check!=2) {
//                $(this).css('background-color','#f60');
//            }
        },function(){
//            if(now_check!=2) {
//                $(this).css('background-color','#fff6cc');
//            }
        });

//        $(".nav-03").hover(function(){
//            $(".list-03").show();
//            $(".nav ul li").css('border','2px solid #777777');
//            $(this).css('border','2px solid red');
//            $(".ms-right").hide();
//            $("#time-item3").show();
//            $(".list-01").hide();
//            $(".list-02").hide();
//            $(".list-04").hide();
//            $(".list-05").hide();
//
//        })
//
//        $(".nav-04").hover(function(){
//            $(".list-04").show();
//            $(".nav ul li").css('border','2px solid #777777');
//            $(this).css('border','2px solid red');
//            $(".ms-right").hide();
//            $("#time-item4").show();
//            $(".list-01").hide();
//            $(".list-02").hide();
//            $(".list-03").hide();
//            $(".list-05").hide();
//
//        })
//
//        $(".nav-05").hover(function(){
//            $(".list-05").show();
//            $(".nav ul li").css('border','2px solid #777777');
//            $(this).css('border','2px solid red');
//            $(".ms-right").hide();
//            $("#time-item5").show();
//            $(".list-01").hide();
//            $(".list-02").hide();
//            $(".list-03").hide();
//            $(".list-04").hide();
//
//        });
    });

    function add_to_redis(id){
        var type = $('#'+id).attr('type');
        var msg = $('#'+id).attr('msg');
        if(type==1) {
            $.ajax({
                url: '/buy_ms',
                data: {id: id},
                type: 'get',
                dataType: 'json',
                success: function (result) {
                    if (result) {
                        if (result.error == 1) {//未审核
                            $('#'+id).attr('type',2);
                            $('#'+id).attr('msg',result.msg);
                            $(".tab_p1").show();
                        } else if (result.error == 2) {//未登录
                            $(".tab_p2").show();
                        } else if (result.error == 0) {
                            $('#'+id).attr('type',2);
                            $('#'+id).attr('msg','商品已加入购物车');
                            $(".tab_p1").show();
                        }else if (result.error == 3) {
                            $('#'+id).attr('type',3);
                            $('#'+id).attr('msg',result.msg);
                            $(".tab_p4").show();
                        }else if (result.error == 5) {
                            $('#'+id).attr('type',5);
                            $('#'+id).attr('msg',result.msg);
                            $(".tab_p4").show();
                        }
                        $(".tip_text").html(result.msg);
                        $(".comfirm_buy").show();
                    }
                }
            })
        }else if(type==2){//不能购买了 原因是已加入购物车
            $(".tip_text").html(msg);
            $(".comfirm_buy").show();
        }else if(type==3){//不能购买了 原因是不能购买多组商品
            $(".tip_text").html(msg);
            $(".comfirm_buy").show();
        }
    }

</script>