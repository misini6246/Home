$(function () {
    $("img.lazy").lazyload({
        effect: "fadeIn",
        threshold: 200,
        placeholder: "http://app.hezongyy.com/images/small.gif"
    });
    //	左侧排名鼠标悬停显示图片
    $('.paihang-bottom ul li').hover(function () {
        $('.paihang-bottom ul li').css('height', '32px');
        $('.paihang-bottom ul li span:first-child').css({
            'border': '1px solid #bbb',
            'color': '#666666'
        });
        $('.paihang-bottom ul li').children('.hover-before').show();
        $('.paihang-bottom ul li').children('.hover-after').hide();
        $(this).css('height', '68px');
        $(this).find('.hover-before').hide();
        $(this).find('.hover-after').show();
        $(this).find('span:first-child').css({
            'border': '1px solid #e70000',
            'color': '#e70000'
        })
    });
    //				内滚动条
//  $('#shouhou').slimScroll({
//      height: 832,
//      width: 988
//  });

//	点击切换
    $('.xiangqing_bottom_right_title li').click(function () {
        var index = $(this).index();
        $(this).addClass('active').siblings('li').removeClass('active');
        $('.xiangqing_bottom_right_list li').eq(index).addClass('active').siblings('li').removeClass('active');
    })
//	切换图片
    $('.xiaotu_list li').hover(function () {
        var src = $(this).find('img').attr('src');
        var jqimg = $(this).find('img').attr('jqimg');
        $('.xq_datu img').attr('src', src);
        $(this).addClass('active').siblings('li').removeClass('active');
        $('.xq_datu img').attr('jqimg', jqimg);
    })
})