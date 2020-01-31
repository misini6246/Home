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
        <div class="top"><span class="title">我的太星医药网</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.account')}}" class="end">>　<span>余额管理</span></a> </div>
        @include('layout.user_menu')
        <div class="main_right1">
            <div class="top_title">
                <h3>余额管理</h3>
                <span class="ico"></span>
                <p class="right_box"><a style="color: #39a817" href="{{route('user.accountInfo')}}">查看账户明细</a></p>
            </div>
            <table class="table1">
                <tr>
                    <th class="tb1_td1">操作时间</th>
                    <th class="tb1_td2">类型</th>
                    <th class="tb1_td3">金额</th>
                    <th class="tb1_td4">会员备注</th>
                    <th class="tb1_td5">管理员备注</th>
                    <th class="tb1_td6">状态</th>
                    <th class="tb1_td7">操作</th>
                </tr>
                @foreach($pages as $v)
                <tr>
                    <td class="tb1_td1">{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                    <td class="tb1_td2">@if($v->process_type==0)充值@else提现@endif</td>
                    <td class="tb1_td3">{{formated_price($v->amount)}}</td>
                    <td class="tb1_td4">{{str_limit($v->user_note,25)}}</td>
                    <td class="tb1_td5">{{str_limit($v->admin_note,25)}}</td>
                    <td class="tb1_td6">@if($v->is_paid==0)未处理@else已处理@endif</td>
                    <td class="tb1_td7">
                        @if($v->is_paid==0&&$v->process_type==1)
                        <a href="" onclick="if (!confirm('确定删除该提现申请吗')) return false;">删除</a>
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr><td colspan="7" class="al_right"><p class="balance">您当前的可用资金为:{{formated_price($user->user_money)}}</p></td></tr>
            </table>
            @if($pages->lastPage()>0)
                {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,['url'=>'user.account']) !!}
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
