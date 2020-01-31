$(function () {
    //当点击跳转链接后，回到页面顶部位置
    $("#totop").click(function(){
        $('body,html').animate({scrollTop:0},400);
        return false;
    });

    //var imgs = $.makeArray($(".tebietuijian-box ul li img"));
    //
    //$(".tebietuijian-box ul li").mouseout(function  () {
    //      for (var i=0; i<imgs.length; i++){
    //      // 需要使用自定义的animate函数，不能使用jquery自带的animate函数
    //        animate(imgs[i],{left:0,opacity:1},100);
    //     }
    //});
    //
    //for (var i=0; i<imgs.length; i++) {
    //
    //      imgs[i].onmouseover=function  () {
    //
    //         for (var j=0; j<imgs.length; j++) {
    //         animate(imgs[j],{left:0,opacity:0.7},100);
    //
    //         }
    //         animate(this,{left:-15,opacity:1},100);
    //
    //      }
    //
    //}


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

    //app显示隐藏
    $(".phone-app").hover(function(){
        $(this).addClass("a_tab2");

          $(".app-ewm").show();  
    },function(){
        $(this).removeClass("a_tab2");
        $(".app-ewm").hide(); 
    })

   
    //顶部关闭广告
    $(".close-btns").click(function () {

        $(".top-wrap").remove();
    });

	//地区选择
    $(".select_choose").click(function(e){
        e.stopPropagation();//阻止冒泡但是允许默认事件的发生
        $(this).next(".select_options").slideDown(100);
    });
    $(".select_options li").click(function(){
        var text = $(this).parent().prev().find("span").text();
        var text1 = $(this).text();
        $(this).parent().prev().find("span").text(text1);
        $(this).text(text);
        $(this).parent().slideUp(100);
        if(text1=='四川'){
            $('.sichuan').show();
            $('.xinjiang').hide();
        }else if(text1=='新疆'){
            $('.xinjiang').show();
            $('.sichuan').hide();
        }
        var url = $(this).attr('data-url') ;
        //location.href = url ;
        return false;
    });
    $(":not(.select_choose)").click(function(){
        $(".select .select_options").slideUp(100);
    });

    //商品分类
    $('.all-goods .item').hover(function(){
        $(this).addClass('active').find('s').hide();
        $(this).find('.product-wrap').show();
    },function(){
        $(this).removeClass('active').find('s').show();
        $(this).find('.product-wrap').hide();
    });



     //tab切换
    var index;
    var timeId = null;
    var $lis = $(".notice-hd li");
    var $divs = $(".notice-bd div");
    $lis.hover(function(){
        $that = $(this);
        if(timeId){
            clearTimeout(timeId);
            timeId = null;
        }
        timeId = setTimeout(function(){
            index = $that.index();

            $that.addClass("selected").siblings().removeClass("selected");
            $divs.eq(index).show().siblings().hide();

        },300);

    });

	

	// 标签显示隐藏
    $(".slides").hover(function () {
        $(this).find(".slideContor2").show();
    }, function () {
        $(this).find(".slideContor2").hide();
    })

   


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


    //var times = $("#time-item").attr("data-id");
    ////倒计时
    //var intDiff = parseInt(times); //倒计时总毫秒数量
    //timer(intDiff);

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



	

    // 右侧导航
    $(".quick_links_panel li").mouseenter(function(){
        $(this).children(".mp_tooltip").animate({left:-116,queue:true});
        $(this).children(".mp_tooltip").css("visibility","visible");
        $(this).children(".ibar_login_box").css("display","block");
        $(this).find("a").addClass("hover-color");
    });
    $(".quick_links_panel li").mouseleave(function(){
        $(this).children(".mp_tooltip").css("visibility","hidden");
        $(this).children(".mp_tooltip").animate({left:-150,queue:true});
        $(this).children(".ibar_login_box").css("display","none");
        $(this).find("a").removeClass("hover-color");
    });
    $(".quick_toggle li").mouseover(function(){
        $(this).children(".mp_qrcode").show();
    });
    $(".quick_toggle li").mouseleave(function(){
        $(this).children(".mp_qrcode").hide();
    });

    $(window).scroll(function () {
     
        if (( $(window).scrollTop()) >=  400) {
           $(".subMenu").show()
        }else{
            $(".subMenu").hide()        

        }
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