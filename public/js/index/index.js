$(function () {
    var show_top = $('#banner').offset().top + parseInt($('#banner').height() / 2);
    var show_bottom = $('#cjtj').offset().top + parseInt($('#fixedNavBar').height() + 100);
    $("#fixedNavBar ul").navigation({
        parent: "#fixedNavBar",
        target: ["#mzjx", "#ppzq", "#wntj", "#djrx", "#jybj", "#zyyp", "#cjtj"],
        current: "active",
        top_show: show_top,
        bottom_show: show_bottom
    })
    //	赖加载
    $("img.lazy").lazyload({
        effect: "fadeIn",
        threshold: 200,
        placeholder: "http://app.hezongyy.com/images/small.gif"
    });
    //	banner右侧广告
    $('.slide_right_title li').hover(function () {
        var index = $(this).index();
        $(this).addClass('active').siblings('li').removeClass('active');
        $('.slide_right_list').eq(index).addClass('active').siblings('ul').removeClass('active');
        $('.tgd').hide();
        $('.tgd').eq(index).show();
    })
    //  每周精选定时器
    $(document).ready(function () {
        $('.remaintime').remaintime({
            time: $('#daojs').val(),
            hourse: '.hourse',
            minute: '.minute',
            second: '.second',
            day: '.day',
            Boolean: true
        })
    });
    //	fixed搜索
    $(window).scroll(function () {
        if ($(window).scrollTop() > $('#nav').offset().top) {
            $('#fixed_search').show()
        } else {
            $('#fixed_search').hide()
        }
    })
    //	电梯导航singlepagenav
    $('#fixedNavBar').singlePageNav({
        offset: 60
    });
    //弹出广告效果
    $('.close').click(function () {
        $('.zzsc').hide(0);
        $('.content_mark').hide(0);
    });
    //5秒自动关闭
    $('.zzsc').show(0);
    $('.content_mark').show(0).css("filter", "alpha(opacity=40)");
    // setTimeout(function () {
    //     $(".zzsc").hide();
    //     $(".content_mark").hide();
    // }, 5000);
})