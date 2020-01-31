/**
 * 弹出对话框
 * @param e           提示信息
 * @param isBgBlack   是否全屏背景变为黑色 ，不写或值为false没有黑色背景
 * @param success     是否是成功
 * @param first_name  第一个按钮名字
 * @param fn          点击第一个按钮需要处理的事,不写该参数表示不处理
 * @param second_name 第二个按钮名字
 * @param fn2         点击第二个按钮需要处理的事,不写该参数表示不处理
 */
function show_addCart(e, isBgBlack, success, first_name, fn, second_name, fn2){
    var su=success;
    if(success){success="success"}else{success="fail"}
    var html="<div class='dialog_addCart'>"+
        "<div class='close'><button class='dialog_close' title='关闭'>╳</button></div>"+
        "<div class='dialog_content'><p><img src='/jfen/images/dialog_"+success+".png' alt=''/>"+e+"</p></div>"+
        "<div class='dialog_footer'>" +
        "<button class='dialog_sure'>"+first_name+"</button><button class='dialog_cancel'>"+second_name+"</button>" +
        "</div></div>";
    $("body").append(html);
    if(!su){$(".dialog_addCart .dialog_footer").remove()}
    var dialog=$(".dialog_addCart");
    if(isBgBlack){ dialog.before("<div class='black'></div>")}
    var black=$(".black");
	$(".dialog_content a").bind("click",function(){window.location.href=$(this).attr("href")});
    $(".dialog_sure").click(function(){
        $(this).parent().parent().fadeOut(300,function(){ $(this).remove();});
        if(fn!=undefined) {
            fn();
        }
        //if(fn2!=undefined) {
         //   fn2();
        //}
        if($(this).parent().parent().prev().hasClass("black"))
            $(this).parent().parent().prev().fadeOut(300,function(){
                $(this).remove();
            });
        return false;
    });
    $(".dialog_cancel,.dialog_close").click(function(){
        $(this).parent().parent().fadeOut(300,function(){$(this).remove();});
        if($(this).parent().parent().prev().hasClass("black")){
            $(this).parent().parent().prev().fadeOut(300,function(){
                $(this).remove();
            });
        }
        return false
    });
    if(black) black.click(function(){$(".black,.dialog_addCart").fadeOut(300,function(){$(this).remove();});return false});
    dialog.click(function(){return false});
}