@extends('jf.layouts.body')
@section('links')
    <link href="{{path('css/jf/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/jf/shouhuodizhi.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/jf/lb.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('jf.layouts.header')
    @include('jf.layouts.nav')
    <!--container-->
    <div class="container content">
        <div class="content_box">
            <div class="top_title">
                <img src="{{get_img_path('images/jf/address_03.png')}}"/>
                <span>当前位置：<a href="{{route('index')}}">积分首页</a> > <a href="{{route('jf.index')}}">个人中心</a>> 收货地址</span>
            </div>
            <div class="vip">
                @include('jf.layouts.user_menu')
                <div class="vip_right">
                    <div class="vip_right_title">
                        <img src="{{get_img_path('images/jf/dian_03.png')}}"/>
                        <span>收货地址</span>
                    </div>
                    <div class="add_box">
                        <ul class="add_list">
                            @foreach($result as $v)
                                <li @if($v->is_default==1)class="active" @endif id="address{{$v->id}}">
                                    <div class="username">
                                        <img src="{{get_img_path('images/jf/user_icon.png')}}"/>
                                        <span>{{$v->true_name}}</span>
                                    </div>
                                    <div class="user_phone">
                                        <img src="{{get_img_path('images/jf/phone_icon.png')}}"/>
                                        <span>{{$v->mob_phone}}</span>
                                    </div>
                                    <div class="user_add">
                                        <img src="{{get_img_path('images/jf/add_icon.png')}}"/>
                                        <span>{{$v->location}}{{$v->address}}</span>
                                    </div>
                                    <img src="{{get_img_path('images/jf/add_choose.png')}}" class="add_choose"/>
                                    <div class="moren">
                                        默认地址
                                    </div>
                                    <div class="set">
										<span class="shezhi" onclick="set_default({{$v->id}})">
											设为默认
										</span>
                                        <span class="xiugai"
                                              onclick="load_html('{{route('jf.address.edit',['id'=>$v->id])}}','修改收货地址')">
											修改
										</span>
                                        @if($v->is_default==0)
                                            <span class="xiugai" onclick="del('确定删除该收货地址?','{{$v->id}}')">
											删除
										    </span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                            @if(count($result)<5)
                                <li class="zengjia" onclick="load_html('{{route('jf.address.create')}}','新增收货地址')">
                                    <div class="add_add">
                                        <img src="{{get_img_path('images/jf/add_add.jpg')}}"/>
                                        <span>新增收货地址</span>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                @include('jf.layouts.wntj')
            </div>
        </div>
    </div>
    <!--container-->
    @include('jf.layouts.footer')
    <script type="text/javascript">
        $(function () {
            $('.xiugai').on('click', function () {
                //获取修改地址的资料

                $('.add_address_title').html("修改收货地址")
                $('.add_address').show();
            })
            $('.zengjia').on('click', function () {
                $('.add_address_title').html("新增收货地址")
                $('.add_address').show();
            })
            $('.bc,.qx').click(close)
            function close() {
                return $('.add_address').hide();
            }
        })
        function del(msg, id) {
            layer.confirm(msg, function () {
                $.ajax({
                    url: '/jf/address/' + id,
                    type: 'delete',
                    dataType: 'json',
                    success: function (data) {
                        layer.msg(data.msg, {icon: data.error + 1});
                        if (data.error == 0) {
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
                url: '/jf/address/set_default',
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    if (data.error == 0) {
                        $('#address' + data.id).addClass('active').siblings().removeClass('active');
                    } else {
                        layer.msg(data.msg, {icon: data.error + 1})
                    }
                }
            })
        }
    </script>
@endsection
