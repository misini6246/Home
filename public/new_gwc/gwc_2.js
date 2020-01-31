$(function () {
//	滚动定位结算
    $(window).scroll(function () {
        var h = $(window).height() - $('.feiyong').height() - 70;
        var t = $(document).scrollTop();
        if (t >= $('.feiyong').offset().top - h) {
            $('.manage').removeClass('fixed_manage');
        } else {
            $('.manage').addClass('fixed_manage');
        }
    })
    $('.dh_list li,.zhifufangshi_list li').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    })
});

//选择优惠卷
//$('.youhuijuan_list li').click(function(){
//	if($(this).hasClass("use")){
//		$(this).addClass('none').removeClass('use active').find('.use_box').addClass('none_box').removeClass('use_box');
//		$(this).find('img').hide()
//	}else{
//		$(this).addClass('use active').removeClass('none').find('.none_box').addClass('use_box').removeClass('none_box');
//		$(this).find('img').show()
//	}
//})

function check_all() {
    $('.all_goods').show();
    $('#zhankai').hide();
    $('#shouqi').show();
}
function shouqi() {
    $('.all_goods').hide();
    $('#shouqi').hide();
    $('#zhankai').show();
}

function check_sub() {
    var shipping = $('input[name=shipping]').val();
    //if (shipping == 0) {
    //    layer.msg('请选择配送物流', {icon: 0});
    //    return false;
    //}
    var pay_id = $('.zhifufangshi_list .active').attr('data-id');
    $('input[name=payment]').val(pay_id);
    var gift = $('.dh_list .active').data('name');
    if (typeof(gift) != 'undefined') {
        $('input[name=gift]').val(gift);
    }
    return true;
}