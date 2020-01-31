/**
 * Created by wang on 14-9-21.
 */
$(function(){
    var login_window=$(".login_window input");
    login_window.focusin(function(){
        $(this).parent().children("span").fadeOut(200);
        $(this).css({"border":"1px solid #68abf7"});
    });
    login_window.keydown(function(){
        $(this).parent().children("span").fadeOut(200);
    });
    login_window.focusout(function(){
        if($(this).val()=="") $(this).parent().children("span").fadeIn(200);
        $(this).css({"border":"1px solid #b7baba"});
    });

    $(".login").click(function(){//点击登录
        var username=$(".username");
        var password=$(".password");
        var alert=$(".alert");
        var html=alert.html();
        if(username.val()==""||password.val()==""){
            alert.css({"border":"1px solid #ff5555"});
            alert.animate({height:"30px"},100);
        }else{
            alert.css({"border":"0"});
            alert.animate({height:"0"},100);
            var name=username.val();
            var pass=password.val();
            $.ajax({type: "post",url: "api/user/test",data: {name: name,password: pass},success: function(msg){
//                do sth
            }})
        }
        return false
    });
});