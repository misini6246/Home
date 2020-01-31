$(function () {

    $(".revise").click(function () {

        var email=$(this).parents("form").find(".email").val();
        var names=$(this).parents("form").find(".names").val();
        var selects1=$(this).parents("form").find(".selects1").val();
        var selects2=$(this).parents("form").find(".selects2").val();
        var selects3=$(this).parents("form").find(".selects3").val();
		var selects4=$(this).parents("form").find(".selects4").val();
        var address=$(this).parents("form").find(".address").val();
        var phone=$(this).parents("form").find(".phone").val();
        var msg="";

        //if (email == "")
        //{
        //    msg += "邮箱不能为空" + '\n';
        //
        //}
        //else
        //{
        //    if ( !(/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/.test(email)))
        //    {
        //        msg += "电子邮箱格式不正确" + '\n';
        //    }
        //}
        if (names == "")
        {
            msg += "姓名不能为空" + '\n';

        }
        if (selects1 == 0)
        {
            msg += "请选择相关的国家" + '\n';

        }
        if (selects2 == 0)
        {
            msg += "请选择相关的省份" + '\n';

        }
        if (selects3 == 0)
        {
            msg += "请选择相关的市" + '\n';

        }
        if (selects4 == 0)
        {
            msg += "请选择相关的县或区" + '\n';

        }
        if (address == "")
        {
            msg += "请填写详细地址" + '\n';

        }
        if (phone == "")
        {
            msg += "电话号码不能为空" + '\n';

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





});




