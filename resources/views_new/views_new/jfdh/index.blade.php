<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <title>合纵医药电子商务采购平台-药易购</title>
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('js/jquery.min.js')}}"></script>
    @include('layout.token')
    <style type="text/css">
        #wxts {
            width: 280px;
            height: 160px;
            position: fixed;
            left: 50%;
            top: 50%;
            margin-left: -125px;
            margin-top: -70px;
            z-index: 1003;
            display: none;
            text-align: center;
        }

        .zhongjiang {
            position: relative;
            width: 280px;
            height: 160px;
        }

        .close2 {
            width: 30px;
            height: 30px;
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            background-color: #f00;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        #sure {
            width: 90px;
            height: 30px;
            position: absolute;
            left: 45px;
            top: 110px;
            background-color: #f00;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .check {
            width: 120px;
            height: 30px;
            position: absolute;
            left: 143px;
            top: 110px;
            background-color: #f00;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .text {
            font-size: 20px;
            color: #fff;
            position: absolute;
            left: 50px;
            line-height: 20px;
            font-weight: bold;
            top: 55px;
            width: 180px;
            text-align: center;
        }

        .text1 {
            font-size: 16px;
            color: #fff;
            position: absolute;
            left: 50px;
            line-height: 20px;
            font-weight: bold;
            top: 42px;
            width: 180px;
            text-align: center;
        }

        .yhq0 {
            width: 180px;
            height: 40px;
            position: absolute;
            left: 105px;
            bottom: 62px;
            background-color: #ed2929;
            color: #fff;
            font-size: 18px;
            border-radius: 20px;
            line-height: 40px;
            text-align: center;
        }

        .yhq1 {
            width: 180px;
            height: 40px;
            position: absolute;
            left: 380px;
            bottom: 62px;
            background-color: #ed2929;
            color: #fff;
            font-size: 18px;
            border-radius: 20px;
            line-height: 40px;
            text-align: center;
        }

        .yhq2 {
            width: 180px;
            height: 40px;
            position: absolute;
            left: 650px;
            bottom: 62px;
            background-color: #ed2929;
            color: #fff;
            font-size: 18px;
            border-radius: 20px;
            line-height: 40px;
            text-align: center;
        }

        .yhq3 {
            width: 180px;
            height: 40px;
            position: absolute;
            left: 925px;
            bottom: 62px;
            background-color: #ed2929;
            color: #fff;
            font-size: 18px;
            border-radius: 20px;
            line-height: 40px;
            text-align: center;
        }
        /*提交订单后的弹框*/
        .Bombbox{
            /*position: relative;*/
            position:fixed;
            _position:absolute;
            top:50%; right:50%;
            /*_bottom:auto;*/
            _top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)));
            width:260px;
            /*border:1px solid red;*/
            /*zoom:1;*/
            height: 140px;
            background:#ffffff;
            border-radius: 5px;
            display:none;
            box-shadow:5px 5px 40px #444;
            -moz-box-shadow:5px 5px 40px #444;
            -webkit-box-shadow:5px 5px 40px #444;
            -o-box-shadow:5px 5px 40px #444;
            background: url("../images/success.jpg") no-repeat;
            font-size: 12px;
            margin: -126px -130px 0 0px;
        }
        .Bombbox img{
            display: inline;
            margin-top: 10px;
            margin-left: -5px;
        }
        .close{
            width: 15px;
            height: 15px;
            /*border: 1px solid red;*/
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .suc{
            position: absolute;
            top:79px;
            left: 150px;
            color: #025aa2;
        }
        .err{
            position: absolute;
            left: 150px;
            top: 106px;
            color: #025aa2;
        }


        /*提交订单后的弹框*/
    </style>
</head>
<body style="padding: 0;margin: 0;background-color:#bc0501;position:relative;">


<div id="wxts">
    <div class="zhongjiang">
        <img id="img" src="{{get_img_path('images/jfdh-tip.png')}}" alt=""/>

        <span class="text" id="wxts_text"></span>

        <span class="close2"></span>
        <a href="javascript:;" id="sure" style="left:95px;"></a>

    </div>
</div>


<div id="top"
     style='background: url("{{get_img_path('images/znq-jfdh01.jpg')}}") no-repeat scroll center top;height: 250px;min-width: 1200px;overflow: hidden;width: 100%;'>
</div>
<div style='background: url("{{get_img_path('images/znq-jfdh02.jpg')}}") no-repeat scroll center top;height: 250px;min-width: 1200px;overflow: hidden;width: 100%;'>
</div>


<div style='background: url("{{get_img_path('images/znq-jfdh03.jpg')}}") no-repeat scroll center top;height: 560px;min-width: 1200px;overflow: hidden;width: 100%;margin: 38px  auto 100px auto;'>


    <div class="lq-box" style="width:1200px;height:560px;margin:0 auto;position:relative;">
        <div style="position:absolute;left:215px;top:115px;font-size:30px;color:#dc2a2a;"><span
                    id="pay_points">{{$user->pay_points}}</span><span style="margin-left: 20px;">(1张周年庆券=10元抵扣券，<span style="font-size: 20px;">仅限3.8/3.15/3.29特价活动当日使用</span>)</span>

        </div>
        @foreach($list as $k=>$v)
            <a href="javascript:;" class="yhq{{$k}}" cat_id="{{$v->cat_id}}" num="{{$v->yhq_num}}"
               jf="{{$v->goods_amount*$v->yhq_num}}" onclick="show_wxts($(this))">点击兑换</a>
        @endforeach
    </div>
</div>
<!--提交成功后的弹框-->
<div class="Bombbox" style="z-index: 1000000">
    <img src="{{path('huodong/images/tishi_03.jpg')}}" alt="">
    <div class="close"></div>
    <a id="chakan" href="javascript:;" class="suc">查看订单</a>
    <a target="_blank" href="http://www.hezongyy.com/articleInfo?id=91" class="err">查看支付帮助</a>
</div>
<!--提交成功后的弹框-->
<style type="text/css">
    #znq-daohang {
        position: fixed;
        _position: absolute;
        _top: expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight)-20+"px");
        top: 40%;
        right: 10px;
        width: 124px;
        zoom: 1;
        height: 330px;
        background: url('{{get_img_path('images/znq-jfdh04.png')}}') no-repeat;
        z-index: 100000;
    }

    #znq-daohang a {
        display: block;
        width: 90px;
        height: 35px;
        margin-bottom: 1px;
        overflow: hidden;
    }

    #znq-daohang a#totop {
        position: absolute;
        bottom: 0px;
        cursor: pointer;
    }

