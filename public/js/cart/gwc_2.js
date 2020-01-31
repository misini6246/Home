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
    $('.dh_list li,.zhifufangshi_list li').on('click', function () {
        $(this).addClass('active').siblings().removeClass('active');
    })
});

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
    // var shipping = $('input[name=shipping]').val();
    // if (shipping == 0) {
    //     layer.msg('请选择配送物流', {icon: 0});
    //     return false;
    // }
    var pay_id = $('.zhifufangshi_list .active').data('id');
    $('input[name=payment]').val(pay_id);
    var gift = $('.dh_list .active').data('name');
    if (typeof(gift) != 'undefined') {
        $('input[name=gift]').val(gift);
    }
    return true;
}