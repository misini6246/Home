$(function () {

    // 购物车

    //默认全选

    var checkAllIuputs = $("input[type=checkbox]");

    checkAllIuputs.each(function () {
        var is_checked = parseInt($(this).attr('is_checked'));
        if (is_checked == 0) {
            $(this).attr("checked", false);
        } else {
            $(this).attr("checked", true);
        }
    });

    // if($(".allselect").attr("checked")){
    //     GetCount();
    // }

    $("#Checkbox1").click(function () {
        $("input[type=checkbox]").each(function () {
            if ($("#Checkbox1").attr("checked")) {
                var is_checked = parseInt($(this).attr('is_checked'));
                if (is_checked == 0) {
                    $(this).attr("checked", false);
                } else {
                    $(this).attr("checked", true);
                }
            } else {
                $(this).attr("checked", false);
            }
        });
        GetCount();
    });

    $("#Checkbox2").click(function () {
        $("input[type=checkbox]").each(function () {
            if ($("#Checkbox2").attr("checked")) {
                var is_checked = parseInt($(this).attr('is_checked'));
                if (is_checked == 0) {
                    $(this).attr("checked", false);
                } else {
                    $(this).attr("checked", true);
                }
            } else {
                $(this).attr("checked", false);
            }
        });
        GetCount();
    });

    $("input[name=newslist]").click(function () {
        if (!$(this).checked) {
            $(".allselect").attr("checked", false);
        }
        if ($("input[name=newslist]:checked").length == $(".gwc_tb2 .xuanzhongzt").length) {
            $(".allselect").attr("checked", true);
        }
        GetCount();
    });


    $(".jz2").click(function () {
        alert('请仔细核对商品数量及商品有效期,药品非质量问题概不退换！')
        //alert('       告广大药易购客户，因公司电商平台系统升级，为了给\n客户更好的下单和收货体验，经公司慎重研究决定，原定于4\n月26日的特价活动延期至5月4日举行，我们由衷的为此次升\n级给您带来的不便表示歉意，5月4日我们将以更大的活动力\n度来回馈大家的支持和理解！');
        $(".submit_txt").show();
        $(this).parent().remove();
    });

    // 参加的优惠信息
    $(".sale_list").hover(function () {
        $(".list").show();
    }, function () {
        $(".list").hide();
    });


    //清空购物车
    $("#clear_all").click(function () {
        if (check("您确定要清除吗？")) {
            $.ajax({
                url: 'flow.php',
                type: 'post',
                dataType: 'json',
                data: {
                    step: 'clear'
                },
                success: function (msg) {
                    if (msg.error) {
                        alert(msg.message);
                    }
                }
            });
            $(".gwc").hide();
            $(".no_shopping").show();
        }
    });

    //点击删除与收藏
    $(".del").click(function () {
        var _id = $(this).parents("tr").attr("data-id");
        $("#shopping_box4").show();
        $(".del2").click(function () {
            $(".del2").attr('href', '/cart/dropCart?id=' + _id);
        });
        $(".remove_col").click(function () {
            $(".remove_col").attr('href', '/cart/dropToCollect?id=' + _id);
        });

    });
    $(".collect").click(function () {
        var _id = $(this).parents("tr").attr("data-id");
        $("#shopping_box5").show();
        $(".confirm_cc").click(function () {
            $(".confirm_cc").attr('href', '/cart/dropToCollect?id=' + _id);
        });

        $(".cancel").click(function () {
            $("#shopping_box5").hide();
        });


    });
    //end


    //删除选中的商品
    $("#del_checked").click(function () {
        var flag = $("#shuliang").text();
        var orderstr = "";
        var _this = $(".gwc_tb2 input[name=newslist]:checked");
        _this.each(function () {
            var recid = $(this).parents("li").data("id");
            orderstr += recid + "_";
        });
        if (flag == 0) {
            layer.confirm('请选择要删除的商品！')
        } else {
            layer.confirm('您确定要删除吗？', function (e) {
                $(".gwc_tb2 input[type=checkbox]:checked ").parents("li").remove();
                $(".allselect").attr("checked", false);
                layer.close(e);
                location.href = '/cart/dropCartMany?id=' + orderstr
            });
        }
    });

    // 确认框
    function check($text) {

        if (confirm($text)) {
            return true;
        }
        else {
            return false;
        }
    }

});


function add_num(rec_id) {
    var _this = $(".gwc_tb2 input[name=newslist]:checked");
    var _th = $(".gwc_tb2 input[name=newslist]");
    var goods = _th.parents("li").find('#goods_num_show_' + rec_id);
    var num = parseInt(goods.val());
    var goods_id = parseInt(goods.data('goods_id'));
    var lsgg = parseInt(goods.data('zbz'));
    var orderstr = "";
    _this.each(function () {
        var recid = $(this).parents("li").data("id");
        orderstr += recid + "_";
    });
    $.post('/ajax/cart/addNum', {
            rec_id: rec_id,
            num: num,
            goods_id: goods_id,
            lsgg: lsgg,
            orderstr: orderstr,
            _token: $('meta[name="_token"]').attr('content')
        },
        updateCartResponse, 'json');
}

