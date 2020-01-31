$(function () {
    $("#search_box input[type=text]").focus(function () {
             $(this).val("");

    });

	$(".btn").click(function () {
        var names=$("#buy_name").val();
        var phone=$("#buy_tel").val();
        var drug=$("#buy_goods").val();
        var factory=$("#product_name").val();
        var norms=$("#buy_spec").val();
        var nums=$("#buy_number").val();
        var price=$("#buy_price").val();
        var validity=$("#buy_time").val();
        var msgs=$("#message").val();
        var msg="";

        if (names == "")
        {
            msg += "联系人不能为空" + '\n';

        }

        if (phone == "")
        {
            msg += "联系电话不能为空" + '\n';

        }
        if (drug == "")
        {
            msg += "求购药品不能为空" + '\n';

        }
        if (factory == "")
        {
            msg += "生产厂家不能为空" + '\n';

        }
        if (norms == "")
        {
            msg += "药品规格不能为空" + '\n';

        }
        if (price == "")
        {
            msg += "求购价格不能为空" + '\n';

        }

        if (nums == "")
        {
            msg += "求购数量不能为空" + '\n';

        }
        if (validity == "")
        {
            msg += "有效期不能为空" + '\n';

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