</style>


@include('common.znqdh')


</body>
<script>
    $(function () {
        $('.close2').click(function () {
            $('.tanchuc').hide();
        });
    });

</script>
<script type="text/javascript">
    $(function () {
        $('.close2').click(function () {
            $('#wxts').hide();
        });
        $('.close').click(function () {
            $('.Bombbox').css('display', 'none')
        })
    });
    function show_wxts(obj) {
        var jf = parseInt(obj.attr('jf'));
        var num = parseInt(obj.attr('num'));
        $('#wxts_text').removeClass('text').addClass('text1');
        $('#wxts_text').html("您将花费<span>" + jf + "</span>积分<br/>兑换" + num + "张周年庆券<br/>过期不使用，积分不退还");
        $('#sure').off('click');
        $('#sure').on('click', function () {
            $('#wxts').hide();
            bt(obj);
        });
        $('#img').attr('src', '{{get_img_path('images/jfdh-tip.png')}}');
        $('#sure').attr('href', 'javascript:;');
        $('#wxts').show();
    }
    function bt(obj) {
        var cat_id = obj.attr('cat_id');
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
            url: '/jfdh/jfdh',
            type: 'post',
            async: false,
            data: {cat_id: cat_id},
            //dataType: 'json',
            success: function (result) {

                $('#wxts_text').removeClass('text1').addClass('text');
                $('#wxts_text').text(result.msg);
                $('#sure').off('click');

                if (result.error == 0) {
                    var pay_points = parseInt($('#pay_points').text());
                    var jf = parseInt(obj.attr('jf'));
                    $('#pay_points').text(parseInt(pay_points - jf));
                    $('#img').attr('src', '{{get_img_path('images/jfdh-tip2.png')}}');
                    $('#sure').on('click', function () {
                        location.href = '/user/youhuiq';
                    });
                } else {
                    $('#sure').on('click', function () {
                        $('#wxts').hide();
                    });
                }
                $('#wxts').show();
            }
        });
    }
</script>
</html>
