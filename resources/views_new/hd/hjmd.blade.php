<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>119获奖名单-{{config('services.web.title')}}</title>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-size: 12px;
            font-family: "微软雅黑";
            list-style: none;
            outline: none;
            box-sizing: border-box;
        }

        img {
            width: 100%;
            border: 0;
            vertical-align: middle;
        }

        .iphone, .miandan, .wuzhe, .hongbao {
            position: absolute;
        }

        .iphone li, .miandan li, .wuzhe li, .hongbao li {
            width: 100%;
            height: 9.1%;
            color: #ffd59f;
            text-align: center;
            text-overflow: ellipsis;

        }
        .miandan li{
            height: 11.4%;
        }
    </style>
</head>
<body>
<img src="{{get_img_path('images/hjmd.jpg')}}" class="bg_img"/>
<ul class="iphone">
    <li>青羊区XXXX大药房</li>
    <li>龙泉驿区龙泉街办太XXX诊所</li>
    <li>南充市高坪区康XXXX中医诊所</li>
    <li>成都市温江仁XXXX药房</li>
    <li>雅安市雨城区城东XXXX药房</li>
    <li>龙泉驿区XXXX惠仁药店</li>
    <li>德阳市旌阳区XXXX第一卫生站</li>
    <li>自贡市沿滩区XXXX药店</li>
    <li>郫县XXXX诊所</li>
    <li>乌鲁木齐市水XXXX诊所</li>
    <li>西昌市XXXX大药房长安东路店</li>
</ul>
<ul class="miandan">
    <li>垫江县华博XXXX砚台百鑫店</li>
    <li>新津县XXXX欣利民药房</li>
    <li>罗江县太极大药房XXXX药店</li>
    <li>绵阳XXXX家家顺加盟店</li>
    <li>广汉市XXXX中西药店</li>
    <li>晋城市杏林XXXX有限公司</li>
    <li>绵阳市慈XXXX大药房</li>
    <li>南充市嘉陵区XXXX服务站</li>
    <li>蓬安县XXXX有限公司第91店</li>
</ul>
<ul class="wuzhe">
    <li>绵阳XXXX陈应诊所</li>
    <li>自贡市关爱XXXX大药房</li>
    <li>成华XXXX诊所</li>
    <li>丹棱县圣丹XXXX龙雲轩店</li>
    <li>四川省永康XXXX高新区药店</li>
    <li>奇台县XXXX药店</li>
    <li>广安三XXXX第五百二十二店</li>
    <li>天府新区XXXX济药房</li>
    <li>五家渠新安康XXXX新华东路店</li>
    <li>宜宾市翠屏区XXXX药房</li>
    <li>邛崃市XXXX健民药店</li>
</ul>
<ul class="hongbao" style="overflow: hidden">
    @foreach($jp1 as $k=>$v)
        <li>{{$v->msn}}</li>
    @endforeach
</ul>
<script type="text/javascript">
    window.onload = function () {
        scroll();
        window.onresize = function () {
            scroll();
        };
    }
    $(function () {
        setInterval('lunbo()', 5000);
    });
    function scroll() {
        $('.iphone,.miandan,.wuzhe,.hongbao').css({
            "width": $('.bg_img').width() * 0.1458,
            "height": $('.bg_img').width() * 0.228,
            "top": $('.bg_img').width() * 0.278
        })
        $('.iphone li,.miandan li,.wuzhe li,.hongbao li').css({
            'font-size': $('.bg_img').width() * 0.01051,
            'line-height': $('.iphone li').height() + "px"
        })
        $('.iphone').css("left", $('body').width() * 0.19);
        $('.miandan').css("left", $('.bg_img').width() * 0.348);
        $('.wuzhe').css("left", $('.bg_img').width() * 0.506);
        $('.hongbao').css("left", $('.bg_img').width() * 0.664);
    }
    function lunbo() {
        var m = $('.hongbao li:eq(0)').css('height');
        $('.hongbao li:eq(0)').animate({marginTop: "-" + m}, 1000, function () {
            $(this).css('margin-top', '0');
            $('.hongbao').append($(this));
        })
    }
</script>
</body>
</html>
