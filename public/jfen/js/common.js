//兑换热榜
//function exchangeHot(exchange){
//    $(".exchange_hotList_list:odd").css("background-color","#f5f5f5");
//    var exchange_hotList=$(".exchange_hotList");
//    $(window).scroll(function(){
//        var scrollTop=exchange.offset().top-$(window).scrollTop();
//        var footer_scroll=$(".footer").offset().top-$(window).scrollTop();
//        if(exchange_hotList.offset().top+exchange_hotList.height()<exchange.offset().top+exchange.height()){
//            console.log(scrollTop);
//            if(scrollTop<=0){
//                exchange_hotList.css({"position":"fixed"});
//                exchange_hotList.next("div").css("margin-left","243px");
//            }else if(scrollTop>0){
//                exchange_hotList.css({"position":"static"});
//                exchange_hotList.next("div").css("margin-left","25px");
//            }
//            if(exchange_hotList.offset().top-parseInt(exchange_hotList.height())>footer_scroll){
//                exchange_hotList.css({bottom: exchange.css("bottom")});
//            }
//        }else{
////            exchange_hotList.css({"top": (-exchange_hotList.offset().top-exchange_hotList.height()+exchange.offset().top+exchange.height())+"px"});
//        }
//    });
//}


//    收藏网站
function collect(){
    var url = "http://www.hezongyy.com";
    var $title = $('title').text();
    try{
        window.external.addFavorite(url, $title);
    }catch(e) {
        try{
            window.sidebar.addPanel($title, url, "");
        }catch (e) {
            alert("加入收藏失败，请使用Ctrl+D进行添加,或手动在浏览器里进行设置.");
        }
    }
}
$(function(){
//热门排行榜和网页底部加target
    $(".exchange_hotList a").attr("target","_blank");
    $(".footer ul li a").attr("target","_blank");

//导航栏hover
    $(".cnd_list li").hover(function(){
        $(this).css({backgroundColor: "#ff9100"})
    },function(){
        $(this).css({background: "none"});
    });


//下拉框
//10-14
    $(".select_choose").click(function(e){
        stopPropagation(e);//阻止冒泡但是允许默认事件的发生
        if($(this).next().find("li").length>0){
            $(this).next(".select_options").slideDown(100);
        }
        if($(this).next().height()<300){
            $(this).next().css({"overflow": "hidden"});
        }else{
            $(this).next().css({"overflow": "scroll"});
        }
    });
	$(".select_options li").live({"mouseover":function(){
        	$(this).css({backgroundColor: "#ddd"});
    	    },"mouseout":function(){
        	$(this).css({background: "none"});
    	    }});
    $(".select_options li").live("click",function(){
        var span=$(this).parent().prev().find("span");
        span.text($(this).text());
        span.attr("data-id",$(this).attr("data-id"));
        var next=$(this).parent().parent().nextAll(".choose_select");
        $(this).parent().slideUp(100);
        
		next.find(".select_choose span").attr("data-id",0);
        next.find(".select_choose span").html("请选择...");
        next.find("ul").html("");

        return false;
    });
    $(":not(.select_choose)").click(function(){
        $(".select .select_options").slideUp(100);
    });
//end

//到顶部
    $(".to_top ul li").hover(function(){
        $(this).css("background-color","#fff");
        $(this).find("img").attr("src",$(this).find("img").attr("src").replace('.png','_y.png'));
        $(this).find("p").css("color","#ff9100");
    },function(){
        $(this).css("background-color","#ff9100");
        $(this).find("img").attr("src",$(this).find("img").attr("src").replace('_y.png','.png'));
        $(this).find("p").css("color","#fff");
    });

    function checkHeight() {
        var to_top = $(".to_top");
        var footer = $(".footer");
        if(to_top.offset().top+to_top.height() >= footer.offset().top){
            to_top.css({bottom: $(window).height()-footer.offset().top + $(window).scrollTop()});
        }else if(to_top.offset().top+to_top.height() < footer.offset().top){
            to_top.css({bottom: $(window).height()-footer.offset().top + $(window).scrollTop()});
            if(parseInt(to_top.css("bottom"))<=50){
                to_top.css({bottom: "50px"});
            }
        }
    }
    checkHeight();
    $(window).scroll(function(){checkHeight();});
    $('.to_top .to_head').click(function(){$('html,body').animate({scrollTop: '0'}, 500);});
//end

//超过变。。。
    $(".hot_things_msg a").each(function(n,e){
        $(e).text(changeToPoint($(e).text(),22));
    });
//    end

    $(".search_btn .button").click(function(){
        var value= parseInt($(".integral_search .select_choose span").attr("data-id"));
        if(value > 0 && value) {
			location.href = '/jf/search?s='+value ;
		}
    });
});

//阻止冒泡
function stopPropagation(e) {
    e = e || window.event;
    if(e.stopPropagation) { //W3C阻止冒泡方法
        e.stopPropagation();
    } else {
        e.cancelBubble = true; //IE阻止冒泡方法
    }
}
function changeToPoint(str,len){
    if(str.length>25){
        return str.substring(0,len)+"···";
    }else{
        return str;
    }
}
