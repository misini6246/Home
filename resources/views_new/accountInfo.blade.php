@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/balance2.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
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
        <div class="top"><span class="title">我的药易购</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.account')}}" class="end">>　<span>余额管理</span></a> </div>
        @include('layout.user_menu')
        <div class="main_right1">
            <div class="top_title">
                <h3>余额管理</h3>
                <span class="ico"></span>
                {{--<p class="right_box"><a style="color: #39a817" href="{{route('user.accountInfo')}}">查看账户明细</a></p>--}}
            </div>
            <table class="table2">
                <tr>
                    <th class="case1">操作时间</th>
                    <th>类型</th>
                    <th>余额</th>
                    <th>备注</th>

                </tr>
                @foreach($pages as $v)
                <tr>
                    <td class="tb2_td1">{{date('Y-m-d',$v->change_time)}}</td>
                    <td class="tb2_td2">@if($v->user_money>0)增加@else减少@endif</td>
                    <td class="tb2_td3">{{formated_price(abs($v->user_money))}}</td>
                    <td class="tb2_td4" title="{$item.change_desc}">{!! $v->change_desc !!}</td>
                </tr>
                @endforeach
                <tr><td colspan="4" class="al_right"><p class="balance" style="font-size: 16px;">您当前的可用资金为:{{formated_price($user->user_money)}}</p></td></tr>
            </table>
            @if($pages->lastPage()>0)
                {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,['url'=>'user.accountInfo']) !!}
            @endif
            <div id="Searchresult"> <!--分页初始化完成后这里的内容会被替换。--></div>
            <div id="Pagination" class="pagination"><!-- 这里显示分页 --></div>
            <div id="hiddenresult" style="display:none;">
                <!-- 列表元素 -->
            </div>

        </div>
    </div>
    @include('common.footer')
@endsection
