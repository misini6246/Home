@if($full_page==1)
@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <style type="text/css">

        /* 会员中心站内信样式开始 */
        .ico3{width: 24px;height: 22px;position: absolute;left: 0;top: 4px;background: url(http://images.hezongyy.com/images/msg-02.png) no-repeat;}
        .zhanneixx-box{width: 986px;float: right;}
        .t-title{border-bottom:1px solid #c7c7c7;height: 40px; margin-top: 10px;}
        .t-title .weidu{width: 160px;float: left;padding-left: 15px;}
        .t-title  .r-xinxi{width: 220px;float: right;text-align: right;}
        .t-title  .r-xinxi span{cursor: pointer;}
        .l-xinxi{width: 180px;float: left;text-align: left;padding-left: 15px;}
        .l-xinxi span{cursor: pointer;}
        .youjian{border: 0;border-bottom: 1px solid #c7c7c7;width: 100%;text-align: center;color: #666666;}
        .youjian tr td{border: 0;line-height: 24px;}
        .youjian tr .td1{width: 40px;}
        .youjian tr .td2{width: 60px;}
        .youjian tr .td3{width: 770px;}
        .youjian tr .td4{width: 110px;}
        .pageList{width: 590px;}
        input[type="checkbox"]{width: 15px;height: 15px;}

        /* 会员中心站内信样式开始 */

    </style>
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="main fn_clear">

        <div class="top"><span class="title">我的太星医药网</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.messageList')}}" class="end">>　<span>系统消息</span></a> </div>

        @include('layout.user_menu')

        <div class="main_right1">
            <div class="top_title">
                <h3>系统消息</h3>
                <span class="ico"></span>
            </div>


            <div class="zhanneixx-box">
                <div class="t-title fn_clear">
                    <div class="weidu">
                        <input style="margin-top: -3px;" type="checkbox" class="xwd" name="item"> 全选

                    </div>
                    <div class="r-xinxi">
                        <input style="margin-top: -3px;" type="checkbox" onchange="wd_znx($(this))" @if($is_wd==1)checked="checked"@endif/><label > 只显示未读消息</label> | <span id="yd" onclick="yd()">标记为已读 | </span> <span id="sc">删除</span>

                    </div>


                </div>
@endif
                @if(count($pages)>0)
                    @foreach($pages as $v)
                        <table class="youjian">
                            <tr class="tr1">
                                <td class="td1"></td>
                                <td class="td2"></td>
                                <td class="td3" style="text-align:left;font-weight:bold;color:#333;font-size:14px;">{{$v->znx_name}}</td>
                                <td class="td4">{{date('Y-m-d H:i',$v->add_time)}}</td>
                            </tr>
                            <tr>
                                <td class="td1"><input type="checkbox" name="item" class="znx_id" znx_id="{{$v->znx_id}}"/><label></label></td>
                                <td class="td2" style="cursor: pointer;">
                                    <a href="{{route('user.znx_info',['id'=>$v->znx_id])}}">
                                    @if($v->is_read==1)
                                    <span class="xyd" ><img src="{{get_img_path('images/msg-03.png')}}" alt="" style="margin-top:10px;"></span>
                                    @else
                                    <span class="xwd" ><img src="{{get_img_path('images/msg-01.jpg')}}" alt="" style="margin-top:10px;"></span>
                                    @endif
                                    </a>
                                </td>
                                <td colspan="2" style="text-align:left;">
                                    <span>{{str_limit($v->info,255)}}</span>
                                    <a href="{{route('user.znx_info',['id'=>$v->znx_id])}}" style="color:#06f;">点击查看全文>></a>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4" style="text-align:right;">发件人：系统管理员</td>
                            </tr>
                        </table>
                    @endforeach
                @else
                    <table class="youjian">
                        <tr>
                            <td colspan="7">暂无任何信息！</td>
                        </tr>
                    </table>
                @endif


                @if($pages->lastPage()>0)
                    {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,[
                    'url'=>'user.znx_list',
                    'is_wd'=>$is_wd,
                    ]) !!}
                @endif






@if($full_page==1)
            </div>

        <input type="hidden" name="is_wd" value="{{$is_wd}}"/>
        </div>
    </div>
    <script type="text/javascript">
        window.onload = function ()
        {
            var oA = document.getElementsByName("fanxuan");
            // var checkall = document.getElementById("checkall");
            var oInput=document.getElementsByName("item")
            // alert(oInput.length);
            var oLabel = document.getElementsByTagName("label")[0];
            var isCheckAll = function ()
            {
                for (var i = 1, n = 0; i < oInput.length; i++)
                {
                    oInput[i].checked && n++
                }
                oInput[0].checked = n == oInput.length - 1;
                //oLabel.innerHTML = oInput[0].checked ? "全不选" : "全选"
            };
            //全选/全不选
            oInput[0].onclick = function ()
            {


                for (var i = 1; i < oInput.length; i++)
                {
                    oInput[i].checked = this.checked
                }
                isCheckAll()
            };





            //反选
            oA.onclick = function ()
            {
                for (var i = 1; i < oInput.length; i++)
                {
                    oInput[i].checked = !oInput[i].checked
                }
                isCheckAll()
            };
            //根据复选个数更新全选框状态
            for (var i = 1; i < oInput.length; i++)
            {
                oInput[i].onclick = function ()
                {
                    isCheckAll()
                }
            }

        }
        function wd_znx(_obj){
            var type = _obj.attr('checked');
            var url = "/user/znx_list";
            var is_wd = 0;
            if(type=='checked'){
                is_wd = 1;
            }
            $.ajax({
                url:url,
                data:{is_wd:is_wd},
                type:'get',
                dataType:'html',
                success: function (data) {
                    if(data){
                        $('.youjian').remove();
                        $('.listPageDiv').remove();
                        $('.zhanneixx-box').append(data);
                    }
                }
            })
        }
        function yd(){
            var str = '';
            $('.znx_id').each(function(){
                var type = $(this).attr('checked');
                if(type=='checked'){
                    var znx_id = parseInt($(this).attr('znx_id'));
                    str += znx_id+',';
                }
            });
            if(str==''){
                alert('未选中任何信息');
            }else{
                location.href = '/user/yd_znx?str='+str;
            }
        }
    </script>
    @include('layout.page_footer')
@endsection
@endif
