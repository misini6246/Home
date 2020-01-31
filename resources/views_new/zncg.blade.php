@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/purchase2.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/purchase.js')}}"></script>
    <style type="text/css">

        .listPageDiv {
            height: 50px;
            line-height: 50px;
            text-align: right;
            margin-top: 10px;
            float: right;
            width: 79%;
            color: #333333;
            font-family: "Microsoft YaHei"
        }

        .pageList {
            width: 580px;
            float: left;
        }

        .listPageDiv .p1 {
            border: 1px #CCC solid;
            padding: 4px 9px;
            margin: 3px;
            background-color: #efefef;
        }

        .listPageDiv .p_ok {
            color: #39a817;
            border: 0;
            background-color: #fff;
        }

        .listPageDiv a {
            color: #666;
        }

        .listPageDiv a:hover {
            text-decoration: underline;
            color: #39a817;
        }

        .listPageDiv .no {
            background-color: #fff;
        }

        .listPageDiv .no a {
            color: #cccccc;
        }

        .listPageDiv .page_inout {
            width: 24px;
            height: 24px;
            border: 1px solid #ccc;
            margin: 0 5px;
            line-height: 24px;
            text-align: center;
        }

        .listPageDiv .submit {
            cursor: pointer;
            width: 45px;
            height: 24px;
            line-height: 20px;
            background-color: #efefef;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .listPageDiv .submit_input {
            padding-left: 10px;
            width: 180px;
            float: right;
            _margin-top: 10px;
        }
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="main fn_clear">

        <div class="top"><span class="title">我的药易购</span> <a>>　<span>交易管理</span> </a> <a href="{{route('user.zncg')}}" class="end">>　<span>智能采购</span></a> </div>
        @include('layout.user_menu')
        <div class="main_right1">
            <div class="top_title">
                <h3>智能采购</h3>
                <span class="ico"></span>
            </div>
            <div class="content_box">
                <form action="{{route('user.plBuy')}}" method="get">
                <table class="gwc_tb2">
                    <tr>
                        <th><input type="checkbox" id="Checkbox1" class="allselect"/> 全选 </th>
                        <th>商品</th>
                        <th>生产厂家</th>
                        <th>包装单位</th>
                        <th>规格</th>
                        <th>当前价格</th>
                        <th>采购次数</th>
                        <th>操作</th>
                    </tr>
                    @if(count($pages)>0)
                    @foreach($pages->goods as $v)
                    <tr id="{{$v->goods_id}}" data-id="{{$v->goods_id}}">
                        <td class="tb2_td1"><input type="checkbox" value="{{$v->goods_id}}" name="ids[]" dd-id="newslist"/></td>
                        <td class="tb2_td2"><a href="{{$v->goods_url}}"><img class="fly_img{{$v->goods_id}}" src="{{$v->goods_thumb}}" alt="{{$v->goods_name}}" title="{{$v->goods_name}}"/></a> <p class="name" alt="{{$v->goods_name}}" title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</p></td>
                        @if($v->sccj)<td class="tb2_td3" alt="{{$v->sccj}}" title="{{$v->sccj}}">{{str_limit($v->sccj,12)}}</td>@endif
                        @if($v->dw)<td class="tb2_td4" alt="{{$v->dw}}" title="{{$v->dw}}">{{str_limit($v->dw,12)}}</td>@endif
                        @if($v->spgg)<td class="tb2_td5" alt="{{$v->spgg}}" title="{{$v->spgg}}">{{str_limit($v->spgg,12)}}</td>@endif
                        <td class="tb2_td6">
                           {{formated_price($v->real_price)}}
                        </td>
                        <td class="tb2_td7">{{$v->goods_number}}</td>
                        <td class="tb2_td8">
                            <a class="fly_to_cart{{$v->goods_id}}" href="javascript:@if($v->is_can_buy==1) addToCart1({{$v->goods_id}},1) @else addToCart2({{$v->goods_id}}) @endif">加入购物车</a>  <!-- 2015-6-26 -->
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">暂无商品！</td>
                    </tr>
                    @endif
                </table>

                <div class="control">
                    <div class="con_left">
                        <input type="checkbox" id="Checkbox2" class="allselect"/> 全选
                        <input type="submit" id='submit' value="加入购物车" class="submit"/>
                    </div>
                </div>
                </form>

                @if($pages->lastPage()>0)
                    {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,[
                    'url'=>'user.zncg',
                    ]) !!}
                @endif

            </div>
        </div>

    </div>
    @include('common.footer')
@endsection
