$(function(){
   $(".search_nav ul li").click(function(){
       $(this).siblings().css({"backgroundColor": "#fff"});
       $(this).siblings().find("a").css({"color": "#454545"});
       $(this).css({"backgroundColor": "#ff9100"});
       $(this).find("a").css({"color": "#fff"});
   });
    $(".etc_class_list li").each(function(n,e){
        if((n+1)%5==1){
            $(e).css("margin-left",0);
        }
    });

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
