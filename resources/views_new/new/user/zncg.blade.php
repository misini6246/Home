@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>智能采购</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuancommon.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuanzhongxin.css" />
    <link rel="stylesheet" type="text/css" href="/user/wodeshoucang.css"/>
    <!--layer-->
    <link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/new_gwc/gwc-js/tanchuc.js" type="text/javascript" charset="utf-8"></script>
    <script src="/new_gwc/gwc-js/transport_jquery.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/common_hyzx.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/huiyuancommon.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/placeholderfriend.js" type="text/javascript" charset="utf-8"></script>
    <!--layer-->
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
    <script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script>

    <script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script>
    <!--轮播-->
    <!--<script src="common/js/lb.js" type="text/javascript" charset="utf-8"></script>-->
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    @include('layouts.youce')

    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="/user/img/详情页_01.png"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="/user/img/right_03.png"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的今瑜e药网</a><img
                        src="/new_gwc/jiesuan_img/椭圆.png" class="right_icon"/><span>智能采购</span>
            </div>
            @include('user.left')
            <div class="right" id="sc1">
                <form id="search_form" name="search_form" action="{{route('member.zncg')}}">
                </form>
                <div class="right_title">
                    <img src="/new_gwc/jiesuan_img/椭圆.png"/>
                    <span>智能采购</span>
                </div>
                @if(count($result)>0)
                    <form id="pl_buy" action="{{route('user.plBuy')}}" method="get">
                        <table>
                            <tr>
                                <th class="input">
                                    <input type="checkbox" class="quanxuan" onclick="quanxuan($(this),$('.danxuan'))"/>
                                </th>
                                <th class="spmc">
                                    <label for="qx_1">全选</label>
                                    <span>商品名称</span>
                                </th>
                                <th class="sccj">生产厂家</th>
                                <th class="bzdw">包装单位</th>
                                <th class="gg">规格</th>
                                <th class="jg">价格</th>
                                @if($sort=='desc')
                                    <th class="cgcs"><a href="{{route('member.zncg',['sort'=>'asc'])}}"
                                                        style="display: inline-block;color: #333">采购次数
                                            <img src="/new_gwc/img/xia.png"/>
                                        </a>
                                    </th>
                                @else
                                    <th class="cgcs"><a href="{{route('member.zncg',['sort'=>'desc'])}}"
                                                        style="display: inline-block;color: #333">采购次数
                                            <img src="/new_gwc/img/shang.png"/>
                                        </a>
                                    </th>
                                @endif
                                <th class="cz">操作</th>
                            </tr>
                            @foreach($result as $v)
                                <tr>
                                    <td><input name="ids[]" value="{{$v->goods_id}}" class="danxuan" type="checkbox"
                                               onclick="danxuan($('.danxuan'),$('.quanxuan'))"/></td>
                                    <td class="spmc">
                                        <a target="_blank" href="{{$v->goods_url}}">
                                            <img class="fly_img{{$v->goods_id}}" src="{{$v->goods_thumb}}"/>
                                            <span title="{{$v->goods_name}}">{{str_limit($v->goods_name,24)}}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="sccj" title="{{$v->sccj}}">{{str_limit($v->sccj,28)}}</div>
                                    </td>
                                    <td class="bzdw">
                                        {{$v->dw}}
                                    </td>
                                    <td>
                                        <div class="gg" title="{{$v->ypgg}}">{{str_limit($v->ypgg,20)}}</div>
                                    </td>
                                    <td class="jg">{{formated_price($v->real_price)}}</td>
                                    <td class="cgcs">{{$v->num}}次</td>
                                    <td class="cz">
                                        <input type="hidden" value="{{$v->zbz or 1}}"
                                               id="J_dgoods_num_{{$v->goods_id}}">
                                        <img src="/new_gwc/img/加入购物车.png"
                                             class="jrgwc fly_to_cart{{$v->goods_id}}"
                                             data-img="{{$v->goods_thumb}}"
                                             onclick="tocart({{$v->goods_id}})">
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </form>
                    <div class="right_bottom">
                        <input type="checkbox" class="quanxuan" onclick="quanxuan($(this),$('.danxuan'))"/><label
                                for="qx_2">全选</label>
                        <span class="jrgwc" onclick="pljr()">加入购物车</span>
                    </div>
                    @include('user.pages',['pages'=>$result])
                @else
                    @include('user.empty',['type'=>2])
                @endif
            </div>
            <div style="clear: both"></div>
            @include('layouts.new_footer')
        </div>

    </div>
    <script type="text/javascript">
        $(function () {
            $('#num').focus(function () {
                $('.placeholder').hide();
            });
            $('#num').blur(function () {
                if ($(this).val() != "") {
                    $('.placeholder').hide();
                } else {
                    $('.placeholder').show();
                }
            });
        });

        function pljr() {
            var len = $('.danxuan:checked').length;
            if (len == 0) {
                layer.msg('请至少选中一个商品', {icon: 0})
                return false;
            }
            $('#pl_buy').submit();
        }
        //返回顶部
        $('.btn-top').click(function() {
            $('html,body').animate({
                'scrollTop': 0
            })
        });
    </script>
    {{--@include('layouts.new_footer')--}}
@endsection
