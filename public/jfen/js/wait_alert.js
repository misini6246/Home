/**
 * Created by wang on 14-10-10.
 */
function wait_alert(parent){
    var html="<div class='wait'><p><img src='/jfen/images/loading.gif' alt=''/><span>正在处理，请稍后...</span></p></div>";
    parent.append(html);
    setTimeout(function(){
        $(".change_black").remove();
    },100);
    $(".wait").css({top: "200px",marginTop: "0",position: "fixed"});
}
function remove_wait(a,isWait){
	$("body").one("click",function(){
        wait.remove();
    });
    var wait=$(".wait");
    if(!isWait){isWait=false}
    wait.find("p").html(a);
    if(isWait){
        setTimeout(function(){
            wait.remove();
        },3000);
    }
}