var user_rank = 2;//用户类型   1：药店  2：诊所  3：连锁公司  4：商业公司
var area = '';
var verify_result = '';
var ie;//用于判断IE版本号
var mobile = $('#mobile').val();
var verify_status = false;

$(function () {
    $('#area').val('')
    $.ajax({
        url: '/xin/register/check_code',
        type: 'post',
        data: {mobile: mobile},
        dataType: 'json',
        success: function (data) {
            if (data.error == 1) {
                location.href = '/xin/register/step1'
            } else if (data.error == 2) {
                location.href = '/'
            }
        }
    })
    //判断浏览器版本
    ie = IEVersion();
    $('#pwd_friend').hide()
    $('#con_pwd_friend').hide()
    //解决兼容
    if (ie == 7) {
        $('input').focus(function () {
            set_dom_style($(this), '', {'color': "#2069F2"})
        }).blur(function () {
            set_dom_style($(this), '', {'color': "#666666"})
        })
    } else if (ie == 9) {
        $('.password').find('input').after("<input id='pwd_friend' type='text' placeholder='请输入6-24位英文、数字、“-”组成的密码'/>");
        $('.con_pwd').find('input').after("<input id='con_pwd_friend' type='text' placeholder='再次输入密码'/>");

        $('#user_name').placeholder();

        $('#password').placeholder();
        $('#password').hide()
        $('#pwd_friend').show().focus(function () {
            $("#pwd_friend").hide();
            $('#password').show().focus().blur(function () {
                if (!reg_pwd($(this).val())) {
                    set_dom_style($(this), '', {
                        'color': '#e21e1e',
                        'background-color': '#FFF2F2'
                    })
                    $(this).addClass('ipt_false')
                } else {
                    set_dom_style($(this), '', {
                        'color': '#333333',
                        'background-color': '#EFF0F4'
                    })
                }
                if ($(this).val() == $(this).attr('placeholder')) {
                    $("#pwd_friend").show();
                    $('#password').hide()
                    return false;
                }
                //input内添加按钮
                if ($(this).val() != '') {
                    add_input_btn(this, '.password', 1, reg_pwd($(this).val()))
                }
            })
        }).blur(function () {
            if ($(this).val() == $(this).attr('placeholder')) {
                set_dom_style($(this), '', {
                    'color': '#e21e1e',
                    'background-color': '#FFF2F2'
                })
                $(this).addClass('ipt_false')
                add_input_btn(this, '.password', 1, false)
            }
        })
        $('#pwd_friend').placeholder()

        $('#password_confirmation').placeholder()
        $('#password_confirmation').hide()
        $('#con_pwd_friend').show().focus(function () {
            $("#con_pwd_friend").hide();
            $('#password_confirmation').show().focus().blur(function () {
                var res = false;
                if ($(this).val() == $('#password').val()) {
                    res = true
                }

                if (!res) {
                    set_dom_style($(this), '', {
                        'color': '#e21e1e',
                        'background-color': '#FFF2F2'
                    })
                    $(this).addClass('ipt_false')
                } else {
                    set_dom_style($(this), '', {
                        'color': '#333333',
                        'background-color': '#EFF0F4'
                    })
                }

                if ($(this).val() == $(this).attr('placeholder')) {
                    $("#con_pwd_friend").show();
                    $('#password_confirmation').hide()
                    return false;
                }
                //input内添加按钮
                if ($(this).val() != '') {
                    add_input_btn(this, '.con_pwd', 1, res)
                }
            })
        }).blur(function () {
            if ($(this).val() == $(this).attr('placeholder')) {
                set_dom_style($(this), '', {
                    'color': '#e21e1e',
                    'background-color': '#FFF2F2'
                })
                $(this).addClass('ipt_false')
                add_input_btn(this, '.con_pwd', 1, false)
            }
        })
        $('#con_pwd_friend').placeholder()
        $('#msn').placeholder()
        $('#area').placeholder()
    }

    //为地址栏添加按钮
    add_input_btn($('#area'), '.area', 2, '', 'bg_ipt_down', {
        width: '12px',
        height: '6px'
    })

    //选择地址
    $('#area').cityPick(function (_obj) {
        area = _obj;
        set_dom_style($('#area'), '', {
            'color': '#333333',
            'background-color': '#EFF0F4'
        })
    })

    //用户类型
    $('.radio span:not(:first)').click(function () {
        user_rank = $(this).data('id')
    })

    //验证用户名
    $('#user_name').blur(function () {
        var reg = /^[\u4e00-\u9fa5a-zA-Z0-9]{2,30}$/;
        if (reg.test($(this).val())) {
            verify_info('user_name');
        } else {
            set_dom_style($(this), '', {
                'color': '#e21e1e',
                'background-color': '#FFF2F2'
            })
            $(this).addClass('ipt_false')
            add_input_btn(this, '.user_name', 1, false)
        }
    });

    if (isPlaceholer()) {
        var id_pwd = "password";
        var id_con_pwd = "password_confirmation"
    } else {
        var id_pwd = "pwdplaceholderfriend";
        var id_con_pwd = "con_pwdplaceholderfriend"
    }

    //验证密码
    $('#' + id_pwd).blur(function () {
        var reg = /^[A-Za-z0-9]{6,24}$/;
        if (!reg.test($(this).val())) {
            set_dom_style($(this), '', {
                'color': '#e21e1e',
                'background-color': '#FFF2F2'
            })
            $(this).addClass('ipt_false')
        } else {
            set_dom_style($(this), '', {
                'color': '#333333',
                'background-color': '#EFF0F4'
            })
        }

        //input内添加按钮
        if (id_pwd == 'password') {
            add_input_btn(this, '.password', 1, reg_pwd($(this).val()))
        }
    })

    //验证确认密码
    $('#' + id_con_pwd).blur(function () {
        var result = false;
        if ($(this).val() == $('#password').val() && $(this).val() != '') {
            result = true
        }

        if (!result) {
            set_dom_style($(this), '', {
                'color': '#e21e1e',
                'background-color': '#FFF2F2'
            })
            $(this).addClass('ipt_false')
        } else {
            set_dom_style($(this), '', {
                'color': '#333333',
                'background-color': '#EFF0F4'
            })
        }

        //input内添加按钮
        if (id_con_pwd == 'password_confirmation') {
            add_input_btn(this, '.password_confirmation', 1, result)
        }
    })

    //真实姓名
    $('#ls_name').blur(function () {
        if ($(this).val() != '') {
            verify_info('ls_name')
        } else {
            set_dom_style($(this), '', {
                'color': '#333333',
                'background-color': '#EFF0F4'
            })
            $('.ls_name').find('.btn_ipt_box').remove();
        }
    });

    //验证企业名称
    $('#msn').blur(function () {
        if ($(this).val() != '') {
            verify_info('msn')
        } else {
            set_dom_style($(this), '', {
                'color': '#e21e1e',
                'background-color': '#FFF2F2'
            })
            $(this).addClass('ipt_false')
            add_input_btn(this, '.msn', 1, false)
        }
    })

    //点击下一步
    $('.form_btn').click(function () {
        $('#user_name').blur();
        if (ie == 9) {
            $('#pwd_friend').blur()
            $('#con_pwd_friend').blur()
        }

        if (isPlaceholer()) {
            $('#' + id_pwd).blur();
            $('#' + id_con_pwd).blur()
        } else {
            if ($('#pwdplaceholderfriend').val() == '') {
                set_dom_style($('#password'), '', {
                    'color': '#e21e1e',
                    'background-color': '#FFF2F2'
                })
                $(this).addClass('ipt_false')
                add_input_btn($('#password'), '.password', 1, false)
            }

            if ($('#con_pwdplaceholderfriend').val() == '') {
                set_dom_style($('#password_confirmation'), '', {
                    'color': '#e21e1e',
                    'background-color': '#FFF2F2'
                })
                $(this).addClass('ipt_false')
                add_input_btn($('#password_confirmation'), '.con_pwd', 1, false)
            }
        }

        $('#msn').blur();
        //验证地址
        if ($('#area').val() == '' || $('#area').val() == '请选择') {
            set_dom_style($('#area'), '', {
                'color': '#e21e1e',
                'background-color': '#FFF2F2'
            })
            $('#area').addClass('ipt_false')
            return false;
        }
        if (verify_status == true) {
            $('#form').submit();
        }
    })
})

