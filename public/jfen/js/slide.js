/**
 * Created by wang on 14-8-27.
 */
/**
 * 幻灯片
 * @param parent    幻灯片父节点
 * @param run_time  运行一次幻灯片时间
 */
function slide(parent,run_time){
    var n = 0,interval, th,time= false,lastPosition=0;
    var slide_num=$(".slide .slide_num");
    var count=parent.find("a").length;
    parent.find("a:not(:first)").hide();
    slide_num.find("li").bind("mouseover",function(event){
        event.stopPropagation();
        th=$(this);
        setTimeout(function(){
            if(th){
                var i = th.attr("data-value") - 1;//获取Li元素内的值
                n = i;
                if(lastPosition != i){
                    lastPosition= i;
                    if (i >= count) return;
                    parent.find("a").stop();
                    parent.find("a").filter(":visible").fadeOut(200,function(){$(this).parent().children().eq(i).fadeIn(200)});
                    slide_num.css("background","");
                    th.toggleClass("on");
                    th.siblings(".on").removeAttr("class");
                    th=null;
                    time=0;
                }
            }
        },500);
    });
    interval= setInterval(function(){showAuto(count)},run_time);
    parent.hover(function(e){
        e.stopPropagation();
        clearInterval(interval);

    },function(){
        interval= setInterval(function(){showAuto(count)},run_time);
    });
}
function showAuto(count){
    var n=$(".slide_num li[class='on']").attr("data-value");
    if(n>=count){ n = 0}
    $(".slide").find("li").eq(n).trigger('mouseover');
}