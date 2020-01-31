<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            list-style: none;
            font-family: "微软雅黑";
            font-size: 12px;
            box-sizing: border-box;
            text-decoration: none;
        }
        img{
            border: none;
            vertical-align: middle;
        }
        #header{
            width: 100%;
            height: 1167px;
            background: url('{{get_img_path('images/hd/top_bg.jpg')}}') no-repeat scroll top center;
            min-width: 1200px;
        }
        #container{
            width: 100%;
            height: 1225px;
            background: url('{{get_img_path('images/hd/bottom_bg.jpg')}}') no-repeat scroll top center;
            min-width: 1200px;
        }
        .center{
            width: 1060px;
            margin: 0 auto;
        }
        #container .center .content .title{
            width: 648px;
            height: 80px;
            margin: 0 auto;
        }
        #container .center .content .title span{
            width: 324px;
            height: 80px;
            line-height: 80px;
            text-align: center;
            color: white;
            font-size: 40.39px;
            display: inline-block;
            border: 1px solid #e00e17;
            *width: 320px;

        }
        #container .center .content li{
            display: none;
        }
        #container .center .content .title span:first-child{
            background: #e00e17;
        }
        .chanpin_1,.chanpin_2{
            width: 880px;
            height:445px;
            margin-left: 118px;
        }
        .chanpin_1{
            margin-top: 92px;
        }
        .chanpin_2{
            margin-top: 50px;
        }
        .img_box{
            width: 425px;
            height: 290px;
            line-height: 290px;
            text-align: center;
            margin-top: 110px;
            overflow: hidden;
            float: left;
        }
        .img_box img{
            width: 100%;
        }
        .text{
            width: 435px;
            height: 405px;
            float: right;
            margin-top: 58px;
            text-indent: 15px;
            color: white;
        }
        .text .guige{
            font-size: 34.47px;
            margin-top: 27px;
        }
        .text .name{
            font-size: 67.9px;
            line-height: 70px;
        }
        .text .company{
            font-size: 20.19px;
            margin-top: 8px;
        }
        .text hr{
            width: 191px;
            height: 6px;
            background: #e00e17;
            border: 0;
            margin: 15px 0 18px 15px;
            text-align: left;
            *margin-left: 0;
        }
        .text .xiangou{
            font-size: 32.55px;
        }
        .text .btn{
            display: inline-block;
            width: 355px;
            height: 83px;
            background: #ffff00;
            text-indent: 0;
            margin: 18px 0 0 15px;
            position: relative;
        [;margin-left:0;];
            *margin-left: 15px;
        }
        .btn_tomorrow{
            background: #bfbfbf!important;

        }
        .btn_tomorrow span{
            color: #290d3b!important;
        }
        .btn_tomorrow span.url{
            color: #fff!important;
        }
        .text .btn span{
            height: 50px;
            float: left;
            color: #000;
            /*margin-top: 16px;*/
            cursor: pointer;
        }
        .text .btn span.yuanjia p{
            font-size: 17.06px;
            margin-left: 12px;
        }
        .text .btn span.yuanjia p:first-child{
            text-decoration: line-through;
        }
        .text .btn span.jiage{
            font-size: 53.34px;
            font-weight: bold;
            line-height: 50px;
            margin: 16px 0 0 13px;
        }
        .text .btn span.yuanjia{
            margin-top: 20px;
        }
        .text .btn span.url{
            font-size: 17.06px;
            line-height: 30px;
            color: white;
            width: 111px;
            height: 30px;
            background: #000;
            margin: 28px 0 0 7px;
            text-align: center;
            border-radius: 30px;
        }
        .sanjiao{
            position: absolute;
            right: 0;
            top: 0;
            width: 0;
            height: 0;
            border-top: 42px solid transparent;
            border-right: 13px solid #280e3a;
            border-bottom: 42px solid transparent;
        }
        .fix{
            width: 134px;
            height:553px;
            background: url('{{get_img_path('images/hd/fix.png')}}') no-repeat;
            position: fixed;
            left: 50px;
        }
        .fix ul{
            width: 134px;
            height: 206px;
            margin-top: 183px;
        }
        .fix ul li{
            height: 103px;
            width: 134px;
            cursor: pointer;
        }
        .active{
            display: block!important;
        }

    </style>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
