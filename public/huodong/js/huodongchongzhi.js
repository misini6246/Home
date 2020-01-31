/**
 * Created by admin on 2017/3/6.
 */

$(document).ready(function () {
    //        点击提交后弹出支付框
    $('#subbtn').click(function () {
        var type = 0;
        var type1 = 0;
        var cat_id = 0;
        var pay_id = 0;
        $('.tihuan').each(function () {
            var status = $(this).find('.gou').css('display');
            console.log(status);
            if (status == 'block') {
                type++;
                cat_id = parseInt($(this).attr('cat_id'));
            }
        });
        $('.paychoose').each(function () {
            var status = $(this).find('.payimg').css('display');
            console.log(status);
            if (status == 'block') {
                type1++;
                pay_id = parseInt($(this).attr('pay_id'));
            }
        });
        if (type == 0) {
            alert('请选择充值包');
            return false;
        } else if (type > 1) {
            alert('只能选择一个充值包');
            return false;
        }
        if (type1 == 0) {
            alert('请选择支付方式');
            return false;
        } else if (type1 > 1) {
            alert('只能选择一个支付方式');
            return false;
        }
        $.ajax({
            url: '/cz/cz',
            data:{cat_id:cat_id,pay_id:pay_id},
            success:function (data) {
                if(data.error==0){
                    if(pay_id!=7) {
                        $('.Bombbox').css('display', 'block')
                        $('#order_id').val(data.order_id);
                        $('#pay_id').val(pay_id);
                        $('#form').submit();
                    }else{
                        weixin(data.order_id,pay_id);
                    }
                    int = setInterval("search_pay_status("+data.order_id+","+pay_id+")", 3000)

                }
            }
        });
        return false;
    })
    //        点击提交后弹出支付框

    //        框体弹出后点击X按钮关闭掉
    $('.close').click(function () {
        $('.Bombbox').css('display', 'none')
    })
    //        框体弹出后点击X按钮关闭掉

    //      通过替换图片来改变input的样式
    //这是支付金额选择的input样式
    var chooseborder = $('.tihuan');
    var chooseimg = $('.gou')


    for (var i = 0; i < chooseborder.length; i++) {
        chooseborder[i].onclick = function () {
            for (var j = 0; j < chooseimg.length; j++) {
                var dangqian = this;
                if (dangqian == chooseborder[j]) {
                    $(chooseimg[j]).toggle()
                } else {
                    $(chooseimg[j]).hide()
                }
            }

        }
    }
    //这是支付金额选择的input样式结束

    var paychoose = $('.paychoose');
    var payimg = $('.payimg');
    for (var i = 0; i < paychoose.length; i++) {
        paychoose[i].onclick = function () {
            for (var j = 0; j < payimg.length; j++) {
                var dangqian = this;
                if (dangqian == paychoose[j]) {
                    $(payimg[j]).toggle()
                } else {
                    $(payimg[j]).hide()
                }
            }

        }
    }
    //      通过替换图片来改变input的样式
});

//解决IE6 png图片透明度
DD_belatedPNG.fix('#znq-daohang,.gou,.payimg');
//解决IE6 png图片透明度

//解决IE CSS3一些效果问题
$(function () {
    if (window.PIE) {
        $('#subbtn').each(function () {
            PIE.attach(this);
        });
    }
});
//解决IE CSS3一些效果问题
function weixin(order_id,pay_id){
    var mask = $("<div class=mask></div>");
    $("body").append(mask);
    $.ajax({
        url:"/cz/pay",
        data:{order_id:order_id,pay_id:pay_id},
        dataType:"json",
        success:function(data){
            $("body").find(".mask").remove();
            if(data.status === 500){
                alert(data.msg);
            }
            else if(data.status === 200){
                window.location="/user/payOk?id=304829&type=4";
            }
            else{
                $("#code_img_url").attr("src",data.code_img_url);
                $(".pop-wraper").show();
                int = setInterval("search_weixin()", 3000)
            }
        }
    })
}
function search_pay_status(order_id,pay_id){
    $.ajax({
        url:"/cz/search",
        data:{order_id:order_id,pay_id:pay_id},
        success:function($result){
            if($result==0){
                window.location="/user/payOk?id="+order_id+"&type=4";
            }
        }
    });
}