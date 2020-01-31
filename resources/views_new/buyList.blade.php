@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/my_buy2.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/my_buy.js')}}"></script>
    <style type="text/css">

        .listPageDiv {
            height: 50px;
            line-height: 50px;
            text-align: right;
            margin-top: 10px;
            float: right;
            width: 82%;
            color: #333333;
            font-family: "Microsoft YaHei"
        }

        .pageList {
            width: 600px;
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
        <div class="top"><span class="title">我的药易购</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.buyList')}}" class="end">>　<span>我的求购</span></a> </div>
        @include('layout.user_menu')
        <div class="main_right1">
            <div class="top_title">
                <h3>我的求购</h3>
                <span class="ico"></span>
                <p class="right_box"><a href="{{route('user.buyNew')}}" style="color: #39a817">增加求购</a> </p>
            </div>
            <table>
                <tr>
                    <th class="case1">求购产品</th>
                    <th>规格</th>
                    <th>求购数量</th>
                    <th>求购价格</th>
                    <th>求购有效期</th>
                    <th> 回复 </th>
                    <th> 操作 </th>
                </tr>

                @if(count($pages)>0)
                @foreach($pages as $v)
                <tr>
                    <td class="case1 tb1_td1" >{{$v->buy_goods}}</td>
                    <td   class="tb1_td2">{{$v->buy_spec}}</td>
                    <td  class="tb1_td3">{{$v->buy_number}}</td>
                    <td  class="tb1_td4">{{formated_price($v->buy_price)}}</td>
                    <td  class="tb1_td5">{{$v->buy_time}}</td>
                    <td  class="tb1_td6">@if($v->buy_through==1){{$v->replay}}@endif</td>
                    <td class="tb1_td7" >@if($v->buy_through==0)<a href="{{route('user.buyUpdate',['id'=>$v->buy_id])}}">修改</a>@endif</td>
                </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="7">暂无任何信息！</td>
                    </tr>
                @endif
            </table>
            @if($pages->lastPage()>0)
                {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,['url'=>'user.buyList']) !!}
            @endif
        </div>
    </div>
    @include('common.footer')
@endsection
