@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/my_msg2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/my_order.js')}}"></script>
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="main fn_clear">

        <div class="top"><span class="title">我的太星医药网</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.messageList')}}" class="end">>　<span>订单留言</span></a> </div>

        @include('layout.user_menu')

        <div class="main_right1">
            <div class="top_title">
                <h3>用户信息</h3>
                <span class="ico"></span>
            </div>
            <!-- *我的留言板 start-->
            @if(count($pages)>0)
            <div class="content_box">
                <h4>我的留言板</h4>
                <div class="content">
                    <table style="width:800px;">
                        @foreach($pages as $v)
                        <tr>
                            <td align="left" width="30">{{$v->user_name}}:</td>
                            <td align="left">{{$v->msg_title}} ({{date('Y-m-d H:i:s',$v->msg_time)}})</td>
                            <td align="right" width="120"><a href="{{route('user.msgDelete',['id'=>$v->msg_id])}}" title="删除" onclick="if (!confirm('你确实要彻底删除这条留言吗?')) return false;">删除</a></td>
                        </tr>
                        @if(!empty($v->msg_content))
                        <tr>
                            <td colspan="3">{{$v->msg_content}}</td>
                        </tr>
                        @endif
                        @if(!empty($v->message_img))
                        <tr>
                            <td colspan="3" align="right"><a href="{{path('uploads/feedback')}}/{{$v->message_img}}" target="_bank">查看上传的文件</a></td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td colspan="3" align="right">
                                @include('layout.pagesUser')
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
            <!--#我的留言板 end-->
            <form action="{{route('user.msgCreate')}}" enctype="multipart/form-data" name="formMsg" class="content_box" method="post" >
                {!! csrf_field() !!}
                <h4>我的留言</h4>
                @if(count($pages)>0)
                    <div class="content_box">
                        <h4>我的留言板</h4>
                        <div class="content">
                            <table style="width:800px;">
                                @foreach($pages as $v)
                                    @if(!empty($v->msg_content))
                                        <tr>
                                            <td colspan="3">{{$v->msg_content}}</td>
                                        </tr>
                                    @endif
                                    @if(!empty($v->message_img))
                                        <tr>
                                            <td colspan="3" align="right"><a href="{{path('uploads/feedback')}}/{{$v->message_img}}" target="_bank">查看上传的文件</a></td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td colspan="3" align="right">
                                        @include('layout.pagesUser')
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endif
                <div class="content">
                    <table>
                        <tbody><tr class="">
                            <td class="title">订单号:</td>
                            <td>
                                <label><a href="{{route('user.orderInfo',['id'=>$orderId])}}"><img src="{{path('images/note.gif')}}">2015120464992</a></label>
                                <label><input name="msg_type" value="5" type="hidden"></label>
                                <label><input name="order_id" value="{{$orderId}}" type="hidden"></label>
                            </td>
                        </tr>
                        <tr class="">
                            <td class="title"><span>主题：</span></td>
                            <td><input name="msg_title" class="text" id="text" type="text"></td>
                        </tr>
                        <tr class="">
                            <td class="title"><span class="msg_title">留言内容：</span></td>
                            <td><textarea name="msg_content" id="msg"></textarea></td>
                        </tr>
                        <tr class="">

                            <td class="title"><span>上传文件：</span></td>
                            <td><p class="file_box"><input name="message_img" class="file" type="file"></p></td>
                        </tr>
                        <tr class="">
                            <td colspan="2"><input value="提　交" class="submit" type="submit"></td>
                            <input name="act" value="act_add_message" type="hidden">
                        </tr>
                        <tr class="">
                            <td colspan="2" class="tip_box">
                                <p><font color="red">小提示：</font></p>
                                <p>您可以上传以下格式的文件：<br>gif、jpg、png、word、excel、txt、zip、ppt、pdf</p>
                            </td>
                        </tr>
                        </tbody></table>
                </div>
            </form>
        </div>
    </div>
    @include('layout.page_footer')
@endsection
