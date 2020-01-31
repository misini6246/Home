$(function () {

    //右侧在线咨询
    $(".services").hover(function () {

        $(this).addClass("hover");


    }, function () {
        $(this).removeClass("hover");
    }) ;

    //返回顶部

    $("#totop").hide();
    //当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
    $(function () {
        $(window).scroll(function(){
            if ($(window).scrollTop()>100){
                $("#totop").fadeIn();
            }
            else
            {
                $("#totop").fadeOut();
            }
        });
        //当点击跳转链接后，回到页面顶部位置
        $("#totop").click(function(){
            $('body,html').animate({scrollTop:0},400);
            return false;
        });
    });


    //二维码显示隐藏
    $(".attention").hover(function () {
        $(this).addClass("a_tab");
        $(".pic").show();

        $(this).css({
            "color":"#6c6c6c"
        });


    }, function () {
        $(".pic").hide();
        $(this).removeClass("a_tab");


    });
	
	//顶部关闭广告
	$(".close_btns").click(function () {
        $(".top_wrap").remove();
    });

});
