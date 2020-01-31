$(function () {
    $('.djbz_change li').hover(function () {

        var index = $(this).index();

        $(this).addClass('active').siblings('li').removeClass('active');

        $('.djbz_list li').eq(index).addClass('active').siblings('li').removeClass('active');
        var url = $(this).data('url');
        $('#ckqb').attr('href', url)
    })

    var len = $('.xprm_right_animate div').length;
    for (var i = 0; i < len; i++) {
        $('.xprm_num').append("<li></li>")
    }
    $('.xprm_num li:first-child').addClass('active');
    $('.xprm_num li').hover(function () {
        var index = $(this).index();
        $(this).addClass('active').siblings('li').removeClass('active');
        $('.xprm_right_animate div').eq(index).fadeIn(500).siblings('div').fadeOut(500)
    });
});