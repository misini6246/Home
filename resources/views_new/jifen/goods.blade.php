@extends('jifen.layouts.body')
@section('links')
    <link href="{{path('css/jifen/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/jifen/xiangqing.css')}}1" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/jifen/AAS.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('js/jifen/add_to_cart.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('jifen.layouts.header')
    @include('jifen.layouts.nav')
    <!--container-->
    <div class="container content">
        <div class="content_box">
            <div class="top_title">
                <img src="{{get_img_path('images/jf/address_03.png')}}"/>
                <span>当前位置：<a href="{{route('jifen.index')}}">积分首页</a> > {{$info->name}}</span>
            </div>
            <div class="detail">
                <div class="img_box">
                    @foreach($info->goodsImg as $k=>$v)
                        @if($k==0)
                            <img style="width: 398px;height: 398px;"
                                 src="http://jf.jyeyw.com/{{substr($v->small_img,1)}}"/>
                        @endif
                    @endforeach

                </div>
                <ul class="img_list">
                    @foreach($info->goodsImg as $k=>$v)
                        <li @if($k==0)class="active"@endif>
                            <img src="http://jf.jyeyw.com/{{substr($v->small_img,1)}}"/>
                        </li>
                    @endforeach
                </ul>
                <div class="text">
                    <p class="name">{{str_limit($info->name,44)}}</p>
                    <p class="jifen">
                        <span class="txt">所需积分：</span><span class="jf">{{$info->jf}}</span><span class="scj">市场价：</span><span
                                class="money">{{formated_price($info->market_price)}}</span>
                    </p>
                    <p class="kucun">
                        库存： <span>{{$info->goods_stock}}</span>
                    </p>
                    <p class="sl">
                        <span>数量：</span>
                        <span class="jian">
								<img src="{{get_img_path('images/jf/jian_03.png')}}"/>
							</span>
                        <input type="text" id="num_btn" value="1"/>
                        <span class="jia">
								<img src="{{get_img_path('images/jf/jia_03.png')}}"/>
							</span>
                    </p>
                    <div class="btn">
                        <div class="dh" onclick="ljdh('{{$info->id}}',$('#num_btn').val())">立即兑换</div>
                        <div class="jr" onclick="add_to_cart('{{$info->id}}',$('#num_btn').val())">
                            <img src="{{get_img_path('images/jf/jr_btn.jpg')}}"/>加入礼品车
                        </div>
                    </div>
                    <form action="{{route('jifen.cart.jiesuan')}}" method="post" id="ljdh_form">
                        {!! csrf_field() !!}
                        <input id="cart_id" type="hidden" name="ids[]" value="0">
                    </form>
                </div>
            </div>
            <div class="xiangqing">
                <div class="xiangqing_title">
                    <img src="{{get_img_path('images/jf/dian_03.png')}}"/>
                    <span>礼品详情</span>
                </div>
                {!! $info->introduction !!}
                {{--<p>上架时间：{{date('Y-m-d H:i:s',$info->add_time)}}</p>--}}
            </div>
        @include('jifen.layouts.hot')
        <!--热门兑换-->
        </div>
    </div>
    <!--container-->
    @include('jifen.layouts.footer')
    <script>
        $('.img_list li').click(function () {
            var src = $(this).find('img').attr('src');
            $(this).addClass('active').siblings('li').removeClass('active');
            $('.detail .img_box img').attr('src', src);
        });
        var max = parseInt({{$info->goods_stock}});
        $('.sl').Aas({
            jia: '.jia',
            jian: '.jian',
            val: '#num_btn',
            max: max,  //最大值
            callback: function () {
//			 没有则不写
            }
        })
        function ljdh(id, num) {
            $.ajax({
                url: '/jifen/cart',
                data: {id: id, gd_num: num},
                dataType: 'json',
                success: function (result) {
                    if (result.error == 0) {
                        $('#cart_id').val(result.id);
                        $('#ljdh_form').submit();
                    } else {
                        layer.msg(result.msg, {icon: result.error + 1});
                    }
                }
            });
        }
    </script>
@endsection
