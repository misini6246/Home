<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>合纵医药网药易购公司简介</title>
    <link rel="stylesheet" href="{{path('css/gsjj/jquery.fullPage.css')}}">
    <link href="{{path('css/gsjj/jianjie.css')}}" type="text/css" rel="stylesheet" />
    <script src="{{path('js/jquery.min.js')}}"></script>
    <script src="{{path('js/jquery-ui.min.js')}}"></script>
    <script src="{{path('js/gsjj/jquery.fullPage.min.js')}}"></script>
    <script>
        $(function(){
            if($.browser.msie && $.browser.version < 10){
                $('body').addClass('ltie10');
            }
            $.fn.fullpage({
                verticalCentered: false,
                anchors: ['page1', 'page2', 'page3', 'page4', 'page5', 'page6', 'page7', 'page8', 'page9'],
                navigation: true,
                navigationTooltips: ['首页', '领导团队', '大事件', '大事件', '团队风采', '资质荣誉', '联系地址', '联系方式','马上体验']
            });
        });
    </script>
</head>
<body>
<div class="boxBor"></div>
<div class="section section1">
    <div class="bg"><img src="{{get_img_path('images/gsjj/section1.jpg')}}" alt=""></div>

    <div class="bg13"></div>

    <div class="hgroup">
        <h1><a href="http://www.hezongyy.com/">合纵医药网</a></h1>
        <h2>改变，不止所见。</h2>
    </div>
    <p class="p11"> 　　
        <img src="{{get_img_path('images/gsjj/biaoyu.png')}}" alt="">
    </p>
</div>

<div class="section section2">
    <div class="bg"><img src="{{get_img_path('images/gsjj/section2.jpg')}}" alt=""></div>
    <div class="section-box" style="z-index:9999">
        <div class="bg21"></div>
        <div class="bg22"></div>
        <div class="bg23"></div>

    </div>



    <h3></h3>

</div>

<div class="section section3">
    <div class="bg"><img src="{{get_img_path('images/gsjj/section3.jpg')}}" alt=""></div>
    <div class="section-box">

        <div class="bg31"></div>
        <div class="bg32"></div>
        <div class="bg33"></div>
        <div class="bg34"></div>
        <strong><img src="{{get_img_path('images/gsjj/section03_title.png')}}" alt=""></strong>


    </div>
</div>

<div class="section section4">

    <div class="bg"><img src="{{get_img_path('images/gsjj/section4.jpg')}}" alt=""></div>
    <div class="section-box" style="padding-left:100px;">
        <div class="bg41"></div>
        <div class="bg42"></div>

        <div class="bg43"></div>
        <div class="bg44"></div>
        <div class="bg45"></div>
        <div class="bg46"></div>

    </div>
</div>

<div class="section section5">
    <div class="bg"><img src="{{get_img_path('images/gsjj/section5.jpg')}}" alt=""></div>
    <strong><img src="{{get_img_path('images/gsjj/section5_title.png')}}" alt=""></strong>

    <h3>
        <div id="frame" >

            <div id="photos" class="play">
                <img src="{{get_img_path('images/gsjj/1.jpg')}}" >
                <img src="{{get_img_path('images/gsjj/2.jpg')}}" >
                <img src="{{get_img_path('images/gsjj/3.jpg')}}" >
                <img src="{{get_img_path('images/gsjj/4.jpg')}}" >
                <img src="{{get_img_path('images/gsjj/5.jpg')}}" >

            </div>
        </div>

    </h3>


</div>

<div class="section section6" >
    <div class="bg"><img src="{{get_img_path('images/gsjj/section6.jpg')}}" alt=""></div>
    <strong></strong>
    <h3></h3>
    <div class="section-box" >
        <div class="bg61" ></div>
        <div class="bg62" ></div>
        <div class="bg63"></div>
    </div>


</div>



<div class="section section8">
    <div class="bg"><img src="{{get_img_path('images/gsjj/section8.jpg')}}" alt=""></div>
    <div class="bg81"></div>
    <div class="bg82"></div>
    <div class="bg83"></div>
    <div class="bg84"></div>
    <!-- <strong>[ 科技.聚 ]</strong> -->
    <h3></h3>
    <p class="p8"><img src="{{get_img_path('images/gsjj/section8_01.png')}}" alt=""></p>
</div>

<div class="section section9">
    <div class="bg"><img src="{{get_img_path('images/gsjj/section9.jpg')}}" alt=""></div>

    <h3></h3>
    <div class="section-box" >
        <div class="bg91" >

        </div>
        <div class="bg92">

        </div>
    </div>
</div>

<div class="section section10">
    <div class="bg"><img src="{{get_img_path('images/gsjj/section10.jpg')}}" alt=""></div>
    <div class="bg101"></div>
    <div class="bg102"></div>
    <div class="bg103"></div>
    <a class="go" href="http://www.hezongyy.com/"></a>

    {{--<p class="copyright">--}}
        {{--<a href="javascript:">关于我们</a>--}}
        {{--<a href="javascript:">联系我们</a>--}}
        {{--<a href="javascript:">官方博客</a>--}}
        {{--<a href="javascript:">客户服务</a>--}}
        {{--<a href="javascript:">用户协议</a>--}}
        {{--<span>|</span>--}}
        {{--<span>合纵药易购版权所有 © 1997-{{date('Y')}} </span>--}}
    {{--</p>--}}
</div>








</body>
</html>
<style type="text/css">
    #frame {/*----------图片轮播相框容器----------*/
        position: absolute; /*--绝对定位，方便子元素的定位*/
        width: 800px;
        height: 415px;
        overflow: hidden;/*--相框作用，只显示一个图片---*/

        left: 63px;
        top:58px;


    }
    #dis {/*--绝对定位方便li图片简介的自动分布定位---*/
        position: absolute;
        left: -50px;
        top: -10px;
        opacity: 0.5;
    }
    #dis li {
        display: inline-block;
        width: 200px;
        height: 20px;
        margin: 0 50px;
        float: left;
        text-align: center;
        color: #fff;
        border-radius: 10px;
        background: #000;
    }
    #photos img {
        float: left;
        width:800px;
        height:415px;
    }
    #photos {/*---设置总的图片宽度--通过位移来达到轮播效果----*/
        position: absolute;z-index:9px;
        width: calc(800px * 5);/*---修改图片数量的话需要修改下面的动画参数*/
    }
    .play{
        animation: ma 20s ease-out infinite alternate;/**/
    }
    @keyframes ma {/*---每图片切换有两个阶段：位移切换和静置。中间的效果可以任意定制----*/
        0%,20% {        margin-left: 0px;       }
        25%,40% {       margin-left: -800px;    }
        45%,60% {       margin-left: -1600px;    }
        65%,80% {       margin-left: -2400px;    }
        85%,100% {      margin-left: -3200px;   }
    }
    .num{
        position:absolute;z-index:10;
        display:inline-block;
        right:10px;top:165px;
        border-radius:100%;
        background:#f00;
        width:25px;height:25px;
        line-height:25px;
        cursor:pointer;
        color:#fff;
        text-align:center;
        opacity:0.8;
    }

    @keyframes ma1 {0%{margin-left:-1200px;}100%{margin-left:-0px;} }
    @keyframes ma2 {0%{margin-left:-1200px;}100%{margin-left:-300px;}   }
    @keyframes ma3 {100%{margin-left:-600px;}   }
    @keyframes ma4 {100%{margin-left:-900px;}   }
    @keyframes ma5 {100%{margin-left:-1200px;}  }
</style>