</head>
<body>
<div id="header"></div>
<div id="container">
    <div class="center">
        <ul class="content">
            <li class="active">
                <div class="title">
                    <span>119品牌盛典</span><span>超值预售专区</span>
                </div>
                <div class="chanpin_1">
                    <div class="img_box">
                        <img src="{{get_img_path('images/hd/chanpin.jpg')}}"/>
                    </div>
                    <div class="text">
                        <p class="guige">规格：100片</p>
                        <p class="name">复方甘草片</p>
                        <p class="company">海南制药厂有限公司</p>
                        <hr/>
                        <p class="xiangou">限购：100000件</p>
                        <a href="#" class="btn">
									<span class="yuanjia">
										<p>￥2099</p>
										<p>预售价:</p>
									</span>
                            <span class="jiage">1799</span>
                            <span class="url">点击抢购 ></span>
                            <div class="sanjiao"></div>
                        </a>
                    </div>
                </div>
                <div class="chanpin_2">
                    <div class="img_box">
                        <img src="{{get_img_path('images/hd/chanpin.jpg')}}"/>
                    </div>
                    <div class="text">
                        <p class="guige">规格：100片</p>
                        <p class="name">复方甘草片</p>
                        <p class="company">海南制药厂有限公司</p>
                        <hr/>
                        <p class="xiangou">限购：100000件</p>
                        <a href="#" class="btn">
									<span class="yuanjia">
										<p>￥2099</p>
										<p>预售价:</p>
									</span>
                            <span class="jiage">1799</span>
                            <span class="url">点击抢购 ></span>
                            <div class="sanjiao"></div>
                        </a>
                    </div>
                </div>
            </li>
            <li>
                <div class="title">
                    <span>超值预售</span><span>明日即将上线</span>
                </div>
                <div class="chanpin_1">
                    <div class="img_box">
                        <img src="{{get_img_path('images/hd/chanpin.jpg')}}"/>
                    </div>
                    <div class="text">
                        <p class="guige">规格：100片</p>
                        <p class="name">复方甘草片</p>
                        <p class="company">海南制药厂有限公司</p>
                        <hr/>
                        <p class="xiangou">限购：100000件</p>
                        <a href="#" class="btn btn_tomorrow">
									<span class="yuanjia">
										<p>￥2099</p>
										<p>预售价:</p>
									</span>
                            <span class="jiage">1799</span>
                            <span class="url">敬请期待></span>
                            <div class="sanjiao"></div>
                        </a>
                    </div>
                </div>
                <div class="chanpin_2">
                    <div class="img_box">
                        <img src="{{get_img_path('images/hd/chanpin.jpg')}}"/>
                    </div>
                    <div class="text">
                        <p class="guige">规格：100片</p>
                        <p class="name">复方甘草片</p>
                        <p class="company">海南制药厂有限公司</p>
                        <hr/>
                        <p class="xiangou">限购：100000件</p>
                        <a href="#" class="btn btn_tomorrow">
									<span class="yuanjia">
										<p>￥2099</p>
										<p>预售价:</p>
									</span>
                            <span class="jiage">1799</span>
                            <span class="url">敬请期待></span>
                            <div class="sanjiao"></div>
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="fix">
    <ul>
        <li></li>
        <li></li>
    </ul>
</div>
<script type="text/javascript">
    $(function(){
        $('.fix').css('top',(window.screen.availHeight-700)/2);

        $('.fix ul li').click(function(){
            var tar = $(this).index();
            $('.content li').eq(tar).addClass('active').siblings('li').removeClass('active')
        })

    })
</script>
</body>
</html>
