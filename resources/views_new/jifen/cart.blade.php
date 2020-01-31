<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>积分商城-查看礼品车</title>
    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/jfen/jfsc-js/jquery.singlePageNav.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/gwc_1.css"/>
</head>

<body>
@include('jifen.layouts.header')
@include('jifen.layouts.nav')
<!--container-->
<div class="container content">
    <div class="content_box">
        <div class="top_title">
            <img src="http://images.hezongyy.com/images/jf/address_03.png?1"/>
            <span>当前位置：<a href="{{route('jifen.index')}}">积分首页</a> > 礼品车</span>
        </div>
        <div class="jiesuan_box">
            <div class="img_title">
                <img src="http://images.hezongyy.com/images/jf/gwc_1.png?1"/>
            </div>
            @if(count($result)>0)
                <form action="{{route('jifen.cart.jiesuan')}}" method="post" onsubmit="return check_cart()">
                    {!! csrf_field() !!}
                    <table>
                        <tr>
                            <th class="qx">
                                <input type="checkbox" name="qx_1" id="qx_1" class="quanxuan"
                                       onclick="quanxuan($(this),$('.danxuan'))"/>
                                <label for="qx_1">全选</label>
                            </th>
                            <th class="lpxx">
                                礼品信息
                            </th>
                            <th class="jf">
                                积分
                            </th>
                            <th class="sl">
                                数量
                            </th>
                            <th class="xj">
                                小计
                            </th>
                            <th class="cz">
                                操作
                            </th>
                        </tr>
                        @foreach($result as $v)
                            <tr class="cart_list" id="tr{{$v->id}}">
                                <td class="qx">
                                    <input name="ids[]" value="{{$v->id}}" data-jf="{{$v->jf}}" type="checkbox"
                                           class="danxuan"
                                           onclick="danxuan($('.danxuan'),$('.quanxuan'))"/>
                                </td>
                                <td class="lpxx">
                                    <div class="img_box">
                                        <a target="_blank"
                                           href="{{route('jifen.goods.show',['id'=>$v->goods_id])}}"><img
                                                    src="{{get_img_path('jf/'.substr($v->goods_image,1))}}"/></a>
                                    </div>
                                    <div class="text">
                                        {{$v->goods_name}}
                                    </div>
                                </td>
                                <td class="jf">
                                    {{$v->jf}}
                                </td>
                                <td class="sl">
								<span class="jian" onclick="change_num($(this),-1,'{{$v->id}}')">
									<img src="http://images.hezongyy.com/images/jf/gwc_jian.jpg?1"/>
								</span>
                                    <input type="text" value="{{$v->goods_num}}" class="input_val goods_num"
                                           onchange="change_num($(this),0,'{{$v->id}}')"
                                           data-old="{{$v->goods_num}}"/>
                                    <span class="jia" onclick="change_num($(this),1,'{{$v->id}}')">
									<img src="http://images.hezongyy.com/images/jf/gwc_jia.jpg?1"/>
								</span>
                                </td>
                                <td class="xj">
                                    {{$v->goods_num*$v->jf}}
                                </td>
                                <td class="cz" onclick="del('确定从购物车删除{{$v->goods_name}}吗?','{{$v->id}}')">
                                    <img src="http://images.hezongyy.com/images/jf/gwc_delete.png?1" class="delete"/>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="heji">
                        <div class="fl">
                            <input type="checkbox" name="qx_2" id="qx_2" class="quanxuan"
                                   onclick="quanxuan($(this),$('.danxuan'))"/>
                            <label for="qx_2">全选</label>
                        </div>
                        <div class="fr">
							<span class="shuliang">
								已选<span id="xz_total">0</span>件礼品
							</span>
                            <span class="jifen">
								积分合计：<span class="jf_sum" id="jf_total">0</span>
								<span class="keyong">（当前可用积分：<span>{{$user->pay_points}}</span>）</span>
							</span>
                            <input type="submit" value="结算" id="jiesuan"/>
                        </div>
                    </div>
                </form>
            @else
                <div class="dd_none" style="padding-bottom: 20px;">
                    <img src="/index/img/search_none.jpg"/>
                    <p>礼品车空空的哦~，去看看心仪的礼品吧~</p>
                    <a href="{{route('jifen.index')}}">去逛逛</a>
                </div>
            @endif
        </div>
    </div>
</div>
<!--container-->
@include('jifen.layouts.footer')
<script>
    function del(msg, id) {
        layer.confirm(msg, function() {
            $.ajax({
                url: '/jifen/cart/' + id,
                type: 'delete',
                dataType: 'json',
                success: function(data) {
                    layer.msg(data.msg, {
                        icon: data.error + 1
                    });
                    if(data.error == 0) {
                        $('#tr' + id).remove();
                        check_list();
                        if($('.cart_list').length == 0) {
                            window.location.reload();
                        }
                    }
                }
            })
        })
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
        _this.each(function() {
            var checked = $(this).prop('checked');
            if(checked == true) {
                num++;
            }
        });
        if(len == num) {
            _obj.prop('checked', true);
        } else {
            _obj.prop('checked', false);
        }
    }

    function check_list() {
        var xz_total = 0;
        var jf_total = 0;
        $('.danxuan').each(function() {
            var checked = $(this).prop('checked');
            var jf = parseInt($(this).data('jf'));
            var num = parseInt($(this).parents('tr').find('.goods_num').val());
            var xj = jf * num;
            $(this).parents('tr').find('.xj').text(xj);
            if(checked == true) {
                jf_total += xj;
                xz_total++;
            }
        })
        $('#jf_total').text(jf_total);
        $('#xz_total').text(xz_total);
    }

    function change_num(_obj, type, id) {
        if(type == 0) {
            var val = parseInt(_obj.data('old'));
            var new_val = parseInt(_obj.val());
        } else {
            var val = parseInt(_obj.parents('tr').find('.goods_num').val());
            var new_val = val;
        }
        if(type != 0) {
            new_val += type;
        }
        if(new_val <= 1) {
            new_val = 1;
        }
        if(new_val != val) {
            $.ajax({
                url: '/jifen/cart/' + id,
                type: 'put',
                data: {
                    num: new_val
                },
                dateType: 'json',
                success: function(data) {
                    if(data.error == 0) {
                        new_val = data.num;
                        _obj.parents('tr').find('.goods_num').val(new_val);
                        _obj.data('old', new_val);
                        check_list();
                    } else if(data.error == 1) {
                        $('#tr' + id).remove();
                        check_list();
                        layer.msg(data.msg, {
                            icon: 2
                        });
                    }
                }
            })
        } else {
            _obj.parents('tr').find('.goods_num').val(new_val);
        }
    }

    function check_cart() {
        var xz_total = parseInt($('#xz_total').text());
        if(xz_total == 0) {
            layer.msg('请选择要购买的商品', {
                icon: 2
            });
            return false;
        }
        var jf_total = parseInt($('#jf_total').text());
        var pay_points = '1105200';
        if(jf_total > parseInt(pay_points)) {
            layer.msg('积分不足', {
                icon: 2
            });
            return false;
        }
    }
    $('input[type=checkbox]').click(function() {
        check_list();
    })
</script>
</body>

</html>