<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/111/css/raffle.css">
    <link href="https://cdn.bootcss.com/Swiper/4.5.1/css/swiper.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/Swiper/4.5.1/js/swiper.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
    <script src="/isIE/isIE.js"></script>
    <script src="/111/js/jquery.rotate.min.js"></script>
    <script src="/layer/layer.js"></script>
    <script src="/111/js/raffle.js"></script>
    <title>幸运大转盘</title>
</head>

<body>
    <div class="container">
        <div class="top">
            <div class="left">
                <div class="rule">
                    <img src="http://www.jyeyw.com/111/choujiang/rule.png" alt="">
                </div>
                <div class="tips">
                    <div class="left-times">
                        剩余抽奖次数：0
                    </div>
                    <div class="my-award">
                        中奖记录：
                    </div>
                </div>
                <div class="award-list">
                    <div class="title">
                        <img src="http://www.jyeyw.com/111/choujiang/title1.png" alt="">
                    </div>
                    <div class="content">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="list-item">
                                        <div class="user-name"></div>
                                        <div class="user-award"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="wheel-wrap">
                    {{-- 转盘外部 --}}
                    <div class="wheel-bg">
                        <img src="http://www.jyeyw.com/111/choujiang/wheel_bg.png" alt="">
                    </div>
                    <div class="wheel">
                        <div class="awards">
                            <img id="wheel" src="http://www.jyeyw.com/111/choujiang/wheel.png" alt="">
                        </div>
                        <div class="pointer">
                            <img id="start" src="http://www.jyeyw.com/111/choujiang/pointer.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>