$(function () {
    //	滚动
    $(function () {

        $('#GwcDiv,#wdscDiv').slimScroll({

            height: $('.quick_links_panel').height() - 101

        });
        $('#zncgDiv').slimScroll({

            height: $('.quick_links_panel').height() - 131

        });
        $('#rukou_scroll').slimScroll({

            height: $('.quick_links_panel').height() - 40

        });
    });
    $('.mpbtn_wdsc3').click(function () {
        fixrightclick('#myyaoyigou', '.mpbtn_wdsc3', 'user_info', '');
    })
    $('.mpbtn_wdsc2').click(function () {
        fixrightclick('#fix-gwc', '.mpbtn_wdsc2', 'gwc', '#GwcDiv');
    })
    $('.fixed-sc').click(function () {
        fixrightclick('#wdsc', '.fixed-sc', 'collect_list', '#wdscDiv');
    })
    $('.fixed-zncg').click(function () {
        fixrightclick('#zncg', '.fixed-zncg', 'zncgsp', '#zncgDiv');
    })
    $('.rukou').click(function () {
        fixrightclick('#rukou');
    })

    function fixrightclick(obj, thiscolor, fun, box) {
        var check = $('#check_auth').val();
        if (check == 0 && obj != '#rukou') {
            location.href = '/auth/login';
            return false;
        }
        $('#quick_links li a').removeClass('click-color');
        $('.mpbtn_wdsc2 div').removeClass('click-fontcolor');
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
            $('.mui-mbar-tabs,#right-bgcolor').animate({
                right: 270 + 'px'
            });
            $('.fix-box-show').children().hide();
            $(obj).show();
            $(obj).css({
                'opacity': 1,
                'filter': 'Alpha(Opacity:100)'
            });
            $(thiscolor).addClass('click-color');
            if (obj == '#fix-gwc') {
                $('.mpbtn_wdsc2 div').addClass('click-fontcolor')
            }
            function setScroll() {
                $(box).slimScroll({
                    height: $('.quick_links_panel').height() - sl,
                    alwaysVisible: true
                });
            }
        } else {
            $('.fix-box-show').animate({
                right: -270 + 'px'
            });
            $('.mui-mbar-tabs,#right-bgcolor').animate({
                right: 0
            }, function () {
                $(obj).hide();
            });
            $(thiscolor).removeClass('click-color');
            $('.mpbtn_wdsc2 div').removeClass('click-fontcolor');
        }

    }


//	点击空白处归位
//     $(document).click(function (e) {
//         e = e || window.event;
//         if (e.clientX < $('#body').width() - $('.fix-box-show').width() - $('.mui-mbar-tabs').width()) {
//             $('.fix-box-show').animate({
//                 right: -270 + 'px'
//             });
//             $('.mui-mbar-tabs,#right-bgcolor').animate({
//                 right: 0
//             });
//             $('.quick_links li a').removeClass('click-color');
//             $('.mpbtn_wdsc2 div').removeClass('click-fontcolor');
//             $('#myyaoyigou,#fix-new_gwc,#wdsc,#zncg').hide('slow');
//         }
//     })
})
function quxiao() {
    $('.fix-box-show').animate({
        right: -270 + 'px'
    });
    $('.mui-mbar-tabs,#right-bgcolor').animate({
        right: 0
    }, function () {
        $('.fix-box-show').children().hide();
    });
    $('#quick_links li a').removeClass('click-color');
    $('.mpbtn_wdsc2 div').removeClass('click-fontcolor')
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
        url: '/gwc',
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