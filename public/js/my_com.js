$(function () {
    /* *
     * 表单验证
     */

    $(".submit").click(function () {

        var user_name = $("#text").val();
        var textarea  = $("#msg").val();

        var errorMsg ="";
        if (user_name=="")
        {
            errorMsg += "主题不能为空" + '\n';
        }

        if (textarea=="")
        {
            errorMsg += "留言内容不能为空" + '\n';
        }

        if (errorMsg !="")
        {
            alert(errorMsg);
			return false;
        }
		return true;
    });
	

	$(".revise").click(function () {
        var email=$(".email").val();
        var msg="";

        if (email == "")
        {
            msg += "邮箱不能为空" + '\n';

        }
        else
        {
            if ( !(/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/.test(email)))
            {
                msg += "电子邮箱格式不正确" + '\n';
            }
        }
        if (msg!="")
        {
            alert(msg);
            return false;
        }
        else
        {
            return true;
        }



    });


    $(".revise2").click(function () {
        var old_password=$(".ypsw").val();
        var new_password=$(".npsw").val();
        var confirm_password=$(".cpsw").val();
        var msg="";
        var reg=null;

        if (old_password == "")
        {
            msg += "原密码不能为空" + '\n';
        }

        if (new_password == "")
        {
            msg += "新密码不能为空" + '\n';
        }

        if (confirm_password == "")
        {
            msg +="密码确认不能为空"  + '\n';
        }

        if (new_password !="" && confirm_password !="")
        {
            if (new_password != confirm_password)
            {
                msg += "密码和密码确认不相同" + '\n';
            }
        }

        if (msg != "")
        {
            alert(msg);
            return false;
        }
        else
        {
            return true;
        }
	});

});