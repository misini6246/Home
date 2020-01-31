$(function () {
    $('.gengduo').click(function () {
        $(this).hide();
        $(this).parent().children('li').show();
    })
    $('.left li a').hover(function () {
        $(this).children('img').attr('src', 'http://images.hezongyy.com/images/user/right_hover.png')
    }, function () {
        $(this).children('img').attr('src', 'http://images.hezongyy.com/images/user/right_03.png');
        if ($(this).hasClass('on')) {
            $(this).children('img').attr('src', 'http://images.hezongyy.com/images/user/right_hover.png');
        }
    });
    var left_h = $('.left').css('height');
    $('.right').css('min-height', left_h);
});
//
// function tocart(id) {
//     var num = $('#J_dgoods_num_' + id).val();
//     addToCart1(id, num);
// }
function del(obj) {
    var config = obj.data('config');
    var url = config.url;
    var msg = config.msg;
    var method = config.method;
    var key = config.key;
    var value = config.value;
    var dataType = config.dataType;
    var box = config.box;
    layer.confirm(msg, function () {
        $.ajax({
            url: url
            , type: method
            , data: {key: key, value: value, box: box}
            , dataType: dataType
            , success: function (data) {
                if (data.error == 0) {
                    $('#' + box).html(data.html);
                }
                layer.msg(data.msg, {icon: data.error + 1});
            }
        });
    });
}

function quanxuan(_this, _obj) {
    var checked = _this.prop('checked');
    var name = _this.prop('class');
    $('.' + name).prop('checked', checked);
    _obj.prop('checked', checked);
}

function danxuan(_this, _obj) {
    var len = _this.length;
    var num = 0;
    _this.each(function () {
        var checked = $(this).prop('checked');
        if (checked == true) {
            num++;
        }
    });
    if (len == num) {
        _obj.prop('checked', true);
    } else {
        _obj.prop('checked', false);
    }
}