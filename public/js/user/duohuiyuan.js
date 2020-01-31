$(function () {
    var $phone = false;
    var $yzm = false;
    var InterValObj;
    var count = 60;
    var curCount;

    function sendMessage() {
        $.ajax({
            url: '/bind_code',
            data: {mobile: $('.phone').val()},
            dataType: 'json',
            success: function (data) {
                if (data.error == 0) {
                    curCount = count;
                    disable_input();
                    $("#submit").attr("disabled", "true");
                    $("#submit").val(+curCount + "s后再次发送");
                    InterValObj = window.setInterval(SetRemainTime, 1000);
                } else if (data.error == 2) {
                    curCount = data.s;
                    disable_input();
                    $("#submit").attr("disabled", "true");
                    $("#submit").val(+curCount + "s后再次发送");
                    InterValObj = window.setInterval(SetRemainTime, 1000);
                    data.error = -1;
                }
                layer.msg(data.msg, {icon: data.error + 1})
            }
        })

    }

    function SetRemainTime() {
        if (curCount == 0) {
            window.clearInterval(InterValObj);
            $("#submit").removeAttr("disabled");
            enable_input()
            $("#submit").val("点击发送验证码");
        } else {
            curCount--;
            $("#submit").val(+curCount + "s后再次发送");
        }
    }

    //第一步验证手机号以及短信验证码
    $('.yz').keyup(function () {
        yzsj($(this));
    });
    $('#submit').hover(function () {
        yzsj($('.yz'));
    });
    $('.yazhengma').focus(function () {
        yzsj($('.yz'));
    });

    function yzsj(_obj) {
        var phone = /^0?(13[0-9]|15[012356789]|17[013678]|18[0-9]|14[57])[0-9]{8}$/;

        //		模拟验证码
        //		当焦点在电话框时的验证
        if (_obj.hasClass('phone')) {
            if (!phone.test(_obj.val())) {
                err('.phone');
                $phone = false;
            } else {
                suc('.phone');
                $phone = true;
                $('#submit').unbind('click');
                $('#submit').on('click', function () {
                    sendMessage();
                })
            }
        }
        //		当焦点在验证码框时的验证
        else if (_obj.hasClass('yazhengma')) {
            if (_obj.val().length != 4) {
                err('.yazhengma');
                $yzm = false;
            } else {
                suc('.yazhengma');
                $yzm = true;
            }
        }

        //		当输入的手机号以及验证码符合标准时解锁下一步按钮
        if ($yzm == true && $phone == true) {
            unlock('#next')
        } else {
            lock('#next')
        }
        if ($phone == true && typeof(curCount) == 'undefined') {
            enable_input()
        } else {
            disable_input()
        }
    }

    //	验证密码
    $('.bangding ul li div.sj .password').keyup(function () {
        if ($(this).hasClass('mima')) {
//			判断密码长度
            if ($(this).val().length >= 6 && $(this).val().length <= 24) {
                suc('.mima');
                $(this).parent().find('p.mm_tishi').hide();
            } else {
                err('.mima');
                $(this).parent().find('p.mm_tishi').show();
            }
        } else if ($(this).hasClass('queren')) {
            if ($(this).val() != $('.bangding ul li div.sj .mima').val()) {
                err('.queren');
                if ($(this).val() == "") { //判断确认密码为空时
                    $(this).parent().find('p.mm_tishi').html("确认密码不能为空！");
                    $(this).parent().find('p.mm_tishi').show();
                } else if ($(this).val() != $('.bangding ul li div.sj .mima').val()) {    //判断确认密码和密码不同时显示提示
                    $(this).parent().find('p.mm_tishi').html("确认密码与密码不一致！");
                    $(this).parent().find('p.mm_tishi').show();
                }
            } else {
                suc('.queren');
                $(this).parent().find('p.mm_tishi').hide();
            }
        }

//		判断密码和确认密码符合规格后解锁按钮
        if ($('#mima').val().length >= 6 && $('#mima').val().length <= 24 && $('#queren').val() == $('#mima').val()) {
            unlock('#btn')
        } else {
            lock('#btn')
        }


    })

    var suc = function (obj) {
        return $(obj).parent().find('img.zt').attr('src', 'http://images.hezongyy.com/images/user/suc.png'),
            $(obj).parent().find('img.zt').show(),
            $(obj).css('border', '1px solid #ccc')
    }
    var err = function (obj) {
        return $(obj).parent().find('img.zt').attr('src', 'http://images.hezongyy.com/images/user/err.png'),
            $(obj).parent().find('img.zt').show(),
            $(obj).css('border', '1px solid #f52547');
    }

    var unlock = function (obj) {
        $(obj).css({
            'opacity': '1',
            'filter': 'Alpha(opacity=100)'
        });
        $(obj).removeAttr("disabled")
        $(obj).unbind('click');
        $(obj).on('click', function () {
            $.ajax({
                url: '/member/duohuiyuan/check_yzm',
                data: {mobile_phone: $('.phone').val(), code: $('.yazhengma').val()},
                dataType: 'json',
                success: function (data) {
                    if (data.error == 0 && data.has == 0) {
                        $('#set_pwd').show();
                        $('#send_code').hide();
                    } else if (data.error == 0 && data.has == 1) {
                        location.reload();
                    }
                    if (data.error > 0) {
                        layer.msg(data.msg, {icon: data.error + 1})
                    }
                }
            })
        })
    }
    var lock = function (obj) {
        $(obj).css({
            'opacity': '0.4',
            'filter': 'Alpha(opacity=20)'
        });
        $(obj).attr("disabled")
    }
    var disable_input = function () {
        $('#submit').unbind('click');
        $('#submit').css({
            'color': '#999',
            'background': '#f5f5f5',
            'border': '1px solid #ccc'
        })
    }
    var enable_input = function () {
        $('#submit').unbind('click');
        $('#submit').on('click', function () {
            sendMessage();
        });
        $('#submit').css({
            'color': '#fff',
            'background': '#4478ec',
            'border': '1px solid #1d54d0'
        })
    }
})