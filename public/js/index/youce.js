$(function () {
    //	右侧悬停显示效果
    $('#right_bar li').hover(function () {
        $(this).find('.right_bar_list_show').stop().animate({
            right: '33px'
        }, 300).show()
    }, function () {
        $(this).find('.right_bar_list_show').stop().animate({
            right: '150px'
        }, 0).hide()
    });
    //	回到顶部
    $('.to_top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 600)
        return false;
    });
    //	点击展开
    $('.right_gwc').click(function () {
        fixrightclick('#fix-new_gwc', '.right_gwc', 'new_gwc', '#GwcDiv');
    })
    $('.right_myyyg').click(function () {
        fixrightclick('#myyaoyigou', '.right_myyyg', 'user_info', '');
    })
    $('.right_sc').click(function () {
        fixrightclick('#wdsc', '.right_sc', 'collect_list', '#wdscDiv');
    })
    $('.right_zncg').click(function () {
        fixrightclick('#zncg', '.right_zncg', 'zncgsp', '#zncgDiv');
    })
    //	点击展开
    function fixrightclick(obj, thiscolor, fun, box) {
        var check = $('#check_auth').val();
        if (check == 0 && obj != '#rukou') {
            location.href = '/auth/login';
            return false;
        }
        $('.right_bar_list li').removeClass('click-color');
        var sl = 101;
        if (obj == '#zncg') {
            sl = 71
        }
        if ($(obj).css('opacity') == 0 || $(obj).css('filter') == 'Alpha(Opacity:0)' || $(obj).css('display') == 'none') {
            if (obj != '#rukou') {
                $.ajax({
                    url: '/yc/' + fun,
                    type: 'get',
                    dataType: 'html',
                    success: function (data) {
                        $(obj).html(data);
                        if (box != '') {
                            setScroll();
                            $(box).slimScroll().bind('slimscroll', function (e, pos) {
                                if (pos == 'bottom') {
                                    page = parseInt($('#' + fun).attr('page'));
                                    $.ajax({
                                        url: '/yc/' + fun,
                                        type: 'get',
                                        data: {full_page: 0, page: page + 1},
                                        dataType: 'html',
                                        success: function (data) {
                                            $('#' + fun).attr('page', page + 1);
                                            $('#' + fun).append(data);
                                            $(window).on("resize", setScroll);
                                        }
                                    });
                                }
                            });
                        }
                    }
                });
            }
            $('.fix-box-show').animate({
                right: 0
            });
            $('#right_bar').animate({
                right: 270 + 'px'
            });
            $('.fix-box-show').children().hide();
            $(obj).show();
            $(obj).css({
                'opacity': 1,
                'filter': 'Alpha(Opacity:100)'
            });
            $(thiscolor).addClass('click-color');
            function setScroll() {
                $(box).slimScroll({
                    height: $('#right_bar').height() - sl,
                    alwaysVisible: true
                });
            }
        } else {
            $('.fix-box-show').animate({
                right: -270 + 'px'
            });
            $('#right_bar').animate({
                right: 0
            }, function () {
                $(obj).hide();
            });
            $(thiscolor).removeClass('click-color');
            $('.right_bar_list li').removeClass('click-color');
        }

    }
})
function quxiao() {
    $('.fix-box-show').animate({
        right: -270 + 'px'
    });
    $('#right_bar').animate({
        right: 0
    }, function () {
        $('.fix-box-show').children().hide();
    });
    $('.right_bar_list li').removeClass('click-color');
}

function shanchu(msg, id, fun, obj) {
    layer.confirm(msg, function () {
        $.ajax({
            url: '/yc/' + fun,
            type: 'get',
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                if (data.error == 0) {
                    obj.parents("li").remove();
                    if (fun == 'delete_gwc') {
                        $('.cart_number').html(data.num);
                        $('#gwc_total').html(data.total);
                    }
                }
                layer.msg(data.msg, {icon: data.error + 1});
            }
        });
    })
}

function newtocart(id, num) {
    $.ajax({
        url: '/new_gwc',
        data: {id: id, num: num},
        dataType: 'json',
        success: function (data) {
            if (data.error == 0) {
                $('.cart_number').html(data.num);
                layer.confirm(data.msg, {
                    btn: ['继续购物', '去结算'], //按钮
                    icon: 1
                }, function (index) {
                    layer.close(index);
                }, function () {
                    location.href = '/cart';
                    return false;
                });
            } else if (data.error == 2) {
                layer.confirm(data.msg, {
                    btn: ['注册', '登录'], //按钮
                    icon: 2
                }, function () {
                    location.href = '/auth/register';
                }, function () {
                    location.href = '/auth/login';
                    return false;
                });
            } else {
                layer.alert(data.msg, {icon: 2})
            }
        }
    })
}