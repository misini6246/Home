$(function () {

	//导航条效果
    $('ul.nav_title li a').click(function(){
        $(this).addClass("checked").parent().siblings().find("a").removeClass("checked");

   });

	//左侧导航
    $(".title_nav").hover(function () {
        $(".left_nav").stop().show();
        $(".title_nav .title_ico").hide();


    }, function () {
        $(".left_nav").stop().hide();
        $(".title_nav .title_ico").show();

    });


    //左侧导航
    $(".nav_list .child_li").hover( function () {
        var cur =$(this).index();
        $(this).addClass("on");
        $(".box").show();
        $(".box li").eq(cur).show().siblings("li").hide();
        $(this).prev().find("p").css("border-bottom",0);


    }, function () {

        $(this).removeClass("on");
        $(this).prev().find("p").css("border-bottom","1px solid #e0e0e0");

    });


    $(".left_nav").hover(function () {
        $(".box").show();
    }, function () {
        $(".box").hide();
    });
    $(".box li").hover(function () {
        var cur=$(this).index();
        var _this= $(".nav_list .child_li");

        _this.eq(cur).addClass("on");
        _this.eq(cur-1).find("p").css("border-bottom",0)

    }, function () {
        var cur=$(this).index();
        var _this= $(".nav_list .child_li");
        _this.eq(cur).removeClass("on");
        _this.eq(cur-1).removeClass("on").find("p").css("border-bottom","1px solid #e0e0e0");
    });

	$(".jiyao").hover(function () {
        $(".box").addClass("big_box");
    }, function () {
        $(".box").removeClass("big_box");
    });

});




