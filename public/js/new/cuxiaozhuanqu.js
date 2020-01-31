$(function () {
    $(document).ready(function () {
        $('.remaintime').remaintime({
            time: parseInt($('#daojs').val()),
            hourse: '.hourse',
            minute: '.minute',
            second: '.second',
            day: '.day',
            Boolean: true
        })
    });
    $('.title_list').singlePageNav({
        offset: 80
    });
    // $(".title_list").navigation({
    //     parent: ".title_list",
    //     target: ["#mzjx", "#xqpz", "#czhg", "#jpmz"],
    //     current: "active"
    // })
    // var title_list = $('.title_list').offset().top
//	title_list滑动样式
    $(window).scroll(function () {
        $(window).scrollTop() > title_list ? $('.title_list').addClass('fixed') : $('.title_list').removeClass('fixed')
    })
    $('.layer_tips').hover(function () {
        var msg = $(this).data('msg');
        var id = $(this).attr('id');
        layer.tips(msg, '#' + id, {
            tips: [1, '#3dbb2b'],
            time: 0,
            id: 'layer_tips'
        });
    }, function () {
        layer.closeAll();
    });

})