<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    @include('layout.token')
    <title>合纵医药电子商务采购平台-药易购</title>
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{path('js/tanchuc.js')}}"></script>

    <style type="text/css">
        .yilingq{ width:389px; height:170px;position: absolute;left: 50%;top: 20%;margin-left: -194px;margin-top: -70px;z-index: 1003;display: none;text-align: center;}

        .gxx{ width:560px; height:407px;position: absolute;left: 50%;top: 40px;margin-left: -280px;z-index: 1003;display: none;text-align: center;}

        .lianjie ul li{width: 250px;height: 108px;float: left;margin-left: 50px;}

    </style>
</head>

<body style="padding: 0;margin: 0;background-color:#62114c;position:relative;" id="body">
<div class="bg" style="width:100%;height:100%;background-color:#000;opacity:0.5;filter:alpha(opacity=50);position:absolute;left:0;bottom:0;display:none;"></div>


<div class="yilingq" >
    <div class="zhongjiang" style="position:fixed;">
        <a href="#"><img src="{{get_img_path('images/shang1206.jpg')}}" alt="" /></a>
        <span class="close-btn" style="width:60px;height:30px;position:absolute;right:-60px;top:0;font-size:16px;font-weight:bolder;color:#fff;cursor:pointer;">[ 关闭 ]</span>
    </div>
</div>

<div class="gxx" >
    <div class="gxx-box" style="position:fixed;">
        <img src="{{get_img_path('images/shang1207.png')}}" alt="" />
        <span class="close-btn-gxx" style="width:60px;height:60px;position:absolute;left:250px;top:0;font-size:16px;font-weight:bolder;color:#fff;cursor:pointer;z-index:999;background-color:#fff;filter:alpha(opacity=0);opacity:0;"></span>
    </div>
</div>




<div id="top" style='background: url("{{get_img_path('images/shang1201.jpg')}}") no-repeat scroll center top;height: 500px;min-width: 1200px;overflow: hidden;width: 100%;'>
    <div class="gxx-b" style="width:1200px;margin:0 auto;height:500px;cursor:pointer;"></div>
</div>



<div class="lianjie" style="width:1200px;margin:0 auto;padding:40px 0;">

    <ul class="fn_clear">
        <li><a href="javascript:;"><img src="{{get_img_path('images/shang1202.png')}}" alt="" /></a></li>
        <li><a href="javascript:;"><img src="{{get_img_path('images/shang1203.png')}}" alt="" /></a></li>
        <li><a href="javascript:;"><img src="{{get_img_path('images/shang1204.png')}}" alt="" /></a></li>
        <li><a href="javascript:;"><img src="{{get_img_path('images/shang1205.png')}}" alt="" /></a></li>
    </ul>

    <p style="width:1200px;text-align:center;padding:50px 0;">
        <a id="wlq" href="javascript:;" class="lq-btn"
           @if($is_has==0)
           style="padding:10px 20px;background-color:#f10e34;color:#fff9c4;font-size:24px;border-radius:10px;"
           @else
           style="padding:10px 20px;background-color:#f10e34;color:#fff9c4;font-size:24px;border-radius:10px;display: none;"
           @endif
           is_has="{{$is_has or 0}}">一键领取感恩券</a>
        <a id="ylq" href="{{route('user.youhuiq')}}"
        @if($is_has==0)
           style="padding:10px 20px;background-color:#f10e34;color:#fff9c4;font-size:24px;border-radius:10px;display:none;"
            @else
            style="padding:10px 20px;background-color:#f10e34;color:#fff9c4;font-size:24px;border-radius:10px;"
            @endif
                >感恩券已领取&nbsp;点击查看</a>
    </p>

    {{--<p style="font-size:16px;color:#dddddd;text-align:center;width:1200px;">*注：感恩券仅限终端客户领取，且感恩券可叠加使用，但控销产品、含麻药品、秒杀不可用。</p>--}}




</div>
</body>
</html>
<script type="text/javascript">
    $(function(){

        $(".lq-btn").click(function(){
//            $(".yilingq").show();
//            $(".bg").show();
            cs($(this));

        })

        $(".close-btn").click(function(){
            $(".yilingq").hide();
            $(".bg").hide();

        })

        $(".gxx-b").click(function(){
            $(".gxx").show();
            $(".bg").show();
        })

        $(".close-btn-gxx").click(function(){
            $(".gxx").hide();
            $(".bg").hide();

        })



    })

    function cs(obj){
        var cat_id = obj.attr('is_has');
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
            url: '/hd/yhq',
            type: 'post',
            async:false,
            data: {cat_id: cat_id},
            //dataType: 'json',
            success: function (result) {
                if(result.error==1) {
                    add_tanchuc(result.msg);
                }else{
                    $(".yilingq").show();
                    $(".bg").show();
                    $("#ylq").show();
                    $("#wlq").hide();
                }
            }
        });
    }

</script>