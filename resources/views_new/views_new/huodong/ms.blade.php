
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <title>合纵医药电子商务采购平台-药易购</title>
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('js/jquery.min.js')}}"></script>

    <style type="text/css">
        .ms-left span,.time-item span{font-size: 40px;color: #fff;}
        .time-item strong{font-size: 40px;color: #fdf404;font-weight: normal;}
        .list-first {width: 1200px;}
        .list-first li{width: 600px;height: 285px;float: left;margin-bottom: 10px;position: relative;}


        .list-first li .li-box img{width: 600px;height: 285px;}

        .list-first li .li-box p{line-height: 20px;color: #6f6e6e;position: absolute;left: 320px;top: 124px;font-size: 12px;}


        .list-first li .li-box  .shopping-btn{display: block;width: 206px;height: 27px;position: absolute;left: 280px;top:215px;}
        .list-first li .li-box  .shopping-btn img{width: 206px;height: 27px;}
        #qixi-daohang {position:fixed;_position:absolute;_top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight)-100+"px");bottom:100px;right:2px;width:122px;zoom:1;height: 427px; background:url(./images/tejia-xf.png) no-repeat;margin: 10px }

    </style>

</head>
<body style="padding: 0;margin: 0;background-color: #dd103b;">
<div style='background: url("{{get_img_path('images/ms01.jpg')}}") no-repeat scroll center top;height: 480px;min-width: 1200px;overflow: hidden;width: 100%;'>
</div>
<div class="site-content-box" style="width: 1200px;margin: 0 auto;">

    <div class="site-first">
        <div class="ms-title" style='width: 1200px; height: 100px;background: url("{{get_img_path('images/ms02.jpg')}}") no-repeat;'>
            <div class="ms-left" style="width: 600px;float: left;height: 100px;line-height: 104px;text-indent: 35px;">
                <span class="title-txt">准点秒杀：</span><span class="time" style="color: #fdf404;">9:00</span>
            </div>

            <div class="ms-right" style="width: 600px;float: left;height: 100px;line-height: 104px;text-indent: 10px">
                <div class="time-item" id="time-item"  >
                    {{--@if($time1>0)--}}
                    {{--<span >距离开抢还剩：</span>--}}
                    {{--@elseif($time1<=0)--}}
                    {{--<span>距离结束还剩：</span>--}}
                    {{--@endif--}}
                    {{--<span style="display: none">已经结束：</span>--}}
                    {{--<strong id="hour_show"></strong> <span>时</span>--}}
                    {{--<strong id="minute_show"></strong> <span>分</span>--}}
                    {{--<strong id="second_show"></strong> <span>秒</span>--}}
                </div>

            </div>

        </div>

        <div class="good-list" style="margin-top: 10px;width: 1200px;overflow: hidden;">
            <ul class="list-first fn_clear" >


                <li>
                    <div class="li-box">
                        <a href='javascript:;'><img src="{{get_img_path('images/miaosha01.png')}}" alt=""/></a>

                        <p>0</p>

                            {{--<a id="2213_1" href='javascript:;' class="shopping-btn"  @if($time1>0) @else style="display: none;"@endif>--}}
                                {{--<img src="{{get_img_path('images/ms03.jpg')}}" alt=""/>--}}
                            {{--</a>--}}

                            {{--<a href='javascript:;' class="shopping-btn" @if($time1<=0)  @else style="display: none;" @endif onclick="add_to_redis(2213)" id="2213" type="1">--}}
                                {{--<img src="{{get_img_path('images/ms04.jpg')}}" alt=""/>--}}
                            {{--</a>--}}

                        <a id="2213_3" href='javascript:;' class="shopping-btn"  >
                            <img src="{{get_img_path('images/ms05.jpg')}}" alt=""/>
                        </a>

                    </div>
                </li>
                <li>
                    <div class="li-box">
                        <a href='javascript:;'><img src="{{get_img_path('images/miaosha02.png')}}" alt=""/></a>

                        <p>0</p>

                        {{--<a id="15932_1" href='javascript:;' class="shopping-btn"  @if($time1>0) @else style="display: none;"@endif>--}}
                            {{--<img src="{{get_img_path('images/ms03.jpg')}}" alt=""/>--}}
                        {{--</a>--}}

                        {{--<a href='javascript:;' class="shopping-btn" @if($time1<=0) @else style="display: none;" @endif onclick="add_to_redis(15932)"  id="15932" type="1" >--}}
                            {{--<img src="{{get_img_path('images/ms04.jpg')}}" alt=""/>--}}
                        {{--</a>--}}

                        <a id="15932_3" href='javascript:;' class="shopping-btn"  >
                            <img src="{{get_img_path('images/ms05.jpg')}}" alt=""/>
                        </a>

                    </div>
                </li>


            </ul>


        </div>
    </div>
    <div class="site-two" style="margin: 10px auto ">
        <div class="ms-title" style='width: 1200px; height: 100px;background: url("{{get_img_path('images/ms02.jpg')}}") no-repeat;'>
            <div class="ms-left" style="width: 600px;float: left;height: 100px;line-height: 104px;text-indent: 35px;">
                <span class="title-txt">准点秒杀：</span><span class="time" style="color: #fdf404;">13:00</span>
            </div>

            <div class="ms-right" style="width: 600px;float: left;height: 100px;line-height: 104px;text-indent: 10px;">
                <div class="time-item" id="time-item2"  >
                    @if($time2>0)
                        <span >距离开抢还剩：</span>
                    @elseif($time2<=0)
                        <span>距离结束还剩：</span>
                    @endif
                    <span style="display: none">已经结束：</span>
                    <strong id="hour_show2"></strong> <span>时</span>
                    <strong id="minute_show2"></strong> <span>分</span>
                    <strong id="second_show2"></strong> <span>秒</span>
                </div>

            </div>
        </div>
        <div class="good-list" style="margin-top: 10px;width: 1200px;overflow: hidden;">
            <ul class="list-first fn_clear" >
                <li>
                    <div class="li-box">
                        <a href='javascript:;'><img src="{{get_img_path('images/miaosha03.png')}}" alt=""/></a>

                        <p>0</p>


                        {{--<a id="14417_1" href='javascript:;' class="shopping-btn"  @if($time2>0) @else style="display: none;"@endif>--}}
                            {{--<img src="{{get_img_path('images/ms03.jpg')}}" alt=""/>--}}
                        {{--</a>--}}

                        {{--<a href='javascript:;' class="shopping-btn" @if($time2<=0)  @else style="display: none;" @endif onclick="add_to_redis(14417)" id="14417" type="1">--}}
                            {{--<img src="{{get_img_path('images/ms04.jpg')}}" alt=""/>--}}
                        {{--</a>--}}

                        <a id="14417_3" href='javascript:;' class="shopping-btn"  >
                            <img src="{{get_img_path('images/ms05.jpg')}}" alt=""/>
                        </a>

                    </div>
                </li>
                <li>
                    <div class="li-box">
                        <a href='javascript:;'><img src="{{get_img_path('images/miaosha04.png')}}" alt=""/></a>

                        <p>{{$ms4->goods_number or 0}}</p>

                        <a id="3279_1" href='javascript:;' class="shopping-btn"  @if($time2>0) @else style="display: none;"@endif>
                            <img src="{{get_img_path('images/ms03.jpg')}}" alt=""/>
                        </a>

                        <a href='javascript:;' class="shopping-btn" @if($time2<=0)  @else style="display: none;" @endif onclick="add_to_redis(3279)" id="3279" type="1" >
                            <img src="{{get_img_path('images/ms04.jpg')}}" alt=""/>
                        </a>

                        <a id="3279_3" href='javascript:;' class="shopping-btn"  style="display: none;" >
                            <img src="{{get_img_path('images/ms05.jpg')}}" alt=""/>
                        </a>

                    </div>
                </li>


            </ul>


        </div>
    </div>

    <div class="site-three">
        <div class="ms-title" style='width: 1200px; height: 100px;background: url("{{get_img_path('images/ms02.jpg')}}") no-repeat;'>
            <div class="ms-left" style="width: 600px;float: left;height: 100px;line-height: 104px;text-indent: 35px;">
                <span class="title-txt">准点秒杀：</span><span class="time" style="color: #fdf404;">15:00</span>
            </div>

            <div class="ms-right" style="width: 600px;float: left;height: 100px;line-height: 104px;text-indent: 10px;">
                <div class="time-item" id="time-item3"  >
                    @if($time3>0)
                        <span >距离开抢还剩：</span>
                    @elseif($time3<=0)
                        <span>距离结束还剩：</span>
                    @endif
                    <span style="display: none">已经结束：</span>
                    <strong id="hour_show3"></strong> <span>时</span>
                    <strong id="minute_show3"></strong> <span>分</span>
                    <strong id="second_show3"></strong> <span>秒</span>
                </div>

            </div>
        </div>
        <div class="good-list" style="margin-top: 10px;width: 1200px;overflow: hidden;">
            <ul class="list-first list-three  fn_clear" >
                <li>
                    <div class="li-box">
                        <a href='javascript:;'><img src="{{get_img_path('images/miaosha05.png')}}" alt=""/></a>

                        <p>{{$ms5->goods_number or 0}}</p>

                        <a id="18070_1" href='javascript:;' class="shopping-btn"  @if($time3>0) @else style="display: none;"@endif>
                            <img src="{{get_img_path('images/ms03.jpg')}}" alt=""/>
                        </a>

                        <a href='javascript:;' class="shopping-btn" @if($time3<=0) @else style="display: none;" @endif onclick="add_to_redis(18070)"  id="18070" type="1">
                            <img src="{{get_img_path('images/ms04.jpg')}}" alt=""/>
                        </a>

                        <a id="18070_3" href='javascript:;' class="shopping-btn"  style="display: none;" >
                            <img src="{{get_img_path('images/ms05.jpg')}}" alt=""/>
                        </a>

                    </div>
                </li>
                <li>
                    <div class="li-box">
                        <a href='javascript:;'><img src="{{get_img_path('images/miaosha06.png')}}" alt=""/></a>

                        <p>{{$ms6->goods_number or 0}}</p>

                        <a id="4562_1" href='javascript:;' class="shopping-btn"  @if($time3>0) @else style="display: none;"@endif>
                            <img src="{{get_img_path('images/ms03.jpg')}}" alt=""/>
                        </a>

                        <a href='javascript:;' class="shopping-btn" @if($time3<=0) @else style="display: none;" @endif onclick="add_to_redis(4562)"   id="4562" type="1">
                            <img src="{{get_img_path('images/ms04.jpg')}}" alt=""/>
                        </a>

                        <a id="4562_3" href='javascript:;' class="shopping-btn"  style="display: none;" >
                            <img src="{{get_img_path('images/ms05.jpg')}}" alt=""/>
                        </a>

                    </div>
                </li>
            </ul>


        </div>
    </div>
    <div class="go-box" style="width:1200px;height:95px;margin:30px auto 100px auto;position:relative;">
        <a target="_blank" href="{{$url}}" style="width:140px;height:50px;position:absolute;right:50px;top:25px;"></a>
        <img src="{{get_img_path('images/tejia-01.gif')}}" alt="" />
    </div>

</div>
<div id="qixi-daohang">

    <a target="_blank" href="{{$url}}" style="width:100%;height:100%;display:block;"></a>
</div>
<div style="position: absolute;z-index: 1000000">

    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1252987830'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s19.cnzz.com/stat.php%3Fid%3D1252987830%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>

</div>
</body>
<script>
    $(function () {
        var time1 = '{{$time1}}';
        if(time1 < 0){
            time1 = '{{$end}}';
        }
        var time2 = '{{$time2}}';
        if(time2 < 0){
            time2 = '{{$end}}';
        }
        var time3 = '{{$time3}}';
        if(time3 < 0){
            time3 = '{{$end}}';
        }
        //倒计时

        var times = $("#time-item").attr("data-id");

        var intDiff = parseInt(time1); //倒计时总毫秒数量

        timer(intDiff);

        var intDiff2 = parseInt(time2); //倒计时总毫秒数量
        timer2(intDiff2);

        var intDiff3 = parseInt(time3); //倒计时总毫秒数量
        timer3(intDiff3);




        $(".right_ico").click(function(){


            var val= $(this).prev().attr("value");
            val= parseInt(val);
            val+=1;
            $(this).prev().attr("value",val);

            var kuncun=parseInt($(this).parents(".li-box").find(".kucun").html());

            if(val>kuncun){
                alert("111");
            }


        });


        $(".left_ico").click(function(){


            var val= $(this).next().attr("value");
            val= parseInt(val);
            val-=1;
            $(this).next().attr("value",val);

            var kuncun=parseInt($(this).parents(".li-box").find(".kucun").html());

            if(val>kuncun){
                alert("111");
            }if(val<=0){

                $(this).next().attr("value",1);
            }


        })





    });



    // 倒计时调用方法
    function timer(intDiff){

        window.setInterval(function(){

            var day=0,

                    hour=0,

                    minute=0,

                    second=0;//时间默认值

            if(intDiff > 0){

                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);

                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);

                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);

            }

            if (minute <= 9) minute = '0' + minute;

            if (second <= 9) second = '0' + second;


            $('#hour_show').html('<s id="h"></s>'+hour);

            $('#minute_show').html('<s></s>'+minute);

            $('#second_show').html('<s></s>'+second);

            intDiff--;
            if(intDiff==0){
                $('#2213_1').hide();
                $('#2213').show();
                $('#15932_1').hide();
                $('#15932').show();
            }


        }, 1000);

    }

    // 倒计时调用方法
    function timer2(intDiff){

        window.setInterval(function(){

            var day=0,

                    hour=0,

                    minute=0,

                    second=0;//时间默认值

            if(intDiff > 0){

                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);

                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);

                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);

            }

            if (minute <= 9) minute = '0' + minute;

            if (second <= 9) second = '0' + second;


            $('#hour_show2').html('<s id="h"></s>'+hour);

            $('#minute_show2').html('<s></s>'+minute);

            $('#second_show2').html('<s></s>'+second);

            intDiff--;
            if(intDiff==0){
                $('#3279').hide();
                $('#3279_3').show();
            }


        }, 1000);

    }

    // 倒计时调用方法
    function timer3(intDiff){

        window.setInterval(function(){

            var day=0,

                    hour=0,

                    minute=0,

                    second=0;//时间默认值

            if(intDiff > 0){

                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);

                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);

                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);

            }

            if (minute <= 9) minute = '0' + minute;

            if (second <= 9) second = '0' + second;


            $('#hour_show3').html('<s id="h"></s>'+hour);

            $('#minute_show3').html('<s></s>'+minute);

            $('#second_show3').html('<s></s>'+second);

            intDiff--;
            if(intDiff==0){
                $('#18070').hide();
                $('#18070_3').show();
                $('#4562').hide();
                $('#4562_3').show();
            }
        }, 1000);

    }
</script>
<script>
    function add_to_redis(id){
        var type = $('#'+id).attr('type');
        if(type==1) {
            $.ajax({
                url: '/buy_ms',
                data: {id: id},
                type: 'get',
                dataType: 'json',
                success: function (result) {
                    if (result) {
                        if (result.error == 1) {
                            alert(result.msg);
                            $('#'+id).attr('type',2)
                        } else if (result.error == 2) {
                            location.href = result.url;
                        } else if (result.error == 0) {
                            alert(result.msg);
                            $('#'+id).attr('type',2)
                        }else if (result.error == 3) {
                            alert(result.msg);
                            $('#'+id).attr('type',3)
                        }else if (result.error == 5) {
                            alert(result.msg);
                            $('#'+id).attr('type',5)
                        }
                    }
                }
            })
        }else if(type==2){//不能购买了 原因是已加入购物车
            alert('商品已抢购');
        }else if(type==3){//不能购买了 原因是不能购买多组商品
            alert('只能抢购一个分组的商品');
        }else if(type==5){//不能购买了 原因是不能购买多组商品
            alert('活动未开始');
        }
    }
</script>
</html>