var time = 60;//重新获取验证码的倒计时时间
var isTime = false;//判断是否还在进行倒计时
var check = false;//判断checkbox状态
var testPhone = false;
var testCode = false;

$(function () {
    //验证手机号
    $('#phone').blur(function () {
        if (isTime) {
            return false;
        }
        if (!reg_phone($(this).val())) {
            set_dom_style($(this), '', {
                'color': '#e21e1e',
                'background-color': '#FFF2F2'
            });
            $(this).addClass('ipt_false')
            testPhone = false;
            //改变发送验证码状态
            up_code_btn_sta(3);
        } else {
            set_dom_style($(this), '', {
                'color': '#333333',
                'background-color': '#EFF0F4'
            });
            testPhone = true;
            //改变发送验证码状态
            up_code_btn_sta(1);
        }

        //input内添加按钮
        add_input_btn(this, '.phone', 1, testPhone)
    }).keyup(function () {
        if (reg_phone($(this).val())) {
            $('#phone').blur()
        }
    });

    //发送验证码
    $('#code_btn').click(function () {
        $('#phone').blur();
        if (!testPhone) {
            return false;
        }//输入的内容存在错误
        isTime = true;
        $.ajax({
            url: '/reg_code',
            type: 'post',
            data: {mobile: $('#phone').val()},
            dataType: 'json',
            success: function (data) {
                if (data.error == 2) {
                    var new_time = data.s;
                    up_code_btn_sta(2, new_time)
                } else {
                    up_code_btn_sta(2, time)
                }
            }
        });
    });

    //验证验证码
    $('#code').blur(function () {
        var $this = $(this);
        var user_code = $(this).val()//用户输入的验证码
        var reg = /^\d{4}$/;
        if (reg.test(user_code)) {
            $.ajax({
                url: '/check_code',
                type: 'post',
                data: {mobile: $('#phone').val(), code: user_code},
                dataType: 'json',
                async: false,
                success: function (data) {
                    if (data.error == 0) {
                        set_dom_style($this, '', {
                            'color': '#333333',
                            'background-color': '#EFF0F4'
                        });
                        testCode = true;
                        //input内添加按钮
                        add_input_btn($this, '.code', 1, testCode);
                        $('#phone').val(data.mobile)
                    } else {
                        set_dom_style($this, '', {
                            'color': '#e21e1e',
                            'background-color': '#FFF2F2'
                        });
                        $this.addClass('ipt_false');
                        testCode = false;
                        //input内添加按钮
                        add_input_btn($this, '.code', 1, testCode)
                    }
                }
            });
        } else {
            set_dom_style($this, '', {
                'color': '#e21e1e',
                'background-color': '#FFF2F2'
            });
            $this.addClass('ipt_false');
            testCode = false;
            //input内添加按钮
            add_input_btn($this, '.code', 1, testCode)
        }
    });

    //复选框
    $('.check').click(function () {
        if (!check) {
            $(this).html('&radic;');
            check = true;
        } else {
            $(this).html('')
            check = false;
        }
    })

    //点击下一步按钮
    $('.form_btn').click(function () {
        $('#phone').blur()
        $('#code').blur()
        if (!testCode || !testPhone) {
            return false;
        }//输入的内容存在错误

        if (!check) {//未勾选已阅读用户协议
            layer.msg('请阅读用户协议', {icon: 2})
            return false;
        }
        $('#form').submit();
    })
})

//=======================================function==================================

/**
 * 改变发送验证码状态
 * @param {Number} type 1：初始状态2：重新获取3：无法获取
 * @param {String} time 状态为2时传入
 */
function up_code_btn_sta(type, time) {
    var code_btn = $('#code_btn')

    if (type == 1) {
        code_btn.removeAttr('disabled')
        code_btn.removeClass('code_again_get');
        code_btn.removeClass('code_false')
        code_btn.val('发送短信验证码')
        code_btn.addClass('code_get')
    } else if (type == 2) {
        code_btn.removeClass('code_get');
        code_btn.addClass('code_again_get');
        code_btn.val(time + 's后重新发送')
        code_btn.attr('disabled', 'disabled');
        var circulation = setInterval(function () {
            time--;
            code_btn.val(time + 's后重新发送')
            if (time == 0) {
                clearInterval(circulation)
                isTime = false;
                up_code_btn_sta(1)
            }
        }, 1000)
    } else if (type == 3) {
        code_btn.removeClass('code_get')
        code_btn.addClass('code_false');
        code_btn.attr('disabled', 'disabled')
    }
}
