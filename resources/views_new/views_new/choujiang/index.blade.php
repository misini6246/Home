<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <title>合纵医药电子商务采购平台-药易购</title>
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('js/jquery.min.js')}}"></script>

    <style type="text/css">
        .time-item{width:420px;height: 100px;margin-left: 560px;}
        .time-item strong{width: 78px;height: 78px;display: block;float: left;margin: 9px 50px 0 0;font-size: 50px;
            color: #e40d0d;line-height: 78px;text-align: center;}


    </style>

    <script type="text/javascript">
        $(function(){

            //倒计时
            var times = $("#time-item").attr("data-id");
            //倒计时
            // var intDiff = parseInt(times); //倒计时总毫秒数量
            timer(times);


        })


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
<body style="padding: 0;margin: 0;position:relative;">

<div id="top" style='background: url("{{get_img_path('images/shuang11ejy01.jpg')}}") no-repeat scroll center top;height: 448px;min-width: 1200px;overflow: hidden;width: 100%;'>




</div>
<div style='background: url("{{get_img_path('images/shuang11ejy02.jpg')}}") no-repeat scroll center top;height: 430px;min-width: 1200px;overflow: hidden;width: 100%;'>
    <div class="js-box" style="width:1200px;height:430px;margin:0 auto;position:relative;">

        <div class="time-item" id="time-item" data-id="{{$end}}">
            <strong id="day_show"></strong>
            <strong id="hour_show"><s id="h"></s></strong>
            <strong id="minute_show" style="margin-left:35px"><s></s></strong>

        </div>

    </div>
</div>
<a target="_blank" href="{{route('cj.bm')}}">
    <div style='background: url("{{get_img_path('images/shuang11ejy03.jpg')}}") no-repeat scroll center top;height: 458px;min-width: 1200px;overflow: hidden;width: 100%;'>
        <div class="fl-box" style="width:1200px;height:458px;margin:0 auto;position:relative;">

        </div>
    </div>
</a>
<a target="_blank" href="{{route('cj.jfdh')}}">
    <div style='background: url("{{get_img_path('images/shuang11ejy04.jpg')}}") no-repeat scroll center top;height: 458px;min-width: 1200px;overflow: hidden;width: 100%;'>
        <div class="dh-box" style="width:1200px;height:458px;margin:0 auto;position:relative;">

        </div>
    </div>
</a>
<a target="_blank" href="{{route('cj.cj')}}">
<div style='background: url("{{get_img_path('images/shuang11ejy05.jpg')}}") no-repeat scroll center top;height: 605px;min-width: 1200px;overflow: hidden;width: 100%;'>

</div>
</a>
@include('shuang11.fudongdh',['fd_type' => 1])
</body>
</html>
<script type="text/javascript">
    $(function(){


        $(".lq-box a").click(function(){
            $(".zhongle").show();


        })

        $(".close").click(function(){
            $(this).parent().parent().hide();

        })

        $(".queding").click(function(){
            $(this).parent().parent().hide();

        })

        $(".check").click(function(){
            $(this).parent().parent().hide();

        })



    })

</script>