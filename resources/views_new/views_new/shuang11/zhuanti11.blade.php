<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <title>合纵医药电子商务采购平台-药易购</title>
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('js/jquery.js')}}"></script>

    <style type="text/css">
        .time-item{width:560px;height: 100px;margin:100px 0 0 462px;}
        .time-item strong{width: 78px;height: 78px;display: block;float: left;margin: 9px 50px 0 0;font-size: 50px;
            color: #e40d0d;line-height: 78px;text-align: center;}

        .shopping-list{width:998px;margin:0 auto;overflow:hidden;padding: 10px;background-color:#fec30f;height: 890px;}

        .shopping-list ul li{width: 242px;height:410px;float: left;margin:0px 10px 10px 0; }
    </style>

    <script type="text/javascript">
        $(function(){

            $.ajax({
                url:'/get_user_info',
                type:'get',
                data:{id:1},
                dataType:'json',
                success:function(msg){
                    if(msg){
                        var intDiff = parseInt(msg.end); //倒计时总毫秒数量
                        timer(intDiff);
                    }
                }
            });


        });


        function timer(intDiff){
            window.setInterval(function(){
                var day=0,
                        hour=0,
                        minute=0,
                        second=0;//时间默认值
                if(intDiff > 0){
                    day = Math.floor(intDiff / (60 * 60 * 24));
                    hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                    minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                    second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
                }
                if (minute <= 9) minute = '0' + minute;
                if (second <= 9) second = '0' + second;

                $('#day_show').html(day);
                $('#hour_show').html('<s id="h"></s>'+hour);
                $('#minute_show').html('<s></s>'+minute);
                $('#second_show').html('<s></s>'+second);
                intDiff--;
            }, 1000);
        }


    </script>



</head>
<body style="position:relative;background-color:#b806cf;">

<div id="top" style='background: url("{{get_img_path('images/shuang11-zht01.jpg')}}") no-repeat scroll center top;height: 338px;min-width: 1200px;overflow: hidden;width: 100%;'>
</div>
<div style='background: url("{{get_img_path('images/shuang11-zht02.jpg')}}") no-repeat scroll center top;height: 255px;min-width: 1200px;overflow: hidden;width: 100%;'>
    <div class="js-box" style="width:1200px;height:255px;margin:0 auto;position:relative;">

        <div class="time-item" id="time-item"  >
            <strong id="day_show"></strong>
            <strong id="hour_show"></strong>
            <strong id="minute_show"></strong>
            <strong id="second_show"></strong>
        </div>

    </div>
</div>

<div  style='background: url("{{get_img_path('images/shuang11-zht042.jpg')}}") no-repeat scroll center top;height: 275px;min-width: 1200px;overflow: hidden;width: 100%;'>
    <a target="_blank" href="{{route('cj.jfdh')}}" style="width:1200px;height:275px;margin:0 auto;display:block;"></a>
</div>
<div  style='background: url("{{get_img_path('images/shuang11-zht041.jpg')}}") no-repeat scroll center top;height: 125px;min-width: 1200px;overflow: hidden;width: 100%;'>
</div>
<div  style='background: url("{{get_img_path('images/shuang11-zht04.jpg')}}") no-repeat scroll center top;height: 360px;min-width: 1200px;overflow: hidden;width: 100%;'>
    <a target="_blank" href="/miaosha.html" style="width:1200px;height:360px;margin:0 auto;display:block;"></a>
</div>
<div class="title" style="width:990px;margin:0 auto;"> <p style="width:330px;height:118px;margin:0 auto;"> <img src="{{get_img_path('images/shuang11-zht05.jpg')}}" alt="" /></p></div>

<div style="width:990px;margin:0 auto;"> <a target="_blank" href="@if(strtotime('2016-11-11 00:00:00')<time()) {{route('category.index',['step'=>'promotion'])}} @else {{route('category.index',['step'=>'nextpro'])}} @endif"> <img src="{{get_img_path('images/shuang11-zht06.jpg')}}" alt="" /></a></div>
<div class="title" style="width:990px;margin:0 auto;"> <p style="width:330px;height:118px;margin:0 auto;"> <img src="{{get_img_path('images/shuang11-zht07.jpg')}}" alt="" /></p></div>

<div style="width:990px;margin:0 auto;"> <a > <img src="{{get_img_path('images/shuang11-zht08.jpg')}}" alt="" /></a></div>

<div class="title" style="width:990px;margin:0 auto;"> <p style="width:330px;height:118px;margin:0 auto;"> <img src="{{get_img_path('images/shuang11-zht09.jpg')}}" alt="" /></p></div>

<div  class="shopping-list">
    <ul style="width:1100px;" class="fn_clear">
        <li><a target="_blank" href="{{route('goods.index',['id'=>8548])}}"><img src="{{get_img_path('images/shuang11-zht015.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>23917])}}"><img src="{{get_img_path('images/shuang11-zht016.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>24404])}}"><img src="{{get_img_path('images/shuang11-zht017.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>20676])}}"><img src="{{get_img_path('images/shuang11-zht018.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>3765])}}"><img src="{{get_img_path('images/shuang11-zht019.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>24427])}}"><img src="{{get_img_path('images/shuang11-zht020.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>19650])}}"><img src="{{get_img_path('images/shuang11-zht021.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>20688])}}"><img src="{{get_img_path('images/shuang11-zht022.jpg')}}" alt="" /></a></li>
    </ul>

    <p style="width:176px;height:56px;margin:0 auto;"><a href="{{route('category.index',['step'=>'zk'])}}"><img src="{{get_img_path('images/shuang11-zht014.jpg')}}" alt="" /></a></p>
</div>
<div class="title" style="width:990px;margin:0 auto;"> <p style="width:330px;height:118px;margin:0 auto;"> <img src="{{get_img_path('images/shuang11-zht011.jpg')}}" alt="" /></p></div>

<div  class="shopping-list">
    <ul style="width:1100px;" class="fn_clear">
        <li><a target="_blank" href="{{route('goods.index',['id'=>3210])}}"><img src="{{get_img_path('images/shuang11-zht031.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>7564])}}"><img src="{{get_img_path('images/shuang11-zht033.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>957])}}"><img src="{{get_img_path('images/shuang11-zht034.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>15042])}}"><img src="{{get_img_path('images/shuang11-zht035.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>20089])}}"><img src="{{get_img_path('images/shuang11-zht036.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>1003])}}"><img src="{{get_img_path('images/shuang11-zht037.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>17979])}}"><img src="{{get_img_path('images/shuang11-zht038.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>18017])}}"><img src="{{get_img_path('images/shuang11-zht039.jpg')}}" alt="" /></a></li>
    </ul>

    <p style="width:176px;height:56px;margin:0 auto;"><a href="{{route('category.index',['step'=>'hg'])}}"><img src="{{get_img_path('images/shuang11-zht014.jpg')}}" alt="" /></a></p>
</div>
<div class="title" style="width:990px;margin:0 auto;"> <p style="width:330px;height:118px;margin:0 auto;"> <img src="{{get_img_path('images/shuang11-zht010.jpg')}}" alt="" /></p></div>

<div  class="shopping-list">
    <ul style="width:1100px;" class="fn_clear">
        <li><a target="_blank" href="{{route('goods.index',['id'=>18118])}}"><img src="{{get_img_path('images/shuang11-zht023.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>4458])}}"><img src="{{get_img_path('images/shuang11-zht024.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>1207])}}"><img src="{{get_img_path('images/shuang11-zht025.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>1206])}}"><img src="{{get_img_path('images/shuang11-zht026.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>1208])}}"><img src="{{get_img_path('images/shuang11-zht027.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>7156])}}"><img src="{{get_img_path('images/shuang11-zht028.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>17987])}}"><img src="{{get_img_path('images/shuang11-zht029.jpg')}}" alt="" /></a></li>
        <li><a target="_blank" href="{{route('goods.index',['id'=>3938])}}"><img src="{{get_img_path('images/shuang11-zht030.jpg')}}" alt="" /></a></li>
    </ul>

    <p style="width:176px;height:56px;margin:0 auto;"><a href="{{route('category.index',['step'=>'mz'])}}"><img src="{{get_img_path('images/shuang11-zht014.jpg')}}" alt="" /></a></p>
</div>




<div class="title" style="width:990px;margin:0 auto;"> <p style="width:330px;height:118px;margin:0 auto;"> <img src="{{get_img_path('images/shuang11-zht012.jpg')}}" alt="" /></p></div>

<div   style="margin:0 auto;margin-bottom:100px;width:990px;height:360px;">

    <a href="{{route('zy.index')}}"><img src="{{get_img_path('images/shuang11-zht045.jpg')}}" alt="" /></a>
    <div id="gonglve"></div>
</div>


<div style='overflow: hidden;width: 100%;background-color: #fff;padding-bottom: 50px'>
    <div style="width:1200px;margin:0 auto;position:relative;">
        <p style="width:580px;height:62px;margin :-10px auto 20px auto;*margin-top:-7px;"><img src="{{get_img_path('images/shuang11-zht013.jpg')}}" alt="" /></p>
        <p><img src="{{get_img_path('images/shuang11-zht040.jpg')}}" alt="" /></p>
    </div>
</div>

<style type="text/css">
    #shuang11-daohang {position:fixed;_position:absolute;_top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight)-20+"px");bottom:10px;right:2px;width:168px;zoom:1;height: 466px; background:url('{{get_img_path('images/shuang11-zht052.png')}}') no-repeat;z-index: 100000;}

    #shuang11-daohang a{ display:block; width:150px; height:35px; margin-bottom:5px; overflow:hidden;}

    #shuang11-daohang a#totop{position:absolute;bottom:0px;cursor:pointer;}

</style>


<div id="shuang11-daohang">
    <div class="lianjie" style="width:150px;height:200px;margin:104px 0 0 10px">
        <a target="_blank" href="/miaosha.html"></a>
        <a target="_blank" href="@if(strtotime('2016-11-11 00:00:00')<time()) {{route('category.index',['step'=>'promotion'])}} @else {{route('category.index',['step'=>'nextpro'])}} @endif"></a>
        <a target="_blank" href="{{route('category.index',['step'=>'zk'])}}"></a>
        <a target="_blank" href="{{route('category.index',['step'=>'mz'])}}"></a>
        <a target="_blank" href="{{route('category.index',['step'=>'hg'])}}"></a>
        <a target="_blank" href="@if(strtotime('2016-11-11 00:00:00')<time()) {{route('category.index',['step'=>'promotion','dis'=>4])}} @else {{route('category.index',['step'=>'nextpro','dis'=>4])}} @endif"></a>
        <a href="#gonglve"></a>

        <a href="#top"></a>
        <a href="{{route('index')}}"></a>
    </div>
</div>



</body>
</html>
