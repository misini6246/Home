/**
 * Created by wang on 14-9-21.
 */
$(function(){
//    左边菜单
    var accordion_list=$(".accordion_list_out");
    accordion_list.find("ul").eq(0).css("display","block");
    accordion_list.eq(0).find("p i").css("background","url('themes/images/list_down.png') center no-repeat");
    accordion_list.first().find("p").css("border","0");
    accordion_list.find("ul li:first").css("border","0");
    accordion_list.find("ul li a").hover(function(){
        $(this).css("color","#f6000c");
    },function(){
        $(this).css("color","#f87017");
    });
    accordion_list.find("p").click(function(){
        var lt=$(this);
        lt.parent().siblings("div").find("i").css("background","url('themes/images/list_right.png') center no-repeat");
        lt.find("i").css("background","url('themes/images/list_down.png') center no-repeat");
        lt.parent().siblings("div").find("ul").slideUp(300);
        lt.next("ul").slideDown(300);
    });
//    end
});