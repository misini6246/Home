@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/balance2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>

@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的太星医药网</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.account')}}" class="end">>　<span>{{$pages_top}}</span></a> </div>
        @include('layout.user_menu')
        <div class="main_right1">
            <div class="top_title">
                <h3>{{$pages_top}}</h3>
                <span class="ico" style="left:40px;"></span>
            </div>
            <table class="table2">
                <tr>
                    <th class="case1">操作时间</th>
                    <th>类型</th>
                    <th>金额</th>
                    <th>操作备注</th>

                </tr>
                @foreach($pages as $v)
                <tr>
                    <td class="tb2_td1">{{date('Y-m-d',$v->change_time)}}</td>
                    <td class="tb2_td2">@if($v->change_amount>0)增加@else减少@endif</td>
                    <td class="tb2_td3">{{formated_price(abs($v->change_amount))}}</td>
                    <td class="tb2_td4" title="{$item.change_desc}">{{$v->change_desc}}</td>
                </tr>
                @endforeach
                {!! $pages_text !!}
            </table>
            @if($pages->lastPage()>0)
                {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,['url'=>$pages_url]) !!}
            @endif
            <div id="Searchresult"> <!--分页初始化完成后这里的内容会被替换。--></div>
            <div id="Pagination" class="pagination"><!-- 这里显示分页 --></div>
            <div id="hiddenresult" style="display:none;">
                <!-- 列表元素 -->
            </div>

        </div>
    </div>
    @include('layout.page_footer')
@endsection