function verify_info(name) {
    if (area == '') {
        var json_data = {
            user_rank: user_rank,
            user_name: $('#user_name').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
            ls_name: $('#ls_name').val(),
            msn: $('#msn').val()
        };
        $('#user_rank').val(user_rank);
    } else {
        var json_data = {
            user_rank: user_rank,
            user_name: $('#user_name').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
            ls_name: $('#ls_name').val(),
            msn: $('#msn').val(),
            province: area.pid,
            city: area.cid,
            district: area.did,
            mobile: mobile
        };
        $('#province').val(area.pid);
        $('#city').val(area.cid);
        $('#district').val(area.did);
        $('#user_rank').val(user_rank);
    }
    $.ajax({
        url: '/xin/register',
        type: 'post',
        data: json_data,
        dataType: 'json',
        async: false,
        statusCode: {
            422: function (data) {
                verify_status = false;
                verify_result = jQuery.parseJSON(data.responseText);
                var has = 0;
                $.each(verify_result, function (key, value) {
                    if (name == key) {
                        has = 1;
                        layer.msg(value[0], {icon: 2});
                        set_dom_style($('#' + name), '', {
                            'color': '#e21e1e',
                            'background-color': '#FFF2F2'
                        })
                        $('#' + name).addClass('ipt_false');
                        add_input_btn($('#' + name), '.' + name, 1, false)
                    }
                })
                if (has == 0) {
                    set_dom_style($('#' + name), '', {
                        'color': '#333333',
                        'background-color': '#EFF0F4'
                    })
                    add_input_btn($('#' + name), '.' + name, 1, true)
                }
            }
        },
        success: function (data) {
            set_dom_style($('#' + name), '', {
                'color': '#333333',
                'background-color': '#EFF0F4'
            });
            add_input_btn($('#' + name), '.' + name, 1, true)
            if (data.error == 0) {
                verify_status = true;
            }
        }
    })
}

//=============================================================function====================================================
