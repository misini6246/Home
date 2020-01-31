@extends('jf.layouts.body')
@section('links')
    <link href="{{path('css/jf/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/jf/gwc_2.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('jf.layouts.header')
    @include('jf.layouts.nav')
    <!--container-->
    <div class="container content">
        <div class="content_box">
            <div class="top_title">
                <img src="{{get_img_path('images/jf/address_03.png')}}"/>
                <span>当前位置：<a href="{{route('jf.index')}}">积分首页</a> > 确认订单信息</span>
            </div>
            <form action="{{route('jf.order.store')}}" method="post">
                {!! csrf_field() !!}
                <div class="jiesuan_box">
                    <div class="img_title">
                        <img src="{{get_img_path('images/jf/gwc_2.jpg')}}"/>
                    </div>
                    <div class="shdz">
                        <div class="shdz_title">
                            收货地址
                        </div>
                        <ul class="add_list" id="address_list">
                            @include('jf.layouts.address')
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
                            @foreach($address as $v)
                                @if($v->is_default==1)
                                    <img src="{{get_img_path('images/jf/add_icon.png')}}"/>
                                    <span>{{$v->location}}{{$v->address}}</span>
                                @endif
                            @endforeach
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
    @include('jf.layouts.footer')
    <script>
        function load_html() {
            layer.open({
                type: 2,
                title: '新增收货地址',
                shadeClose: true,
                shade: 0.4,
                area: ['800px', '500px'],
                content: '{{route('jf.address.create')}}'
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
                        $('#default_address').html(data.default_address);
                    } else {
                        layer.msg(data.msg, {icon: data.error + 1})
                    }
                }
            })
        }
    </script>
@endsection
