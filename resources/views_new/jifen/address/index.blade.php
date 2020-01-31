<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>积分商城-个人中心-我的地址</title>
    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/jfen/jfsc-js/jquery.singlePageNav.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/shouhuodizhi.css"/>
    <script src="/jfen/jfsc-js/lb.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
@include('jifen.layouts.header')
@include('jifen.layouts.nav')
<!--container-->
<div class="container content">
    <div class="content_box">
        <div class="top_title">
            <img src="http://images.hezongyy.com/images/jf/address_03.png?1" />
            <span>当前位置：<a href="http://www.jyeyw.com/jifen">积分首页</a> > <a
                        href="http://www.jyeyw.com/jifen/user">个人中心</a>> 收货地址</span>
        </div>
        <div class="vip">
            @include('jifen.layouts.user_menu')
            <div class="vip_right">
                <div class="vip_right_title">
                    <img src="http://images.hezongyy.com/images/jf/dian_03.png?1"/>
                    <span>收货地址</span>
                </div>
                @if(count($result)>0)
                    <div class="add_box">
                        <ul class="add_list">
                            @foreach($result as $v)
                                <li class="active" id="address{{$v->address_id}}">
                                    <div class="username">
                                        <img src="http://images.hezongyy.com/images/jf/user_icon.png?1"/>
                                        <span>{{$v->consignee}}</span>
                                    </div>
                                    <div class="user_phone">
                                        <img src="http://images.hezongyy.com/images/jf/phone_icon.png?1"/>
                                        <span>{{$v->tel}}</span>
                                    </div>
                                    <div class="user_add">
                                        <img src="http://images.hezongyy.com/images/jf/add_icon.png?1"/>
                                        <span>{{get_region_name([$v->province,$v->city,$v->district])}}{{$v->address}}</span>
                                    </div>
                                    <img src="http://images.hezongyy.com/images/jf/add_choose.png?1" class="add_choose"/>
                                    <div class="moren">
                                        默认地址
                                    </div>
                                    {{--<div class="set">--}}
                                    {{--<span class="shezhi" onclick="set_default({{$v->id}})">--}}
                                    {{--设为默认--}}
                                    {{--</span>--}}
                                    {{--<span class="xiugai"--}}
                                    {{--onclick="load_html('{{route('jifen.address.edit',['id'=>$v->id])}}','修改收货地址')">--}}
                                    {{--修改--}}
                                    {{--</span>--}}
                                    {{--@if($v->is_default==0)--}}
                                    {{--<span class="xiugai" onclick="del('确定删除该收货地址?','{{$v->id}}')">--}}
                                    {{--删除--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                    {{--</div>--}}
                                </li>
                            @endforeach
                            {{--@if(count($result)<5)--}}
                            {{--<li class="zengjia" onclick="load_html('{{route('jifen.address.create')}}','新增收货地址')">--}}
                            {{--<div class="add_add">--}}
                            {{--<img src="{{get_img_path('images/jf/add_add.jpg')}}"/>--}}
                            {{--<span>新增收货地址</span>--}}
                            {{--</div>--}}
                            {{--</li>--}}
                            {{--@endif--}}
                        </ul>
                    </div>
                @else
                    <div class="dd_none">
                        <img src="{{get_img_path('images/user/search_none.jpg')}}"/>
                        <p>您还没有收货地址</p>
                        <a target="_blank" href="{{route('member.address.index')}}" style="width: 100px;">添加收货地址</a>
                    </div>
                @endif
            </div>
            @include('jifen.layouts.wntj')
        </div>
    </div>
</div>
<!--container-->
@include('jifen.layouts.footer')
<script type="text/javascript">
    $(function() {
        $('.xiugai').on('click', function() {
            //获取修改地址的资料

            $('.add_address_title').html("修改收货地址")
            $('.add_address').show();
        })
        $('.zengjia').on('click', function() {
            $('.add_address_title').html("新增收货地址")
            $('.add_address').show();
        })
        $('.bc,.qx').click(close)

        function close() {
            return $('.add_address').hide();
        }
    })

    function del(msg, id) {
        layer.confirm(msg, function() {
            $.ajax({
                url: '/jifen/address/' + id,
                type: 'delete',
                dataType: 'json',
                success: function(data) {
                    layer.msg(data.msg, {
                        icon: data.error + 1
                    });
                    if(data.error == 0) {
                        $('#address' + id).remove();
                    }
                }
            })
        })
    }

    function load_html(url, title) {
        layer.open({
            type: 2,
            title: title,
            shadeClose: true,
            shade: 0.4,
            area: ['800px', '500px'],
            content: url
        });
    }

    function set_default(id) {
        $.ajax({
            url: '/jifen/address/set_default',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                if(data.error == 0) {
                    $('#address' + data.id).addClass('active').siblings().removeClass('active');
                } else {
                    layer.msg(data.msg, {
                        icon: data.error + 1
                    })
                }
            }
        })
    }
</script>
</body>

</html>