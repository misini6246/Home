$(function () {
    //首页banner轮播图
    $('.slides').slides({
        container: 'slides_container',
        preload: true,
        play: 100000,
        pause: 1500,
        hoverPause: true,
        effect: 'slide',
        slideSpeed: 850
    });
	
	//地区选择
    $(".select_choose").click(function(e){
        e.stopPropagation();//阻止冒泡但是允许默认事件的发生
        $(this).next(".select_options").slideDown(100);
    });
    $(".select_options li").click(function(){
        $(this).parent().prev().find("span").text($(this).text());
        $(this).parent().slideUp(100);
        var url = $(this).attr('data-url') ;
        location.href = url ;
        return false;
    });
    $(":not(.select_choose)").click(function(){
        $(".select .select_options").slideUp(100);
    });

    //导航条效果
    $('ul.nav_title li a').click(function(){
        $(this).addClass("checked").parent().siblings().find("a").removeClass("checked");

   });
	

	// 标签显示隐藏
    $(".slides").hover(function () {
        $(this).find(".slideContor2").show();
    }, function () {
        $(this).find(".slideContor2").hide();
    })

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


	//弹出广告效果
	$('.close').click(function(){
		$('.zzsc').hide(0);
		$('.content_mark').hide(0);
	});

	//5秒自动关闭
	$('.zzsc').show(0);
	$('.content_mark').show(0).css("filter","alpha(opacity=40)");
	setTimeout(function () {
        $(".zzsc").hide();
        $(".content_mark").hide();
    },5000);


	//cookie控制弹框
	//var expiresDate= new Date();
    //expiresDate.setTime(expiresDate.getTime() + (60* 60 * 1000)); //替换成分钟数如果为60分钟则为 60 * 60 *1000

	//var COOKIE_NAME = "showbox";	
	//if($.cookie(COOKIE_NAME)){
		//$('.zzsc').hide(0);
		//$('.content_mark').hide(0);
	//}else{
		//$('.zzsc').show(0);
		//$('.content_mark').show(0).css("filter","alpha(opacity=40)");
	//}
	//$.cookie(COOKIE_NAME,'ishide',{expires : expiresDate});
    //setTimeout(function () {
        //$(".zzsc").hide();
        //$(".content_mark").hide();
    //},5000);

    //图片延迟加载
    $("img").lazyload({
        placeholder : "images/grey.gif",
        effect : "fadeIn"
    });

    //求购公告
    $("#newly").hover(function(){
        clearInterval(scrtime);
    },function(){
        scrtime=setInterval(function(){
            $ul=$("#newly");
            liheight=$ul.find("li:first").height();
            $ul.animate({marginTop:"0px"},1000,function(){
                $ul.find("li:first").appendTo("#newly");
                $ul.find("li:first").hide();
                $ul.css("margin-top","0px");
                $ul.find("li:first").show();
            });
        },2000);
    }).trigger("mouseleave");


    //倒计时
	var times = $("#time-item").attr("data-id");
	//倒计时
	var intDiff = parseInt(times); //倒计时总毫秒数量
    timer(intDiff);
	
	//左侧抖动效果
	$(".main_list img").each(function(k,img){
        new JumpObj(img,10);
        //第一个参数代表元素对象
        //第二个参数代表抖动幅度
    });
});


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