@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/my_buy2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/my_buy.js')}}"></script>

@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的太星医药网</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.buyList')}}" class="end">>　<span>我的求购</span></a> </div>
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
                    <td  class="tb1_td6">@if($v->buy_through==1){{$v->buy_replay}}}@endif</td>
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
    @include('layout.page_footer')
@endsection
