<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>积分商城-确认订单信息</title>
    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/jfen/jfsc-js/jquery.singlePageNav.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/gwc_2.css"/>
</head>

<body>
@include('jifen.layouts.header')
@include('jifen.layouts.nav')
<!--container-->
<div class="container content">
    <div class="content_box">
        <div class="top_title">
            <img src="http://images.hezongyy.com/images/jf/address_03.png?1"/>
            <span>当前位置：<a href="{{route('jifen.index')}}">积分首页</a> > 确认订单信息</span>
        </div>
        <form action="{{route('jifen.order.store')}}" method="post">
            {!! csrf_field() !!}
            <div class="jiesuan_box">
                <div class="img_title">
                    <img src="http://images.hezongyy.com/images/jf/gwc_2.jpg?1"/>
                </div>
                <div class="shdz">
                    <div class="shdz_title">
                        收货地址
                    </div>
                    <ul class="add_list" id="address_list">
                        <li class="address active" id="address{{$address->address_id}}">
                            <div class="username">
                                <img src="http://images.hezongyy.com/images/jf/user_icon.png?1"/>
                                <span>{{$address->consignee}}</span>
                            </div>
                            <div class="user_phone">
                                <img src="http://images.hezongyy.com/images/jf/phone_icon.png?1"/>
                                <span>{{$address->tel}}</span>
                            </div>
                            <div class="user_add">
                                <img src="http://images.hezongyy.com/images/jf/phone_icon.png?1"/>
                                <span>{{get_region_name([$address->province,$address->city,$address->district],' ')}}{{$address->address}}</span>
                            </div>
                            <img src="http://images.hezongyy.com/images/jf/add_icon.png?1" class="add_choose"/>
                            <div class="moren">
                                默认地址
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="lpqd">
                    <div class="shdz_title">
                        礼品清单
                    </div>
                    <table>
                        <tr>
                            <th class="lpxx">礼品信息</th>
                            <th class="sl">数量</th>
                            <th class="xj">小计</th>
                        </tr>
                        @foreach($result as $v)
                            <input type="hidden" name="ids[]" value="{{$v->id}}">
                            <tr>
                                <td class="lpxx">
                                    <div class="img_box">
                                        <img src="{{get_img_path('jf/'.substr($v->goods_image,1))}}"/>
                                    </div>
                                    <div class="text">
                                        {{$v->goods_name}}
                                    </div>
                                </td>
                                <td class="sl">
                                    {{$v->goods_num}}
                                </td>
                                <td class="xj">
                                    {{$v->goods_num*$v->jf}}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="heji">
							<span class="lipin">
								共<span>{{count($result)}}</span>个礼品
							</span>
                        <span class="jifen">
								积分合计：<span>{{$jf_total}}</span>
							</span>
                    </div>
                </div>
                <div class="liuyan">
                    <div class="shdz_title">
                        留言内容
                    </div>
                    <textarea name="message"></textarea>
                </div>
                <div class="btn_box">
                    <div class="fl" id="default_address">
                        <img src="http://images.hezongyy.com/images/jf/add_icon.png?1"/>
                        <span>{{get_region_name([$address->province,$address->city,$address->district],' ')}}{{$address->address}}</span>
                    </div>
                    <div class="fr">
                        应付积分：<span>{{$jf_total}}</span>
                        <input type="submit" id="btn" value="确认提交"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--container-->
@include('jifen.layouts.footer')
<script>
    function load_html() {
        layer.open({
            type: 2,
            title: '新增收货地址',
            shadeClose: true,
            shade: 0.4,
            area: ['800px', '500px'],
            content: 'http://www.jyeyw.com/jifen/address/create'
        });
    }
</script>
</body>

</html>