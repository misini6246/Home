// 右侧导航
$(".quick_links_panel li").mouseenter(function () {
    $(this).children(".mp_tooltip").animate({left: -75, queue: true});
    $(this).children(".mp_tooltip").css("visibility", "visible");
    $(this).children("#sh_kfdh").css("display", "block");
    $(this).find("a").addClass("hover-color");
});
$(".quick_links_panel li").mouseleave(function () {
    $(this).children(".mp_tooltip").css("visibility", "hidden");
    $(this).children(".mp_tooltip").animate({left: -150, queue: true});
    $(this).children("#sh_kfdh").css("display", "none");
    $(this).find("a").removeClass("hover-color");
});
$(".quick_toggle li").mouseover(function () {
    $(this).children(".mp_qrcode").show();
});
$(".quick_toggle li").mouseleave(function () {
    $(this).children(".mp_qrcode").hide();
});

$(window).scroll(function () {

    if (( $(window).scrollTop()) >= 400) {
        $(".subMenu").show()
    } else {
        $(".subMenu").hide()

    }
});