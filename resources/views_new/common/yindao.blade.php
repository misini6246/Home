
<div id="lvjing">
    <div class="lvjing-box">
        <!--第一个引导-->
        <div class="yindao1" style="display:none;">
            <div class="goOn1"></div>
            <div class="out1"></div>
        </div>
        <!--第一个引导-->

        <!--第二个引导-->
        <div class="yindao2" style="display:none;">
            <a href="#GoTo4"><div class="goOn2"></div></a>
            <div class="out2"></div>
        </div>
        <!--第二个引导-->

        <!--第三个引导-->
        <div class="yindao3" style="display:none;">
            <a href="#GoTo1"><div class="goOn3"></div></a>
            <div class="out3"></div>
        </div>
        <!--第三个引导-->

        <!--第四个引导-->
        <div class="yindao4" style="display:none;">
            <a href="#GoTo2"><div class="goOn4"></div></a>
            <div class="out4"></div>
        </div>
        <!--第四个引导-->

        <!--第五个引导-->
        <div class="yindao5" style="display:none;">
            <a href="#GoTo3"><div class="goOn5"></div></a>
            <div class="out5"></div>
        </div>
        <!--第五个引导-->

        <!--第六个引导-->
        <div class="yindao6" style="display:none;">
            <a href="#header"><div class="goOn6"></div></a>
        </div>
        <!--第六个引导-->




    </div>
    <!--背景遮罩层-->、
    <div class="zhezhao-bg">

    </div>
    <!--背景遮罩层-->
    <!--跳转层-->
    <div id="GoTo4">

    </div>
    <div id="GoTo1">

    </div>
    <div id="GoTo2">

    </div>
    <div id="GoTo3">

    </div>
    <!--跳转层-->
</div>
<script type="text/javascript">

    $(function(){
        $("html,body").animate({scrollTop:0}, 500);
        var width = $('.top_left').css('width');
        width = parseFloat(width) - 55;
        $('.yindao1').css('left',width);
        $('.yindao1').show();

        $('.goOn1').click(function(){
            $('.yindao1').css('display','none');
            $('.yindao2').css('display','block');
        })
        $('.goOn2').click(function(){
            $('.yindao2').css('display','none');
            $('.yindao3').css('display','block');
        })
        $('.goOn3').click(function(){
            $('.yindao3').css('display','none');
            $('.yindao4').css('display','block');
        })
        $('.goOn4').click(function(){
            $('.yindao4').css('display','none');
            $('.yindao5').css('display','block');
        })
        $('.goOn5').click(function(){
            $('.yindao5').css('display','none');
            $('.yindao6').css('display','block');
        })
        $('.out1,.out2,.out3,.out4,.out5,.goOn6').click(function(){
            $('#lvjing').css('display','none')
        })
    })
</script>