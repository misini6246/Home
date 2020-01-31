/**
 * Created by wang on 14-9-21.
 */
$(function(){
//    左边菜单
    var accordion_list=$(".accordion_list_out");
    accordion_list.first().find("p").css("border","0");
    accordion_list.find("ul li:first").css("border","0");
    accordion_list.find("ul li a").hover(function(){
        $(this).css("color","#ff9100");
    },function(){
        $(this).css("color","#474747");
    });
    accordion_list.find("p").click(function(){
        var lt=$(this);
        lt.parent().siblings("div").find("i").css("background","url('/jfen/images/my_page_toRight.png') center no-repeat");
        lt.find("i").css("background","url('/jfen/images/my_page_toDown.png') center no-repeat");
        lt.parent().siblings("div").find("ul").slideUp(300);
        lt.next("ul").slideDown(300);
    });
//    end
//    底部推荐
    $(".prompt_left").click(function(){
        var ul=$(this).next("ul");
        var li=$(this).next("ul").find("li");
        li.eq(0).animate({marginLeft: -li.width()+"px"},200,function(){
            li.eq(0).css("margin-left",0);
            li.eq(0).appendTo(".prompt ul");
        });
    });
    $(".prompt_right").click(function(){
        var ul=$(this).prev("ul");
        var li=$(this).prev("ul").find("li");
        li.last().prependTo(".prompt ul");
        ul.css("margin-left",-li.width()+"px");
        ul.animate({marginLeft: 0+"px"},200);
    });
});