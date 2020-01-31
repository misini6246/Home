/**
 * 弹出对话框
 * @param e         提示信息
 * @param isBgBlack 是否全屏背景变为黑色 ，不写或值为false没有黑色背景
 * @param fn        点击确认按钮需要处理的事,不写该参数表示不处理
 */
function showDialog(e, isBgBlack, fn){
    var html="<div class='dialog'><div class='dialog_title'>" +
        "<button title='关闭' class='dialog_close'></button><h5>提示消息</h5></div>"+
        "<div class='dialog_content'><p>"+e+"</p></div>"+
        "<div class='dialog_footer'>" +
        "<button class='dialog_sure'>确定</button><button class='dialog_cancel'>取消</button>" +
        "</div></div>";
    $("body").append(html);
    var dialog=$(".dialog");
    if(isBgBlack){ dialog.before("<div class='black'></div>")}
    var black=$(".black");
    $(".dialog_sure").click(function(){
        $(this).parent().parent().fadeOut(300,function(){ $(this).remove();});
        if(fn!=undefined) {
            fn();
        }
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
    if(black) black.click(function(){$(".black,.dialog").fadeOut(300,function(){$(this).remove();});return false});
    dialog.click(function(){return false});
}