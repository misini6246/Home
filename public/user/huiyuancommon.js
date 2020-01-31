$(function () {	
	
    $('.gengduo').click(function () {
        $(this).hide();
        $(this).parent().children('li').show();
    })
    $('.left li a').hover(function () {
        $(this).children('img').attr('src', '/user/img/right_hover.png')
		$(this).find("span.num").css('color','#FFFFFF')
    }, function () {
        $(this).children('img').attr('src', '/user/img/right_03.png');
        if ($(this).hasClass('on')) {
            $(this).children('img').attr('src', '/user/img/right_hover.png');
        }
    });
    var left_h = $('.left').css('height');
    $('.right').css('min-height', left_h);
});

function tocart(id) {
    var num = $('#J_dgoods_num_' + id).val();
    addToCart1(id, num);
}
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
    var checked = _this.attr('checked')==undefined?false:_this.attr('checked');
    var name = _this.attr('class');
    $('.' + name).attr('checked', checked);
    _obj.attr('checked', checked);
}
function danxuan(_this, _obj) {
    var len = _this.length;
    var num = 0;
    _this.each(function () {
        var checked = $(this).attr('checked');
        if (checked) {
            num++;
        }
    });
    if (len == num) {
        _obj.attr('checked', true);
    } else {
        _obj.attr('checked', false);
    }
}