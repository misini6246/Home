<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <title>合纵医药电子商务采购平台-药易购</title>
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{path('js/daojishi2.js')}}"></script>
    <script type="text/javascript" src="{{path('js/tanchuc.js')}}"></script>
    <style type="text/css">

        .nav-box{width: 1200px;height:82px;margin: 200px auto 0 auto;position: relative;}
        .nav-box .nav{width: 1000px;height: 80px;margin: 0 auto;}
        .nav-box .nav ul li{width: 500px;height: 80px;float: left;position: relative;cursor: pointer;line-height: 80px;opacity: 0.9;filter: alpha(opacity=90)}
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
        .main-box .text-box h3{width: 240px;height: 30px;line-height: 30px;font-size: 20px;font-weight: normal;color: #996027;overflow: hidden;border-bottom: 1px solid #ebdfd4;}
        .main-box .text-box .guige{color: #996027}
        .main-box .text-box p{line-height: 24px;font-size: 14px;width: 280px;overflow: hidden;height: 24px;color: #6f6e6e;}
        .main-box .text-box p span{color: #eb294e;font-size: 20px;font-weight: bold;}
        .main-box .text-box .anniu{margin-top: 10px;}

        .nav-box .nav ul li.miaoshao-yjs{background-color: #fff6cc;}
        .nav-box .nav ul li.miaoshao-wks{background-color: #fff6cc;}
        .nav-box .nav ul li.miaoshao-xz{background-color: #7e1178;}
        .nav-box .nav ul li.miaoshao-wxz{background-color: #fff6cc;}
        .nav-box .nav ul li.miaoshao-wxz span{color: #000000;border: 2px dashed #000;}
        .nav-box .nav ul li.miaoshao-wxz a{color: #000000}


        .nav-box .nav ul li.miaoshao-yjs .yjs{display: block;}
        .nav-box .nav ul li.miaoshao-yjs .wks{display: none;}
        .nav-box .nav ul li.miaoshao-yjs .jx{display: none;}

        .nav-box .nav ul li.miaoshao-jx .yjs{display: none;}
        .nav-box .nav ul li.miaoshao-jx .wks{display: none;}
        .nav-box .nav ul li.miaoshao-jx .jx{display: block;}

        .nav-box .nav ul li.miaoshao-wks .yjs{display: none;}
        .nav-box .nav ul li.miaoshao-wks .wks{display: block;}
        .nav-box .nav ul li.miaoshao-wks .jx{display: none;}
        .bg{position:absolute;left:16px;bottom:16px;width:215px;height:80px;font-size:30px;color:#fff;line-height:80px;text-align:center;background-color:#000;opacity:0.5;filter: alpha(opacity=50)}
        .yw{position:absolute;left:16px;bottom:16px;width:215px;height:80px;font-size:30px;color:#fff;line-height:80px;text-align:center;}
    </style>

</head>
<body id="body" style="padding: 0;margin: 0;background-color:#f65382;">

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
                @foreach($team as $v)
                    {{--<li id="team{{$v->team}}" class="nav-0{{$v->team}} @if($now_check1==2) miaoshao-yjs @elseif($now_check1==0&&$now_check==$v->team)  @elseif($now_check1==0&&$now_check>$v->team) miaoshao-yjs @elseif($now_check1==1) miaoshao-yjs @endif"><a href="javascript:;">{{$v['start']}}</a> <span class="wks">未开始</span><span class="jx" >在进行</span> <span class="yjs">已结束</span></li>--}}
                    <li start="{{$v->start}}" end="{{$v->end}}"  id="team{{$v->team}}" class="nav-0{{$v->team}} @if($v->hd_status==2) miaoshao-yjs miaoshao-wxz @elseif($v->hd_status==0||$now_check>$v->team) miaoshao-wks @if($now_check==0&&$v->team==1)  miaoshao-xz @else miaoshao-wxz @endif @else miaoshao-jx miaoshao-xz @endif"><a href="javascript:;">{{date('Y-m-d',$v->start)}}</a> <span class="wks">未开始</span><span class="jx" >在进行</span> <span class="yjs">已结束</span></li>
                @endforeach
            </ul>

        </div>

    </div>
    @foreach($team as $v)
        <div id="time-box{{$v->team}}" class="time-box" @if($now_check==$v->team) style="display: block;" @elseif($v->hd_status!=2||$now_check==-1) style="display: block;" @else style="display:none;" @endif>
            <div class="ms-right" id="time-item{{$v->team}}0"  data-id="{{$v->time}}" @if($v->hd_status==0) style="display: block;" @else style="display:none;" @endif>
                <div class="time-item" >
                    <span class="text_wks{{$v->team}}0">距离开抢还剩：</span>
                    <strong id="hour_show{{$v->team}}0"></strong>
                    <strong id="minute_show{{$v->team}}0"></strong>
                    <strong id="second_show{{$v->team}}0"></strong>
                </div>
            </div>
            <div class="ms-right" id="time-item{{$v->team}}1"  data-id="{{$v->time}}" @if($now_check==$v->team&&$v->hd_status==1) style="display: block;" @else style="display:none;" @endif>
                <div class="time-item" >
                    <span class="text_yks{{$v->team}}1">距离结束还剩：</span>
                    <strong id="hour_show{{$v->team}}1"></strong>
                    <strong id="minute_show{{$v->team}}1"></strong>
                    <strong id="second_show{{$v->team}}1"></strong>
                </div>

            </div>
            <div class="ms-right" id="time-item{{$v->team}}2"  data-id="{{$v->time}}" @if($v->hd_status==2) style="display: block;" @else style="display:none;" @endif>
                <div class="time-item" >
                    <span class="text_yjs{{$v->team}}2">已经结束：</span>
                    <strong id="hour_show{{$v->team}}2"></strong>
                    <strong id="minute_show{{$v->team}}2"></strong>
                    <strong id="second_show{{$v->team}}2"></strong>
                </div>

            </div>
        </div>
    @endforeach

</div>


<div style='background: url("{{get_img_path('images/shang12-miaosha03.jpg')}}") no-repeat scroll center top;height: 1100px;min-width: 1200px;width: 100%;background-color: #f65382;padding-top: 20px;'>
    <div class="main-box">
        @foreach($team as $val)
            <ul class="list-0{{$val->team}}" @if($now_check==$val->team) style="display: block;" @elseif($val->team==1) style="display: block;"  @else style="display:none;" @endif>
                @foreach($val->goods as $v)
                    <li>
                        <span class="ms"><img src="{{get_img_path('images/shuang11-miaosha05.jpg')}}" alt="" /></span>
                        <p class="tp"><img src="{{$v->goods_thumb}}" alt="" /></p>
                        <div class="yqg{{$v->goods_id}}" style="display: none;">
                            <div class="bg"></div> <p class="yw">已抢完</p>
                        </div>
                        <div class="text-box">
                            <h3>{{$v->goods_name}}</h3>
                            <p class="guige">{{$v->spgg}}</p>
                            <p>{{$v->product_name}}</p>
                            @if($v->goods_id!=4088)
                                <p id="kc{{$v->goods_id}}">库存：{{$v->goods_number}}</p>
                            @endif
                            <p>数量：{{$v->cart_number}}
                                @if(count($v->area_xg)>0)
                                    <span style="float:right;margin-right: 25px;font-size: 16px;">{{$v->xg_tip}}</span>
                                @endif
                            </p>
                            <p style="color:#eb294e">
                                秒杀价：￥ <span>{{sprintf('%.2f',$v->real_price)}}</span>
                                <strike style="color: #666;font-size: 14px;font-weight: normal;float: right;margin-right: 25px;">原价：￥ {{sprintf('%.2f',$v->shop_price)}}</strike>
                            </p>
                            <div class="anniu pt_btn{{$v->goods_id}}">
                                <a class="btn{{$v->team}}1" type="1" id="{{$v->goods_id}}" onclick="add_to_redis({{$v->goods_id}})" href="javascript:;"  @if($val->hd_status==1) style="display:block" @else style="display:none" @endif><img src="{{get_img_path('images/shuang11-miaosha07.jpg')}}" alt="" /></a>
                                <a class="btn{{$v->team}}2" href="javascript:;" @if($val->hd_status==2) style="display:block" @else style="display:none" @endif><img src="{{get_img_path('images/shuang11-miaosha08.jpg')}}" alt="" /></a>
                                <a class="btn{{$v->team}}0" href="javascript:;" @if($val->hd_status==0) style="display:block" @else style="display:none" @endif><img src="{{get_img_path('images/shuang11-miaosha09.jpg')}}" alt="" /></a>
                            </div>
                            <div class="anniu yqg_btn{{$v->goods_id}}" style="display: none;">
                                <a href="javascript:;"><img src="{{get_img_path('images/shuang11-miaosha08.jpg')}}" alt="" /></a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <input type="hidden" id="end_time{{$v->team}}" value="{{$val->time}}" now_check="{{$now_check}}" team="{{$val->team}}" hd_status="{{$val->hd_status}}"/>
        @endforeach
    </div>


</div>
@include('shuang11.daohang')
</body>
</html>

<script type="text/javascript">
    $(function(){

        $('.nav ul li').hover(function(){
            var index = parseInt($(this).index());
            index++;
            check_ms(index);
            $('.nav ul li').removeClass('miaoshao-xz').addClass('miaoshao-wxz');
            $(this).removeClass('miaoshao-wxz').addClass('miaoshao-xz');
        });
    });

    function check_ms(team,color){
        $(".time-box").hide();
        $("#time-box"+team).show();
        $(".main-box ul").hide();
        $(".list-0"+team).show();
    }
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
                        add_tanchuc(result.msg);
                        $('#'+id).attr('type',result.error)
                    }
                }
            })
        }else{
            $(".tip_text").html('商品已加入购物车');
            $(".tanchuc").show();
        }
    }

</script>