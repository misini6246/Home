$(function () {

    $(".revise_1").click(function () {
        var email=$(this).parents("form").find(".email").val();
        var names=$(this).parents("form").find(".names").val();
        var selects1=$(this).parents("form").find(".selects1").val();
        var selects2=$(this).parents("form").find(".selects2").val();
        var selects3=$(this).parents("form").find(".selects3").val();
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
        if (selects1 == "")
        {
            msg += "请选择相关的省" + '\n';

        }
        if (selects2 == "")
        {
            msg += "请选择相关的市" + '\n';

        }
        if (selects3 == "")
        {
            msg += "请选择相关的县" + '\n';

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