function reduce_num(rec_id) {
    var _this = $(".gwc_tb2 input[name=newslist]:checked");
    var _th = $(".gwc_tb2 input[name=newslist]");
    var goods = _th.parents("li").find('#goods_num_show_' + rec_id);
    var num = parseInt(goods.val());
    var goods_id = parseInt(goods.data('goods_id'));
    var lsgg = parseInt(goods.data('zbz'));
    var orderstr = "";
    _this.each(function () {
        var recid = $(this).parents("li").data("id");
        orderstr += recid + "_";
    });
    $.post('/ajax/cart/addNum', {
            rec_id: rec_id,
            num: num,
            change_num: -1,
            goods_id: goods_id,
            lsgg: lsgg,
            orderstr: orderstr,
            _token: $('meta[name="_token"]').attr('content')
        },
        updateCartResponse, 'json');
}


function changePrice_ls(rec_id) {
    var _this = $(".gwc_tb2 input[name=newslist]:checked");
    var _th = $(".gwc_tb2 input[name=newslist]");
    var goods = _th.parents("li").find('#goods_num_show_' + rec_id);
    var num = parseInt(goods.val());
    var goods_id = parseInt(goods.data('goods_id'));
    var lsgg = parseInt(goods.data('zbz'));
    var orderstr = "";
    _this.each(function () {
        var recid = $(this).parents("li").data("id");
        orderstr += recid + "_";
    });
    $.post('/ajax/cart/addNum', {
            rec_id: rec_id,
            num: 0,
            change_num: num,
            goods_id: goods_id,
            lsgg: lsgg,
            orderstr: orderstr,
            _token: $('meta[name="_token"]').attr('content')
        },
        updateCartResponse, 'json');
}

function updateCartResponse(result) {
    if (result.error == 0) {
        var isChecked = $('.gwc_tb2 input[name=newslist]').is(":checked");
        if (isChecked) {
            $('.heji').html(result.total);
            $('.jp_heji').html(result.jp_total_amount);
        }
        $('#goods_num_show_' + result.rec_id).val(result.num);
        $('#subtotal_' + result.rec_id).html(result.subtotal);
        $('#zp_goods' + result.rec_id).replaceWith(result.child);

        if (result.message) {
            layer.msg(result.message, {icon: 0});
        }
        //end
    }
    else if (result.error == 1) {
        layer.msg(result.msg, {icon: 2});
        return false;
    }
    else {
        //alert(result.message);
        $('#goods_num_show_' + result.rec_id).val(result.num);
    }
}

function del(rec_id) {
    layer.confirm('<h3>删除商品？</h3><p class="txt_tip">您可以选择移到收藏，或删除商品。</p>',
        {
            btn: ['删除', '移到我的收藏'] //按钮
        }, function (e) {
            drop('/cart/dropCart', rec_id, e);
        }, function (e) {
            drop('/cart/dropToCollect', rec_id, e);
            return false;
        })
}

function del_to_collection(rec_id) {
    layer.confirm('<h3>移到收藏？</h3><p class="txt_tip">移动后该商品将不在购物车中显示。</p>', function (e) {
        drop('/cart/dropToCollect', rec_id, e);
    })
}

function GetCount() {
    var aa = 0;
    var bb = 0;
    var orderstr = "";
    var finestr = "";
    $(".gwc_tb2 input[name=newslist]").each(function () {
        if ($(this).attr("checked")) {
            var recid = $(this).parents("li").data("id");
            var fine = parseInt($(this).parents("li").data('jp'));
            orderstr += recid + "_";
            aa += 1;
            if (fine == 1) {
                finestr += recid + "_";
                bb++;
            }
        }
    });
    $.ajax({
        url: '/ajax/cart/goodsChoose?' + Math.random(),
        type: 'get',
        dataType: 'json',
        data: {orderstr: orderstr},
        success: function (msg) {
            $('.heji').html(msg.total);
            $('.jp_heji').html(msg.jp_total_amount);
        }
    });

    $("#shuliang").text(aa);
    //$("#zong1").html((conts).toFixed(2));

    if (aa == 0) {
        $('.jiesuan').addClass('disabled')
        $('.jiesuan').attr('href', 'javascript:;')
    } else {
        $('.jiesuan').removeClass('disabled')
        $('.jiesuan').attr('href', '/cart/jiesuan')
    }
}

function drop(url, rec_id, e) {
    $.ajax({
        url: url,
        type: 'get',
        data: {id: rec_id},
        dataType: 'json',
        success: function (data) {
            if (data.error == 0) {
                $('#li_' + rec_id).fadeOut();
                $('#li_' + rec_id).remove();
                if ($('.gwc_tb2 .xuanzhongzt').length == 0) {
                    location.reload();
                }
                GetCount();
                layer.close(e)
            }
            layer.msg(data.msg, {icon: data.error + 1})
        }
    });
}