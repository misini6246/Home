/**
 * Created by Administrator on 2017-06-01.
 */
$(function () {
    //	加减
    $('td.sl,.jiajian').Aas({
        jia: '.jia',
        jian: '.jian',
        val: '.input_val',
        state: 1 //state状态表示是购物车普药的加减还是产品详情的加减  1为购物车普药 2为产品详情的加减
    });
});
function add_num(id) {
    var gn = parseInt($('#gn_' + id).val());
    var yl = parseInt($('#yl_' + id).val());
    var isYl = parseInt($('#isYl_' + id).val());
    var zbz = parseFloat($('#zbz_' + id).val());
    var jzl = parseInt($('#jzl_' + id).val());
    var num = parseFloat($('#J_dgoods_num_' + id).val());
    num = num + zbz;
    if (jzl) {//件装量存在
        if ((num % jzl) / jzl >= 0.8) {//购买数量达到件装量80%
            layer.alert('你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。', {icon: 0, title: '温馨提示'});
            num = Math.ceil(num / jzl) * jzl;
        }
    }

    if (num % zbz != 0) {//不为中包装整数倍
        num = num - num % zbz + zbz;
    }

    if (isYl > 0 && num > isYl && yl > 0) {//商品限购
        num = isYl;
    }

    if (num > gn && gn > 0) {
        num = gn;
    }
    $('#J_dgoods_num_' + id).val(num);
}

function reduce_num(id) {
    var yl = parseInt($('#yl_' + id).val());
    var isYl = parseInt($('#isYl_' + id).val());
    var zbz = parseFloat($('#zbz_' + id).val());
    var jzl = parseInt($('#jzl_' + id).val());
    var num = parseFloat($('#J_dgoods_num_' + id).val());
    num = num - zbz;
    if (jzl) {//件装量存在
        if ((num % jzl) / jzl >= 0.8 && (num % jzl) / jzl <= 1) {//购买数量达到件装量80%
            num = num - num % jzl + parseInt(jzl * 0.8);
        }
    }

    if (num % zbz != 0) {//不为中包装整数倍
        num = num - num % zbz;
    }

    if (isYl > 0 && num > isYl && yl > 0) {//商品限购
        num = isYl;
    }

    if (num < 1) {
        num = zbz;
    }
    $('#J_dgoods_num_' + id).val(num);
}

function changePrice(id) {
    var gn = parseInt($('#gn_' + id).val());
    var yl = parseInt($('#yl_' + id).val());
    var isYl = parseInt($('#isYl_' + id).val());
    var zbz = parseInt($('#zbz_' + id).val());
    var jzl = parseInt($('#jzl_' + id).val());
    var num = parseInt($('#J_dgoods_num_' + id).val());
    if (num < 0) {
        layer.msg('请输入正确的数量', {icon: 2});
        $('#J_dgoods_num_' + id).val(0 - zbz);
        return false;
    }
    if (num == 0) {
        layer.msg('请输入正确的数量', {icon: 2});
        $('#J_dgoods_num_' + id).val(zbz);
        return false;
    }
    if (num % zbz != 0) {//不为中包装整数倍
        num = num - num % zbz + zbz;
    }

    if (jzl) {//件装量存在
        if ((num % jzl) / jzl >= 0.8 && (num % jzl) / jzl <= 1) {//购买数量达到件装量80%
            layer.alert('你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。', {icon: 0, title: '温馨提示'});
            num = Math.ceil(num / jzl) * jzl;
        }
    }

    if (isYl > 0 && num > isYl && yl > 0) {//商品限购
        num = isYl;
    }

    if (num > gn && gn > 0) {
        num = gn;
    }
    $('#J_dgoods_num_' + id).val(num);
}

function tocart(id) {
    var num = $('#J_dgoods_num_' + id).val();
    $.ajax({
        url: '/gwc',type:'post',
        data: {id: id, num: num},
        dataType: 'json',
        success: function (data) {
            if (data.error == 0) {
                if (data.type == 0) {
                    layer.msg('购物车已有该商品', {icon: 0})
                } else {
                    layer.confirm(data.msg, {
                        btn: ['继续购物', '去结算'], //按钮
                        icon: 1
                    }, function (index) {
                        layer.close(index);
                    }, function () {
                        location.href = '/cart';
                        return false;
                    });
                }
            } else if (data.error == 2) {
                layer.confirm(data.msg, {
                    btn: ['注册', '登录'], //按钮
                    icon: 2
                }, function () {
                    location.href = '/xin/register/old';
                }, function () {
                    location.href = '/auth/login';
                    return false;
                });
            } else {
                if (data.msg.indexOf('血液制品采购委托书') > 0 || data.msg.indexOf('冷藏药品采购委托书') > 0) {
                    layer.alert(data.msg, {
                        btn: ['下载委托书', '确定'], //按钮
                        icon: 2
                    }, function (index) {
                        location.href = '/uploads/血液制品、冷藏药品采购委托书（二合一）.doc';
                    })
                } else {
                    layer.alert(data.msg, {icon: 2})
                }
            }
        }
    })
}
function tocollect(id) {
    $.ajax({
        url: '/collect',
        data: {id: id},
        dataType: 'json',
        success: function (data) {
            if (data.error == 2) {
                layer.confirm(data.msg, {
                    btn: ['注册', '登录'], //按钮
                    icon: 2
                }, function () {
                    location.href = '/xin/register/old';
                }, function () {
                    location.href = '/auth/login';
                    return false;
                });
            } else {
                layer.alert(data.msg, {icon: data.error + 1, btn: '查看我的收藏'}, function () {
                    location.href = '/user/collectList';
                })
            }
        }
    })
}
function tocart1() {
    layer.confirm('请登录后再操作', {
        btn: ['注册', '登录'], //按钮
        icon: 2
    }, function () {
        location.href = '/xin/register/old';
    }, function () {
        location.href = '/auth/login';
        return false;
    });
}

function fly_to_cart(id, data) {

    // 元素以及其他一些变量

    var eleFlyElement = document.querySelector("#flyItem"), eleShopCart = document.querySelector(".mpbtn_wdsc2"),
        eleShopCart_1 = document.querySelector(".cart_number");

    var numberItem = $('#gwc_count').text();
    var a = 300;
    if (window.screen.availWidth < 1400) {
        a = 150
    } else if (window.screen.availWidth >= 1400) {
        a = 300
    }

    var myParabola = funParabola(eleFlyElement, eleShopCart, {

        speed: a, //抛物线速度

        curvature: 0.0008, //控制抛物线弧度

        complete: function () {

            eleFlyElement.style.visibility = "hidden";
            if (data.type == 1) {
                numberItem++;
                eleShopCart.querySelector("span").innerHTML = numberItem;
                eleShopCart_1.innerHTML = numberItem
            }

        }

    });
    var imgsrc = $('.fly_to_cart' + id).data('img');
    $('#flyItem').children('img').attr('src', imgsrc);
    // 滚动大小
    var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft || 0,

        scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;

    eleFlyElement.style.left = $('.fly_to_cart' + id).offset().left + 'px';

    eleFlyElement.style.top = $('.fly_to_cart' + id).offset().top + 'px';

    eleFlyElement.style.visibility = "visible";
    // 需要重定位

    myParabola.position().move();
}