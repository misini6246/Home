/**
 * Created by Administrator on 2018-01-23.
 */
function add_to_cart(id, num) {
    $.ajax({
        url: '/jf/cart',
        data: {id: id, num: num},
        dataType: 'json',
        success: function (result) {
            if (result.error == 0) {
                layer.confirm(result.msg, {
                    btn: ['继续购物', '去结算'], //按钮
                    icon: 1
                }, function (index) {
                    layer.close(index);
                }, function () {
                    location.href = '/jf/cart';
                    return false;
                });
            } else {
                layer.msg(result.msg, {icon: result.error + 1});
            }
        }
    });
}