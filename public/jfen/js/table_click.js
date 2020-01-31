/**
 * Created by wang on 14-9-21.
 */
$(function(){
    var tr=$(".all_address tbody tr");
    tr.hover(function(){
       $(this).siblings("tr").css({"background":"#f9f9f9",color: "#4b4b4b"});
       $(this).css({"background":"#f95706",color: "#fff"});
       $(this).find(".color_f9").css("color","#fff");
       $(this).find(".orderid a").css("color","#fff");
       return false;
    },function(){
       $(this).css({"background":"#f9f9f9",color: "#4b4b4b"});
        $(this).find(".orderid a").css("color","#4b4b4b");
       $(this).find(".color_f9").css("color","#f95706");
    });
});